<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use App\Http\Resources\EmailResource;
use App\Http\Resources\PhoneResource;

class User extends AuthenticatableForUser
{
    use Notifiable, HasApiTokens;

    protected $emailForResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'email', 'password', 'first_name', 'last_name', 'avatar',
        'created_through_soc_acc', 'gender', 'birthday', 'main_email_id', 'main_phone_id', 'timezone',
        'country'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password' // , 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'avatar' => 'array',
        'gender' => 'boolean',
        // 'birthday' => 'date:Y-m-d'
    ];

    /**
    * The attributes that should be mutated to dates.
    * !!! Для каждого поля даты я написал геттеры для возвращения с учетом временной зоны
    * (если добавляете поле даты, то добавляйте геттер)
    */
   protected $dates = [
       'created_at',
       'updated_at',
       'birthday'
   ];

    /**
     * Какие Accessors при сериализации должны быть выданы
     */
    protected $appends = ['activated', 'full_name', 'main_email', 'main_phone'];



    /**
     * Accessor который определяет активирован ли пользователь
     */
    function getActivatedAttribute() {
        // если есть подтвержденная почта или прикрепленный соц акканут
        return $this->emails()->where('verified', true)->exists() ||
            $this->socAccounts()->exists();
    }
    /**
     * Accessor для полного имени
     */
    function getFullNameAttribute() {
        return $this->first_name && $this->last_name ? "$this->first_name  $this->last_name" : null;
    }
    /**
     * Accessor для главной почты
     */
    function getMainEmailAttribute() {
        return $this->emails()->find($this->main_email_id);
    }
    /**
     * Accessor для главного телефона
     */
    function getMainPhoneAttribute() {
        return $this->phones()->find($this->main_phone_id);
    }
    /**
     * Accessor для возраста.
     */
    public function getAgeAttribute()
    {
        if (!$this->birthday) {
            return null;
        }
        return Carbon::parse($this->birthday)->age;
    }



    /**
     * Мутация для главной почты
     */
    function setMainEmailAttribute($email) {
        $this->attributes['main_email_id'] = $email ? $email->id : null;
    }
    /**
     * Мутация для главного телефона
     */
    function setMainPhoneAttribute($phone) {
        $this->attributes['main_phone_id'] = $phone ? $phone->id : null;
    }



    /**
     * Сохраняет почту и если не было главной то делает
     */
    function saveEmail($email) {
        $this->emails()->save($email);

        // ставит если нет главного
        if (!$this->main_email_id) {
            $this->mainEmail = $email;
            $this->save();
        }
    }
    /**
     * Сохраняет телефон, первый сохраненный будет главным
     */
    function savePhone($phone) {
        $this->phones()->save($phone);
        // ставит если нет главного
        if (!$this->main_phone_id) {
            $this->mainPhone = $phone;
            $this->save();
        }
    }

    /**
     *Удаляет телефон, меняет главный телефон если надо
     */
    function deletePhone($id) {
        // $this->mainPhone = null;
        // $this->save();
        Phone::destroy($id);

        if (!$this->mainPhone && $this->phones()->exists()) { // $this->mainPhone &&
            $this->mainPhone = $this->phones()->first();
            $this->save();
        }
    }



    /**
     * Получить социальные аккаунты
     */
    public function socAccounts()
    {
      return $this->belongsToMany(SocialiteProvider::class); // , 'socialite_provider_user', 'user_id', 'provider_id'
    }

    /**
     * Почтовы еадреса
     */
    public function emails()
    {
      return $this->hasMany(Email::class);
    }

    /**
     * Почтовы еадреса
     */
    public function phones()
    {
      return $this->hasMany(Phone::class);
    }

    /**
     * История изменений пароля
     */
    public function passwordsHistory()
    {
      return $this->hasMany(UserPasswordHistroy::class);
    }




    /**
     * Пользователь по нику
     */
    public function scopeOfNickname($query, $nickname)
    {
        return $query->where('nickname', $nickname);
    }

    /**
     * Пользователь по почте
     */
    public function scopeOfEmail($query, $email)
    {
        $query->whereHas('emails', function ($relationQuery) use ($email) {
            $relationQuery->where('email', $email);
        })->get();
    }





    /**
     * Это перезапись Illuminate/Auth/Passwords/CanResetPassword.php
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->emailForResetPassword;// $this->mainEmail;
    }
    public function setEmailForResetPassword($value)
    {
        $this->emailForResetPassword = $value;
    }
}
