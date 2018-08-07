<template>
  <div>
    <!-- <v-alert :value="!$auth.user.password" type="warrning" class="mb-3">
      Для Вас не доступен вход через пароль(с помощью почты или ника),
      потому что у Вас нет пароля. Сохраните пароль чтобы входить через
      пароль и ник или почту.
    </v-alert> -->

    <!-- TODO ТУТ ДРУГИЕ ССЫЛКИ -->
    <!-- TODO ТУТ ДРУГИЕ ССЫЛКИ -->
    <!-- TODO ТУТ ДРУГИЕ ССЫЛКИ -->
    <!-- TODO ТУТ ДРУГИЕ ССЫЛКИ -->
    <!-- duplicate duplicate duplicate duplicate duplicate duplicate duplicate duplicate duplicate -->
    <!-- <v-alert :value="!$auth.user.password" type="warning" class="mb-3">
      Для Вас не доступен вход через почту, потому что у вас нет
      <template v-if="!$auth.user.email">
        почты и пароля.
        <v-btn to="#email">Добавить почту</v-btn> -->
        <!-- <router-link to="#email">Добавить почту</router-link> -->
        <!-- <v-btn to="#password">Добавить пароль</v-btn> -->
        <!-- <router-link >Добавить пароль</router-link> -->
      <!-- </template>
      <template v-else>
        пароля.
        <v-btn to="#password">Добавить</v-btn>
      </template>
    </v-alert> -->

    <v-alert :value="$auth.user.passwordLongTimeNotChange" type="warning" class="mb-3">
      Вы давно не меняли пароль, рекомендуется поменять на новый.
    </v-alert>


    <v-alert :value="!$auth.user.password" type="warning" class="mb-3">
      Если хотите входить через <b>ник</b> или
      <b>
        почту
        <span v-if="!$auth.user.email">(У Вас не введена почта)</span>
      </b>
      , то добавьте пароль.
      <v-btn @click="$refs.password.focus()" color="primary">
        Добавить
      </v-btn>
    </v-alert>



    <v-layout class="mt-5 mb-5" align-center justify-center wrap>
      <v-flex class="mb-5 pr-5" xs12 md8 lg6 xl6>
        <form @submit.prevent="saveNewPassword" @keydown.enter="saveNewPassword" autocomplete="on">
          <template v-if="$auth.user.password">
            <!-- prepend-icon="security" -->
            <v-text-field
              v-model="currentPassword"
              v-validate="validatorRules.password"
              :error-messages="errors.collect('currentPassword')"
              :type="passwordShow ? 'text' : 'password'"
              :append-icon="passwordShow ? 'visibility_off' : 'visibility'"
              @click:append="passwordShow = !passwordShow"
              data-vv-name="currentPassword"
              label="Текущий пароль"
              required
            />

            <v-layout justify-center>
              <v-icon class="mr-1">help</v-icon>
              <nuxt-link to="/auth/forgot-password">
                Забыли пароль?
              </nuxt-link>
            </v-layout>

            <v-text-field
              v-model="newPassword"
              v-validate="validatorRules.password"
              :error-messages="errors.collect('newPassword')"
              :type="passwordShow ? 'text' : 'password'"
              :append-icon="passwordShow ? 'visibility_off' : 'visibility'"
              @click:append="passwordShow = !passwordShow"
              data-vv-name="newPassword"
              label="Новый пароль"
              required
            />
          </template>
          <template v-else>
            <v-text-field
              v-model="password"
              v-validate="validatorRules.password"
              :error-messages="errors.collect('password')"
              :type="passwordShow ? 'text' : 'password'"
              :append-icon="passwordShow ? 'visibility_off' : 'visibility'"
              @click:append="passwordShow = !passwordShow"
              data-vv-name="password"
              label="Какой пароль хотите?"
              prepend-icon="security"
              ref="password"
              required
            />
          </template>

          <v-btn
            @click="saveNewPassword"
            :loading="loading"
            :disabled="btnDisabled"
            class="mt-3 right"
            color="primary"
            right
          >
            <v-icon left>save</v-icon>
            Сохранить
          </v-btn>
        </form>
      </v-flex>
      <v-flex xs12 md12 xl6>
        <p class="title">
          История изменений пароля
        </p>
        <v-alert type="info" v-if="passwordsHistory.length" :value="true">
          Последнее изменение: {{ $dayjs(passwordsHistory[passwordsHistory.length - 1].created_at).format(dateFormat) }}
        </v-alert>
        <v-alert type="info" :value="!passwordsHistory.length">
          Вы не меняли пароль.
        </v-alert>
        <ul>
          <li v-for="period in passwordsHistory.slice().reverse()" :key="period.id">
            <time>
              {{ $dayjs(period.created_at).format(dateFormat) }}
              ({{ $dayjs().to($dayjs(period.created_at)) }})
            </time>
          </li>
        </ul>
      </v-flex>
    </v-layout>

    <div>
      <p class="title">Сочетайте разные символы</p>
      <p>Используйте одновременно буквы, цифры и специальные символы:</p>
      <ul>
        <li>Заглавные (прописные) буквы, например A, E, R.</li>
        <li>Строчные буквы, например a, e, r.</li>
        <li>Цифры, например 2, 6, 7.</li>
        <li>Специальные символы, например !, @, &amp;, *.</li>
      </ul>
      <p class="title mt-3">Следуйте рекомендациям</p>
      <p>Выберите слово или фразу и замените некоторые буквы цифрами или символами. В пароле нельзя использовать символы кириллицы, но можно заменить их похожими допустимыми символами или использовать транслит. Примеры:</p>
      <ul>
        <li>Название праздника Хеллоуин можно записать как }{eJIJI0yI/IH.</li>
        <li>Прощание "чао-какао" можно записать как 4A0-|{aK@O.</li>
      </ul>
      <p>Сократите фразу: используйте первые буквы каждого слова. Пример:</p>
      <ul>
        <li>"Если звезды зажигают, значит, это кому-нибудь нужно?" можно записать как E*zZeKnN?</li>
      </ul>
      <p>Чем длиннее пароль, тем он надежнее. Поскольку в паролях допустимы пробелы, можно использовать запоминающиеся фразы или слова из ваших любимых песен, стихов или цитат. Пример:</p>
      <ul>
        <li>@&nbsp;– DrOOG 4eloveka (Собака&nbsp;– друг человека).</li>
        <li>33 KoP0BbI&nbsp;– cBe}|{AR sTP0|&lt;A (Тридцать три коровы&nbsp;– свежая строка).</li>
        <li>Ya pomnyu chudnoe mgnovenye: Peredo mnoy yavilas ty (Я помню чудное мгновенье: передо мной явилась ты).</li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import validatorMixin from '~/mixins/validator'

export default {
  transition: 'slide-y-transition',
  scrollToTop: true,
  mixins: [validatorMixin],
  asyncData: async ({ store }) => ({
    passwordsHistory: await store.dispatch('profileSettings/getPasswordsHistory')
  }),
  data: () => ({
    password: null,
    currentPassword: null,
    newPassword: null,
    passwordShow: true,
    loading: false,
    dateFormat: process.env.dateFormats.main
  }),
  computed: {
    title () {
      return this.$auth.user.password ? 'Смена пароля' : 'Добавление пароля'
    },
    btnDisabled () {
      return !!this.errors.items.length
    }
    // passwordsHistorySorted () {
    //   this.passwordsHistory.sort((a, b) => {
    //     return new Date(b.created_at) - new Date(a.created_at)
    //   })
    // }
  },
  methods: {
    async saveNewPassword () {
      const data = this.$auth.user.password
        ? { currentPassword: this.currentPassword, newPassword: this.newPassword }
        : { password: this.password }

      if (await this.validateByMixin(data)) {
        this.loading = true
        await this.setPassword(data)
        this.loading = false
        this.passwordsHistory = await this.getPasswordsHistory()
      }
    },
    ...mapActions('profileSettings', ['setPassword', 'getPasswordsHistory'])
  }
}
</script>
