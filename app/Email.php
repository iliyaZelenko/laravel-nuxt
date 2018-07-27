<?php

namespace App;

class Email extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'label', 'verified', 'public', 'verification_token'
    ];

    /**
     * Почта по почте
     */
    public function scopeOfEmail($query, $email)
    {
        return $query->where('email', $email);
    }


    public function user() {
        return $this->belongsTo(User::class);
    }
}
