<template>
  <div>
    <input
      :type="type"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :placeholder="placeholder"
      class="input"
    />
    <span v-if="error && error.length" class="text-red-500 text-sm">{{ error[0] }}</span>
  </div>
</template>

<script setup>
    defineProps({
    modelValue: String,
    type: { type: String, default: 'text' },
    placeholder: String,
    error: Array
    })
</script>
