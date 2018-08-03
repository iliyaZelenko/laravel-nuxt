<template>
  <div>


    <div class="text-xs-center headline my-4">
      На сайт и на главный эл. адрес <span v-if="$auth.user.mainEmail">({{ $auth.user.mainEmail.email }})</span>
    </div>


    <v-layout justify-center>
      <v-alert :value="!$auth.user.mainEmail" type="error" class="mb-3">
        У Вас нет почты, уведомления с раздела "На почту" для Вас не работают.<br>
        <v-btn to="/profile/settings/emails">
          <v-icon left>add</v-icon>
          Добавить
        </v-btn>
      </v-alert>

      <v-alert :value="$auth.user.mainEmail && !$auth.user.mainEmail.verified" type="warning" class="mb-3">
        У Вас не подтвержденна почта, уведомления с раздела "На почту" для Вас не работают.<br>
      </v-alert>
    </v-layout>


    <v-layout justify-center>
      <v-data-table
        :headers="headers"
        :items="items"
        class="elevation-1 mb-5"
        style="max-width: 100%;"
        hide-actions
        disable-initial-sort
      >
        <!-- <template slot="headerCell" slot-scope="props">
          <v-icon v-if="!$auth.user.email && props.header.value === 'email'" color="error">error</v-icon>
          {{ props.header.text }}
        </template> -->
        <template slot="items" slot-scope="props">
          <td>{{ props.item.event }}</td>
          <td>
            <v-checkbox
              v-model="props.item.site"
              :disabled="props.item.disabled && props.item.disabled.includes('site')"
              hide-details
            />
            <!-- {{ props.item.site }} -->
          </td>
          <td>
            <v-checkbox
              v-model="props.item.email"
              :disabled="props.item.disabled && props.item.disabled.includes('email')"
              :color="!$auth.user.mainEmail ? 'error' : !$auth.user.mainEmail.verified ? 'warning' : undefined"
              hide-details
            />
            <!-- {{ props.item.email }} -->
          </td>
        </template>
      </v-data-table>
    </v-layout>


    <v-divider />


    <div class="text-xs-center headline my-4">
      Смс уведомления
    </div>

    <v-layout justify-center>
      <v-alert :value="!$auth.user.phones.length" type="warning" class="mb-3">
        У вас нет телефонов, смс уведомления не доступны.<br>
      </v-alert>
    </v-layout>

    <v-layout v-if="$auth.user.phones.length" justify-center>
      <v-card>

        <div class="px-4 py-2">
          <main-phone-select />

          <v-alert :value="$auth.user.mainPhone && !$auth.user.mainPhone.verified" type="warning" class="mt-3">
            Телефон не подтвержден.<br>
          </v-alert>
        </div>


        <v-list v-if="$auth.user.mainPhone && $auth.user.mainPhone.verified" two-line subheader>
          <v-list-tile avatar>
            <v-list-tile-action>
              <v-checkbox v-model="notifications"  />
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>Мне ответили</v-list-tile-title>
              <v-list-tile-sub-title>Когда Вам ответил пользователь</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-action>
              <v-checkbox v-model="sound" />
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>Добавление в друзья</v-list-tile-title>
              <v-list-tile-sub-title>Когда кто-то захотел стать другом</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-action>
              <v-checkbox v-model="video" />
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>Личное сообщение</v-list-tile-title>
              <v-list-tile-sub-title>Когда пришло личное сообщение</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-action>
              <v-checkbox v-model="invites" />
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>День рождения друга</v-list-tile-title>
              <v-list-tile-sub-title>Напоминать о днях рождения</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-card>
    </v-layout>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { getFlag } from '~/tools/helpers'
import validatorMixin from '~/mixins/validator'
import MainPhoneSelect from '~/components/profile/current-user/settings/phones/MainPhoneSelect'

export default {
  transition: 'slide-y-transition',
  scrollToTop: true,
  mixins: [validatorMixin],
  components: { MainPhoneSelect },
  data () {
    return {
      mainPhone: this.$auth.user.mainPhone,
      setMainPhoneLoading: false,

      notifications: true,
      sound: false,
      video: false,
      invites: true,

      headers: [
        {
          text: 'События',
          align: 'left',
          value: 'event'
        },
        { text: 'На сайт', value: 'site' },
        { text: 'На почту', value: 'email' }
      ],
      items: [
        {
          event: 'Личное сообщение',
          site: true,
          email: false,
          disabled: ['site']
        },
        {
          event: 'Добавление в друзья',
          site: true,
          email: true
        },
        {
          event: 'Вас лайкнули',
          site: false,
          email: false
        },
        {
          event: 'Подписка',
          site: false,
          email: true
        }
      ]
    }
  },
  methods: {
    getFlag,
    ...mapActions('profileSettings', ['setMainPhone'])
  },
  watch: {
    async mainPhone ({ id }) {
      if (id === this.$auth.user.mainPhone.id) {
        return
      }
      this.setMainPhoneLoading = true
      await this.setMainPhone({ id })
      this.mainPhone = this.$auth.user.mainPhone
      this.setMainPhoneLoading = false
    }
  }
}
</script>
