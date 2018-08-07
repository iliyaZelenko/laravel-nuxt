<template>
  <v-container fill-height>
    <!-- <v-layout v-if="!user || saveSocAccLoading" fill-height justify-center align-center> -->
    <v-alert :value="!user || saveSocAccLoading" type="info" class="display-1 text-xs-center">
      <template v-if="!user">
        Получаем данные о Вас...
      </template>
      <template v-if="saveSocAccLoading">
        Сохраняем в ваши прикрепленные аккаунты...
      </template>
    </v-alert>
    <!-- </v-layout> -->

    <v-layout v-if="!$auth.loggedIn && user && !userSocResponse.doAuth" fill-height justify-center align-center>
      <v-flex xs12 sm8 md6 lg4 xl3>

        <v-card class="elevation-10">
          <v-card-text>

            <div class="display-1 text-xs-center mb-3">
              Последний шаг
            </div>

            <!-- <pre>{{ userSocResponse }}</pre> -->

            <!--<alert :value="!haveEmail" type="info">-->
              <!--Не удалось получить вашу почту, пожалуйста, введите.-->
            <!--</alert>-->

            <form @submit.prevent="submitNewUser" @keydown.enter="submitNewUser" autocomplete="on">
              <signup-form v-model="form" :handler="submitNewUser" soc-auth validate-on-start />
            </form>

          </v-card-text>
          <!-- <v-card-actions class="px-3 pb-3">
            <v-btn
              @click="submitNewUser"
              color="primary"
              :loading="formLoading"
              :disabled="form.btnDisabled"
              large block
            >
              Создать аккаунт
            </v-btn>
          </v-card-actions> -->
        </v-card>

      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'
import SignupForm from '~/components/auth/SignupForm'

export default {
  components: { SignupForm },
  data: () => ({
    form: {},
    userSocResponse: null,
    haveEmail: null,
    saveSocAccLoading: false
    // formLoading: false
  }),
  methods: {
    // отправка формы создания нового юзера для соц сети
    async submitNewUser () {
      // TODO Тут просто как и в signup странице, но передать данные о UserSoc
      const { data } = this.form
      // let dataForValidate = this.form.data
      //
      // // если не выбран вход через пароль и почту/ник
      // if (!this.form.passwordVariantAuthChoose) {
      //   const { nickname } = this.form.data
      //   dataForValidate = { nickname }
      // }
      //
      // console.log(dataForValidate)
      //
      // if (await this.validateByMixin(dataForValidate)) {
      // this.formLoading = true
      // alert('ok')
      const doAuth = await this.signup({
        form: data,
        userSoc: this.user,
        providerName: this.providerName
      })

      // вход используя токены и объект пользователя
      await this.signinManually(doAuth)

      this.$notify.success(`Аккаунт создан через ${this.providerName}.`)
      // this.formLoading = false
      // }
    },
    async justSignIn () {
      const info = this.userSocResponse.doAuth
      // вход используя токены и объект пользователя
      await this.signinManually(info)
      this.$notify.success(`Вход через ${this.providerName} выполнен.`)
      this.$router.push('/profile/' + info.user.nickname)
    },
    checkAccessDenied () {
      const error = this.$route.query.error
      if (error) {
        if (error === 'access_denied') {
          this.$notify.error('Доступ отклонен')
          this.$router.push(this.$auth.loggedIn ? '/profile/settings/soc-accounts' : '/auth/signin')
        } else {
          // в теории никаких еще ошибок не должно произойти
          this.$notify.error(error)
        }
      }
    },
    ...mapActions('authSocialite', [
      'getUserSocialite', 'saveSocAcc' // 'loginSocialite', 'handleSocialite',
    ]),
    ...mapActions('auth', [
      'signup', 'signinManually'
    ])
  },
  computed: {
    code () {
      return this.$route.query.code
    },
    providerName () {
      return this.$route.params.providerName
    },
    user () {
      return this.userSocResponse && this.userSocResponse.user
    }
  },
  async mounted () {
    this.checkAccessDenied()

    const providerName = this.providerName
    const code = this.code
    const payloads = {code, providerName, loggedIn: this.$auth.loggedIn}

    try {
      this.userSocResponse = await this.getUserSocialite(payloads)

      if (this.$auth.loggedIn) {
        this.saveSocAccLoading = true
        await this.saveSocAcc({
          userSoc: this.user,
          providerName
        })
      } else {
        // если акк прикреплен к юзеру из соц сети
        if (this.userSocResponse.doAuth) {
          this.justSignIn()
        } else { // если акк не прикреплен ни какому юзеру, то юзеру нужно заполнить форму регестрации и отправить запрос на регестрацию где ему прикрепят соц акк
          const { email, nickname } = this.user
          // ставит данные в форму из соц акка, сделал чтобы не ставились лишние свойства
          this.form.data = { email, nickname }
          this.haveEmail = !!email
        }
      }
    } catch ({ response }) {
      const status = response.status

      if (status === 401 || status === 400) {
        this.$notify.error(response.data.message)
        this.$router.push(this.$auth.loggedIn ? '/profile/settings/soc-accounts' : '/auth/signin')
      }
    }
  }
}
</script>
