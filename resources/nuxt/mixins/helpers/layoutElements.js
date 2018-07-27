import { mapGetters } from 'vuex'

const prefix = 'mixinslayoutElements_' // префикс $_ не работает как писали в советах стиля, компонент не видит переменную, это очень странно, разбирался с эти 30-60 мин

// !!! Те у которых префикс $_ ($ и _ тоже вроде) не проксируются, поэтмоу к ним нужно обращатся напрямую через $data и еще они что-то не реактивны по видимому
export default {
  data: () => ({
    [prefix + 'appToolbarEl']: '.app-toolbar',
    [prefix + 'appContentEl']: '.v-content__wrap',
    [prefix + 'emailVerificationAlertUnderToolbarEl']: '.email-verification-alert_under-toolbar',
    [prefix + 'profileSettingsToolbar']: '.profile-settings__toolbar',
    [prefix + 'profileSettingsNavigationDrawerParent']: '.profile-settings__navigation-drawer-parent',
    [prefix + 'profileSettingsNavigationDrawer']: '.profile-settings__navigation-drawer'
  }),
  methods: {

    [prefix + 'appToolbarGetHeight'] () {
      return document.querySelector(this[prefix + 'appToolbarEl']).offsetHeight + 'px'
    },

    [prefix + 'appContentSetDynamicStyles'] () {
      const content = document.querySelector(this[prefix + 'appContentEl'])
      const alertUnderToolbar = document.querySelector('.email-verification-alert_under-toolbar')

      content.style.paddingTop = this[prefix + 'appToolbarGetHeight']()

      // /profile/settings
      // отступ для алерта под тулбаром
      if (!this.$route.path.includes('profile/settings') && (
        (this.$route.path.includes('profile') && this.$vuetify.breakpoint.smAndDown) || // делать отступ в профиле если smAndDown
        (!this.$route.path.includes('profile')) // не делать отступ в настройках    && !this.$route.path.includes('profile/settings')              !this.$route.path.includes('profile/settings') &&
      ) && content && alertUnderToolbar) { // если есть элементы
        if (this.userHaveGlobalMessage()) {
          const toolbarHeight = alertUnderToolbar.offsetHeight || 85

          content.style.paddingTop = `${parseInt(content.style.paddingTop) + toolbarHeight}px` // parseInt(toolbar.style.top) +
        }
      }
    },

    [prefix + 'emailVerificationAlertUnderToolbarSetTop'] () {
      const toolbar = document.querySelector(this[prefix + 'appToolbarEl'])
      const alert = document.querySelector(this[prefix + 'emailVerificationAlertUnderToolbarEl'])

      if (alert && toolbar) {
        alert.style.top = toolbar.offsetHeight + 'px'
      }
    },

    [prefix + 'profileInterfaceSetStyles'] () {
      const toolbar = document.querySelector(this[prefix + 'profileSettingsToolbar'])
      const drawerParent = document.querySelector(this[prefix + 'profileSettingsNavigationDrawerParent'])
      const drawer = document.querySelector(this[prefix + 'profileSettingsNavigationDrawer'])

      // ставит ширину как у родителя(v-flex)
      drawer.style.setProperty('width', drawerParent.clientWidth + 'px', 'important')

      if (this.$vuetify.breakpoint.mdAndUp) {
        const drawerWidth = this[prefix + 'profileSettingsGetFixedNavigationDrawerWidth']()
        toolbar.style.marginLeft = drawerWidth
        toolbar.style.width = `calc(100% - ${drawerWidth})`

        if (document.querySelector(this[prefix + 'appToolbarEl'])) {
          toolbar.style.top =
            drawer.style.top =
              this[prefix + 'appToolbarGetHeight']()
        }
      } else {
        toolbar.style.marginLeft =
          toolbar.style.width =
            toolbar.style.top =
              drawer.style.top =
                null
      }
    },

    [prefix + 'profileSettingsGetFixedNavigationDrawerWidth'] () {
      const el = document.querySelector(this[prefix + 'profileSettingsNavigationDrawer'])

      return (el ? el.offsetWidth : 280) + 'px'
    }
  },
  computed: {
    ...mapGetters('user', ['userHaveGlobalMessage'])
  }
}
