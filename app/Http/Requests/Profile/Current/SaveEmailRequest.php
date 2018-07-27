<?php

namespace App\Http\Requests\Profile\Current;

use Illuminate\Foundation\Http\FormRequest;

class SaveEmailRequest extends FormRequest
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
            'email' => 'required|' . config('validation.email'),
            'public' => 'required|boolean',
            'label' => 'nullable|' . config('validation.emailLabel'),
            'main' => 'required|boolean'
        ];
    }


    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        // $validator->after(function ($validator) {
        //     if (request()->label) {
        //         $validator->addRules([ 'label' => config('validation.emailLabel') ]);
        //     }
        //     if ($this->somethingElseIsInvalid()) {
        //         $validator->errors()->add('field', 'Something is wrong with this field!');
        //     }
        // });
    }
}
