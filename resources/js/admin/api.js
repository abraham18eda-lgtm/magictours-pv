import axios from "axios";

// Creamos la instancia de Axios para la API
const api = axios.create({
  // baseURL: 'https://www.magictourspv.com/api',
  baseURL: 'http://localhost:8000/api',
  headers: {
    "Content-Type": "application/json",
    "Accept": "application/json"
  }
});

// Interceptor opcional para agregar token automáticamente
api.interceptors.request.use(config => {
  const token = localStorage.getItem("token"); // token guardado
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;