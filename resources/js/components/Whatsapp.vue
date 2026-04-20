<script setup>
import { computed } from 'vue'
import { useLocaleStore } from '../stores/locale'
import { useToggleLanguage } from '../composables/useToggleLanguage'
import { useI18n } from 'vue-i18n'

const localeStore = useLocaleStore()
const { locale: i18nLocale  } = useI18n()
const { toggleLanguage } = useToggleLanguage()

const currentLangLabel = computed(() =>
localeStore.locale === 'en' ? 'es' : 'en')

const phone = "523224588968";
const messages = {
  es: "Hola, me gustaría recibir más información sobre los tours.",
  en: "Hi, I’d like to get more information about your tours."
};
// Selección automática del mensaje
const message = computed(() => messages[localeStore.locale]);

</script>

<template>
  <a
    :href="`https://wa.me/${phone}?text=${encodeURIComponent(message)}`"
    target="_blank"
    rel="noopener noreferrer"
    class="fixed bottom-[100px] lg:bottom-[40px] right-5 bg-green-500 hover:bg-green-600 text-white rounded-full p-0 shadow-lg transition-all duration-300 flex items-center justify-center z-50"
  >
    <!-- Ícono de WhatsApp -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-12 h-12">
      <path
        d="M12.04 2C6.59 2 2.17 6.42 2.17 11.87c0 2.09.62 4.04 1.69 5.7L2 22l4.57-1.79c1.6.88 3.43 1.38 5.39 1.38 5.45 0 9.87-4.42 9.87-9.87C21.91 6.42 17.49 2 12.04 2zm0 17.93c-1.7 0-3.29-.5-4.63-1.36l-.33-.2-2.71 1.06.99-2.8-.22-.29c-1-1.39-1.54-3.04-1.54-4.77 0-4.45 3.62-8.07 8.07-8.07 4.45 0 8.07 3.62 8.07 8.07-.01 4.46-3.62 8.07-8.07 8.07zm4.38-6.06c-.24-.12-1.41-.7-1.63-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.94-1.23-.72-.64-1.2-1.42-1.34-1.66-.14-.24-.02-.37.1-.49.1-.1.24-.26.36-.4.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.48-.4-.42-.54-.42h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2.02s.86 2.34.98 2.5c.12.16 1.7 2.6 4.1 3.64.57.24 1.02.38 1.36.5.57.18 1.08.16 1.48.1.46-.06 1.41-.58 1.61-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28z"
      />
    </svg>
  </a>
</template>
