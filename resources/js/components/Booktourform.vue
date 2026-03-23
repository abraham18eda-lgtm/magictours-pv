<!-- components/BookTourForm.vue -->
<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <img
        :src="logo"
        alt="Logo de Magic Tours"
        class="w-64 h-auto rounded shadow-lg"
        />
    </div>

  <!-- Canvas (desktop) -->
  <div v-if="open && !isMobile" class="fixed top-0 right-0 w-96 h-full bg-white shadow-lg z-50 p-6 overflow-auto">
    <h2 class="text-xl font-bold mb-4">Book a Tour</h2>
    <Form />
    <button @click="$emit('close')" class="absolute top-2 right-2 text-gray-500">✖</button>
  </div>

  <!-- Modal (mobile) -->
  <div v-if="open && isMobile" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md p-6 rounded">
      <h2 class="text-xl font-bold mb-4">Book a Tour</h2>
      <Form />
      <button @click="$emit('close')" class="absolute top-2 right-2 text-gray-500">✖</button>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import Form from '../agency/Form.vue'
// import logo from '@/storage/logos/magic-tours-vert.svg'

const props = defineProps({
  open: Boolean
})

defineEmits(['close'])

const isMobile = ref(false)

onMounted(() => {
  isMobile.value = window.innerWidth < 768
})
</script>
