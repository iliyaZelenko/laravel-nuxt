import { msg } from '~/tools/helpers'

export default function ({ store, redirect, route, app }) {
  // If the user is not authenticated
  if (store.state.nuxtAuth.loggedIn) { // store.nuxtAuth.user
    msg.error(`Страница <b>${route.fullPath}</b> доступна только для гостей.`)
    return redirect('/profile/' + app.$auth.user.nickname) // '/profile/current-user'
  }
}
