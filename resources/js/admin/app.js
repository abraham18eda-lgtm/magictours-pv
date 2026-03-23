import { createApp } from 'vue';
import router from './router';           // router exclusivo CMS
import App from './App.vue';             // App.vue del CMS
import { createPinia } from 'pinia';
import axios from './axios';
import '../../css/admin.css';

// axios.defaults.baseURL = 'http://localhost:8000/api';

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount('#app');