<template>
  <!-- Fondo oscuro -->
  <transition name="fade">
    <div
      v-if="modelValue"
      class="fixed inset-0 bg-black/50 z-40"
      @click="$emit('update:modelValue', false)"
    ></div>
  </transition>

  <!-- Offcanvas desde arriba -->
  <transition name="slide-down">
    <div
      v-if="modelValue"
      class="fixed top-0 left-0 w-full bg-white shadow-lg z-50 p-6 max-h-[90vh] overflow-y-auto"
    >
      <slot />
    </div>
  </transition>
</template>

<script setup>
defineProps({
  modelValue: Boolean,
})

defineEmits(["update:modelValue"])
</script>

<style>
.slide-down-enter-from,
.slide-down-leave-to {
  transform: translateY(-100%);
}

.slide-down-enter-to,
.slide-down-leave-from {
  transform: translateY(0);
}

.slide-down-enter-active,
.slide-down-leave-active {
  transition: transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.fade-enter-to,
.fade-leave-from {
  opacity: 1;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
</style>
