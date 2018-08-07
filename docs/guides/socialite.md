# Socialite :busts_in_silhouette:

## Providers

Starter has such socialite providers:

| Name          | Admin dashboard                                                                                  |
| ------------- |:------------------------------------------------------------------------------------------------:|
| facebook      | [admin](https://developers.facebook.com/apps/)                                                   |
| google        | [admin](https://console.developers.google.com/projectselector/apis/dashboard)                    |
| instagram     | [admin](https://www.instagram.com/developer/clients/manage/)                                     |
| reddit     | [admin](https://www.reddit.com/prefs/apps)                                                          |
| vkontakte     | [admin](https://vk.com/apps?act=manage)                                                          |



<!-- - facebook [(admin)](https://developers.facebook.com/apps/)
- google [(admin)](https://console.developers.google.com/projectselector/apis/dashboard)
- instagram [(admin)](https://www.instagram.com/developer/clients/manage/)
- reddit [(admin)](https://www.reddit.com/prefs/apps)
- vkontakte [(admin)](https://vk.com/apps?act=manage) -->

::: tip
You can disable some providers if you remove them from seeds.
:::


## Setup
Set **providers keys**, **secrets**, **redirects** in .env

Redirect link must be of format below, `env('APP_CLIENT_URL')` will serve as a prefix.

> /auth/socialite/facebook


## Helpful links
- [Offical documentation](https://laravel.com/docs/5.6/socialite)
- [Socialite providers](https://socialiteproviders.github.io/)
