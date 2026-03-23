import { defineStore } from 'pinia'

export const useLocaleStore = defineStore('locale', {
  state: () => ({
    locale: localStorage.getItem('locale') || 'en',
  }),
  actions: {
    setLocale(lang) {
      this.locale = lang
      localStorage.setItem('locale', lang)
    },
  },
})
 