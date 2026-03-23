<template>
  <div
    class="group bg-white rounded-xl overflow-hidden shadow-md transition-all duration-300
           hover:shadow-xl hover:-translate-y-1"
  >
    <!-- MAP -->
    <div class="relative h-48 overflow-hidden">
      <iframe
        class="w-full h-full transition-transform duration-500 group-hover:scale-105"
        :src="mapUrl"
        width="400"
        height="300"
        style="border:0;"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>

      <!-- Overlay opcional -->
      <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition"></div>
    </div>

    <!-- CONTENIDO -->
    <div class="p-5 space-y-3">
      <h3 class="text-lg font-semibold text-gray-900">
        {{ title }}
      </h3>

      <p class="text-sm text-gray-600 leading-relaxed">
        {{ description }}
      </p>

      <div class="pt-3 border-t">
        <p class="text-sm font-medium text-gray-700">
          {{ schedule }}
        </p>
        <p class="text-sm text-gray-500">
          {{ time }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  description: String,
  schedule: String,
  mapUrl: { type: String, required: true },
  time: String
})
</script>
