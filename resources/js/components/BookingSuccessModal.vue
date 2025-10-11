<script setup>
const props = defineProps({
  show: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['close', 'returnHome'])

function closeModal() {
  emit('close')
}

function returnHome() {
  emit('returnHome')
}
</script>

<template>
  <div v-if="show" class="fixed inset-0 z-[9999] overflow-y-auto">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    
    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
      <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full overflow-hidden">
        <!-- Header -->
        <div class="bg-[#1E71B8] text-white px-6 py-4 text-center">
          <div class="flex justify-center mb-2">
            <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <h2 class="text-xl font-bold">Booking Successful!</h2>
        </div>
        
        <!-- Content -->
        <div class="p-6 text-center">
          <div class="mb-4">
            <p class="text-gray-700 text-lg mb-2">Thank you for booking with JE Travel & Tours!</p>
            <p class="text-gray-600 mb-4">Please wait for the confirmation of your booking.</p>
            <p class="text-gray-600 text-sm">
              For more inquiries, contact us at 
              <a href="mailto:contactus@jetravelandtours.com" class="text-[#1E71B8] underline hover:text-[#008DDA]">
                contactus@jetravelandtours.com
              </a>
            </p>
          </div>
        </div>
        
        <!-- Footer -->
        <div class="px-6 py-4 flex justify-center gap-3">
          <button 
            @click="returnHome"
            class="bg-[#1E71B8] hover:bg-[#008DDA] text-white px-6 py-2 rounded-lg font-semibold transition-colors"
          >
            Return Home
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
