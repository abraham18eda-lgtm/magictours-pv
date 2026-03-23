<script setup>
import { ref, onMounted, watch } from 'vue'
import { useLocaleStore } from '../stores/locale'
import { useI18n } from 'vue-i18n'

const { locale } = useI18n()
const localeStore = useLocaleStore()

const isMobile = ref(window.innerWidth < 768)
const handleResize = () => (isMobile.value = window.innerWidth < 768)

// Tawk widgets por idioma
const widgets = {
  en: 'https://embed.tawk.to/692e1ca40121eb197dd1b43f/1jbe1vp1p',
  es: 'https://embed.tawk.to/67417b7c2480f5b4f5a2bcdf/1jboqr9e1',
}

// --- FUNCIONES PRINCIPALES ---
function removeTawkWidget() {
  // Eliminar el iframe
  const iframe = document.querySelector('iframe[src*="tawk.to"]')
  if (iframe?.parentNode) iframe.parentNode.removeChild(iframe)

  // Eliminar el script existente
  const scripts = document.querySelectorAll('script[src*="tawk.to"]')
  scripts.forEach(s => s.parentNode.removeChild(s))

  // Resetear API
  window.Tawk_API = undefined
}

function loadTawkWidget(lang) {
  const script = document.createElement('script')
  script.async = true
  script.src = widgets[lang]
  script.charset = 'UTF-8'
  script.setAttribute('crossorigin', '*')

  const s0 = document.getElementsByTagName('script')[0]
  s0.parentNode.insertBefore(script, s0)

  // Esperar a que cargue y aplicar mobile rules
  const interval = setInterval(() => {
    if (window.Tawk_API) {
      if (isMobile.value) window.Tawk_API.hideWidget()
      else window.Tawk_API.showWidget()
      clearInterval(interval)
    }
  }, 300)
}

const loadChat = () => loadTawkWidget(localeStore.locale)

// --- MOUNT ---
onMounted(() => {
  window.addEventListener('resize', handleResize)
  loadChat()
})

// --- WATCH idioma ---
watch(
  () => localeStore.locale,
  (newLang) => {
    removeTawkWidget()
    loadTawkWidget(newLang)
  }
)

// Botón para móvil
const openTawkChat = () => window.Tawk_API?.maximize()
</script>

<template>
  <button
    v-if="isMobile"
    @click="openTawkChat"
    class="fixed bottom-28 right-5 bg-blue-500 text-white rounded-full p-4 shadow-lg"
  >
    Chat
  </button>
</template>
