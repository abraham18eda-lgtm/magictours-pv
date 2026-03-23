<template>
  <div class="accordion my-2">
    <div class="w-full mx-auto space-y-2">
      <details
        v-for="(section, index) in data"
        :key="index"
        class="group border rounded-lg"
      >
        <summary class="flex items-center justify-between p-4 cursor-pointer">
          <span class="font-semibold text-gray-800 uppercase">
            {{ section.title }}
          </span>
          <svg
            class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 9l-7 7-7-7"
            />
          </svg>
        </summary>

        <div class="p-4 border-t text-gray-600 space-y-3">
          <p v-if="section.description" class="text-gray-800 text-lg leading-relaxed">
            {{ section.description }}
          </p>

          <ul v-if="section.items && section.items.length" class="list-disc pl-6 text-gray-800 text-lg">
            <li v-for="(item, i) in section.items" :key="i" class="my-2">
              {{ item }}
            </li>
          </ul>

          <div v-if="section.texto && section.texto.length" class="pl-4 text-gray-800 text-lg leading-relaxed space-y-3">
            <p v-for="(p, i) in section.texto" :key="i" v-html="p"></p>
          </div>
        </div>
      </details>

      <p v-if="!data.length" class="text-gray-500 text-center italic">
        No hay información disponible.
      </p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  data: {
    type: Array,
    default: () => []
  }
})
</script>
