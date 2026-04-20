<template>
  <div class="p-8 bg-gray-100 min-h-screen">
    <!-- <h1 class="text-2xl font-bold mb-6">Crear Tour</h1> -->

    <!-- TABS -->
    <div class="flex gap-2 mb-4">
      <button @click="activeTab = 'es'" :class="tabClass('es')">🇲🇽 Español</button>
      <button @click="activeTab = 'en'" :class="tabClass('en')">🇺🇸 English</button>
    </div>

    <!-- FORM -->
    <div class="bg-white p-6 rounded shadow space-y-4 ">
      
      <h2 class="text-base font-bold uppercase text-primary">Traducción: {{ activeTab.toUpperCase() }}</h2>
      <div>
        <!-- <label class="block mb-1 font-semibold">URL del tour</label> -->
        <div class="url-preview"> <!--  @click="copyUrl" -->
          https://www.magictourspv.com/{{ activeTab }}/tours/{{ form[activeTab].slug || "slug-del-tour" }}
        </div>
      </div>

      <h3 class="text-h3 text-primary py-4">Impresion detalles en Tarjetas</h3>
      <!-- Imagen -->
      <div>
        <label class="block mb-1 font-semibold">Imagen del tour</label>
        <input type="file" @change="handleFileChange" />
      </div>

      <input v-model="form[activeTab].title" placeholder="Título" class="input" />
      <textarea v-model="form[activeTab].description" placeholder="Descripción" class="input"></textarea>
      <input v-model="form[activeTab].regular_price" type="number" placeholder="Precio" class="input" />
      <input v-model="form[activeTab].descount_price" type="number" placeholder="Precio descuento" class="input" />

      <!-- Pagina de detalles -->
      <p class="text-h3 text-primary py-4">Impresion Pagina de detalles</p>
      <!-- Campos generales -->
      <input v-model="short_description" placeholder="Descripción corta" class="input" />

      <!-- Amenities -->
      <div class="mt-2">
        <label class="block mb-1 font-semibold">Amenities</label>
        <div v-for="(amenity, index) in form[activeTab].amenities" :key="index" class="flex gap-2 mb-2">
          <input
            type="text"
            v-model="form[activeTab].amenities[index]"
            placeholder="Amenity"
            class="input flex-1"
          />
          <button type="button" @click="removeAmenity(activeTab, index)" class="btn-red">X</button>
        </div>
        <button type="button" @click="addAmenity(activeTab)" class="btn-blue">Añadir Amenity</button>
      </div>

      <textarea v-model="description" placeholder="Descripción larga" class="input"></textarea>

       <!-- Site select -->
      <div>
        <label class="block mb-1 font-semibold">Selecciona el sitio</label>
        <select v-model="site_id" class="input">
          <option disabled value="">-- Selecciona un sitio --</option>
          <option value="vtaadventure">VTA Adventure</option>
          <option value="canopyriver">Canopy River</option>
        </select>
      </div>
       <!-- Fin del campo de detalles-->
       <!-- Checkbox Tour activo -->
      <div class="mt-2">
        <label class="flex items-center gap-2 font-semibold">
          <input type="checkbox" v-model="tourActive" />
          Tour activo
        </label>
      </div>

      <!-- Botón Crear -->
      <button @click="createTour" class="btn w-full mt-4">
        Crear Tour
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();
const activeTab = ref("es");

// Campos generales
const site_id = ref("");
const short_description = ref("");
const description = ref("");
const price = ref("");
const image = ref(null);

// Checkbox Tour activo (por defecto false)
const tourActive = ref(false);

// Traducciones
const form = reactive({
  es: { slug: "", title: "", description: "", regular_price: "", descount_price: "", amenities: [] },
  en: { slug: "", title: "", description: "", regular_price: "", descount_price: "", amenities: [] }
});

// --- Helpers ---

// Generar slug automáticamente
function generateSlug(text) {
  return text
    .toString()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .toLowerCase()
    .trim()
    .replace(/\s+/g, "-")
    .replace(/[^\w\-]+/g, "")
    .replace(/\-\-+/g, "-");
}

// Actualizar slug automáticamente al cambiar el título
watch(
  () => form[activeTab.value].title,
  (newTitle) => {
    form[activeTab.value].slug = generateSlug(newTitle);
  }
);

// Copiar URL al portapapeles
const copyUrl = () => {
  const url = `https://www.magictourspv.com/${activeTab.value}/tours/${form[activeTab.value].slug}`;
  navigator.clipboard.writeText(url);
  alert("URL copiada al portapapeles");
};

// Manejo de imagen
const handleFileChange = (event) => {
  image.value = event.target.files[0];
};

// Manejo de amenities
const addAmenity = (locale) => {
  form[locale].amenities.push("");
};
const removeAmenity = (locale, index) => {
  form[locale].amenities.splice(index, 1);
};

// Tabs clase dinámica
const tabClass = (tab) =>
  activeTab.value === tab
    ? "px-4 py-2 bg-blue-600 text-white rounded"
    : "px-4 py-2 bg-gray-200 rounded";

// Crear tour
const createTour = async () => {
  try {
    const formData = new FormData();
    if (image.value) formData.append("image", image.value);
    formData.append("site_id", site_id.value);
    formData.append("short_description", short_description.value);
    formData.append("description", description.value);
    formData.append("price", price.value);
    formData.append("tour_active", tourActive.value); // <-- enviamos el campo tour_active
    formData.append("translations", JSON.stringify(form));

    await axios.post("/api/tours", formData, {
      headers: { "Content-Type": "multipart/form-data" }
    });

    alert("Tour creado");
    router.push("/admin/tours");
  } catch (err) {
    console.error(err);
    alert("Error creando el tour");
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
.btn-blue {
  background: #3b82f6;
  color: white;
  padding: 6px 12px;
  border-radius: 6px;
}
.btn-red {
  background: #ef4444;
  color: white;
  padding: 6px 12px;
  border-radius: 6px;
}
.url-preview {
  background-color: #f3f4f6; /* gris claro */
  padding: 8px 12px;
  border-radius: 6px;
  font-family: monospace;
  color: #1f2937;
  cursor: pointer;
  overflow-x: auto;
  white-space: nowrap;
}
.url-preview:hover {
  background-color: #e5e7eb;
}
</style>