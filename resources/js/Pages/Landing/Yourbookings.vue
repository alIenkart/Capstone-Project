<template>
  <div class="min-h-screen w-full bg-[#f4f8fb]">
    <PaymentReceiptModal :isOpen="showReceiptModal" :receiptData="receiptData" @close="closeReceiptModal" />
    <div class="w-full bg-[#1E71B8] py-4 px-8 shadow-sm">
      <h2 class="text-white text-3xl font-bold tracking-tight">My Bookings</h2>
    </div>
    <div class="flex w-full h-[calc(100vh-72px)]">
      <aside class="w-80 bg-white border-r border-gray-100 h-full py-8 px-4">
        <div class="mb-8 px-2">
          <h3 class="text-gray-900 text-sm font-bold uppercase tracking-wider mb-4">Filter Bookings</h3>
          <div class="relative">
            <button @click="isFilterOpen = !isFilterOpen"
              class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 group">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                <span class="font-semibold text-gray-800">
                  {{ selectedStatusFilter === 'All' ? 'All Statuses' : selectedStatusFilter }}
                </span>
              </div>
              <svg :class="['w-5 h-5 text-blue-600 transition-transform duration-300', isFilterOpen ? 'rotate-180' : '']"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div v-if="isFilterOpen" class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden animate-in fade-in slide-in-from-top-2">
              <div v-for="status in uniqueStatuses" :key="status"
                @click="selectedStatusFilter = status; isFilterOpen = false"
                :class="[
                  'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                  selectedStatusFilter === status ? 'bg-blue-50 border-l-4 border-l-blue-500' : ''
                ]">
                <span v-if="status === 'All'" class="text-lg"></span>
                <span v-else-if="status === 'Approved'" class="text-lg"></span>
                <span v-else-if="status === 'Pending'" class="text-lg"></span>
                <span v-else-if="status === 'reject'" class="text-lg"></span>
                
                <span :class="[
                  'font-medium',
                  selectedStatusFilter === status ? 'text-blue-700' : 'text-gray-700'
                ]">
                  {{ status === 'All' ? 'All Statuses' : status }}
                </span>
                
                <svg v-if="selectedStatusFilter === status" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>
        
        <h3 class="text-gray-700 text-lg font-semibold mb-4 px-2">All Bookings</h3>
        <div class="flex flex-col gap-2 overflow-y-auto" style="max-height: 70vh">
          <div v-if="filteredBookings.length" v-for="(booking, i) in filteredBookings" :key="booking.id"
            @click="selectedBookingIndex = i" :class="[
              'cursor-pointer transition-all flex flex-row items-center gap-3 rounded-lg px-4 py-3 group border',
              i === selectedBookingIndex
                ? 'bg-blue-50/80 border-blue-300 ring-2 ring-blue-200'
                : 'hover:bg-gray-50 border-transparent'
            ]">
            <div class="flex-grow">
              <div class="font-semibold tracking-tight truncate">
                {{ booking.package_destination }} Tour
              </div>
              <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path
                      d="M8 7V3M16 7V3M3 11h18M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z" />
                  </svg>
                  {{ new Date(booking.start_date).toLocaleDateString('en-PH', {
                    year: 'numeric', month: 'long', day:
                      'numeric'
                  }) }}
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 10a4 4 0 108 0 4 4 0 00-8 0zm6 2H7a6 6 0 100 12h6a6 6 0 100-12z" />
                  </svg>
                  {{ booking.total_quantity }}
                </span>
              </div>
              <div class="flex items-center gap-2 mt-1">
                <span class="rounded px-2 py-0.5 text-xs font-semibold transition" :class="{
                  'bg-green-100 text-green-700': booking.status === 'Approved',
                  'bg-yellow-100 text-yellow-700': booking.status === 'Pending',
                  'bg-red-100 text-red-600': booking.status === 'reject'
                }">{{ booking.status }}</span>
                <span v-if="booking.tour_type" class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-xs">{{
                  booking.tour_type }}</span>
              </div>

            </div>
            <span class="font-mono text-xs text-blue-500">B{{ String(booking.id).padStart(5, '0') }}</span>
          </div>
          <div v-else class="flex items-center justify-center h-96 text-gray-400 text-lg">
            No bookings found.
          </div>
        </div>
      </aside>
      <main class="flex-1 flex justify-center items-start py-10 overflow-auto">
        <div v-if="filteredBookings.length" class="bg-white rounded-3xl shadow-lg w-full max-w-5xl px-8 py-6">
          <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-7 border-b pb-5 border-gray-100">
            <div>
              <div class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-2 leading-tight">
                {{ filteredBookings[selectedBookingIndex].package_destination }} Tour
              </div>
              <div class="flex flex-wrap gap-4 mb-1 text-gray-500">
                <div class="flex items-center gap-1 text-base">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path
                      d="M8 7V3M16 7V3M3 11h18M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z" />
                  </svg>
                  {{ new Date(filteredBookings[selectedBookingIndex].start_date).toLocaleDateString('en-PH', {
                    year: 'numeric',
                    month: 'long', day: 'numeric'
                  }) }}
                </div>
                <div class="flex items-center gap-1 text-base">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 10a4 4 0 108 0 4 4 0 00-8 0zm6 2H7a6 6 0 100 12h6a6 6 0 100-12z" />
                  </svg>
                  {{ filteredBookings[selectedBookingIndex].total_quantity }}
                </div>
                <div>Booking Type: <span class="font-semibold text-gray-700">{{ filteredBookings[selectedBookingIndex].tour_type
                    }}</span></div>
                <div>Booked: <span class="font-semibold text-gray-700">{{ new
                  Date(filteredBookings[selectedBookingIndex].created_at).toLocaleDateString('en-PH', {
                    year: 'numeric',
                    month: 'long', day: 'numeric'
                  }) }}</span></div>
              </div>
            </div>
            <span class="text-base font-mono text-blue-500 font-bold mt-3 md:mt-0">B{{
              String(filteredBookings[selectedBookingIndex].id).padStart(5, '0') }}</span>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-3 mb-7">
            <div class="flex flex-col">
              <span class="text-gray-500 text-sm">Booking Status</span>
              <span class="text-sm px-3 py-1 rounded-full font-semibold w-fit mt-1 transition-all" :class="[
                filteredBookings[selectedBookingIndex].status === 'Approved'
                  ? 'bg-green-400 text-white'
                  : filteredBookings[selectedBookingIndex].status === 'reject'
                    ? 'bg-red-400 text-white'
                    : 'bg-yellow-400 text-white'
              ]">
                {{ filteredBookings[selectedBookingIndex].status }}
              </span>
            </div>
            <div class="flex flex-col">
              <span class="text-gray-500 text-sm">Guests</span>
              <span class="font-medium text-gray-800 mt-1">{{ filteredBookings[selectedBookingIndex].total_quantity }}</span>
            </div>
            <div class="flex flex-col">
              <span class="text-gray-500 text-sm">Total Due</span>
              <span class="text-lg font-bold text-green-600 mt-1">
                ₱{{ Number(filteredBookings[selectedBookingIndex].total_price).toLocaleString('en-PH') }}
              </span>
            </div>
            <div class="flex flex-col">
              <span class="text-gray-500 text-sm">Payment Status</span>
              <span class="text-sm px-3 py-1 rounded-full font-semibold w-fit mt-1 transition-all" :class="{
                'bg-yellow-400 text-white': paymentStatus === 'Pending',
                'bg-green-400 text-white': paymentStatus === 'Approved',
                'bg-red-400 text-white': paymentStatus === 'Unpaid' || paymentStatus === 'Rejected',
              }">
                {{ paymentStatus }}
              </span>
            </div>
          </div>
          <div v-if="filteredBookings[selectedBookingIndex].remarks" class="mb-6">
            <span class="text-gray-500 block mb-1">Remarks</span>
            <span class="bg-gray-50 rounded px-4 py-2 text-gray-700 font-mono">
              {{ toCamelCase(filteredBookings[selectedBookingIndex].remarks) }}
            </span>
          </div>
          <div class="mt-6 mb-2 border-t border-gray-200 pt-6">
            <h4 class="font-bold text-lg text-gray-700 mb-4 text-center">Payment</h4>
            <div class="flex flex-col sm:flex-row gap-8 items-center mb-6">
              <div class="w-full sm:w-1/2 flex flex-col justify-center items-center">
                <div class="font-semibold text-gray-800 text-center text-xl mb-1">Dorie Magjobos</div>
                <div class="text-gray-500 text-center text-base mb-3">xxxx xxx 1200</div>
                <img src="/storage/qr-payment/qr.png" alt="QR Payment"
                  class="w-48 h-48 bg-white border-2 border-gray-200 rounded-lg object-contain mb-2 shadow-sm" />
                <div class="text-sm text-gray-500 mt-2 text-center">Scan this QR code to pay</div>
              </div>
              <div class="w-full sm:w-1/2 flex flex-col gap-5 justify-center">
                <div>
                  <label class="block mb-2 text-gray-700 font-medium" for="paymentType">Mode of Payment:</label>
                  <select id="modeOfPayment" v-model="selectedModeOfPayment"
                    class="rounded-md border border-gray-300 p-2 bg-white focus:ring-2 focus:ring-blue-200 transition"
                    style="width: 50%">
                    <option value="GCASH">GCASH</option>
                    <option value="Pay Maya">Pay Maya</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-gray-700 font-medium" for="paymentType">Type of Payment:</label>
                  <select id="paymentType" v-model="selectedPaymentType"
                    class="rounded-md border border-gray-300 p-2 bg-white focus:ring-2 focus:ring-blue-200 transition"
                    style="width: 50%">
                    <option value="full">Full Payment</option>
                    <option value="down">Down Payment</option>
                  </select>
                </div>
                <div v-if="selectedPaymentType === 'full'">
                  <span class="text-gray-700 font-medium">Amount to pay:</span>
                  <span class="ml-2 text-lg font-bold text-green-600">
                    ₱{{ Number(filteredBookings[selectedBookingIndex]?.total_price || 0).toLocaleString('en-PH') }}
                  </span>
                </div>
                <div v-else-if="selectedPaymentType === 'down'">
                  <label class="block mb-2 text-gray-700 font-medium" for="downPaymentAmount">Enter Down Payment Amount:</label>
                  <input
                    id="downPaymentAmount"
                    v-model.number="formData.downPaymentAmount"
                    type="number"
                    min="0"
                    class="rounded-md border border-gray-300 p-2 w-1/2 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="Enter amount (₱)"
                  />
                </div>
                <div>
                  <label class="block mb-2 text-gray-700 font-medium">Upload Payment Receipt:</label>
                  <div class="flex items-center gap-4 mb-4 flex-wrap">
                    <label v-if="!selectedFile" :class="[
                      'flex items-center px-4 py-2 rounded-lg border shadow-sm transition',
                      filteredBookings[selectedBookingIndex]?.status === 'Pending'
                        ? 'bg-gray-200 text-gray-400 border-gray-300 cursor-not-allowed'
                        : 'bg-blue-50 text-blue-700 border-blue-100 hover:bg-blue-200 cursor-pointer'
                    ]">
                      <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 16v-4m0 0V8m0 4h4m-4 0H8m12 4v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4"></path>
                      </svg>
                      <span>Add Image</span>
                      <input type="file" class="hidden" @change="onFileChange"
                        :disabled="filteredBookings[selectedBookingIndex]?.status === 'Pending'" />
                    </label>

                    <div v-else class="flex items-center bg-white px-3 py-2 rounded shadow border cursor-pointer"
                      @click="$refs.fileInput.click()">
                      <img :src="previewUrl" alt="Preview" class="w-20 h-20 rounded object-cover border" />
                      <input ref="fileInput" type="file" class="hidden" @change="onFileChange"
                        :disabled="filteredBookings[selectedBookingIndex]?.status === 'Pending'" />
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="flex justify-center w-full">
              <div class="flex flex-col items-center gap-4 mt-8 mb-2 relative group w-full max-w-xs">
                <button
                  v-if="filteredBookings[selectedBookingIndex]?.status === 'Approved' && (paymentStatus === 'Pending' || paymentStatus === 'Unpaid')"
                  :disabled="!selectedFile" @click="submitProofOfPayment()"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-8 py-3 rounded-xl font-bold text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  Send For Approval
                </button>

                <button v-if="paymentStatus === 'Approved'" @click="submitPayment"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-8 py-3 rounded-xl font-bold text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  View Receipt
                </button>

                <button v-if="filteredBookings[selectedBookingIndex]?.status === 'Pending'" @click="submitPayment"
                  :disabled="filteredBookings[selectedBookingIndex]?.status === 'Pending'"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-8 py-3 rounded-xl font-bold text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  Submit
                </button>

                <span v-if="filteredBookings[selectedBookingIndex]?.status === 'Pending'"
                  class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                  Wait for the booking status to be set to approved.
                </span>

                <span v-else-if="!selectedFile"
                  class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                  Please upload the receipt.
                </span>

                <button v-if="paymentStatus === 'Pending' || paymentStatus === 'Unpaid'"
                  class="w-full bg-white hover:bg-red-50 text-red-500 border border-red-400 px-8 py-3 rounded-xl font-bold text-lg transition shadow-md focus:outline-none focus:ring-2 focus:ring-red-100 active:scale-95 duration-150">
                  Cancel Booking
                </button>
              </div>
            </div>

          </div>
        </div>
        <div v-else class="flex items-center justify-center h-96 text-gray-400 text-lg">
          No bookings found.
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import LandingIndex from './LandingIndex.vue'
import PaymentReceiptModal from './PaymentReceiptModal.vue'
import { fetchBookingsByUser, fetchPaymentsByBookingId } from '@/api/booking';
import { onMounted, ref, watch, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toCamelCase } from '@/helper/helper'
import { useToast } from 'vue-toastification'

