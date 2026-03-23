// Normalizamos todas las keys a minúsculas
const templates = {
  vtaadventure: () => import('./Vtaadventure.vue'),
  canopyriver: () => import('./Canopyriver.vue'),
  default: () => import('./DefaultTours.vue'),
}

// Función helper para obtener loader seguro
export const getTemplateLoader = (key) => {
  if (!key) return templates.default
  const normalizedKey = key.toLowerCase()
  return templates[normalizedKey] || templates.default
}

export default templates
