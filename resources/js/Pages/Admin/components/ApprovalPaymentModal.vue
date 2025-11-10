<template>
  <!-- Payment Approval Modal -->
  <div v-if="!showReceipt" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden">
      <!-- Header -->
      <div class="bg-gradient-to-r from-[#217093] to-[#2a8bb5] px-8 py-6 relative">
        <h2 class="text-2xl font-bold text-white">Payment Approval</h2>
        <p class="text-white/80 text-sm mt-1">
          Review and process payment submission
        </p>
        <button
          class="absolute top-6 right-6 text-white/80 hover:text-white hover:bg-white/20 rounded-full w-10 h-10 flex items-center justify-center transition-all"
          @click="$emit('close')" aria-label="Close">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Content -->
      <div class="px-8 py-6 max-h-[calc(100vh-16rem)] overflow-y-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Left: Booking Details -->
          <div class="space-y-6">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
              <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#217093]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <h3 class="font-bold text-gray-800">Customer Information</h3>
              </div>
              <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                  <span class="text-gray-600">Name:</span>
                  <span class="font-semibold text-gray-800">{{
                    receiptData.customerName
                    }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">Email:</span>
                  <span class="font-semibold text-gray-800">{{
                    receiptData.customerEmail
                    }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">Phone:</span>
                  <span class="font-semibold text-gray-800">{{
                    receiptData.customerPhone
                    }}</span>
                </div>
              </div>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-200">
              <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#217093]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="font-bold text-gray-800">Booking Details</h3>
              </div>
              <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                  <div class="text-gray-600 text-xs">Booking Date</div>
                  <div class="font-semibold text-gray-800">March 26, 2024</div>
                </div>
                <div>
                  <div class="text-gray-600 text-xs">Travel Date</div>
                  <div class="font-semibold text-gray-800">
                    {{ receiptData.travelDate }}
                  </div>
                </div>
                <div>
                  <div class="text-gray-600 text-xs">Package</div>
                  <div class="font-semibold text-gray-800">
                    {{ receiptData.package }}
                  </div>
                </div>
                <div>
                  <div class="text-gray-600 text-xs">Duration</div>
                  <div class="font-semibold text-gray-800">
                    {{ receiptData.duration }}
                  </div>
                </div>
                <div>
                  <div class="text-gray-600 text-xs">Number of Pax</div>
                  <div class="font-semibold text-gray-800">
                    {{ receiptData.quantity }} People
                  </div>
                </div>
                <div>
                  <div class="text-gray-600 text-xs">Booking Type</div>
                  <div class="font-semibold text-gray-800">
                    {{ receiptData.bookingType }}
                  </div>
                </div>
                <div class="col-span-2">
                  <div class="text-gray-600 text-xs">Destination</div>
                  <div class="font-semibold text-gray-800">
                    {{ receiptData.destination }}
                  </div>
                </div>
                <!-- <div>
                  <div class="text-gray-600 text-xs">Discount Applied</div>
                  <div class="font-semibold text-green-600">Yes</div>
                </div> -->
              </div>
            </div>

            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-200">
              <h3 class="font-bold text-gray-800 mb-3">Payment Summary</h3>
              <div v-if="
                paymentHistory.some((p) => p.paymentType === 'Full Payment')
              ">
                <div class="space-y-2">
                  <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Paid Amount:</span>
                    <span class="font-semibold text-gray-800">₱ {{ currentPayment?.fullPaymentAmount }}</span>
                  </div>
                  <div class="flex justify-between text-lg font-bold pt-2 border-t border-emerald-200">
                    <span class="text-gray-800">Total Amount Paid:</span>
                    <span class="text-[#217093]">₱ {{ currentPayment?.fullPaymentAmount }}</span>
                  </div>
                </div>
              </div>

              <div v-else>
                <div class="space-y-2">
                  <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Paid Amount:</span>

                    <div class="text-right">
                      <div v-for="(p, index) in paymentHistory" :key="index" class="font-semibold text-gray-800">
                        ₱ {{ p.downPaymentAmount.toLocaleString() }}
                      </div>
                    </div>
                  </div>
                  <div class="flex justify-between text-lg font-bold pt-2 border-t border-emerald-200">
                    <span class="text-gray-800">Total Amount Paid:</span>
                    <span class="text-[#217093]">
                      ₱ {{ totalDownPayment.toLocaleString() }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Right: Payment Proof -->
          <div class="space-y-6">
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-200">
              <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#217093]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <h3 class="font-bold text-gray-800">Payment Proof</h3>
              </div>

              <div v-if="paymentHistory.length > 1" class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Payment Date</label>
                <select v-model="selectedPaymentIndex"
                  class="w-full border border-gray-300 rounded-lg p-2 text-gray-700">
                  <option v-for="(payment, index) in paymentHistory" :key="index" :value="index">
                    {{ payment.paymentDate }}
                  </option>
                </select>
              </div>

              <!-- Payment Info -->
              <div v-for="(image, index) in receiptImages" :key="index">
                <label class="block text-sm font-medium text-gray-700 mb-2">Proof of Payment</label>
                <div @click="openImageModal(image)"
                  class="relative group rounded-xl overflow-hidden border-2 border-gray-300 bg-gray-50 aspect-video cursor-pointer">
                  <img v-if="currentPayment?.proofOfPayment" :src="`/storage/${image}`" alt="Payment Proof"
                    class="w-full h-full object-cover" />
                  <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                    No Image
                  </div>
                  <div
                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                    <div
                      class="text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                      <svg class="w-12 h-12 text-white mx-auto mb-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                      <p class="text-white font-semibold text-sm">
                        Click to view full size
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-5">
                <label class="block text-sm font-medium text-gray-700">
                  Type of Payment: {{ currentPayment?.paymentType }}
                </label>
                <label class="block text-sm font-medium text-gray-700">
                  Mode Of Payment: {{ currentPayment?.modeOfPayment }}
                </label>
                <label class="block text-sm font-medium text-gray-700">
                  Remaining Balance: ₱{{ currentPayment?.remainingBalance }}
                </label>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Remarks (Optional)</label>
              <textarea v-model="remarks" rows="4" placeholder="Add your comments here..."
                class="w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-2 focus:ring-[#217093]/20 outline-none transition-all p-4 resize-none"></textarea>
            </div>

            <div v-if="isDownPayment()">
              <div class="flex items-center mb-4">
                <input id="fullyVerified" type="checkbox" v-model="isFullyPaid"
                  class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                <label for="fullyVerified" class="ml-2 block text-sm text-gray-700">
                  I acknowledge that the amount has been fully paid.
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Actions -->
      <div v-if="isPaymentPending()">
        <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
          <div class="flex flex-wrap justify-center gap-4">
            ⚠️ No payment has been submitted yet by the user.
          </div>
        </div>
      </div>

      <div v-if="!isPaymentComplete() && !isPaymentRejected()">
        <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
          <div class="flex flex-wrap justify-center gap-4">
            <div v-if="!isDownPayment()">
              <button @click="submitVerificationOfPayment('Approved')"
                class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-600 to-green-700 px-8 py-3 text-white font-semibold hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Approve Payment
              </button>
            </div>

            <div v-else>
              <button @click="submitVerificationOfPayment('Down Payment Approved')"
                class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-600 to-green-700 px-8 py-3 text-white font-semibold hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Approve Down Payment
              </button>
            </div>

            <button @click="showRejectionModal = true"
              class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-500 to-red-600 px-8 py-3 text-white font-semibold hover:from-red-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Reject Payment
            </button>
            <button @click="$emit('close')"
              class="flex items-center gap-2 rounded-xl bg-gray-600 px-8 py-3 text-white font-semibold hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              Cancel
            </button>
          </div>
        </div>
      </div>

      <div v-else-if="isPaymentRejected()">
        <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
          <div class="flex flex-wrap justify-center gap-4">
            <button @click="showRejectionModalDetail = true"
              class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-3 text-white font-semibold hover:from-blue-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              View Rejected Reason
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <RejectionModal :reason="rejectionReason" :category="rejectionCategory" :date="rejectionDate"
    :visible="showRejectionModalDetail" @close="showRejectionModalDetail = false" />

  <!-- Image Modal for Full Size View -->
  <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0"
    enter-to-class="opacity-100" leave-active-class="transition-all duration-200 ease-in" leave-from-class="opacity-100"
    leave-to-class="opacity-0">
    <div v-if="showImageModal" @click="closeImageModal"
      class="fixed inset-0 z-[60] flex items-center justify-center bg-black/95 backdrop-blur-md p-4 cursor-zoom-out">
      <!-- Close Button -->
      <button @click="closeImageModal"
        class="absolute top-6 right-6 z-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full p-3 transition-all duration-200 hover:scale-110 active:scale-95 group"
        aria-label="Close">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <div
        class="absolute top-6 left-6 bg-white/10 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2 pointer-events-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Payment Proof
      </div>
      <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0"
        enter-to-class="opacity-100" leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-if="showImageModal" @click="closeImageModal"
          class="fixed inset-0 z-[60] flex items-center justify-center bg-black/95 backdrop-blur-md p-4 cursor-zoom-out">
          <button @click="closeImageModal"
            class="absolute top-6 right-6 z-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full p-3 transition-all duration-200 hover:scale-110 active:scale-95 group"
            aria-label="Close">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          <div
            class="absolute top-6 left-6 bg-white/10 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2 pointer-events-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Payment Proof
          </div>
          <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="showImageModal" @click.stop
              class="relative w-full max-w-7xl h-[90vh] flex items-center justify-center cursor-default">
              <img v-if="imagePreview" :src="imagePreview" alt="Payment Proof Full Size"
                class="w-full h-full object-contain rounded-2xl shadow-2xl" />
              <div v-else class="text-white text-center">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p>No image available</p>
              </div>
              <a v-if="imagePreview" :href="imagePreview" download="payment-proof.png"
                class="absolute bottom-6 right-6 bg-[#217093] hover:bg-[#2a8bb5] text-white rounded-xl px-5 py-3 font-semibold transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download
              </a>
            </div>
          </Transition>
          <div
            class="absolute bottom-8 left-1/2 transform -translate-x-1/2 bg-white/10 backdrop-blur-sm text-white/80 px-4 py-2 rounded-full text-xs pointer-events-none">
            Click outside to close
          </div>
        </div>
      </Transition>
      <div
        class="absolute bottom-8 left-1/2 transform -translate-x-1/2 bg-white/10 backdrop-blur-sm text-white/80 px-4 py-2 rounded-full text-xs pointer-events-none">
        Click outside to close
      </div>
    </div>
  </Transition>

  <!-- Reject Confirmation Modal -->
  <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0"
    enter-to-class="opacity-100" leave-active-class="transition-all duration-200 ease-in" leave-from-class="opacity-100"
    leave-to-class="opacity-0">
    <div v-if="showRejectionModal"
      class="fixed inset-0 z-[70] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
      <Transition enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="opacity-0 scale-95 translate-y-4" enter-to-class="opacity-100 scale-100 translate-y-0"
        leave-active-class="transition-all duration-200 ease-in" leave-from-class="opacity-100 scale-100 translate-y-0"
        leave-to-class="opacity-0 scale-95 translate-y-4">
        <div v-if="showRejectionModal" @click.stop class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
          <!-- Icon -->
          <div class="flex justify-center mb-4">
            <div class="bg-red-100 rounded-full p-3">
              <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
          </div>

          <!-- Title -->
          <h3 class="text-xl font-bold text-gray-900 text-center mb-2">
            Reject Payment
          </h3>
          <p class="text-gray-600 text-center mb-6">
            Please provide the reason and category for rejecting this payment.
          </p>

          <form @submit.prevent="confirmReject" class="space-y-4">
            <div class="relative">
              <button type="button" @click="showCategoryDropdown = !showCategoryDropdown"
                class="w-full flex justify-between items-center rounded-xl border-2 border-gray-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 px-4 py-2 outline-none text-gray-700 transition-all">
                <span>{{ rejectionCategory || 'Select Rejection Category' }}</span>
                <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': showCategoryDropdown }"
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>

              <transition enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95">
                <div v-if="showCategoryDropdown"
                  class="absolute z-10 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                  <button v-for="(category, index) in rejectionCategories" :key="index" type="button" @click="
                    rejectionCategory = category;
                  showCategoryDropdown = false;
                  " class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                    {{ category }}
                  </button>
                </div>
              </transition>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Rejection Reason <span
                  class="text-red-500">*</span></label>
              <textarea v-model="rejectionReason" rows="4" placeholder="Enter reason"
                class="w-full rounded-xl border-2 border-gray-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 px-4 py-2 outline-none resize-none"
                required></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 mt-4">
              <button type="button" @click="cancelReject"
                class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-200 hover:scale-105 active:scale-95">
                Cancel
              </button>
              <button @click="submitVerificationOfPayment('Rejected')"
                class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-xl transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg">
                Reject
              </button>
            </div>
          </form>
        </div>
      </Transition>
    </div>
  </Transition>

  <!-- Official Payment Receipt Modal -->
  <div v-if="showReceipt" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
    <div id="receipt-content" class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
      <!-- Header with Logo -->
      <div class="flex items-center justify-between p-6 border-b">
        <div class="flex items-center gap-3">
          <img src="/storage/logo/Logo.png" alt="JE Travel & Tours" class="w-16 h-16 object-contain" />
          <div>
            <h3 class="text-sm font-semibold text-gray-600">
              JE TRAVEL & TOURS
            </h3>
            <p class="text-xs text-gray-400">Adventure Awaits</p>
          </div>
        </div>
        <button @click="closeReceipt" class="text-gray-400 hover:text-gray-600 transition">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Receipt Content -->
      <div class="p-8">
        <div class="text-center mb-6">
          <h2 class="text-2xl font-bold text-gray-800 mb-1">
            OFFICIAL PAYMENT RECEIPT
          </h2>
          <p class="text-sm text-gray-600">
            Receipt No: {{ receiptData.receiptNo }}
          </p>
          <p class="text-sm text-gray-600">Date: {{ receiptData.date }}</p>
        </div>

        <hr class="border-gray-300 mb-6" />

        <!-- Customer Information & Payment Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <!-- Customer Information -->
          <div>
            <h3 class="font-bold text-gray-800 mb-3">Customer Information</h3>
            <div class="space-y-1 text-sm">
              <p>
                <span class="text-gray-600">Name:</span>
                <span class="font-medium">{{ receiptData.customerName }}</span>
              </p>
              <p>
                <span class="text-gray-600">Email:</span>
                <span class="font-medium">{{ receiptData.customerEmail }}</span>
              </p>
              <p>
                <span class="text-gray-600">Phone No:</span>
                <span class="font-medium">{{ receiptData.customerPhone }}</span>
              </p>
            </div>
          </div>

          <!-- Payment Details -->
          <div>
            <h3 class="font-bold text-gray-800 mb-3">Payment Details</h3>
            <div class="space-y-1 text-sm">
              <p>
                <span class="text-gray-600">Payment Via:</span>
                <span class="font-medium">{{ receiptData.paymentVia }}</span>
              </p>
              <p>
                <span class="text-gray-600">Quantity:</span>
                <span class="font-medium">{{ receiptData.quantity }}</span>
              </p>
              <p>
                <span class="text-gray-600">Type of Payment:</span>
                <span class="font-medium">{{ receiptData.paymentType }}</span>
              </p>
            </div>
          </div>
        </div>

        <!-- Booking Details -->
        <div class="mb-6">
          <h3 class="font-bold text-gray-800 mb-3">Booking Details</h3>
          <div class="space-y-1 text-sm">
            <p>
              <span class="text-gray-600">Tour Classification:</span>
              <span class="font-medium">{{
                receiptData.tourClassification
                }}</span>
            </p>
            <p>
              <span class="text-gray-600">Package:</span>
              <span class="font-medium">{{ receiptData.package }}</span>
            </p>
            <p>
              <span class="text-gray-600">Duration:</span>
              <span class="font-medium">{{ receiptData.duration }}</span>
            </p>
            <p>
              <span class="text-gray-600">Booking Type:</span>
              <span class="font-medium">{{ receiptData.bookingType }}</span>
            </p>
            <p>
              <span class="text-gray-600">Destination:</span>
              <span class="font-medium">{{ receiptData.destination }}</span>
            </p>
            <p>
              <span class="text-gray-600">Travel Date:</span>
              <span class="font-medium">{{ receiptData.travelDate }}</span>
            </p>
          </div>
        </div>

        <!-- Total Amount -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span class="font-bold text-gray-800">Total Amount:</span>
              <span class="font-bold text-gray-800">₱ {{ receiptData.totalAmount }}</span>
            </div>
            <div class="flex justify-between">
              <span class="font-bold text-gray-800">Amount Paid:</span>
              <span class="font-bold text-green-600">₱ {{ receiptData.amountPaid }}</span>
            </div>
            <div class="flex justify-between">
              <span class="font-bold text-gray-800">Remaining Balance:</span>
              <span class="font-bold text-red-600">₱ {{ receiptData.remainingBalance }}</span>
            </div>
          </div>
        </div>

        <hr class="border-gray-300 mb-6" />

        <!-- Authorized By -->
        <div class="mb-6">
          <p class="font-bold text-gray-800 mb-3">Authorized by:</p>
          <div class="text-center">
            <img src="/storage/Signature/Signature.png" alt="Signature" class="w-32 h-20 object-contain mx-auto mb-1" />
            <p class="font-semibold text-gray-800 italic">Admin Name</p>
            <p class="text-sm text-gray-600 italic">Position</p>
          </div>
        </div>

        <hr class="border-gray-300 mb-6" />

        <!-- Footer -->
        <div class="text-center text-sm text-gray-600">
          <p class="font-medium mb-1">
            Thank you for booking with JE Travel & Tours!
          </p>
          <p>
            For more inquiries, contact us at
            <a href="mailto:contactus@jetravelandtours.com"
              class="text-blue-600 hover:underline">contactus@jetravelandtours.com</a>
          </p>
        </div>
      </div>

      <!-- Action Buttons -->
      <div id="receipt-buttons" class="flex justify-center gap-4 p-6 border-t bg-gray-50">
        <button @click="closeReceipt"
          class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition">
          Close
        </button>
        <button @click="downloadReceipt"
          class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
          Download Receipt
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import { useToast } from "vue-toastification";
import RejectionModal from "./PaymentRejectionDetail.vue";

const emit = defineEmits(["close"]);

const props = defineProps({
  payment: Object,
});

const showReceipt = ref(false);
const remarks = ref("");
const isFullyPaid = ref(null);
const paymentMethod = ref("GCash");
const showImageModal = ref(false);
const showRejectionModal = ref(false);
const showRejectionModalDetail = ref(false);
const paymentData = ref({});
const receiptData = ref({});
const imagePreview = ref(null);
const toast = useToast();
let typeOfPayment = ref("");
let paymentStatus = ref("");
const rejectionDate = ref(null);
const rejectionCategory = ref(null);
const rejectionReason = ref(null);
const paymentHistory = ref([]);
const showCategoryDropdown = ref(false);
const selectedPaymentIndex = ref(0);
const currentPayment = computed(
  () => paymentHistory.value[selectedPaymentIndex.value]
);
const totalDownPayment = computed(() =>
  paymentHistory.value.reduce(
    (sum, payment) => sum + (payment.downPaymentAmount || 0),
    0
  )
);

const fetchPaymentAndBooking = async (id) => {
  try {
    const response = await axios.get(`/api/payments/${id}`);
    const data = response.data.data;

    // Assign defaults safely
    paymentData.value = {
      payment_id: data.payment_id || null,
      booking_id: data.booking_id || null,
      customer_id: data.customer_id || null,
      total_price: data.total_price || 0,
      payment_history: data.payment_history || {},
      remarks: data.remarks || "",
      image_path: data.receipt || "",
      payment_status: data.payment_status || "",
      created_at: data.created_at || null,
      updated_at: data.updated_at || null,
      type_of_payment: data.type_of_payment || "",
      rejection_reason: data.rejection_reason || "",
      rejection_category: data.rejection_category || "",
      rejected_at: data.rejected_at || "",
      booking: {
        customer_name: data.booking?.customer_name || "",
        customer_email: data.booking?.customer_email || "",
        customer_phone: data.booking?.customer_phone || "",
        package_destination: data.booking?.package_destination || "",
        tour_type: data.booking?.tour_type || "",
        duration: data.booking?.duration || "",
        start_date: data.booking?.start_date || "",
        end_date: data.booking?.end_date || "",
        total_quantity: data.booking?.total_quantity || 0,
        total_price: data.booking?.total_price || 0,
      },
    };
    paymentHistory.value = data.payment_history || [];
    typeOfPayment.value = paymentData.value.type_of_payment || "";
    paymentStatus.value = paymentData.value.payment_status || "";
    (rejectionDate.value = paymentData.value.rejected_at || ""),
      (rejectionCategory.value = paymentData.value.rejection_category || ""),
      (rejectionReason.value = paymentData.value.rejection_reason || "");

    receiptData.value = {
      receiptNo: `2025-${paymentData.value?.payment_id || "N/A"}`,
      date: new Date().toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
      }),
      customerName: paymentData.value?.booking?.customer_name || "",
      customerEmail: paymentData.value?.booking?.customer_email || "",
      customerPhone: paymentData.value?.booking?.customer_phone || "",
      paymentVia: paymentMethod.value,
      quantity: paymentData.value?.booking?.total_quantity || 0,
      paymentType: "Downpayment",
      tourClassification: paymentData.value?.booking?.tour_type || "",
      package: paymentData.value?.booking?.package_destination || "",
      duration: paymentData.value?.booking?.duration || "",
      bookingType: "Exclusive",
      destination: paymentData.value?.booking?.package_destination || "",
      travelDate: paymentData.value?.booking?.start_date
        ? new Date(paymentData.value.booking.start_date).toLocaleDateString(
          "en-US"
        )
        : "",
      totalAmount: paymentData.value?.booking?.total_price || 0,
      amountPaid: paymentData.value?.total_price || 0,
      remainingBalance:
        (paymentData.value?.booking?.total_price || 0) -
        (paymentData.value?.total_price || 0),
    };

    imagePreview.value = paymentData.value.image_path
      ? `/storage/${JSON.parse(paymentData.value.image_path)[0]}`
      : null;
  } catch (error) {
    console.error("Error fetching payment:", error);
    alert("Failed to fetch payment data.");
    emit("close");
  }
};

const approvePayment = () => {
  receiptData.value.paymentVia = paymentMethod.value;
  showReceipt.value = true;
};

const rejectionCategories = [
  "Insufficient Payment",
  "Invalid Receipt",
  "Payment Pending/Overdue",
  "Other"
];

const confirmReject = () => {
  showRejectionModal.value = false;
  emit("close");
};

const cancelReject = () => {
  showRejectionModal.value = false;
};

const closeReceipt = () => {
  showReceipt.value = false;
};

const openImageModal = () => {
  showImageModal.value = true;
};

const closeImageModal = () => {
  showImageModal.value = false;
};

const isDownPayment = () => {
  return typeOfPayment.value === "Down Payment";
};

const isPaymentComplete = () => {
  return (
    paymentStatus.value === "Approved" || paymentStatus.value === "Pending"
  );
};

const isPaymentRejected = () => {
  return paymentStatus.value === "Rejected";
};

const isPaymentPending = () => {
  return paymentStatus.value === "Pending";
};

const downloadReceipt = async () => {
  const receiptElement = document.getElementById("receipt-content");

  if (!receiptElement) {
    alert("Receipt element not found");
    return;
  }

  const buttons = document.getElementById("receipt-buttons");
  if (buttons) buttons.style.display = "none";

  const originalMaxHeight = receiptElement.style.maxHeight;
  const originalOverflow = receiptElement.style.overflow;
  receiptElement.style.maxHeight = "none";
  receiptElement.style.overflow = "visible";

  try {
    await new Promise((resolve) => setTimeout(resolve, 500));

    const canvas = await html2canvas(receiptElement, {
      scale: 2.5,
      useCORS: false,
      allowTaint: true,
      logging: false,
      backgroundColor: "#ffffff",
      windowHeight: receiptElement.scrollHeight,
      height: receiptElement.scrollHeight,
      imageTimeout: 0,
      removeContainer: true,
      ignoreElements: (element) => {
        if (
          element.id === "close-button" ||
          element.classList.contains("print:hidden")
        ) {
          return true;
        }
        if (element.tagName === "IMG" && element.naturalHeight === 0) {
          return true;
        }
        return false;
      },
    });

    const imgData = canvas.toDataURL("image/png", 1.0);
    const pdf = new jsPDF({
      orientation: "portrait",
      unit: "mm",
      format: "a4",
      compress: true,
    });

    const pdfWidth = 210;
    const pdfHeight = 297;
    const imgWidth = pdfWidth - 20;
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    const xOffset = 10;
    const yOffset = 10;

    if (imgHeight <= pdfHeight - 20) {
      pdf.addImage(
        imgData,
        "PNG",
        xOffset,
        yOffset,
        imgWidth,
        imgHeight,
        undefined,
        "FAST"
      );
    } else {
      const scaledHeight = pdfHeight - 20;
      const scaledWidth = (canvas.width * scaledHeight) / canvas.height;
      const centeredX = (pdfWidth - scaledWidth) / 2;
      pdf.addImage(
        imgData,
        "PNG",
        centeredX,
        yOffset,
        scaledWidth,
        scaledHeight,
        undefined,
        "FAST"
      );
    }

    pdf.save(`Payment_Receipt_${receiptData.value.receiptNo}.pdf`);
  } catch (error) {
    console.error("Error generating PDF:", error);
    alert("Failed to generate PDF. Please try again.");
  } finally {
    receiptElement.style.maxHeight = originalMaxHeight;
    receiptElement.style.overflow = originalOverflow;
    if (buttons) buttons.style.display = "flex";
  }
};

const receiptImages = computed(() => {
  if (!paymentData.value.image_path) return [];

  if (typeof paymentData.value.image_path === "string") {
    try {
      const parsed = JSON.parse(paymentData.value.image_path);
      return Array.isArray(parsed) ? parsed : [];
    } catch (e) {
      console.error(e);
      return [];
    }
  }

  return Array.isArray(props.booking.discount_images)
    ? props.booking.discount_images.slice(0, 4)
    : [];
});

async function submitVerificationOfPayment($status) {
  if (!isDownPayment()) {
    isFullyPaid.value = true;
  }

  const data = new FormData();
  data.append("remarks", remarks.value || "");
  data.append("payment_status", $status);
  data.append("is_fully_paid", isFullyPaid.value ? 1 : 0);

  if ($status === "Rejected") {
    data.append("rejection_category", rejectionCategory.value);
    data.append("rejection_reason", rejectionReason.value);
  }

  try {
    const response = await axios.post(
      `/api/payments/${props.payment.id}?_method=PUT`,
      data
    );

    if (response.status === 200) {
      toast.success(`Payment Successfully ${$status}!`);
      emit("close");
    }
  } catch (error) {
    if (error.response && error.response.status === 422) {
      const errorMessage =
        error.response.data?.message ||
        "Transaction cancelled due to invalid booking quantity.";
      toast.error(errorMessage);
    } else {
      toast.error("Something went wrong while submitting your payment.");
      }
    }
}
onMounted(() => {
  if (props.payment?.id) {
    fetchPaymentAndBooking(props.payment.id);
  }
});
</script>
