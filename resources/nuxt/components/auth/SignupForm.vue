<template>
  <div class="px-3">


    <v-text-field
      v-model="form.nickname"
      v-validate="validatorRules.nickname"
      :error-messages="nicknameErrors"
      :loading="nicknameCheckLoading"
      :counter="nicknameMaxSymbols"
      @input="checkNickname"
      data-vv-name="nickname"
      prepend-icon="person"
      label="Ник"
      required
    />


    <!-- Уникальность ника -->
    <template v-if="form.nickname && !errors.has('nickname')">
      <v-alert :value="nicknameCheckLoading" color="info" icon="info" outline>
        Проверяем...
        <v-progress-circular color="primary" :size="20" indeterminate></v-progress-circular>
      </v-alert>

      <template v-if="!nicknameCheckLoading">
        <v-alert :value="nicknameUnique" color="success" icon="check_circle" outline>
          Ник не занят
        </v-alert>
      </template>
    </template>


    <!-- <v-alert type="info" :value="enterEmail !== null && !form.email">
      Некоторые функции сайта требуют почту, но Вы можете ввести ее потом.
    </v-alert>

    <v-switch
      v-if="enterEmail !== null"
      label="Ввести почту"
      v-model="enterEmail"
    /> -->


    <!-- <template v-if="enterEmail === true || enterEmail === null"> -->
    <v-text-field
      v-if="!socAuth"
      v-model="form.email"
      label="Почта"
      type="email"
      :error-messages="errors.collect('email')"
      v-validate="'required|' + validatorRules.email"
      data-vv-name="email"
      prepend-icon="mail"
      required
    />
    <!-- </template> -->

    <!-- <v-alert type="info" :value="passwordVariantAuthChoose !== null && !form.password" small>
      Введите пароль если хотите входить через него использую ник или почту.
    </v-alert>

    <v-switch
      v-if="passwordVariantAuthChoose !== null"
      label="Возможность входить через пароль"
      v-model="passwordVariantAuthChoose"
    /> -->


    <!-- <template v-if="passwordVariantAuthChoose !== false"> -->
    <!-- <v-text-field
      v-if="!socAuth"
      v-model="form.password"
      label="Пароль"
      :error-messages="errors.collect('password')"
      v-validate="validatorRules.password"
      data-vv-name="password"
      :type="passwordShow ? 'text' : 'password'"
      :append-icon="passwordShow ? 'visibility_off' : 'visibility'"
      :append-icon-cb="() => (passwordShow = !passwordShow)"
      prepend-icon="security"
      required
    /> -->

    <v-text-field
      v-if="!socAuth"
      v-model="form.password"
      v-validate="validatorRules.password"
      :error-messages="errors.collect('password')"
      :type="passwordShow ? 'text' : 'password'"
      :append-icon="passwordShow ? 'visibility_off' : 'visibility'"
      @click:append="passwordShow = !passwordShow"
      data-vv-name="password"
      prepend-icon="security"
      label="Пароль"
      required
    />
    <!-- </template> -->


    <!-- Капча -->
    <v-layout v-if="!socAuth" class="mt-4" justify-center>
      <!-- <div id="g-recaptcha"></div> -->
      <!-- data-size="compact" -->
      <div v-show="!captchaLoaded" class="text-xs-center">
        Загрузка капчи...<br>
        <v-progress-circular color="primary" indeterminate></v-progress-circular>
      </div>
      <div class="g-recaptcha" data-sitekey="6LdxzGAUAAAAAB-7jgghBCMhn4NPYJzcHLtV2QMN"></div>
    </v-layout>


    <v-btn
      @click="submit"
      color="primary"
      class="mt-5"
      :loading="loading"
      :disabled="btnDisabled"
      large block
    >
      <v-icon left>how_to_reg</v-icon>
      <!-- <v-icon left>forward</v-icon> -->
      Закончить
    </v-btn>


  </div>
</template>

<script>
import validatorMixin from '~/mixins/validator'
import { nicknameMaxSymbols } from '~/tools/Validator'
import { mapActions } from 'vuex'
import { msg } from '~/tools/helpers'

let timeoutIdForCheckNickname = null

