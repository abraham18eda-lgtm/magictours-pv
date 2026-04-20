// composables/useSeo.js
import { useHead } from '@vueuse/head'
import { useI18n } from 'vue-i18n'

export function useSeo(key) {
  const { t } = useI18n()

  useHead(() => ({
    title: t(`${key}.title`),
    meta: [
      {
        name: 'description',
        content: t(`${key}.description`)
      }
    ]
  }))
}