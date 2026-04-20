import { useLocaleStore } from '../stores/locale'
import { routeTranslations } from '../utils/routeTranslations'
import { useRoute, useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'
import api from '../plugins/axios'

export function useToggleLanguage() {
  const localeStore = useLocaleStore()
  const route = useRoute()
  const router = useRouter()
  const { locale: i18nLocale } = useI18n()

  const toggleLanguage = async () => {
    const newLocale = localeStore.locale === 'en' ? 'es' : 'en'
    console.log('slug actual:', route.params.slug)
    // actualizar store y i18n
    localeStore.setLocale(newLocale)
    i18nLocale.value = newLocale

    // Página dinámica (legal u otras con slug)
    if (route.name === 'page' && route.params.slug) {
      const currentSlug = route.params.slug

      const translation = routeTranslations[currentSlug]

      if (translation) {
        const newSlug = translation[newLocale]

        router.push({
          path: `/${newLocale}/${newSlug}`
        })
        return
      }
    }
    
    // Página de listado de tours
    if (route.name === 'tour-list') {
      router.push({ name: 'tour-list', params: { lang: newLocale } })
      return
    }

    // Página de detalle (nuevo slug en el nuevo idioma)
    if (route.name === 'tour-detail') {
      try {
        const tourIdOrSlug = route.params.slug
        const res = await api.get(`/api/tours/${tourIdOrSlug}?lang=${newLocale}`)
        const newSlug = res.data.slug

        router.push({
          name: 'tour-detail',
          params: { lang: newLocale, slug: newSlug }
        })
        return
      } catch (err) {
        console.error('Error cambiando idioma del tour:', err)
      }
    }

    // Cualquier otra página
    router.push({
      name: route.name,
      params: { ...route.params, lang: newLocale }
    })
  }

  return { toggleLanguage }
}
