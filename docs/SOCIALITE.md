# Socialite

Starter has such socialite providers:
- facebook [(admin)](https://developers.facebook.com/apps/)
- google [(admin)](https://console.developers.google.com/projectselector/apis/dashboard)
- instagram [(admin)](https://www.instagram.com/developer/clients/manage/)
- reddit [(admin)](https://www.reddit.com/prefs/apps)
- vkontakte [(admin)](https://vk.com/apps?act=manage)

you can disable some providers if you remove them from seeds


## Setup
Set **providers keys**, **secrets**, **redirects** in .env

Redirect link must be of this format:

> /auth/socialite/facebook

[Offical documentation](https://laravel.com/docs/5.6/socialite)
