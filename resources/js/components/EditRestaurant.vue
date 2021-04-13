<template>
  <div class="p-8">
    <general></general>
    <div class="border-b border-gray-200 mb-8 pt-8"></div>
    <user></user>
    <div class="border-b border-gray-200 mb-8 pt-8"></div>
    <rooms></rooms>
    <div class="border-b border-gray-200 mb-8 pt-8"></div>
    <tables></tables>
  </div>
</template>

<script>
import store from '../store';

export default {
  name: 'EditRestaurant',
  props: ['restaurant'],
  store,
  mounted() {
    this.$store.commit('updateSelectedRestaurant', this.restaurant);
  },
};
</script>

<style scoped></style>
