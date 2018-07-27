<?php

namespace App\Services\Socialite\Avatars;

use GuzzleHttp\Client;
use App\Contracts\Socialite\Avatar;

class Google extends Avatar
{
    /**
     * Дает ссылку на аватар из данных запроса
     */
    protected function getAvatarFromData($data)
    {
        return $data->image->url.'0' ?? null;
    }

    /**
     * Параметры запроса
     */
    protected function getConfig() {
        return [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->userSocialite->token,
            ]
        ];
    }

    /**
     * Адрес API
     */
    protected function getUrl() {
        return 'https://www.googleapis.com/plus/v1/people/me';
    }
}
