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

    /**
    * The attributes that should be mutated to dates.
    */
   // protected $dates = [
   //     'created_at',
   //     'updated_at'
   // ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // 'Europe/Kiev'
    // public function getCreatedAtAttribute($value) {
    //     // Carbon::parse( ->toDateTimeString()
    //     return Carbon::parse($value)->tz($this->user->timezone ?? 'UTC');
    // }
}
