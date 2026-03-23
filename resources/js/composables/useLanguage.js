// composables/useLanguage.js
import { useRouter, useRoute } from 'vue-router'
import { useLocaleStore } from '../stores/locale'
import { useI18n } from 'vue-i18n'
import api from '../plugins/axios'

export function useLanguage() {
  const router = useRouter()
  const route = useRoute()
  const localeStore = useLocaleStore()
  const { locale: i18nLocale } = useI18n()

  const currentLangLabel = computed(() =>
    localeStore.locale === 'en' ? 'ES' : 'EN'
  )

  const toggleLanguage = async () => {
    const newLocale = localeStore.locale === 'en' ? 'es' : 'en'
    localeStore.setLocale(newLocale)
    i18nLocale.value = newLocale

    // Si estamos en TourDetail, necesitamos obtener el slug traducido
    if (route.name === 'tour-detail') {
      try {
        const tourId = route.params.id || route.params.slug
        const res = await api.get(`/api/tours/${tourId}?lang=${newLocale}`)
        const newSlug = res.data.slug
        router.push({
          name: 'tour-detail',
          params: { lang: newLocale, slug: newSlug }
        })
      } catch (err) {
        console.error('Error cambiando idioma en TourDetail:', err)
      }
    } else {
      // Para TourList, Home u otras rutas
      router.push({ name: route.name, params: { lang: newLocale, ...route.params } })
    }
  }

  return { currentLangLabel, toggleLanguage }
}
