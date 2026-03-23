<template>
  <div class="container mx-auto my-20">
    <div class="text-center">
          <h1 class="text-primary text-center text-3xl font-bold mb-4 py-4 uppercase">{{ tour.title }}</h1>
    </div>
    <!-- <div class="bg-white rounded-lg shadow p-6"> -->
    <div class="bg-white p-6">
    <!-- DESKTOP -->
    <div class="hidden md:grid md:grid-cols-4 gap-6">
      <!-- LEFT TABS -->
      <div class="md:col-span-1">
        <ul class="space-y-2">
          <li v-for="tab in tabs" :key="tab.key">
            <button
              @click="activeTab = tab.key"
              :class="[
                'w-full text-left px-4 py-3 rounded-md font-medium transition',
                activeTab === tab.key
                  ? 'bg-blue-600 text-white'
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
              ]"
            >
             {{ t(`tabs.canopy.${tab.key}`) }}
              <!-- {{ tab.label }} -->
            </button>
          </li>
        </ul>
      </div>

      <!-- RIGHT CONTENT -->
      <div class="md:col-span-3">
        <!-- <TabContent :active-tab="activeTab" /> -->
         <div class="text-gray-600 text-base">
            <div v-if="activeTab === 'description'">
            <p class="text-gray-700 mb-4" v-html="tour.description"></p>
            </div>

            <div v-if="activeTab === 'include'">
                <div class="text-base">
                    <div v-show="open" class="mt-2 text-gray-600 pl-4">
                        <p class="my-2" v-html="tour.info">
                        </p><br />
                    </div>
                </div>
            </div>

            <div v-if="activeTab === 'recommendations'">
                <div class="text-base">
                    <div v-show="open" class="mt-2 text-gray-600 pl-4">
                        <p class="my-2" v-html="tour.recommendations">
                        </p><br />
                    </div>
                </div>
            </div>

            <div v-if="activeTab === 'requirements'">
                <div class="text-base">
                    <div v-show="open" class="mt-2 text-gray-600 pl-4">
                        <p class="my-2" v-html="tour.requirements">
                        </p><br />
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

    <!-- MOBILE -->
    <div class="md:hidden space-y-6">
      <div
        v-for="tab in tabs"
        :key="tab.key"
        class="border rounded-lg p-4"
      >
        <h3 class="text-lg font-semibold mb-2">
          {{ tab.label }}
        </h3>

        <div class="text-gray-600 text-sm">
            <div v-if="activeTab === 'description'">
            <p class="text-gray-700 mb-4" v-html="tour.description"></p>
            </div>

            <div v-if="activeTab === 'include'">
             <div class="text-base">
                    <div v-show="open" class="mt-2 text-gray-600 pl-4">
                        <p class="my-2" v-html="tour.info">
                        </p><br />
                    </div>
                </div>
            </div>

            <div v-if="activeTab === 'recommendations'">
            <div class="text-base">
                    <div v-show="open" class="mt-2 text-gray-600 pl-4">
                        <p class="my-2" v-html="tour.recommendations">
                        </p><br />
                    </div>
                </div>
            </div>

            <div v-if="activeTab === 'requirements'">
                <div class="text-base">
                    <div v-show="open" class="mt-2 text-gray-600 pl-4">
                        <p class="my-2" v-html="tour.requirements">
                        </p><br />
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

  </div>
     <div class="Pickupcard py-24">
        <div class="">
            <h2 class="text-primary text-center text-2xl font-bold mb-4 py-4 uppercase">{{ $t('schedule.title') }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <PickupCard
            v-for="(pickup, index) in pickupPoints"
            :key="index"
            :title="pickup.title"
            :description="pickup.description"
            :schedule="pickup.schedule"
            :map-url="pickup.mapUrl"
            :time="pickup.time"
        />
        </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed  } from 'vue'
import Acordeon from '../components/Accordition.vue'
import PickupCard from '../components/pickupcard.vue'
import { useLocaleStore } from '../stores/locale'

defineProps({
  tour: Object
})

const open = ref(true)
const localeStore = useLocaleStore()
const activeTab = ref('description')

const baseURL = window.location.hostname.includes('localhost')
  ? 'http://localhost:8000'
  : 'https://www.magictourspv.com'

const getImageUrl = (path) => path ? `${baseURL}${path}` : ''
const tabs = [
  { key: 'description' },
  { key: 'include' },
  { key: 'recommendations', },
  { key: 'requirements', },
]

// Helper de traducción
const messages = { en, es }
const t = (path) => {
  return path
    .split('.')
    .reduce((obj, key) => obj?.[key], messages[localeStore.locale]) || path
}

// Importar JSON de idiomas
import en from '../lang/en.json'
import es from '../lang/es.json'

// Supongamos que quieres cambiar según el idioma
// alert('Tour recibido: ' + JSON.stringify(currentLang, null, 2))
// Computed que detecta el idioma actual
const pickupPoints = computed(() => {
  return localeStore.currentLang === 'en' ? es.schedule.card : en.schedule.card
})
</script>

<style scoped>
.canopyriver-template {
  padding: 1rem;
}
.canopyriver-template img {
  max-width: 100%;
  margin: 1rem 0;
}
</style>
