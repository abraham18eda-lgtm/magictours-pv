<template>
  <div class="container mx-auto py-20 lg:w-5/6">
    <div class="p-0 lg:p-8">
      <h1 class="font-heading text-4xl text-center mb-6 text-primary font-semibold">
        {{ $t('legal.privacy.title') }}
      </h1>
     
      <div v-html="$t('legal.privacy.description')"></div>
  
     </div>
  </div>
</template>

<script setup>
import { useHead } from '@vueuse/head'
import { ref, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useLocaleStore } from '../../stores/locale'
import { useToggleLanguage } from '../../composables/useToggleLanguage'

const localeStore = useLocaleStore()
const { t, locale: i18nLocale } = useI18n()

const { toggleLanguage } = useToggleLanguage()

const title = computed(() => t('seo.legal.privacy.title'))
const description = computed(() => t('seo.legal.privacy.description'))

useHead(() => ({
  title: title.value,
  meta: [
    {
      name: 'description',
      content: description.value
    },
    {
      name: 'robots',
      content: 'noindex, follow'
    }
  ]
}))

</script>