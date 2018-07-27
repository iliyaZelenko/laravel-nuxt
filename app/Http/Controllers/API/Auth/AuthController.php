<?php
namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Carbon\Carbon;
use App\User;
use App\SocialiteProvider;
use App\Email;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\PassportToken;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Resources\UserResource;
use App\Traits\Socialite;
use App\Traits\EmailVerification;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    use PassportToken, ThrottlesLogins, Socialite, EmailVerification; //
    /**
     * Регистрация
     */
    public function signup(SignupRequest $request)
    {
        $country = null;
        if ($countryCookie = $request->cookie('guest-country')) {
            $country = \Countries::where('cca2', $countryCookie)->first();
            if ($country) {
                $country = $country->cca3;
            }
        }

        // $country = 'UKR';
        $timezoneCookie = $request->cookie('guest-timezone'); // 'Europe/Kiev';

        $userSoc = $request->userSoc;
        $socAcc = SocialiteProvider::where('name', $request->providerName)->first();
        $user = User::create([ // new не проходит, дальше требуется id
            'nickname' => $request->form['nickname'],
            'password' => $request->form['password'] ? bcrypt($request->form['password']) : null,
            'created_through_soc_acc' => $socAcc ? $socAcc->id : null,
            'timezone' => $timezoneCookie ?? config('app.timezone'), // json_decode(get_file_contents('http://ip-api.com/json/'), true)['timezone']
            'country' => $country
        ]);



        event(new Registered($user));

        // если регестраци не через соц акк
        if (!$userSoc) {
            $captchaResponse = $request->captchaResponse;
            $captchaCheckStatus = $this->checkCaptcha($captchaResponse);

            if (!$captchaCheckStatus) {
                $user->delete();
                return $this->sendError('Неправильно введена капча.', 422);
            }

            // сохраняет почту из формы регистрации
            $email = new Email([
                'email' => $request->form['email'],
                'label' => 'Эл. адрес взятый из формы регистрации',
                'public' => false,
                'verified' => false,
            ]);
            $email->verification_token = $this->createVerificationTokenAndMail($email);
            $user->saveEmail($email);
            // $user->activated = false;
            // $user->email_verified = false;
            // почту нужно подтвердить, создает токен для подтверждения почты
            // $user->email_verification_token = $this->createVerificationTokenAndMail($user);
            // $user->save();
        }

        // если регестрация через соц акк, то сохраняет акк и отправляет ответ для входа(токены и объект пользователя)
        if ($userSoc) {
            $this->userSaveSocAcc($user, $userSoc,  $request->providerName);
            $doAuthResponse = $this->getDoAuthResponse($user, $request->providerName);

            return $this->sendResponse($doAuthResponse);
        }


        return $this->sendResponse(NULL, 'Пользователь успешно создан!', 201);
    }

    /**
     * Вход и возвращение токена
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(LoginRequest $request)
    {
        $credentials = array_filter(request(['nickname', 'email'])); // , 'password'
        // $credentials['password'] = \Hash::make($credentials['password']);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $error = null;
        // пользователь по почте или нику
        if ((isset($credentials['email']) && $user = User::ofEmail($credentials['email'])->first())
        || (isset($credentials['nickname']) && $user = User::ofNickname($credentials['nickname'])->first())
        ) {
            // совпадает ли пароль
            if (request()->password && !Hash::check(request()->password, $user->password)) {
                $error = 'Не правильный пароль';
            }
        } else {
            $error = isset($credentials['email']) ? 'Не правильная почта.' : 'Не правильный ник.';
        }


        // если найдена ошибка
        if ($error) {
            // попыток входа += 1
            $this->incrementLoginAttempts($request);
            return $this->sendError($error, 401);
        }

        // через какой соц акк пользователь вошел последний раз(раз он не не использовал соц акк, то ставится null)
        $user->signin_through_soc_acc = null;
        $user->save();
        // попыток входа = 0
        $this->clearLoginAttempts($request);
        event(new Login($user, false)); // false - это remember


        // Возврашает ответ с токеном
        return $this->getBearerTokenByUser($user);
        // "token_type": "Bearer",
        // "expires_in": 3600,
        // "access_token": "...",
        // "refresh_token": "..."
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout()
    {
        $user = auth()->user();

        $user->token()->revoke();
        event(new Logout($user));

        return $this->sendResponse(NULL, 'Выход успешен');
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $user = new UserResource(auth()->user());

        return $this->sendResponse([
            'user' => $user
        ]);
    }

    /**
     * Повторно отправить сообщение о подтвержденнии, не меняя при этом токен
     *
     */
    public function repeatVerificationMail()
    {
        $this->createVerificationTokenAndMail(Email::find(request()->id), true);
    }

    /**
     * Попытка подтвердить почту пользователя
     *
     * @return [json] user object
     */
    public function emailVerify()
    {
        if ($email = Email::where('verification_token', request()->token)->first()) {
            $email->verified = true;
            $email->verification_token = null;
            $email->save();

            return new UserResource(auth()->user());
        } else {
            return $this->sendError('Не правильная ссылка подтверждения.', 422);
        }
    }

    /**
     * Only dev: Вернуть данные для входа указаного пользователя
     */
    public function devAuthInfoByUser()
    {
        if ($user = auth()->user()) {
            $user->token()->revoke();
            event(new Logout($user));
        }

        $user = User::find(request()->userId);
        // Инфо о токене в виде массива
        $tokenInfoArr = $this->getBearerTokenByUser($user, false);

        // return array_merge(
        //     $tokenInfoArr,
        //     ['user' => new UserResource($user)]
        // );
        return $this->sendResponse(array_merge(
            $tokenInfoArr,
            ['user' => new UserResource($user)]
        ));
    }

    /**
     * Результат капчи
     */
    protected function checkCaptcha($captchaResponse) : bool
    {
        $client = new Client();
        $resStr = $client->post('https://www.google.com/recaptcha/api/siteverify', ['query' => [
            'secret' => env('RECAPTCHA_SECRET'), // TODO
            'response' => $captchaResponse
        ]])->getBody()->getContents();

        $resObj = json_decode($resStr);

        return (boolean) $resObj->success;
    }


    /**
     * username использующийся в Throttles
     *
     * @return string
     */
    public function username()
    {
        return 'nickname'; // было email
    }
}

// return array
// return $this->getBearerTokenByUser($user, 1, false);
// $tokenResult = $user->createToken('Personal Access Token'); // просто подпись токена, может быть любой

// $token = $tokenResult->token;
// if ($request->remember_me)
//     $token->expires_at = Carbon::now()->addWeeks(1);
// $token->save();

// return response()->json([
//     'access_token' => $tokenResult->accessToken,
//     'token_type' => 'Bearer',
//     'expires_at' => Carbon::parse(
//         $tokenResult->token->expires_at
//     )->toDateTimeString()
// ]);

// return $this->sendResponse([
//     'access_token' => $tokenResult->accessToken,
//     'token_type' => 'Bearer',
//     'expires_at' => Carbon::parse(
//         $tokenResult->token->expires_at
//     )->toDateTimeString()
// ]);

// return response()->json([
//     'access_token' => $tokenResult->accessToken,
//     'token_type' => 'Bearer',
//     'expires_at' => Carbon::parse(
//         $tokenResult->token->expires_at
//     )->toDateTimeString()
// ]);
