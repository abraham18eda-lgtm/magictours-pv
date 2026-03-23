<template>
    <div class="container mx-auto max-w-6xl px-4 py-20">
        <div class="lg:text-center mb-8 flex justify-start items-center">
          <div class="lg:container lg:mx-auto">
            <h2 class="text-3xl lg:text-base text-primary font-semibold py-6 whitespace-pre-wrap text-start md:text-center">{{ $t('tours.title')}}</h2>
            <p class="text-xl md:text-base  text-start lg:text-center sm:text-lg md:text-xl lg:text-base whitespace-pre-wrap" v-html="$t('tours.description')"></p>
          </div>
        </div>

        <!-- Input de búsqueda elegante -->
        <div class="w-full flex justify-start mb-2 lg:mb-0 p-1">
          <div class="relative w-full md:w-3/6 lg:w-2/6 lg:max-w-full lg:mb-4">
            
            <!-- Input -->
            <input
              v-model="search"
              type="text"
              :placeholder="$t('tours.placeholder')"
              class="peer w-full bg-transparent border-b border-gray-300 
                    text-gray-800 placeholder-gray-400 text-base
                    pl-10 pr-4 py-2 transition-colors duration-300
                    focus:outline-none"
            />

            <!-- Línea inferior animada -->
            <span class="absolute bottom-0 left-0 w-full h-[2px] 
                        bg-gradient-to-r from-[#3A8DFF] to-[#00A8E8] 
                        scale-x-0 origin-left transition-transform duration-500
                        peer-focus:scale-x-100">
            </span>

            <!-- Ícono de búsqueda -->
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 
                        text-gray-400 transition-colors duration-300 peer-focus:text-[#3A8DFF]">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                  stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
              </svg>
            </span>

          </div>
        </div>

        <!-- Mensajes de carga / vacío -->
        <div v-if="loading" class="text-center py-8 text-gray-500">
            Cargando tours...
        </div>

        <div v-else-if="paginatedTours.length === 0" class="text-center py-8 text-gray-500">
            No se encontraron tours.
        </div>

        <!-- Contenedor de tarjetas -->
        <div
            v-else
            name="fade-up"
            tag="div"
            class="sm:grid md:grid-cols-2 lg:grid-cols-3 sm:gap-6 flex overflow-x-auto space-x-4 no-scrollbar p-1"
            style="scroll-snap-type: x mandatory;">
            <div
            v-for="tour in paginatedTours"
            :key="tour.id"
            class="group relative bg-white/80 backdrop-blur-lg rounded-2xl shadow-md overflow-hidden 
            hover:shadow-2xl transition-all duration-500 flex-shrink-0 w-72 sm:w-auto mb-16
            hover:-translate-y-2 hover:scale-[1.02]"
            >
            <!-- Imagen y título -->
              <div class="flex flex-col h-full">
                <div class="relative">
                <img
                     :src="getImageUrl(tour.image)"
                    alt="Imagen del tour"
                    class="w-full h-[40vh] lg:min-h-[50vh] md:min-h-[40vh] md:h-[60vh] lg:h-60  rounded-t-lg"
                />
                <div class="absolute bottom-0 w-full min-h-[100px] text-center
                  bg-gradient-to-t from-black/95 via-black/70 to-transparent py-4 px-2
                  transition-all duration-500">
                    <h3 class="text-white font-semibold text-base sm:text-lg md:text-2xl lg:text-base lg:pb-0 ">{{ tour.title }}</h3>
                    <p class="text-white text-sm">

                    <span  v-if="tour.regular_price >0"
                    class="font-normal line-through opacity-70 text-base sm:text-lg md:text-base lg:text-base"> ${{ formatPrice(tour.regular_price) }} {{ $t('price.moneda') }}</span>
                    <span  v-if="tour.descount_price > 0"
                    class="font-bold pl-4  text-xl md:text-xl lg:text-base text-brandBlue-300">  ${{ formatPrice(tour.descount_price) }} {{ $t('price.moneda') }}</span>
                    </p>
                </div>
              </div>

                <!-- Detalles -->
                <div class="pt-2 flex flex-col">
                  <!-- Lista de amenities -->
                    <p v-if="tour.amenities.length" class="justify-center items-center flex">
                        <span
                            v-for="(amenity, index) in tour.amenities.slice(0, 3)"
                            :key="index"
                            class="mr-4 lg:mr-5 text-sm md:text-sm lg:text-[12px] lg:py-0 uppercase"
                        >
                            {{ amenity }}
                        </span>
                    </p>
                    <!-- <ul v-if="tour.amenities.length">
                        <li v-for="(amenity, index) in tour.amenities.slice(0, 4)" :key="index">
                            {{ amenity }}
                        </li>
                    </ul> -->
                  <p v-else>No amenities listed</p>
                  <ul
                      v-if="tour.details && tour.details.list"
                      class="flex text-gray-600 justify-center text-sm list-disc pl-2 mb-4 w-full"
                  >
                      <li
                      v-for="(detail, key) in tour.details.list"
                      :key="key"
                      class="min-w-[80px]"
                      >
                      {{ detail }}
                      </li>
                  </ul>
                </div>

                <hr class="my-2" />

                <!-- Botones -->
                <div class="px-4 flex justify-between my-4 w-full h-auto">
                  <button
                      @click="viewDetails(tour)"
                      class="border-2 border-indigo-600 text-indigo-600 px-4 py-0 lg:py-0 rounded-md hover:bg-indigo-50 transition"
                  >
                      <span class="text-base sm:text-lg md:text-base lg:text-base">
                          {{ $t('cta.view_tours') }}</span>
                  </button>
                  <button
                      @click="booking.open(tour)"
                      class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition
                      bg-gradient-to-r from-[#3A8DFF] to-[#00A8E8] transition-transform duration-200 
                      active:scale-95 active:shadow-2xl">
                      <span class=" text-base sm:text-lg md:text-base lg:text-base">{{ $t('cta.primary_book') }}</span>
                  </button>
                  <!-- <button @click="openForm()"
                      class="ml-4 px-6 py-3 bg-gradient-to-r from-[#3A8DFF] to-[#00A8E8] 
                        rounded-lg uppercase font-semibold text-base text-white shadow-lg 
                        transition-transform duration-200 active:scale-95 active:shadow-2xl">
                    {{ $t('cta.primary_book') }}
                  </button> -->
                </div>
              </div>
            </div>
        </div>

<!-- <div
  v-if="isDesktop && totalPages > 1"
  class="flex justify-center items-center gap-2 mt-8"
> -->
<div class="flex justify-center items-center gap-2 mt-8">
  <button
    @click="currentPage--"
    :disabled="currentPage === 1"
    class="px-3 py-2 rounded-md border text-sm disabled:opacity-40"
  >
    ←
  </button>

  <button
    v-for="page in totalPages"
    :key="page"
    @click="currentPage = page"
    class="px-4 py-2 rounded-md text-sm border"
    :class="page === currentPage
      ? 'bg-indigo-600 text-white'
      : 'bg-white text-gray-700 hover:bg-gray-100'"
  >
    {{ page }}
  </button>

  <button
    @click="currentPage++"
    :disabled="currentPage === totalPages"
    class="px-3 py-2 rounded-md border text-sm disabled:opacity-40"
  >
    →
  </button>
</div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useLocaleStore } from '../stores/locale'
import { useBookingFormStore } from '../stores/bookingForm'
import { usePrice } from '../composables/usePrices'
import api from '../plugins/axios'

import Footer from './Footer.vue'
import Header from './Header.vue'
import TopBar from './TopBar.vue'

const route = useRoute()
const router = useRouter()
const localeStore = useLocaleStore()
const { formatPrice } = usePrice()
const booking = useBookingFormStore()

const tours = ref([])
const loading = ref(true)
const search = ref("")
const errorMessage = ref("")

const currentPage = ref(1)
const itemsPerPage = 9
const isDesktop = ref(false)

const selectedTour = ref(null)
const showForm = ref(false)

const checkScreen = () => {
  isDesktop.value = window.innerWidth >= 1024
}
// Detectar base URL según entorno
const baseURL = window.location.hostname.includes('localhost') ? 'http://localhost:8000' : 'https://www.magictourspv.com'

// Función para obtener URL completa de la imagen
const getImageUrl = (path) => path ? `${baseURL}${path}` : ''


// const openForm = () => {
//   booking.open(tour)
// }
// const openForm = () => {
//   showForm.value = true
//   mobileMenu.value = false
// }

    const paginatedTours = computed(() => {
    if (isDesktop.value) {
        //Mobile: todos (scroll horizontal)
        return filteredTours.value
    }

    const start = (currentPage.value - 1) * itemsPerPage
    const end = start + itemsPerPage
    return filteredTours.value.slice(start, end)
    })

    const totalPages = computed(() => {
    if (isDesktop.value) return 1
    return Math.ceil(filteredTours.value.length / itemsPerPage)
    })

const filteredTours = computed(() => {
  const term = search.value?.toLowerCase()
  const list = !term
    ? tours.value
    : tours.value.filter(
        t =>
          t.title.toLowerCase().includes(term) ||
          (t.description && t.description.toLowerCase().includes(term))
      )
  // limitar la ruta
  if (route.name === 'home') {
    return list.slice(0, 9)
  }
  return list
})

const fetchTours = async () => {
  loading.value = true
  const lang = route.params.lang || localeStore.locale
  try {
    const res = await api.get(`api/tours?lang=${lang}`)
    tours.value = res.data
    // alert('Tour recibido: ' + JSON.stringify(tours.value, null, 2))
  } catch (err) {
    console.error('Error fetching tours:', err)
    tours.value = []
    errorMessage.value = 'No se pudieron cargar los tours.'
  } finally {
    loading.value = false
  }
}

const viewDetails = (tour) => {
  const lang = route.params.lang || localeStore.locale
  router.push({ name: 'tour-detail', params: { lang, slug: tour.slug } })
}

onMounted(fetchTours)
watch(() => route.params.lang, fetchTours)
watch(() => localeStore.locale, fetchTours)

onMounted(() => {
  checkScreen()
  window.addEventListener('resize', checkScreen)
})

onUnmounted(() => {
  window.removeEventListener('resize', checkScreen)
})
</script>
