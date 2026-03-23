// resources/js/plugins/metaPlugin.js
import { updateMeta } from '../meta'

export default {
  install(app, { router }) {
    if (!router) {
      console.warn('[metaPlugin] Router instance is required')
      return
    }

    router.afterEach((to) => {
      updateMeta(to)
    })
  }
}
