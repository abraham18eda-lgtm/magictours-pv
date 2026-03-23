import { t } from './lang'

export function updateMeta(route) {
  if (!route.name) return

  const name = route.name.toLowerCase()
  const title = t(`routes.${name}.title`)
  const description = t(`routes.${name}.description`)

  if (title) document.title = title

  // Actualiza meta description
  let metaTag = document.querySelector('meta[name="description"]')
  if (metaTag) metaTag.remove()

  if (description) {
    metaTag = document.createElement('meta')
    metaTag.name = 'description'
    metaTag.content = description
    document.head.appendChild(metaTag)
  }
}

