<script setup>
const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  message: {
    type: String,
    default: 'Processing your booking...'
  }
})
</script>

<template>
  <div v-if="show" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-xl p-8 shadow-xl max-w-sm w-full mx-4 text-center">
      <!-- Animated Spinner -->
      <div class="flex justify-center mb-4">
        <div class="relative">
          <!-- Outer rotating ring -->
          <div class="w-16 h-16 border-4 border-gray-200 border-t-[#1E71B8] rounded-full animate-spin"></div>
          <!-- Inner pulsing dot -->
          <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <div class="w-3 h-3 bg-[#1E71B8] rounded-full animate-pulse"></div>
          </div>
        </div>
      </div>
      
      <!-- Loading Text -->
      <div class="text-gray-700">
        <h3 class="text-lg font-semibold mb-2">Please wait</h3>
        <p class="text-sm">{{ message }}</p>
      </div>
      
      <!-- Animated dots -->
      <div class="flex justify-center mt-4 space-x-1">
        <div class="w-2 h-2 bg-[#1E71B8] rounded-full animate-bounce" style="animation-delay: 0ms"></div>
        <div class="w-2 h-2 bg-[#1E71B8] rounded-full animate-bounce" style="animation-delay: 150ms"></div>
        <div class="w-2 h-2 bg-[#1E71B8] rounded-full animate-bounce" style="animation-delay: 300ms"></div>
      </div>
    </div>
  </div>
</template>
