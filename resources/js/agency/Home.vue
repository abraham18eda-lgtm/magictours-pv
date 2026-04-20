<template>
    <Carousel />
    <div class="main">
        <div class="description w-full text-center py-20 px-4 md:px-0">
            <div class="md:container md:mx-auto md:w-6/7">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                     <div class="order-2 lg:order-1 animate-on-scroll animate-slideInLeft">
                        <img
                            :src='description'
                            class="w-full lg:h-full object-cover rounded-xl shodow-lg transition-transform duration-300 hover:scale-105"
                            alt="home-imagen"
                        />
                    </div>
                    <div class="order-1 lg:order-2 animate-on-scroll animate-slideInRight lg:m-2">
                    <h1 class="font-heading text-4xl text-primary font-bold mb-5">{{ $t('bloque_1.title') }}</h1>
                    <p class="text-xl md:text-base text-justify lg:text-start sm:text-lg md:text-lg" v-html="$t('bloque_1.description')"></p>
                    </div>
                </div>
                <!-- <div class="flex justify-between items-center text-black">
                    <div>
                        123
                    </div>
                    <div>
                    <h3 class="text-h1  text-primary font-bold mb-8">{{ $t('bloque_1.title') }}</h3>
                    <p class="lg:w-3/5 text-base text-justify lg:text-center sm:text-lg md:text-4xl lg:text-base" v-html="$t('bloque_1.description')"></p>
                    </div>
                </div> -->
            </div>
        </div>
        
        <div class="services bg-gradient-to-r from-[#3A8DFF] to-[#00A8E8] py-16">
            <div class="container mx-auto w-4/5 text-center">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white 
                drop-shadow-2xl mb-12">{{ $t('services.title')}}</h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Tarjeta 1 -->
                    <div class="min-h-[200px] bg-white rounded-xl p-6 flex flex-col items-center justify-center
                                shadow-lg hover:shadow-2xl transition-all duration-300 
                                transform hover:-translate-y-2 hover:rotate-1 
                                active:-translate-y-4 active:rotate-2 cursor-pointer">
                        <img src="https://es.magictourspv.com/storage/icons/quality-service.png"
                            class="w-14 filter" 
                            style="filter: invert(31%) sepia(98%) saturate(3716%) hue-rotate(197deg) brightness(97%) contrast(92%);"
                            alt="" />
                        <span class="text-primary text-xl md:text-xl ">{{ $t('services.list.1')}}</span>
                    </div>

                    <!-- Tarjeta 2 -->
                    <div class="min-h-[200px] bg-white rounded-xl p-6 flex flex-col items-center justify-center
                                shadow-lg hover:shadow-2xl transition-all duration-300 
                                transform hover:-translate-y-2 hover:rotate-1 
                                active:-translate-y-4 active:rotate-2 cursor-pointer">
                        <img src="https://magictourspv.com/storage/icons/professional-team.png"
                            class="w-14 filter" 
                            style="filter: invert(31%) sepia(98%) saturate(3716%) hue-rotate(197deg) brightness(97%) contrast(92%);"
                            alt="" />
                        <span class="text-primary text-xl md:text-xl">{{ $t('services.list.2')}}</span>
                    </div>

                    <!-- Tarjeta 3 -->
                    <div class="min-h-[200px] bg-white rounded-xl p-6 md:p-8 flex flex-col items-center  justify-center
                                shadow-lg hover:shadow-2xl transition-all duration-300 
                                transform hover:-translate-y-2 hover:rotate-1 
                                active:-translate-y-4 active:rotate-2 cursor-pointer">
                        <img src="https://magictourspv.com/storage/icons/top-tier.png"
                            class="w-14 filter" 
                            style="filter: invert(31%) sepia(98%) saturate(3716%) hue-rotate(197deg) brightness(97%) contrast(92%);"
                            alt="" />
                        <span class="text-primary text-xl md:text-xl">{{ $t('services.list.3')}}</span>
                    </div>

                </div>
            </div>
        </div>
        <!-- <div class="services bg-gradient-to-r from-[#3A8DFF] to-[#00A8E8]">
            <div class="description w-full text-center py-10">
                <div class="container mx-auto w-4/5">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 py-10 lg:py:0">
                        <div class="flex flex-col  items-center my-4 lg:my-0">
                            <img src="https://es.magictourspv.com/storage/icons/quality-service.png"
                            class="w-[80px] lg:w-[80px] white-icon object-cover"
                            alt="" />
                            <span class="min-[20px] max-w-2xl text-base sm:text-lg md:text-4xl lg:text-base text-white">{{ $t('services.list.1')}}</span>
                        </div>
                        <div class="flex flex-col items-center my-4 lg:my-0">
                            <img src="https://magictourspv.com/storage/icons/professional-team.png"
                            class="w-[80px] lg:w-[80px] white-icon  object-cover"
                            alt="" />
                            <span class="min-[40px] max-w-2xl text-base sm:text-lg md:text-4xl lg:text-base text-white">{{ $t('services.list.2')}}</span>
                        </div>
                        <div class="flex flex-col items-center my-4 lg:my-0">
                             <img src="https://magictourspv.com/storage/icons/top-tier.png"
                            class="w-[80px] lg:w-[80px] white-icon  object-cover"
                            alt="" />
                            <span class="max-w-2xl text-base sm:text-lg md:text-4xl lg:text-base text-white">{{ $t('services.list.3')}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
         <TourList :tours="tours" />

        <!-- cta-->
        <div class="py-10">
            <ctadventure />
        </div>
        <!-- Fin cta-->

        <!-- <TourList /> -->
        <div class="SlideBottom">
            <div class="container mx-auto lg:w-3/4 py-10">
                <h3 class="font-heading text-4xl text-primary font-bold mb-5 text-start md:text-center ">{{ $t('slideBottom.title') }}</h3>
                <p class="text-base text-start lg:text-center sm:text-lg md:text-base lg:text-lg"  v-html="$t('slideBottom.description')"></p>
            </div>
            <div class="px-4 md:px-12">
                <ElegantSlider :items="ESlider" />
            </div>
        </div>

        <!-- Newsletter -->
         <div class="">
            <Newsletter />
         </div>
    </div>
</template>

<script setup>
    import { useRoute } from 'vue-router'
    import { ref, onMounted, watch } from 'vue'
    import { useLocaleStore } from '../stores/locale'
    import { setLang, t } from '../lang'
    import { updateMeta } from '../meta';
    // Aquí puedes agregar tu lógica con Composition API
    import Carousel from '../components/Carousel.vue';
    import { useScrollAnimation } from '../composables/useScrollAnimation';
    // import Filtertour from '../components/Filtertour.vue';
    // import Tourslider from '../components/Tourslider.vue';
    import Booktourform from '../components/Booktourform.vue';
    import TourList from '../components/TourList.vue';
    import api from '../plugins/axios'
    import axios from 'axios';
    // import Metas from '../components/Metas.vue'
    import ElegantSlider from "../components/ElegantSlider.vue" 
    import ctadventure from '../components/ctadventure.vue';
    import Newsletter from '../components/Newsletter.vue';

    // Elegante Slider
    const ESlider = [
        { image: "/storage/images/slider/car-tours-aventure.webp", title: "Proyecto 1", description: "Landing" },
        { image: "/storage/images/slider/horse-tours-aventure.webp", title: "Proyecto 2", description: "UX/UI" },
        { image: "/storage/images/slider/colomitos-tourspv.webp", title: "Proyecto 3", description: "Sistema" },
        { image: "/storage/images/slider/las-caletas-tourspv.webp", title: "Proyecto 4", description: "E-commerce" },
        { image: "/storage/images/slider/ecoturismo-tourspv.webp", title: "Proyecto 4", description: "E-commerce" },
        { image: "/storage/images/slider/majahuitas-tourspv.webp", title: "Proyecto 5", description: "Dashboard" },
        { image: "/storage/images/slider/los-arcos-de-mismaloya-paddle-tours.webp", title: "Proyecto 6", description: "App móvil" },
        { image: "/storage/images/slider/raft-tours-aventure.webp", title: "Proyecto 7", description: "SaaS" },
    ]
    // Fin Elegante Slider

    const description = '/storage/images/home/description-magictourspv-home.webp'
    // const tours = ref([])
    // const loading = ref(true)
    // const localeStore = useLocaleStore()
    
    const localeStore = useLocaleStore()
    const tours = ref([])
    const loading = ref(true)
    //Rutas
    const route = useRoute()

    // uso de las animaciones
       useScrollAnimation()
    // fin de las animaciones

    // Meta reactiva: escucha cambios de ruta
    watch(route, (to) => {
    updateMeta(to)
    }, { immediate: true })

    const fetchTours = async () => {
        loading.value = true
        try {
            // const res = await api.get(`api/tours?lang=${localeStore.locale}`)
            const res = await api.get(`https://www.magictourspv.com/api/tours?lang=${localeStore.locale}`)
            tours.value = res.data
            // alert('Tour recibido: ' + JSON.stringify(tours.value, null, 2))
        } catch (error) {
            console.error('Error al cargar tours:', error)
        } finally {
            loading.value = false
        }
    }


    const changeLang = () => {
        fetchTours()
    }
    // Cambio de idioma
    function changeLang2(lang) {
        setLang(lang)
        updateMeta(route) // actualiza metas al cambiar idioma
    }

    onMounted(fetchTours)
</script>

<style scoped>
/* Estilos globales o específicos para este componente */
    .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    }

    .animate-on-scroll {
        opacity: 0;
    }

    .animate-on-scroll.animate-visible {
        opacity: 1;
    }
    .white-icon {
        filter: invert(100%) brightness(200%);
    }
</style>
