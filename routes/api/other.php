<?php

Route::post('check-nickname', function () {
    $user = \App\User::where('nickname', request()->nickname)->first();

    return response()->json(['unique' => !$user]);
});

Route::post('users', function () {
    $users = \App\User::all();

    // Чтобы получить пользователя: auth()->user()
    // Факт: если используется авторизация через апи, то не не нужен специальный
    // middleware для того чтобы просто получить пользователя, если есть токен - происходит автооризация,
    // если токен ошибочный то просто не поставитсья пользователь, но если стоит auth:api то уже может выдать ошибку что нет токена
    // if (auth()->check()) {
    //     $user = auth()->user();
    // }

    return \App\Http\Resources\UserResource::collection($users);
});


Route::get('socialite-providers', function () {
    $data = \App\SocialiteProvider::all();

    return $data; //response()->json($data);
});



// список стран ['US' => 'United States', 'BE' => 'Belgium', ...]
Route::get('countries', function () {
    // $countries = Countries::all();     where('name.common', 'France');

    $countries = Countries::all()->filter(function ($item) {
        return $item->cca2 !== "EU" && isset($item['translations']['rus']['common']); // strlen($item->cca2) > 0;
    })->map(function ($item, $key) {
        $prefix = isset($item['dialling']['calling_code'][0]) ? $item['dialling']['calling_code'][0] : null;
        // $prefix = $prefix[0] ?? null;

        // $shortName = $item->cca2; // cca2;
        // $callingCodes = $item->getCallingCodes();

        return [
            'countryCode' => $item->cca3, // или key
            'text' => $item['translations']['rus']['common'], // country()->name($shortName), // $item->name->common,
            // 'code' => $shortName, // postal,
            'flagName' => $key,
            'phonePrefix' => $prefix     // $prefix, // , // isset($item->dialling) ?  : null  ['calling_code'][0]
            // 'flag' => $item['flag'],
            // 'tttttttttttttttttttttttttttttttttttttttttt' => $item->hydrate('timezones')->timezones->first() // ->zone_name
            // 'r' => $item->getTranslation()
            // 'flag' => $item->flag->emoji
        ];
    });

    // $timezones = null;
    // $timezones = Countries::all()->where('name.common', 'United States')->first()->hydrate('timezones')->timezones->first(); // ->zone_name
    // $countries->toJson()
    return response()->json($countries->values()); // ->pluck('name.common')


    // $countries = country()->all();
    //
    // $countries = array_map(function ($key, $val) {
    //     return [
    //         'value' => $key,
    //         'text'  => $val
    //     ];
    // }, array_keys($countries), $countries);
    //
    // return response()->json($countries);
});


// список временный зон в формате [Africa/Abidjan] => (UTC+00:00) Africa/Abidjan
Route::get('timezones', function () {
    $countries = Countries::all();

    $timezones = collect([]);
    $countries->hydrate('timezones')->each(function ($country, $countryKey) use ($timezones) {
        $timezones = $country['timezones']->each(function($timezone) use ($timezones, $country, $countryKey) {
            $name = $timezone['zone_name'];
            $timezones[] = [
                'text' => $name,
                'value' => $name,
                'countryName' => $country['translations']['rus']['common'],
                // 'countryCodeFlag' => $countryKey,
                'flagName' => $timezone->cca3,
                'countryCode' => $timezone->cca3 // cca2
            ];
        });
    });
    $tzlist = $timezones->unique('text');


    $result = [];
    foreach ($tzlist as $timezone) {
        $offset = (new DateTimeZone($timezone['value']))->getOffset(new DateTime);
        $offsetPrefix = $offset < 0 ? '-' : '+';
        $offsetFormatted = gmdate('H:i', abs($offset));
        // $utcOffset = "UTC$offsetPrefix$offsetFormatted";

        $result[] = array_merge($timezone, [
            // 'value' => $timezone['value'],
            'offset' => "$offsetPrefix$offsetFormatted",
            'offsetPrefix' => $offsetPrefix
            // "text" => "($utcOffset) $timezone"
        ]);
    }

    usort($result, function ($a, $b) { return strcmp($a["offset"], $b["offset"]); });


    return response()->json($result);
});



// список временный зон в формате [Africa/Abidjan] => (UTC+00:00) Africa/Abidjan
Route::get('phone-prefixes', function () {
    $countries = Countries::all()->filter(function ($item) {
        $prefix = isset($item['dialling']['calling_code'][0]);

        return $prefix && $item->cca2 !== "EU" && isset($item['translations']['rus']['common']); // strlen($item->cca2) > 0;
    })->map(function ($item, $key) {
        return [
            'countryCode' => $item->cca3, // или key
            'countryCode2' => $item->cca2,
            'country' => $item['translations']['rus']['common'],
            'phonePrefix' => $item['dialling']['calling_code'][0]
        ];
    });


    return response()->json($countries->values());
});

// список временный зон в формате [Africa/Abidjan] => (UTC+00:00) Africa/Abidjan
// Route::get('timezones', function () {
//     $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
//
//     $result = [];
//     foreach ($tzlist as $timezone) {
//         $offset = (new DateTimeZone($timezone))->getOffset(new DateTime);
//         $offsetPrefix = $offset < 0 ? '-' : '+';
//         $offsetFormatted = gmdate('H:i', abs($offset));
//         // $utcOffset = "UTC$offsetPrefix$offsetFormatted";
//
//         $result[] = [
//             'value' => $timezone,
//             'offset' => "$offsetPrefix$offsetFormatted",
//             'offsetPrefix' => $offsetPrefix
//             // "text" => "($utcOffset) $timezone"
//         ];
//     }
//
//     usort($result, function ($a, $b) { return strcmp($a["offset"], $b["offset"]); });
//
//
//     return response()->json($result);
// });
