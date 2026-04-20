<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

import PrivacyPolicy from './legal/PrivacyPolicy.vue'
import TermsConditions from './legal/TermsConditions.vue'
import CookiesPolicy from './legal/CookiesPolicy.vue'

const route = useRoute()

const pageComponent = computed(() => {
  const slug = route.params.slug

  if (slug === 'privacy-policy' || slug === 'aviso-de-privacidad') {
    return PrivacyPolicy
  }

  if (slug === 'terms-and-conditions' || slug === 'terminos-y-condiciones') {
    return TermsConditions
  }

  if (slug === 'cookie-policy'  || slug === 'politica-de-cookies') {
    return CookiesPolicy
  }

  return null
})
</script>

<template>
  <component v-if="pageComponent" :is="pageComponent" />

  <div v-else class="text-center py-20">
    <h1 class="text-2xl font-semibold">404</h1>
    <p class="text-gray-500 mt-2">Página no encontrada</p>
  </div>
</template>