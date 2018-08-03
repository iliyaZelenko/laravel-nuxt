<template>
  <!-- <v-parallax src="https://vuetifyjs.com/static/doc-images/parallax/material.jpg" :height="1000"> -->
    <v-container style="margin-bottom: 190px;" fill-height fluid>
      <v-layout fill-height justify-center align-center wrap>
        <v-flex xs12>
          <div class="display-1 text-xs-center mb-4 white--text">
            Список зарегистрированных пользователей
          </div>
          <v-data-table
            :headers="headers"
            :items="users"
            :pagination.sync="pagination"
            :rows-per-page-items="[5,10,25,100,{text: '$vuetify.dataIterator.rowsPerPageAll',value:-1}]"
            class="elevation-1"
            style="border-radius: 15px;"
          >
            <template slot="items" slot-scope="{ item }">
              <td class="text-xs-center">
                <user-avatar v-if="item.avatar" :user="item" size-name="circle" />
                <v-btn @click="devSigninByUser(item.id)" color="primary" small round>
                  Войти
                </v-btn>
              </td>
              <td class="text-xs-center">
                <template v-if="item.country">
                  <img :src="getFlag(item.country)" class="country-flag" style="max-width: 30px;"><br>
                  {{ item.countryName | truncate }}
                </template>
                <span v-else>-</span>
              </td>
              <td>
                <router-link :to="'/profile/' + item.nickname" class="title">
                  {{ item.nickname }}
                </router-link>
              </td>
              <td>{{ item.fullName || '-' }}</td>
              <td>
                <template v-if="item.emails.length">
                  <ul class="pa-0">
                    <li v-for="email in item.emails" :key="email.id" style="white-space: nowrap;">
                      <b v-if="item.mainEmail && item.mainEmail.id === email.id">
                        {{ email.email }}(главный)
                      </b>
                      <span v-else>{{ email.email }}</span>
                      <v-icon v-if="email.verified" color="green">check</v-icon>
                    </li>
                  </ul>
                </template>

                {{ !item.emails.length ? 'нет адресов' : '' }}
              </td>
              <td>
                <template v-if="item.socAccounts.length">
                  <ul>
                    <li v-for="acc in item.socAccounts" :key="acc.id" style="list-style-type: none;">
                      <font-awesome-icon :icon="['fab', acc.icon]" :color="acc.color" size="lg" />
                      <span :style="`color: ${acc.color};`">
                        {{ acc.name_for_human }}
                      </span>
                    </li>
                  </ul>
                </template>

                {{ !item.socAccounts.length ? 'нет аккаутов' : '' }}
              </td>
              <td>
                <template v-if="item.phones.length">
                  <ul style="list-style-type: none; white-space: nowrap;" class="pa-0">
                    <li v-for="phone in item.phones" :key="phone.id" class="pt-2">
                      <img :src="getFlag(phone.country)" class="country-flag mr-2" style="max-width: 30px;">
                      <b v-if="item.mainPhone && item.mainPhone.id === phone.id">
                        {{ phone.numberFormated }}(для смс)
                      </b>
                      <span v-else>{{ phone.numberFormated }}</span>
                      <v-icon v-if="phone.verified" color="green">check</v-icon>
                    </li>
                  </ul>
                </template>

                {{ !item.phones.length ? 'нет телефонов' : '' }}
              </td>
              <td class="text-xs-center">
                {{ item.timezone ? item.timezone : '-' }}
              </td>
              <td>{{ boolToText(item.activated) }}</td>
              <td>{{ boolToText(item.password) }}</td>
              <td>{{ item.genderText }}</td>
              <td>{{ item.birthday ? $dayjs(item.birthday).format(dateFormat) : '-'  }}</td>
              <td>{{ boolToText(item.passwordLongTimeNotChange) }}</td>
              <td>
                <!-- new Date(item.createdAt).toLocaleDateString() -->
                <time>{{ $dayjs(item.createdAt).format(dateFormat) }}</time>
              </td>
              <td>
                <template v-if="item.createdThroughSocAcc">
                  <font-awesome-icon :icon="['fab', socAccById(item.createdThroughSocAcc).icon]" :color="socAccById(item.createdThroughSocAcc).color" size="lg" />
                  {{ socAccById(item.createdThroughSocAcc).name_for_human }}
                </template>
                <span v-else>Форму</span>
              </td>
              <td>
                <template v-if="item.signinThroughSocAcc">
                  <font-awesome-icon :icon="['fab', socAccById(item.signinThroughSocAcc).icon]" :color="socAccById(item.signinThroughSocAcc).color" size="lg" />
                  {{ socAccById(item.signinThroughSocAcc).name_for_human }}
                </template>
                <span v-else>Пароль</span>
              </td>
            </template>
          </v-data-table>
        </v-flex>

        <!-- <v-flex xs6> -->
          <v-alert type="info" :value="userInfo.country || userInfo.timezone">
            <span class="title">Удалось получить информацию!</span>
            <div v-if="userInfo.country">
              Ваша страна: <b>{{ userInfo.country }}</b>
            </div>
            <div v-if="userInfo.timezone">
              Ваш часовой пояс: <b>{{ userInfo.timezone }}</b>
            </div>
          </v-alert>
        <!-- </v-flex> -->
      </v-layout>
    </v-container>
