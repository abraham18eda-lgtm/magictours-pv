<template>
<!-- Topbar -->
<div class="bg-gray-900 text-gray-100 text-sm hidden lg:flex">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center py-2">

      <!-- Izquierda: Localización -->
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 0C6.13 0 3 3.13 3 7c0 4.25 6 13 7 13s7-8.75 7-13c0-3.87-3.13-7-7-7zM10 9.5c-1.38 0-2.5-1.12-2.5-2.5S8.62 4.5 10 4.5s2.5 1.12 2.5 2.5S11.38 9.5 10 9.5z"/>
        </svg>
        <span class="text-lg">Puerto Vallarta, Jalisco</span>
      </div>

      <!-- Derecha: Redes Sociales + Idioma -->
      <div class="flex items-center gap-4">

        <!-- Redes Sociales -->
        <a href="https://www.facebook.com/magictourspv"
        class="hover:text-blue-500 transition text-xl"
         target="_blank"
         title="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.instagram.com/magictourspv/"
        class="hover:text-pink-500 transition text-xl"
         target="_blank"
         title="Instagram">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://wa.me/523224588968"
            class="hover:text-green-500 transition text-xl"
            title="WhatsApp"
            target="_blank"
            rel="noopener noreferrer">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="#"
        class="hover:text‑somecolor transition text-xl" title="TripAdvisor" target="_blank" rel="noopener noreferrer">
        <i class="fa fa-tripadvisor"></i>
        </a>
        |
        <div class="phone-number">
            <a href="tel:3223224588968" class="text-lg">(322) 458 89 68</a>
        </div>
        |
        <!-- Botón para cambiar idioma -->
        <button
        class="flex px-4 py-1 text-white text-lg rounded hover:bg-white hover:text-black"
        @click="toggleLanguage"
        ><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 relative top-[2px] right-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
        </svg>
        {{ currentLangLabel }}
        </button>
      </div>
    </div>
  </div>
</div>
</template>

<script setup>
import { ref, computed, onMounted   } from 'vue'
import { useToggleLanguage } from '../composables/useToggleLanguage'
import { useLocaleStore } from '../stores/locale'
import { useI18n } from 'vue-i18n'
import api from '../plugins/axios'
import axios from 'axios';

// const localeStore = useLocaleStore()
// Acceder a i18n

const localeStore = useLocaleStore()
const { locale: i18nLocale  } = useI18n()
const { toggleLanguage } = useToggleLanguage()

const currentLangLabel = computed(() =>
localeStore.locale === 'en' ? 'ES' : 'EN')

</script>

<style scoped>
/* puedes agregar algo extra si quieres personalizar más */
</style>
