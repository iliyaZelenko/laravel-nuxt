// import { serverValidatorShowErrors, msg } from '~/tools/helpers'
// export const state = () => ({
//   list: this.$auth.user
// })

// export const mutations = {
// add (state, text) {
//   state.list.push({
//     text: text,
//     done: false
//   })
// },
// toggle (state, todo) {
//   todo.done = !todo.done
// }
// }
// console.log(store)
// const defaultUser = this

// console.log(defaultUser)

export const getters = {
  userAvatar: (state, getters, store) =>
    (user = store.nuxtAuth.user, sizeName) =>
      user.avatar[sizeName],
  // typeof user.avatar === 'string' ? user.avatar : user.avatar[sizeName], // || require('~/assets/no-avatar.png')
  // userFullName: (state, getters, store) =>
  //   (user = store.nuxtAuth.user) =>
  //     user.firstName && user.lastName ? user.firstName + ' ' + user.lastName : null,
  userCanUseEmail: (state, getters, store) =>
    (user = store.nuxtAuth.user) =>
      user && user.mainEmail && user.mainEmail.verified,
  // то чно ниже это !$auth.user.activated
  userHaveGlobalMessage: (state, getters, store) =>
    (user = store.nuxtAuth.user) =>
      user && (!user.mainEmail || !user.mainEmail.verified || !user.activated)
}

// export const actions = {}
