import { msg } from '~/tools/helpers'
import { request } from '~/tools/Validator'

export const actions = {
  async setPassword ({ dispatch, commit }, data) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/set-password', data)
      this.$auth.setUser(user)
      msg.success(data.password ? 'Пароль добавлен.' : 'Пароль изменен.')
    })
  },

  async setUserData ({ dispatch, commit }, data) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/set-user-data', data)
      this.$auth.setUser(user)
      msg.success('Данные успешно сохранены.')
    })
  },

  async saveEmail ({ dispatch, commit }, data) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/save-email', data)
      this.$auth.setUser(user)
      msg.success('Сохранено.')
    })
  },

  async deleteEmail ({ dispatch, commit }, data) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/delete-email', data)
      this.$auth.setUser(user)
      msg.success('Удалено.')
    })
  },

  async setMainEmail ({ dispatch, commit }, data) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/set-main-email', data)
      this.$auth.setUser(user)
      msg.success('Сохранено.')
    })
  },

  async changePublicStateEmail ({ dispatch, commit }, email) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/change-public-email', {
        id: email.id,
        public: !email.public
      })
      this.$auth.setUser(user)
      msg.success('Сохранено.')
    })
  },

  async getPasswordsHistory ({ dispatch, commit }) {
    return this.$axios.$post('/api/profile/current/get-passwords-history')
  },

  async savePhone ({ dispatch, commit }, data) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/save-phone', data)
      this.$auth.setUser(user)
      msg.success('Сохранено, ждите смс.')
    })
  },

  async deletePhone ({ dispatch, commit }, data) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/delete-phone', data)
      this.$auth.setUser(user)
      msg.success('Удалено.')
    })
  },

  async setMainPhone ({ dispatch, commit }, data) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/set-main-phone', data)
      this.$auth.setUser(user)
      msg.success('Сохранено.')
    })
  },

  async changePublicStatePhone ({ dispatch, commit }, phone) {
    return request(async () => {
      const user = await this.$axios.$post('/api/profile/current/change-public-phone', {
        id: phone.id,
        public: !phone.public
      })
      this.$auth.setUser(user)
      msg.success('Сохранено.')
    })
  },

  async repeatVerificationPhone ({ dispatch, commit }, id) {
    msg.success('Смс отправлено.')
  }
}
