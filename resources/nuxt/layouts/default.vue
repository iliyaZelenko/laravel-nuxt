<template>
  <v-app :class="{
    'application--have-auth-background': $route.path.includes('/auth'),
    'application--have-settings-background': $route.path.includes('profile/settings')
  }">

    <!-- <v-navigation-drawer
      :mini-variant.sync="miniVariant"
      :clipped="clipped"
      v-model="drawer"
      temporary
      fixed
      app
    >
      <v-list>
        <v-list-tile
          router
          exact
          :to="item.to"
          :key="i"
          v-for="(item, i) in items"
        >
          <v-list-tile-action>
            <v-icon v-html="item.icon"></v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="item.title"></v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer> -->

    <layout-toolbar />

    <!-- color="green lighten-5" -->
    <!-- class="mb-4"  style="padding-top: 110px;" -->
    <v-content>
      <v-scale-transition>
        <email-verification-alert v-show="!$route.path.includes('/profile/settings')" under-toolbar/>
      </v-scale-transition>
      <!-- <v-container > -->

      <!-- <div style="padding: 0 0 100px;"> -->
        <!-- Сообщение на счет почты -->
          <!-- <email-verification-alert v-if="!$route.path.includes('/profile/settings')" class="mt-4 mb-4" /> -->

        <nuxt />

        <!-- Кнопка "наверх" -->
        <v-fab-transition>
          <v-btn
            v-show="mixinsHelperScroll_scrolled > 100"
            @click="$vuetify.goTo(0)"
            :small="$vuetify.breakpoint.smAndDown"
            color="primary"
            fab
            fixed
            bottom
            right
          >
            <v-icon>keyboard_arrow_up</v-icon>
          </v-btn>
        </v-fab-transition>
      <!-- </div> -->
      <!-- <div style="margin: 0 auto; width: 1px;">
        <pre>{{ $auth.$state }}</pre>
      </div> -->
      <!-- </v-container> -->
    </v-content>

    <!-- secondary  color="green lighten-4" -->
    <!-- :style="`background: ${$vuetify.theme.secondary};`" -->
    <!-- absolute -->
    <!-- <v-footer class="footer" app dark>
      <div class="ml-3">
        Сделано с
        <v-icon class="red--text">favorite</v-icon>
        от
        Ильи
      </div>
      <pre>{{ $vuetify.theme }}</pre>
    </v-footer> -->

    <v-footer
      class="footer"
      height="auto"
      inset
      dark
    >
      <div>
      <!-- <v-card
        flat
        tile
        class="grey darken-3"
        width="100%"
        style="background-image: url(https://cdn2.hubspot.net/hubfs/463671/Hero_images/footer-background.jpg?t=1531247225841) !important; background-size: cover;"
        dark
      > -->
        <!-- <v-card-text> -->
          <div class="text-xs-center mb-3 mt-4">
            <v-btn
              v-for="icon in icons"
              :key="icon"
              class="mx-3"
              icon dark outline
            >
              <!-- <v-icon size="24px">{{ icon }}</v-icon> -->
              <font-awesome-icon :icon="['fab', icon]" size="lg" />
            </v-btn>
          </div>
          <v-divider />

          <v-container fluid grid-list-xl>
            <v-layout wrap justify-center>
              <v-flex xs12 lg12 xl6>
                <p class="title text-xs-center">
                  О нас
                </p>
                <p>
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                </p>
                <p>
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  <!-- <v-btn flat round>
                    <v-icon left>contact_support</v-icon>
                    Поддержка
                  </v-btn> -->
                </p>
              </v-flex>
              <v-flex class="pl-5" xs6 sm4 lg3 xl2>
                <p class="title">
                  Полезные ссылки
                </p>
                <div>
                  <p><router-link to="#" class="white--text">Помощь</router-link></p>
                  <p><router-link to="#" class="white--text">Соглашение</router-link></p>
                  <p><router-link to="#" class="white--text">Правила</router-link></p>
                  <p><router-link to="#" class="white--text">Документация</router-link></p>
                  <p><router-link to="#" class="white--text">Конфиденциальность</router-link></p>
                </div>
              </v-flex>
              <v-flex xs6 sm4 lg3 xl2>
                <p class="title">
                  Еще ссылки
                </p>
                <div>
                  <p><router-link to="#" class="white--text">Соглашение</router-link></p>
                  <p><router-link to="#" class="white--text">Помощь</router-link></p>
                  <p><router-link to="#" class="white--text">Документация</router-link></p>
                  <p><router-link to="#" class="white--text">Конфиденциальность</router-link></p>
                  <p><router-link to="#" class="white--text">Правила</router-link></p>
                </div>
              </v-flex>
              <!-- <v-flex xs12 lg4 xl2>
                <p class="title text-xs-center">
                  Информация
                </p>
                <p>
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                  Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.
                </p>
              </v-flex> -->
              <v-flex xs6 sm4 lg4 xl2>
                <p class="title">
                  Контакты
                </p>

                <p>
                  <v-icon class="mr-2">phone</v-icon>
                  +380960652658
                </p>
                <p>
                  <v-icon class="mr-2">location_on</v-icon>
                  ул. Михаила Грушевского, 26/1
                </p>
                <p>
                  <v-icon class="mr-2">mail_outline</v-icon>
                  mail@gmail.com
                </p>

                <!-- <v-list style="border-radius: 25px; background: rgba(0, 0, 0, .30);" two-line dark>
                  <v-list-tile>
                    <v-list-tile-avatar><v-icon left>phone</v-icon></v-list-tile-avatar>
                    <v-list-tile-content>+380960652658</v-list-tile-content>
                  </v-list-tile>
                  <v-list-tile>
                    <v-list-tile-avatar><v-icon left>location_on</v-icon></v-list-tile-avatar>
                    <v-list-tile-content>Офис: Киев, ул. Михаила Грушевского, 26/1</v-list-tile-content>
                  </v-list-tile>
                  <v-list-tile>
                    <v-list-tile-avatar><v-icon left>mail_outline</v-icon></v-list-tile-avatar>
                    <v-list-tile-content>mail@gmail.com</v-list-tile-content>
                  </v-list-tile> -->
                  <!-- <v-list-tile>
                    <v-list-tile-avatar><v-icon left>phone</v-icon></v-list-tile-avatar>
                    <v-list-tile-content>+380960652658</v-list-tile-content>
                  </v-list-tile> -->
                <!--</v-list>-->
              </v-flex>
              <!-- <v-flex xs3>
                <div class="title text-xs-center">
                  Заголовок 3
                </div>
                <p>Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum.</p>
              </v-flex> -->
            </v-layout>
          </v-container>

          <!-- Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum. Praesent ut risus eget metus luctus accumsan id ultrices nunc. Sed at orci sed massa consectetur dignissim a sit amet dui. Duis commodo vitae velit et faucibus. Morbi vehicula lacinia malesuada. Nulla placerat augue vel ipsum ultrices, cursus iaculis dui sollicitudin. Vestibulum eu ipsum vel diam elementum tempor vel ut orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. -->
        <!-- </v-card-text> -->

        <!-- <v-divider /> -->

        <!-- <v-card-text class="white--text">
          Сделано с
          <v-icon class="red--text">favorite</v-icon>
          от
          Ильи
        </v-card-text> -->
      <!-- </v-card> -->
      </div>
    </v-footer>

  </v-app>
