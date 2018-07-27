<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        // try {
        $numberParsed = $phoneUtil->parse($this->number, $this->country2);
        $numberFormated = $phoneUtil->format($numberParsed, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
        // } catch (\libphonenumber\NumberParseException $e) {
        //     var_dump($e);
        // }

        return [
            'id' => $this->id,
            'country' => $this->country,
            'country2' => $this->country2,
            // 'countryFlag' => Countries::where('cca3', $this->country)->first()
            'prefix' => $this->prefix,
            'number' => $this->number,
            // 'numberFormated' => phone("+$this->prefix$this->number", [$this->country])->ofCountry($this->country)->formatInternational(),
            'numberFormated' => $numberFormated, // "+$this->prefix$this->number",
            'label' => $this->label,
            'verified' => $this->verified,
            'public' => $this->public,
            'smsVerificationCode' => $this->sms_verification_code,
            'createdAt' => (string) $this->created_at,
            'updatedAt' => (string) $this->updated_at,
        ];
    }
}
