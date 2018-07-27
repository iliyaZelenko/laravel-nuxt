<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerify;

trait EmailVerification
{
    /**
     * Создает токен подтверждения почты и сообщение на почту
     */
    protected function createVerificationTokenAndMail($email, $oldToken = false) : string
    {
        $token = ($oldToken && $email->verification_token) ?
            $email->verification_token
            :
            hash_hmac('sha256', str_random(40), config('app.key'));

        // возвращает токен
        return tap(
            $token,
            function ($token) use ($email) {
                $resetUrlWithToken = config('app.client_url') . '/auth/verify-email?token=' . $token;
                $afterSignup = auth()->guest();

                Mail::to([
                    'email' => $email->email
                ])->send(new EmailVerify($resetUrlWithToken, $afterSignup));
            });
    }
}
