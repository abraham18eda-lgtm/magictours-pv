<template>
  <header class="bg-white shadow sticky top-0 z-50 py-5 lg:py-0">
    <div class="lg:container mx-auto px-4 py-2">
      <div class="flex justify-between">
      <!-- Logo -->
      <div>
        <RouterLink :to="`/${localeStore.locale}/`">
          <img
            :src="logo"
            class="w-[180px] lg:h-[80px]  object-contain"
            alt="Logo"
          />
        </RouterLink>
      </div>

      <!-- Desktop Menu (≥1024px) -->
      <nav class="hidden lg:flex space-x-6 items-center">
        <a href="#" class="text-gray-700 text-lg font-semibold hover:text-blue-600 uppercase">{{ $t('header.home') }}</a>
        <button @click="$emit('open-drawer')" class="text-gray-700 text-lg font-semibold hover:text-blue-600 uppercase">
          {{ $t('header.tours') }}
        </button>
        <a href="#" class="text-gray-700 text-lg font-semibold hover:text-blue-600 uppercase">{{ $t('header.about') }}</a>
        <button @click="openForm()"
            class="ml-4 px-6 py-3 
              bg-gradient-to-r from-[#3A8DFF] to-[#00A8E8] 
              rounded-lg uppercase font-semibold text-lg
              text-white shadow-lg transition-transform duration-200
              active:scale-95 active:shadow-2xl">
          {{ $t('cta.primary_book') }}
        </button>
      </nav>


      <div class="lg:hidden flex">
        <!-- Language Switch (Mobile + Tablet) -->
        <div class="items-center justify-center space-x-1 relative left-6 top-[5px]">
            <button class="flex py-1 text-gray-700 rounded hover:bg-white hover:text-black"
              @click="toggleLanguage"
              ><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 relative top-[3px]">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
              </svg>
              <span class="relative text-gray-700 text-xl"> {{ currentLangLabel }}</span>
            </button>
        </div>
          <!-- Hamburger (Mobile + Tablet <1024px) -->
        <button ref="hamburgerBtn" @click="toggleMenu" class="flex relative items-center mx-10 top-2">
            <span
            class="absolute w-8 h-[2px] bg-gray-600 transition-all duration-300"
            :class="mobileMenu ? 'rotate-45 top-5' : 'top-2'"
            ></span>
            <span
            class="absolute w-8 h-[2px] bg-gray-600 transition-all duration-300"
            :class="mobileMenu ? 'opacity-0 top-5' : 'top-4'"
            ></span>
            <span
            class="absolute w-8 h-[2px] bg-gray-600 transition-all duration-300"
            :class="mobileMenu ? '-rotate-45 top-5' : 'top-6'"
            ></span>
        </button>
      </div>
    </div>

    <!-- Dropdown Vertical (Mobile + Tablet) -->
    <transition name="slide-down">
      <div
        v-if="mobileMenu"
        class="lg:hidden absolute top-full bg-white shadow-xl z-40 border-t border-gray-200 w-full left-0"
      >
        <!-- Flecha Indicadora alineada con el botón hamburguesa -->
        <div
          class="absolute -translate-y-1 w-4 h-4 bg-white rotate-45 shadow-md z-50"
          :style="{ left: arrowLeft + 'px' }"
        ></div>

        <div class="container">
            <div class="px-4 py-6 flex flex-col space-y-2 min-h-[60px]">
                <RouterLink :to="`/${localeStore.locale}/`" class="text-gray-700 hover:text-brandBlue-100 text-lg lg:text-lg font-semibold uppercase transition-colors duration-300">{{ $t('header.home') }}</RouterLink>

                <RouterLink
                    :to="`/${localeStore.locale}/tours`"
                    class="text-gray-700 text-lg lg:text-lg hover:text-brandBlue font-semibold uppercase transition-colors duration-300"
                    >
                    {{ $t('header.tours') }}
                </RouterLink>
                <a href="#" class="text-gray-700 hover:text-brandBlue-100 text-lg lg:text-lg font-semibold uppercase">{{ $t('header.about') }}</a>
                <!-- <button @click="openForm()" class="w-full mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition uppercase">
                    {{ $t('cta.primary_book') }}
                </button> -->
            </div>
        </div>
      </div>
    </transition>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount, nextTick } from 'vue'
import { useToggleLanguage } from '../composables/useToggleLanguage'
import { RouterLink } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useBookingFormStore } from '../stores/bookingForm'
import { useLocaleStore } from '../stores/locale'
import logo from '../assets/logos/magic-tours-hz.svg'
import api from '../plugins/axios'
import axios from 'axios';


const booking = useBookingFormStore()
const { t, locale: i18nLocale } = useI18n()
const localeStore = useLocaleStore()

const { toggleLanguage } = useToggleLanguage()

const mobileMenu = ref(false)
const hamburgerBtn = ref(null)
const arrowLeft = ref(0)

const currentLangLabel = computed(() =>
localeStore.locale === 'en' ? 'ES' : 'EN')


const toggleMenu = () => {
  mobileMenu.value = !mobileMenu.value
  nextTick(updateArrowPosition)
}

const openForm = () => {
  booking.open()
  mobileMenu.value = false
}

const updateArrowPosition = () => {
  if (hamburgerBtn.value) {
    const rect = hamburgerBtn.value.getBoundingClientRect()
    arrowLeft.value = rect.left + rect.width / 2 - 8 // 8 = half de la flecha (w-4)
  }
}

onMounted(() => {
  window.addEventListener('resize', updateArrowPosition)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateArrowPosition)
})

</script>

<style scoped>
/* Animación suave de dropdown */
.slide-down-enter-from {
  opacity: 0;
  transform: translateY(-10px);
}
.slide-down-enter-to {
  opacity: 1;
  transform: translateY(0);
}
.slide-down-enter-active {
  transition: all 0.25s ease-out;
}
.slide-down-leave-from {
  opacity: 1;
  transform: translateY(0);
}
.slide-down-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
.slide-down-leave-active {
  transition: all 0.25s ease-in;
}

</style>
