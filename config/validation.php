<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Правила валидации
    |--------------------------------------------------------------------------
    |
    |
    */

    'nickname' => 'string|min:3|max:32|regex:/^[а-яА-Яa-zA-ZЁё][а-яА-Яa-zA-Z0-9Ёё]*?([-_.][а-яА-Яa-zA-Z0-9Ёё]+){0,3}$/u',
    'email' => 'email',
    'emailLabel' => 'string|min:3|max:20',
    'phoneLabel' => 'string|min:3|max:20',
    'password' => 'required|string|min:5',
    'reset_password_token' => 'required',
    'first_name' => 'alpha|min:3|max:10',
    'last_name' => 'alpha|min:3|max:15'
];
