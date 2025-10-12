<script setup>
import LandingIndex from './LandingIndex.vue'
import { api } from '../../api/api'
import { usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue'
import { storeBooking } from '../../state/storeBooking'
import { useToast } from 'vue-toastification'
import TermsAndPrivacyModal from '../../components/TermsAndPrivacyModal.vue'
import BookingSuccessModal from '../../components/BookingSuccessModal.vue'
import LoadingOverlay from '../../components/LoadingOverlay.vue'

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
const agreeChecked = ref(false)
const showModal = ref(false)
const modalType = ref('terms')
const showSuccessModal = ref(false)
const isLoading = ref(false)

const errors = ref({
  first_name: '',
  last_name: '',
  email: '',
  phone_number: '',
  address: ''
})

function validateFields() {
  let isValid = true
  errors.value = { first_name: '', last_name: '', email: '', phone_number: '', address: '' }

  if (!first_name.value || !first_name.value.trim()) {
    errors.value.first_name = 'First Name is required.'
    isValid = false
  }
  if (!last_name.value || !last_name.value.trim()) {
    errors.value.last_name = 'Last Name is required.'
    isValid = false
  }
  if (!email.value || !email.value.trim()) {
    errors.value.email = 'Email is required.'
    isValid = false
  } else {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!emailRegex.test(email.value)) {
      errors.value.email = 'Enter a valid email address.'
      isValid = false
    }
  }
  if (!phone_number.value || !phone_number.value.trim()) {
    errors.value.phone_number = 'Contact No. is required.'
    isValid = false
  } else {
    const digits = phone_number.value.replace(/\D/g, '')
    if (digits.length < 7) {
      errors.value.phone_number = 'Enter a valid contact number.'
      isValid = false
    }
  }
  if (!address.value || !address.value.trim()) {
    errors.value.address = 'Address is required.'
    isValid = false
  }

  if (!agreeChecked.value) {
    toast.error('You must agree to the Terms and Privacy Policy.')
    isValid = false
  }

  return isValid
}

// Retrieve discountIdImage and selectedIdType from store
const discountIdImage = computed(() => booking.discountIdImage)
const selectedIdType = computed(() => booking.selectedIdType)

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

async function postBooking() {
  if (!validateFields()) {
    return
  }
  
  isLoading.value = true
  
  booking.setUser({
    first_name: first_name.value,
    last_name: last_name.value,
    email: email.value,
    phone_number: phone_number.value,
    address: address.value
  })

  // Use FormData to send file
  const formData = new FormData();
  formData.append('package_id', booking.packageId);
  formData.append('customer_name', `${booking.user.first_name} ${booking.user.last_name}`);
  formData.append('customer_id', user.value.id);
  formData.append('voucher_id', booking.voucherCode || '');
  formData.append('total_quantity', booking.adultsQuantity + booking.kidsQuantity);
  formData.append('total_price', booking.amountWithDiscount);
  formData.append('status', 'Pending');
  formData.append('remarks', booking.remarks || '');
  
  // Package details
  formData.append('package_destination', booking.packageDestination);
  formData.append('tour_type', booking.tourType);
  formData.append('duration', booking.duration);
  formData.append('start_date', booking.startDate);
  formData.append('end_date', booking.endDate);
  
  // Pricing details
  formData.append('adults_quantity', booking.adultsQuantity);
  formData.append('kids_quantity', booking.kidsQuantity);
  formData.append('adult_rate', booking.adultRate);
  formData.append('kids_rate', booking.kidsRate);
  formData.append('adult_total_amount', booking.adultTotalAmount);
  formData.append('kids_total_amount', booking.kidsTotalAmount);
  formData.append('original_amount', booking.amount);
  
  // Customer contact details
  formData.append('customer_email', booking.user.email);
  formData.append('customer_phone', booking.user.phone_number);
  formData.append('customer_address', booking.user.address);
  
  // Add discount images from store
  if (booking.discountImages && booking.discountImages.length > 0) {
    booking.discountImages.forEach((image, index) => {
      formData.append(`discount_images[${index}]`, image.file);
    });
  }
  
  if (discountIdImage.value) {
    formData.append('discount_id_image', discountIdImage.value);
  }
  if (selectedIdType.value) {
    formData.append('id_type', selectedIdType.value);
  }

  try {
    const response = await service.createBooking(formData)
    await new Promise(resolve => setTimeout(resolve, 500))
    isLoading.value = false
    showSuccessModal.value = true
  } catch (error) {
    console.error('Error saving booking:', error)
    isLoading.value = false
  }
}

