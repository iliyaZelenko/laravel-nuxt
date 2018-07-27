import { msg } from '~/tools/helpers'
import { request } from '~/tools/Validator'

export const state = () => ({
  // list: []
})

export const mutations = {
  // add (state, text) {
  //   state.list.push({
  //     text: text,
  //     done: false
  //   })
  // },
  // toggle (state, todo) {
  //   todo.done = !todo.done
  // }
}

export const actions = {
  async signin ({ dispatch, commit }, payloads) {
    return request(async () => {
      await this.$auth.loginWith(payloads.strategy || 'local', {data: payloads.data}) // With('local',

      if (!payloads.dontShowSuccessMsg) {
        msg.success('Вход выполнен.')
        // msg({message: response.data.message, type: 'error'})
      }
      if (!payloads.dontRedirect) {
        this.$router.push('/profile/' + this.$auth.user.nickname)
      }
    })
  },
  /* eslint-disable */
  // вход используя токены и объект пользователя
  async signinManually ({ dispatch, commit }, { access_token, refresh_token, user }) {
    this.$auth.setToken('local', 'Bearer ' + access_token)
    this.$auth.setRefreshToken('local', refresh_token)
    this.$auth.setUser(user)
    // msg.success('Вход выполнен.')
  },
  /* eslint-enable */
  async signup ({ dispatch, commit }, payloads) {
    // обработка ошибок запроса регистрации
    return request(async () => {
      const { doAuth } = await this.$axios.$post('/api/auth/signup', payloads)

      // если через соц акк, то возвращает данные для входа
      if (payloads.userSoc) {
        return doAuth
      }
      // обработка ошибок запроса входа
      try {
        await dispatch('signin', {data: payloads.form, dontShowSuccessMsg: true})
        msg.success('Аккаунт создан.')
      } catch (e) {
        msg.warning('Аккаунт создан, но не удалось войти.')
      }
    })
  },
  async checkNicknameUnique ({ dispatch, commit }, nickname) {
    try {
      // данные с API
      const { unique } = await this.$axios.$post('/api/check-nickname', { nickname })

      return unique
    } catch (e) {
      // если ошибка API, то уникальность неопределена
      return null
    }
  },
  async resetPasswordSendEmail ({ dispatch, commit }, data) {
    // try {
    return request(async () => {
      let resetRoute = this.$router.resolve({
        name: 'auth-reset-password-token-email'
      })
      // нужно для генерации ссылки в почту
      let port = location.port ? (':' + location.port) : ''
      let resetUrl = location.protocol + '//' + location.hostname + port + resetRoute.href

      const { message } = await this.$axios.$post('/api/auth/reset-password-email', { ...data, resetUrl })
      msg.success(message)
      // return true
    }) // , { throwErr: true }
    // } catch (e) {
    //   return false
    // }
    // } catch ({ response }) {
    //   if (response.status === 422) {
    //     // почему-то иногда почта не подходит в laravel, но подходит в браузере
    //     // serverValidatorShowErrors(response)
    //   } else {
    //     msg.error(response.data.message)
    //   }
    //
    //   return false
    // }
  },
  async resetPassword ({ dispatch, commit }, data) {
    return request(async () => {
      const { message } = await this.$axios.$post('/api/auth/reset-password', data)

      // обработка ошибок запроса входа
      // try {
      await dispatch('signin', {data, dontShowSuccessMsg: true})
      msg.success(message)
      // } catch (e) {
      //   msg.warning('Пароль был сброшен, но не удалось войти.')
      //   this.$router.push('/auth/signin')
      // }
    })
  },
  async repeatVerificationMail ({ dispatch, commit }, id) {
    return request(async () => {
      await this.$axios.$post('/api/auth/repeat-verification-mail', { id })
      msg.success('Сообщение отправлено.')
    })
  },
  async verifyEmail ({ dispatch, commit }, token) {
    return request(async () => {
      const user = await this.$axios.$post('/api/auth/verify', { token })
      msg.success('Эл. адрес подтвержден!')
      this.$auth.setUser(user)
      this.$router.push(this.$auth.loggedIn ? '/profile/settings/emails' : '/auth/signin')
    })
  }
}
