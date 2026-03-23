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
            <!-- {{ $t('cta.primary_book') }} -->
              {{ booking.selectedTour?.title || $t('cta.primary_book') }}
          </h2>

          <button
            @click="booking.close"
            class="text-gray-400 hover:text-black text-2xl"
          >
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

            <!-- INPUT GROUP -->
            <div class="grid grid-cols-1 gap-4">

              <!-- NAME -->
              <div class="floating">
                <input v-model="form.name" placeholder=" " class="input-airbnb" />
                <label>Nombre completo</label>
              </div>

              <!-- PHONE -->
              <div class="floating">
                <input
                  v-model="form.phone"
                  @input="form.phone = form.phone.replace(/\D/g, '')"
                  placeholder=" "
                  class="input-airbnb"
                />
                <label>Teléfono</label>
              </div>

              <!-- DATE -->
              <div class="floating">
                <input ref="dateInput" class="input-airbnb" placeholder=" " />
                <label>Fecha</label>
              </div>

              <!-- EMAIL -->
              <div class="floating">
                <input type="email" v-model="form.email" placeholder=" " class="input-airbnb" />
                <label>Email</label>
              </div>

              <!-- Tours dropdown -->
              <!-- Input estilo Airbnb -->
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
              <!-- Fin del dropdown -->

            </div>

            <!-- COUNTERS -->
            <div class="border rounded-xl divide-y">

              <!-- ADULTS -->
              <div class="flex justify-between items-center p-4">
                <div>
                  <p class="font-medium">Adultos</p>
                  <p class="text-sm text-gray-500">Edad 13+</p>
                </div>

                <div class="flex items-center gap-3">
                  <button type="button" @click="decreaseAdults" class="btn-circle-airbnb">-</button>
                  <span class="w-6 text-center">{{ form.adults }}</span>
                  <button type="button" @click="increaseAdults" class="btn-circle-airbnb">+</button>
                </div>
              </div>

              <!-- CHILDREN -->
              <div class="flex justify-between items-center p-4">
                <div>
                  <p class="font-medium">Niños</p>
                  <p class="text-sm text-gray-500">Edad 0–12</p>
                </div>

                <div class="flex items-center gap-3">
                  <button type="button" @click="decreaseMenor" class="btn-circle-airbnb">-</button>
                  <span class="w-6 text-center">{{ form.children }}</span>
                  <button type="button" @click="increaseMenor" class="btn-circle-airbnb">+</button>
                </div>
              </div>

            </div>

            <!-- CTA -->
            <div class="pt-2">
              <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-semibold text-lg transition active:scale-[0.98]"
              >
                {{ $t('form.cta_book') }}
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onBeforeUnmount, watch } from 'vue'
import { useBookingFormStore } from '../stores/bookingForm'
import { useI18n } from 'vue-i18n'
import axios from 'axios'
import logo from '../assets/logos/magic-tours-hz.svg';
import api from '../plugins/axios'
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

const booking = useBookingFormStore()

// tm() devuelve objetos completos del JSON (no solo strings)
const { t, tm } = useI18n()

const isMobile = ref(window.innerWidth < 768)
window.addEventListener('resize', () => isMobile.value = window.innerWidth < 768)


defineEmits(["open-drawer"])

// Form data
const form = ref({
  name: '',
  phone: '',
  date: '',
  email: '',
  tour: '',
  adults: 1,
  children: 0,
//   tour: ref('')
})

// Counter
const increaseAdults = () => {
  form.value.adults++
}
const decreaseAdults = () => {
  if (form.value.adults > 1)
  form.value.adults--
}

const increaseMenor = () => {
  form.value.children++
}
const decreaseMenor = () => {
  if (form.value.children > 0)
  form.value.children--
}
const errors = ref({})
const formSubmitted = ref(false)
const successMessage = ref('') // al inicio del script, junto a tus refs

// Flatpickr
const dateInput = ref(null);
onMounted(() => {
  flatpickr(dateInput.value, {
    dateFormat: "Y-m-d",
    minDate: "today", // ❌ bloquea fechas pasadas
    // disable: [
    //   "2026-03-20",
    //   "2026-03-25"
    // ], //fechas bloqueadas manuales
    locale: {
      firstDayOfWeek: 1
    },
    onChange: (selectedDates, dateStr) => {
      form.date = dateStr;
    }
  });
});

// desahabilitar fechas desde backend
// const disabledDates = ref([]);

