<template>
    <TopBar />
    <Header @open-drawer="drawerOpen = true" />
        <div id="app">
            <router-view />
        </div>
        <!-- Offcanvas con Tours -->
        <OffcanvasTop v-model="drawerOpen" class="fixed inset-0 z-50 bg-white flex flex-col">
        <!-- Botón de cerrar -->
        <button
        @click="drawerOpen = false"
        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold"
        >
        &times;
        </button>
        <!-- Header -->
        <div class=" border-b">
            <h2 class="text-primary text-2xl font-bold text-gray-800">{{ t('canvas.title') }}</h2>
        </div>

        <!-- Contenido scrollable -->
        <div class="flex-1 overflow-auto p-4">

        <!-- LOADER -->
        <div v-if="loading" class="text-center py-6 text-gray-500">
        Cargando tours...
        </div>

        <!-- ERROR -->
        <div v-if="errorMessage" class="text-red-600 py-4">
        {{ errorMessage }}
        </div>

        <!-- GRID RESPONSIVO: 7 tours + botón como tarjeta 8 -->
        <div
        v-if="!loading && tours.length > 0"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
        >
        <!-- Mostrar hasta 7 tours -->
        <div
            v-for="tour in tours.slice(0,7)"
            :key="tour.id"
            class="relative bg-white rounded-lg overflow-hidden shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl w-full"
        >
            <img
            :src="getImageUrl(tour.image)"
            alt="Imagen del tour"
            class="w-full h-[180px] object-cover"
            />

            <!-- Overlay -->
            <div
            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center text-white p-4"
            >
            <h3 class="text-lg font-semibold text-center">{{ tour.title }}</h3>
            <button
                @click="goToTour(tour.slug)"
                class="mt-2 px-3 py-1 bg-indigo-600 hover:bg-indigo-700 rounded text-white text-sm font-semibold"
            >
                {{ $t('cta.view_tours') }}
            </button>
            </div>
        </div>

        <!-- BOTÓN “VER TODOS LOS TOURS” como TARJETA 8 con sombreado y solo el botón clickeable -->
        <div
            class="flex items-center justify-center bg-indigo-100/20 rounded-lg w-full h-40 shadow-sm"
        >
            <button
            @click="goToAllTours"
            class="px-6 py-3 bg-indigo-600/80 rounded-md text-white font-semibold shadow"
            >
            {{ $t('cta.all_tour') }}
            </button>
        </div>

        </div>

        <!-- VACÍO -->
        <div
        v-if="!loading && tours.length === 0 && !errorMessage"
        class="text-gray-500 text-center py-6"
        >
        No hay tours disponibles.
        </div>

    </div>
    </OffcanvasTop>
    <BookingFormModal />
    <slot />
    <Whatsapp />
    <BottomBar />
    <SliderBottom />
    <Footer />
    <Tawk />
</template>

<script setup>
    import { ref, watch  } from 'vue'
    import Header from '../components/Header.vue';
    import TopBar from '@/components/TopBar.vue';
    import Footer from '../components/Footer.vue';
    import Whatsapp from '../components/Whatsapp.vue';
    import Tawk from '../components/Tawk.vue';
    import BottomBar from '../components/BottomBar.vue';
    import OffcanvasTop from '../components/OffcanvasTop.vue'
    import BookingFormModal from '../components/BookingFormModal.vue'
    import { useRoute, useRouter } from 'vue-router'
    import { useLocaleStore } from '../stores/locale'
    import { setLang, t } from '../lang'
    import { useI18n } from 'vue-i18n'
    import api from '../plugins/axios'

    const drawerOpen = ref(false)
    const tours = ref([])
    const loading = ref(false)
    const errorMessage = ref(null)
    const route = useRoute()
    const router = useRouter()

    // const { locale } = useI18n()
    // const getLang = () => route.params.lang || locale.value
    // SINCRONIZAR I18N CON PINIA
    const localeStore = useLocaleStore()
    const { locale } = useI18n()

    watch(
    () => localeStore.locale,
    (newLang) => {
        locale.value = newLang     // <- actualiza i18n
    },
    { immediate: true }
    )
    const getLang = () => localeStore.locale

    // Detectar base URL según entorno
    const getImageUrl = (path) => {
    const isLocal = window.location.hostname.includes('localhost')
    const baseURL = isLocal ? 'http://localhost:8000' : 'https://www.magictourspv.com'

    if (!path) {
        // fallback en public
        return '/images/tours/default-tour.jpg'
    }

    // Limpiamos la ruta, evitando doble /storage
    const cleanedPath = path.startsWith('/storage') ? path : `/storage${path}`

    return `${baseURL}${cleanedPath}`.replace(/([^:]\/)\/+/g, '$1')
    }




    // Cargar tours solo al abrir el offcanvas
    const fetchTours = async () => {
    loading.value = true
    errorMessage.value = null
    try {
        const res = await api.get("/api/tours")
        tours.value = res.data
    } catch (err) {
        console.error(err)
        tours.value = []
        errorMessage.value = "No se pudieron cargar los tours."
    } finally {
        loading.value = false
    }
    }

    watch(drawerOpen, (open) => {
    if (open && tours.value.length === 0) {
        fetchTours()
    }
    })

    // const getLang = () => {
    //     return window.location.pathname.split('/')[1] || 'es'
    // }
    // Redirigir al tour usando slug
    // const goToTour = (slug) => {
    // drawerOpen.value = false
    // router.push(`/${lang}/tours/${slug}`)
    // }
    const goToTour = (slug) => {
        drawerOpen.value = false
        const lang = getLang()
        router.push(`/${lang}/tours/${slug}`)
    }

    // const goToAllTours = () => {
    //     drawerOpen.value = false
    //     router.push(`/tours`)
    // }
    const goToAllTours = () => {
        drawerOpen.value = false
        const lang = getLang()
        router.push(`/${lang}/tours`)
    }

</script>

<style scoped>
/* Animación para el transition-group */
.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(20px);
}
.fade-slide-enter-to {
  opacity: 1;
  transform: translateY(0);
}
.fade-slide-enter-active {
  transition: all 0.3s ease;
}
.fade-slide-leave-from {
  opacity: 1;
}
.fade-slide-leave-to {
  opacity: 0;
}
.fade-slide-leave-active {
  transition: all 0.2s ease;
}
</style>
