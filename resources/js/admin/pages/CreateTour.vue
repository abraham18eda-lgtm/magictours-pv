<template>
  <div class="p-8 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-bold mb-6">Crear Tour</h1>

    <!-- TABS -->
    <div class="flex gap-2 mb-6">
      <button @click="activeTab = 'es'" :class="tabClass('es')">
        🇲🇽 Español
      </button>

      <button @click="activeTab = 'en'" :class="tabClass('en')">
        🇺🇸 English
      </button>
    </div>

    <!-- FORM -->
    <div class="bg-white p-6 rounded shadow space-y-4">
      
      <input v-model="form[activeTab].title" placeholder="Título" class="input" />
      <input v-model="form[activeTab].slug" placeholder="Slug" class="input" />

      <textarea v-model="form[activeTab].description" placeholder="Descripción" class="input"></textarea>

      <input v-model="form[activeTab].regular_price" type="number" placeholder="Precio" class="input" />

      <input v-model="form[activeTab].descount_price" type="number" placeholder="Precio descuento" class="input" />

      <button @click="createTour" class="btn">
        Crear Tour
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import api from "../api";
import { useRouter } from "vue-router";

const router = useRouter();

const activeTab = ref("es");

const form = ref({
  es: {
    slug: "",
    title: "",
    description: "",
    regular_price: "",
    descount_price: ""
  },
  en: {
    slug: "",
    title: "",
    description: "",
    regular_price: "",
    descount_price: ""
  }
});

const tabClass = (tab) =>
  activeTab.value === tab
    ? "px-4 py-2 bg-blue-600 text-white rounded"
    : "px-4 py-2 bg-gray-200 rounded";

const createTour = async () => {
  try {
    await api.post("/admin/tours", {
      translations: form.value
    });

    alert("Tour creado");
    router.push("/admin/tours");

  } catch (err) {
    console.log(err);
  }
};
</script>

<style>
.input {
  width: 100%;
  border: 1px solid #ccc;
  padding: 8px;
  border-radius: 6px;
}
.btn {
  background: #2563eb;
  color: white;
  padding: 10px;
  border-radius: 6px;
}
</style>