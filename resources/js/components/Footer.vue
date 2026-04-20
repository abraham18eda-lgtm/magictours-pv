<template>
  <footer class="bg-[#022f04] text-white pt-10 pb-6">
    <div class="container mx-auto">
      <!-- Redes Sociales -->
      <div class="flex justify-center gap-6 mb-1 my-10 lg:my-0">
        <a
            href="https://www.facebook.com/magictourspv"
            target="_blank"
            class="hover:text-indigo-400 transition"
            aria-label="Facebook"
        >
            <i class="fab fa-facebook-f text-2xl pl-4"></i>
        </a>
        <a
            href="https://www.instagram.com/magictourspv/"
            target="_blank"
            class="hover:text-indigo-400 transition"
            aria-label="Instagram"
        >
            <i class="fab fa-instagram text-2xl pl-4"></i>
        </a>
        <a href="https://wa.me/523221074277"
            class="hover:text-green-500 transition text-xl"
            title="WhatsApp"
            target="_blank"
            rel="noopener noreferrer">
            <i class="fab fa-whatsapp text-2xl pl-4"></i>
        </a>

      </div>
         <!-- Separador -->
        <hr class="my-6 border-1 border-solid border-white opacity-20 mb-8" />
    </div>


    <!-- Bloques de contenido -->
    <div class="container mx-auto lg:px-10">
      <div
      class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10 px-1 md:px-10 my-10"
    >
      <!-- Contacto -->
      <div class="my-5 lg:my-0">
        <h3 class="text-2xl lg:text-lg  font-semibold mb-4">Contacto</h3>
        <p class="text-gray-300 text-base py-1 lg:py-0">📍 Puerto Vallarta, México</p>
        <p class="text-gray-300 text-base py-1 lg:py-0">📞 <a :href="`tel:+523224588968`">+52 322 458 89 68</a></p>
        <p class="text-gray-300 text-base py-1 lg:py-0">📞 <a :href="`tel:+523223564082`">+52 322 356 40 82</a></p>
        <p class="text-gray-300 text-base py-1 lg:py-0 hover:text-indigo-400">✉️ <a :href="`mailto:magictours01@hotmail.com`">magictours01@hotmail.com</a>
        </p>
      </div>

      <div class="flex flex-col gap-2">
        <h3 class="text-2xl lg:text-lg font-semibold mb-4">{{ $t('footer.explore.title') }}</h3>
        <RouterLink
          :to="`/${lang}/${routeTranslations['privacy-policy'][lang]}`"
          class="text-gray-300 text-base hover:text-brandBlue transition-colors duration-300 hover:underline"
          >
          {{ t('footer.explore.legal.privacy') }}
        </RouterLink>

        <router-link 
          :to="`/${lang}/${routeTranslations['terms-and-condition'][lang]}`"
          class="text-gray-300 text-base hover:text-brandBlue transition-colors  duration-300 hover:underline"">
          {{ t('footer.explore.legal.terms') }}
        </router-link>

        <router-link 
        :to="`/${lang}/${routeTranslations['cookie-policy'][lang]}`"
        class="text-gray-300 text-base hover:text-brandBlue transition-colors duration-300 hover:underline"">
          {{ t('footer.explore.legal.cookie') }}
        </router-link>
      </div>

      <!-- Tours Favoritos -->
      <div class="lg:my-0">
        <h3 class="text-2xl lg:text-lg font-semibold mb-4">Tours Favoritos</h3>
        <ul class="text-gray-300 space-y-2 text-base py-0 lg:py-0">
          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'rhythms-of-the-night' : 'ritmos-de-la-noche'}`"class="hover:text-indigo-400">{{ t('tours.book.1') }}</a></li>

          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'las-caletas-beach-hideaway' : 'las-caletas-beach-hideaway'}`" class="hover:text-indigo-400">{{ t('tours.book.2') }}</a></li>

          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'island-discovery' : 'playa-escondida-islas-marietas'}`"  class="hover:text-indigo-400">{{ t('tours.book.3') }}</a></li>

          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'marietas-eco-discovery' : 'islas-marietas'}`" class="hover:text-indigo-400">{{ t('tours.book.4') }}</a></li>

          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'yelapa-majahuitas' : 'yelapa-majahuitas'}`" class="hover:text-indigo-400">{{ t('tours.book.6') }}</a></li>
        </ul>
      </div>
    </div>
  </div>

    <!-- Separador -->
    <hr class="my-2 mt-[50px] border-esmeralda-200" />
    <!-- Firma -->
    <div class="text-center text-base lg:text-base text-gray-300 my-0 h-[120px] lg:h-auto p-2">
        &copy; {{ new Date().getFullYear() }} {{ $t('footer.signature.title') }}
    </div>
  </footer>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useLocaleStore } from '../stores/locale'
import { routeTranslations } from '@/utils/routeTranslations'

const localeStore = useLocaleStore()
const { t, locale: i18nLocale } = useI18n()

const lang = computed(() => localeStore.locale)

</script>

<!-- Si usas FontAwesome con CDN, añade esto en tu index.html -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" /> -->

<style scoped>
/* Responsive helper para textos pequeños si se requiere más ajuste */
</style>
