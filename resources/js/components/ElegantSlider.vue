<template>
  <div class="relative w-full overflow-hidden py-10">

    <!-- Track -->
    <div
      ref="track"
      class="flex gap-6 cursor-grab active:cursor-grabbing transition-transform duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]"
      :style="{ transform: `translateX(${translateX}px)` }"
      @mousedown="start"
      @mousemove="move"
      @mouseup="end"
      @mouseleave="end"
      @touchstart="start"
      @touchmove="move"
      @touchend="end"
    >
      <div
        v-for="(item, i) in loopedItems"
        :key="i"
        class="flex-shrink-0 transition-all duration-800"
        :style="{ width: cardWidth + 'px' }"
      >
        <!-- CARD -->
        <div
          class="rounded-2xl overflow-hidden bg-white shadow-lg transition-all duration-500"
          :class="getClass(i)"
        >
          <img :src="item.image" class="h-80 w-full object-cover" draggable="false" />

          <!-- <div class="p-4">
            <h3 class="font-semibold text-lg">{{ item.title }}</h3>
            <p class="text-sm text-gray-500">{{ item.description }}</p>
          </div> -->
        </div>
      </div>
    </div>

    <!-- Botones -->
    <button @click="prev" class="nav left-4">←</button>
    <button @click="next" class="nav right-4">→</button>
  </div>
  <div class="flex items-center justify-center my-16">
      <button @click="openForm()"
            class="ml-4 px-6 py-3 
              bg-gradient-to-r from-[#3A8DFF] to-[#00A8E8] 
              rounded-lg uppercase font-semibold text-lg
              text-white shadow-lg transition-transform duration-200
              active:scale-95">
          {{ $t('cta.primary_book') }}
        </button>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue"
import { useBookingFormStore } from '../stores/bookingForm'

const booking = useBookingFormStore()
const openForm = () => {
  booking.open()
}

const props = defineProps({
  items: Array,
  autoplay: { type: Boolean, default: true },
})

const current = ref(0)
const track = ref(null)

const visible = ref(5)
const cardWidth = ref(250)
const gap = 24

// Clonamos para loop infinito real
const loopedItems = computed(() => [
  ...props.items.slice(-visible.value),
  ...props.items,
  ...props.items.slice(0, visible.value),
])

const baseIndex = computed(() => current.value + visible.value)

const translateX = ref(0)

const updateSizes = () => {
  const width = window.innerWidth

  if (width < 640) visible.value = 1
  else if (width < 768) visible.value = 2
  else if (width < 1280) visible.value = 3
  else visible.value = 5

  cardWidth.value = window.innerWidth / visible.value - gap
  updatePosition()
}

const updatePosition = () => {
  translateX.value =
    -(baseIndex.value * (cardWidth.value + gap)) +
    window.innerWidth / 2 -
    cardWidth.value / 2
}

// navegación
const next = () => {
  current.value++
  updatePosition()
  handleLoop()
}

const prev = () => {
  current.value--
  updatePosition()
  handleLoop()
}

// loop sin salto
const handleLoop = () => {
  setTimeout(() => {
    if (current.value >= props.items.length) {
      current.value = 0
      updatePosition()
    }
    if (current.value < 0) {
      current.value = props.items.length - 1
      updatePosition()
    }
  }, 400)
}

// card activa
const getClass = (i) => {
  if (i === baseIndex.value) {
    return "scale-110 z-10 shadow-2xl"
  }
  return "opacity-70 hover:opacity-100 hover:scale-105"
}

// drag
let startX = 0
let isDragging = false

const start = (e) => {
  isDragging = true
  startX = e.touches ? e.touches[0].clientX : e.clientX
}

const move = (e) => {
  if (!isDragging) return

  const x = e.touches ? e.touches[0].clientX : e.clientX
  const diff = startX - x

  if (diff > 50) {
    next()
    isDragging = false
  }

  if (diff < -50) {
    prev()
    isDragging = false
  }
}

const end = () => {
  isDragging = false
}

// autoplay
let interval

onMounted(() => {
  updateSizes()
  window.addEventListener("resize", updateSizes)

  if (props.autoplay) {
    interval = setInterval(() => {
      next()
    }, 4000)
  }
})
</script>

<style scoped>
.nav {
  @apply absolute top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white p-3 rounded-full shadow-lg transition;
}
</style>