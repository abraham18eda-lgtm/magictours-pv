<template>
<div class="bg-gradient-to-r from-[#3A8DFF] to-[#00A8E8] p-12 rounded-lg shadow-lg overflow-hidden grid grid-cols-1 lg:grid-cols-2 gap-8 lg:h-[300px]">
  <!-- Texto de la izquierda -->
  <div class="flex flex-col justify-center space-y-4 text-white">
    <h2 class="text-3xl sm:text-4xl font-bold leading-tight">
      {{ $t('ctadventure.questions') }}
    </h2>
    <p class="text-lg sm:text-xl opacity-90">
      {{ $t('ctadventure.answear') }}
    </p>
  </div>
  
  <!-- Columna de Botón (Derecha) -->
  <div class="flex items-center justify-center h-full">
    <button 
        @click="$router.push({ name: 'tour-list', params: { lang: $i18n.locale } })"
        class="px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 transition duration-300 rounded-full">
      {{ $t('ctadventure.cta') }}
    </button>
  </div>
</div>
</template>