</template>

<script>
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
import helperScrollMixin from '~/mixins/helpers/scroll'
import mixinlayoutElements from '~/mixins/helpers/layoutElements'
import LayoutToolbar from '~/components/layouts/default/TheToolbar'
import EmailVerificationAlert from '~/components/auth/EmailVerificationAlert'
// import * as Cookie from 'js-cookie' // TODO import Cookie from 'js-cookie'

export default {
  mixins: [helperScrollMixin, mixinlayoutElements],
  components: { LayoutToolbar, EmailVerificationAlert, FontAwesomeIcon },
  data: () => ({
    icons: [
      'google-plus',
      'facebook',
      'vk',
      'instagram',
      'reddit'
    ]
  }),
  watch: {
    '$route': function () {
      this.$nextTick(this.mixinslayoutElements_appContentSetDynamicStyles)
    }
  },
  async mounted () {
    this.$nextTick(this.mixinslayoutElements_appContentSetDynamicStyles)

    window.addEventListener('resize', this.mixinslayoutElements_appContentSetDynamicStyles)
  },
  beforeDestroy () {
    window.removeEventListener('resize', this.mixinslayoutElements_appContentSetDynamicStyles)
  },
  created () {
    this.$auth.$storage.watchState('loggedIn', newValue => {
      const token = this.$auth.getToken('local')

      this.$axios.setToken(token)
      // this.$axios.setHeader('Authorization', localStorage['auth._token.local'])

      // document.location.reload()
      // this.$axios.setToken(this.$auth.getToken(this.$auth.strategy.name))
      // console.log(1, localStorage['auth._token.local'])
    })

    // if (this.$auth.$state.redirect === null) {
    // {headers: {
    //   'Authorization': `Bearer ${this.$auth.getToken()}`
    // }}
    // console.log(2, localStorage['auth._token.local'])
    // this.$axios.setHeader('Authorization', localStorage['auth._token.local'])
    // this.$axios.setToken(this.$auth.getToken(this.$auth.strategy.name))
    // document.location.reload()
    // }
  }
}
</script>

<style>
.footer {
  /* height: auto !important; */
  z-index: 1;
  /* 3 */
  /* background: #f1f3f4 !important; */
  /* background: url(http://qaru.site/img/43ba263df12f60c20cad596e7220cd51.jpg) !important; */
}

.v-content {
  padding-top: unset !important;
  /* padding-bottom: 100px !important; */
  min-height: 100vh;
}

.application--have-auth-background {
  /* #eeeeee */
  background: #40b9be url(https://orig00.deviantart.net/2ee4/f/2014/007/8/f/google_abstract_by_dynamicz34-d718hzj.png) !important;
}

.application--have-settings-background {
  background: #fafafa !important;
}

.v-content__wrap {
  transition: padding-top 0.5s ease-out;
}
</style>
