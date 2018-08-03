<template>
  <v-list>
    <!-- Ставлю классы активности вручную, потому что если url содержит # то будет не совпадение(хеш содержится когда дается ссылка на поле формы, например) -->
    <v-list-tile to="/profile/settings" exact :class="{'primary--text v-list__tile--active': $route.path === '/profile/settings/' || $route.path === '/profile/settings'}">
      <v-list-tile-action><v-icon>settings</v-icon></v-list-tile-action>
      <v-list-tile-content><v-list-tile-title>
          Главная информация
      </v-list-tile-title></v-list-tile-content>
    </v-list-tile>


    <v-list-tile v-if="!$auth.user.password" to="/profile/settings/password">
      <v-list-tile-action>
        <v-badge color="warning" overlap>
          <span slot="badge">!</span>
          <!-- <v-icon slot="badge">warning</v-icon> -->
          <v-icon>lock</v-icon>
        </v-badge>
      </v-list-tile-action>
      <v-list-tile-content><v-list-tile-title class="warning--text">
          Добавить вход через пароль
      </v-list-tile-title></v-list-tile-content>
    </v-list-tile>


    <v-list-tile to="/profile/settings/emails">
      <v-list-tile-action><v-icon>email</v-icon></v-list-tile-action>
      <v-list-tile-content><v-list-tile-title>
          Электронные адреса
      </v-list-tile-title></v-list-tile-content>
    </v-list-tile>


    <v-list-tile to="/profile/settings/phones">
      <v-list-tile-action><v-icon>phone</v-icon></v-list-tile-action>
      <v-list-tile-content><v-list-tile-title>
          Номера телефонов
      </v-list-tile-title></v-list-tile-content>
    </v-list-tile>


    <v-list-tile to="/profile/settings/soc-accounts">
      <!-- account_box -->
      <v-list-tile-action><v-icon>group_add</v-icon></v-list-tile-action>
      <v-list-tile-content><v-list-tile-title>
          Прикрепленные аккаунты
      </v-list-tile-title></v-list-tile-content>
    </v-list-tile>


    <v-list-tile to="/profile/settings/notifications" exact>
      <v-list-tile-action>
        <v-badge v-if="notificationsGetColor" :color="notificationsGetColor" overlap>
          <!-- <v-icon slot="badge" small>error</v-icon> -->
          <span slot="badge">!</span>
          <v-icon>notifications_active</v-icon>
          <!-- color="error" -->
        </v-badge>
        <v-icon v-else>notifications_active</v-icon>
        <!-- notification_important -->
      </v-list-tile-action>
      <v-list-tile-content><v-list-tile-title :class="`${notificationsGetColor}--text`">
        Уведомления
      </v-list-tile-title></v-list-tile-content>
    </v-list-tile>


    <v-list-tile v-if="$auth.user.password" to="/profile/settings/password">
      <v-list-tile-action>
        <v-badge v-if="changePasswordGetColor" :color="changePasswordGetColor" overlap>
          <span slot="badge">!</span>
          <v-icon>lock</v-icon>
        </v-badge>
        <v-icon v-else>lock</v-icon>
      </v-list-tile-action>
      <v-list-tile-content><v-list-tile-title :class="`${changePasswordGetColor}--text`">
          Смена пароля
      </v-list-tile-title></v-list-tile-content>
    </v-list-tile>


    <!-- <v-list-group
      prepend-icon="person"
      no-action
    >

      <v-list-tile slot="activator">
        <v-list-tile-content>
          <v-list-tile-title>Заголовок</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile @click="">
        <v-list-tile-content><v-list-tile-title>
          Заголовок 1
        </v-list-tile-title></v-list-tile-content>
        <v-list-tile-action><v-icon>add</v-icon></v-list-tile-action>
      </v-list-tile>

      <v-list-tile @click="">
        <v-list-tile-content><v-list-tile-title>
          Заголовок 2
        </v-list-tile-title></v-list-tile-content>
      </v-list-tile>

    </v-list-group> -->

  </v-list>
</template>

<script>
export default {
  computed: {
    notificationsGetColor () {
      return !this.$auth.user.mainEmail ? 'error' : !this.$auth.user.mainEmail.verified ? 'warning' : ''
    },
    changePasswordGetColor () {
      return this.$auth.user.passwordLongTimeNotChange ? 'warning' : ''
    }
  }
}
</script>
