# Configuration :wrench:

[[toc]]

## SSR
1. Set .env `APP_CLIENT_MODE=srr`
2. Set client url `APP_CLIENT_URL` and api `APP_URL`

For start production ssr server run `yarn ssr` / `npm run ssr`

## SPA (default setup)
1. Set .env `APP_CLIENT_MODE=spa`
2. Set same client url `APP_CLIENT_URL` and api `APP_URL`

For production build run `yarn build-spa` / `npm run build-spa`  
To see production version run `php artisan serve`


## Development in SPA

1. Setup SPA
2. Run `yarn dev` / `npm run dev`  
