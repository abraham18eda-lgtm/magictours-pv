import { createRouter, createWebHistory } from 'vue-router'
import TourList from '../components/TourList.vue'
import TourDetail from '../components/TourDetail.vue'
import Home from '../agency/Home.vue'
import Dashboard from '../components/Dashboard.vue'

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
  routes
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

export default router
