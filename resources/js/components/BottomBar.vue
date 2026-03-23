<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'
import { useBookingFormStore } from '../stores/bookingForm'

const router = useRouter()
const booking = useBookingFormStore()

// Accordion contacto
const contactoOpen = ref(false)
const toggleContacto = () => {
  contactoOpen.value = !contactoOpen.value
}

// Cerrar accordion al click fuera
const handleClickOutside = (event) => {
  const accordion = document.getElementById('contacto-accordion')
  const button = document.getElementById('contacto-button')
  if (accordion && button && !accordion.contains(event.target) && !button.contains(event.target)) {
    contactoOpen.value = false
  }
}

onMounted(() => document.addEventListener('click', handleClickOutside))
onBeforeUnmount(() => document.removeEventListener('click', handleClickOutside))

// Funciones botones
const goToBooking = () => booking.open()
const goToTours = () => router.push('/tours')
</script>

<template>
  <div class="lg:hidden fixed bottom-0 left-0 w-full bg-white border-t-2 border-gray-300 shadow-xl z-50">
    <div class="flex justify-around divide-x divide-gray-300">

      <!-- Contacto -->
      <div class="relative flex-1 flex flex-col items-center">
        <button id="contacto-button" @click="toggleContacto"
                class="relative flex flex-col items-center py-3 w-full text-gray-700 transition-transform duration-150
                hover:text-gray-900 hover:shadow-lg hover:scale-105 bg-gradient-to-t from-white to-white
                overflow-hidden rounded-lg">
          <span class="absolute inset-0 bg-gray-200 opacity-20 rounded-full scale-0 transition-transform duration-500"></span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-brandBlue-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75v-4.5m0 4.5h4.5m-4.5 0 6-6m-3 18c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
          </svg>
          <span class="text-base text-brandBlue-500 uppercase text-primary font-bold">Contacto</span>
        </button>

      <!-- Accordion -->
        <transition name="slide-fade">
        <div v-if="contactoOpen" id="contacto-accordion"
            class="fixed bottom-0 left-0 w-full h-[50vh] bg-gray-50 p-6 shadow-lg z-50 overflow-y-auto text-sm p-10">
            <h3 class="text-2xl text-primary font-bold uppercase my-2 mb-5">{{  $t('bottombar.title') }}</h3>
            <p class="text-base my-2">
                <span class="text-brandBlue-500 font-semibold">{{  $t('bottombar.email') }}</span>
                <a href="mailto:contacto@magictours.com" class="text-gray-700 hover:underline">
                contacto@magictours.com</a>
            </p>
            <p class="text-base my-2"><span class="text-brandBlue-500 font-semibold">{{  $t('bottombar.phone') }}</span> <a href="tel:+529876543210" class="text-gray-700 hover:underline"> +52 n/a</a></p>
            <p class="text-base"><span class="text-brandBlue-500 font-semibold">WhatsApp:</span> <a href="tel:+529876543210" class="text-gray-700 hover:underline"> +52 n/a</a>
            </p>
        </div>
        </transition>
      </div>

      <!-- Reservar -->
      <div class="flex-1 flex flex-col items-center">
        <button @click="goToBooking"
                class="relative flex flex-col items-center py-3 w-full text-gray-700 transition-transform duration-150
                       hover:text-gray-900 hover:shadow-lg hover:scale-105 bg-gradient-to-t from-white to-white
                       overflow-hidden rounded-lg">
          <span class="absolute inset-0 bg-gray-200 opacity-20 rounded-full scale-0 transition-transform duration-500"></span>
           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-brandBlue-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
          </svg>
          <span class="text-base uppercase text-brandBlue-500 font-bold">Reservar</span>
        </button>
      </div>

      <!-- Tours -->
      <div class="flex-1 flex flex-col items-center">
        <button @click="goToTours"
                class="relative flex flex-col items-center py-3 w-full text-gray-700 transition-transform duration-150
                       hover:text-gray-900 hover:shadow-lg hover:scale-105 bg-gradient-to-t from-white to-white
                       overflow-hidden rounded-lg">
          <span class="absolute inset-0 bg-gray-200 opacity-20 rounded-full scale-0 transition-transform duration-500"></span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-brandBlue-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="m6.115 5.19.319 1.913A6 6 0 0 0 8.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 0 0 2.288-4.042 1.087 1.087 0 0 0-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 0 1-.98-.314l-.295-.295a1.125 1.125 0 0 1 0-1.591l.13-.132a1.125 1.125 0 0 1 1.3-.21l.603.302a.809.809 0 0 0 1.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 0 0 1.528-1.732l.146-.292M6.115 5.19A9 9 0 1 0 17.18 4.64M6.115 5.19A8.965 8.965 0 0 1 12 3c1.929 0 3.716.607 5.18 1.64" />
          </svg>
          <span class="text-base uppercase text-brandBlue-500 font-bold">Tours</span>
        </button>
      </div>

    </div>
  </div>
</template>

<style>
/* Accordion animation */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}

/* Ripple effect */
button:active .ripple {
  transform: scale(4);
  opacity: 0;
  transition: transform 0.5s, opacity 0.5s;
}
</style>
