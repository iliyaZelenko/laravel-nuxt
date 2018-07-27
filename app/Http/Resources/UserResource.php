<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use Carbon\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lastPasswordChange = $this->passwordsHistory()->orderBy('created_at', 'asc')->first();

        if ($lastPasswordChange) {
            $passwordLongTimeNotChange = now()->diffInDays($lastPasswordChange->created_at) > 100;
        } else {
            $passwordLongTimeNotChange = null;
        }


        $countryName = \Countries::where('cca3', $this->country)->first()['translations']['rus']['common'];


        return [
            'id' => $this->id,
            'password' => !!$this->password, // есть ли пароль
            'passwordLongTimeNotChange' => $passwordLongTimeNotChange,
            'nickname' => $this->nickname,
            'emails' => EmailResource::collection($this->emails), // короткая форма чтобы не писать ()->get()
            'phones' => PhoneResource::collection($this->phones),
            'mainEmail' => new EmailResource($this->mainEmail),
            'mainPhone' => new PhoneResource($this->mainPhone),
            'age' => $this->age,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'fullName' => $this->full_name,
            'gender' => $this->gender,
            'genderText' => $this->gender === true ? 'Мужчина' : ($this->gender === false ? 'Женщина' : 'Не указано'),
            'timezone' => $this->timezone,
            'country' => $this->country,
            'countryName' => $countryName,
            // 'avatar' => $this->avatar,
            'avatar' => $this->avatar,
            'socAccounts' => $this->socAccounts,
            'createdThroughSocAcc' => $this->created_through_soc_acc,
            'signinThroughSocAcc' => $this->signin_through_soc_acc,
            // 'emailVerified' => $this->email_verified,
            'activated' => $this->activated,
            // created_through_soc_acc
            'birthday' => (string) $this->birthday,
            'createdAt' => (string) $this->created_at,
            'updatedAt' => (string) $this->updated_at,
        ];
    }
}
