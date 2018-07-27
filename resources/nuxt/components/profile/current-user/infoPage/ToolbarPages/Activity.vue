<template>
  <div>
    <v-card>
      <v-card-title>
        <avatar :user="user" />
        <div class="ml-3">
          <b>{{ user.nickname }}</b><span class="pl-2 grey--text">добавил видео</span><br>
          <span class="grey--text">13.07.2018</span>
        </div>

        <v-spacer />

        <v-btn icon large>
          <v-icon color="green">thumb_up_alt</v-icon>
          <small>543</small>
        </v-btn>
        <v-btn icon large>
          <v-icon color="red">thumb_down_alt</v-icon>
          <small>44</small>
        </v-btn>

      </v-card-title>
      <v-card-text style="overflow-y: auto;">
        <div style="overflow: auto;">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/1ZYbU82GVz4" frameborder="0" allow="autoplay; encrypted-media" class="mx-3" style="float: right; border-radius: 10px; border: 5px inset grey;" allowfullscreen />
          <p>Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
          Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
          Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.<br>
          Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
          Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
          Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
          Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.</p>
          <p>Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
          Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
          Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
          Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.</p>
        </div>
        <v-textarea
          @click:append-outer=""
          class="mt-3"
          placeholder="Оставить кооментарий"
          append-outer-icon="send"
          height="56"
          hide-details box single-line
        />
      </v-card-text>
    </v-card>

    <v-card class="mt-3">
      <v-card-title>
        <avatar :user="user" />
        <div class="ml-3">
          <b>{{ user.nickname }}</b><span class="ml-2 grey--text">добавил фото</span><br>
          <span class="grey--text">10.07.2018</span>
        </div>

        <v-spacer />

        <v-btn icon large>
          <v-icon color="green">thumb_up_alt</v-icon>
          <small>43</small>
        </v-btn>
        <v-btn icon large>
          <v-icon color="red">thumb_down_alt</v-icon>
          <small>4</small>
        </v-btn>

      </v-card-title>
      <v-card-text style="overflow-y: auto;">
        <figure class="px-3 py-3" style="float: right; width: 35%;">
          <img src="https://picsum.photos/800/600" style="width: 100%; border-radius: 10px; border: 2px inset grey;">
          <figcaption class="grey--text text-xs-center">Подпись</figcaption>
        </figure>

        <figure class="px-3 py-3" style="float: right; width: 35%;">
          <img src="https://picsum.photos/900/600" style="width: 100%; border-radius: 10px; border: 2px inset grey;">
          <figcaption class="grey--text text-xs-center">Подпись</figcaption>
        </figure>
        <p>Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.<br>
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        </p><p>Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.</p>
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        <v-textarea
          @click:append-outer=""
          class="mt-3"
          placeholder="Оставить кооментарий"
          append-outer-icon="send"
          height="56"
          hide-details box single-line
        />
      </v-card-text>
    </v-card>

    <v-card class="mt-3">
      <v-card-title>
        <avatar :user="user" />
        <div class="ml-3">
          <b>{{ user.nickname }}</b><span class="ml-2 grey--text">добавил запись</span><br>
          <span class="grey--text">01.07.2018</span>
        </div>

        <v-spacer />

        <v-btn icon large>
          <v-icon color="green">thumb_up_alt</v-icon>
          <small>3</small>
        </v-btn>
        <v-btn icon large>
          <v-icon color="red">thumb_down_alt</v-icon>
          <small>0</small>
        </v-btn>

      </v-card-title>
      <v-card-text>
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        Бла-бал бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла бла-бла.
        <v-textarea
          @click:append-outer=""
          class="mt-3"
          placeholder="Оставить кооментарий"
          append-outer-icon="send"
          height="56"
          hide-details box single-line
        />
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
