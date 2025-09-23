<script setup>
import LandingIndex from './LandingIndex.vue'
import { storeBooking } from '../../state/storeBooking'
import { computed, ref, onMounted, onBeforeUnmount, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { api } from '../../api/api';
defineOptions({ layout: LandingIndex })

const service = new api();
const emit = defineEmits(['next', 'back'])
const page = usePage();
const booking = storeBooking()
const id = computed(() => page.props.id);
const selectedPackage = ref({});
const pax = ref(1);
const kidsPax = ref(1);

// Duration in days based on booking dates (inclusive)
const durationDays = computed(() => {
  const start = booking.startDate
  const end = booking.endDate
  if (!start || !end) return 0
  // Parse YYYY-MM-DD safely in UTC to avoid timezone shifts
  const [sy, sm, sd] = String(start).split('-').map(Number)
  const [ey, em, ed] = String(end).split('-').map(Number)
  const startDateUtc = Date.UTC(sy, (sm || 1) - 1, sd || 1)
  const endDateUtc = Date.UTC(ey, (em || 1) - 1, ed || 1)
  const diffMs = endDateUtc - startDateUtc
  const days = Math.floor(diffMs / (1000 * 60 * 60 * 24)) + 1 // inclusive
  return days > 0 ? days : 0
})


const adultTotalAmount = computed(() => {
  const amount = selectedPackage.value.pax_rate || 0
  return amount * pax.value
})

const kidsTotalAmount = computed(() => {
  const amount = selectedPackage.value.kids_pax_rate || 0
  return amount * kidsPax.value
})

// Subtotal (Adults + Kids)
const totalAmount = computed(() => {
  return adultTotalAmount.value + kidsTotalAmount.value
})

// Apply a 20% discount (temporary static until discount logic is wired)
const discountRate = 0.20
const totalAmountWithDiscount = computed(() => {
  const subtotal = totalAmount.value
  const discountAmount = subtotal * discountRate
  return subtotal - discountAmount
})


function postPackage() {
  booking.setPackageId(id.value)
  booking.setAdultsQuantity(pax.value)
  booking.setKidsQuantity(kidsPax.value)
  booking.setAmount(totalAmount.value)
  booking.setTotalAmountWithDiscount(totalAmountWithDiscount.value)
  booking.setPackageDestination(selectedPackage.value.destination)
  booking.setDuration(durationDays.value)
  booking.setAdultRate(selectedPackage.value.pax_rate || 0)
  booking.setKidsRate(selectedPackage.value.kids_pax_rate || 0)
  booking.setAdultTotalAmount(adultTotalAmount.value)
  booking.setKidsTotalAmount(kidsTotalAmount.value)
  emit('next')
}

const fetchSelectedPackage = async () => {
  try {
    const response = await service.getPackage(id.value);
    selectedPackage.value = response.data.data;
  } catch (error) {
    console.error('Error fetching selectedPackage:', error);
  }
};

onMounted(() => {
  fetchSelectedPackage();
});

</script>
<template>
  <div class="w-full min-h-screen flex flex-col items-center bg-[#fcfcfc] py-8">
    <!-- Stepper at the top -->
    <div class="flex items-center gap-2 mb-16 mt-2 w-full max-w-5xl justify-center">
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] bg-[#008DDA] flex items-center justify-center">
          <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base">Availability</span>
      </div>
      <span class="w-16 h-0.5 bg-[#008DDA] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] flex items-center justify-center">
          <span class="w-2 h-2 rounded-full bg-[#008DDA]"></span>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base border-b-2 border-[#008DDA] pb-0.5">Reservation Details</span>
      </div>
      <span class="w-16 h-0.5 bg-[#008DDA] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] flex items-center justify-center"></span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base">Confirmation</span>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-row w-full max-w-6xl justify-center gap-8">
      <!-- Left Side: Package Selection -->
      <div class="flex-1">
        <div class="flex justify-start mb-4">
          <button @click="emit('back')" class="w-24 rounded-full py-2 font-bold text-lg transition bg-[#1E71B8] text-white hover:bg-[#73BE5D]">
            Back
          </button>
        </div>
        <div class="flex w-full mb-2">
          <div class="flex-1 font-semibold text-[#1E71B8]">Travellers</div>
          <div class="flex-1 font-semibold text-[#1E71B8] text-center">Rate</div>
          <div class="flex-1 font-semibold text-[#1E71B8] text-right">Quantity</div>
        </div>
        <p class="message">*Age around 13 and above</p>
        <div class="w-full flex items-center bg-[#1E71B8] rounded-xl px-6 py-5 mb-6">
          <div class="flex-1 text-white font-medium text-lg">Adults</div>
          <div class="flex-1 text-white font-medium text-lg text-center">₱ {{ selectedPackage.pax_rate }}</div>
          <div class="flex-1 flex items-center justify-end gap-2">
            <button @click="pax > 1 && pax--" class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">-</button>
            <input type="text" :value="pax" class="w-14 h-8 rounded-lg text-center border border-[#1E71B8] bg-white text-[#1E71B8] font-semibold" readonly>
            <button @click="pax++" class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">+</button>
          </div>
        </div>
        <p class="message">*Age around 2-12</p>
        <div class="w-full flex items-center bg-[#1E71B8] rounded-xl px-6 py-5 mb-6">
          <div class="flex-1 text-white font-medium text-lg">Kids</div>
          <div class="flex-1 text-white font-medium text-lg text-center">₱ {{ selectedPackage.kids_pax_rate }}</div>
          <div class="flex-1 flex items-center justify-end gap-2">
            <button @click="kidsPax > 1 && kidsPax--" class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">-</button>
            <input type="text" :value="kidsPax" class="w-14 h-8 rounded-lg text-center border border-[#1E71B8] bg-white text-[#1E71B8] font-semibold" readonly>
            <button @click="kidsPax++" class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">+</button>
          </div>
        </div>

        <!-- Itinerary Section -->
        <div class="mt-8">
          <div class="flex w-full mb-2">
            <div class="flex-1 font-semibold text-[#1E71B8]">Itinerary</div>
          </div>
          <pre
            class="w-full rounded-xl border border-[#000000] bg-white text-[#000000] p-4 whitespace-pre-wrap"
          >{{ selectedPackage.itinerary }}</pre>
        </div>
      </div>
      <!-- Right Side: Summary Card -->
      <div class="w-full max-w-sm bg-[#1E71B8] rounded-xl p-8 flex flex-col justify-between min-h-[350px]">
        <div>
          <div class="font-bold text-white text-lg mb-2">{{selectedPackage.destination}}</div>
          <div class="text-white mb-4">
            <div>Tour Type: <span class="text-white">{{ booking.tourType }}</span></div>
          </div>
          <div class="text-white mb-4">
            <div>Duration: <span class="text-white">{{ durationDays }} Day<span v-if="durationDays !== 1">s</span></span></div>
          </div>
          <div class="text-white mb-4">
            <div>Starting Date: <span class="text-white">{{ booking.startDate }}</span></div>
          </div>
          <div class="text-white mb-4">
            <div class="mb-1">Travellers</div>
            <div class="flex justify-between">
              <span>Adult Rate ₱ {{ selectedPackage.pax_rate }} x ({{ pax }})</span>
              <span>₱ {{ adultTotalAmount }}</span>
            </div>
            <div class="flex justify-between">
              <span>Kids Rate ₱ {{ selectedPackage.kids_pax_rate }} x ({{ kidsPax }})</span>
              <span>₱ {{ kidsTotalAmount }}</span>
            </div>
            <div class="flex justify-between">
              <span>Discount ID</span>
              <span>- 20%</span>
            </div>
          </div>
          <hr class="border-[#73BE5D] my-4" />
          <div class="flex justify-between items-center font-bold text-white text-lg mt-4">
            <span>Total :</span>
              <span>₱ {{ totalAmountWithDiscount }}</span>
          </div>
        </div>
        <button @click=postPackage class="w-full rounded-full py-3 font-bold text-lg transition bg-[#73BE5D] text-white hover:bg-[#6aae56] mt-2">
          Proceed
        </button>
      </div>
    </div>
  </div>
</template>

<style>
.message {
  color: #6B7899;
  font-size: 0.8rem;
}
</style>