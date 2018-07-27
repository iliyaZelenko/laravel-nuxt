<template>
  <v-toolbar class="profile__toolbar" color="primary" dark dense>
    <!-- <v-toolbar-title>Title</v-toolbar-title> margin-bottom: 300px; -->
    <!-- <user-avatar class="hidden-md-and-down" v-if="user.avatar" :user="user" size-name="md" style="margin-bottom: 180px; margin-left: 10px;" /> -->

    <!-- <v-spacer /> -->
    <!-- <v-toolbar-items> -->

    <!-- <v-btn flat>Активность</v-btn>
    <v-divider vertical inset />
    <v-btn flat>Друзья</v-btn>
    <v-divider vertical inset />
    <v-btn flat>Фото</v-btn>
    <v-divider vertical inset />
    <v-btn flat>Видео</v-btn>
    <v-divider vertical inset />
    <v-btn flat>Музыка</v-btn> -->
    <v-tabs
     v-model="currentItemLocal"
     color="transparent"
     slider-color="yellow"
     fixed-tabs
     show-arrows
    >
     <v-tab
       v-for="item in items"
       :href="'#tab-' + item.text"
       :key="item.text"
     >
       {{ item.text }}
     </v-tab>

     <v-menu
       v-if="more.length"
       class="v-tabs__div"
       bottom
       left
     >
       <a slot="activator" class="v-tabs__item">
         Больше
         <v-icon>arrow_drop_down</v-icon>
       </a>

       <v-list class="grey lighten-3">
         <v-list-tile
           v-for="item in more"
           :key="item.text"
           @click="addItem(item)"
         >
           {{ item.text }}
         </v-list-tile>
       </v-list>
     </v-menu>
    </v-tabs>


    <!-- </v-toolbar-items> -->
    <!-- <v-spacer /> -->
    <!-- <div style="max-width: 10%; ">

    </div> -->
    <!-- <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn flat>Link One</v-btn>
      <v-btn flat>Link Two</v-btn>
      <v-btn flat>Link Three</v-btn>
    </v-toolbar-items>
    <v-spacer></v-spacer> -->
  </v-toolbar>
</template>

<script>
  export default {
    props: {
      currentItem: String,
      items: Array,
      more: Array
    },
    data () {
      return {
        currentItemLocal: this.currentItem
      }
    },
    methods: {
      addItem (item) {
        const removed = this.items.splice(0, 1)

        this.items.push(
          ...this.more.splice(this.more.indexOf(item), 1)
        )
        this.more.push(...removed)
        this.$nextTick(() => { this.currentItemLocal = 'tab-' + item.text })
      }
    },
    watch: {
      currentItemLocal (val) {
        this.$emit('update:currentItem', val)
      }
    }
  }
</script>

<style>
  .profile__toolbar {
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
  }
</style>
