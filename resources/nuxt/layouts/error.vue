<template>
  <v-layout style="height: 100vh;" align-center justify-center>
    <v-alert :value="true" type="error" class="display-1 text-xs-center">

      {{ text }}
      <br>

      <nuxt-link to="/">
        На главную
      </nuxt-link>

    </v-alert>
  </v-layout>
</template>

<script>
export default {
  props: ['error'],
  head () {
    return {
      title: `Ошибка ${this.error.statusCode}`
    }
  },
  computed: {
    text () {
      return this.error.statusCode === 404 ? 'Страница не найдена.' : `Произошла ошибка ${this.error.statusCode}.`
    }
  }
}
</script>
