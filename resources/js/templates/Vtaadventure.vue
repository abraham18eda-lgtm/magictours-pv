<template>
  <div class="default-template">
     <div class="container mx-auto max-w-4xl px-4 py-10">
        <section class="p-6">
            <div v-if="error" class="text-red-600 font-medium">{{ error }}</div>
            <div v-else-if="loading">Cargando tour...</div>

            <div v-else>
                <h1 class="text-primary text-center text-3xl font-bold mb-4 py-8 uppercase">{{ tour.title }}</h1>
            <!-- <img
                v-if="tour.image"
                :src="tour.image"
                alt="Imagen del tour"
                class="rounded-lg mb-4 w-full max-w-xl"
            /> -->
            <p class="text-gray-700 mb-4" v-html="tour.description"></p>

            <div v-if="tour.amenities && tour.amenities.length" class="mb-4">
                <!-- Grid de 3 columnas -->
                <div class="grid grid-cols-1  xs:grid-cols-2 md:grid-cols-3">
                    <div
                    v-for="(item, index) in tour.amenities"
                    :key="index"
                    class="flex items-center space-x-3 bg-white shadow-sm rounded-lg p-1 hover:shadow-md transition"
                    >
                    <!-- Puedes poner un ícono aquí si deseas -->
                    <div class="text-indigo-500 text-xl">
                        <i class="fas fa-check-circle"></i>
                    </div>

                    <!-- Nombre del amenity -->
                    <span class="text-gray-700 font-medium">{{ typeof item === 'string' ? item : item.name }}</span>
                    </div>
                </div>
            </div>
            <div class="text-gray-700 mb-4 my-14" v-html="tour.description_2"></div>

            <div class="mt-6 pt-4 py-8">
                <button
                @click="open = !open"
                class="text-indigo-600 font-semibold flex items-center gap-2 uppercase"
                >
                 {{ open ? '▲' : '▼' }} <h3 class="text-h3 text-semibold">{{ $t('tours_detail.include.title') }}</h3>
                </button>
                <div v-show="open" class="mt-2 text-gray-600 pl-4">
                    <p class="my-2" v-html="tour.info">
                    </p><br />
                </div>
            </div>
            <Acordeon :data="accordionJson" />

            <div class="mt-6 pt-4 py-8">
                <button
                @click="open_2 = !open_2"
                class="text-indigo-600 font-semibold flex items-center gap-2 uppercase"
                >
                 {{ open_2 ? '▲' : '▼' }} <h3 class="text-h3 font-semibold">{{ $t('tours_detail.faqs.title') }}</h3>
                </button>
                <div v-show="open_2" class="mt-2 text-gray-600">
                     <span class="my-2" v-html="tour.faq">
                     </span>
                    <br />
                </div>
            </div>
        </div>
        </section>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import { useLocaleStore } from '../stores/locale'
import { useI18n } from 'vue-i18n'
import Acordeon from '../components/Accordition.vue'

const props = defineProps({
  tour: Object
})

const tour = ref(props.tour)
// Estados
const error = ref(null)
const open = ref(true)
const open_2 = ref(false)

// Pinia y vue-i18n
const localeStore = useLocaleStore()
const { t, locale: i18nLocale } = useI18n()

// Importar JSON de idiomas
import en from '../lang/en.json'
import es from '../lang/es.json'
const localesData = { en, es }

const baseURL = window.location.hostname.includes('localhost')
  ? 'http://localhost:8000'
  : 'https://www.magictourspv.com'

const getImageUrl = (path) => path ? `${baseURL}${path}` : ''

watch(() => props.tour, (newTour) => {
  tour.value = newTour
})
const accordionJson = computed(() => {
  if (!tour.value?.slug) return []

  const slug = tour.value.slug
  const lang = localeStore.locale || 'en'

  // Verificar si hay acordeones en el idioma actual
  if (localesData[lang]?.accordions?.[slug]) {
    return localesData[lang].accordions[slug]
  }

  // Fallback a inglés
  if (localesData['en']?.accordions?.[slug]) {
    return localesData['en'].accordions[slug]
  }

  return []
})

</script>

<style scoped>
.vtaadventure-template {
  padding: 1rem;
}
.vtaadventure-template img {
  max-width: 100%;
  margin: 1rem 0;
}
</style>
