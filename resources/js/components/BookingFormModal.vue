<template>
  <Transition name="fade">
    <div
      v-show="booking.show"
      class="fixed inset-0 z-50 flex justify-center items-end md:items-center bg-black/40 backdrop-blur-sm"
    >
      <!-- CONTAINER -->
      <div
        ref="formContainer"
        class="w-full h-full md:h-auto md:max-w-lg bg-white md:rounded-2xl shadow-xl overflow-y-auto animate-slideUp"
      >
        <!-- HEADER -->
        <div class="sticky top-0 bg-white z-10 border-b px-5 py-4 flex items-center justify-between">
          <h2 class="text-lg font-semibold text-gray-800">
            {{ $t('cta.primary_book') }}
          </h2>

          <button @click="booking.close()" class="text-gray-400 hover:text-black text-2xl">
            ✕
          </button>
        </div>

        <!-- CONTENT -->
        <div class="p-5 space-y-5">

          <!-- SUCCESS -->
          <div
            v-if="successMessage"
            class="bg-green-50 text-green-700 p-4 rounded-xl text-center"
            v-html="successMessage"
          ></div>

          <form v-else @submit.prevent="submitForm" class="space-y-4">

            <!-- INPUTS -->
            <div class="grid grid-cols-1 gap-4">

              <div class="floating">
                <input v-model="form.name" placeholder=" " class="input-airbnb" />
                <label>Nombre completo</label>
              </div>

              <div class="floating">
                <input
                  v-model="form.phone"
                  @input="form.phone = form.phone.replace(/\D/g, '')"
                  placeholder=" "
                  class="input-airbnb"
                />
                <label>Teléfono</label>
              </div>

              <div class="floating">
                <input ref="dateInput" class="input-airbnb" type="text" id="fechaInput" placeholder=" " readonly />
                <label>Fecha</label>
              </div>

              <div class="floating">
                <input type="email" v-model="form.email" placeholder=" " class="input-airbnb" />
                <label>Email</label>
              </div>

              <!-- TOUR DROPDOWN -->
               <!-- Tours dropdown -->
              <div class="relative" ref="formContainer" id="tour-dropdown">
                <input
                  v-model="tourSearch"
                  @focus="tourOpen = true"
                  placeholder="Seleccionar tour"
                  class="input-airbnb w-full"
                />
                <ul v-if="tourOpen"
                    class="absolute w-full bg-white border rounded-xl shadow-xl mt-1 max-h-56 overflow-y-auto z-[999]">
                  <li
                    v-for="tour in filteredTours"
                    :key="tour.id"
                    @mousedown.prevent="selectTour(tour)"
                    class="px-4 py-3 hover:bg-gray-100 cursor-pointer transition"
                  >
                    {{ tour.title }}
                  </li>
                  <li v-if="filteredTours.length === 0" class="px-4 py-3 text-gray-500">
                    No se encontraron resultados
                  </li>
                </ul>
                <input type="hidden" name="tour" :value="tourForm" />
              </div>

              <!-- <div class="relative" id="tour-dropdown">
                <input
                  v-model="tourSearch"
                  @focus="tourOpen = true"
                  placeholder="Seleccionar tour"
                  class="input-airbnb w-full"
                />

                <ul
                  v-if="tourOpen"
                  class="absolute w-full bg-white border rounded-xl shadow-xl mt-1 max-h-56 overflow-y-auto z-[999]"
                >
                  <li
                    v-for="tour in filteredTours"
                    :key="tour.id"
                    @mousedown.prevent="selectTour(tour)"
                    class="px-4 py-3 hover:bg-gray-100 cursor-pointer"
                  >
                    {{ tour.title }}
                  </li>

                  <li v-if="filteredTours.length === 0" class="px-4 py-3 text-gray-500">
                    No se encontraron resultados
                  </li>
                </ul>
              </div> -->

            </div>

            <!-- COUNTERS -->
            <div class="border rounded-xl divide-y">

              <div class="flex justify-between items-center p-4">
                <div>
                  <p class="font-medium">Adultos</p>
                </div>
                <div class="flex items-center gap-3">
                  <button type="button" @click="decreaseAdults" class="btn-circle-airbnb">-</button>
                  <span>{{ form.adults }}</span>
                  <button type="button" @click="increaseAdults" class="btn-circle-airbnb">+</button>
                </div>
              </div>

              <div class="flex justify-between items-center p-4">
                <div>
                  <p class="font-medium">Niños</p>
                </div>
                <div class="flex items-center gap-3">
                  <button type="button" @click="decreaseMenor" class="btn-circle-airbnb">-</button>
                  <span>{{ form.children }}</span>
                  <button type="button" @click="increaseMenor" class="btn-circle-airbnb">+</button>
                </div>
              </div>

            </div>

            <!-- CTA -->
            <button
              type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-semibold"
            >
              {{ $t('form.cta_book') }}
            </button>

          </form>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useBookingFormStore } from '../stores/bookingForm'
