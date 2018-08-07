<template>
  <!-- <v-flex xs12 sm12 md10 lg8> width: 851px; height: 315px;  -->
  <div class="profile__cover grey" style="position: relative;">
    <div class="profile__cover-content">
      <v-btn v-if="isCurrentUser" to="/profile/settings" color="primary" class="elevation-0" style="left: 8px; position: absolute; top: 5px; opacity: 0.8;" small fab>
        <v-icon>photo_camera</v-icon>
      </v-btn>
      <!-- <v-parallax :src="require('~/assets/cover.jpg')" style="height: 100%;" dark> -->
      <!-- margin-left: 250px; -->
      <v-layout fill-height align-end>
        <!-- margin-bottom: 180px;  class="hidden-md-and-down"  -->
        <!-- <div> -->
          <user-avatar v-if="user.avatar" class="profile__avatar hidden-md-and-down" img-class="profile__avatar-img" :user="user" size-name="md" reset-border-bottom-radius />
          <user-avatar v-if="user.avatar" class="profile__avatar hidden-lg-and-up hidden-xs-only" img-class="profile__avatar-img" :user="user" size-name="sm" reset-border-bottom-radius />
          <v-btn v-if="user.avatar && isCurrentUser" to="/profile/settings" style="position: absolute; left: 166px; bottom: 2px; opacity: 0.8;" color="primary" class="hidden-md-and-down elevation-0" small fab>
            <v-icon>photo_camera</v-icon>
          </v-btn>
        <!-- </div> -->


        <span :class="{'profile__nickname white--text mb-2 ml-3': true, 'display-2 font-weight-black': $vuetify.breakpoint.lgAndUp, 'headline': !$vuetify.breakpoint.lgAndUp}">
          {{ user.nickname }}
        </span>

        <v-layout class="pr-3 mb-2" justify-end>


          <div class="hidden-md-and-down">
            <v-btn color="green lighten-1" dark small>
              <v-icon left>person_add</v-icon>
              Добавить в друзья
            </v-btn>
            <v-btn color="red lighten-1" dark small>
              <v-icon left>block</v-icon>
              Заблокировать
            </v-btn>
            <v-btn color="blue lighten-1" dark small>
              <v-icon left>chat</v-icon>
              Написать сообщение
            </v-btn>
          </div>


          <v-menu class="hidden-lg-and-up" offset-y>
            <v-btn slot="activator" color="primary" small dark>
              Действия
              <v-icon>arrow_drop_down</v-icon>
            </v-btn>
            <v-list>
              <v-list-tile @click="() => {}">
                <v-list-tile-title>
                  <v-icon class="mr-2">person_add</v-icon>
                  Добавить в друзья
                </v-list-tile-title>
              </v-list-tile>
              <v-list-tile @click="() => {}">
                <v-list-tile-title>
                  <v-icon class="mr-2">block</v-icon>
                  Заблокировать
                </v-list-tile-title>
              </v-list-tile>
              <v-list-tile @click="() => {}">
                <v-list-tile-title>
                  <v-icon class="mr-2">chat</v-icon>
                  Написать сообщение
                </v-list-tile-title>
              </v-list-tile>
            </v-list>
          </v-menu>


        </v-layout>
      </v-layout>
      <!-- </v-parallax> -->
    </div>
  </div>
</template>

<script>
import UserAvatar from '~/components/user/UserAvatar'

export default {
  props: {
    user: Object,
    isCurrentUser: Boolean
  },
  components: { UserAvatar }
}
</script>

<style>
  .profile__cover {
    height: 0;
    /* 2.7 0.3333  3/1  4/1 */
    padding-top: calc(500 / 2000 * 100%);

    background: url('~/assets/cover.jpg');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  .profile__cover-content {
    background: linear-gradient(rgba(0,0,0,0) 71%, rgba(0,0,0, .53));
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  .profile__avatar {
    /* background: linear-gradient(rgba(0,0,0,0) 71%, rgba(0,0,0, .53)); */
    margin-left: 25px;
    width: auto;
  }

  .profile__avatar-img {
    border: 4px inset #fff;
    /* border-width: initial initial 0 initial !important; */
    /* border-style: inset; */
    /* border-top-left-radius: 2px; */
    /* border-top-right-radius: 2px; */
  }

  .profile__nickname {
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 350px;
    text-rendering: optimizelegibility;
    text-shadow: 0 0 3px rgba(0,0,0,.8);
  }
</style>
