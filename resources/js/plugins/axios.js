import axios from 'axios'
import { useLocaleStore } from '../stores/locale'

const api = axios.create({
  // baseURL: 'https://www.magictourspv.com/',
  baseURL: 'http://localhost:8000/',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

export default api
