import { createRouter, createWebHistory } from 'vue-router'
import { updateMeta } from '../meta'
import TourList from '../components/TourList.vue'
import TourDetail from '../components/TourDetail.vue'
import Home from '../agency/Home.vue'
import Dashboard from '../components/Dashboard.vue'
import PageResolver from '../components/PageResolver.vue'
import PrivacyPolicy from '../components/legal/PrivacyPolicy.vue'
import CookiesPolicy from '../components/legal/CookiesPolicy.vue'
import TermsConditions  from '../components/legal/TermsConditions.vue'

const routes = [
    {
    path: '/:lang(en|es)?',   // idioma opcional, solo "en" o "es"
    name: 'home',
    component: Home,
    props: route => ({ lang: route.params.lang || 'es' })
  },
  {
    path: '/:lang(en|es)?/tours',   // idioma opcional, solo "en" o "es"
    name: 'tour-list',
    component: TourList,
    props: route => ({ lang: route.params.lang || 'es' })
  },
  {
    path: '/:lang(en|es)?/tours/:slug',
    name: 'tour-detail',
    component: TourDetail,
    props: route => ({ slug: route.params.slug, lang: route.params.lang || 'es' })
  },
  {
    path: '/:lang/:slug',
    name: 'page',
    component: PageResolver
  },
  {
    path: '/privacy-policy',
    name: 'PrivacyPolicy',
    component: PrivacyPolicy
  },
  {
    path: '/cookie-policy',
    name: 'CookiesPolicy',
    component: CookiesPolicy
  },
  {
    path: '/terms-and-conditions',
    name: 'TermsConditions',
    component: TermsConditions
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard
  },

  // Ruta por defecto: redirigir a idioma por defecto
  {
    path: '/:catchAll(.*)',
    redirect: '/es/'
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    // Si hay posición guardada (botón back)
    if (savedPosition) {
      return savedPosition
    }

    // 🔥 Siempre ir al top en nuevas páginas
    return { top: 0 }
  }
})

// Antes de cada ruta: asegurarnos que localeStore esté sincronizado
import { useLocaleStore } from '../stores/locale'

router.beforeEach((to, from, next) => {
  const localeStore = useLocaleStore()
  const urlLang  = to.params.lang || 'es'
  if (localeStore.locale !== urlLang) {
    localeStore.setLocale(urlLang)
  }
  next()
})

router.afterEach((to) => {
  const skip = ['CookiesPolicy', 'PrivacyPolicy', 'TermsConditions']

  if (skip.includes(to.name)) return

  updateMeta(to)
})


export default router
