<template>
  <div v-if="booking" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-md transition-opacity" @click="$emit('close')"></div>

    <div class="flex min-h-full items-center justify-center p-4">
      <div
        class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all sm:my-8 w-full max-w-7xl">
        <button type="button"
          class="absolute right-4 top-4 z-10 rounded-full p-2 text-white/80 hover:text-white hover:bg-white/20 transition-all"
          @click="$emit('close')">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <div class="bg-gradient-to-r from-[#217093] to-[#2a8bb5] px-8 py-8">
          <div class="flex items-start justify-between">
            <div>
              <h3 class="text-3xl font-bold text-white tracking-tight">Booking Details</h3>
              <p class="mt-2 text-white/80 text-sm">Review and manage booking information</p>
            </div>
          </div>
        </div>

        <div class="px-8 py-8 max-h-[calc(100vh-280px)] overflow-y-auto bg-gradient-to-br from-slate-50 to-white">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
              <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-5">
                  <div class="p-2.5 bg-gradient-to-br from-[#217093] to-[#2a8bb5] rounded-lg shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </div>
                  <h4 class="text-xl font-bold text-slate-800">Customer Information</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                  <div class="space-y-1.5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Full Name</p>
                    <p class="text-base font-semibold text-slate-900">{{ booking.customer_name }}</p>
                  </div>
                  <div class="space-y-1.5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Email Address</p>
                    <p class="text-base text-slate-700 break-all">{{ booking.customer_email ?? '—' }}</p>
                  </div>
                  <div class="space-y-1.5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Phone Number</p>
                    <p class="text-base text-slate-700">{{ booking.customer_phone ?? '—' }}</p>
                  </div>
                </div>
              </div>

              <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-5">
                  <div class="p-2.5 bg-gradient-to-br from-[#217093] to-[#2a8bb5] rounded-lg shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                  </div>
                  <h4 class="text-xl font-bold text-slate-800">Trip Details</h4>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                  <div class="space-y-1.5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Package</p>
                    <p class="text-base font-semibold text-slate-900">{{ booking.package_destination ?? '—' }}</p>
                  </div>
                  <div class="space-y-1.5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Duration</p>
                    <p class="text-base text-slate-700">{{ booking.duration ?? '—' }} Day/s</p>
                  </div>
                  <div class="space-y-1.5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tour Type</p>
                    <p class="text-base text-slate-700">{{ booking.tour_type ?? '—' }}</p>
                  </div>
                  <div class="space-y-1.5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Number of Pax</p>
                    <p class="text-base font-bold text-[#217093]">{{ booking.total_quantity }}</p>
                  </div>
                  <div class="space-y-1.5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Booking Date</p>
                    <p class="text-base text-slate-700">{{ formattedDate }}</p>
                  </div>
                  <div class="space-y-1.5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Travel Date</p>
                    <p class="text-base text-slate-700">{{ travelDate }}</p>
                  </div>
                </div>
              </div>
              <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-6">
                  <div class="p-2.5 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                    </svg>
                  </div>
                  <h4 class="text-xl font-bold text-slate-800">Itinerary</h4>
                </div>
                <div v-if="booking.itinerary && booking.itinerary.length" class="space-y-6">
                  <div v-for="(item, index) in booking.itinerary" :key="item.id"
                    class="p-5 bg-gradient-to-br from-slate-50 to-white border border-slate-200 rounded-xl hover:shadow-md transition-all">
                    <p class="text-2xl font-bold text-[#217093] mb-2 tracking-tight">
                      Day {{ index + 1 }}
                    </p>
                    <p class="text-slate-700 text-base leading-relaxed">
                      {{ item.content }}
                    </p>
                  </div>
                </div>
                <div v-else class="text-center py-10 bg-slate-50 rounded-lg border-2 border-dashed border-slate-200">
                  <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V7a2 2 0 012-2h5l2 2h5a2 2 0 012 2v11a2 2 0 01-2 2z" />
                  </svg>
                  <p class="text-slate-400 text-sm font-medium">No itinerary available for this booking</p>
                </div>
              </div>
              <div
                class="bg-gradient-to-br from-emerald-50 to-white rounded-xl p-6 border border-emerald-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                  <div class="p-2.5 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                  </div>
                  <h4 class="text-xl font-bold text-slate-800">Payment Information</h4>
                </div>
                <div class="flex items-baseline gap-3">
                  <p class="text-sm font-semibold text-slate-600">Total Amount</p>
                  <p class="text-3xl font-bold text-emerald-600">₱{{ booking.total_price?.toLocaleString() ?? '0' }}</p>
                </div>
              </div>
            </div>

            <div class="space-y-6">
              <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-5">
                  <div class="p-2.5 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                  </div>
                  <h4 class="text-xl font-bold text-slate-800">Discount ID</h4>
                </div>
                <div v-if="hasValidImages" class="grid grid-cols-2 gap-3">
                  <div v-for="(image, index) in discountImages" :key="index" class="relative group cursor-pointer"
                    @click="openImageModal(image)">
                    <div
                      class="aspect-[4/3] rounded-lg overflow-hidden bg-slate-100 border-2 border-slate-200 hover:border-amber-400 transition-all shadow-sm hover:shadow-md">
                      <img :src="`/storage/${image}`" :alt="`ID Preview ${index + 1}`" @error="handleImageError"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                    </div>
                    <div
                      class="absolute inset-0 bg-black/0 group-hover:bg-black/20 rounded-lg transition-colors flex items-center justify-center">
                      <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                    </div>
                  </div>
                </div>
                <div v-else-if="!props.booking.discount_images"
                  class="text-center py-10 bg-slate-50 rounded-lg border-2 border-dashed border-slate-200">
                  <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <p class="text-slate-400 text-sm font-medium">No Discount ID uploaded</p>
                </div>
                <div v-else class="text-center py-10 bg-slate-50 rounded-lg border-2 border-dashed border-slate-200">
                  <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <p class="text-slate-400 text-sm font-medium">Discount ID is missing or broken</p>
                </div>
              </div>

              <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <label class="flex items-center gap-3 mb-4">
                  <div class="p-2.5 bg-gradient-to-br from-slate-500 to-slate-600 rounded-lg shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </div>
                  <span class="text-xl font-bold text-slate-800">Remarks</span>
                </label>
                <textarea v-model="form.remarks" rows="6"
                  class="w-full rounded-lg border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none placeholder:text-slate-400"
                  placeholder="Add any notes or comments about this booking..."></textarea>
              </div>

              <!-- Approval/Rejection Info Card -->
              <div v-if="isApprovedOrRejected"
                :class="['rounded-xl p-6 border shadow-sm hover:shadow-md transition-shadow', statusBgClass]">
                <div class="flex items-center gap-3">
                  <div :class="['p-2.5 rounded-lg shadow-md', statusIconBgClass]">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path v-if="booking.status === 'Approved'" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M5 13l4 4L19 7" />
                      <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </div>
                  <div v-if="booking.status === 'Approved'">
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">
                      Approved by
                    </p>
                    <p class="text-base font-bold" :class="statusTextClass">{{ adminName }}</p>
                  </div>
                  <div v-else-if="booking.status === 'Rejected'">
                    <p class="text-sm font-semibold text-slate-600 uppercase tracking-wider">
                      Rejected by
                    </p>
                    <p class="text-base font-bold" :class="statusTextClass">{{ adminName }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-white px-8 py-5 border-t border-slate-200">
          <div class="flex justify-end gap-3">
            <button type="button"
              class="flex items-center gap-2 rounded-lg px-6 py-2.5 text-sm font-semibold bg-gray-600 text-white hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
              @click="$emit('close')">
              Cancel
            </button>
            <div class="relative group">
              <button type="button" @click="showRejectionModal = true" :disabled="isApprovedOrRejected" :class="[
                'flex items-center gap-2 rounded-lg px-6 py-2.5 text-sm font-semibold text-white shadow-lg transition-all',
                isApprovedOrRejected
                  ? 'bg-gray-400 cursor-not-allowed opacity-60'
                  : 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 hover:shadow-xl transform hover:-translate-y-0.5'
              ]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Reject Booking
              </button>
              <div v-if="isApprovedOrRejected"
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-slate-800 text-white text-xs rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 whitespace-nowrap pointer-events-none z-50">
                Booking already {{ booking.status.toLowerCase() }}
                <div
                  class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1 border-4 border-transparent border-t-slate-800">
                </div>
              </div>
            </div>
            <div class="relative group">
              <button type="button" @click="submitStatus('Approved')" :disabled="isApprovedOrRejected" :class="[
                'flex items-center gap-2 rounded-lg px-6 py-2.5 text-sm font-semibold text-white shadow-lg transition-all',
                isApprovedOrRejected
                  ? 'bg-gray-400 cursor-not-allowed opacity-60'
                  : 'bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 hover:shadow-xl transform hover:-translate-y-0.5'
              ]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Approve Booking
              </button>

              <div v-if="isApprovedOrRejected"
                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-slate-800 text-white text-xs rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 whitespace-nowrap pointer-events-none z-50">
                Booking already {{ booking.status.toLowerCase() }}
                <div
                  class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1 border-4 border-transparent border-t-slate-800">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Rejection Modal -->
    <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100" leave-active-class="transition-all duration-200 ease-in"
      leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
      <div v-if="showRejectionModal"
        class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
          <!-- Header -->
          <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-6">
            <div class="flex items-center gap-3">
              <div class="p-3 bg-white/20 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4v2m0 0v2m0-6v-2m0 0v-2" />
                </svg>
              </div>
              <h3 class="text-xl font-bold text-white">Reject Booking</h3>
            </div>
          </div>

          <!-- Body -->
          <div class="px-6 py-6 space-y-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-3">
                Rejection Category <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <button type="button" @click="isDropdownOpen = !isDropdownOpen" :class="[
                  'w-full px-5 py-4 text-left bg-white border-2 rounded-xl transition-all duration-200 text-sm font-medium',
                  rejectionCategory
                    ? 'border-red-500 text-slate-800'
                    : 'border-slate-200 text-slate-400',
                  isDropdownOpen ? 'ring-4 ring-red-500/10 border-red-500' : 'hover:border-slate-300'
                ]">
                  {{ rejectionCategory || 'Select a rejection reason' }}
                </button>
                <Transition enter-active-class="transition-all duration-200 ease-out"
                  enter-from-class="opacity-0 scale-95 -translate-y-2"
                  enter-to-class="opacity-100 scale-100 translate-y-0"
                  leave-active-class="transition-all duration-150 ease-in"
                  leave-from-class="opacity-100 scale-100 translate-y-0"
                  leave-to-class="opacity-0 scale-95 -translate-y-2">
                  <div v-if="isDropdownOpen">
                    <div class="fixed inset-0 z-10" @click="isDropdownOpen = false" />
                    <div
                      class="absolute z-20 w-full mt-2 bg-white rounded-xl shadow-2xl border border-slate-200 overflow-hidden">
                      <button v-for="(category, index) in rejectionCategories" :key="category" type="button"
                        @click="selectCategory(category)" :class="[
                          'w-full px-5 py-4 text-left text-sm font-medium transition-all duration-150',
                          rejectionCategory === category
                            ? 'bg-red-50 text-red-700'
                            : 'text-slate-700 hover:bg-slate-50',
                          index !== 0 ? 'border-t border-slate-100' : ''
                        ]">
                        {{ category }}
                      </button>
                    </div>
                  </div>
                </Transition>
              </div>
              <p v-if="!rejectionCategory" class="text-xs text-red-500 mt-3 font-medium">
                Please select a rejection category
              </p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">
                Additional Notes <span class="text-slate-400 font-normal">(Optional)</span>
              </label>
              <textarea v-model="rejectionReason" rows="5"
                class="w-full rounded-lg border-2 border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 px-4 py-3 text-sm outline-none transition-all resize-none placeholder:text-slate-400"
                placeholder="Add any additional details or notes about this rejection..."></textarea>
            </div>
          </div>

          <!-- Footer -->
          <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end gap-3">
            <button type="button" @click="showRejectionModal = false"
              class="rounded-lg px-6 py-2.5 text-sm font-semibold bg-slate-200 text-slate-800 hover:bg-slate-300 transition-all">
              Cancel
            </button>
            <button type="button" @click="submitRejection" :disabled="!rejectionCategory || isSubmitting"
              class="flex items-center gap-2 rounded-lg bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 disabled:from-red-400 disabled:to-red-500 disabled:cursor-not-allowed px-6 py-2.5 text-sm font-semibold text-white transition-all">
              <svg v-if="!isSubmitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <svg v-else class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 0116 0" />
              </svg>
              {{ isSubmitting ? 'Processing...' : 'Confirm Rejection' }}
            </button>
          </div>
        </div>
      </div>
    </Transition>

    <!-- Image Modal -->
    <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0"
      enter-to-class="opacity-100" leave-active-class="transition-all duration-200 ease-in"
      leave-from-class="opacity-100" leave-to-class="opacity-0">
      <div v-if="selectedImage" @click="closeImageModal"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/95 backdrop-blur-md p-4 cursor-zoom-out">
        <button @click="closeImageModal"
          class="absolute top-6 right-6 z-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full p-3 transition-all duration-200 hover:scale-110 active:scale-95"
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
          Discount ID
        </div>

        <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100" leave-active-class="transition-all duration-200 ease-in"
          leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
          <div v-if="selectedImage" @click.stop
            class="relative w-full max-w-7xl h-[90vh] flex items-center justify-center cursor-default">
            <img :src="`/storage/${selectedImage}`" alt="Discount ID Full Size"
              class="w-full h-full object-contain rounded-2xl shadow-2xl" />
          </div>
        </Transition>

        <div
          class="absolute bottom-8 left-1/2 transform -translate-x-1/2 bg-white/10 backdrop-blur-sm text-white/80 px-4 py-2 rounded-full text-xs pointer-events-none">
          Click outside to close
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { api } from '@/api/api'
import { useToast } from 'vue-toastification'
import { usePage } from '@inertiajs/vue3'

