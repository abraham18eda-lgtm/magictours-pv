<template>
  <transition name="fade">
    <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center">
      
      <!-- overlay -->
      <div class="absolute inset-0 bg-black/50" @click="close"></div>

      <!-- modal -->
      <div class="relative bg-white w-full max-w-3xl max-h-[90vh] rounded-2xl shadow-2xl overflow-hidden">
        
        <!-- header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
          <h2 class="font-heading text-xl font-semibold">
            {{ title }}
          </h2>
          <button @click="close" class="text-gray-500 hover:text-black">✕</button>
        </div>

        <!-- content -->
        <div class="p-6 overflow-y-auto text-sm text-gray-600 leading-relaxed space-y-4">
          <slot />
        </div>

      </div>
    </div>
  </transition>
</template>

<script setup>
defineProps({
  open: Boolean,
  title: String
})

const emit = defineEmits(['close'])

const close = () => emit('close')
</script>