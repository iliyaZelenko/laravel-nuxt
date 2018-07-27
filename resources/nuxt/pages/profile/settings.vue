<template>
  <div style="height: 100%;">


  <!-- <v-container> -->
    <v-layout v-if="$auth.user" fill-height wrap>
      <!-- md4 -->
      <v-flex class="profile-settings__navigation-drawer-parent" xs12 sm5 md3 lg3 xl2>
        <!-- width: 20%; float: left; min-width: 280px !important; max-width: 300px !important; -->
        <!-- <div style="height: 100%;"> -->


          <!-- width="auto" -->
          <v-navigation-drawer :class="{
              'profile-settings__navigation-drawer': true,
              'profile-settings__navigation-drawer_fixed': $vuetify.breakpoint.mdAndUp
            }"
            width="unset"
            :fixed="$vuetify.breakpoint.mdAndUp"
            permanent
            clipped
          >
            <v-toolbar flat>
              <v-toolbar-title>
                Настрйоки
              </v-toolbar-title>
            </v-toolbar>

            <v-divider />

            <settings-menu />
          </v-navigation-drawer>
        <!-- </div> -->

      </v-flex>
      <!-- md8 -->
      <v-flex xs12 sm7 md9 lg9 xl8>
        <!-- <div style=""> -->
          <!-- <v-layout v-if="$auth.user" fill-height wrap> -->
            <!-- <v-flex xs12 sm7 md8 lg9 xl8> -->

              <settings-menu-toolbar />
              <settings-content />

            <!-- </v-flex> -->
            <!--  lg2 Чтобы было равнее lg должен быть 3!!! -->
            <!-- <v-flex hidden-lg-and-down xl2>
            </v-flex> -->
          <!-- </v-layout> -->
        <!-- </div> -->
      </v-flex>
    </v-layout>
      <!-- <v-flex xs12 sm7 md8 lg9 xl10> -->
      <!-- Чтобы было равнее lg должен быть 6!!! -->

    <!-- </v-layout> -->
  <!-- </v-container> -->
  </div>
</template>

<script>
  import mixinlayoutElements from '~/mixins/helpers/layoutElements'
  import SettingsMenu from '~/components/profile/current-user/settings/Menu'
  import SettingsMenuToolbar from '~/components/profile/current-user/settings/MenuToolbar'
  import SettingsContent from '~/components/profile/current-user/settings/Content'

  export default {
    middleware: 'auth',
    mixins: [mixinlayoutElements],
    components: { SettingsMenu, SettingsMenuToolbar, SettingsContent },
    data: () => ({}),
    methods: {

    },
    mounted () {
      this.$nextTick(this.mixinslayoutElements_profileInterfaceSetStyles)

      // странно как оно работает без bind
      window.addEventListener('resize', this.mixinslayoutElements_profileInterfaceSetStyles)
    },
    // watch: {
    //   'profileToolbar.style.'
    // },
    beforeDestroy () {
      window.removeEventListener('resize', this.mixinslayoutElements_profileInterfaceSetStyles)
    }
  }
</script>

<style>
  .profile-settings__navigation-drawer {
    width: auto !important;
    /* max-width: inherit !important; */
    /* width: auto !important; */
    /* width: auto !important; */
    padding-bottom: 0 !important;
    /* top: 48px;  */
  }

  .profile-settings__navigation-drawer_fixed {
    /* bottom: 0; */
    /* left: 0; */
    /* overflow-x: hidden; */
    /* overflow-y: auto; */
    /* position: fixed; */
    /* top: 48px; */
    /* 64px; */
    /* width: 279px; */
    /* width: 20% !important; */
    /* width: inherit !important; */


    z-index: 0;
    width: inherit !important;
    min-width: inherit !important;
    max-width: inherit !important;
    /* width: 300px !important; */
    /* min-width: 280px !important; */
    /* max-width: 300px !important; */



    /* max-width: inherit; */
  }


  .profile-settings__toolbar {
    z-index: 1;
  }

  .profile-settings__toolbar_fixed {
    /* left: 20%; */
    /* width: 80% !important; */
    /* left: 279px; */
    /* 263px; */
    /* overflow-x: hidden; */
    /* overflow-y: auto; */
    /* position: fixed; */
    /* top: 48px; */
  }
</style>