const page = usePage();
const toast = useToast();
const props = defineProps({ booking: Object })
const emit = defineEmits(['close', 'booking-updated'])
const service = new api()

const form = ref({
  id_type: props.booking.id_type ?? '',
  remarks: props.booking.remarks ?? ''
})

const showRejectionModal = ref(false)
const rejectionReason = ref('')
const rejectionCategory = ref('')
const isSubmitting = ref(false)
const isDropdownOpen = ref(false)
const selectedImage = ref(null)
const imageLoadErrors = ref([])
const users = ref();

const rejectionCategories = [
  'Incomplete/Invalid Information',
  'History of No-Shows or Late Cancellations',
  'Policy Violations',
  'Invalid Discount ID'
]

const selectCategory = (category) => {
  rejectionCategory.value = category
  isDropdownOpen.value = false
}

const handleImageError = (event) => {
  const imgSrc = event.target.src
  if (!imageLoadErrors.value.includes(imgSrc)) {
    imageLoadErrors.value.push(imgSrc)
  }
}

const formattedDate = computed(() => {
  const date = new Date(props.booking.created_at)
  return date.toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  })
})

const travelDate = computed(() => {
  const date = new Date(props.booking.travel_date ?? '')
  return isNaN(date) ? '—' : date.toLocaleDateString('en-US', {
    month: 'short',
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

  if (typeof props.booking.discount_images === 'string') {
    try {
      const parsed = JSON.parse(props.booking.discount_images)
      return Array.isArray(parsed) ? parsed : [props.booking.discount_images]
    } catch {
      return [props.booking.discount_images]
    }
  }

  return Array.isArray(props.booking.discount_images)
    ? props.booking.discount_images.slice(0, 4)
    : []
})

const hasValidImages = computed(() => {
  if (discountImages.value.length === 0) return false

  const allFailed = discountImages.value.every(img => {
    const fullPath = `/storage/${img}`
    const hasError = imageLoadErrors.value.some(errorSrc => errorSrc.includes(img))
    return hasError
  })

  return !allFailed
})

const hasImagesButBroken = computed(() => {
  return discountImages.value.length > 0 && !hasValidImages.value
})

const openImageModal = (image) => {
  selectedImage.value = image
}

const closeImageModal = () => {
  selectedImage.value = null
}

// Computed properties for approval/rejection info
const isApprovedOrRejected = computed(() => {
  return props.booking.status === 'Approved' || props.booking.status === 'Rejected'
})

const adminName = computed(() => {
  if (!users.value) return 'Unknown Admin';

  const userId = props.booking?.status === 'Approved'
    ? props.booking?.approved_by
    : props.booking?.rejected_by;

  if (!userId) return 'Unknown Admin';

  const user = users.value.find(user => user.id === userId);

  return user ? `${user.first_name} ${user.last_name}` : 'Unknown Admin';
})

const statusBgClass = computed(() => {
  if (props.booking.status === 'Approved') {
    return 'bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200'
  } else if (props.booking.status === 'Rejected') {
    return 'bg-gradient-to-br from-red-50 to-rose-50 border border-red-200'
  }
  return ''
})

const statusIconBgClass = computed(() => {
  if (props.booking.status === 'Approved') {
    return 'bg-gradient-to-br from-green-500 to-emerald-600'
  } else if (props.booking.status === 'Rejected') {
    return 'bg-gradient-to-br from-red-500 to-rose-600'
  }
  return ''
})

const statusTextClass = computed(() => {
  if (props.booking.status === 'Approved') {
    return 'text-green-700'
  } else if (props.booking.status === 'Rejected') {
    return 'text-red-700'
  }
  return 'text-slate-700'
})

const submitStatus = async (statusValue) => {
  try {
    const payload = {
      status: statusValue,
      id_type: form.value.id_type,
      remarks: form.value.remarks,
    }

    if (statusValue === 'Approved') {
      payload.approved_by = page.props.auth.user.id
    }

    await service.updateBooking(props.booking.id, payload)

    toast.success(`Booking ${statusValue}!`)
    emit('booking-updated')
    emit('close')
  } catch (error) {
    console.error('Error updating booking:', error)
    toast.error('Failed to update booking.')
  }
}

const submitRejection = async () => {
  if (!rejectionCategory.value) {
    toast.error('Please select a rejection category')
    return
  }

  isSubmitting.value = true
  try {
    await service.updateBooking(props.booking.id, {
      status: 'Rejected',
      id_type: form.value.id_type,
      remarks: form.value.remarks,
      rejection_category: rejectionCategory.value,
      rejection_reason: rejectionReason.value || null,
      rejected_by: page.props.auth.user.id
    })

    toast.success('Booking rejected!')
    showRejectionModal.value = false
    emit('booking-updated')
    emit('close')
  } catch (error) {
    console.error('Error rejecting booking:', error)
    toast.error('Failed to reject booking.')
  } finally {
    isSubmitting.value = false
  }
}

const loadUsers = async () => {
  const response = await service.getUsers();
  users.value = response?.data?.data;
};

onMounted(() => {
  loadUsers();
});
</script>