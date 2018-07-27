<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Email;
use App\UserPasswordHistroy;
use App\Phone;
use Carbon\Carbon;
use App\Traits\Avatar;

class UsersTableSeeder extends Seeder
{
    use Avatar;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'name' => 'Laravel Personal Access Client',
            'secret' => 'RjY1VH0i0VYStZD5mPQZ4ii8VKvCILYqZoCXJFZB',
            'redirect' => 'http://localhost',
            'personal_access_client' => 1,
            'password_client' => 0,
            'revoked' => 0,
        ]);

        factory(User::class, 5)->create()->each(function ($u) {
            for ($i = 0; $i < mt_rand(1, 4) - mt_rand(1, 2); $i++) {
                $email = factory(Email::class)->make();
                $u->saveEmail($email);
            }

            $avatar = ($u->gender ? 'https://randomuser.me/api/portraits/men/' : 'https://randomuser.me/api/portraits/women/') . mt_rand(0, 99) . '.jpg';
            $this->setAvatar($u, $avatar);

            // история изменений пароля
            $passwordsHistory = factory(UserPasswordHistroy::class, mt_rand(1, 3))->make();
            $u->passwordsHistory()->saveMany($passwordsHistory);

            // телефоны
            $phones = factory(Phone::class, abs(mt_rand(1, 3) - mt_rand(1, 3)))
                ->make()
                ->each(function ($phone) use ($u) {
                    $u->savePhone($phone);
                });
            // $u->phones()->saveMany($phones);
        });

        $adminNickname = 'Ilya-Zelenko';
        if (!User::ofNickname($adminNickname)->first()) {
            $this->makeAdmin($adminNickname);
        }
    }


    public function makeAdmin($adminNickname) {
        $adminAvatarBasePath = public_path('avatars/forAdminSeed/');
        $admin = User::firstOrCreate([
            'nickname' => $adminNickname,
            'first_name' => 'Илья',
            'last_name' => 'Зеленько',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'gender' => true,
            'birthday' => Carbon::now()->subYears(18),
            'timezone' => 'Europe/Kiev',
            'country' => 'UKR'
            // 'avatar' => [
            //     "lg" => $adminAvatarBasePath . 'lg.jpg',
            //     "md" => $adminAvatarBasePath . 'md.jpg',
            //     "sm" => $adminAvatarBasePath . 'sm.jpg',
            //     "circle" => $adminAvatarBasePath . 'circle.jpg',
            // ],
        ]);

        $this->setAvatar($admin, $adminAvatarBasePath . 'lg.jpg');

        $provider = App\SocialiteProvider::where('name', 'google')->first();
        $admin->socAccounts()->save($provider, [
            // 'socialite_provider_id' => App\SocialiteProvider::where('name', 'google')->first()->id,
            'uid' => '114487984432110048809',
            'token' => 'ya29.GlzXBSv-hkz9oljIlewBTi-8TRnqmIhng6DtLkjSU18ZtQ8PUrunm8ceTYWDdOOxPF5UTchP90nk8dOSPrfa4ImTo1IFbfm_MptL4IT6MLcdLF2TNXeHAUFgKUoDlg',
            'expiresIn' => 3598,
            'refreshToken' => null
        ]);

        $emails = [
            // главный адрес определяется по тому что первый
            [
                'email' => 'iliyazelenkog@gmail.com',
                'label' => null,
                'public' => false,
                'verified' => false,
                'verification_token' => 'testToken'
            ],
            [
                'email' => 'aimer@gmail.com',
                'label' => 'Для вопросов',
                'public' => true,
                'verified' => false,
                'verification_token' => 'testToken'
            ],
            [
                'email' => 'ilya@gmail.com',
                'label' => 'Для деловых предложений',
                'public' => true,
                'verified' => true,
                'verification_token' => null
            ]
        ];

        foreach ($emails as $email) {
            $emailModel = new Email($email);
            $admin->saveEmail($emailModel);
        }


        // история изменений пароля
        $passwordsHistory = factory(UserPasswordHistroy::class, mt_rand(1, 3))->make();
        $admin->passwordsHistory()->saveMany($passwordsHistory);
        // чтобы удобней тестить
        $admin->passwordsHistory()->save(new UserPasswordHistroy([
            'password' => \Hash::make('secret1')
        ]));


        // телефоны
        $phones = [
            factory(Phone::class)->make([
                'country' => 'UKR',
                'prefix' => '380',
                'number' => '983267431',
                'label' => 'Семейный',
                'public' => false
            ]),
            factory(Phone::class)->make([
                'country' => 'UKR',
                'prefix' => '380',
                'number' => '960652658',
                'label' => 'Для работы',
                'public' => true
            ]),
            factory(Phone::class)->make([
                'country' => 'POL',
                'prefix' => '48',
                'number' => '460652658',
                'label' => 'Польский',
                'public' => false
            ]),
            factory(Phone::class)->make([
                'country' => 'POL',
                'prefix' => '48',
                'number' => '583267431',
                'label' => 'Польский 2',
                'public' => false
            ])
        ];

        foreach ($phones as $phone) {
            $admin->savePhone($phone);
        }
    }

    public function setAvatar($user, $url) {
        $img = \Image::make($url);
        $this->setUserAvatar($user, $img);
    }
}
