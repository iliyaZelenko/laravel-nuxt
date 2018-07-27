<template>
  <!-- color="green darken-2" -->
  <!-- dense -->
  <!-- padding-left: 130px; padding-right: 130px; -->
  <!-- style="padding-left: 230px; padding-right: 230px;" -->
  <!-- extended dense tabs -->
  <v-toolbar class="app-toolbar" clipped-left fixed app dark>
    <!-- <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon> -->
    <!-- <img src="~/assets/vuetify.png" height="38px" width="38px"> -->
    <!-- <img src="https://www.freelogodesign.org/img/logo-ex-5.png" height="150px"> -->
    <!-- http://mediad.publicbroadcasting.net/p/wsdl/files/201510/chemours_website.png -->
    <img
      @click="$router.push('/')"
      class="app-toolbar__logo"
      src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/1000px-Google_2015_logo.svg.png"
      height="30px"
    >

    <!-- <v-toolbar-title @click="$router.push('/')" style="cursor: pointer"> -->
      <!-- Заголовок -->
    <!-- </v-toolbar-title> -->



    <v-spacer />



    <!-- <v-btn class="ml-3 mr-2" icon>
      <v-icon large>notifications</v-icon>
    </v-btn> -->
    <!-- <v-btn to="/security" flat>
      Под защитой
      <v-icon right>security</v-icon>
    </v-btn> -->
    <v-text-field
      @click:append=""
      append-icon="mic"
      prepend-inner-icon="search"
      class="hidden-sm-and-down mx-3"
      label="Поиск"
      hide-details
      solo-inverted
      flat
      dense
    />

    <v-spacer />


    <template v-if="$auth.loggedIn && $auth.user">

      <the-toolbar-user-notifications />

      <v-divider vertical inset />

      <the-toolbar-user-menu />

    </template>
    <v-toolbar-items v-else>
      <v-btn to="/auth/signin" flat>
        <!-- account_box -->
        <!-- <v-icon left>person</v-icon> -->
        <!-- <v-icon left>account_box</v-icon> -->
        <!-- large -->
        <v-icon left>directions_walk</v-icon>
        Войти
      </v-btn>

      <v-divider vertical />

      <v-btn to="/auth/signup" flat>
        <v-icon left>person_add</v-icon>
        Зарегестрироваться
      </v-btn>
    </v-toolbar-items>


    <!-- TODO width: 100%; может и не нужно -->
    <!-- <v-layout style="width: 100%;" slot="extension" fill-height align-end>
      <v-flex xs8>
        <v-tabs
          :hide-slider="!tabs.find(tab => tab.to === $route.fullPath)"
          color="transparent"
          fixed-tabs
          show-arrows
        >
          <v-tab v-for="tab in tabs" :key="tab.text" :to="tab.to" exact>
            <v-icon v-if="tab.icon" class="mr-3">{{ tab.icon }}</v-icon>
            {{ tab.text }}
          </v-tab>
        </v-tabs>
      </v-flex>
      <v-flex xs4>
        <v-text-field
          @click:append=""
          append-icon="mic"
          prepend-inner-icon="search"
          class="mx-3"
          label="Поиск"
          solo-inverted
          flat
        ></v-text-field>
      </v-flex>
    </v-layout> -->



  </v-toolbar>
</template>

<script>
  import TheToolbarUserNotifications from '~/components/layouts/default/TheToolbarUserNotifications'
  import TheToolbarUserMenu from '~/components/layouts/default/TheToolbarUserMenu'

  export default {
    components: { TheToolbarUserNotifications, TheToolbarUserMenu },
    data: () => ({
      tabs: [
        {text: 'Главаня', to: '/', icon: 'home'},
        {text: 'О нас', to: '/#1'},
        {text: 'Цены', to: '/#2'},
        {text: 'Форум', to: '/#3'},
        {text: 'Поддержка', to: '/#4'}
      ]
    })
  }
</script>

<style>
  .app-toolbar {
    background-color: #202124;
    /* height: 150px; */
  }

  /* .app-toolbar .v-toolbar__extension {
    height: 60px !important;
  } */

  .app-toolbar__logo {
    cursor: pointer;
    /* background-color: white;*/
    /* padding: 3px; */
    margin-left: 30px;
    /* border-radius: 14px; */
  }
</style>