import { useLocaleStore } from '../stores/locale'
import { useI18n } from 'vue-i18n'
import axios from 'axios'
import api from '../plugins/axios'
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

import { Spanish } from 'flatpickr/dist/l10n/es.js'

const booking = useBookingFormStore()
const { t } = useI18n()

const form = ref({
  name: '',
  phone: '',
  date: '',
  email: '',
  tour: '',
  adults: 1,
  children: 0
})

const successMessage = ref('')

// AUTO SELECCIÓN DEL TOUR
const tourSearch = ref('')
const tourForm = ref(null)
const dateInput = ref(null)
const route = useRoute()

watch(
  () => booking.selectedTour,
  (tour) => {
    if (tour) {
      tourSearch.value = tour.title
      tourForm.value = tour.id
      form.value.tour = tour.id
    } else {
      tourSearch.value = ''
      tourForm.value = null
      form.value.tour = ''
    }
  },
  { immediate: true }
)

// COUNTERS
const increaseAdults = () => form.value.adults++
const decreaseAdults = () => { if (form.value.adults > 1) form.value.adults-- }
const increaseMenor = () => form.value.children++
const decreaseMenor = () => { if (form.value.children > 0) form.value.children-- }

// DATE
const initializeFlatpickr = (lang) => {
  if (!dateInput.value) return

  const config = {
    dateFormat: "Y-m-d",
    minDate: "today",
    disableMobile: true,
    onChange: (selectedDates, dateStr) => {
      form.value.date = dateStr
    }
  }

  if (lang === 'es') {
    config.locale = Spanish
  }

  flatpickr(dateInput.value, config)
}

onMounted(() => {
  const lang = route.params.lang || 'es'
  initializeFlatpickr(lang)
})

// Watch para actualizar el idioma de flatpickr cuando cambie la ruta (idioma)
watch(
  () => route.params.lang,
  (newLang) => {
    initializeFlatpickr(newLang)
  },
  { immediate: true }
)

// TOURS
const tours = ref([])
const tourOpen = ref(false)

const fetchTours = async () => {
  const res = await api.get('api/tours?lang=es')
  tours.value = res.data
}

const filteredTours = computed(() => {
  if (!tourSearch.value) return tours.value.slice(0, 6)
  return tours.value.filter(t =>
    t.title.toLowerCase().includes(tourSearch.value.toLowerCase())
  )
})

const selectTour = (tour) => {
  tourSearch.value = tour.title
  tourForm.value = tour.id
  form.value.tour = tour.id
  tourOpen.value = false
}

// SUBMIT
const submitForm = async () => {
  try {
    await axios.post('/api/bookings', form.value)
    successMessage.value = t('form.cta_book_success')
    booking.close()
  } catch (error) {
    alert(t('form.cta_book_error'))
  }
}

