<script setup>
import LandingIndex from './LandingIndex.vue'
import { api } from '../../api/api'
import { usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue'
import { storeBooking } from '../../state/storeBooking'
import { useToast } from 'vue-toastification'

defineOptions({ layout: LandingIndex })

const emit = defineEmits(['back'])
const service = new api();
const page = usePage();
const user = computed(() => page.props.auth?.user);
const booking = storeBooking()
const toast = useToast();
const first_name = ref('')
const last_name = ref('')
const email = ref('')
const phone_number = ref('')
const address  = ref('')

// Retrieve discountIdImage and selectedIdType from store
const discountIdImage = computed(() => booking.$state.discountIdImage)
const selectedIdType = computed(() => booking.$state.selectedIdType)

async function postBooking() {
  booking.setUser({
    first_name: first_name.value,
    last_name: last_name.value,
    email: email.value,
    phone_number: phone_number.value,
    address: address.value
  })

  // Use FormData to send file
  const formData = new FormData();
  formData.append('package_id', booking.$state.packageId);
  formData.append('customer_name', `${booking.$state.user.first_name} ${booking.$state.user.last_name}`);
  formData.append('discount_id', booking.$state.discountId);
  formData.append('voucher_id', booking.$state.voucherCode || '');
  formData.append('total_quantity', booking.$state.quantity);
  formData.append('total_price', booking.$state.amountWithDiscount);
  if (discountIdImage.value) {
    formData.append('discount_id_image', discountIdImage.value);
  }
  if (selectedIdType.value) {
    formData.append('selected_id_type', selectedIdType.value);
  }

  try {
    const response = await service.createBooking(formData)
    toast.success('Booking successfully created!')
    setTimeout(() => {
      window.location.href = route('destination')
    }, 1500)
  } catch (error) {
    console.error('Error saving booking:', error)
  }
}

onMounted(() => {
  console.log(user.value) 
  if (user.value) {
    first_name.value = user.value.first_name
    last_name.value = user.value.last_name
    email.value = user.value.email
    phone_number.value = user.value.phone_number
    address.value = user.value.address
  }
});

</script>
<template>
  <div class="w-full min-h-screen flex flex-col items-center bg-[#fcfcfc] py-8">
    <!-- Stepper at the top -->
    <div class="flex items-center gap-2 mb-16 mt-2 w-full max-w-5xl justify-center">
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#ff7f2a] bg-[#ff7f2a] flex items-center justify-center">
          <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>
        </span>
        <span class="ml-1 text-[#ff7f2a] font-semibold text-base">Availability</span>
      </div>
      <span class="w-16 h-0.5 bg-[#ff7f2a] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#ff7f2a] bg-[#ff7f2a] flex items-center justify-center">
          <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>
        </span>
        <span class="ml-1 text-[#ff7f2a] font-semibold text-base">Select Package</span>
      </div>
      <span class="w-16 h-0.5 bg-[#ff7f2a] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#ff7f2a] flex items-center justify-center">
          <span class="w-2 h-2 rounded-full bg-[#ff7f2a]"></span>
        </span>
        <span class="ml-1 text-[#ff7f2a] font-semibold text-base border-b-2 border-[#ff7f2a] pb-0.5">Confirmation</span>
      </div>
    </div>
    <!-- Main Content -->
    <div class="flex flex-row w-full max-w-6xl justify-center gap-8">
      <!-- Left Side: Details Form -->
      <div class="flex-1">
        <div class="flex justify-start mb-4">
          <button @click="emit('back')" class="w-24 rounded-full py-2 font-bold text-lg transition bg-[#d95f00] text-white hover:bg-[#b94c00]">
            Back
          </button>
        </div>
        <div class="font-bold text-xl mb-4 text-[#f28c3a]">Details</div>
        <form class="flex flex-col gap-4">
          <div>
            <label class="block text-[#f28c3a] font-semibold mb-1">First Name</label>
            <input type="text" v-model ="first_name" class="w-full border-2 border-[#f28c3a] rounded-xl px-4 py-3 bg-white text-[#f28c3a] focus:outline-none focus:ring-2 focus:ring-[#ff7f2a]" />
          </div>
          <div>
            <label class="block text-[#f28c3a] font-semibold mb-1">Last Name</label>
            <input type="text" v-model ="last_name" class="w-full border-2 border-[#f28c3a] rounded-xl px-4 py-3 bg-white text-[#f28c3a] focus:outline-none focus:ring-2 focus:ring-[#ff7f2a]" />
          </div>
          <div>
            <label class="block text-[#f28c3a] font-semibold mb-1">Email</label>
            <input type="email" v-model ="email" class="w-full border-2 border-[#f28c3a] rounded-xl px-4 py-3 bg-white text-[#f28c3a] focus:outline-none focus:ring-2 focus:ring-[#ff7f2a]" />
          </div>
          <div>
            <label class="block text-[#f28c3a] font-semibold mb-1">Contact No.</label>
            <input type="text" v-model ="phone_number" class="w-full border-2 border-[#f28c3a] rounded-xl px-4 py-3 bg-white text-[#f28c3a] focus:outline-none focus:ring-2 focus:ring-[#ff7f2a]" />
          </div>
          <div>
            <label class="block text-[#f28c3a] font-semibold mb-1">Address</label>
            <input type="text" class="w-full border-2 border-[#f28c3a] rounded-xl px-4 py-3 bg-white text-[#f28c3a] focus:outline-none focus:ring-2 focus:ring-[#ff7f2a]" />
          </div>
          <!--
          <div>
            <label class="block text-[#f28c3a] font-semibold mb-1">City &amp; Province</label>
            <select class="w-full border-2 border-[#f28c3a] rounded-xl px-4 py-3 bg-white text-[#f28c3a] focus:outline-none focus:ring-2 focus:ring-[#ff7f2a]">
              <option>City &amp; Province</option>
            </select>
          </div>  
          -->
          <div class="flex items-center mt-2">
            <input type="checkbox" id="agree" class="accent-[#ff7f2a] mr-2" />
            <label for="agree" class="text-[#f28c3a] text-sm">
              Check the box to confirm you've read and agree to our
              <a href="#" class="text-[#2471a3] underline">Terms and Conditions</a> and
              <a href="#" class="text-[#2471a3] underline">Privacy Policy</a>.
            </label>
          </div>
          <button
            @click="postBooking"
            type="button"
            class="mt-4 w-48 py-4 bg-[#f28c3a] text-white font-semibold rounded-xl shadow text-lg hover:bg-[#d95f00] transition"
          >
            Book Now
          </button>
        </form>
      </div>
      <!-- Right Side: Summary Card -->
      <div class="w-full max-w-sm bg-[#f28c3a] rounded-xl p-8 flex flex-col min-h-[350px] self-start">
        <div>
          <div class="font-bold text-white text-2xl mb-4 text-center">Details</div>
          <hr class="border-[#ffb97a] mb-4" />
          <div class="font-bold text-white text-lg mb-2">La Union Travel Getaway - 3 Days</div>
          <div class="text-white mb-4">
            <div>Starting Date: <span class="text-white">MM/DD/YY</span></div>
          </div>
          <div class="text-white mb-4">
            <div class="mb-1">Travellers</div>
            <div class="flex justify-between">
              <span>Rate P {{ booking.$state.amount }} x ({{ booking.$state.quantity }})</span>
              <span>P {{ booking.$state.amount }}</span>
            </div>
            <div class="flex justify-between">
              <span>Discount ID</span>
              <span>- 20%</span>
            </div>
            <!-- <div class="flex justify-between font-bold mt-2">
              <span>Subtotal:</span>
              <span>P XXXX</span>
            </div> -->
          </div>
          <hr class="border-[#ffb97a] my-4" />
          <div class="flex justify-between items-center font-bold text-white text-xl mt-4">
            <span>Total :</span>
            <span>P {{ booking.$state.amountWithDiscount }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>