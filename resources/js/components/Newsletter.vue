<template>
  <div class="w-full mx-auto">

    <!-- Card -->
    <div class="w-full bg-white shadow-lg border border-gray-100 p-3 lg:p-4 flex justify-center">
      <div class="w-full lg:w-4/5 my-16 lg:my-10">  
        <!-- Header -->
        <div class="mb-3 lg:mb-4 text-center">
            <h3 class="font-heading text-3xl lg:text-2xl font-bold text-primary uppercase">
            {{ $t('footer.newsletter.title') }}
            </h3>
            <p class="text-gray-500 text-base">
            {{ $t('footer.newsletter.description') }}
            </p>
        </div>

        <!-- Form Horizontal -->
        <form
            v-if="!submitted"
            @submit.prevent="submitForm"
            class="flex flex-col lg:flex-row gap-3 items-stretch"
        >
            <!-- Name -->
            <input
            v-model="form.name"
            type="text"
            :placeholder="$t('footer.newsletter.name')"
            class="flex-1 px-4 py-3 rounded-xl border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#00A8E8] focus:border-transparent transition"
            required
            />

            <!-- Email -->
            <input
            v-model="form.email"
            type="email"
            :placeholder="$t('footer.newsletter.email')"
            class="flex-1 px-4 py-3 rounded-xl border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#00A8E8] focus:border-transparent transition"
            required
            />

            <!-- Button -->
            <button
            type="submit"
            class="px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-[#3A8DFF] to-[#00A8E8] hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 whitespace-nowrap"
            >
            {{ $t('footer.newsletter.cta_send') }}
            </button>
        </form>

        <!-- Success -->
        <div
            v-if="submitted"
            class="text-center bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl font-medium mt-3"
        >
            {{ modalMessage }}
        </div>
      </div>    
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'

const form = ref({
  name: '',
  email: '',
})

// const subscribe = () => {
//   alert(
//     `Gracias, ${newsletter.value.name}! Te has suscrito al boletín con el correo ${newsletter.value.email}.`
//   )
//   newsletter.value.name = ''
//   newsletter.value.email = ''
// }
const submitted = ref(false)
const modalMessage = ref('')


const submitForm = async () => {
  try {
    const res = await axios.post('/newsletter', form.value)
     modalMessage.value = res.data.message
     submitted.value = true
  } catch (err) {
    if (err.response && err.response.data.errors) {
       modalMessage.value = Object.values(err.response.data.errors).flat().join('\n')
      alert(errors)
    } else {
       modalMessage.value = 'Ocurrió un error, intenta nuevamente.'
    }
    submitted.value = true
  }
}

</script>