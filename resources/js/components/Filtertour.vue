<template>
  <div class="container mx-auto">
    <div class="hidden sm:block max-w-10xl mx-auto px-4 py-20">
        <div class="flex justify-center py-10">
            <h2 class="text-h2 text-primary">{{ $t('tours.title')}}</h2>
        </div>
        <!-- Select filtrable -->
        <div class="mb-6 w-full flex justify-end">
            <input
                v-model="search"
                type="text"
                :placeholder="$t('tours.placeholder')"
                class="w-2/5 max-w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
        </div>

        <!-- Contenedor slider / grid -->
        <div
        class="sm:grid sm:grid-cols-2 lg:grid-cols-3 sm:gap-6
            flex overflow-x-auto space-x-4 no-scrollbar p-2"
        style="scroll-snap-type: x mandatory;"
        >
        <div
            v-for="tour in filteredTours"
            :key="tour.id"
            class="relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition
            flex-shrink-0 w-72 sm:w-auto
            scroll-snap-align: start;"
        >
            <!-- Nombre del tour encima, con diseño elegante -->
            <div class=" flex flex-col h-full">
              <div class="relative">
                <img :src="tour.imagen" alt="Imagen del tour" class="w-full min-h-[60vh] h-60 object-cover rounded-t-lg" />
                <div class="absolute bottom-0 w-full text-center">
                    <h3 class="text-white"> {{ tour.name }}</h3>
                 <p class="text-white text-xl font-semibold mb-2">
                    Precio: <span class="text-white">${{ tour.price }}</span>
                 </p>
                </div>
              </div>
              <div class="pt-2 px-4">
               <ul class="flex text-gray-600 justify-center text-sm list-disc pl-2 mb-4 w-full">
                <li v-for="(detail, key) in tour.details.list" :key="key" class="min-w-[80px]">
                    {{ detail }}
                </li>
               </ul>
              </div>
              <hr />
               <div class="p-4 flex justify-between">
                 <button
                    @click="viewDetails(tour)"
                    class="border border-indigo-600 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-50 transition"
                    type="button">
                    Ver más
                  </button>
                  <button
                    @click="openModal(tour)"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition"
                    type="button"
                    >
                    Reservar
                  </button>
              </div>
            </div>
        </div>
        </div>

        <!-- Modal Reservar -->
        <transition name="fade">
        <div
            v-if="showModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div
            class="bg-white rounded-lg max-w-md w-full p-6 relative shadow-lg"
            @click.stop
            >
            <button
                @click="closeModal"
                class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold"
                aria-label="Cerrar"
                type="button"
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
                class="w-full border border-gray-300 rounded-md px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />

                <label class="block mb-2 font-medium" for="email">Email:</label>
                <input
                v-model="reservation.email"
                id="email"
                type="email"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />

                <label class="block mb-2 font-medium" for="date">Fecha:</label>
                <input
                v-model="reservation.date"
                id="date"
                type="date"
                required
                class="w-full border border-gray-300 rounded-md px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import api from '../plugins/axios'
import axios from 'axios';
import { useLocaleStore } from '../stores/locale'

const tours = ref([
  {
    id: 1,
    imagen: 'https://magictourspv.com/storage/images/card/agency/vallarta-adventure/rhythms-of-the-night.webp',
    name: 'Tour a la Playa Paradisíaca',
    price: 120,
    details: {
        list: {
            1: '5 Hours',
            2: 'Couples',
            3: 'Min. 6 years old',
        },
    },
  },
  {
    id: 2,
    name: 'Aventura en la Montaña',
    price: 150,
    details:
      'Excursión guiada por senderos naturales, perfecta para amantes del trekking.',
  },
  {
    id: 3,
    name: 'City Tour Histórico',
    price: 80,
    details:
      'Recorrido por los principales sitios históricos y culturales de la ciudad.',
  },
  {
    id: 4,
    name: 'Safari Fotográfico',
    price: 200,
    details:
      'Explora la fauna local y captura fotos increíbles con guías expertos.',
  },
  {
    id: 5,
    name: 'Tour Gastronómico',
    price: 100,
    details:
      'Prueba los platillos típicos y conoce la cultura culinaria local.',
  },
  {
    id: 6,
    name: 'Navegación al Atardecer',
    price: 110,
    details:
      'Paseo en bote para disfrutar el atardecer en alta mar con cena incluida.',
  },
  {
    id: 7,
    name: 'Tour Cultural y Artesanal',
    price: 90,
    details:
      'Visita talleres y museos para conocer la artesanía y tradiciones locales.',
  },
  {
    id: 8,
    name: 'Excursión a Cascadas',
    price: 130,
    details:
      'Disfruta de un día entre naturaleza y cascadas con opciones de baño.',
  },
  {
    id: 9,
    name: 'Paseo en Globo Aerostático',
    price: 250,
    details:
      'Experiencia única volando sobre paisajes impresionantes al amanecer.',
  },
])

const search = ref('')

const filteredTours = computed(() => {
  if (!search.value.trim()) return tours.value
  const lowerSearch = search.value.toLowerCase()
  return tours.value.filter((tour) =>
    tour.name.toLowerCase().includes(lowerSearch)
  )
})

const showModal = ref(false)
const selectedTour = ref(null)

const reservation = ref({
  name: '',
  email: '',
  date: '',
})

const openModal = (tour) => {
  selectedTour.value = tour
  showModal.value = true
  reservation.value = { name: '', email: '', date: '' }
}

const closeModal = () => {
  showModal.value = false
}

const submitReservation = () => {
  alert(
    `Gracias, ${reservation.value.name}! Tu reserva para "${selectedTour.value.name}" ha sido recibida.`
  )
  closeModal()
}

const viewDetails = (tour) => {
  alert(`Ver más detalles del tour:\n\n${tour.name}\n\n${tour.details}`)
}
</script>

<style>
/* Quitar scrollbar nativo pero que permita scroll */
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

/* fade para modal */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* scroll snap para slider móvil */
[style*='scroll-snap-align'] {
  scroll-snap-align: start;
}
</style>
