<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class SocialiteProvider extends BaseModel
{
    /**
     * Получить владельцев провайлера
     */
    public function SocialiteProviders()
    {
      return $this->belongsToMany(User::class); // , 'socialite_provider_user', 'user_id', 'provider_id'
    }
}
