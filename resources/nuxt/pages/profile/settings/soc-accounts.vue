<template>
  <div>
    <template v-if="$auth.user.socAccounts.length === 1">
      <v-alert v-if="!$auth.user.password" type="info" class="mb-3" :value="true">
        У вас не настроен
        <router-link to="/profile/settings/password">
          вход через пароль
        </router-link>
        (с помощью почты или ника), это значит что <b>мы Вам запретили откреплять последний аккаунт</b>,
        иначе Вы не смогли бы входить на сайт.
      </v-alert>

      <!-- $auth.user.activated нужно чтобы не выводить сообщение не активированому о том что он станет не активированым(он и так не активирвоан) -->
      <!-- $auth.user.password потому что без пароля нет разрешения откреплять аккаунт(не будет способа войти) -->
      <!-- Если последний соц аккаунт и нет почты или она не подтвержденна. То есть пользователь активирован только за счет этого последнего аккаунта -->
      <v-alert v-else-if="$auth.user.activated && $auth.user.emails.length === 1 && (!$auth.user.mainEmail || !$auth.user.mainEmail.verified)" type="info" class="mb-3" :value="true">
        Если Вы открепите последний аккаунт, то Ваш аккаунт будет не активирован.
        Чтобы остаться активированным Вам нужно {{ addOrVerifyEmailText }}.
      </v-alert>
    </template>

    <!-- <v-layout justify-center>
      <v-flex sm12 md8 lg6 xl4> -->

    <soc-accounts />

      <!-- </v-flex>
    </v-layout> -->
  </div>
</template>

<script>
import socAccounts from '~/components/profile/current-user/settings/soc-accounts/SocAccounts'

export default {
  transition: 'slide-y-transition',
  scrollToTop: true,
  components: { socAccounts },
  computed: {
    addOrVerifyEmailText () {
      if (!this.$auth.user.mainEmail) {
        return 'добавить и подтвердить почту'
      }
      if (!this.$auth.user.mainEmail.verified) {
        return 'подтвердить почту'
      }
    }
  }
}
</script>
