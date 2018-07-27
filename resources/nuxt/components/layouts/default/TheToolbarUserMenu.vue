<template>
  <!-- :nudge-width="200" -->
  <!-- :nudge-left="195" -->

  <!-- attach для фиксированйо позиции при скроле -->
  <v-menu
    :close-on-content-click="false"
    offset-y
    open-on-hover
    left
    dark
    attach
  >
    <v-btn class="ml-3" slot="activator" flat>
      <span class="pr-3" style="text-transform: none !important;">
        {{ $auth.user.nickname }}
      </span>

      <user-avatar size="124px"></user-avatar>
    </v-btn>

    <v-card>
      <v-list>
        <v-list-tile :to="'/profile/' + $auth.user.nickname">
          <v-list-tile-action><v-icon>person</v-icon></v-list-tile-action>
          <v-list-tile-content><v-list-tile-title>
            Профиль
          </v-list-tile-title></v-list-tile-content>
        </v-list-tile>
        <v-list-tile to="/profile/settings">
          <v-list-tile-action><v-icon>settings</v-icon></v-list-tile-action>
          <v-list-tile-content><v-list-tile-title>
            Настройки
          </v-list-tile-title></v-list-tile-content>
        </v-list-tile>
        <v-list-tile @click.prevent="$auth.logout()">
          <v-list-tile-action><v-icon>exit_to_app</v-icon></v-list-tile-action>
          <v-list-tile-content><v-list-tile-title>
            Выйти
          </v-list-tile-title></v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-card>
  </v-menu>
</template>

<script>
  // import { mapGetters } from 'vuex'
  import UserAvatar from '~/components/user/UserAvatar'
  import { mapGetters } from 'vuex'

  export default {
    components: { UserAvatar },
    computed: {
      ...mapGetters('user', ['userFullName'])
    }
    // computed: {
    //   ...mapGetters('user', ['userAvatar'])
    // }
  }
</script>

<style scoped>
  #logo {
    cursor: pointer;
    /* background-color: white;*/
    /* padding: 3px; */
    margin-left: 30px;
    /* border-radius: 14px; */
  }
</style>
