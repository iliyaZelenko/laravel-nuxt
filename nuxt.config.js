require('dotenv').config()
const spa = require('laravel-nuxt')


const commonConfig = {
  env: {
    // you can access env file via process.env
    localeDefault: 'ru', // (example: process.env.CLIENT_LOCALE_DEFAULT)
    avatarSizes: {
      lg: 320,
      md: 200,
      sm: 133
    },
    dateFormats: {
      main: 'YYYY-MM-DD', // DD.MM.YYYY
      datetime: 'YYYY-MM-DD HH:mm:ss'
    }
  },

  router: {
    middleware: 'global'
  },

  /*
  ** Headers of the page
  */
  head: {
    title: 'Заголовок',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Описание' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' }
    ]
  },

  plugins: [
    { src: '~/plugins/vuetify' },
    { src: '~/plugins/vee-validate' },
    { src: '~/plugins/fontawesome' },
    { src: '~/plugins/vue-notifications', ssr: false },
    { src: '~/plugins/vuex-shared-mutations.js', ssr: false },
    // { src: '~/plugins/ga.js', ssr: false },
    { src: '~/plugins/dayjs.js' },
    { src: '~/plugins/filters.js' }
  ],

  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth',
    ['@nuxtjs/dotenv', { path: './'}],
    'cookie-universal-nuxt'
  ],

  css: [
    '~/styles/app.styl'
    // { src: 'flag-icon-css/css/flag-icon.min.css', lang: 'css' }
  ],

  loading: {
    color: '#1976D2',
    height: '4px'
  },

  loadingIndicator: '~/layouts/loading.html',
  // loadingIndicator: {
  //   name: 'cube-grid' // 'folding-cube'
  // },

  /*
   ** Авторизация
   */
  auth: {
    vuex: {
      namespace: 'nuxtAuth'
    },
    strategies: {
      local: {
        endpoints: {
          login: { url: '/api/auth/login', method: 'post', propertyName: 'access_token' },
          logout: { url: '/api/auth/logout', method: 'post' },
          user: { url: '/api/auth/user', method: 'get', propertyName: 'user' }
        }
      }
    },
    redirect: {
      login: '/auth/signin',
      callback: '/auth/signin',
      // home: false,
      logout: '/' // возможно логичней не перенаправлять(false)
      // user: После входа идет перенаправление на прошлый роут
    }
  },

  generate: {
    routes: [
      '/auth/socialite/google',
      '/auth/socialite/facebook',
      '/auth/socialite/vkontakte',
      '/auth/socialite/instagram',
      '/auth/socialite/reddit'
      // '/auth/reset-password/_token/_email'
    ]
  },

  /*
  ** Build configuration
  */
  build: {
    vendor: [
      'vuetify', // ~/plugins/ and .js
      'vee-validate',
      'vue-izitoast',
      'vue-notifications',
      '@fortawesome/fontawesome'
    ],
    extractCSS: true,
    /*
    ** Run ESLint on save
    */
    extend (config, { isDev, isClient }) {
      if (isDev && isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  }
}

// generate spa config
const spaModeConfig = spa(commonConfig)

// universa(ssr) config
const universalModeConfig = {
    ...commonConfig,
    mode: 'universal', // (ssr)
    srcDir: 'resources/nuxt',
    generate: {
        dir: 'storage/app/nuxt'
    },
    axios: {
        browserBaseURL: process.env.APP_URL,
        baseURL: process.env.APP_URL // api url 'http://127.0.0.1:8000'
    }
}


if (process.env.APP_CLIENT_MODE === 'ssr') {
    module.exports = universalModeConfig
} else {
    module.exports = spaModeConfig
}




















//
// module.exports = {
//   mode: 'spa', // spa
//
//   env: {
//     avatarSizes: {
//       lg: 320,
//       md: 200,
//       sm: 133
//     },
//     dateFormats: {
//       main: 'YYYY-MM-DD' // DD.MM.YYYY
//     }
//   },
//   /*
//   ** Headers of the page
//   */
//   head: {
//     title: 'Заголовок',
//     meta: [
//       { charset: 'utf-8' },
//       { name: 'viewport', content: 'width=device-width, initial-scale=1' },
//       { hid: 'description', name: 'description', content: 'Описание' }
//     ],
//     // script: [
//     //   { src: 'js-cookie' }
//     // ],
//     link: [
//       { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
//       { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' }
//     ]
//   },
//   // plugins: [
//   //   '~/plugins/vuetify.js',
//   //   '~/plugins/vee-validate.js'
//   // ],
//   plugins: [
//     { src: '~/plugins/vuetify' },
//     { src: '~/plugins/vee-validate' }, // , ssr: false izitoast
//     { src: '~/plugins/fontawesome' }, // , ssr: true
//     { src: '~/plugins/vue-notifications', ssr: false },
//     // { src: '~/plugins/vue-affix', ssr: false },
//     { src: '~/plugins/vuex-shared-mutations.js', ssr: false },
//     { src: '~/plugins/dayjs.js' },
//     { src: '~/plugins/filters.js' }
//   ],
//   modules: [
//     '@nuxtjs/axios',
//     '@nuxtjs/auth'
//   ],
//   css: [
//     '~/styles/app.styl'
//     // { src: 'flag-icon-css/css/flag-icon.min.css', lang: 'css' }
//     // 'flag-icon-css'
//   ],
//   /*
//   ** Customize the progress bar color
//   */
//   loading: { color: '#3B8070' },
//   /*
//    ** Авторизация
//    */
//   auth: {
//     vuex: {
//       namespace: 'nuxtAuth'
//     },
//     strategies: {
//       local: {
//         endpoints: {
//           login: { url: '/api/auth/login', method: 'post', propertyName: 'access_token' },
//           logout: { url: '/api/auth/logout', method: 'post' },
//           user: { url: '/api/auth/user', method: 'get', propertyName: 'user' }
//         }
//       },
//       google: {
//         client_id: '418799322900-b4t9dd0gqqf7cp0gfvb99pjf405ftist.apps.googleusercontent.com'
//       }
//     },
//     redirect: {
//       login: '/auth/signin',
//       callback: '/auth/signin', // TODO сделать красивую страницу
//       // home: false,
//       logout: '/' // возможно логичней не перенаправлять(false)
//       // home: Надо: '/profile/' + $auth.user.nickname Но стоит: '/profile/current-user' // user После входа идет перенаправление на прошлый роут
//     }
//   },
//   axios: {
//     https: true,
//     // proxy: true
//     browserBaseURL: 'https://ilyaz.herokuapp.com/',
//     baseURL: 'https://ilyaz.herokuapp.com/'
//   },
//   proxy: {
//     // '/api': 'https://ilyaz.herokuapp.com/',
//     '/api': 'http://127.0.0.1:8000/'
//   },
//   /*
//   ** Build configuration
//   */
//   build: {
//     vendor: [
//       'vuetify', // ~/plugins/ and .js
//       'vee-validate',
//       'vue-izitoast',
//       'vue-notifications',
//       '@fortawesome/fontawesome',
//       'js-cookie'
//     ],
//     extractCSS: true,
//     /*
//     ** Run ESLint on save
//     */
//     extend (config, ctx) {
//       if (ctx.isDev && ctx.isClient) {
//         config.module.rules.push({
//           enforce: 'pre',
//           test: /\.(js|vue)$/,
//           loader: 'eslint-loader',
//           exclude: /(node_modules)/
//         })
//       }
//     }
//   }
// }
