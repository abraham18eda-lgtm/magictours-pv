
<!-- <script setup>
import { ref, onMounted, watch, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../plugins/axios'
import { useLocaleStore } from '../stores/locale'
import { useI18n } from 'vue-i18n'
import Acordeon from '../components/Accordition.vue'

// Router y slug
const route = useRoute()
const router = useRouter()

// Estados
const tour = ref({})
const loading = ref(true)
const error = ref(null)
const open = ref(true)
const open_2 = ref(false)

// Props
defineProps({
  slug: String,
  lang: String
})

// Pinia y vue-i18n
const localeStore = useLocaleStore()
const { t, locale: i18nLocale } = useI18n()

// Base URL para imágenes
const baseURL = window.location.hostname.includes('localhost')
  ? 'http://localhost:8000'
  : 'https://www.magictourspv.com'

// Función para obtener URL completa de imagen
const getImageUrl = (path) => path ? `${baseURL}${path}` : ''

// Importar JSON de idiomas
import en from '../lang/en.json'
import es from '../lang/es.json'
const localesData = { en, es }

// Función para traer tour de la API
const fetchTour = async () => {
  loading.value = true
  error.value = null

  const slug = route.params.slug
  const lang = localeStore.locale

  try {
    const res = await api.get(`/api/tours/${slug}?lang=${lang}`)
    tour.value = res.data
  } catch (err) {
    console.error('Error fetching tour:', err)
    error.value = 'No se pudo cargar la información del tour.'
  } finally {
    loading.value = false
  }
}

// Computed para acordeones según slug y idioma
const accordionJson = computed(() => {
  const slug = tour.value.slug
  const lang = localeStore.locale

  if (!slug) return []

  if (localesData[lang]?.accordions?.[slug]) {
    return localesData[lang].accordions[slug]
  }

  // Fallback a inglés
  if (localesData['en']?.accordions?.[slug]) {
    return localesData['en'].accordions[slug]
  }

  return []
})

// Montar componente
onMounted(fetchTour)

// Recargar tour si cambia slug o idioma en URL
watch(
  () => [route.params.slug, route.params.lang],
  () => fetchTour()
)

// Escuchar cambios de idioma desde TopBar (Pinia)
watch(
  () => localeStore.locale,
  async (newLocale) => {
    i18nLocale.value = newLocale

    // Esperar a que tour.value tenga slugByLang
    if (!tour.value.slugByLang) {
      await fetchTour()
    }

    const newSlug = tour.value.slugByLang?.[newLocale] || tour.value.slug

    // Solo actualizar la URL si difiere de la actual
    if (newSlug !== route.params.slug || newLocale !== route.params.lang) {
      router.replace({
        name: 'tour-detail',
        params: { lang: newLocale, slug: newSlug }
      })
    } else {
      fetchTour()
    }
  }
)
</script> -->

<template>
  <div v-if="loading" class="container mx-auto">
    <span class="text-center">Cargando tour...</span>
  </div>
  <div v-else-if="error">{{ error }}</div>
  <component v-else :is="TemplateComponent" :tour="tour" />
</template>

<script setup>
import { ref, onMounted, watch, computed, shallowRef, markRaw } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../plugins/axios'
import { useLocaleStore } from '../stores/locale'
import { useI18n } from 'vue-i18n'
import templates from '../templates'

// Router y slug
const route = useRoute()
const router = useRouter()

// Estados
const tour = ref({})
const loading = ref(true)
const error = ref(null)

// Componente dinámico
const TemplateComponent = shallowRef(null)

// Props
defineProps({
  slug: String,
  lang: String
})

// Pinia y vue-i18n
const localeStore = useLocaleStore()
const { t, locale: i18nLocale } = useI18n()

// Base URL para imágenes
const baseURL = window.location.hostname.includes('localhost')
  ? 'http://localhost:8000'
  : 'https://www.magictourspv.com'

const getImageUrl = (path) => path ? `${baseURL}${path}` : ''

// Importar JSON de idiomas
import en from '../lang/en.json'
import es from '../lang/es.json'
const localesData = { en, es }

// Función para traer tour de la API
const fetchTour = async () => {
  loading.value = true
  error.value = null

  const slug = route.params.slug
  const lang = localeStore.locale

  try {
    const res = await api.get(`/api/tours/${slug}?lang=${lang}`)
    tour.value = res.data
    // alert('Tour recibido: ' + JSON.stringify(tour.value, null, 2))
    // console.log('Tour recibido:', tour.value)

    // Obtener loader seguro
    const templateKey = tour.value.template?.toLowerCase() || 'default'
    const loader = templates[templateKey] || templates.default

    if (typeof loader !== 'function') {
      console.warn('Template inválido, cargando default:', templateKey)
      TemplateComponent.value = markRaw((await templates.default()).default)
    } else {
      const module = await loader()
      TemplateComponent.value = markRaw(module.default)
    }

    // console.log('Template cargado:', templateKey)

    // Inicializar Tawk después de unos segundos
    setTimeout(() => {
      if (!window.Tawk_API) {
        const TawkScript = document.createElement('script')
        TawkScript.src = 'https://embed.tawk.to/YOUR_TAWK_ID/default'
        TawkScript.async = true
        TawkScript.charset = 'UTF-8'
        document.body.appendChild(TawkScript)
        console.log('Tawk cargado')
      }
    }, 3000)

  } catch (err) {
    console.error('Error fetching tour:', err)
    error.value = 'No se pudo cargar la información del tour.'
  } finally {
    loading.value = false
  }
}

// Computed para acordeones según slug y idioma
const accordionJson = computed(() => {
  const slug = tour.value.slug
  const lang = localeStore.locale

  if (!slug) return []

  if (localesData[lang]?.accordions?.[slug]) {
    return localesData[lang].accordions[slug]
  }

  if (localesData['en']?.accordions?.[slug]) {
    return localesData['en'].accordions[slug]
  }

  return []
})

// Montar componente
onMounted(fetchTour)

// Recargar tour si cambia slug o idioma
watch(
  () => [route.params.slug, route.params.lang],
  () => fetchTour()
)

// Escuchar cambios de idioma desde Pinia
watch(
  () => localeStore.locale,
  async (newLocale) => {
    i18nLocale.value = newLocale

    if (!tour.value.slugByLang) {
      await fetchTour()
    }

    const newSlug = tour.value.slugByLang?.[newLocale] || tour.value.slug

    if (newSlug !== route.params.slug || newLocale !== route.params.lang) {
      router.replace({
        name: 'tour-detail',
        params: { lang: newLocale, slug: newSlug }
      })
    } else {
      fetchTour()
    }
  }
)
</script>



