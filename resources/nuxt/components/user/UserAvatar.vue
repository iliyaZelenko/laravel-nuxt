<template>
  <span>
    <template v-if="avatar">
      <!-- ref="avatar" -->
      <!-- TODO это можно оптимизировать -->
      <img
        v-if="sizeName === 'lg'"
        :src="avatar"
        :alt="alt"
        :width="sizes.lg"
        :class="{['user-avatar__img user-avatar__img_large elevation-3 ' + imgClass]: true, 'user-avatar__img--border-bottom-reset': resetBorderBottomRadius}"
      />
      <img
        v-if="sizeName === 'md'"
        :src="avatar"
        :alt="alt"
        :width="sizes.md"
        :class="{['user-avatar__img user-avatar__img_medium elevation-3 ' + imgClass]: true, 'user-avatar__img--border-bottom-reset': resetBorderBottomRadius}"
      />
      <img
        v-if="sizeName === 'sm'"
        :src="avatar"
        :alt="alt"
        :width="sizes.sm"
        :class="{['user-avatar__img user-avatar__img_small elevation-3 ' + imgClass]: true, 'user-avatar__img--border-bottom-reset': resetBorderBottomRadius}"
      />
      <v-avatar v-if="sizeName === 'circle'" size="auto" :class="{['user-avatar__img user-avatar__img_circle ' + imgClass]: true, 'user-avatar__img--border-bottom-reset': resetBorderBottomRadius}">
        <img :src="avatar" class="elevation-3" alt="Аватар" />
      </v-avatar>
    </template>
    <v-icon v-else large>person</v-icon>
  </span>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  props: {
    user: Object,
    url: String,
    resetBorderBottomRadius: Boolean,
    imgClass: String,
    sizeName: {
      type: String,
      'default': 'circle'
    }
  },
  data: () => ({
    alt: 'Аватар',
    sizes: process.env.avatarSizes
  }),
  computed: {
    userForAvatar () {
      return this.user || this.$auth.user
    },
    avatar () {
      return this.url
        ? this.url
        : this.userForAvatar.avatar
          ? this.userAvatar(this.userForAvatar, this.sizeName)
          : null
    },
    ...mapGetters('user', ['userAvatar'])
  }
}
</script>

<style lang="stylus">
$avatarsTypes = {
  large: {
    r: 25px,
    mw: 320px
  },
  medium: {
    r: 20px,
    mw: 200px
  },
  small: {
    r: 15px,
    mw: 133px
  },
  circle: {
    mw: 38px
  },
}
/* :root {

} */

.user-avatar__img
  display: block;
  width: 100% !important;
  height: auto !important;

  // $user-avatar-large-size = 320px;
  // $user-avatar-medium-sizee = 200px;
  // $user-avatar-small-sizee = 133px;
  // $user-avatar-circle-sizee = 44px;
  //
  // $user-avatar-large-border: 320px;
  // $user-avatar-medium-border: 200px;
  // $user-avatar-small-border: 133px;
  // $user-avatar-circle-border: 44px;

  /* border-radius: 25px; */

.user-avatar__img--border-bottom-reset
  border-bottom-width: 2px !important;
  border-bottom-left-radius: 0 !important;
  border-bottom-right-radius: 0 !important;

.user-avatar__img_circle
  display: inline-flex;

for $type, $options in $avatarsTypes
  .user-avatar__img_{$type}
    max-width: $options.mw
    if ($options.r)
      border-radius: $options.r;

// .user-avatar__img_large {
//   border-radius: 25px;
//   max-width: var(--user-avatar-large-size);
//   /* max-height: 100%; */
//   /* max-width: 100%; /* 333px */
//   /* max-height: 240px;
//   width: 333px;
//   height: 250px; */
// }
//
// .user-avatar__img_medium {
//   border-radius: 20px;
//   max-width: var(--user-avatar-medium-size);
//   /* max-height: 150px; */
// }
//
// .user-avatar__img_small {
//   border-radius: 15px;
//   max-width: var(--user-avatar-small-size);
//   /* max-height: 100px; */
//   /* max-width: 66px;
//   max-height: 50px; */
// }
//
// .user-avatar__img_circle {
//   max-width: var(--user-avatar-circle-size);
// }
</style>
