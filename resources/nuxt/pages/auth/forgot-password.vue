<template>
  <v-container fill-height>
    <v-layout fill-height justify-center align-center>
      <v-flex xs12 sm8 md6 lg4 xl3>


        <v-alert :value="sent" type="info">
          Эта страница уже не нужна, перейдите по ссылке в сообщении.
        </v-alert>


        <v-card v-show="!sent" class="elevation-10 app-border-all-round">
          <v-toolbar card prominent>
            <v-layout class="display-1" justify-center>
                Сброс пароля
            </v-layout>
          </v-toolbar>
          <v-card-text>


            <v-btn
              :to="$auth.loggedIn ? '/profile/settings/password' : '/auth/signin'"
              color="primary"
              small
              flat
            >
              <v-icon left>arrow_back</v-icon>
              Назад
            </v-btn>


            <!-- <div class="display-1 text-xs-center mb-3">
              Сброс пароля
            </div> -->

            <template v-if="$auth.user">
              <v-alert :value="!$auth.user.mainEmail" type="warning" class="mb-3">
                Для продолжения Вы должны добавить почту.
                <v-btn to="/profile/settings/emails">
                  <v-icon left>add</v-icon>
                  Добавить
                </v-btn>
              </v-alert>
              <v-alert :value="$auth.user.mainEmail && !$auth.user.mainEmail.verified" type="warning" class="mb-3">
                Для продолжения Вы должны
                <router-link to="/profile/settings/emails">
                  подтвердить главную почту.
                </router-link>
              </v-alert>
            </template>


            <form v-if="!$auth.loggedIn || userCanUseEmail()" @submit.prevent="submit" @keydown.enter="submit" autocomplete="on">
              <v-radio-group v-model="emailOrNickname" v-if="!$auth.loggedIn" row>
                <v-layout justify-space-around>
                  <v-radio label="Через почту" value="email" class="mr-0" />
                  <v-radio label="Через ник" value="nickname" class="mr-0" />
                </v-layout>
              </v-radio-group>

              <v-text-field
                v-model="form.email"
                v-show="emailOrNickname === 'email'"
                v-validate="`required|${validatorRules.email}`"
                :disabled="$auth.loggedIn"
                :error-messages="errors.collect('email')"
                data-vv-name="email"
                prepend-icon="mail"
                label="Почта"
                required
              ></v-text-field>

              <v-text-field
                v-show="emailOrNickname === 'nickname'"
                v-model="form.nickname"
                v-validate="validatorRules.nickname"
                :error-messages="errors.collect('nickname')"
                :counter="32"
                data-vv-name="nickname"
                prepend-icon="person"
                label="Ник"
                required
              />
            </form>


          </v-card-text>
          <v-card-actions v-if="!$auth.loggedIn || userCanUseEmail()" class="px-3 pb-3">


            <v-btn
              @click="submit"
              color="primary"
              :disabled="btnDisabled"
              :loading="btnLoading"
              large block
            >
              Продолжить
              <v-icon right>forward</v-icon>
            </v-btn>


          </v-card-actions>
        </v-card>


      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import validatorMixin from '~/mixins/validator'
import { mapActions, mapGetters } from 'vuex'

export default {
  mixins: [validatorMixin],
  data () {
    return {
      form: {
        email: this.$auth.loggedIn ? this.$auth.user.mainEmail.email : null,
        nickname: null
      },
      emailOrNickname: 'email',
      btnLoading: false,
      sent: false
    }
  },
  methods: {
    async submit () {
      const data = {
        [this.emailOrNickname]: this.form[this.emailOrNickname]
      }

      if (await this.validateByMixin(data)) {
        this.btnLoading = true
        if (await this.resetPasswordSendEmail(data)) {
          this.sent = true
        }
        this.btnLoading = false
      }
    },
    ...mapActions('auth', [
      'resetPasswordSendEmail'
    ])
  },
  computed: {
    formErrors () {
      return this.errors.items.filter(i => i.field === this.emailOrNickname)
    },
    btnDisabled () {
      return !!this.formErrors.length
    },
    ...mapGetters('user', ['userCanUseEmail'])
  }
}
</script>
