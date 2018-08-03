<template>
  <div style="width: 100%;">
    <v-layout v-if="$auth.user.phones.length" class="mb-3" justify-center>
      <div>
        <v-subheader>
          Телефон для&nbsp;
          <router-link to="/profile/settings/notifications">
            смс уведомлений
          </router-link>
        </v-subheader>

        <main-phone-select />
      </div>
    </v-layout>



    <v-layout row wrap justify-center>
      <v-flex xs12>

        <v-toolbar class="profile-settings__phones-toolbar mt-3" color="primary" dark>
          <v-btn
            @click="createDialog = true"
            color="success"
            fab
            top
            right
            absolute
          >
            <v-icon>add</v-icon>
          </v-btn>
          <v-toolbar-title class="white--text">
            Мои номера телефонов
            <v-tooltip bottom>
              <v-btn slot="activator" icon>
                <v-icon>help</v-icon>
              </v-btn>
              <span>
                Служат как данные для входа, сброса пароля, а также как контактные данные(только публичные)
              </span>
            </v-tooltip>
          </v-toolbar-title>
          <!-- <v-spacer></v-spacer>
          <v-btn icon>
            <v-icon>search</v-icon>
          </v-btn>
          <v-btn icon>
            <v-icon>view_module</v-icon>
          </v-btn> -->
        </v-toolbar>

      </v-flex>
      <v-flex xs12>
        <v-data-table
          :headers="headers"
          :items="$auth.user.phones"
          class="elevation-1 mb-5"
          style="max-width: 100%;"
          hide-actions
          disable-initial-sort

        >
          <template slot="items" slot-scope="{ item }" active="true">
            <tr>
              <td :class="{'success--text': item.verified, 'error--text': !item.verified}">
                <img :src="getFlag(item.country)" class="country-flag mr-2" style="max-width: 30px;">
                <!-- <b>+{{ item.prefix }}</b> -->
                <span style="white-space: nowrap;">
                  {{ item.numberFormated }}
                </span>
                <b v-if="$auth.user.mainPhone && $auth.user.mainPhone.id === item.id">(для смс уведомлений)</b>
              </td>
              <td>{{ item.label }}</td>
              <td class="text-xs-center">
                <v-icon v-if="item.verified" color="success">check</v-icon>
                <v-icon v-else color="error">error</v-icon>
              </td>
              <td>
                <v-checkbox @change="changePublicStatePhone(item)" :input-value="item.public" class="ml-4" hide-details />
              </td>
              <td class="text-xs-center">
                <span v-if="item.verified">
                  Телефон подтвержден
                </span>
                <span v-if="item.smsVerificationCode">
                  Да
                  <v-btn
                    v-if="item.smsVerificationCode"
                    @click="clickRepeatVerificationPhone(item.id)"
                    :loading="repeatVerificationPhoneLoadingItemId === item.id"
                    color="primary"
                    class="ml-4"
                    small
                  >
                    <v-icon left>sms</v-icon>
                    Отправить повторно
                  </v-btn>
                </span>
              </td>
              <td>
                <v-btn @click="deleteDialog = true; deleteDialogItem = item.id;" icon>
                  <v-icon color="error">delete</v-icon>
                </v-btn>
              </td>
            </tr>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>


    <v-dialog v-model="deleteDialog" max-width="390">
      <v-card>
        <v-card-title class="headline">Удалить этот телефон?</v-card-title>
        <!-- <v-card-text>Let Google help apps determine location. This means sending anonymous location data to Google, even when no apps are running.</v-card-text> -->
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" @click="deleteDialog = false" flat>
            Нет
          </v-btn>
          <v-btn @click="deleteDialogDeletePhone" :loading="deleteDialogLoadingBtn" color="error" flat>
            Да
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    <v-dialog v-model="createDialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">
            Добавление телефона
          </span>
        </v-card-title>

        <v-card-text>
          <v-layout align-center>
            <v-autocomplete
              v-model="createDialogForm.prefix"
              :items="prefixes"
              :item-text="i => `+${i.phonePrefix} ${i.country}`"
              item-value="phonePrefix"
              prepend-icon="phone"
              style="width: 25%;"
              class="mr-3"
            >
              <template
                slot="selection"
                slot-scope="{item, selected}"
              >
                <img :src="getFlag(item.countryCode)" class="country-flag" style="max-width: 30px;">
                <span class="ml-2">+{{ item.phonePrefix }}</span>
              </template>
              <template
                slot="item"
                slot-scope="{item, tile}"
              >
                <v-list-tile-action>
                  <img :src="getFlag(item.countryCode)" class="country-flag" style="max-width: 30px;">
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>+{{ item.phonePrefix }}</v-list-tile-title>
                  <v-list-tile-sub-title>{{ item.country }}</v-list-tile-sub-title>
                </v-list-tile-content>
              </template>
            </v-autocomplete>

            <!-- маску можно указывать как ## ### ####, но у каждой страны своя маска https://ru.wikipedia.org/wiki/%D0%A2%D0%B5%D0%BB%D0%B5%D1%84%D0%BE%D0%BD%D0%BD%D1%8B%D0%B5_%D0%BF%D0%BB%D0%B0%D0%BD%D1%8B_%D0%BD%D1%83%D0%BC%D0%B5%D1%80%D0%B0%D1%86%D0%B8%D0%B8_%D0%B2_%D1%80%D0%B0%D0%B7%D0%BD%D1%8B%D1%85_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B0%D1%85#%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D1%8F_%D0%B8_%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD -->
            <v-text-field
              v-model="createDialogForm.number"
              v-validate="'required|' + validatorRules.phone"
              :error-messages="errors.collect('phone')"
              mask="phone"
              type="phone"
              label="Телефон"
              data-vv-name="phone"
              style="width: 50%;"
              required
            />
          </v-layout>
          <span v-if="!$auth.user.country" class="grey--text">
            Для подставления префикса Вашей страны сохраните ее в настройках.
          </span>


          <v-text-field
            v-model="createDialogForm.label"
            v-validate="validatorRules.phoneLabel"
            :error-messages="errors.collect('phoneLabel')"
            label="Метка"
            data-vv-name="phoneLabel"
            prepend-icon="label"
            required
          />


          <v-layout justify-start>
            <v-checkbox v-model="createDialogForm.public" label="Публичный?" />

            <v-tooltip bottom>
              <v-btn slot="activator" color="primary" class="mt-3" flat icon>
                <v-icon>info</v-icon>
              </v-btn>
              <span>Виден всем пользователям в ваших контактах</span>
            </v-tooltip>
          </v-layout>


          <v-checkbox v-model="createDialogForm.main" label="Сделать главным(для смс уведомлений)?" :disabled="!$auth.user.phones.length" />
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" @click.native="createDialog = false" flat>
            Отмена
          </v-btn>
          <v-btn color="blue darken-1" @click.native="createDialogSavePhone" :loading="createDialogLoadingBtn" :disabled="!!this.errors.items.length" flat>
            Сохранить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { getFlag } from '~/tools/helpers'
