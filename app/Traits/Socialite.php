<?php

namespace App\Traits;

use App\SocialiteProvider;
use App\User;
use App\Email;
use App\Http\Resources\UserResource;
use App\Traits\Avatar; // можно и просто use Avatar;
use Image;
// use App\Traits\EmailVerification;

trait Socialite
{
    // use EmailVerification;
    use Avatar;

    public function userSaveSocAcc($user, $userSoc, $providerName) {
        $provider = SocialiteProvider::where('name', $providerName)->first();

        // ищет юзера по uid
        if ($userBySocAccountUid = $this->userBySocAccountUid($userSoc['uid'])) {
            if ($userBySocAccountUid->id === $user->id) {
                throw new \Exception('Вы уже прикрепляли этот аккаунт!', 422);
            } else {
                throw new \Exception('Этот аккаунт прикреплен другим пользователем!', 422); // или 403
            }
        }

        // Было так: (!$user->mainEmail || !$user->mainEmail->verified) &&  добавялет почту, аватар, имя смотря на то если есть в запросе и нет у пользователя(или у него есть но не подтверждена)
        // Добавляет каждый новый адрес из соц сети если он не занят другим пользователем
        if ($userSoc['email']) {
            // поиск почты совпадающей с почтой соц сети
            if ($emailSameAsSocEmail = Email::where('email', $userSoc['email'])->first()) {
                // если владелец почты совпадает с текущим и если не подтвержденна, то делает ее подтвержденной
                if ($emailSameAsSocEmail->user()->first()->id === $user->id && !$emailSameAsSocEmail->verified) {
                    $emailSameAsSocEmail->verified = true;
                    $emailSameAsSocEmail->save();
                }
            } else { // делает новый экземпляр почты и прикрепляет к пользователю
                $emailFromSocAcc = new Email([
                    'user_id' => $user->id, // не знаю почему, но без этого не работает
                    'email' => $userSoc['email'],
                    'label' => "Эл. адрес взятый из $provider->name_for_human.",
                    'verified' => true,
                    'public' => false
                ]);

                $user->saveEmail($emailFromSocAcc);
            }
        }

        // if ($userSoc['email'] && !Email::where('email', $userSoc['email'])->first()) {
        //
        // }
        // определяет подтвержденна ли почта, может отправить сообщение для подтверждения
        // if ($user->email) {
        //     // делать подтвержденной только если почты совпадают
        //     if ($user->email === $userSoc['email']) {
        //         // подтверждение почты
        //         $user->email_verified = true;
        //     } elseif (!$user->email_verified) { // если не подтвержден, то отправляет сообщение (bool) $user->email_verified !== true
        //         // ставит как не подтвержденная и отправляет сообщение на почту
        //         $user->email_verified = false;
        //         $user->email_verification_token = $this->createVerificationTokenAndMail($user);
        //     }
        // } else {
        //     // ставит как не подтвержденная, не отправляет сообщение на почту, потому как куда отправлять если ее нет?
        //     $user->email_verified = false;
        // }


        // ставит аватарку
        if (!$user->avatar && $userSoc['avatar']) {
            $img = Image::make($userSoc['avatar']);
            $this->setUserAvatar($user, $img);
        }
        // $user->avatar = $user->avatar ?? $userSoc['avatar'];
        $user->first_name = $user->first_name ?? $userSoc['firstName'] ?? NULL;
        $user->last_name = $user->last_name ?? $userSoc['lastName'] ?? NULL;
        // $user->activated = true;
        $user->save();


        $user->socAccounts()->save($provider, [
            'uid' => $userSoc['uid'],
            'token' => $userSoc['token'],
            'expiresIn' => $userSoc['expiresIn'],
            'refreshToken' => $userSoc['refreshToken']
        ]);
    }

    public function getUserSocResponse($userSoc, $providerName) {
        $userSocResponse = [
            'user' => [
                'uid' => $userSoc->getId(),
                'email' => $userSoc->getEmail(),
                'nickname' => $userSoc->getNickname(),
                'avatar' => $this->getAvatar($userSoc, $providerName),
                // token
                'token' => $userSoc->token,
                'refreshToken' => $userSoc->refreshToken,
                'expiresIn' => $userSoc->expiresIn
            ]
        ];
        if ($name = $userSoc->getName()) {
            [$firstName, $lastName] = explode(' ', $name);

            $userSocResponse['user']['firstName'] = $firstName;
            $userSocResponse['user']['lastName'] = $lastName;
        }

        return $userSocResponse;
    }

    /**
     * Возможно этот акк соц сети уже привязан к кому-то(попытка найти по uid)
     */
    public function userBySocAccountUid($uid)
    {
        $user = User::whereHas('socAccounts', function ($query) use ($uid) {
            $query->where('uid', $uid);
        })->first();

        return $user;
    }

    /**
     * Возвращает данные для входа
     */
     public function getDoAuthResponse($userForAuth, $providerName) {
         // через какой соц акк пользователь вошел последний раз
         $userForAuth->signin_through_soc_acc = SocialiteProvider::where('name', $providerName)->first()->id;
         $userForAuth->save();
         // Инфо о токене в виде массива
         $tokenInfoArr = $this->getBearerTokenByUser($userForAuth, false);

         return ['doAuth' => array_merge(
             $tokenInfoArr,
             ['user' => new UserResource($userForAuth)]
         )];
     }

    /**
     * Возможно аватар
     */
    protected function getAvatar($userSoc, $providerName)
    {
        $prividersForBuiltInAvatar = ['facebook', 'instagram', 'reddit'];

        // если провайдер не возвращает аватар нормально, то получает через класс
        if (in_array($providerName, $prividersForBuiltInAvatar)) {
            // встроенное получение
            $avatar = $userSoc->getAvatar();
        } else {
            $avatarClass = '\App\Services\Socialite\Avatars\\' . ucfirst($providerName);
            $avatar = (new $avatarClass($userSoc))->get();
        }

        return $avatar;
    }
}