export default {
  // props: ['value', 'handler', 'validateOnStart', 'socAuth'], // formInitalProp
  props: {
    value: Object,
    handler: Function,
    validateOnStart: Boolean,
    socAuth: Boolean,
    captchaLoaded: Boolean
  },
  mixins: [validatorMixin],
  data: () => ({
    form: {
      email: null,
      nickname: null,
      password: null
    },
    // form: {
    //   email: 'florida122@example.com',
    //   nickname: 'user122',
    //   password: 'secret'
    // },
    loading: false,
    passwordShow: true,
    nicknameUnique: null,
    nicknameCheckLoading: false,
    passwordVariantAuthChoose: null, // null - не добавлять чекбокс с выборомб
    enterEmail: null,
    nicknameMaxSymbols
  }),
  methods: {
    async submit () {
      let dataForValidate = this.form

      // если не выбран вход через пароль и почту/ник
      if (this.passwordVariantAuthChoose === false) {
        const { nickname } = this.form
        dataForValidate = { nickname }
      }

      if (await this.validateByMixin(dataForValidate)) {
        let captchaResponse = null

        if (window.grecaptcha) {
          captchaResponse = window.grecaptcha.getResponse()

          if (!captchaResponse) {
            msg.error('Подтвердите что Вы не робот.')
            return
          }
        }

        this.loading = true
        await this.handler(captchaResponse)
        this.loading = false
      }
    },
    async checkNickname () {
      // Было бы логично, но собития странно работают(если в нике была ошибка и ее исправляешь то тут ф-я будет думать что есть ошибка)
      // if (this.errors.has('nickname')) {
      //   this.nicknameUnique = null
      //   return
      // }

      this.nicknameCheckLoading = true

      clearTimeout(timeoutIdForCheckNickname)
      // Чтобы не вызывался запрос к API при постоянном добавлении/удалении символов(вводе), сделал timeout, если timeout был до этого то он удаляется
      timeoutIdForCheckNickname = setTimeout(async () => {
        this.nicknameUnique = await this.checkNicknameUnique(this.form.nickname)
        // даже если запрос к API завершится с ошибкой
        this.nicknameCheckLoading = false
      }, 1000)
    },
    input () {
      this.$emit('input', {
        data: this.form,
        // errors: this.errors,
        // nicknameErrors: this.nicknameErrors,
        // nicknameCheckLoading: this.nicknameCheckLoading,
        btnDisabled: this.btnDisabled,
        passwordVariantAuthChoose: this.passwordVariantAuthChoose
      })
    },
    setFormFromValue () {
      this.form = {...this.form, ...this.value.data}
    },
    ...mapActions('auth', [
      'checkNicknameUnique'
    ])
  },
  computed: {
    nicknameErrors () {
      let errors = this.errors.collect('nickname')

      if (this.nicknameUnique === false) {
        errors.push('Занятый')
      }
      return errors
    },
    btnDisabled () {
      const fieldsErrors = [...this.errors.items, ...this.nicknameErrors]
      return !!(fieldsErrors.length || this.nicknameCheckLoading)
    }
  },
  watch: {
    form: {
      deep: true,
      handler () {
        this.input()
      }
    },
    // value: {
    //   deep: true,
    //   handler () {
    //     this.setFormFromValue()
    //   }
    // },
    errors () {
      this.input()
    },
    btnDisabled () {
      this.input()
    },
    passwordVariantAuthChoose () {
      this.input()
    }
  },
  async mounted () {
    // если уже есть значение то не ставить дефолтное значение
    if (this.value.data) { // Object.keys(this.value).length
      this.setFormFromValue()
    } else {
      // если нет значения в v-model, то ставит дефолтное значение формы
      this.input()
    }

    if (this.form.nickname) {
      this.checkNickname()
    }

    if (this.validateOnStart) {
      await this.validateByMixin(this.form)
    }
    if (this.socAuth) {
      this.passwordVariantAuthChoose = this.enterEmail = false
      if (this.form.email) {
        // если почта получена из соц сети, то не заморачивать пользователя объяснениями
        this.enterEmail = null
      }
    }
  }
}
</script>
