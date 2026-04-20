<template>
  <div class="relative w-full h-[80vh] overflow-hidden">
    <!-- Slides -->
    <div
      v-for="(slide, index) in Bannerslides"
      :key="index"
      class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
      :class="{
        'opacity-90 z-20': currentSlide === index,
        'opacity-0 z-10 pointer-events-none': currentSlide !== index
      }"
    >
      <picture class="w-full h-full block">
        <!-- Desktop -->
        <source :srcset="slide.image.desktop" media="(min-width: 1024px)" />
        <!-- Tablet -->
        <source :srcset="slide.image.tablet" media="(min-width: 640px)" />
        <!-- Mobile (fallback) -->
        <img
          :src="slide.image.mobile"
          alt=""
          class="w-full h-full object-cover"
          draggable="false"
        />
      </picture>

      <!-- Text overlay -->
      <div
        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 pointer-events-none p-4 lg:p-0 "
      >
        <h2 class="text-white text-2xl md:text-5xl font-bold text-center">
          {{ slide.text }} {{ $t(slide.textKey) }}
        </h2>
      </div>
    </div>

    <!-- Botón izquierdo -->
    <button
      @click="prevSlide"
      class="absolute left-4 top-1/2 transform -translate-y-1/2 
      bg-black bg-opacity-75 text-white rounded-full p-3 hover:bg-opacity-75 transition z-30 mt-6"
      aria-label="Anterior"
      type="button"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
      >
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- Botón derecho -->
    <button
      @click="nextSlide"
      class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-75 text-white rounded-full p-3 hover:bg-opacity-75 transition z-30 mt-6"
      aria-label="Siguiente"
      type="button"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
      >
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const Bannerslides = ref([
  {
    image: {
      mobile: 'https://www.magictourspv.com/storage/images/banner-home/ritmos-de-la-noche-small.jpg',
      tablet: 'https://www.magictourspv.com/storage/images/banner-home/ritmos-de-la-noche-medium.jpg',
      desktop: 'https://www.magictourspv.com/storage/images/banner-home/ritmos-de-la-noche-large.jpg',
    },
    textKey: 'banner.text_1'
    // text: 'Explore Beautiful Beaches',
  },
  {
    image: {
      mobile: 'https://www.magictourspv.com/storage/images/banner-home/las-caletas-small.jpg',
      tablet: 'https://www.magictourspv.com/storage/images/banner-home/las-caletas-medium.jpg',
      desktop: 'https://www.magictourspv.com/storage/images/banner-home/las-caletas-large.jpg',
    },
    textKey: 'banner.text_2'
    // text: 'Adventure in the Mountains',
  },
  {
    image: {
      mobile: 'https://www.magictourspv.com/storage/images/banner-home/nado-con-delfines-small.jpg',
      tablet: 'https://www.magictourspv.com/storage/images/banner-home/nado-con-delfines-medium.jpg',
      desktop: 'https://www.magictourspv.com/storage/images/banner-home/nado-con-delfines-large.jpg',
    },
    textKey: 'banner.text_3'
    // text: 'Discover Stunning Cities',
  },
])

const currentSlide = ref(0)
let interval = null

const startSlider = () => {
  interval = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % Bannerslides.value.length
  }, 8000)
}

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % Bannerslides.value.length
  resetInterval()
}

const prevSlide = () => {
  currentSlide.value =
    (currentSlide.value - 1 + Bannerslides.value.length) % Bannerslides.value.length
  resetInterval()
}

const resetInterval = () => {
  clearInterval(interval)
  startSlider()
}

onMounted(() => {
  startSlider()
})

onUnmounted(() => {
  clearInterval(interval)
})
</script>
