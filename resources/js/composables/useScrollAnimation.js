import { onMounted } from 'vue'

export function useScrollAnimation() {
  onMounted(() => {
    const observer = new IntersectionObserver(
      entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animate-visible')
          }
        })
      },
      { threshold: 0.4 } // se activa cuando 20% del bloque está visible
    )

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
      // inicialmente dejamos invisible
      el.classList.remove('animate-visible')
      observer.observe(el)
    })
  })
}