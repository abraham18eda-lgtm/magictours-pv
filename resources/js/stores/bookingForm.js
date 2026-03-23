import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useBookingFormStore = defineStore('bookingForm', () => {
  const show = ref(false) // controla si el modal se muestra
  const selectedTour = ref(null)

  function open(tour = null) {
    show.value = true
    selectedTour.value = tour // GUARDAMOS EL TOUR
  }

  function close() {
    show.value = false
    selectedTour.value = null // LIMPIAMOS
  }

  // function open() { show.value = true }
  // function close() { show.value = false }

  return { show, open, close, selectedTour  }
})
