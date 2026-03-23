<template>
  <div class="default-template">
    <h1>{{ tour.title }} - Tour Default</h1>
    <img :src="getImageUrl(tour.image)" alt="" v-if="tour.image" />
    <p v-html="tour.description"></p>
    <p v-if="tour.description_2" v-html="tour.description_2"></p>
  </div>
</template>

<script setup>
defineProps({
  tour: Object
})

const baseURL = window.location.hostname.includes('localhost')
  ? 'http://localhost:8000'
  : 'https://www.magictourspv.com'

const getImageUrl = (path) => path ? `${baseURL}${path}` : ''
</script>

<style scoped>
.default-template {
  padding: 1rem;
}
.default-template img {
  max-width: 100%;
  margin: 1rem 0;
}
</style>
