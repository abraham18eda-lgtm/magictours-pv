<!-- components/Form.vue -->
<template>
  <form @submit.prevent="submitForm" class="space-y-4">
    <input v-model="form.name" type="text" placeholder="Nombre" class="input" required />
    <input v-model="form.phone" type="tel" placeholder="Teléfono" class="input" required />
    <input v-model="form.email" type="email" placeholder="Email" class="input" required />
    <input v-model="form.date" type="date" class="input" required />

    <select v-model="form.tour" class="input" required>
      <option disabled value="">Selecciona un Tour</option>
      <option v-for="t in tours" :key="t.id" :value="t.name">{{ t.name }}</option>
    </select>

    <div class="flex items-center space-x-4">
      <span>Adultos:</span>
      <button type="button" @click="decrement" class="px-2 bg-gray-300 rounded">-</button>
      <span>{{ form.adults }}</span>
      <button type="button" @click="increment" class="px-2 bg-gray-300 rounded">+</button>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      Book Now
    </button>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const form = ref({
  name: '',
  phone: '',
  email: '',
  date: '',
  tour: '',
  adults: 1
})

const tours = [
  { id: 1, name: 'City Tour' },
  { id: 2, name: 'Adventure Trip' },
  { id: 3, name: 'Cultural Walk' }
]

function increment() {
  form.value.adults++
}

function decrement() {
  if (form.value.adults > 1) form.value.adults--
}

async function submitForm() {
  try {
    await axios.post('/api/bookings', form.value)
    alert('Reservación realizada con éxito')
    form.value = { name: '', phone: '', email: '', date: '', tour: '', adults: 1 }
  } catch (err) {
    console.error(err)
    alert('Error al enviar el formulario')
  }
}
</script>

<style scoped>
/* .input {
  @apply w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300;
} */
</style>
