<template>
  <div class="p-8 min-h-screen ">
    <h1 class="text-base lg:text-2xl uppercase font-bold text-gray-800 text-primary text-center text-primary-600 text-blue-600 lg:mb-12">Lista de Tours</h1>
      
    <!-- Lista de tours -->
    <div class="flex gap-2 justify-end items-center">
      <button
        @click="changeLocale('es')"
        :class="locale === 'es' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700'"
        class="px-4 py-2 rounded border"
      >
        🇲🇽 ES
      </button>

      <button
        @click="changeLocale('en')"
        :class="locale === 'en' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700'"
        class="px-4 py-2 rounded border"
      >
        🇺🇸 EN
      </button>
    </div>
    <div class="mt-6 grid gap-4 grid-cols-1 md:grid-cols-2">
      <div
        v-for="tour in tours"
        :key="tour.id"
        class="bg-white rounded-xl shadow p-4 flex justify-between items-center"
      >
        <div>
          <h2 class="text-xl font-semibold text-gray-700">
              {{ tour.translation.title }}
          </h2>
          <p class="text-gray-500 mt-1">Precio: $
            {{ tour.translation.regular_price }}
          </p>
        </div>

        <div class="flex space-x-2">
          <router-link
            :to="`/admin/tours/edit/${tour.id}`"
            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition"
          >
            Editar
          </router-link>
        </div>
      </div>
    </div>

    <p v-if="error" class="text-red-500 text-sm mt-4">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../api";

const tours = ref([]);
const error = ref("");
const locale = ref("es");


const getTranslation = (tour) => {
  return tour.translations.find(t => t.locale === locale.value) || {};
};

const loadTours = async () => {
  error.value = "";
  try {
    const res = await api.get(`/admin/tours`);
    // const res = await api.get("/tours");
    tours.value = res.data.map(tour => {
      const translation = tour.translations.find(
        t => t.locale === locale.value
      );

      return {
        ...tour,
        translation: translation || {}
      };
    });
  } catch (err) {
    // console.log(err);
    if (err.response) {
    // console.log(err.response.data);
    // console.log(err.response.status);
  }
    error.value = "Error al cargar tours";
  }
};
const changeLocale = (lang) => {
  locale.value = lang;
  loadTours(); // recargar tours
};

onMounted(loadTours);
</script>