onMounted(fetchTours)
</script>



<style scoped>
/* INPUT AIRBNB */
.input-airbnb {
  width: 100%;
  border: 1px solid #d1d5db;
  border-radius: 12px;
  padding: 16px 12px 6px;
  outline: none;
  font-size: 16px;
  transition: 0.2s;
}

.input-airbnb:focus {
  border-color: black;
  box-shadow: 0 0 0 1px black;
}

/* FLOATING LABEL */
.floating {
  position: relative;
}

.floating label {
  position: absolute;
  left: 12px;
  top: 14px;
  color: #6b7280;
  font-size: 14px;
  transition: 0.2s;
  pointer-events: none;
}

.input-airbnb:focus + label,
.input-airbnb:not(:placeholder-shown) + label {
  top: 6px;
  font-size: 11px;
  color: black;
}

/* BUTTONS */
.btn-circle-airbnb {
  width: 32px;
  height: 32px;
  border-radius: 999px;
  border: 1px solid #d1d5db;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ANIMACIONES */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.animate-slideUp {
  animation: slideUp 0.25s ease;
}

@keyframes slideUp {
  from {
    transform: translateY(40px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

/* MOBILE FULL SCREEN FIX */
@media (max-width: 768px) {
  .animate-slideUp {
    border-radius: 20px 20px 0 0;
  }
}

/*
.flatpickr-calendar {
  border-radius: 12px !important;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.flatpickr-day.selected {
  background: #2563eb !important;
  border-color: #2563eb !important;
} */

/* Fondo azul para el calendario */
.flatpickr-calendar {
  background-color: #2c3e50 !important; /* Azul oscuro elegante */
  color: white !important; /* Texto blanco */
  border-radius: 8px !important; /* Bordes redondeados */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;  /* Sombra sutil */
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

/* Encabezado con fondo más oscuro */
.flatpickr-month {
  background-color: #1A2A3A !important; /* Azul más oscuro */
  color: white !important; /* Texto blanco */
  border-radius: 8px 8px 0 0 !important; /* Bordes redondeados arriba */
}

/* Día seleccionado */
.flatpickr-day.selected {
  background-color: #2980b9 !important; /* Azul claro para el día seleccionado */
  color: white !important; /* Texto blanco */
  border-radius: 50% !important; /* Hacer el círculo */
}

/* Día hover (cuando el usuario pasa el ratón sobre el día) */
.flatpickr-day:hover {
  background-color: #3498db !important; /* Azul intermedio */
  color: white !important;
  cursor: pointer !important; /* Cambiar el cursor */
}

/* Asegurarse que el botón de "Hoy" también tenga un buen estilo */
.flatpickr-current-day {
  background-color: #1ABC9C !important; /* Verde suave para el botón de hoy */
  color: white !important;
  border-radius: 50% !important;
  font-weight: bold !important;
}

/* Cambiar el color de los botones (previo/siguiente) */
.flatpickr-prev-month, .flatpickr-next-month {
  color: #2980b9 !important; /* Azul para las flechas de mes */
}

/* Desactivar los días (vacíos o inalcanzables) */
.flatpickr-day.disabled {
  background-color: #7f8c8d !important; /* Gris para los días deshabilitados */
  color: white !important;
  cursor: not-allowed !important;
}

/* Estilo de los días del mes */
.flatpickr-day {
  padding: 10px !important;
  border-radius: 4px !important;
  text-align: center !important; 
  font-size: 16px !important;
}

/* Estilo de los días del encabezado (Lun, Mar, Mié...) */
.flatpickr-weekday {
  font-weight: bold !important;
  color: #ecf0f1 !important; /* Color gris claro para los días de la semana */
}

/* Estilo del calendario cuando está abierto (fondo semi-transparente) */
.flatpickr-calendar.open {
  opacity: 1 !important;
  transition: opacity 0.2s ease-in-out !important;
}


</style>