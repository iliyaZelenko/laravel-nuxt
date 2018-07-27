<?php

use Illuminate\Database\Seeder;

class SocialiteProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // php artisan db:seed --class SocialiteProvidersTableSeeder
    public function run()
    {
        // App\SocialiteProvider::create([
        //     'name' => 'vkontakte',
        //     'name_for_human' => 'Вконтакте',
        // ]);
        //
        // App\SocialiteProvider::create([
        //     'name' => 'facebook',
        //     'name_for_human' => 'Facebook',
        // ]);
        //
        // App\SocialiteProvider::create([
        //     'name' => 'google',
        //     'name_for_human' => 'Google+',
        // ]);

        if (App\SocialiteProvider::where('name', 'google')->exists()) {
            return;
        }


        App\SocialiteProvider::insert([
            [
                'name' => 'google',
                'name_for_human' => 'Google+',
                'icon' => 'google-plus',
                'color' => '#F44336',
                'text_color' => null
            ],
            [
                'name' => 'facebook',
                'name_for_human' => 'Facebook',
                'icon' => 'facebook',
                'color' => '#3F51B5',
                'text_color' => null
            ],
            [
                'name' => 'vkontakte',
                'name_for_human' => 'Вконтакте',
                'icon' => 'vk',
                'color' => '#1976D2',
                'text_color' => '#1976D2'
            ],
            [
                'name' => 'instagram',
                'name_for_human' => 'Instagram',
                'icon' => 'instagram',
                'color' => '#2196F3',
                'text_color' => null
            ],
            [
                'name' => 'reddit',
                'name_for_human' => 'Reddit',
                'icon' => 'reddit',
                'color' => '#E64A19',
                'text_color' => '#E64A19'
            ]
        ]);
    }
}
