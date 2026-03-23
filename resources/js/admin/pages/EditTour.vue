<template>
  <div class="p-8 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-bold mb-6">Editar Tour</h1>

    <!-- TABS -->
    <div class="flex gap-2 mb-6">
      <button
        @click="activeTab = 'es'"
        :class="tabClass('es')"
      >
        🇲🇽 Español
      </button>

      <button
        @click="activeTab = 'en'"
        :class="tabClass('en')"
      >
        🇺🇸 English
      </button>
    </div>

    <!-- FORM -->
    <div class="bg-white p-6 rounded shadow">
      <input
        v-model="form[activeTab].title"
        type="text"
        placeholder="Título"
        class="w-full border p-2 mb-4"
      />

      <input
        v-model="form[activeTab].regular_price"
        type="number"
        placeholder="Precio"
        class="w-full border p-2 mb-4"
      />

      <button
        @click="saveTour"
        class="bg-blue-600 text-white px-4 py-2 rounded"
      >
        Guardar
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import api from "../api";

const route = useRoute();
const tourId = route.params.id;

const activeTab = ref("es");

const form = ref({
  es: { title: "", regular_price: "" },
  en: { title: "", regular_price: "" }
});

const tabClass = (tab) =>
  activeTab.value === tab
    ? "px-4 py-2 rounded bg-blue-600 text-white"
    : "px-4 py-2 rounded bg-gray-200";

const loadTour = async () => {
  try {
    const res = await api.get(`/admin/tours/${tourId}`);

    res.data.translations.forEach((t) => {
      if (form.value[t.locale]) {
        form.value[t.locale] = {
          title: t.title,
          regular_price: t.regular_price
        };
      }
    });

  } catch (err) {
    console.log(err);
  }
};

const saveTour = async () => {
  try {
    await api.put(`/admin/tours/${tourId}`, {
      translations: form.value
    });

    alert("Guardado correctamente");
  } catch (err) {
    console.log(err);
  }
};

onMounted(loadTour);
</script>