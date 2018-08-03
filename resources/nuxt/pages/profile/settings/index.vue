<template>
  <div>
    <v-layout align-center justify-center>
      <v-alert :value="!$auth.user.mainEmail && $auth.user.password" type="info" class="mb-3">
        Для Вас не доступен вход с паролем используя почту, потому что у вас нет почты.
        Но вы можете входить через ник <b>{{ $auth.user.nickname }}</b>
        <router-link v-if="$auth.user.socAccounts.length" to="/profile/settings/soc-accounts">
          и прикрепленные аккаунты
        </router-link>
        <v-btn to="/profile/settings/emails">
          <v-icon left>add</v-icon>
          Добавить почту
        </v-btn>
      </v-alert>

      <v-alert :value="!$auth.user.password" type="info" class="mb-3">
        У вас не настроен вход через пароль используя почту или ник.
        <v-btn to="/profile/settings/password">
          <v-icon left>add</v-icon>
          Добавить эту возможность
        </v-btn>
      </v-alert>
    </v-layout>


    <!-- profile-settings__nickname служит как якорь после загрузки аватарки -->
    <div id="profile-settings__nickname" class="text-xs-center mb-4">
      <span class="display-2">{{ $auth.user.nickname }}</span><br>
      <span class="grey--text">Ник изменить нельзя</span>
    </div>



    <v-container class="profile-settings__avatar-wrap">
      <div class="title text-xs-center pb-4">
        Ваш аватар
      </div>
      <avatar />
    </v-container>



    <v-layout justify-center row wrap>
      <v-flex class="px-2 pb-3" sm12 md10 lg6 xl5>
        <form @submit.prevent="submit" autocomplete="on">

          <!-- <v-text-field
            v-model="form.email"
            type="email"
            label="Почта"
            :error-messages="emailErrors"
            v-validate="validatorRules.email"
            data-vv-name="email"
            prepend-icon="mail"
            :autofocus="$route.hash.includes('email')"
            ref="email"
            required
          /> -->

          <!-- prepend-icon="person" -->
          <v-text-field
            v-model="form.firstName"
            label="Имя"
            :error-messages="errors.collect('firstName')"
            v-validate="validatorRules.firstName"
            data-vv-name="firstName"
            required
          />


          <v-text-field
            v-model="form.lastName"
            label="Фамилия"
            :error-messages="errors.collect('lastName')"
            v-validate="validatorRules.lastName"
            data-vv-name="lastName"
            required
          />



          <!-- :filter="countriesFilter" -->
          <v-autocomplete
            v-model="form.country"
            :items="countries"
            item-value="countryCode"
            label="Страна"
            prepend-icon="location_on"
          >
            <template
              slot="selection"
              slot-scope="{item, selected}"
            >
              <div style="width: 25px;">
                <img :src="getFlag(item.flagName)" class="country-flag">
              </div>
              <span class="ml-2">{{ item.text }}</span>
            </template>
            <template
              slot="item"
              slot-scope="{item, tile}"
            >
              <!-- <v-list-tile-content>
                <img :src="getFlag(item)" width="30px">
              </v-list-tile-content>
              <v-list-tile-title>
                <span class="ml-3">{{ item.text }}</span>
              </v-list-tile-title> -->
              <img :src="getFlag(item.flagName)" class="country-flag" style="max-width: 30px;">
              <!-- <img :src="getFlag(item)" width="30px"> -->
              <!-- <div v-html="item.flag"></div> -->
              <span class="ml-3">{{ item.text }}</span>
            </template>
          </v-autocomplete>


          <!-- без item-text не работает, я так понял оно надо для поиска(как по мне, лучше бы разрабы сделали поиск по слоту item) -->
          <!-- item-value="countryCode" -->
          <v-autocomplete
            v-model="form.timezone"
            :items="timezonesByCountry"
            :filter="timezonesFilter"
            :item-text="(i) => `(UTC${i.offset}) ${i.value}`"
            label="Временная зона"
            prepend-icon="access_time"
            persistent-hint
          >
            <template
              slot="item"
              slot-scope="{item}"
            >
              <!-- <v-list-tile dense> -->
                <!-- <v-list-tile-title>
                  (UTC<b>{{item.item.offset}}</b>) {{ item.item.value }} | {{ UTC.add(parseInt(item.item.offset), 'hours').format('HH:mm:ss') }}
                </v-list-tile-title> -->
                <!-- <v-list-tile-content> -->
                <v-list-tile-content class="pr-3">
                  <img :src="getFlag(item.flagName)" class="country-flag" style="max-width: 30px;">
                </v-list-tile-content>
                <!-- <v-list-tile-content> -->

                <v-list-tile-title>
                  (UTC{{item.offset}}) <b>{{ item.value }}</b>
                </v-list-tile-title>
                  <!-- <v-list-tile-sub-title>
                    {{ UTC.add(parseInt(item.item.offset), 'hours').format('HH:mm:ss') }}
                  </v-list-tile-sub-title> -->
                <!-- </v-list-tile-content> -->
                <v-list-tile-action class="grey--text ml-2">
                  <!-- {{ $dayjs().add(parseInt(item.item.offset), 'hours').format('HH:mm:ss') }} -->
                  {{ timezoneCurrentTime(item) }}
                </v-list-tile-action>
              <!-- </v-list-tile> -->
            </template>
            <!-- <div slot-scope="item">
              <b>{{item.offset}}</b>
            </div> -->
          </v-autocomplete>


          <!-- <v-subheader>
            Пол:
          </v-subheader> -->
          <!-- :mandatory="false" -->
          <v-radio-group v-model="form.gender" label="Пол:" row>
            <v-layout justify-space-around>
              <!-- class="mr-0" -->
              <v-radio label="Мужчина" :value="true" />
              <!-- убрал  class="mr-0" чтобы с label radio-group красивее было -->
              <v-radio label="Женщина" :value="false" />
              <v-radio label="Не указано" :value="null" />
            </v-layout>
          </v-radio-group>




          <v-dialog
            v-model="modalBirthday"
            :return-value.sync="form.birthday"
            ref="dialog"
            width="290px"
            persistent
            lazy
            full-width
          >
            <v-text-field
              slot="activator"
              v-model="form.birthday"
              label="День рождения"
              prepend-icon="event"
              readonly
            ></v-text-field>
            <v-date-picker v-model="form.birthday" :locale="locale" scrollable>
              <v-spacer></v-spacer>
              <v-btn flat color="primary" @click="modalBirthday = false">Отмена</v-btn>
              <v-btn flat color="primary" @click="$refs.dialog.save(form.birthday)">Ок</v-btn>
            </v-date-picker>
          </v-dialog>


          <!-- !$auth.user.email && form.email  -->
          <!-- <v-alert :value="form.email !== $auth.user.email && !errors.collect('email').length" type="info" class="mb-3">
            {{ $auth.user.socAccounts.length ? 'Почта будет не подтвержденной(аккаунт останется активированным)' : 'Аккаунт станет не активированным, нужно будет подтвердить почту.' }}
          </v-alert> -->

          <v-alert :value="formDifference().length" type="info" class="mb-3">
            Измененные поля: {{ formDifference().map(name => formLocalizedAttributes[name]).join(', ') }}.
          </v-alert>

          <v-btn
            v-show="formDifference().length"
            @click="submit"
            color="success"
            :loading="loading"
            :disabled="btnDisabled"
            large block
          >
            <v-icon left>save</v-icon>
            Сохранить
          </v-btn>
        </form>
      </v-flex>
    </v-layout>

    <!-- {{ $auth.user.nickname }} -->
    <!-- <pre>{{ $auth.$state }}</pre> -->
  </div>
