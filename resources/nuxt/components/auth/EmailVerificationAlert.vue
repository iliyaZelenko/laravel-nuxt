<template>
    <v-scale-transition appear>
      <v-layout v-if="userHaveGlobalMessage()" justify-center>
        <!-- transition="slide-y-transition" -->
        <v-alert
          v-if="underToolbar"
          :type="getInfoByUserData('alertType')"
          :value="true"
          :style="underToolbarShowMiniMessage ? 'max-width: 900px;': 'max-width: 901px;'"
          class="email-verification-alert email-verification-alert_under-toolbar"

        >
          <v-slide-y-transition mode="out-in">
            <div v-if="underToolbarShowMiniMessage">
              <span class="title">{{ getInfoByUserData('title') }}</span>
              <v-btn @click="underToolbarShowMiniMessage = false" color="primary" class="ml-3">
                Подробнее
              </v-btn>
            </div>
            <email-verification-alert-content
              v-else
              @click-hide="underToolbarShowMiniMessage = true"
              :content-type="getInfoByUserData('contentType')"
              under-toolbar
            />
          </v-slide-y-transition>
        </v-alert>

        <!-- <v-alert
          :type="getInfoByUserData('alertType')"
          :value="!underToolbarShowMiniMessage"
          class="email-verification-alert email-verification-alert_under-toolbar"
        >
          <email-verification-alert-content @click-hide="underToolbarShowMiniMessage = true" />
        </v-alert> -->

        <v-alert
          v-if="!underToolbar"
          :type="getInfoByUserData('alertType')"
          :value="true"
          class="email-verification-alert mt-4 mb-4"
        >
          <email-verification-alert-content :content-type="getInfoByUserData('contentType')" :title="getInfoByUserData('title')" />
        </v-alert>
      </v-layout>
    </v-scale-transition>
</template>

<script>
  import { mapGetters } from 'vuex'
  import mixinlayoutElements from '~/mixins/helpers/layoutElements'
  import EmailVerificationAlertContent from '~/components/auth/EmailVerificationAlertContent'

  export default {
    mixins: [mixinlayoutElements],
    components: { EmailVerificationAlertContent },
    props: {
      underToolbar: Boolean
    },
    data: () => ({
      underToolbarShowMiniMessage: true
    }),
    // methods: {
    //   setTopProperyByAppToolbarHeight () {
    //     const toolbar = document.querySelector('.email-verification-alert_under-toolbar')
    //     const el = document.querySelector('.app-toolbar')
    //     if (el && toolbar) {
    //       toolbar.style.top = `${el.offsetHeight}px`
    //     }
    //   }
    // },
    computed: {
      // alertType () {
      //   if (this.$auth.user.mainEmail) {
      //     if (!this.$auth.user.mainEmail.verified) {
      //       return this.$auth.user.activated ? 'info' : 'warning'
      //     }
      //   } else {
      //     return 'info'
      //   }
      // },
      getInfoByUserData () {
        return infoType => {
          const infoText = {
            noActivated: ['warning', 'У Вас не активирован аккаунт!', 0],
            noEmailVerified: this.$auth.user.mainEmail ? ['info', `У Вас не подтверждена почта ${this.$auth.user.mainEmail.email}.`, 1] : null,
            noEmail: ['info', 'В вашем аккаунте нет почты.', 2]
          }
          let index

          if (infoType === 'alertType') {
            index = 0
          } else if (infoType === 'title') {
            index = 1
          } else if (infoType === 'contentType') {
            index = 2
          } else {
            throw new Error('Неизвестный тип')
          }

          if (this.$auth.user.mainEmail) {
            if (!this.$auth.user.mainEmail.verified) {
              return this.$auth.user.activated ? infoText.noEmailVerified[index] : infoText.noActivated[index]
            }
          } else {
            return infoText.noEmail[index]
          }
        }
      },
      ...mapGetters('user', ['userHaveGlobalMessage'])
      // ...mapGetters('user', ['userNeedActivateAccountOrVerifyEmail'])
    },
    mounted () {
      this.mixinslayoutElements_emailVerificationAlertUnderToolbarSetTop()

      window.addEventListener('resize', this.mixinslayoutElements_emailVerificationAlertUnderToolbarSetTop)
    },
    updated () { // по идее когда меняешь код то делается ре-рендеринг
      this.$nextTick(() => {
        this.mixinslayoutElements_emailVerificationAlertUnderToolbarSetTop()
      })
    },
    watch: {
      '$route': function () {
        this.mixinslayoutElements_emailVerificationAlertUnderToolbarSetTop()
      }
    },
    beforeDestroy () {
      window.removeEventListener('resize', this.mixinslayoutElements_emailVerificationAlertUnderToolbarSetTop)
    }
  }
</script>

<style>
  .email-verification-alert {
    /* width: 100%; */
  }

  .email-verification-alert_under-toolbar {
    /* max-width: 100%; */
    z-index: 2 !important; /* z-index: 3 !important; */
    position: fixed !important;
    /* right: 0; */
    /* left: 0; */
    /* margin: 0 auto; */

    --radius: 25px;

    /* transition: width 2s, height 4s; */
    transition: max-width .5s ease !important;
    /* transition: width 1s ease-out; */
    /* transition: all .2s ease-in-out; */
    margin-top: 0;
    border-bottom-left-radius: var(--radius) !important;
    border-bottom-right-radius: var(--radius) !important;
    border-top-left-radius: unset !important;
    border-top-right-radius: unset !important;
  }
</style>
