<?php

namespace App\Http\Requests\Profile\Current;

use Illuminate\Foundation\Http\FormRequest;

class SetPasswordRequest extends FormRequest
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
        if (request()->password) {
            $rules = [
                'password' => config('validation.password')
            ];
        } else {
            $rules = [
                'currentPassword' => config('validation.password'),
                'newPassword' => config('validation.password')
            ];
        }

        return $rules;
    }
}