</template>

<script>
import { getFlag, getLocale } from '~/tools/helpers'
import validatorLocales from '~/i18n/validator'
import validatorMixin from '~/mixins/validator'
import { mapActions } from 'vuex'
import Avatar from '~/components/profile/current-user/settings/index/Avatar'
import reduce from 'lodash/reduce'
import isEqual from 'lodash/isEqual'

let formDefault

export default {
  transition: 'slide-y-transition',
  scrollToTop: true,
  mixins: [validatorMixin],
  components: { Avatar },
  async asyncData ({ store }) {
    return {
      timezones: await store.dispatch('getTimezones'),
      countries: await store.dispatch('getCountries')
    }
  },
  data () {
    const locale = getLocale()
    const { firstName, lastName, gender, country, timezone, birthday } = this.$auth.user
    const dateFormat = process.env.dateFormats.main

    formDefault = {
      firstName,
      lastName,
      gender,
      country,
      timezone,
      birthday: birthday ? this.$dayjs(birthday).format(dateFormat) : null
    }

    return {
      form: {...formDefault},
      formLocalizedAttributes: validatorLocales[locale].attributes,
      modalBirthday: null,
      loading: false,
      // dateFormat: process.env.dateFormats.main,
      currentDate: null,
      dateFormat,
      locale
    }
  },
  methods: {
    async submit () {
      if (await this.validateByMixin(this.form)) {
        this.loading = true
        await this.setUserData(this.form)
        this.loading = false
        formDefault = {...this.form}
      }
    },
    formDifference () {
      return reduce(this.form, (result, value, key) =>
        isEqual(value, formDefault[key]) ? result : result.concat(key),
      [])
    },
    setCurrentDate () {
      this.currentDate = this.$dayjs()
    },
    timezonesFilter (i, queryText) {
      return `(UTC${i.offset}) ${i.value} ${this.timezoneCurrentTime(i)}`.includes(queryText)
    },
    // birthdayFormatDate (date) {
    //   if (!date) return null
    //
    //   const [year, month, day] = date.split('-')
    //   return `${month}/${day}/${year}`
    // },
    getFlag,
    ...mapActions('profileSettings', [
      'setUserData'
    ])
  },
  // watch: {
  //   'form.timezone' (val) {
  //     if (val.includes('GMT')) {
  //       console.log(val)
  //       this.form.timezone = val.slice(13)
  //     }
  //   }
  // },
  computed: {
    timezoneCurrentTime () {
      return item => {
        const hours = +item.offset.slice(1, 3)
        const minutes = +item.offset.slice(4, 6)
        let date = this.currentDate

        if (item.offsetPrefix === '+') {
          date = date.add(hours, 'hours').add(minutes, 'minutes')
        } else {
          date = date.subtract(hours, 'hours').subtract(minutes, 'minutes')
        }

        return date.toISOString().slice(11, -5)
      }
    },
    timezonesByCountry () {
      if (this.form.country) {
        const countryCode = this.form.country
        const timezones = this.timezones.filter(i => i.countryCode === countryCode)

        console.log(timezones)
        if (timezones.length === 1) {
          this.form.timezone = timezones[0].value
        }

        return timezones
      }
      return this.timezones
    },
    // computedBirthday () {
    //   return this.birthdayFormatDate(this.form)
    // },
    // emailErrors () {
    //   let emailErrors = this.errors.collect('email')
    //
    //   if (this.$auth.user.email && this.form.email === '') {
    //     emailErrors.push('Нельзя удалять почту с аккаунта.')
    //   }
    //
    //   return emailErrors
    // },
    // formErrors () {
    //   return this.errors.items // [...this.errors.items, ...this.emailErrors]
    // },
    btnDisabled () {
      return !!this.errors.items.length
    }
  },
  created () {
    this.setCurrentDate()
    setInterval(this.setCurrentDate, 1000)
  },
  destroyed () {
    clearInterval(this.setCurrentDate)
  }
}
</script>

<style>
  .profile-settings__avatar-wrap {
    background: #eee;
    border-radius: 25px;
    margin-bottom: 45px;
  }
</style>
