<template>
  <!-- :style="$vuetify.breakpoint.mdAndUp ? `margin-left: ${getFixedDrawerWidth()};width: ${getToolbarWidth()}` : ''" -->
  <v-toolbar :class="{
    'profile-settings__toolbar': true,
    'profile-settings__toolbar_fixed': $vuetify.breakpoint.mdAndUp,
    'elevation-3': $vuetify.breakpoint.mdAndUp && mixinsHelperScroll_scrolled
    }"
    :fixed="$vuetify.breakpoint.mdAndUp"
    color="primary"
    flat
    dark
  >
    <v-toolbar-title>{{ title }}</v-toolbar-title>
    <v-spacer></v-spacer>
    <!-- class="hidden-xs-only" -->
    <v-tooltip bottom>
      <v-btn slot="activator" icon>
        <v-icon>help</v-icon>
      </v-btn>
      <span>Нужна помощь?</span>
    </v-tooltip>

  </v-toolbar>
</template>

<script>
import helperScrollMixin from '~/mixins/helpers/scroll'

export default {
  mixins: [helperScrollMixin],
  computed: {
    title () {
      const titles = {
        '/profile/settings': 'Главная информация',
        '/profile/settings/soc-accounts': 'Прикрепленные аккаунты',
        '/profile/settings/password': 'Добавление пароля',
        '/profile/settings/notifications': 'Уведомления',
        '/profile/settings/emails': 'Электронные адреса'
      }
      titles['/profile/settings/password'] = this.$auth.user.password ? 'Смена пароля' : 'Добавление пароля'

      return titles[this.$route.path]
    }
  }
}
</script>
