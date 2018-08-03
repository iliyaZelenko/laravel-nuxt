<template>
  <div class="text-xs-center">
    <v-progress-circular
      v-if="!socAccounts"
      indeterminate
      color="primary"
    />
    <v-layout justify-space-between>
        <v-btn
          v-if="socAccounts"
          v-for="(provider, index) in socAccounts"
          @click="click(provider.name, index)"
          :key="provider.name"
          :loading="btnIndexForLoading === index"
          :style="'color: ' + provider.color"
          class="mx-2"
          flat
          icon
          large
        >
          <font-awesome-icon :icon="['fab', provider.icon]" size="3x" />
        </v-btn>
    </v-layout>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import FontAwesomeIcon from '@fortawesome/vue-fontawesome'

export default {
  components: { FontAwesomeIcon },
  data: () => ({
    socAccounts: null,
    // provider оне не хотело менять(хотел сделать свойство loading)
    btnIndexForLoading: null
  }),
  methods: {
    async click (name, index) {
      this.btnIndexForLoading = index
      location.href = await this.getRedirectUrl(name)
      this.btnIndexForLoading = null
    },
    ...mapActions(['getSocialiteProviders']),
    ...mapActions('authSocialite', ['getRedirectUrl'])
  },
  async beforeMount () {
    this.socAccounts = await this.getSocialiteProviders()
  }
}
</script>
