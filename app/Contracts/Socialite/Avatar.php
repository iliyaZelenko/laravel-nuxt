<?php

namespace App\Contracts\Socialite;

use GuzzleHttp\Client;

abstract class Avatar
{
    protected $userSocialite;

    public function __construct(\Laravel\Socialite\AbstractUser $userSocialite)
    {
        $this->userSocialite = $userSocialite;
    }

    public function get()
    {
        $data = $this->request();

        return $this->getAvatarFromData($data);
    }

    /**
     * Возвращает результат запроса к API с указаными параметрами
     */
    protected function request()
    {
        $responseContents = (new Client())
            ->get($this->getUrl(), $this->getConfig())
            ->getBody()
            ->getContents();
        $data = json_decode($responseContents);

        return $data;
    }

    /**
     * Параметры запроса
     */
    protected function getConfig() {
        return [];
    }

    /**
     * Адрес API
     */
    abstract protected function getUrl();

    /**
     * Дает ссылку на аватар из данных запроса
     */
    abstract protected function getAvatarFromData($data);

}
