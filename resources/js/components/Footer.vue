<template>
  <footer class="bg-black text-white pt-10 pb-6">
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
        <hr class="my-6 border-1 border-solid border-white opacity-10 mb-8" />
    </div>


    <!-- Bloques de contenido -->
    <div class="container mx-auto lg:px-10">
      <div
      class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10 px-1 md:px-10 my-10"
    >
      <!-- Contacto -->
      <div class="my-5 lg:my-0">
        <h3 class="text-2xl lg:text-lg  font-semibold mb-4">Contacto</h3>
        <p class="text-gray-400 text-base py-1 lg:py-0">📍 Puerto Vallarta, México</p>
        <p class="text-gray-400 text-base py-1 lg:py-0">📞 <a :href="`tel:+523224588968`">+52 322 458 89 68</a></p>
        <p class="text-gray-400 text-base py-1 lg:py-0">📞 <a :href="`tel:+523223564082`">+52 322 356 40 82</a></p>
        <p class="text-gray-400 text-base py-1 lg:py-0">✉️ <a :href="`mailto:magictours01@hotmail.com`">magictours01@hotmail.com</a>
        </p>
      </div>

      <!-- Tours Favoritos -->
      <div class="lg:my-0">
        <h3 class="text-2xl lg:text-lg font-semibold mb-4">Tours Favoritos</h3>
        <ul class="text-gray-400 space-y-2 text-base py-0 lg:py-0">
          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'rhythms-of-the-night' : 'ritmos-de-la-noche'}`"class="hover:text-indigo-400">{{ t('tours.book.1') }}</a></li>

          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'las-caletas-beach-hideaway' : 'las-caletas-beach-hideaway'}`" class="hover:text-indigo-400">{{ t('tours.book.2') }}</a></li>

          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'island-discovery' : 'playa-escondida-islas-marietas'}`"  class="hover:text-indigo-400">{{ t('tours.book.3') }}</a></li>

          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'marietas-eco-discovery' : 'islas-marietas'}`" class="hover:text-indigo-400">{{ t('tours.book.4') }}</a></li>

          <li><a :href="`https://magictourspv.com/${lang}/tours/${lang === 'en' ? 'yelapa-majahuitas' : 'yelapa-majahuitas'}`" class="hover:text-indigo-400">{{ t('tours.book.6') }}</a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div class="my-2 lg:my-0">
        <h3 class="text-2xl lg:text-lg font-semibold mb-4">{{ $t('footer.newsletter.title') }}</h3>
        <p class="text-gray-400 text-sm mb-4">
          {{ $t('footer.newsletter.description') }}
        </p>
        <form v-if="!submitted"
        @submit.prevent="submitForm" class="space-y-3">
          <input
            v-model="form.name"
            type="text"
            :placeholder="$t('footer.newsletter.name')"
            class="w-full px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-base"
            required
          />
          <input
            v-model="form.email"
            type="email"
            :placeholder="$t('footer.newsletter.email')"
            class="w-full px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-base"
            required
          />
          <button
            type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 transition py-2 rounded font-medium text-base h-auto"
          >
            {{ $t('footer.newsletter.cta_send') }}
          </button>
        </form>
        <!-- Mensaje: solo visible si submitted -->
        <div
        v-if="submitted"
        class="text-white p-2 shadow-md font-semibold"
        >
        {{ modalMessage }}
        </div>
      </div>
      </div>
    </div>

    <!-- Separador -->
    <hr class="my-2 mt-[50px] border-gray-700" />

    <!-- Firma -->
    <div class="text-center text-base lg:text-sm text-gray-500 my-0 h-[120px] lg:h-auto p-2">
      &copy; {{ new Date().getFullYear() }} {{ $t('footer.signature.title') }}
    </div>
  </footer>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'
import { useI18n } from 'vue-i18n'
import { useLocaleStore } from '../stores/locale'

const localeStore = useLocaleStore()
const { t, locale: i18nLocale } = useI18n()

const lang = computed(() => localeStore.locale)

const form = ref({
  name: '',
  email: '',
})

// const subscribe = () => {
//   alert(
//     `Gracias, ${newsletter.value.name}! Te has suscrito al boletín con el correo ${newsletter.value.email}.`
//   )
//   newsletter.value.name = ''
//   newsletter.value.email = ''
// }
const submitted = ref(false)
const modalMessage = ref('')


const submitForm = async () => {
  try {
    const res = await axios.post('/newsletter', form.value)
     modalMessage.value = res.data.message
     submitted.value = true
  } catch (err) {
    if (err.response && err.response.data.errors) {
       modalMessage.value = Object.values(err.response.data.errors).flat().join('\n')
      alert(errors)
    } else {
       modalMessage.value = 'Ocurrió un error, intenta nuevamente.'
    }
    submitted.value = true
  }
}
</script>

<!-- Si usas FontAwesome con CDN, añade esto en tu index.html -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" /> -->

<style scoped>
/* Responsive helper para textos pequeños si se requiere más ajuste */
</style>
