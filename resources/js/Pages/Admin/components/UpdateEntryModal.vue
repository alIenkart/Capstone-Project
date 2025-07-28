<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="relative bg-white rounded-2xl border-2 border-gray-300 shadow-2xl w-full max-w-4xl px-8 py-8">
      <button
        class="absolute top-4 right-4 text-2xl text-black hover:text-[#217093] font-bold"
        @click="$emit('close')"
        aria-label="Close"
      >×</button>

      <h2 class="text-center text-lg font-bold mb-6">Booking Details - ID #{{ booking.id }}</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <h3 class="font-bold text-base mb-2">Customer Information</h3>
          <p><strong>Name:</strong> {{ booking.customer_name }}</p>
          <p><strong>Email:</strong> {{ booking.email ?? '—' }}</p>
          <p><strong>Phone:</strong> {{ booking.phone ?? '—' }}</p>

          <h3 class="font-bold text-base mt-6 mb-2">Booking Details</h3>
          <p><strong>Booking Date:</strong> {{ formattedDate }}</p>
          <p><strong>Discount ID:</strong> {{ booking.discount_id ? 'Yes' : 'No' }}</p>
          <p><strong>Package:</strong> {{ booking.package?.name ?? '—' }}</p>
          <p><strong>Duration:</strong> {{ booking.package?.duration ?? '—' }}</p>
          <p><strong>Number of Pax:</strong> {{ booking.total_quantity }}</p>
          <p><strong>Booking Type:</strong> {{ booking.package?.type ?? '—' }}</p>
          <p><strong>Destination:</strong> {{ booking.package?.destinations ?? '—' }}</p>
          <p><strong>Travel Date:</strong> {{ travelDate }}</p>

          <h3 class="font-bold text-base mt-6 mb-2">Price</h3>
          <p><strong>Total Price:</strong> ₱ {{ booking.total_price?.toLocaleString() ?? 'XXXX' }}</p>
          <p><strong>Discounted Price:</strong> ₱ {{ discountedPrice ?? '—' }}</p>
        </div>

        <div>
          <h3 class="font-bold text-base mb-4">Other Details</h3>

          <label class="block font-semibold mb-1">ID Type</label>
          <select v-model="form.id_type" class="w-full rounded-xl border-2 border-gray-300 px-4 py-2">
            <option value="">Select ID</option>
            <option value="Passport">Passport</option>
            <option value="Driver's License">Driver's License</option>
            <option value="National ID">National ID</option>
            <option value="Student ID">Student ID</option>
            <option value="Senior Citizen ID">Senior Citizen ID</option>
          </select>

          <div class="mt-4">
            <p class="font-semibold mb-1">ID Preview:</p>
            <div v-if="booking.discount_id_image" class="w-full h-40 border rounded overflow-hidden">
              <img :src="`/storage/${booking.discount_id_image}`" alt="ID Preview" class="w-full h-full object-contain" />
            </div>
            <p v-else class="text-gray-500">No preview available.</p>
          </div>

          <label class="block font-semibold mt-4 mb-1">Remarks</label>
          <textarea
            v-model="form.remarks"
            rows="4"
            class="w-full rounded-xl border-2 border-gray-300 px-4 py-2"
            placeholder="Enter remarks here..."
          ></textarea>

          <div class="flex justify-end mt-6 gap-4">
            <button
              @click="submitStatus('Approved')"
              class="bg-green-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-green-700"
            >
              Approve
            </button>
            <button
              @click="submitStatus('Rejected')"
              class="bg-red-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-red-700"
            >
              Reject
            </button>
            <button
              @click="$emit('close')"
              class="bg-gray-300 text-gray-800 px-6 py-2 rounded-xl font-semibold hover:bg-gray-400"
            >
              Cancel
            </button>
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
