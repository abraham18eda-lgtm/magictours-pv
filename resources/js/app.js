// import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia'
import { createI18n } from 'vue-i18n'
import App from './agency/App.vue';
import router from './router';
import axios from 'axios';
import metaPlugin from './plugins/metaPlugin'

// Importar JSON locales
import en from './lang/en.json'
import es from './lang/es.json'

import '../css/app.css';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token no encontrado: revisa tu <head>');
}

//Idioma por defecto (puedes obtenerlo del backend, navegador, o localStorage)
// const locale = document.documentElement.lang || 'es';
const savedLocale = localStorage.getItem('locale') || 'en'

// 🚀 Inicializamos la app de forma asíncrona para poder cargar traducciones
async function setupApp() {

    // Crear instancia de i18n
    const i18n = createI18n({
        legacy: false, // Recomendado para Vue 3 Composition API
        locale: savedLocale,
        fallbackLocale: 'en',
        messages: { en, es }, // ya no necesitamos "messages"
    });

    // Crear la app de Vue
    const app = createApp(App);
    app.use(createPinia());
    app.use(router);
    app.use(metaPlugin , { router })
    app.use(i18n); // Registramos i18n
    app.config.globalProperties.$axios = axios;

    app.mount('#app');
}

// Iniciar
setupApp();
