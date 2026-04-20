<!-- resources/js/admin/pages/Login.vue -->
<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-blue-100 to-blue-200 px-4">
    <div class="bg-white shadow-xl rounded-xl w-full max-w-sm p-8">
      <!-- Logo / Título -->
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-blue-700">Magic Tours CMS</h1>
        <p class="text-gray-500 mt-1 text-sm">Inicia sesión para continuar</p>
      </div>

      <!-- Formulario -->
      <form @submit.prevent="login" class="space-y-5">
        <!-- Email -->
        <div>
          <label for="email" class="block text-gray-700 font-medium mb-1">Correo electrónico</label>
          <input
            v-model="form.email"
            type="email"
            id="email"
            placeholder="tu@correo.com"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
            required
          />
        </div>

        <!-- Contraseña -->
        <div>
          <label for="password" class="block text-gray-700 font-medium mb-1">Contraseña</label>
          <input
            v-model="form.password"
            type="password"
            id="password"
            placeholder="********"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
            required
          />
        </div>

        <!-- Botón login -->
        <button
          type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition duration-200"
          :disabled="loading"
        >
          <span v-if="loading">Ingresando...</span>
          <span v-else>Iniciar sesión</span>
        </button>

        <!-- Mensaje de error -->
        <p v-if="error" class="text-red-500 text-sm mt-2 text-center">{{ error }}</p>
      </form>

      <!-- Footer opcional -->
      <p class="text-center text-gray-400 text-sm mt-4">
        &copy; 2026 Magictourspv
      </p>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import api from "../api";
import { useRouter } from "vue-router";
import { useUserStore } from '../stores/user';

// Router de Vue para redireccionar después del login
const router = useRouter();
const userStore = useUserStore();

// Datos del formulario
const form = reactive({
  email: "",
  password: "",
});

// Estado de carga y error
const loading = ref(false);
const error = ref("");

// Función de login
const login = async () => {
  loading.value = true;
  error.value = "";

  try {
    
    const res = await api.post('/admin/login', { email: email.value, password: password.value });
    console.log(api.defaults.baseURL + '/admin/login');
    userStore.setToken(res.data.token);
    
    router.push({ name: 'Dashboard' }); // redirige al dashboard
  } catch (err) {
    // Manejar errores de login
    if (err.response && err.response.data.message) {
      error.value = err.response.data.message;
    } else {
      error.value = "Error al iniciar sesión";
    }
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
input:focus {
  outline: none;
}
</style>