<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="relative bg-white rounded-2xl border-2 border-gray-300 shadow-2xl w-full max-w-4xl px-8 py-8">
      <!-- Close button -->
      <button
        class="absolute top-4 right-4 text-2xl text-[#1E71B8] hover:text-[#73BE5D] font-bold"
        @click="$emit('close')"
        aria-label="Close"
      >×</button>
      <h2 class="text-center text-lg font-bold mb-6 text-[#1E71B8]">New Booking Entry</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left: Booking Form -->
        <div>
          <div class="mb-4">
            <label class="block font-semibold mb-1 text-[#1E71B8]">Customer Name</label>
            <input
              v-model="customerName"
              type="text"
              class="w-full rounded-xl border-2 border-[#1E71B8] px-4 py-2 focus:border-[#73BE5D] focus:ring-[#73BE5D] text-[#1E71B8]"
              placeholder="Name"
            />
          </div>
          <div class="mb-4">
            <label class="block font-semibold mb-1">Package Name</label>
              <select
                v-model="selectedPackage"
                :class="[
                  'w-full rounded-xl border-2 border-gray-300 px-4 py-2 focus:border-[#217093] focus:ring-[#217093]',
                  selectedPackage === '' ? 'text-gray-400' : 'text-black'
                ]"
              >
                <option disabled value="">Destination</option>
                <option
                  v-for="pkg in packages"
                  :key="pkg.id"
                  :value="pkg.id"
                  class="text-black"
                >
                  {{ pkg.destinations }}
                </option>
              </select>
          </div>
          <div class="mb-2 font-semibold">Travellers</div>
          <div class="flex items-center mb-4">
            <div class="flex-1">Regular</div>
            <div class="flex-1 text-center">₱{{ selectedPackageData.pax_rate ?? 'XXXX' }}</div>
            <div class="flex-1 flex items-center justify-end gap-2">
              <button class="w-8 h-8 rounded-full bg-gray-200 text-lg font-bold flex items-center justify-center" @click="pax > 1 && pax--">-</button>
              <input type="text" class="w-10 text-center rounded border border-gray-300" :value="pax" readonly />
              <button class="w-8 h-8 rounded-full bg-gray-200 text-lg font-bold flex items-center justify-center" @click="pax++">+</button>
            </div>
          </div>
          <div class="mb-4">
            <label class="block font-semibold mb-1">Upload Discount ID:</label>
            <button class="flex items-center gap-2 bg-[#c6e6f7] text-[#217093] px-4 py-2 rounded-lg font-semibold">
              <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
              </svg>
              Add Image
            </button>
          </div>
          <div class="mb-4">
            <label class="block font-semibold mb-1">Enter voucher code:</label>
            <input
              v-model="voucherCode"
              type="text"
              class="w-full rounded-xl border-2 border-gray-300 px-4 py-2 focus:border-[#217093] focus:ring-[#217093]"
            />
          </div>
        </div>
        <!-- Right: Booking Summary -->
        <div>
          <div class="bg-gray-900 text-white rounded-xl p-6 mb-4 min-h-[270px]">
            <div class="font-semibold mb-2">Tour Name</div>
            <div class="text-sm mb-2">Starting Date: MM/DD/YY</div>
            <div class="mb-2">
              <div class="flex justify-between">
                <span>Regular ₱ {{ selectedPackageData.pax_rate ?? 'XXXX' }}x ({{ pax }})</span>
                <span>₱ {{ selectedPackageData.pax_rate ? selectedPackageData.pax_rate * pax : 'XXXX' }}</span>
              </div>
            </div>
            <div class="flex justify-between font-bold border-t border-gray-600 pt-2 mt-2">
              <span>Total :</span>
              <span>₱ {{ selectedPackageData.pax_rate ? selectedPackageData.pax_rate * pax : 'XXXX' }}</span>
            </div>
          </div>
          <div class="flex justify-center">
            <button @click="submitBooking" class="rounded-xl bg-[#73BE5D] px-8 py-2 text-white font-semibold hover:bg-[#6aae56] transition">
              Confirm
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { api } from '../../../api/api'
import { useToast } from 'vue-toastification'

const emit = defineEmits(['close', 'booking-created']) // ← this line
const toast = useToast();
const service = new api();
const packages = ref([])
const selectedPackage = ref('')
const pax = ref(1)
const customerName = ref('')
const discountId = ref(null)
const voucherCode = ref('')
const totalPrice = computed(() => {
  const rate = selectedPackageData.value.pax_rate
  return rate ? rate * pax.value : 0
})

const selectedPackageData = computed(() => {
  return packages.value.find(pkg => pkg.id === selectedPackage.value) || {}
})

const fetchPackages = async () => {
    try {
        const response = await service.getPackages();
        packages.value = response.data.data
    } catch (error) {
        console.error('Error fetching packages:', error)
    }
}

const submitBooking = async () => {
  try {
    const payload = {
      package_id: selectedPackage.value,
      customer_name: customerName.value,
      discount_id: discountId.value,
      voucher_id: voucherCode.value,
      total_quantity: pax.value,
      total_price: totalPrice.value
    }

    const response = await service.createBooking(payload)
    emit('booking-created')
    toast.success('Booking successfully created!')
  } catch (error) {
    console.error('Error creating booking:', error)
    alert('Failed to create booking.')
  }
}

onMounted(() => {
    fetchPackages()
})
</script>