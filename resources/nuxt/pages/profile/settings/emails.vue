<template>
  <div style="width: 100%;">
    <v-container v-if="$auth.user.emails.length" fluid>
      <v-layout row wrap justify-center>
        <v-flex xs12 md6 xl4>
          <v-subheader>Главный адрес</v-subheader>
          <span class="grey--text">
            Используется для
            <router-link to="/profile/settings/notifications">уведомлений</router-link>
            и функций сайта, например, для сброса пароля.
          </span>
        </v-flex>
        <v-flex xs12 md6 xl4>


          <!-- item-value="id" -->
          <v-select
            v-model="mainEmail"
            :loading="setMainEmailLoading"
            :items="$auth.user.emails"
            prepend-icon="mail"
            item-text="email"
            return-object
          >
            <template
              slot="selection"
              slot-scope="{ item }"
            >
              <span class="mr-1">
                <v-tooltip v-if="item.verified" bottom>
                  <v-icon slot="activator" color="success">check_circle</v-icon>
                  <span>Подтвержденный адрес</span>
                </v-tooltip>
                <v-tooltip v-else bottom>
                  <v-icon slot="activator" color="error">error</v-icon>
                  <span>Неподтвержденный адрес</span>
                </v-tooltip>
              </span>
              {{ item.email }}
            </template>
            <template
              slot="item"
              slot-scope="{ item }"
            >
             <span class="mr-3">
               <v-tooltip v-if="item.verified" bottom>
                 <v-icon slot="activator" color="success">check_circle</v-icon>
                 <span>Подтвержденный адрес</span>
               </v-tooltip>
               <v-tooltip v-else bottom>
                 <v-icon slot="activator" color="error">error</v-icon>
                 <span>Неподтвержденный адрес</span>
               </v-tooltip>
             </span>
              {{ item.email }}
            </template>
          </v-select>


        </v-flex>
      </v-layout>
    </v-container>

    <!-- <div>
      <v-btn
       dark
       fab
       top
       right
       color="pink"
     >
       <v-icon>add</v-icon>
     </v-btn>
    </div> -->

    <v-layout justify-center wrap>
      <v-flex xs12>

        <v-toolbar class="profile-settings__emails-toolbar mt-3" color="primary" dark>
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
            Мои электронные адреса
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
          :items="$auth.user.emails"
          class="elevation-1 mb-5"
          style="max-width: 100%;"
          hide-actions
          disable-initial-sort
        >
          <template slot="items" slot-scope="props" active="true">
            <tr :active="$auth.user.mainEmail && $auth.user.mainEmail.id === props.item.id">
              <td :class="{'success--text': props.item.verified, 'error--text': !props.item.verified}">
                {{ props.item.email }}<br>
                <b v-if="$auth.user.mainEmail && $auth.user.mainEmail.id === props.item.id">
                  (главный)
                </b>
              </td>
              <td>{{ props.item.label }}</td>
              <td class="text-xs-center">
                <v-icon v-if="props.item.verified" color="success">check</v-icon>
                <v-icon v-else color="error">error</v-icon>
              </td>
              <td>
                <v-checkbox @change="changePublicStateEmail(props.item)" :input-value="props.item.public" class="ml-4" hide-details />
              </td>
              <td class="text-xs-center">
                <span v-if="props.item.verified">
                  Почта подтверждена
                </span>
                <span v-if="props.item.verificationToken">
                  Да
                  <v-btn
                    v-if="props.item.verificationToken"
                    @click="clickRepeatVerificationMail(props.item.id)"
                    :loading="repeatVerificationMailLoadingItemId === props.item.id"
                    color="primary"
                    class="ml-4"
                    small
                  >
                    <v-icon left>email</v-icon>
                    Отправить повторно
                  </v-btn>
                </span>
              </td>
              <td>
                <v-btn @click="deleteDialog = true; deleteDialogItem = props.item.id;" icon>
                  <v-icon color="error">delete</v-icon>
                </v-btn>
              </td>
            </tr>
          </template>
        </v-data-table>

      </v-flex>
    </v-layout>


    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">Удалить этот адрес?</v-card-title>
        <!-- <v-card-text>Let Google help apps determine location. This means sending anonymous location data to Google, even when no apps are running.</v-card-text> -->
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" @click="deleteDialog = false" flat>
            Нет
          </v-btn>
          <v-btn @click="deleteDialogDeleteEmail" :loading="deleteDialogLoadingBtn" color="error" flat>
            Да
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    <v-dialog v-model="createDialog" max-width="400px">
      <v-card>
        <v-card-title>
          <span class="headline">
            Добавление почтового адреса
          </span>

          <!-- <v-spacer />

          <v-btn @click="createDialog = false" icon>
            <v-icon>close</v-icon>
          </v-btn> -->
        </v-card-title>

        <v-card-text>
          <v-text-field
            v-model="createDialogForm.email"
            type="email"
            label="Почта"
            :error-messages="errors.collect('email')"
            v-validate="'required|' + validatorRules.email"
            data-vv-name="email"
            prepend-icon="mail"
            required
          />


          <v-text-field
            v-model="createDialogForm.label"
            label="Метка"
            :error-messages="errors.collect('emailLabel')"
            v-validate="validatorRules.emailLabel"
            data-vv-name="emailLabel"
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


          <v-checkbox v-model="createDialogForm.main" label="Сделать главным?" :disabled="!$auth.user.emails.length" />
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" @click.native="createDialog = false" flat>
            Отмена
          </v-btn>
          <v-btn color="blue darken-1" @click.native="createDialogSaveEmail" :loading="createDialogLoadingBtn" :disabled="!!this.errors.items.length" flat>
            Сохранить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import validatorMixin from '~/mixins/validator'

