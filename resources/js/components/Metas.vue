<template>
  <!-- Este componente no muestra nada visual -->
  <div></div>
</template>

<script setup>
import { onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'

const props = defineProps({
  meta: {
    type: Object,
    default: () => ({
      title: 'Default Title | MyTravel',
      description: 'Default description for MyTravel website.',
      image: '/default.jpg'
    })
  }
})

const route = useRoute()

const updateMeta = (meta) => {
  document.title = meta.title || 'MyTravel'

  const setMeta = (name, content, attr = 'name') => {
    let tag = document.querySelector(`meta[${attr}="${name}"]`)
    if (!tag) {
      tag = document.createElement('meta')
      tag.setAttribute(attr, name)
      document.head.appendChild(tag)
    }
    tag.setAttribute('content', content)
  }

  setMeta('description', meta.description)
  setMeta('og:title', meta.title, 'property')
  setMeta('og:description', meta.description, 'property')
  setMeta('og:image', meta.image, 'property')
  setMeta('twitter:title', meta.title, 'name')
  setMeta('twitter:description', meta.description, 'name')
  setMeta('twitter:image', meta.image, 'name')
}

onMounted(() => updateMeta(props.meta))
watch(() => route.fullPath, () => updateMeta(props.meta))

</script>
