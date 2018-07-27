import { msg } from '~/tools/helpers'
import { request } from '~/tools/Validator'

// export const state = () => ({
//   socAccounts: [
//     {
//       name: 'vkontakte',
//       nameForHuman: 'Вконтакте',
//       icon: 'vk',
//       color: 'blue darken-2',
//       textColor: 'blue--text text--darken-2'
//     },
//     {
//       name: 'facebook',
//       nameForHuman: 'Facebook',
//       icon: 'facebook',
//       color: 'indigo'
//     },
//     {
//       name: 'google',
//       nameForHuman: 'Google+',
//       icon: 'google-plus', // fa-
//       color: 'red'
//     },
//     {
//       name: 'instagram',
//       nameForHuman: 'Instagram',
//       icon: 'instagram', // fa-
//       color: 'blue'
//     },
//     {
//       name: 'reddit',
//       nameForHuman: 'Reddit',
//       icon: 'reddit', // fa-
//       color: 'deep-orange darken-2',
//       textColor: 'deep-orange--text text--darken-2'
//     }
//     // {
//     //   name: 'twitter',
//     //   nameForHuman: 'Twitter',
//     //   icon: 'twitter', // fa-
//     //   color: 'light-blue'
//     // }
//   ]
// })

export const mutations = {}

export const actions = {
  async getRedirectUrl ({ dispatch, commit }, providerName) {
    const { redirectUrl } = await this.$axios.$post('/api/auth/soc/get-redirect-url', { providerName })

    return redirectUrl
  },

  async getUserSocialite ({ dispatch, commit }, payloads) {
    return this.$axios.$post('/api/auth/soc/get-soc-user', payloads)
  },

  async saveSocAcc ({ dispatch, commit }, payloads) {
    const result = await request(async () => {
      const user = await this.$axios.$post('/api/auth/soc/save-soc-acc', payloads)

      this.$auth.setUser(user)
      this.$router.push('/profile/settings/soc-accounts')
      msg.success(`Аккаунт ${payloads.providerName} успешно прикреплен!`)
    })

    if (!result) {
      this.$router.push('/profile/settings/soc-accounts')
    }

    return result
  },

  async deleteSocAcc ({ dispatch, commit }, { name, id }) {
    return request(async () => {
      const user = await this.$axios.$post('/api/auth/soc/delete-soc-acc', { id })

      this.$auth.setUser(user)
      msg.success(`Аккаунт ${name} успешно откреплен!`)
    })
  }
}
