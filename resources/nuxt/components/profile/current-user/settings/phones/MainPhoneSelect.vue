<template>
  <v-select
    v-model="mainPhone"
    :items="$auth.user.phones"
    :loading="setMainPhoneLoading"
    item-text="numberFormated"
    prepend-icon="phone"
    class="mt-2"
    style="max-width: 300px;"
    hide-details
    return-object
  >
    <template
      slot="selection"
      slot-scope="{ item }"
    >
      <img :src="getFlag(item.country)" class="country-flag" style="max-width: 30px;">
      <span class="ml-2">{{ item.numberFormated }}</span>
    </template>
    <template
      slot="item"
      slot-scope="{ item }"
    >
      <img :src="getFlag(item.country)" class="country-flag" style="max-width: 30px;">
      <span class="ml-2">{{ item.numberFormated }}</span>
    </template>
  </v-select>
</template>

<script>
  import { mapActions } from 'vuex'
  import { getFlag } from '~/tools/helpers'

  export default {
    data () {
      return {
        mainPhone: this.$auth.user.mainPhone,
        setMainPhoneLoading: false
      }
    },
    methods: {
      getFlag,
      ...mapActions('profileSettings', ['setMainPhone'])
    },
    watch: {
      async mainPhone ({ id }) {
        if (this.$auth.user.mainPhone && id === this.$auth.user.mainPhone.id) {
          return
        }
        this.setMainPhoneLoading = true
        await this.setMainPhone({ id })
        this.mainPhone = this.$auth.user.mainPhone
        this.setMainPhoneLoading = false
      },
      '$auth.user.phones' () {
        this.mainPhone = this.$auth.user.mainPhone
      }
    }
  }
</script>