const user = usePage().props.auth.user;
const toast = useToast();
const bookings = ref([]);
const payments = ref([]);
const selectedBookingIndex = ref(0);
const userId = user?.id;
const selectedPaymentType = ref('full');
const selectedModeOfPayment = ref('GCASH');
const selectedFile = ref(null);
const previewUrl = ref(null);
const showReceiptModal = ref(false);
const receiptData = ref({});
const selectedStatusFilter = ref('All');
const isFilterOpen = ref(false);

const formData = ref({
  paymentType: '',
  downPaymentAmount: 0,
  fullPaymentAmount: 0,
  remainingBalance: 0,
  paymentDate: '',
  proofOfPayment: null,
});

// Computed property for filtered bookings
const filteredBookings = computed(() => {
  if (selectedStatusFilter.value === 'All') {
    return bookings.value;
  }
  return bookings.value.filter(booking => booking.status === selectedStatusFilter.value);
});

// Get unique statuses from bookings
const uniqueStatuses = computed(() => {
  const statuses = new Set(bookings.value.map(b => b.status));
  return ['All', ...Array.from(statuses)];
});

const imagePreview = ref(null)

const onFileChange = (event) => {
  const file = event.target.files[0];
  selectedFile.value = file;
  previewUrl.value = file ? URL.createObjectURL(file) : null;
}

