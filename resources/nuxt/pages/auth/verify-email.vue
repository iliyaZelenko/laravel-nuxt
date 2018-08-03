<template>
  <v-container fill-height>
    <v-layout fill-height justify-center align-center>
      <v-alert :value="true" type="info" class="display-1 text-xs-center">

        Обрабатываем...

      </v-alert>
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  data: () => ({}),
  methods: {
    ...mapActions('auth', [
      'verifyEmail'
    ])
  },
  computed: {
    token () {
      return this.$route.query.token
    }
  },
  async mounted () {
    console.log(this.token)
    await this.verifyEmail(this.token)
  }
}
</script>