</template>

<script>
import { mapActions } from 'vuex'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
import { getFlag, msg } from '~/tools/helpers'
import UserAvatar from '~/components/user/UserAvatar'

export default {
  components: { FontAwesomeIcon, UserAvatar },
  async asyncData ({ app, store }) {
    try {
      let users = await app.$axios.$post(`/api/users`)
      let socialiteProviders = await app.store.dispatch('getSocialiteProviders')

      console.log(socialiteProviders)

      return { users, socialiteProviders }
    } catch (e) {
      console.log(e)
    }
  },
  data: () => ({
    pagination: {
      rowsPerPage: 100
    },
    headers: [
      {
        text: 'Аватар',
        align: 'left',
        // sortable: false,
        value: 'id'
      },
      { text: 'Откуда', value: 'countryName' },
      { text: 'Ник', value: 'nickname' },
      { text: 'Имя', value: 'fullName' },
      { text: 'Эл. адреса', value: 'emails' },
      { text: 'Прикрепленные аккаунты', value: 'socAccounts' },
      { text: 'Телефоны', value: 'phones', align: 'center' },
      { text: 'Часовой пояс', value: 'timezone', align: 'center' },
      { text: 'Активирован', value: 'activated' },
      { text: 'Имеет пароль', value: 'password' },
      { text: 'Пол', value: 'gender' },
      { text: 'День рождения', value: 'birthday' },
      { text: 'Давно не менял пароль?', value: 'passwordLongTimeNotChange' },
      { text: 'Зарегестрирован', value: 'createdAt' },
      { text: 'Зарегестрирован через', value: 'createdThroughSocAcc' },
      { text: 'Последний раз входил через', value: 'signinThroughSocAcc' }
    ],
    dateFormat: process.env.dateFormats.main
  }),
  methods: {
    socAccById (id) {
      // TODO если пользователь откреплял то может не быть
      return this.socialiteProviders.find(i => i.id === id) // user.socAccounts
    },
    async devSigninByUser (userId) {
      const info = await this.$axios.$post('/api/auth/login-by-id', { userId })
      this.signinManually(info)
      msg.success('Вход выполнен.')
      this.$router.push('/profile/' + info.user.nickname)
    },
    ...mapActions('auth', ['signinManually']),
    getFlag
  },
  computed: {
    userInfo () {
      const timezone = this.$cookies.get('guest-timezone')
      const country = this.$cookies.get('guest-country')

      return { timezone, country }
    },
    boolToText: () => val => val ? 'Да' : 'Нет'
  }
}
</script>
