<template>
  <!--
  :nudge-left="160"

  :nudge-right="180"
   -->
  <v-menu
    :nudge-width="0"
    :nudge-right="130"
    :close-on-content-click="false"
    left
    offset-y
    open-on-hover
    dark
    attach
  >
    <!-- large -->
    <v-btn class="mx-4" slot="activator" flat icon>
      <v-badge color="red" overlap>
        <span slot="badge">2</span>
        <v-icon medium>notifications</v-icon>
      </v-badge>
    </v-btn>
    <v-card>
      <v-list two-line>
        <template v-for="(item, index) in items">
          <v-list-tile
            :key="item.title"
            avatar
            ripple
            @click="toggle(index)"
          >
            <v-list-tile-content>
              <v-list-tile-title>{{ item.title }}</v-list-tile-title>
              <!-- <v-list-tile-sub-title class="text--primary">{{ item.headline }}</v-list-tile-sub-title> -->
              <v-list-tile-sub-title>{{ item.subtitle }}</v-list-tile-sub-title>
            </v-list-tile-content>
            <v-list-tile-action>
              <v-list-tile-action-text>{{ item.action }}</v-list-tile-action-text>
              <v-icon
                v-if="selected.indexOf(index) < 0"
                color="grey lighten-1"
              >visibility</v-icon>
              <v-icon
                v-else
                color="yellow darken-2"
              >visibility</v-icon>
            </v-list-tile-action>
          </v-list-tile>
          <v-divider v-if="index + 1 < items.length" :key="index"></v-divider>
        </template>
      </v-list>
    </v-card>
  </v-menu>
</template>

<script>
// import { mapGetters } from 'vuex'
import UserAvatar from '~/components/user/UserAvatar'

export default {
  components: { UserAvatar },
  data () {
    return {
      selected: [0, 1],
      items: [
        { action: '15 min', headline: 'Brunch this weekend?', title: 'Ali Connors', subtitle: "I'll be in your neighborhood doing ?" },
        { action: '2 hr', headline: 'Summer BBQ', title: 'me, Scrott, Jennifer', subtitle: "Wish I could come, but I'm out " },
        { action: '6 hr', headline: 'Oui oui', title: 'Sandra Adams', subtitle: 'Do you have Paris recommendations?' },
        { action: '12 hr', headline: 'Birthday gift', title: 'Trevor Hansen', subtitle: 'Have any ideas about what' },
        { action: '18hr', headline: 'Recipe to try', title: 'Britta Holt', subtitle: 'We should eat this: Grate, Squash' }
      ]
    }
  },

  methods: {
    toggle (index) {
      const i = this.selected.indexOf(index)

      if (i > -1) {
        this.selected.splice(i, 1)
      } else {
        this.selected.push(index)
      }
    }
  }
  // computed: {
  //   ...mapGetters('user', ['userAvatar'])
  // }
}
</script>

<style scoped>
  #logo {
    cursor: pointer;
    /* background-color: white;*/
    /* padding: 3px; */
    margin-left: 30px;
    /* border-radius: 14px; */
  }
</style>