const removeFile = () => {
  selectedFile.value = null;
  previewUrl.value = null;
}

const submitPayment = () => {
  const currentBooking = filteredBookings.value[selectedBookingIndex.value];

  receiptData.value = {
    receiptNo: `B${String(currentBooking.id).padStart(5, '0')}`,
    date: new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }),
    customerName: currentBooking.customer_name || '',
    customerEmail: currentBooking.customer_email || '',
    customerPhone: currentBooking.customer_phone || '+63XXXXXXXXXXX',
    paymentVia: 'GCash',
    quantity: currentBooking.total_quantity,
    paymentType: selectedPaymentType.value === 'full' ? 'Full Payment' : 'Down Payment',
    tourClassification: 'Land Tour',
    package: `${currentBooking.package_destination} Tour`,
    duration: currentBooking.duration,
    bookingType: currentBooking.tour_type,
    destination: currentBooking.package_destination,
    travelDate: new Date(currentBooking.start_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }),
    totalAmount: Number(currentBooking.total_price).toLocaleString('en-PH'),
    amountPaid: Number(currentBooking.total_price).toLocaleString('en-PH'),
    remainingBalance: '0'
  };

  showReceiptModal.value = true;
}

const closeReceiptModal = () => {
  showReceiptModal.value = false;
}

