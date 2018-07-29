<?php

namespace App;

class UserPasswordHistroy extends BaseModel
{
    protected $table = 'users_passwords_history';


    protected $fillable = [
        'password'
    ];

    protected $hidden = [
        'password'
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }
}
