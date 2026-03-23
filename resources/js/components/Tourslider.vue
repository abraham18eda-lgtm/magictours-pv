<template>
  <div class="block sm:hidden px-4 py-8 relative max-w-md mx-auto">
    <!-- Tarjeta de tour actual -->
    <div class="relative bg-white rounded-lg shadow-lg overflow-hidden transition-all">
      <!-- Nombre encima -->
      <div
        class="absolute -top-5 left-1/2 transform -translate-x-1/2 bg-indigo-600 text-white px-6 py-1 rounded-full text-lg font-semibold shadow z-10"
      >
        {{ currentTour.name }}
      </div>

      <div class="pt-10 px-6 pb-6 flex flex-col h-full">
        <p class="text-gray-800 text-xl font-semibold mb-2">
          Precio: <span class="text-indigo-600">${{ currentTour.price }}</span>
        </p>
        <p class="text-gray-600 flex-grow">{{ currentTour.details }}</p>

        <div class="mt-6 flex justify-between">
          <button
            @click="openModal(currentTour)"
            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition"
            type="button"
          >
            Reservar
          </button>
          <button
            @click="viewDetails(currentTour)"
            class="border border-indigo-600 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-50 transition"
            type="button"
          >
            Ver más
          </button>
        </div>
      </div>
    </div>

    <!-- Botones izquierda/derecha -->
    <button
      @click="prevTour"
      class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-40 text-white p-2 rounded-full z-20"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <button
      @click="nextTour"
      class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-40 text-white p-2 rounded-full z-20"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>

    <!-- Modal Reservar -->
    <transition name="fade">
      <div
        v-if="showModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      >
        <div class="bg-white rounded-lg max-w-md w-full p-6 relative shadow-lg">
          <button
            @click="closeModal"
            class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold"
            aria-label="Cerrar"
          >
            &times;
          </button>
          <h3 class="text-2xl font-semibold mb-4">
            Reservar Tour: {{ selectedTour?.name }}
          </h3>

          <form @submit.prevent="submitReservation">
            <label class="block mb-2 font-medium" for="name">Nombre:</label>
            <input
              v-model="reservation.name"
              id="name"
              type="text"
              required
              class="w-full border border-gray-300 rounded-md px-3 py-2 mb-4 focus:ring-2 focus:ring-indigo-500"
            />

            <label class="block mb-2 font-medium" for="email">Email:</label>
            <input
              v-model="reservation.email"
              id="email"
              type="email"
              required
              class="w-full border border-gray-300 rounded-md px-3 py-2 mb-4 focus:ring-2 focus:ring-indigo-500"
            />

            <label class="block mb-2 font-medium" for="date">Fecha:</label>
            <input
              v-model="reservation.date"
              id="date"
              type="date"
              required
              class="w-full border border-gray-300 rounded-md px-3 py-2 mb-4 focus:ring-2 focus:ring-indigo-500"
            />

            <button
              type="submit"
              class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition"
            >
              Confirmar Reserva
            </button>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const tours = ref([
  {
    id: 1,
    name: 'Tour a la Playa',
    price: 120,
    details: 'Día completo en la playa con comida incluida.',
  },
  {
    id: 2,
    name: 'Aventura en Montaña',
    price: 150,
    details: 'Excursión con guía en senderos naturales.',
  },
  {
    id: 3,
    name: 'Tour Histórico',
    price: 90,
    details: 'Recorre los principales puntos históricos de la ciudad.',
  },
])

const currentIndex = ref(0)

const currentTour = computed(() => tours.value[currentIndex.value])

const nextTour = () => {
  currentIndex.value = (currentIndex.value + 1) % tours.value.length
}

const prevTour = () => {
  currentIndex.value = (currentIndex.value - 1 + tours.value.length) % tours.value.length
}

// Modal reservar
const showModal = ref(false)
const selectedTour = ref(null)
const reservation = ref({ name: '', email: '', date: '' })

const openModal = (tour) => {
  selectedTour.value = tour
  showModal.value = true
  reservation.value = { name: '', email: '', date: '' }
}

const closeModal = () => {
  showModal.value = false
}

const submitReservation = () => {
  alert(`Gracias, ${reservation.value.name}! Has reservado el tour "${selectedTour.value.name}" para el ${reservation.value.date}.`)
  closeModal()
}

const viewDetails = (tour) => {
  alert(`Detalles del tour:\n\n${tour.name}\n\n${tour.details}`)
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
