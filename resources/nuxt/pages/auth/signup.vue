<template>
  <v-container fill-height>
    <!-- min-height: 80vh; -->
    <v-layout fill-height justify-center align-center>
      <v-flex xs12 sm8 md6 lg4 xl3>
        <v-card class="elevation-10 app-border-all-round">


          <v-toolbar card prominent>
            <v-layout class="display-1" justify-center>
                Регистрация
            </v-layout>
          </v-toolbar>
          <v-card-text>


            <socialite-buttons />


            <app-hr-text text="или" />

            <v-layout class="display-1" justify-center>
              <v-btn v-show="!showForm" @click="showForm = true" color="primary">
                Через почту
                <v-icon right>mail</v-icon>
              </v-btn>
            </v-layout>

            <!-- @submit.prevent="submit" @keydown.enter="submit" -->
            <form v-show="showForm" autocomplete="on">
              <v-alert :value="true" type="warning">
                Этот вариант требует обязательного подтверждения потчы для активации аккаунта!
              </v-alert>

              <signup-form v-model="form" :handler="submit" :captcha-loaded="captchaLoaded" />
              <!-- <div class="g-recaptcha" data-sitekey="6LdxzGAUAAAAAB-7jgghBCMhn4NPYJzcHLtV2QMN"></div> -->
            </form>


          </v-card-text>


          <div class="text-xs-center pb-3">
            <v-icon class="mr-1">directions_walk</v-icon>
            <nuxt-link to="/auth/signin">
              Уже регестрировались?
            </nuxt-link>
          </div>


        </v-card>
      </v-flex>
    </v-layout>


    <!-- <no-ssr>
      <script :src="`https://www.google.com/recaptcha/api.js?render=${captchaKey}`"></script>
    </no-ssr> -->

  </v-container>
</template>

<script>
import { mapActions } from 'vuex'
import AppHrText from '~/components/AppHrText'
import socialiteButtons from '~/components/auth/SocialiteButtons'
import SignupForm from '~/components/auth/SignupForm'

export default {
  middleware: 'guest',
  components: { AppHrText, socialiteButtons, SignupForm },
  data: () => ({
    showForm: false,
    form: {},
    // captchaResponse: null,
    captchaLoaded: false,
    captchaKey: '6LcpH18UAAAAAJ7IxDGeA4TtQdBDTYA4xL4QSkvA'
    // btnLoading: false
  }),
  methods: {
    async submit (captchaResponse) {
      let { data } = this.form
      // const k = '6LcpH18UAAAAAGlQkpW90lJIdwZjRdToblUBsoNc'
      // const data = await this.$axios.$post(`https://www.google.com/recaptcha/api/siteverify?secret=${k}&response=${this.captchaResponse}`)
      // console.log(data)
      //
      // if (await this.validateByMixin(data)) {
      // this.btnLoading = true
      // const captchaResponse = await window.grecaptcha.execute(this.captchaKey, {action: 'homepage'})

      // console.log(!!captchaResponse, data)
      await this.signup({ form: data, captchaResponse })
      // this.btnLoading = false
      // }
    },
    ...mapActions('auth', [
      'signup'
    ])
  },
  beforeMount () {
    window.onloadCallback = () => {
      this.captchaLoaded = true
      // window.grecaptcha.render('g-recaptcha', {
      //   sitekey: '6LdxzGAUAAAAAB-7jgghBCMhn4NPYJzcHLtV2QMN',
      //   callback: token => {
      //     alert(token)
      //   },
      //   theme: 'dark' // light
      // })
    }
  },
  // mounted () {
  // if (process.client) {
  //   window.grecaptcha.ready(() => {
  //     window.grecaptcha.execute(this.captchaKey, {action: 'homepage'}).then(token => {
  //       this.captchaResponse = token
  //       console.log(token)
  //       //
  //     })
  //   })
  // }
  // },
  // created () {
  //   if (window.grecaptcha) {
  //     window.grecaptcha.ready(() => {
  //       window.grecaptcha.execute(this.captchaKey, {action: 'homepage'}).then(token => {
  //         console.log(token)
  //         //
  //       })
  //     })
  //   }
  // },
  head () {
    return {
      title: 'Страница регестрации',
      meta: [
        { content: 'Это страница регестрации', name: 'description', hid: 'description' }
      ],
      script: [
        // { src: `https://www.google.com/recaptcha/api.js?render=${this.captchaKey}` }
        // Язык: &hl=uk
        // Ручной рендеринг &render=explicit
        { src: 'https://www.google.com/recaptcha/api.js?onload=onloadCallback', async: true, defer: true }
      ]
    }
  }
}
</script>
