<?php

namespace App\Services\Socialite\Avatars;

use GuzzleHttp\Client;
use App\Contracts\Socialite\Avatar;

class Vkontakte extends Avatar
{
    /**
     * Дает ссылку на аватар из данных запроса
     */
    protected function getAvatarFromData($data)
    {
        return $data->photo_400_orig ?? null;
    }

    /**
     * Адрес API
     */
    protected function getUrl() {
        $fields = ['photo_400_orig'];

        return "https://api.vk.com/method/users.get?user_ids={$this->userSocialite->getId()}&fields=" . implode(',', $fields) . "&access_token={$this->userSocialite->token}&https=1";
    }
}
