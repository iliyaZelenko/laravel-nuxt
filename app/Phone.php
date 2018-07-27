<?php

namespace App;

class Phone extends BaseModel
{
    protected $fillable = [
        'country', 'country2', 'prefix', 'number', 'label', 'verified', 'public', 'sms_verification_code'
    ];

    /**
     * Пользователь по нику
     */
    public function scopeOfPhone($query, $phone)
    {
        return $query->where('phone', $phone);
    }


    public function user() {
        return $this->belongsTo(User::class);
    }
}
