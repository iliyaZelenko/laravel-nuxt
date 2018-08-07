module.exports = {
  title: 'Laravel Nuxt Auth Starter DEMO',
  description: 'Laravel + Nuxt.js',
  layout: 'SpecialLayout',
  base: '/laravel-nuxt/',
  // head: [
  //   ['link', { rel: 'icon', href: `/logo.png` }
  // ],
  themeConfig: {
    // lastUpdated: 'Last Updated', // string | boolean
    // search: false,
    // sidebar: [
    //   '/',
    //   '/foo',
    //   ['/socialite', 'Explicit link text']
    // ],
    sidebar: [
      // {
      //   title: 'Group 1',
      //   // collapsable: false,
      //   children: [
      // '/',
      '/features/',
      {
        title: 'Guides',
        collapsable: false,
        children: [
          '/guides/installation', // , 'Installation']
          '/guides/configuration',
          '/guides/socialite' // , 'Socialite'],
        ]
      },
      '/bugs/',
      '/todo/',
      // '/guides/',
      // '/socialite/', // ['/socialite/', 'Socialite']
      // [
      // {
      //   title: 'Group 2',
      //   children: [
      //     ['/socialite/', 'Socialite'],
      //     // ['/socialite', 'Explicit link text']
      //   ]
      // }
        // '',     /* /foo/ */
        // 'index'  /* /foo/one.html */
        // 'two'   /* /foo/two.html */
      // ],
      // ['/page/index', 'Page']
      // ['/socialite', 'Explicit link text']
      // ['/2', 'Socialite'],
      //   ]
      // },
      // {
      //   title: 'Group 2',
      //   children: [
      //     '/',
      //     // ['/socialite', 'Explicit link text']
      //   ]
      // }
    ],
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Docs', link: '/features/' },
      // { text: 'Installation', link: '/guides/installation' },
      // { text: 'Configuration', link: '/guides/configuration' },
      { text: 'Github', link: 'https://github.com/iliyaZelenko/laravel-nuxt' },
      // { text: 'Bugs', link: '/bugs/' },
      // { text: 'Todo', link: '/todo/' },
      // {
      //   text: 'Guides',
      //   items: [
      //     { text: 'Installation', link: '/guides/installation' },
      //     { text: 'Configuration', link: '/guides/configuration' },
      //     { text: 'Socialite', link: '/guides/socialite' }
      //   ]
      // },
      {
        text: 'Languages',
        items: [
          { text: 'English', link: '/language/en' },
          { text: 'Русский', link: '/language/ru' }
        ]
      }
    ]
  }
}
