import axios from 'axios';
import { useUserStore } from './stores/user';

const api = axios.create({
  // baseURL: 'https://www.magictourspv.com/',
  baseURL: 'http://localhost:8000/',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
});

// Interceptor para agregar token automáticamente
api.interceptors.request.use(config => {
  const userStore = useUserStore();
  const token = userStore.getToken();
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;