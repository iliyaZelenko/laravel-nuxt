<template>
  <!-- fill-height не подходит так как там используется не только полная высота -->
  <v-container style="height: 100%;" class="pt-0" v-if="user">


    <profile-cover :user="user" :is-current-user="isCurrentUser" />


    <profile-toolbar :currentItem.sync="toolbarCurrentItem" :items="toolbarItems" :more="toolbarMore" />


    <v-container fluid grid-list-xl>
      <v-layout wrap>
        <v-flex xs12 sm5 md4 lg4 xl3>

          <main-info :user="user" />

        </v-flex>
        <v-flex xs12 sm7 md8 lg8 xl9>

          <v-tabs-items v-model="toolbarCurrentItem" class="px-1">
            <v-tab-item
              v-for="item in toolbarItems.concat(toolbarMore)"
              :id="'tab-' + item.text"
              :key="item.text"
            >
              <!-- <p class="headline">{{ item.text }}</p> -->
              <component :is="item.component" :user="user"/>
            </v-tab-item>
          </v-tabs-items>

        </v-flex>
      </v-layout>
    </v-container>


    <v-layout v-if="!user" fill-height justify-center align-center>
      <v-alert :value="true" type="error">
        Не удалось найти пользователя с ником <b>{{ $route.params.nickname }}</b>.
        <v-btn @click="$router.go(-1)" color="primary">
          <v-icon left>arrow_back</v-icon>
          Назад
        </v-btn>
      </v-alert>
    </v-layout>


  </v-container>
</template>

<script>
  import { mapActions } from 'vuex'
  import MainInfo from '~/components/profile/current-user/infoPage/MainInfo'
  import ProfileCover from '~/components/profile/current-user/infoPage/Cover'
  import ProfileToolbar from '~/components/profile/current-user/infoPage/Toolbar'
  import ProfileToolbarPageActivity from '~/components/profile/current-user/infoPage/ToolbarPages/Activity'
  import ProfileToolbarPageFriends from '~/components/profile/current-user/infoPage/ToolbarPages/Friends'
  import ProfileToolbarPagePhoto from '~/components/profile/current-user/infoPage/ToolbarPages/Photo'
  import ProfileToolbarPageNews from '~/components/profile/current-user/infoPage/ToolbarPages/News'

  export default {
    components: { MainInfo, ProfileCover, ProfileToolbar, ProfileToolbarPageActivity, ProfileToolbarPageFriends, ProfileToolbarPagePhoto, ProfileToolbarPageNews },
    async asyncData ({ params, store, app }) {
      try {
        let user, isCurrentUser

        if ((isCurrentUser = app.$auth.loggedIn && app.$auth.user.nickname === params.nickname)) {
          user = app.$auth.user
        } else {
          user = await store.dispatch('otherProfile/getUser', params.nickname)
        }
        console.log(user)

        return { user, isCurrentUser }
      } catch ({ response }) {
        app.$notify.error(response.data.message)
      }
    },
    data: () => ({
      toolbarCurrentItem: 'tab-Активность',
      toolbarItems: [
        {
          text: 'Активность',
          component: 'ProfileToolbarPageActivity'
        },
        {
          text: 'Друзья',
          component: 'ProfileToolbarPageFriends'
        },
        {
          text: 'Фото',
          component: 'ProfileToolbarPagePhoto'
        }
        // 'Видео', 'Музыка'
      ],
      toolbarMore: [
        {
          text: 'Новости',
          component: 'ProfileToolbarPageNews'
        }
        // , 'Карты', 'Книги', 'Приложения'
      ],
      text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
    }),
    methods: {
      ...mapActions('otherProfile', ['getUser'])
    },
    head () {
      return {
        title: this.isCurrentUser ? 'Ваш профиль' : 'Прфоиль ' + (this.user ? this.user.nickname : 'не найден!'),
        meta: [
          {
            content: this.isCurrentUser ? 'Информация о Вашем профиле' : (this.user ? 'Информация о профиле ' + this.user.nickname : 'Профиль не найден!'),
            name: 'description',
            hid: 'description'
          }
        ]
      }
    }
  }
</script>

<style>
  /* .current-user-profile__toolbar {
    height: 68px;
  } */

  /* .current-user-profile__toolbar_sticky { */
    /* position: sticky; */
    /* z-index: 1; */
    /* top: 130px; /* 230 */
  /* } */
</style>



<!-- <v-toolbar color="primary" :class="{'current-user-profile__toolbar': true, 'current-user-profile__toolbar_sticky': $vuetify.breakpoint.mdAndUp }" dark tabs>
  <v-tabs
    v-model="tabs"
    color="transparent"
    centered
    dark
    icons-and-text
  >
    <v-tabs-slider></v-tabs-slider>

    <v-tab href="#tab-1">
      Recents
      <v-icon>phone</v-icon>
    </v-tab>

    <v-tab href="#tab-2">
      Favorites
      <v-icon>favorite</v-icon>
    </v-tab>

    <v-tab href="#tab-3">
      Nearby
      <v-icon>account_box</v-icon>
    </v-tab>
  </v-tabs>
</v-toolbar>


<v-tabs-items v-model="tabs" class="mt-3">
  <v-tab-item
    v-for="i in 3"
    :id="'tab-' + i"
    :key="i"
  >
    <p>Content №{{ i }}: {{ text }}{{ text }}{{ text }}</p>
    <p>{{ text }}{{ text }}{{ text }}{{ text }}{{ text }}</p>
    <p>{{ text }}{{ text }}{{ text }}</p>
    <p>{{ text }}{{ text }}{{ text }}{{ text }}{{ text }}</p>
    <p>{{ text }}{{ text }}{{ text }}</p>
    <p>{{ text }}{{ text }}{{ text }}{{ text }}{{ text }}</p>
    <p>{{ i }}: {{ text }}{{ text }}{{ text }}</p>
    <p>{{ text }}{{ text }}{{ text }}</p>
  </v-tab-item>
</v-tabs-items> -->
