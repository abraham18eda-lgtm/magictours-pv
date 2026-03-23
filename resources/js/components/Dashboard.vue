<script setup>
import { ref, computed, onMounted, nextTick, watch } from 'vue'
import axios from 'axios'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)

// ========================
// DATOS
// ========================
const items = ref([])
const error = ref(null)
const loading = ref(true)

// ========================
// FILTROS Y PAGINACION
// ========================
const searchQuery = ref('')
const filterDate = ref('')

const currentPage = ref(1)
const pageSize = 10

const showStats = ref(false)
const chartRef = ref(null)
let chartInstance = null

// ========================
// TRAER DATOS
// ========================
onMounted(async () => {
    try {
        const { data } = await axios.get('/api/dashboard')
        items.value = data
    } catch (e) {
        console.error("ERROR API:", e)
        error.value = "No se pudo cargar la información"
    } finally {
        loading.value = false
    }
})

// ========================
// COMPUTED: FILTRADO Y PAGINACION
// ========================
const filteredItems = computed(() => {
    return items.value.filter(item => {
        const matchesSearch = item.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                              item.tour.toLowerCase().includes(searchQuery.value.toLowerCase())
        const matchesDate = filterDate.value ? item.date === filterDate.value : true
        return matchesSearch && matchesDate
    })
})

const totalPages = computed(() => Math.ceil(filteredItems.value.length / pageSize))

const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * pageSize
    return filteredItems.value.slice(start, start + pageSize)
})

// ========================
// ESTADISTICAS
// ========================
const totalAdults = computed(() => filteredItems.value.reduce((sum, i) => sum + i.adults, 0))
const totalChildren = computed(() => filteredItems.value.reduce((sum, i) => sum + i.children, 0))

function createChart() {
    if (!chartRef.value) return

    const tours = [...new Set(filteredItems.value.map(i => i.tour))]
    const adultsPerTour = tours.map(t => filteredItems.value.filter(i => i.tour === t).reduce((sum, i) => sum + i.adults, 0))
    const childrenPerTour = tours.map(t => filteredItems.value.filter(i => i.tour === t).reduce((sum, i) => sum + i.children, 0))

    if (chartInstance) chartInstance.destroy()

    chartInstance = new Chart(chartRef.value, {
        type: 'bar',
        data: {
            labels: tours,
            datasets: [
                { label: 'Adultos', data: adultsPerTour, backgroundColor: 'rgba(54, 162, 235, 0.7)' },
                { label: 'Niños', data: childrenPerTour, backgroundColor: 'rgba(75, 192, 192, 0.7)' }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Adultos y Niños por Tour' },
                legend: { position: 'top' }
            }
        }
    })
}

function createPieChart() {
    const totalsChart = document.getElementById('totalsChart')
    if (!totalsChart) return
    new Chart(totalsChart, {
        type: 'doughnut',
        data: {
            labels: ['Adultos', 'Niños'],
            datasets: [{
                data: [totalAdults.value, totalChildren.value],
                backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(75, 192, 192, 0.7)']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Totales Globales' },
                legend: { position: 'bottom' }
            }
        }
    })
}

// Mostrar modal de estadísticas
function toggleStats() {
    showStats.value = !showStats.value
    nextTick(() => {
        if (showStats.value) {
            createChart()
            createPieChart()
        }
    })
}

// Resetear pagina si cambia filtro o búsqueda
watch([searchQuery, filterDate], () => currentPage.value = 1)

</script>

<template>
  <div class="container mx-auto">
    <div class="text-gray-800 my-20">
        <h1 class="text-3xl font-bold mb-6 text-center">Reservas</h1>

        <!-- Error -->
        <p v-if="error" class="text-red-600 mb-4">{{ error }}</p>

        <!-- Loading -->
        <p v-if="loading" class="text-gray-500">Cargando reservas...</p>

        <!-- Filtros y botón estadísticas -->
        <div v-if="!loading" class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
            <input v-model="searchQuery" type="text" placeholder="Buscar por nombre o tour"
                class="border rounded p-2 w-full md:w-1/3" />
            <input v-model="filterDate" type="date" class="border rounded p-2 w-full md:w-1/4" />
            <button @click="searchQuery=''; filterDate=''" class="bg-gray-200 hover:bg-gray-300 rounded p-2">Limpiar</button>
            <button @click="toggleStats" class="ml-auto bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">
                {{ showStats ? 'Cerrar Estadísticas' : 'Mostrar Estadísticas' }}
            </button>
        </div>

        <!-- Tabla paginada -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4">Nombre</th>
                        <th class="py-2 px-4">Tour</th>
                        <th class="py-2 px-4">Fecha</th>
                        <th class="py-2 px-4">Adultos</th>
                        <th class="py-2 px-4">Niños</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in paginatedItems" :key="item.id" class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">{{ item.name }}</td>
                        <td class="py-2 px-4">{{ item.tour }}</td>
                        <td class="py-2 px-4">
                            {{ item.date.split('-').reverse().join('/') }}
                        </td>
                        <!-- <td class="py-2 px-4">{{ new Date(item.date).toLocaleDateString() }}</td> -->
                        <td class="py-2 px-4">{{ item.adults }}</td>
                        <td class="py-2 px-4">{{ item.children }}</td>
                        <td class="py-2 px-4">{{ item.email }}</td>
                        <td class="py-2 px-4">{{ item.phone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="flex justify-center mt-4 gap-2">
            <button v-for="page in totalPages" :key="page" @click="currentPage = page"
                    :class="['px-3 py-1 rounded', page === currentPage ? 'bg-blue-600 text-white' : 'bg-gray-200']">
                {{ page }}
            </button>
        </div>

        <!-- Overlay estadísticas -->
        <transition name="fade">
            <div v-if="showStats" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
                <div class="bg-white rounded-lg p-6 w-full md:w-3/4 lg:w-1/2 relative shadow-lg overflow-auto max-h-full">
                    <button @click="toggleStats" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 font-bold text-xl">&times;</button>
                    <h2 class="text-2xl font-semibold mb-4">Estadísticas de Reservas</h2>

                    <div class="mb-6">
                        <h3 class="font-semibold mb-2">Totales Globales</h3>
                        <canvas id="totalsChart"></canvas>
                        <p class="mt-2">Adultos: {{ totalAdults }} | Niños: {{ totalChildren }}</p>
                    </div>

                    <div>
                        <h3 class="font-semibold mb-2">Por Tour (Barras)</h3>
                        <canvas ref="chartRef"></canvas>
                    </div>
                </div>
            </div>
        </transition>

    </div>
  </div>
</template>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
