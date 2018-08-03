<template>
  <div>
    <v-card>
      <v-card-title>
        <div class="headline">
          Заголовок новости
        </div>

        <div class="ml-3">
          <v-icon>star</v-icon>
          <v-icon>star</v-icon>
          <v-icon>star_half</v-icon>
          <v-icon>star_border</v-icon>
        </div>


        <v-spacer />
        <avatar :user="user" />
        <div class="ml-3 mr-3">
          <b>{{ user.nickname }}</b><br>
          <span class="grey--text">13.07.2018</span>
        </div>
      </v-card-title>
      <v-card-text style="overflow-y: auto;">
        <p>Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла...</p>
        <v-btn class="right" color="primary">Читать больше</v-btn>
      </v-card-text>
    </v-card>



    <v-card class="mt-3">
      <v-card-title>
        <div class="headline">
          Заголовок новости
        </div>

        <div class="ml-3">
          <v-icon>star</v-icon>
          <v-icon>star</v-icon>
          <v-icon>star_half</v-icon>
          <v-icon>star_border</v-icon>
        </div>


        <v-spacer />
        <avatar :user="user" />
        <div class="ml-3 mr-3">
          <b>{{ user.nickname }}</b><br>
          <span class="grey--text">13.07.2018</span>
        </div>
      </v-card-title>
      <v-card-text style="overflow-y: auto;">
        <p>Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла...</p>
        <v-btn class="right" color="primary">Читать больше</v-btn>
      </v-card-text>
    </v-card>



    <v-card class="mt-3">
      <v-card-title>
        <div class="headline">
          Заголовок новости
        </div>

        <div class="ml-3">
          <v-icon>star</v-icon>
          <v-icon>star</v-icon>
          <v-icon>star_half</v-icon>
          <v-icon>star_border</v-icon>
        </div>


        <v-spacer />
        <avatar :user="user" />
        <div class="ml-3 mr-3">
          <b>{{ user.nickname }}</b><br>
          <span class="grey--text">13.07.2018</span>
        </div>
      </v-card-title>
      <v-card-text style="overflow-y: auto;">
        <p>Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла...
        </p>
        <v-btn class="right" color="primary">Читать больше</v-btn>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import avatar from '~/components/user/UserAvatar.vue'

export default {
  props: {
    user: Object
  },
  components: { avatar }
}
</script>
