<?php

namespace App\Http\Requests\Profile\Current;

use Illuminate\Foundation\Http\FormRequest;

class SavePhoneRequest extends FormRequest
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
        return [
            'number' => 'required|phone:country2|unique:phones,number',
            'country2' => 'required_with:number',
            // еще передается просто country
            // 'number' => 'required|unique:phones,number', // TODO . config('validation.phone'),
            'label' => 'nullable|' . config('validation.phoneLabel'),
            'public' => 'required|boolean',
            'prefix' => 'required'
        ];;
    }
}