onMounted(async () => {
  bookings.value = await fetchBookingsByUser(userId);
  console.log('view bookings', bookings.value)
  
  if (filteredBookings.value.length) {
    payments.value = await fetchPaymentsByBookingId(filteredBookings.value[selectedBookingIndex.value].id);
    console.log('view payment', payments.value)
  }
});

watch(selectedBookingIndex, async (newIndex) => {
  if (filteredBookings.value.length) {
    const bookingId = filteredBookings.value[newIndex].id;
    payments.value = await fetchPaymentsByBookingId(bookingId);
  }
});

// Reset selectedBookingIndex when filter changes
watch(selectedStatusFilter, () => {
  selectedBookingIndex.value = 0;
  isFilterOpen.value = false;
});

const paymentStatus = computed(() => {
  if (!payments.value.length || !filteredBookings.value.length) return 'Unpaid';
  const currentBookingId = filteredBookings.value[selectedBookingIndex.value].id;
  const currentPayment = payments.value.find(p => p.booking_id === currentBookingId);
  return currentPayment ? currentPayment.payment_status : 'Unpaid';
});

async function submitProofOfPayment() {
  const currentBooking = filteredBookings.value[selectedBookingIndex.value];
  if (!currentBooking) return toast.error('No booking selected.');

  if (selectedPaymentType.value === 'down' && !formData.value.downPaymentAmount) {
    return toast.error('Please enter a down payment amount.');
  }
  if (!selectedFile.value) {
    return toast.error('Please upload a proof of payment.');
  }

  const total = Number(currentBooking.total_price);
  const paidAmount =
    selectedPaymentType.value === 'full'
      ? total
      : Number(formData.value.downPaymentAmount);
  const remaining = Math.max(total - paidAmount, 0);

  const payment_history = {
    paymentType: selectedPaymentType.value === 'full' ? 'Full Payment' : 'Down Payment',
    fullPaymentAmount: selectedPaymentType.value === 'full' ? total : 0,
    downPaymentAmount: selectedPaymentType.value === 'down' ? paidAmount : 0,
    remainingBalance: remaining,
    paymentDate: new Date().toISOString().split('T')[0],
    proofOfPayment: selectedFile.value ? selectedFile.value.name : null,
  };

  const data = new FormData();
  data.append('proof_of_payment', selectedFile.value);
  data.append('payment_history', JSON.stringify(payment_history));
  data.append('mode_of_payment', selectedModeOfPayment.value);
  data.append('payment_status', 'Under Review');

  try {
    const response = await axios.post(
      `/api/payments/${currentBooking.id}?_method=PUT`,
      data
    );

    if (response.status === 200) {
      toast.success('Payment successfully submitted!');
      payments.value = await fetchPaymentsByBookingId(currentBooking.id);
    }
  } catch (error) {
    console.error(error);
    toast.error('Something went wrong while submitting your payment.');
  }
}

defineOptions({ layout: LandingIndex })
</script>