import { t } from './lang'
// import { i18n } from './lang'

export function updateMeta(route) {
  if (!route?.name) return

  const name = String(route.name).toLowerCase()

  const title = t(`routes.${name}.title`)
  const description = t(`routes.${name}.description`)

  if (title && title !== `routes.${name}.title`) {
    document.title = title
  }

  let metaTag = document.querySelector('meta[name="description"]')

  if (!metaTag) {
    metaTag = document.createElement('meta')
    metaTag.setAttribute('name', 'description')
    document.head.appendChild(metaTag)
  }

  if (description && description !== `routes.${name}.description`) {
    metaTag.setAttribute('content', description)
  }
}
