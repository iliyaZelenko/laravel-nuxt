// import * as Cookie from 'js-cookie'

export const state = () => ({
  sidebar: false
})

export const mutations = {
  toggleSidebar (state) {
    state.sidebar = !state.sidebar
  }
}

export const actions = {
  // async nuxtServerInit ({ app }) {
  // if (!Cookie.get('guest-timezone') || !Cookie.get('uest-country')) {
  // const a = JSON.parse(await app.$axios.get('http://ip-api.com/json')) // { timezone, countryCode }
  // console.log(a)
  // Cookie.set('guest-timezone', timezone, {expires: 7})
  // Cookie.set('guest-country', countryCode, {expires: 7})
  // },
  getTimezones () {
    return this.$axios.$get('/api/timezones')
  },
  getCountries () {
    return this.$axios.$get('/api/countries')
  },
  getPhonePrefixes () {
    return this.$axios.$get('/api/phone-prefixes')
  },
  getSocialiteProviders () {
    return this.$axios.$get('/api/socialite-providers')
  }
}
