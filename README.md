# Laravel Nuxt Auth Starter DEMO

I'm ready to fix all mistakes and i want to make it as cool as possible.
Project in Russian, but **if you are interested yo can put a star, i can translate everything into English**.
Contact Email: iliyazelenkog@gmail.com

## Features

- Laravel 5.6, Nuxt 1.4
- SSR or SPA (easy switch and development)
- Authentication with Laravel Passport and [@nuxtjs/auth](https://github.com/nuxt-community/auth-module)
- Socialite integration(there are many cool features here, i need to make a separate page)
- Vuetify + Font Awesome icons(A la Carte + vue integration)
- Login, register, password reset, profile, settings
- 95% responsive design
- many emails and phones
- User can set time zone and country (for guest, country and time zone are defined in cookie via https://ipapi.co/json/)
- manage socialite accounts and all info in settings
- avatar upload using cropping
- **And many others (detailed description will be soon)**

## Installation

<!-- 2. `cp .env .env.example` -->
1. `git clone https://github.com/iliyaZelenko/laravel-nuxt.git`
2. `composer install`
3. Edit **.env** to set your database connection details
4. `php artisan migrate:fresh --seed` make tables and users
5. for recaptcha set [RECAPTCHA_SECRET](https://www.google.com/recaptcha/admin#list)(used only in registration)
6. [how to setup socialite](./docs/SOCIALITE.md)

## Setup ssr
1. Set .env `APP_CLIENT_MODE=srr`
2. Set client url `APP_CLIENT_URL` and api `APP_URL`

For start production ssr server run `yarn ssr` / `npm run ssr`

## Setup spa (default setup)
1. Set .env `APP_CLIENT_MODE=spa`
2. Set same client url `APP_CLIENT_URL` and api `APP_URL`

For production build run `yarn build-spa` / `npm run build-spa`  
To see production version run `php artisan serve`


## Development in spa

1. Setup spa
2. Run `yarn dev` / `npm run dev`  


<img align="left" width="415" height="200" src="https://i.imgur.com/9rDip2L.png">
<img align="right" width="415" height="200" src="https://i.imgur.com/2mWCW9w.png">

<img align="left" width="415" height="200" src="https://i.imgur.com/WCqVvJe.png">
<img align="right" width="415" height="200" src="https://i.imgur.com/yREueWw.png">

<img align="left" width="415" height="200" src="https://i.imgur.com/xgFSMDu.png">
<img align="right" width="415" height="200" src="https://i.imgur.com/QhEjkU7.png">

<img align="left" width="415" height="200" src="https://i.imgur.com/a7DMq90.png">
<img align="right" width="415" height="200" src="https://i.imgur.com/MFWdwvO.png">
