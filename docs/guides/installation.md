# Installation :package:

<!-- 2. `cp .env .env.example` -->
1. `git clone https://github.com/iliyaZelenko/laravel-nuxt.git`
2. `composer install` and `yarn` / `npm install`
3. Edit **.env** to set your database connection details
4. `php artisan migrate:fresh --seed` make tables and users
5. for recaptcha set [RECAPTCHA_SECRET](https://www.google.com/recaptcha/admin#list)(used only in registration)
6. [how to setup socialite](../socialite/SOCIALITE.md)


::: tip Development in spa
Run `yarn dev` / `npm run dev`
:::
