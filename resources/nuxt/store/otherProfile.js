// import { msg } from '~/tools/helpers'
// import { request } from '~/tools/Validator'

export const actions = {
  async getUser ({ dispatch, commit }, nickname) {
    // try {
    // return request(async () => { const user =
    return this.$axios.$post('/api/profile/other/get-user', { nickname })
    // return user
    // }, { ifCathThenReturn: null }) // throwErr: true
    //
    //   return user
    // } catch ({ response }) {
    //   return null
    // }
  }
}
