<template>
  <!--  64px был паддинг class="pt-4 pb-5" -->
  <v-container
    :style="$vuetify.breakpoint.mdAndUp ? 'padding-top: 80px;' : ''"
    fill-height
  >
    <div style="height: 100%; width: 100%; padding-bottom: 100px !important;">
      <email-verification-alert :class="$vuetify.breakpoint.mdAndUp ? 'padding-variant-1' : 'padding-variant-2'" />

      <!-- <v-layout row wrap>
        <v-flex xs12 lg9 xl10> -->
      <v-layout
        :style="userHaveGlobalMessage() ? '' : 'height: 100%;'"
        justify-center
        align-center
      >
        <!-- <v-flex :class="$vuetify.breakpoint.mdAndUp ? 'padding-variant-1' : 'padding-variant-2'" xs12> -->

        <!-- <slot /> -->
        <nuxt-child/>
        <!-- </v-flex> -->
      </v-layout>
      <!-- </v-flex> -->
      <!-- эта колонка для того чтобы контент был по центру, она размером как колонка слева -->
      <!-- <v-flex lg3 xl2></v-flex>
      </v-layout> -->
    </div>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import EmailVerificationAlert from '~/components/auth/EmailVerificationAlert'

export default {
  components: { EmailVerificationAlert },
  computed: {
    ...mapGetters('user', ['userHaveGlobalMessage'])
  }
}
</script>
