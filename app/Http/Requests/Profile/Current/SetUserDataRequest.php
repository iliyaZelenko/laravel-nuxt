<?php

namespace App\Http\Requests\Profile\Current;

use Illuminate\Foundation\Http\FormRequest;

class SetUserDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'birthday' => 'nullable|date',
            'timezone' =>  'nullable|timezone'
        ];

        // TODO!!!!!!!!!!!!!!!!!!!
        // требовать ввода обоих полей если одно из них введено
        if (request()->firstName || request()->lastName) {
            $rules['firstName'] = 'required|' . config('validation.first_name');
            $rules['lastName'] = 'required|' . config('validation.last_name');
        }

        // if (request()->email) {
        //     $rules['email'] = config('validation.email');
        // }



        return $rules;
    }
}
