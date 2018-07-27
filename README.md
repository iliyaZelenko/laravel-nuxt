# Laravel Nuxt Auth Starter DEMO

I'm ready to fix all mistakes and i want to make it as cool as possible.
Project in Russian, but if you are interested yo can put a star, i can translate everything into English.

## Features

- Laravel 5.6, Nuxt 1.4
- SSR or SPA (easy switch and development)
- Authentication with Laravel Passport and [@nuxtjs/auth](https://github.com/nuxt-community/auth-module)
- Socialite integration
- Vuetify + Font Awesome icons(A la Carte + vue integration)
- Login, register, password reset, profile, settings
- **And many others (detailed description will be soon)**

## Installation

1. `cp .env .env.example`
2. `composer install`
3. Edit **.env** to set your database connection details
4. `php artisan migrate`
5. for recaptcha set **RECAPTCHA_SECRET**(used only in registration)
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


<img align="left" width="315" height="200" src="https://i.imgur.com/9rDip2L.png">
<img align="right" width="315" height="200" src="https://i.imgur.com/2mWCW9w.png">

<img align="left" width="315" height="200" src="https://i.imgur.com/WCqVvJe.png">
<img align="right" width="315" height="200" src="https://i.imgur.com/yREueWw.png">

<img align="left" width="315" height="200" src="https://i.imgur.com/xgFSMDu.png">
<img align="right" width="315" height="200" src="https://i.imgur.com/QhEjkU7.png">
