<template>
  <v-container fill-height>
    <v-layout fill-height justify-center align-center>
      <v-flex xs12 sm8 md6 lg4 xl3>
        <v-card class="elevation-10 app-border-all-round">
          <v-toolbar card prominent>
            <v-layout class="display-1" justify-center>
              Вход
            </v-layout>
          </v-toolbar>
          <v-card-text>
            <!-- <div class="display-1 text-xs-center mb-3">
              Вход
            </div> -->


            <v-alert type="error" :value="$auth.$state.redirect">
              Чтобы посетить <b>{{ $auth.$state.redirect }}</b> Вам нужно войти.
            </v-alert>


            <socialite-buttons />


            <app-hr-text text="или" />

            <!-- <v-alert :value="error" type="error">
              {{ error }}
            </v-alert> -->
            <!-- <v-btn @click="google">Google</v-btn> -->


            <form @submit.prevent="submit" @keydown.enter="submit" autocomplete="on">
              <!-- <v-layout align-center justify-center> -->
                <v-radio-group v-model="emailOrNickname" row>
                  <v-layout justify-space-around>
                    <v-radio label="Через почту" value="email" class="mr-0" />
                    <v-radio label="Через ник" value="nickname" class="mr-0" />
                  </v-layout>
                </v-radio-group>
              <!-- </v-layout> -->


              <v-text-field
                v-show="emailOrNickname === 'email'"
                v-model="form.email"
                type="email"
                label="Почта"
                :error-messages="errors.collect('email')"
                v-validate="'required|' + validatorRules.email"
                data-vv-name="email"
                prepend-icon="mail"
                required
                box
              />


              <v-text-field
                v-show="emailOrNickname === 'nickname'"
                v-model="form.nickname"
                v-validate="validatorRules.nickname"
                :error-messages="errors.collect('nickname')"
                :counter="nicknameMaxSymbols"
                data-vv-name="nickname"
                prepend-icon="person"
                label="Ник"
                required
                box
              />


              <v-text-field
                v-model="form.password"
                v-validate="validatorRules.password"
                :error-messages="errors.collect('password')"
                :type="passwordShow ? 'text' : 'password'"
                :append-icon="passwordShow ? 'visibility_off' : 'visibility'"
                @click:append="passwordShow = !passwordShow"
                data-vv-name="password"
                prepend-icon="security"
                label="Пароль"
                required
                box
              />


              <!-- <v-checkbox
                v-model="form.remember"
                label="Запомнить меня"
                type="checkbox"
              ></v-checkbox> -->
            </form>


          </v-card-text>
          <v-card-actions class="px-3 pb-3">

            <!-- class="ml-3" -->


            <!-- <v-spacer /> -->




            <v-btn
              @click="submit"
              :loading="loadingBtn"
              :disabled="btnDisabled"
              color="primary"
              large block
            >
              <v-icon left>directions_walk</v-icon>
              Войти
              <!-- vpn_key -->
            </v-btn>
          </v-card-actions>

          <div class="text-xs-center pb-3">
            <v-icon class="mr-1">help</v-icon>
            <nuxt-link to="/auth/forgot-password">
              Забыли пароль?
            </nuxt-link>

            <span class="mx-3"></span>

            <v-icon class="mr-1">person_add</v-icon>
            <nuxt-link to="/auth/signup">
              Создать аккаунт
            </nuxt-link>
          </div>

        </v-card>




      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import { mapActions } from 'vuex'
  import validatorMixin from '~/mixins/validator'
  import { nicknameMaxSymbols } from '~/tools/Validator'
  import socialiteButtons from '~/components/auth/SocialiteButtons'
  import AppHrText from '~/components/AppHrText'
  // import groupBy from 'lodash/groupBy'

  export default {
    middleware: 'guest',
    mixins: [validatorMixin],
    components: { socialiteButtons, AppHrText },
    data: () => ({
      form: {
        email: 'iliyazelenkog@gmail.com',
        nickname: 'Ilya-Zelenko',
        password: 'secret'
      },
      emailOrNickname: 'email',
      passwordShow: true,
      loadingBtn: false,
      nicknameMaxSymbols
      // error: false
    }),
    methods: {
      async submit () {
        const data = {
          password: this.form.password,
          [this.emailOrNickname]: this.form[this.emailOrNickname]
        }

        console.log(data)

        if (await this.validateByMixin(data)) {
          this.loadingBtn = true
          await this.signin({ data })
          this.loadingBtn = false
        }
      },
      ...mapActions('auth', [
        'signin'
      ])
    },
    computed: {
      formErrors () {
        return this.errors.items.filter(i => i.field === this.emailOrNickname || i.field === 'password')
      },
      btnDisabled () {
        return !!this.formErrors.length
      }
    },
    head () {
      return {
        title: 'Страница входа',
        meta: [
          { content: 'Это страница входа', name: 'description', hid: 'description' }
        ]
      }
    }
  }
  </script>