export default {
  transition: 'slide-y-transition',
  scrollToTop: true,
  mixins: [validatorMixin],
  data () {
    return {
      repeatVerificationMailLoadingItemId: false,
      deleteDialogItem: null,
      deleteDialog: false,
      deleteDialogLoadingBtn: false,
      createDialog: false,
      createDialogLoadingBtn: false,
      createDialogForm: {
        email: null,
        label: null,
        public: false,
        main: !this.$auth.user.emails.length // если нет почт, то будет true
      },
      mainEmail: this.$auth.user.mainEmail,
      setMainEmailLoading: false,
      headers: [
        {
          text: 'Адрес',
          align: 'left',
          value: 'email'
        },
        { text: 'Метка', value: 'label' },
        { text: 'Подтвержденный', value: 'verified', align: 'center' },
        { text: 'Виден всем?', value: 'public' },
        { text: 'Отправлялось сообщение для подтверждения?', value: 'verificationToken', align: 'center' },
        { text: 'Удалить', value: -1 }
      ]
    }
  },
  methods: {
    async createDialogSaveEmail () {
      if (await this.validateByMixin(this.createDialogForm)) {
        this.createDialogLoadingBtn = true
        await this.saveEmail(this.createDialogForm)
        this.setInputMainEmail()
        this.createDialogLoadingBtn = this.createDialog = false
        this.setCreateDialogFormMain()
      }
    },
    async deleteDialogDeleteEmail () {
      this.deleteDialogLoadingBtn = true
      await this.deleteEmail({ id: this.deleteDialogItem })
      this.deleteDialogLoadingBtn = this.deleteDialog = false
      this.setCreateDialogFormMain()
    },
    async clickRepeatVerificationMail (id) {
      this.repeatVerificationMailLoadingItemId = id
      await this.repeatVerificationMail(id)
      this.repeatVerificationMailLoadingItemId = null
    },
    setCreateDialogFormMain () { // указывает будет ли в форме чекбокс "сделать главной почтой" true или false
      this.createDialogForm.main = !this.$auth.user.emails.length
    },
    setInputMainEmail () { // применяет новое значение к инпуту
      this.mainEmail = this.$auth.user.mainEmail
    },
    ...mapActions('auth', ['repeatVerificationMail']),
    ...mapActions('profileSettings', ['saveEmail', 'deleteEmail', 'setMainEmail', 'changePublicStateEmail'])
  },
  watch: {
    async mainEmail ({ id }) {
      if (this.$auth.user.mainEmail && id === this.$auth.user.mainEmail.id) {
        return
      }
      this.setMainEmailLoading = true
      await this.setMainEmail({ id })
      this.setInputMainEmail()
      this.setMainEmailLoading = false
    }
  }
}
</script>

<style>
  .profile-settings__emails-toolbar {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    /* border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px; */
  }
</style>
