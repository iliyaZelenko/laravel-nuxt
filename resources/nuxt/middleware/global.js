import axios from 'axios'

export default async function ({ req, app }) {
  if (!app.$cookies.get('guest-timezone') || !app.$cookies.get('uest-country')) {
    // const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone
    const info = (await axios.get('https://ipapi.co/json/')).data
    const { country, timezone } = info
    const maxAge = 60 * 60 * 24 * 7

    app.$cookies.set('guest-timezone', timezone, { maxAge })
    app.$cookies.set('guest-country', country, { maxAge })
    app.$cookies.set('guest-all-info', info, { maxAge })
  }
}
