/**
 * Genera la URL completa de una imagen según el entorno
 * Compatible con Laravel Mix + Vue
 *
 * @param {string} path - Ruta que devuelve la API (ej: "/storage/images/tours/imagen.jpg")
 * @returns {string} URL completa accesible desde Vue
 */
export const getImageUrl = (path) => {
  if (!path) return '';

  // Detectar entorno desde process.env (Laravel Mix)
  const env = process.env.MIX_APP_ENV || 'local';

  const baseURL =
    env === 'local'
      ? process.env.MIX_APP_URL_LOCAL || 'http://127.0.0.1:8080'
      : process.env.MIX_APP_URL_PROD || 'https://www.magictourspv.com';

  // Limpiar slash inicial
  const cleanPath = path.startsWith('/') ? path.substring(1) : path;

  return `${baseURL}/${cleanPath}`;
};