import MainPhoneSelect from '~/components/profile/current-user/settings/phones/MainPhoneSelect'
import validatorMixin from '~/mixins/validator'

export default {
  transition: 'slide-y-transition',
  scrollToTop: true,
  mixins: [validatorMixin],
  components: { MainPhoneSelect },
  asyncData: async ({ store }) => ({
    prefixes: await store.dispatch('getPhonePrefixes')
  }),
  data () {
    return {
      repeatVerificationPhoneLoadingItemId: false,
      deleteDialogItem: null,
      deleteDialog: false,
      deleteDialogLoadingBtn: false,
      createDialog: false,
      createDialogLoadingBtn: false,
      createDialogForm: {
        prefix: null,
        number: null,
        label: null,
        public: false,
        main: !this.$auth.user.phones.length // если нет телефонов, то будет true
      },
      headers: [
        {
          text: 'Номер',
          align: 'left',
          value: 'numberFormated'
        },
        { text: 'Метка', value: 'label' },
        { text: 'Подтвержденный', value: 'verified', align: 'center' },
        { text: 'Виден всем?', value: 'public' },
        { text: 'Отправлялось смс для подтверждения?', value: 'smsVerificationCode', align: 'center' },
        { text: 'Удалить', value: -1 }
      ]
    }
  },
  methods: {
    async createDialogSavePhone () {
      if (await this.validateByMixin(this.createDialogForm)) {
        const prefixMoreInfo = this.prefixes.find(i => i.phonePrefix === this.createDialogForm.prefix)
        this.createDialogForm.country = prefixMoreInfo.countryCode
        this.createDialogForm.country2 = prefixMoreInfo.countryCode2

        this.createDialogLoadingBtn = true
        await this.savePhone(this.createDialogForm)
        this.createDialogLoadingBtn = this.createDialog = false
        this.setCreateDialogFormMain()
      }
    },
    async deleteDialogDeletePhone () {
      this.deleteDialogLoadingBtn = true
      await this.deletePhone({ id: this.deleteDialogItem })
      this.deleteDialogLoadingBtn = this.deleteDialog = false
      this.setCreateDialogFormMain()
    },
    async clickRepeatVerificationPhone (id) {
      this.repeatVerificationPhoneLoadingItemId = id
      await this.repeatVerificationPhone(id)
      this.repeatVerificationPhoneLoadingItemId = null
    },
    setCreateDialogFormMain () { // указывает будет ли в форме чекбокс "сделать главной почтой" true или false и указывает mainEmail
      this.createDialogForm.main = !this.$auth.user.phones.length
    },
    getFlag,
    ...mapActions(['phonePrefixes']),
    ...mapActions('profileSettings', ['savePhone', 'deletePhone', 'changePublicStatePhone', 'repeatVerificationPhone'])
  },
  mounted () {
    // префикс по стране
    this.createDialogForm.prefix = this.prefixes.find(i => i.countryCode === this.$auth.user.country).phonePrefix
  }
}
</script>

<style>
  .profile-settings__phones-toolbar {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    /* border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px; */
  }
</style>
