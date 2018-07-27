<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
        logger(request());
        $rules = [
            'form.nickname' => 'required|unique:users,nickname|' . config('validation.nickname'),
        ];

        if (!request()->userSoc) {
            $rules = array_merge($rules, [
                'form.email' => 'required|unique:emails,email|' . config('validation.email'),
                'form.password' => config('validation.password')
            ]);
        }

        return $rules;
    }
}
