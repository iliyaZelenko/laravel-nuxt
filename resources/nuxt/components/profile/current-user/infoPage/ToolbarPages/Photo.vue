<template>
  <div>
    <!-- https://picsum.photos/800/600 -->
    <v-container fluid grid-list-sm>
      <v-layout row wrap justify-center>
        <v-flex v-for="i in 40" :key="i" xs2>
          <img :src="`https://picsum.photos/150/300?image=${i}`" width="100%">
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
export default {

}
</script>