function openModal(type) {
  modalType.value = type
  showModal.value = true
}

function closeModal() {
  showModal.value = false
}

function closeSuccessModal() {
  showSuccessModal.value = false
}

function returnHome() {
  window.location.href = route('destination')
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
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] bg-[#008DDA] flex items-center justify-center">
          <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base">Availability</span>
      </div>
      <span class="w-16 h-0.5 bg-[#008DDA] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] bg-[#008DDA] flex items-center justify-center">
          <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base">Select Package</span>
      </div>
      <span class="w-16 h-0.5 bg-[#008DDA] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] flex items-center justify-center">
          <span class="w-2 h-2 rounded-full bg-[#008DDA]"></span>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base border-b-2 border-[#008DDA] pb-0.5">Confirmation</span>
      </div>
    </div>
    <!-- Main Content -->
    <div class="flex flex-row w-full max-w-6xl justify-center gap-8">
      <!-- Left Side: Details Form -->
      <div class="flex-1">
        <div class="flex justify-start mb-4">
          <button @click="emit('back')" class="w-24 rounded-full py-2 font-bold text-lg transition bg-[#1E71B8] text-white hover:bg-[#73BE5D]">
            Back
          </button>
        </div>
        <div class="font-bold text-xl mb-4 text-[#1E71B8]">Details</div>
        <form class="flex flex-col gap-4">
          <div>
            <label class="block text-[#1E71B8] font-semibold mb-1">First Name</label>
          <input type="text" v-model ="first_name" :class="['w-full border-2 rounded-xl px-4 py-3 bg-white text-[#00000] focus:outline-none focus:ring-2 focus:ring-[#008DDA]', errors.first_name ? 'border-red-500' : 'border-[#1E71B8]']" />
          <p v-if="errors.first_name" class="text-red-600 text-sm mt-1">{{ errors.first_name }}</p>
          </div>
          <div>
            <label class="block text-[#1E71B8] font-semibold mb-1">Last Name</label>
          <input type="text" v-model ="last_name" :class="['w-full border-2 rounded-xl px-4 py-3 bg-white text-[#00000] focus:outline-none focus:ring-2 focus:ring-[#008DDA]', errors.last_name ? 'border-red-500' : 'border-[#1E71B8]']" />
          <p v-if="errors.last_name" class="text-red-600 text-sm mt-1">{{ errors.last_name }}</p>
          </div>
          <div>
            <label class="block text-[#1E71B8] font-semibold mb-1">Email</label>
          <input type="email" v-model ="email" :class="['w-full border-2 rounded-xl px-4 py-3 bg-white text-[#00000] focus:outline-none focus:ring-2 focus:ring-[#008DDA]', errors.email ? 'border-red-500' : 'border-[#1E71B8]']" />
          <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</p>
          </div>
          <div>
            <label class="block text-[#1E71B8] font-semibold mb-1">Contact No.</label>
          <input type="text" v-model ="phone_number" :class="['w-full border-2 rounded-xl px-4 py-3 bg-white text-[#00000] focus:outline-none focus:ring-2 focus:ring-[#008DDA]', errors.phone_number ? 'border-red-500' : 'border-[#1E71B8]']" />
          <p v-if="errors.phone_number" class="text-red-600 text-sm mt-1">{{ errors.phone_number }}</p>
          </div>
          <div>
            <label class="block text-[#1E71B8] font-semibold mb-1">Address</label>
          <input type="text" v-model="address" :class="['w-full border-2 rounded-xl px-4 py-3 bg-white text-[#00000] focus:outline-none focus:ring-2 focus:ring-[#008DDA]', errors.address ? 'border-red-500' : 'border-[#1E71B8]']" />
          <p v-if="errors.address" class="text-red-600 text-sm mt-1">{{ errors.address }}</p>
          </div>
          <!--
          <div>
            <label class="block text-[#1E71B8] font-semibold mb-1">City &amp; Province</label>
            <select class="w-full border-2 border-[#1E71B8] rounded-xl px-4 py-3 bg-white text-[#1E71B8] focus:outline-none focus:ring-2 focus:ring-[#008DDA]">
              <option>City &amp; Province</option>
            </select>
          </div>  
          -->
          <div class="flex items-center mt-2">
            <input type="checkbox" id="agree" v-model="agreeChecked" class="accent-[#008DDA] mr-2" />
            <label for="agree" class="text-[#1E71B8] text-sm">
              Check the box to confirm you've read and agree to our
              <a href="#" @click.prevent="openModal('terms')" class="text-[#2471a3] underline hover:text-[#1E71B8] cursor-pointer">Terms and Conditions</a> and
              <a href="#" @click.prevent="openModal('privacy')" class="text-[#2471a3] underline hover:text-[#1E71B8] cursor-pointer">Privacy Policy</a>.
            </label>
          </div>
          <button
            @click="postBooking"
            type="button"
            :disabled="!agreeChecked || isLoading"
            :class="['mt-4 w-48 py-4 text-white font-semibold rounded-xl shadow text-lg transition flex items-center justify-center', (!agreeChecked || isLoading) ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#1E71B8] hover:bg-[#d95f00]']"
          >
            <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ isLoading ? 'Processing...' : 'Book Now' }}
          </button>
        </form>
      </div>
      <!-- Right Side: Summary Card -->
      <div class="w-full max-w-sm bg-[#1E71B8] rounded-xl p-8 flex flex-col min-h-[350px] self-start">
        <div>
          <div class="font-bold text-white text-2xl mb-4 text-center">Details</div>
          <hr class="border-[#73BE5D] mb-4" />
          <div class="font-bold text-white text-lg mb-2">{{ booking.packageDestination }}</div>
          <div class="text-white mb-4">
            <div>Tour Type: <span class="text-white">{{ booking.tourType }}</span></div>
          </div>
          <div class="text-white mb-4">
            <div>Duration: <span class="text-white">{{ booking.duration }} Day<span v-if="durationDays !== 1">s</span></span></div>
          </div>
          <div class="text-white mb-4">
            <div>Starting Date: <span class="text-white">{{ booking.startDate }}</span></div>
          </div>
          <div class="text-white mb-4">
            <div class="mb-1">Travellers</div>
            <div class="flex justify-between">
              <span>Adults Rate ₱ {{ booking.adultRate }} x ({{ booking.adultsQuantity }})</span>
              <span>₱ {{ booking.adultTotalAmount }}</span>
            </div>
            <div class="flex justify-between">
              <span>Kids Rate ₱ {{ booking.kidsRate }} x ({{ booking.kidsQuantity }})</span>
              <span>₱ {{ booking.kidsTotalAmount }}</span>
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
          <hr class="border-[#73BE5D] my-4" />
          <div class="flex justify-between items-center font-bold text-white text-xl mt-4">
            <span>Total :</span>
            <span>₱ {{ booking.amountWithDiscount }}</span>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Terms and Privacy Modal -->
    <TermsAndPrivacyModal 
      :show="showModal" 
      :type="modalType" 
      @close="closeModal" 
    />
    
    <!-- Booking Success Modal -->
    <BookingSuccessModal 
      :show="showSuccessModal" 
      @close="closeSuccessModal"
      @returnHome="returnHome"
    />
    
    <!-- Loading Overlay -->
    <LoadingOverlay 
      :show="isLoading" 
      message="Processing your booking..."
    />
  </div>
</template>