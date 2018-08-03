<template>
  <div :class="{
    'subheading': $vuetify.breakpoint.smAndUp,
    'body-2': $vuetify.breakpoint.xsOnly,
    'pa-2': true
  }">
    <!-- Было $auth.user.activated && !$auth.user.email -->
    <div style="overflow-y: auto;">
      <template v-if="contentType === 2">

        <img src="~/assets/auth/noEmail.svg" width="100%" style="max-width: 70px; float: right; margin-left: 20px;" alt="Нет почты">

        {{ title }}
        Функции сайта требующие почты для Вас не доступны.<br>
        Например: "Забыли пароль?", вход через почту используя пароль, уведомления с раздела "На почту".<br>
        Вы можете ввести ее в <router-link to="/profile/settings/emails">Вашем профиле</router-link>.

      </template>
      <template v-if="contentType === 0 || contentType === 1">
        <template v-if="contentType === 1">

            <img src="~/assets/auth/email.svg" width="100%" style="max-width: 70px; float: right; margin-left: 20px;" alt="Почта">

            {{ title }}

            <template v-if="otherVerifiedEmails.length">
              У вас есть
              {{ otherVerifiedEmails.length === 1 ? 'подтвержденный адрес' : 'подтвержденные адреса:' }}

              <span v-for="email in otherVerifiedEmails" :key="email">
                <b>{{ email.email }}</b>
                <span v-if="email.label">({{ email.label }})</span>,
              </span>

              <router-link to="/profile/settings/emails">
                выберите
                {{ otherVerifiedEmails.length === 1 ? 'его' : 'один из них' }}
                в настройках
              </router-link>
              чтобы не было этого сообщения.
            </template>

            Функции сайта требующие почты для Вас не доступны.
            Чтобы подтвердить - посмотрите сообщение на почте которое мы Вам отправляли.

        </template>
        <template v-if="contentType === 0">

          <img src="~/assets/auth/notActivated.svg" width="100%" style="max-width: 70px; float: right; margin-left: 20px;" alt="Не активирован">

          {{ title }}

          Это несет
          <v-tooltip bottom>
            <a href="#" slot="activator">
              некоторые ограничения.
            </a>
            Ограничение 1, Ограничение 2, Ограничение 3 и другие
          </v-tooltip>

          Есть два варианта активировать:
          <ul>
            <li>
              <router-link to="/profile/settings/emails">
                {{ $auth.user.emails.length > 1 ? 'подтвердить одну из почт' : 'подтвердить почту' }}
              </router-link>
              (мы отправляли сообщение Вам на почту).
            </li>
            <li>
              <router-link to="/profile/settings/soc-accounts">
                привязать любой аккаунт социальной сети.
              </router-link>
            </li>
          </ul>

        </template>
      </template>
    </div>

    <div class="text-xs-center">
      <template v-if="contentType === 0 || contentType === 1">
        <b v-if="hideBtn" class="green--text">
          Отправлено
          <v-icon color="green" right>check</v-icon>
        </b>
        <v-btn
          v-else
          :loading="loading"
          @click="clickRepeatVerificationMail"
          color="primary"
          round small
        >
          Отправить сообщение повторно
        </v-btn>
      </template>

      <v-btn v-if="underToolbar" @click="$emit('click-hide')" round small>
        <v-icon left>cancel</v-icon>
        Скрыть
      </v-btn>
    </div>


  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  props: {
    underToolbar: Boolean,
    contentType: Number,
    title: String
  },
  data: () => ({
    hideBtn: false,
    loading: false
  }),
  methods: {
    async clickRepeatVerificationMail () {
      this.loading = true
      await this.repeatVerificationMail(this.$auth.user.mainEmail.id)
      this.loading = false
      this.hideBtn = true
    },
    ...mapActions('auth', ['repeatVerificationMail'])
  },
  computed: {
    otherVerifiedEmails () {
      return this.$auth.user.emails.filter(email => email.verified)
    }
  },
  watch: {
    $route (to, from) {
      this.hideBtn = false
    }
  }
}
</script>