// onMounted(async () => {
//   const res = await api.get('/disabled-dates');
//   disabledDates.value = res.data;

//   flatpickr(dateInput.value, {
//     dateFormat: "Y-m-d",
//     minDate: "today",
//     disable: disabledDates.value,
//     onChange: (selectedDates, dateStr) => {
//       form.date = dateStr;
//     }
//   });
// });

// Submit
const submitForm = async () => {
  errors.value = {}; // limpiar antes de enviar
  try {
    await axios.post('/api/bookings', form.value)

    successMessage.value = t('form.cta_book_success')
    setTimeout(() => { successMessage.value = ''
    isOpen.value = false }, 10000)

    form.value = {
      name: '',
      phone: '',
      date: '',
      email: '',
      tour: '',
      adults: 1,
      children: 0
    }
    // closeForm()
  } catch (error) {
    if (error.response?.status === 422) {
      // Mapear errores del backend a tus traducciones
      errors.value = Object.fromEntries(
        Object.entries(error.response.data.errors).map(([key, messages]) => [
          key,
          [t(`formErrors.${key}`)] // toma solo la traducción
        ])
      )
    } else {
      alert(t('form.cta_book_error')) // error genérico
    }
  }
  setTimeout(() => {
    isSubmitting.value = false
  }, 500)
}

const closeForm = () => {
  booking.close()   // usa el método de tu store
}

// Fecha mínima = hoy
const today = new Date().toISOString().split('T')[0]

// titulos del input desde api
const tours = ref([])
const tourSearch = ref('')
const tourForm = ref(null)
const tourOpen = ref(false)

// referencia al contenedor del formulario para los click fuera
const formContainer = ref(null)

// Traer tours desde la API
const fetchTours = async () => {
  try {
    const res = await api.get('api/tours?lang=es')
    tours.value = res.data
  } catch (err) {
    console.error('Error fetching tours:', err)
  }
}

// const openDropdown = () => {
//   tourOpen.value = true
// }

// Filtrar tours
const filteredTours = computed(() => {
  if (!tourSearch.value) return tours.value.slice(0, 6)

  const term = tourSearch.value.toLowerCase()
  return tours.value.filter(t =>
    (t.title || '').toLowerCase().includes(term)
  )
})

// seleccion
const selectTour = (tour) => {
  tourSearch.value = tour.title
  tourForm.value = tour.id
  tourOpen.value = false
}

// const onSearch = () => { tourOpen.value = true}

// Cerrar dropdown al hacer clic fuera
const closeDropdown = () => tourOpen.value = false
// function handleClickOutside(e) {
//   if (!e.target.closest('.tour-select-wrapper')) {
//     tourOpen.value = false
//   }
// }

// Manejar click fuera del dropdown y del formulario
function handleClickOutside(e) {
  const dropdown = document.getElementById('tour-dropdown')
  if (dropdown && dropdown.contains(e.target)) return
  // Solo cerramos el dropdown, no el formulario
  tourOpen.value = false
}

function handleClickOutsideForm(e) {
  if (!formContainer.value) return
  const dropdown = document.getElementById('tour-dropdown')
  // Ignorar clicks dentro del formulario o del dropdown
  if (formContainer.value.contains(e.target) || (dropdown && dropdown.contains(e.target))) return
  // Aquí puedes cerrar el formulario si usas un estado tipo booking.show
  // booking.close()
}

watch(
  () => booking.selectedTour,
  (tour) => {
    if (tour) {
      tourSearch.value = tour.title   // llena el input visible
      tourForm.value = tour.id        // id oculto
      form.value.tour = tour.id       // se envía al backend
    }
  },
  { immediate: true }
)

watch(
  () => booking.show,
  (isOpen) => {
    if (isOpen && !booking.selectedTour) {
      tourSearch.value = ''
      tourForm.value = null
      form.value.tour = ''
    }
  }
)

onMounted(fetchTours)

onMounted(() => document.addEventListener('click', handleClickOutside))
onBeforeUnmount(() => document.removeEventListener('click', handleClickOutside))

//cerrar formulario
// const formContainer = ref(null)

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
  document.addEventListener('mousedown', handleClickOutsideForm)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
  document.removeEventListener('mousedown', handleClickOutsideForm)
})
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

.flatpickr-calendar {
  border-radius: 12px !important;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.flatpickr-day.selected {
  background: #2563eb !important;
  border-color: #2563eb !important;
}
</style>

