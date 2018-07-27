<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/




// $faker = Faker\Factory::create('ru_RU');// Faker::create('ru_RU');

$factory->define(App\User::class, function (Faker $faker, $attr) { // Faker $faker
    $addName = mt_rand(1, 2) === 2;
    $gender = mt_rand(1, 4) < 4; // true - мужчина, 25% что женщина

    $country = Countries::all()->filter(function ($item) {
        return $item->cca2 !== "EU" && isset($item['translations']['rus']['common']);
    })->random()->hydrate('timezones'); // ->cca3

    return [
        'nickname' => str_replace('.', '_', $faker->userName),
        // 'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'first_name' => $addName ? $faker->firstName($gender) : null,
        'last_name' => $addName ? $faker->lastName($gender) : null,
        'gender' => $gender,
        'birthday' => mt_rand(1, 3) === 1 ? Carbon::now()->subYears(mt_rand(22, 40))->subDays(mt_rand(1, 800)) : null,
        'country' => $country->cca3,
        'timezone' => $country['timezones']->first()['zone_name'] ?? config('app.timezone'),// (mt_rand(1, 3) === 1 ? $country['timezones']->first()['zone_name'] : null) ?? config('app.timezone'),
        // 'activated' => false,
        // 'email_verified' => false,
        'created_at' => Carbon::now()->subDays(mt_rand(1, 800)),
        // 'remember_token' => str_random(10),
    ];
});


$factory->define(App\Email::class, function (Faker $faker) { // Faker $faker
    $addlabel = mt_rand(1, 2) === 2;
    $public = mt_rand(1, 2) === 2;
    $verified = mt_rand(1, 2) === 2;

    return [
        'email' => $faker->unique()->safeEmail,
        'label' => $addlabel ? $faker->word : null,
        'public' => $public,
        'verified' => $verified,
        'verification_token' => $verified ? null : hash_hmac('sha256', str_random(40), config('app.key'))
    ];
});


$factory->define(App\Phone::class, function (Faker $faker, $attr) { // Faker $faker
    $addlabel = mt_rand(1, 2) === 2;
    $public = mt_rand(1, 2) === 2;
    $verified = mt_rand(1, 2) === 2;
    // $country = $attr['country'] ?? $faker->countryCode;
    $numberFaker = substr($faker->e164PhoneNumber, -9); // TODO через обычнуб php либу // substr($faker->e164PhoneNumber, -9); // '0' . национальный формат ->ofCountry($country)


    $countries = Countries::all();

    $countries = $countries->filter(function ($country) {
        $prefix = countryGetCallingCode($country);

        return $prefix && $country->cca2 !== "EU" && isset($country['translations']['rus']['common']);
    });


    if (isset($attr['country'])) {
        $country = $countries->where('cca3', $attr['country'])->first(); // $countries->whereFirst('cca3', $attr['country']); // ->first()
    } else {
        $country = $countries->random();
    }

    $prefix = countryGetCallingCode($country);
    // $prefix = isset($country['dialling']['calling_code'][0]) ? $country['dialling']['calling_code'][0] : null;
    $number = $numberFaker; // $prefix .

    // clock($country, $prefix, $number);

    return [
        'country' => $country->cca3,
        'country2' => $country->cca2,
        'prefix' => $prefix,
        'number' => $number,
        'label' => $addlabel ? $faker->word : null,
        'public' => $public,
        'verified' => $verified,
        'sms_verification_code' => $verified ? null : hash_hmac('sha256', str_random(5), config('app.key'))
    ];
});


$factory->define(App\UserPasswordHistroy::class, function (Faker $faker) { // Faker $faker
    return [
        'password' => \Hash::make($faker->word),
        'created_at' => Carbon::now()->subDays(mt_rand(1, 200))
    ];
});


function countryGetCallingCode($country) {
    return isset($country['dialling']['calling_code'][0]) ? $country['dialling']['calling_code'][0] : null;
}
