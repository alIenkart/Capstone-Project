<template>
  <div v-if="booking" class="fixed inset-0 z-50 overflow-y-auto">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="$emit('close')"></div>

    <!-- Modal panel -->
    <div class="flex min-h-full items-center justify-center p-4">
      <div class="relative transform overflow-hidden rounded-2xl border-2 border-gray-300 bg-white px-6 py-6 text-left shadow-2xl transition-all sm:my-8 w-full max-w-4xl">
        <!-- Close button -->
        <div class="absolute right-0 top-0 pr-4 pt-4">
          <button
            type="button"
            class="rounded-full bg-white text-[#1E71B8] hover:text-[#73BE5D] focus:outline-none"
            @click="$emit('close')"
          >
            <span class="sr-only">Close</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Modal content -->
        <div>
          <div class="text-center sm:text-left w-full">
            <h3 class="text-xl font-semibold leading-6 text-[#1E71B8] mb-6">
              Booking Details - ID #{{ booking.id }}
            </h3>

            <div class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Information -->
                <div class="space-y-4">
                  <div class="border-2 border-[#1E71B8] rounded-xl p-4 bg-white">
                    <h4 class="text-lg font-semibold text-[#1E71B8] mb-3">Customer Information</h4>
                    <div class="space-y-2">
                      <p><span class="font-medium text-[#1E71B8]">Name:</span> {{ booking.customer_name }}</p>
                      <p><span class="font-medium text-[#1E71B8]">Email:</span> {{ booking.customer_email ?? '—' }}</p>
                      <p><span class="font-medium text-[#1E71B8]">Phone:</span> {{ booking.customer_phone ?? '—' }}</p>
                    </div>
                  </div>

                  <div class="border-2 border-[#1E71B8] rounded-xl p-4 bg-white">
                    <h4 class="text-lg font-semibold text-[#1E71B8] mb-3">Booking Details</h4>
                    <div class="space-y-2">
                      <p><span class="font-medium text-[#1E71B8]">Booking Date:</span> {{ formattedDate }}</p>
                      <p><span class="font-medium text-[#1E71B8]">Discount ID:</span> {{ discountImages.length > 0 ? `${discountImages.length} image(s)` : 'No' }}</p>
                      <p><span class="font-medium text-[#1E71B8]">Package:</span> {{ booking.package_destination ?? '—' }}</p>
                      <p><span class="font-medium text-[#1E71B8]">Duration:</span> {{ booking.duration ?? '—' }} Day/s</p>
                      <p><span class="font-medium text-[#1E71B8]">Number of Pax:</span> {{ booking.total_quantity }}</p>
                      <p><span class="font-medium text-[#1E71B8]">Booking Type:</span> {{ booking.tour_type ?? '—' }}</p>
                      <p><span class="font-medium text-[#1E71B8]">Destination:</span> {{ booking.package_destination ?? '—' }}</p>
                      <p><span class="font-medium text-[#1E71B8]">Travel Date:</span> {{ travelDate }}</p>
                    </div>
                  </div>
                </div>

                <!-- ID Preview and Actions -->
                <div class="space-y-4">
                  <div class="border-2 border-[#1E71B8] rounded-xl p-4 bg-white">
                    <h4 class="text-lg font-semibold text-[#1E71B8] mb-3">ID Preview</h4>
                    <div v-if="discountImages.length > 0" class="grid grid-cols-2 gap-2">
                      <div 
                        v-for="(image, index) in discountImages" 
                        :key="index"
                        class="w-full h-40 border-2 border-[#1E71B8] rounded-xl overflow-hidden bg-white"
                      >
                        <img 
                          :src="`/storage/${image}`" 
                          :alt="`ID Preview ${index + 1}`" 
                          class="w-full h-full object-contain" 
                        />
                      </div>
                    </div>
                    <p v-else class="text-gray-500 italic">No preview available.</p>
                  </div>

                  <div class="border-2 border-[#1E71B8] rounded-xl p-4 bg-white">
                    <label class="block text-sm font-medium text-[#1E71B8] mb-2">Remarks</label>
                    <textarea
                      v-model="form.remarks"
                      rows="4"
                      class="w-full rounded-xl border-2 border-[#1E71B8] focus:border-[#73BE5D] focus:ring-[#73BE5D] sm:text-sm resize-none"
                      placeholder="Enter remarks here..."
                    ></textarea>
                  </div>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex justify-end gap-x-4">
                <button
                  type="button"
                  class="rounded-xl px-6 py-2 text-sm font-semibold leading-6 text-[#1E71B8] hover:bg-[#1E71B8] hover:text-white transition-colors"
                  @click="$emit('close')"
                >
                  Cancel
                </button>
                <button
                  type="button"
                  @click="submitStatus('Rejected')"
                  class="rounded-xl bg-red-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                >
                  Reject
                </button>
                <button
                  type="button"
                  @click="submitStatus('Approved')"
                  class="rounded-xl bg-[#73BE5D] px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#6aae56] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#73BE5D]"
                >
                  Approve
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { api } from '@/api/api'
import { useToast } from 'vue-toastification'

const toast = useToast();
const props = defineProps({ booking: Object })
const emit = defineEmits(['close', 'booking-updated'])
const service = new api()

const form = ref({
  id_type: props.booking.id_type ?? '',
  remarks: props.booking.remarks ?? ''
})

const formattedDate = computed(() => {
  const date = new Date(props.booking.created_at)
  return date.toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric'
  })
})

const travelDate = computed(() => {
  const date = new Date(props.booking.travel_date ?? '')
  return isNaN(date) ? '—' : date.toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric'
  })
})

const discountedPrice = computed(() => {
  if (!props.booking.total_price || !props.booking.discount_rate) return null
  const discount = props.booking.total_price * (props.booking.discount_rate / 100)
  return (props.booking.total_price - discount).toFixed(2)
})

const discountImages = computed(() => {
  if (!props.booking.discount_images) return []
  
  // Handle both string and array formats
  if (typeof props.booking.discount_images === 'string') {
    try {
      // Try to parse as JSON array
      const parsed = JSON.parse(props.booking.discount_images)
      return Array.isArray(parsed) ? parsed : [props.booking.discount_images]
    } catch {
      // If not JSON, treat as single string
      return [props.booking.discount_images]
    }
  }
  
  // If already an array, return it (max 3 images)
  return Array.isArray(props.booking.discount_images) 
    ? props.booking.discount_images.slice(0, 3) 
    : []
})

const submitStatus = async (statusValue) => {
  try {
    await service.updateBooking(props.booking.id, {
      status: statusValue,
      id_type: form.value.id_type,
      remarks: form.value.remarks
    })
    toast.success(`Booking ${statusValue}!`)
    emit('booking-updated')
    emit('close')
  } catch (error) {
    console.error('Error updating booking:', error)
    alert('Failed to update booking.')
  }
}
</script>
