<script setup>
import LandingIndex from './LandingIndex.vue'
import PaymentReceiptModal from './PaymentReceiptModal.vue'
import { fetchBookingsByUser, fetchPaymentsByBookingId } from '@/api/booking';
import { onMounted, ref, watch, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toCamelCase } from '@/helper/helper'

const user = usePage().props.auth.user;
const bookings = ref([]);
const payments = ref([]);
const selectedBookingIndex = ref(0);
const userId = user?.id;
const selectedPaymentType = ref('full');
const selectedFile = ref(null);
const previewUrl = ref(null);
const showReceiptModal = ref(false);
const receiptData = ref({});

function onFileChange(event) {
  const file = event.target.files[0];
  selectedFile.value = file;
  previewUrl.value = file ? URL.createObjectURL(file) : null;
}
function removeFile() {
  selectedFile.value = null;
  previewUrl.value = null;
}

function submitPayment() {
  const currentBooking = bookings.value[selectedBookingIndex.value];

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

function closeReceiptModal() {
  showReceiptModal.value = false;
}

onMounted(async () => {
  bookings.value = await fetchBookingsByUser(userId);
  // Fetch payments for the initial booking
  if (bookings.value.length) {
    payments.value = await fetchPaymentsByBookingId(bookings.value[selectedBookingIndex.value].id);
  }
});

watch(selectedBookingIndex, async (newIndex) => {
  if (bookings.value.length) {
    const bookingId = bookings.value[newIndex].id;
    payments.value = await fetchPaymentsByBookingId(bookingId);
  }
});

// Compute payment status for selected booking using payments.value and booking_id
const paymentStatus = computed(() => {
  if (!payments.value.length || !bookings.value.length) return 'Unpaid';
  const currentBookingId = bookings.value[selectedBookingIndex.value].id;
  const currentPayment = payments.value.find(p => p.booking_id === currentBookingId);
  return currentPayment ? currentPayment.payment_status : 'Unpaid';
});

defineOptions({ layout: LandingIndex })
</script>

<template>
  <div class="min-h-screen w-full bg-[#f4f8fb]">
    <PaymentReceiptModal :isOpen="showReceiptModal" :receiptData="receiptData" @close="closeReceiptModal" />
    <div class="w-full bg-[#1E71B8] py-4 px-8 shadow-sm">
      <h2 class="text-white text-3xl font-bold tracking-tight">My Bookings</h2>
    </div>
    <div class="flex w-full h-[calc(100vh-72px)]">
      <aside class="w-80 bg-white border-r border-gray-100 h-full py-8 px-4">
        <h3 class="text-gray-700 text-lg font-semibold mb-4 px-2">All Bookings</h3>
        <div class="flex flex-col gap-2 overflow-y-auto" style="max-height: 80vh">
          <div v-if="bookings.length" v-for="(booking, i) in bookings" :key="booking.id"
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
        <div v-if="bookings.length" class="bg-white rounded-3xl shadow-lg w-full max-w-5xl px-8 py-6">
          <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-7 border-b pb-5 border-gray-100">
            <div>
              <div class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-2 leading-tight">
                {{ bookings[selectedBookingIndex].package_destination }} Tour
              </div>
              <div class="flex flex-wrap gap-4 mb-1 text-gray-500">
                <div class="flex items-center gap-1 text-base">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path
                      d="M8 7V3M16 7V3M3 11h18M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z" />
                  </svg>
                  {{ new Date(bookings[selectedBookingIndex].start_date).toLocaleDateString('en-PH', {
                    year: 'numeric',
                    month: 'long', day: 'numeric'
                  }) }}
                </div>
                <div class="flex items-center gap-1 text-base">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 10a4 4 0 108 0 4 4 0 00-8 0zm6 2H7a6 6 0 100 12h6a6 6 0 100-12z" />
                  </svg>
                  {{ bookings[selectedBookingIndex].total_quantity }}
                </div>
                <div>Booking Type: <span class="font-semibold text-gray-700">{{ bookings[selectedBookingIndex].tour_type
                    }}</span></div>
                <div>Booked: <span class="font-semibold text-gray-700">{{ new
                  Date(bookings[selectedBookingIndex].created_at).toLocaleDateString('en-PH', {
                    year: 'numeric',
                    month: 'long', day: 'numeric'
                  }) }}</span></div>
              </div>
            </div>
            <span class="text-base font-mono text-blue-500 font-bold mt-3 md:mt-0">B{{
              String(bookings[selectedBookingIndex].id).padStart(5, '0') }}</span>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-3 mb-7">
            <div class="flex flex-col">
              <span class="text-gray-500 text-sm">Booking Status</span>
              <span class="text-sm px-3 py-1 rounded-full font-semibold w-fit mt-1 transition-all" :class="[
                bookings[selectedBookingIndex].status === 'Approved'
                  ? 'bg-green-400 text-white'
                  : bookings[selectedBookingIndex].status === 'reject'
                    ? 'bg-red-400 text-white'
                    : 'bg-yellow-400 text-white'
              ]">
                {{ bookings[selectedBookingIndex].status }}
              </span>
            </div>
            <div class="flex flex-col">
              <span class="text-gray-500 text-sm">Guests</span>
              <span class="font-medium text-gray-800 mt-1">{{ bookings[selectedBookingIndex].total_quantity }}</span>
            </div>
            <div class="flex flex-col">
              <span class="text-gray-500 text-sm">Total Due</span>
              <span class="text-lg font-bold text-green-600 mt-1">
                ₱{{ Number(bookings[selectedBookingIndex].total_price).toLocaleString('en-PH') }}
              </span>
            </div>
            <!-- Payment Status column using computed property -->
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
          <div v-if="bookings[selectedBookingIndex].remarks" class="mb-6">
            <span class="text-gray-500 block mb-1">Remarks</span>
            <span class="bg-gray-50 rounded px-4 py-2 text-gray-700 font-mono">
              {{ toCamelCase(bookings[selectedBookingIndex].remarks) }}
            </span>
          </div>
          <div class="mt-6 mb-2 border-t border-gray-200 pt-6">
            <h4 class="font-bold text-lg text-gray-700 mb-4 text-center">Payment</h4>
            <div class="flex flex-col sm:flex-row gap-8 items-center mb-6">
              <!-- LEFT: Name, Number, QR, Text -->
              <div class="w-full sm:w-1/2 flex flex-col justify-center items-center">
                <div class="font-semibold text-gray-800 text-center text-xl mb-1">Dorie Magjobos</div>
                <div class="text-gray-500 text-center text-base mb-3">xxxx xxx 1200</div>
                <img src="/storage/qr-payment/qr.png" alt="QR Payment"
                  class="w-48 h-48 bg-white border-2 border-gray-200 rounded-lg object-contain mb-2 shadow-sm" />
                <div class="text-sm text-gray-500 mt-2 text-center">Scan this QR code to pay</div>
              </div>
              <!-- RIGHT: Payment Dropdown, Amount, and Upload (with gap) -->
              <div class="w-full sm:w-1/2 flex flex-col gap-5 justify-center">
                <!-- Type of Payment -->
                <div>
                  <label class="block mb-2 text-gray-700 font-medium" for="paymentType">Type of Payment:</label>
                  <select id="paymentType" v-model="selectedPaymentType"
                    class="rounded-md border border-gray-300 p-2 bg-white focus:ring-2 focus:ring-blue-200 transition"
                    style="width: 50%">
                    <option value="full">Full Payment</option>
                    <option value="down">Down Payment</option>
                  </select>
                </div>
                <!-- Amount To Pay -->
                <div>
                  <span class="text-gray-700 font-medium">Amount to pay:</span>
                  <span class="ml-2 text-lg font-bold text-green-600">
                    ₱{{ Number(bookings[selectedBookingIndex]?.total_price || 0).toLocaleString('en-PH') }}
                  </span>
                </div>
                <!-- Upload Payment Receipt -->
                <div>
                  <label class="block mb-2 text-gray-700 font-medium">Upload Payment Receipt:</label>
                  <div class="flex items-center gap-4 mb-4 flex-wrap">
                    <label v-if="!selectedFile" :class="[
                      'flex items-center px-4 py-2 rounded-lg border shadow-sm transition',
                      bookings[selectedBookingIndex]?.status === 'Pending'
                        ? 'bg-gray-200 text-gray-400 border-gray-300 cursor-not-allowed'
                        : 'bg-blue-50 text-blue-700 border-blue-100 hover:bg-blue-200 cursor-pointer'
                    ]">
                      <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 16v-4m0 0V8m0 4h4m-4 0H8m12 4v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4"></path>
                      </svg>
                      <span>Add Image</span>
                      <input type="file" class="hidden" @change="onFileChange"
                        :disabled="bookings[selectedBookingIndex]?.status === 'Pending'" />
                    </label>

                    <div v-else class="flex items-center bg-white px-3 py-2 rounded shadow border cursor-pointer"
                      @click="$refs.fileInput.click()">
                      <img :src="previewUrl" alt="Preview" class="w-20 h-20 rounded object-cover border" />
                      <input ref="fileInput" type="file" class="hidden" @change="onFileChange"
                        :disabled="bookings[selectedBookingIndex]?.status === 'Pending'" />
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="flex justify-center w-full">
              <div class="flex flex-col items-center gap-4 mt-8 mb-2 relative group w-full max-w-xs">
                <button
                  v-if="bookings[selectedBookingIndex]?.status === 'Approved' && (paymentStatus === 'Pending' || paymentStatus === 'Unpaid')"
                  :disabled="!selectedFile"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-8 py-3 rounded-xl font-bold text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  Send For Approval
                </button>

                <button v-if="paymentStatus === 'Approved'" @click="submitPayment"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-8 py-3 rounded-xl font-bold text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  View Receipt
                </button>

                <button v-if="bookings[selectedBookingIndex]?.status === 'Pending'" @click="submitPayment"
                  :disabled="bookings[selectedBookingIndex]?.status === 'Pending'"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-8 py-3 rounded-xl font-bold text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  Submit
                </button>

                <!-- Tooltip -->
                <span v-if="bookings[selectedBookingIndex]?.status === 'Pending'"
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