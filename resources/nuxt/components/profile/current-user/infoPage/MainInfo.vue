<template>
  <div :class="{'current-user-profile__info elevation-1': true, 'current-user-profile__info_sticky': $vuetify.breakpoint.mdAndUp }">
    <v-list style="border-radius: 5px;" two-line dense>


      <v-list-tile>
        <v-list-tile-avatar>
           <!-- class="grey lighten-1 white--text" -->
           <v-icon color="indigo">person</v-icon>
         </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title class="indigo--text">Имя</v-list-tile-title>
          <v-list-tile-sub-title>{{ user.fullName || 'не указано' }}</v-list-tile-sub-title>
        </v-list-tile-content>
      </v-list-tile>


      <v-list-tile v-if="user.gender !== null">
        <v-list-tile-avatar>
           <v-icon color="indigo">account_box</v-icon>
         </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title class="indigo--text">Пол</v-list-tile-title>
          <v-list-tile-sub-title>
            {{ user.genderText }}
          </v-list-tile-sub-title>
        </v-list-tile-content>
      </v-list-tile>


      <v-list-tile v-if="user.birthday">
        <v-list-tile-avatar>
           <v-icon color="indigo">cake</v-icon>
         </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title class="indigo--text">Возраст</v-list-tile-title>
          <v-list-tile-sub-title>
            {{ user.age }} ({{ user.birthday | date }})
          </v-list-tile-sub-title>
        </v-list-tile-content>
      </v-list-tile>


      <v-list-tile v-if="user.country">
        <v-list-tile-avatar>
           <v-icon color="indigo">location_on</v-icon>
         </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title class="indigo--text">Страна</v-list-tile-title>
          <v-list-tile-sub-title>
            <img :src="getFlag(user.country)" class="country-flag mr-1" style="max-width: 30px;">
            {{ user.countryName }}
          </v-list-tile-sub-title>
        </v-list-tile-content>
      </v-list-tile>


      <v-list-tile>
        <v-list-tile-avatar>
           <v-icon color="indigo">access_time</v-icon>
         </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title class="indigo--text">Заренестрирован</v-list-tile-title>
          <v-list-tile-sub-title>
            <time>{{ new Date(user.createdAt).toLocaleDateString() }}</time>
          </v-list-tile-sub-title>
        </v-list-tile-content>
      </v-list-tile>


      <!-- <v-divider inset /> -->
      <!-- <v-subheader>Контакты</v-subheader> -->


      <v-list-tile v-if="emailsPublic.length">
        <v-list-tile-avatar>
           <v-icon color="indigo">contact_mail</v-icon>
         </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title class="indigo--text">Эл. адреса</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>


      <v-list-tile v-for="email in emailsPublic" :key="'email-' + email.id">
        <v-list-tile-avatar></v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title>{{ email.email }}</v-list-tile-title>
          <v-list-tile-sub-title>{{ email.label }}</v-list-tile-sub-title>
        </v-list-tile-content>
      </v-list-tile>





      <v-list-tile v-if="phonesPublic.length">
        <v-list-tile-avatar>
           <v-icon color="indigo">contact_phone</v-icon>
         </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title class="indigo--text">Телефоны</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>


      <v-list-tile v-for="phone in phonesPublic" :key="'phone-' + phone.id">
        <v-list-tile-avatar></v-list-tile-avatar>
        <v-list-tile-action>
          <img :src="getFlag(phone.country)" class="country-flag" style="max-width: 30px;">
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>
            {{ phone.numberFormated }}
          </v-list-tile-title>
          <v-list-tile-sub-title>{{ phone.label }}</v-list-tile-sub-title>
        </v-list-tile-content>
        <!-- <v-list-tile-content>
          <v-btn @click="" icon>
            <v-icon color="grey">file_copy</v-icon>
          </v-btn>
        </v-list-tile-content> -->

        <!-- <v-list-tile-action>
          <v-btn @click="" icon>
            <v-icon color="grey">file_copy</v-icon>
          </v-btn>
        </v-list-tile-action> -->
      </v-list-tile>



    </v-list>
  </div>
</template>

<script>
  import { getFlag } from '~/tools/helpers'

  export default {
    props: ['user'],
    computed: {
      emailsPublic () {
        return this.user.emails.filter(i => i.public)
      },
      phonesPublic () {
        return this.user.phones.filter(i => i.public)
      }
    },
    methods: {
      getFlag
    }
  }
</script>

<style>
  .current-user-profile__info_sticky {
    position: sticky;
    z-index: 1;
    /* 230 */
    top: 100px;
  }
</style>
<!-- <no-ssr>
  <table style="width: 100%;">
    <tr>
      <td>
        <v-icon class="pr-2">person</v-icon>
        <b>Имя:</b>
      </td>
      <td class="text-xs-right">{{ user.fullName || 'не указано' }}</td>
    </tr>
    <tr>
      <td>
        <v-icon class="pr-2">access_time</v-icon>
        <b>Заренестрирован:</b>
      </td>
      <td class="text-xs-right"><time>{{ new Date(user.createdAt).toLocaleDateString() }}</time></td>
    </tr>
    <tr>
      <td>
        <v-icon class="pr-2">contact_mail</v-icon>
        <b>Эл. адреса:</b>
      </td>
      <td class="text-xs-right">
        todo
      </td>
    </tr>
  </table>
</no-ssr> -->
