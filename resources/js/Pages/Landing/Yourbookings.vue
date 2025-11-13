<template>
  <div class="min-h-screen w-full bg-[#f4f8fb]">
    <PaymentReceiptModal :isOpen="showReceiptModal" :receiptData="receiptData" @close="closeReceiptModal" />
    <div class="w-full bg-[#1E71B8] py-4 px-4 sm:px-8 shadow-sm">
      <h2 class="text-white text-2xl sm:text-3xl font-bold tracking-tight">My Bookings</h2>
    </div>
    <div class="flex flex-col lg:flex-row w-full lg:h-[calc(100vh-72px)]">
      <aside
        class="w-full lg:w-80 bg-white border-b lg:border-b-0 lg:border-r border-gray-100 lg:h-full py-6 lg:py-8 px-4 lg:px-4">
        <div class="mb-6 lg:mb-8 px-2">
          <h3 class="text-gray-900 text-sm font-semibold uppercase tracking-wider mb-4">
            Filter Bookings
          </h3>
          <div class="relative">
            <button @click="isFilterOpen = !isFilterOpen"
              class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 group">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                  viewBox="0 0 24 24">
                  <path
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                  </path>
                </svg>
                <span class="font-semibold text-gray-800">
                  {{
                    selectedStatusFilter === "All"
                      ? "All Status"
                      : selectedStatusFilter
                  }}
                </span>
              </div>
              <svg :class="[
                'w-5 h-5 text-blue-600 transition-transform duration-300',
                isFilterOpen ? 'rotate-180' : '',
              ]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
              </svg>
            </button>

            <div v-if="isFilterOpen"
              class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden animate-in fade-in slide-in-from-top-2">
              <div v-for="status in uniqueStatuses" :key="status" @click="
                selectedStatusFilter = status;
              isFilterOpen = false;
              " :class="[
                'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                selectedStatusFilter === status
                  ? 'bg-blue-50 border-l-4 border-l-blue-500'
                  : '',
              ]">
                <span :class="[
                  'font-medium',
                  selectedStatusFilter === status
                    ? 'text-blue-700'
                    : 'text-gray-700',
                ]">
                  {{ status === "All" ? "All Status" : status }}
                </span>

                <svg v-if="selectedStatusFilter === status" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor"
                  viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <h3 class="text-gray-700 text-lg font-semibold mb-4 px-2">
          All Bookings
        </h3>
        <div class="flex flex-col gap-2 overflow-y-auto" :style="{ maxHeight: 'calc(100vh - 300px)' }">
          <div v-if="filteredBookings.length" v-for="(booking, i) in filteredBookings" :key="`booking-${i}`"
            @click="handleBookingClick(i, booking)" :class="[
              'cursor-pointer transition-all flex flex-row items-center gap-3 rounded-lg px-4 py-3 group border',
              i === selectedBookingIndex
                ? 'bg-blue-50/80 border-blue-300 ring-2 ring-blue-200'
                : 'hover:bg-gray-50 border-transparent',
            ]">
            <div class="flex-grow min-w-0">
              <div class="font-semibold tracking-tight truncate text-sm sm:text-base">
                {{ booking.package_destination }} Tour
              </div>
              <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mt-1">
                <span class="flex items-center gap-1 font-medium text-gray-700">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                    <path
                      d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                    <path fill-rule="evenodd"
                      d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                      clip-rule="evenodd" />
                  </svg>
                  {{
                    new Date(booking.start_date).toLocaleDateString("en-PH", {
                      year: "numeric",
                      month: "short",
                      day: "numeric",
                    })
                  }}
                </span>
                <span class="flex items-center gap-1 font-medium text-gray-700">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                    <path
                      d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                  </svg>
                  {{ booking.total_quantity }}
                </span>
              </div>
              <div class="flex items-center gap-2 mt-2 flex-wrap">
                <span class="rounded px-2 py-0.5 text-xs font-semibold transition" :class="{
                  'bg-green-100 text-green-700':
                    booking.status === 'Approved',
                  'bg-yellow-100 text-yellow-700':
                    booking.status === 'Pending',
                  'bg-red-100 text-red-600': booking.status === 'Rejected',
                }">{{ booking.status }}</span>
                <span v-if="booking.tour_type" class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">{{
                  booking.tour_type }}</span>
              </div>
            </div>
            <span class="font-mono text-xs text-blue-500 flex-shrink-0">B{{ String(booking.id).padStart(5, "0")
            }}</span>
          </div>
          <div v-else class="flex items-center justify-center py-12 text-gray-400 text-base">
            No bookings found.
          </div>
        </div>
      </aside>

      <main class="flex-1 flex justify-center items-start py-6 lg:py-10 overflow-auto px-4 sm:px-6 lg:px-0">
        <div v-if="filteredBookings.length"
          class="bg-white rounded-2xl lg:rounded-3xl shadow-lg w-full max-w-5xl px-4 sm:px-6 lg:px-8 py-6">
          <div
            class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 lg:mb-7 border-b pb-4 lg:pb-5 border-gray-100">
            <div class="w-full">
              <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2 leading-tight">
                {{
                  filteredBookings[selectedBookingIndex].package_destination
                }}
                Tour
              </div>
              <div class="flex flex-wrap gap-2 sm:gap-4 mb-2 text-gray-500 text-sm">
                <div class="flex items-center gap-1 font-normal">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path
                      d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                    <path fill-rule="evenodd"
                      d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="font-medium text-gray-700">
                    {{
                      new Date(
                        filteredBookings[selectedBookingIndex].start_date
                      ).toLocaleDateString("en-PH", {
                        year: "numeric",
                        month: "short",
                        day: "numeric",
                      })
                    }}
                    -
                    {{
                      new Date(
                        filteredBookings[selectedBookingIndex].end_date
                      ).toLocaleDateString("en-PH", {
                        year: "numeric",
                        month: "short",
                        day: "numeric",
                      })
                    }}
                  </span>
                </div>
                <div class="flex items-center gap-1 font-medium text-gray-700">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path
                      d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                  </svg>
                  {{ filteredBookings[selectedBookingIndex].total_quantity }}
                </div>
              </div>
              <div class="flex flex-wrap gap-2 sm:gap-4 text-xs sm:text-sm font-normal">
                <div>
                  Booking Type:
                  <span class="font-medium text-gray-700">{{
                    filteredBookings[selectedBookingIndex].tour_type
                  }}</span>
                </div>
                <div>
                  Booked:
                  <span class="font-medium text-gray-700">{{
                    new Date(
                      filteredBookings[selectedBookingIndex].created_at
                    ).toLocaleDateString("en-PH", {
                      year: "numeric",
                      month: "short",
                      day: "numeric",
                    })
                  }}</span>
                </div>
              </div>
            </div>
            <span class="text-sm font-mono text-blue-500 font-semibold mt-3 lg:mt-0">B{{
              String(filteredBookings[selectedBookingIndex].id).padStart(
                5,
                "0"
              )
            }}</span>
          </div>

          <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-8 mb-6 lg:mb-7">
            <div class="flex flex-col">
              <span class="text-gray-500 text-xs sm:text-sm font-normal">Booking Status</span>
              <span class="text-xs sm:text-sm px-2 sm:px-3 py-1 rounded-full font-semibold w-fit mt-1 transition-all"
                :class="[
                  filteredBookings[selectedBookingIndex].status === 'Approved'
                    ? 'bg-green-400 text-white'
                    : filteredBookings[selectedBookingIndex].status === 'reject'
                      ? 'bg-red-400 text-white'
                      : 'bg-yellow-400 text-white',
                ]">
                {{ filteredBookings[selectedBookingIndex].status }}
              </span>
            </div>
            <div class="flex flex-col">
              <span class="text-gray-500 text-xs sm:text-sm font-normal">Guests</span>
              <span class="font-medium text-gray-800 mt-1">{{
                filteredBookings[selectedBookingIndex].total_quantity
              }}</span>
            </div>
            <div class="flex flex-col">
              <span class="text-gray-500 text-xs sm:text-sm font-normal">Total Due</span>
              <span class="text-base sm:text-lg font-bold text-green-600 mt-1">
                ₱{{
                  Number(
                    filteredBookings[selectedBookingIndex].total_price
                  ).toLocaleString("en-PH")
                }}
              </span>
            </div>
            <div class="flex flex-col">
              <span class="text-gray-500 text-xs sm:text-sm font-normal">Payment Status</span>
              <span class="text-xs sm:text-sm px-2 sm:px-3 py-1 rounded-full font-semibold w-fit mt-1 transition-all"
                :class="{
                  'bg-yellow-400 text-white': paymentStatus === 'Pending',
                  'bg-green-400 text-white': paymentStatus === 'Approved',
                  'bg-blue-400 text-white':
                    paymentStatus === 'Down Payment Approved',
                  'bg-red-400 text-white': paymentStatus === 'Rejected',
                }">
                {{ paymentStatus }}
              </span>
            </div>
          </div>

          <div v-if="filteredBookings[selectedBookingIndex].remarks" class="mb-6">
            <span class="text-gray-500 block mb-2 text-xs sm:text-sm font-normal">Remarks</span>
            <span
              class="bg-gray-50 rounded px-3 sm:px-4 py-2 text-gray-700 text-xs sm:text-sm font-medium inline-block">
              {{ _.startCase(filteredBookings[selectedBookingIndex].remarks) }}
            </span>
          </div>

          <div class="mt-6 mb-2 border-t border-gray-200 pt-6">
            <h4 class="font-semibold text-base sm:text-lg text-gray-700 mb-4 text-center">
              Payment
            </h4>
            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start mb-6">
              <div class="w-full lg:w-2/3 flex flex-col gap-4 lg:gap-5 justify-start">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                  <div>
                    <label class="block mb-2 sm:mb-3 text-gray-700 font-semibold text-xs sm:text-sm tracking-wide"
                      for="modeOfPayment">Mode of Payment</label>
                    <div class="relative mode-payment-dropdown">
                      <button @click="toggleModeDropdown"
                        class="w-full flex justify-between items-center px-3 sm:px-4 py-2 sm:py-3.5 bg-white border-2 border-gray-200 rounded-xl shadow-sm text-gray-800 font-medium text-sm sm:text-base hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-200 transition-all">
                        {{ selectedModeOfPayment }}
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 transition-transform duration-200"
                          :class="{ 'rotate-180': dropdownOpenModePayment }" fill="none" stroke="currentColor"
                          stroke-width="2" viewBox="0 0 24 24">
                          <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                      </button>
                      <div v-if="dropdownOpenModePayment"
                        class="absolute z-10 w-full mt-1 bg-white border-2 border-gray-200 rounded-xl shadow-lg overflow-hidden">
                        <div v-for="option in modeOfPaymentOptions" :key="option.value"
                          @click="selectOptionModePayment(option)"
                          class="px-4 py-2 sm:py-3 cursor-pointer hover:bg-blue-100 hover:text-blue-700 transition-colors text-sm sm:text-base">
                          {{ option.label }}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <label class="block mb-2 sm:mb-3 text-gray-700 font-semibold text-xs sm:text-sm tracking-wide"
                      for="paymentType">Type of Payment</label>
                    <div class="relative type-payment-dropdown">
                      <button @click="toggleTypeDropdown"
                        class="w-full flex justify-between items-center px-3 sm:px-4 py-2 sm:py-3.5 bg-white border-2 border-gray-200 rounded-xl shadow-sm text-gray-800 font-medium text-sm sm:text-base hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-200 transition-all">
                        {{ selectedPaymentType }}
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 transition-transform duration-200"
                          :class="{ 'rotate-180': dropdownOpenTypePayment }" fill="none" stroke="currentColor"
                          stroke-width="2" viewBox="0 0 24 24">
                          <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                      </button>

                      <div v-if="dropdownOpenTypePayment"
                        class="absolute z-10 w-full mt-1 bg-white border-2 border-gray-200 rounded-xl shadow-lg overflow-hidden">
                        <div v-for="option in paymentTypeOptions" :key="option.value"
                          @click="selectOptionTypePayment(option)"
                          class="px-4 py-2 sm:py-3 cursor-pointer hover:bg-blue-100 hover:text-blue-700 transition-colors text-sm sm:text-base">
                          {{ option.label }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div v-if="selectedPaymentType === 'Full Payment'"
                  class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-3 sm:p-5 shadow-sm">
                  <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                      <div class="bg-green-100 p-2 sm:p-2.5 rounded-lg flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor"
                          stroke-width="2" viewBox="0 0 24 24">
                          <path
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                          </path>
                        </svg>
                      </div>
                      <div>
                        <span class="text-gray-600 text-xs sm:text-sm font-normal block">Amount to Pay</span>
                        <span class="text-lg sm:text-2xl font-bold text-green-700">
                          ₱{{
                            Number(
                              filteredBookings[selectedBookingIndex]
                                ?.total_price || 0
                            ).toLocaleString("en-PH")
                          }}
                        </span>
                      </div>
                    </div>
                    <div class="bg-green-500 text-white px-2 sm:px-3 py-1 rounded-full text-xs font-bold flex-shrink-0">
                      FULL
                    </div>
                  </div>
                </div>

                <div v-else-if="selectedPaymentType === 'Down Payment'" class="space-y-3">
                  <div
                    class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-3 sm:p-4 shadow-sm">
                    <label class="flex items-center gap-2 text-gray-700 font-semibold text-xs sm:text-sm mb-2 sm:mb-3"
                      for="downPaymentAmount">
                      <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path
                          d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                      </svg>
                      Enter Down Payment Amount
                    </label>
                    <div class="relative">
                      <span
                        class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-base sm:text-lg">₱</span>
                      <input id="downPaymentAmount" v-model.number="formData.downPaymentAmount" type="number" min="0"
                        class="w-full rounded-xl border-2 border-gray-200 pl-8 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-3.5 bg-white text-gray-800 font-semibold text-base sm:text-lg focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-blue-300 hover:shadow-md shadow-sm"
                        placeholder="0.00" />
                    </div>
                    <div class="text-red-500 text-[0.6rem] sm:text-sm mt-2">
                      "Please note: A minimum down payment of 20% to 50% is required."
                    </div>
                  </div>
                  <div class="flex items-center justify-between text-xs sm:text-sm px-2">
                    <span class="text-gray-600 font-normal">Total Amount:</span>
                    <span class="font-semibold text-gray-800">₱{{
                      Number(
                        filteredBookings[selectedBookingIndex]?.total_price ||
                        0
                      ).toLocaleString("en-PH")
                    }}</span>
                  </div>
                </div>

                <div>
                  <label class="block mb-2 text-gray-700 font-semibold text-xs sm:text-sm">Upload Payment
                    Receipt:</label>
                  <!-- Image Preview with Fullscreen -->
                  <div v-if="paymentStatus === 'Under Review' || paymentStatus === 'Approved'" class="flex items-center gap-3 sm:gap-4 mb-4 flex-wrap">
                    <div
                      class="flex items-center bg-white px-2 sm:px-3 py-2 rounded shadow border border-green-200 bg-green-50 cursor-pointer hover:shadow-lg transition-shadow"
                      @click="openFullscreenImage(proofOfPaymentUrl)">
                      <img v-if="proofOfPaymentUrl" :src="proofOfPaymentUrl" alt="Proof of Payment"
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded object-cover border hover:opacity-80 transition-opacity" />
                      <div v-else
                        class="w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center bg-gray-100 rounded">
                        <span class="text-xs text-gray-500">No image</span>
                      </div>
                      <div class="ml-3 flex-1">
                        <p class="text-xs font-semibold text-green-700">Proof Submitted</p>
                        <p class="text-xs text-gray-600">Waiting for verification</p>
                      </div>
                    </div>
                  </div>

                  <div v-else class="flex items-center gap-3 sm:gap-4 mb-4 flex-wrap">
                    <label v-if="!selectedFile" :class="[
                      'flex items-center px-3 sm:px-4 py-2 rounded-lg border shadow-sm transition text-xs sm:text-sm',
                      filteredBookings[selectedBookingIndex]?.status === 'Pending' ||
                        filteredBookings[selectedBookingIndex]?.status === 'Rejected' ||
                        paymentStatus === 'Under Review'
                        ? 'bg-gray-200 text-gray-400 border-gray-300 cursor-not-allowed'
                        : 'bg-blue-50 text-blue-700 border-blue-100 hover:bg-blue-200 cursor-pointer',
                    ]">
                      <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M12 16v-4m0 0V8m0 4h4m-4 0H8m12 4v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4"></path>
                      </svg>
                      <span>Add Image</span>
                      <input type="file" class="hidden" @change="onFileChange" :disabled="filteredBookings[selectedBookingIndex]?.status === 'Pending' ||
                        filteredBookings[selectedBookingIndex]?.status === 'Rejected' ||
                        paymentStatus === 'Under Review'" />
                    </label>

                    <div v-else :class="[
                      'flex items-center bg-white px-2 sm:px-3 py-2 rounded shadow border cursor-pointer hover:shadow-lg transition-shadow',
                      paymentStatus === 'Under Review'
                        ? 'cursor-not-allowed opacity-60'
                        : '',
                    ]" @click="paymentStatus !== 'Under Review' ? openFullscreenImage(previewUrl) : null">
                      <img :src="previewUrl" alt="Preview"
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded object-cover border hover:opacity-80 transition-opacity" />
                      <input ref="fileInput" type="file" class="hidden" @change="onFileChange" :disabled="filteredBookings[selectedBookingIndex]?.status === 'Pending' ||
                        filteredBookings[selectedBookingIndex]?.status === 'Rejected' ||
                        paymentStatus === 'Under Review'" />
                    </div>
                  </div>

                  <!-- Fullscreen Image Modal -->
                  <Transition enter-active-class="transition-opacity duration-300" enter-from-class="opacity-0"
                    enter-to-class="opacity-100" leave-active-class="transition-opacity duration-200"
                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <div v-if="showFullscreenImage"
                      class="fixed inset-0 z-[80] bg-black/90 backdrop-blur-sm flex items-center justify-center p-4"
                      @click="closeFullscreenImage">
                      <button @click.stop="closeFullscreenImage"
                        class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                      </button>

                      <img :src="fullscreenImageUrl" alt="Fullscreen Preview"
                        class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" @click.stop />
                    </div>
                  </Transition>
                </div>
              </div>

              <div class="w-full lg:w-1/3 flex flex-col justify-center items-center h-fit">
                <div class="font-semibold text-gray-800 text-center text-base sm:text-lg">
                  Dorie Magjobos
                </div>
                <div class="text-gray-500 text-center text-sm sm:text-base font-normal mb-3">
                  xxxx xxx 1200
                </div>
                <img src="/storage/qr-payment/qr.png" alt="QR Payment"
                  class="w-36 h-36 sm:w-48 sm:h-48 bg-white border-2 border-gray-200 rounded-lg object-contain mb-2 shadow-sm flex-shrink-0" />
                <div class="text-xs sm:text-sm text-gray-500 mt-2 text-center font-normal">
                  Scan this QR code to pay
                </div>
              </div>
            </div>

            <div class="flex justify-center w-full">
              <div class="flex flex-col items-center gap-3 sm:gap-4 mt-6 sm:mt-8 mb-2 relative group w-full max-w-xs">
                <div v-if="statusMessage" class="flex justify-center w-full">
                  <div
                    class="bg-yellow-50 border border-yellow-300 text-yellow-700 px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-sm text-center w-full text-xs sm:text-sm"
                  >
                    <span class="font-semibold block">{{ statusMessage }}</span>
                  </div>
                </div>

                <div v-if="paymentStatus === 'Cancelled' && isBookingStatusCancelled" class="flex justify-center w-full">
                  <div
                    class="bg-red-50 border border-red-300 text-red-700 px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-sm text-center w-full text-xs sm:text-sm">
                      <span class="font-semibold block">Booking has been Cancelled</span>
                  </div>
                </div>

                <button v-if="
                  filteredBookings[selectedBookingIndex]?.status ===
                  'Approved' && paymentStatus === 'Pending'
                " :disabled="!selectedFile" @click="submitProofOfPayment()"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-semibold text-sm sm:text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  Send For Approval
                </button>

                <button v-if="
                  paymentStatus === 'Down Payment Approved' && !isFullyPaid()
                " :disabled="!selectedFile" @click="submitProofOfPayment()"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-semibold text-sm sm:text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  Complete Down Payment
                </button>

                <button v-if="
                  paymentStatus === 'Under Review' && isBookingStatusPending()
                " @click="submitPayment" :disabled="filteredBookings[selectedBookingIndex]?.status === 'Pending'
                  "
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-semibold text-sm sm:text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  Submit
                </button>

                <button v-if="
                  paymentStatus === 'Pending' &&
                  !filteredBookings[selectedBookingIndex]?.rejected_at &&
                  !isPaymentRejected()" 
                  @click="cancelBooking()" 
                  class="w-full bg-white hover:bg-red-50 text-red-500 border border-red-400 px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-semibold text-sm sm:text-lg transition shadow-md focus:outline-none focus:ring-2 focus:ring-red-100 active:scale-95 duration-150">
                  Cancel Booking
                </button>

                <button v-if="isFullyPaid()" @click="viewReceipt"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-semibold text-sm sm:text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  View Receipt
                </button>

                <button v-if="
                  filteredBookings[selectedBookingIndex]?.rejected_at &&
                  (isPaymentRejected() || isBookingRejected())
                " @click="showRejectionModal = true"
                  class="w-full bg-[#1E71B8] hover:bg-[#155a8a] focus:ring-2 focus:ring-[#52c2f8] transition shadow-lg text-white px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-semibold text-sm sm:text-lg focus:outline-none active:scale-95 duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                  View Rejection Reason
                </button>
              </div>
            </div>
          </div>
        </div>
        <div v-else class="flex items-center justify-center h-96 text-gray-400 text-base sm:text-lg">
          No bookings found.
        </div>

        <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100" leave-active-class="transition-all duration-200 ease-in"
          leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
          <div v-if="showRejectionModal"
            class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
              <div class="bg-gradient-to-r from-red-500 to-red-600 px-4 sm:px-6 py-4 sm:py-6">
                <div class="flex items-center gap-3">
                  <div class="p-2 sm:p-3 bg-white/20 rounded-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4v2m0 0v2m0-6v-2m0 0v-2" />
                    </svg>
                  </div>
                  <h3 class="text-lg sm:text-xl font-bold text-white">Booking Rejected</h3>
                </div>
              </div>

              <div class="px-4 sm:px-6 py-4 sm:py-6 space-y-4">
                <div class="block text-xs sm:text-sm font-semibold text-slate-700 mb-3 text-right">
                  {{
                    filteredBookings[selectedBookingIndex]?.rejected_at
                      ? new Date(
                        filteredBookings[selectedBookingIndex].rejected_at
                      ).toLocaleDateString("en-US", {
                        month: "short",
                        day: "numeric",
                        year: "numeric",
                      })
                      : ""
                  }}
                </div>

                <div>
                  <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-3">
                    Rejection Category
                  </label>
                  <div class="block text-xs sm:text-sm font-normal text-slate-700 mb-1 pl-4">
                    -
                    {{
                      filteredBookings[selectedBookingIndex]?.rejection_category
                    }}
                  </div>
                </div>

                <hr />
                <label class="block text-xs sm:text-sm font-semibold text-slate-700">
                  Reason:
                </label>
                <textarea
                  class="w-full rounded-xl border-2 border-gray-300 p-2 sm:p-3 text-xs sm:text-sm text-slate-700 resize-none bg-gray-100 font-normal"
                  :value="filteredBookings[selectedBookingIndex]?.rejection_reason
                    " rows="4" readonly>
                </textarea>

                <div
                  class="bg-slate-50 py-3 sm:py-4 border-t border-slate-200 flex justify-end px-4 sm:px-6 -mx-4 sm:-mx-6 -mb-4 sm:-mb-6">
                  <button type="button" @click="showRejectionModal = false"
                    class="rounded-lg px-4 sm:px-6 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold bg-slate-200 text-slate-800 hover:bg-slate-300 transition-all">
                    Close
                  </button>
                </div>
              </div>
            </div>
          </div>
        </Transition>

        <RejectionModal :reason="rejectionReason" :category="rejectionCategory" :date="rejectionDate"
          :visible="showRejectionModal" @close="showRejectionModal = false" />
      </main>
    </div>
  </div>
  <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0"
    enter-to-class="opacity-100" leave-active-class="transition-all duration-200 ease-in" leave-from-class="opacity-100"
    leave-to-class="opacity-0">
    <div v-if="showSuccessAnimation" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
      @click="showSuccessAnimation = false"></div>
  </Transition>

  <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0 scale-95"
    enter-to-class="opacity-100 scale-100" leave-active-class="transition-all duration-200 ease-in"
    leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
    <div v-if="showSuccessAnimation"
      class="fixed inset-0 flex items-center justify-center pointer-events-none z-50 p-4">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden pointer-events-auto" @click.stop>
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-8">
          <div class="flex items-center justify-center mb-4">
            <div class="relative w-24 h-24">
              <div class="absolute inset-0 bg-white rounded-full animate-pulse"></div>
              <div class="absolute inset-0 flex items-center justify-center bg-white rounded-full">
                <svg class="w-12 h-12 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd" />
                </svg>
              </div>
            </div>
          </div>
          <h3 class="text-2xl font-bold text-white text-center">Payment Successful!</h3>
          <p class="text-green-50 text-center mt-2 text-sm">Your payment has been submitted for approval</p>
        </div>

        <div class="px-6 py-6 space-y-4">
          <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-green-800 text-sm font-medium text-center">
              ✓ Your booking confirmation will be sent to your email shortly
            </p>
          </div>

          <div class="space-y-3 text-sm">
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                  clip-rule="evenodd" />
              </svg>
              <span class="text-gray-700">Payment status updated to "Under Review"</span>
            </div>
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                  clip-rule="evenodd" />
              </svg>
              <span class="text-gray-700">Proof of payment received</span>
            </div>
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                  clip-rule="evenodd" />
              </svg>
              <span class="text-gray-700">Your booking is in queue for approval</span>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex justify-center">
          <button @click="showSuccessAnimation = false"
            class="px-8 py-2.5 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-all duration-300 active:scale-95">
            Close
          </button>
        </div>
      </div>
    </div>
  </Transition>
  <Footer></Footer>
</template>

<script setup>
import LandingIndex from "./LandingIndex.vue";
import PaymentReceiptModal from "./PaymentReceiptModal.vue";
import { fetchBookingsByUser, fetchPaymentsByBookingId } from "@/api/booking";
import {
  onMounted,
  onBeforeUnmount,
  ref,
  watch,
  computed,
  nextTick,
} from "vue";
import { usePage } from "@inertiajs/vue3";
import { toCamelCase } from "@/helper/helper";
import { useToast } from "vue-toastification";
import RejectionModal from "../Admin/components/PaymentRejectionDetail.vue";
import { _ } from "lodash";
import Footer from "./Footer.vue";

const user = usePage().props.auth.user;
const toast = useToast();
const bookings = ref([]);
const payments = ref([]);
const selectedBookingIndex = ref(0);
const selectedBookingId = ref(null);
const userId = user?.id;
const selectedPaymentType = ref("Full Payment");
const selectedModeOfPayment = ref("GCASH");
const selectedFile = ref(null);
const previewUrl = ref(null);
const showReceiptModal = ref(false);
const receiptData = ref({});
const selectedStatusFilter = ref("All");
const isFilterOpen = ref(false);
const dropdownOpenModePayment = ref(false);
const dropdownOpenTypePayment = ref(false);
const showRejectionModal = ref(false);
const rejectionDate = ref(null);
const rejectionCategory = ref(null);
const rejectionReason = ref(null);
const showSuccessAnimation = ref(false);
const showFullscreenImage = ref(false);
const fullscreenImageUrl = ref(null);

const modeOfPaymentOptions = [
  { label: "GCASH", value: "GCASH" },
  { label: "Pay Maya", value: "Pay Maya" },
  { label: "Bank", value: "Bank" },
];

const paymentTypeOptions = [
  { label: "Full Payment", value: "Full Payment" },
  { label: "Down Payment", value: "Down Payment" },
];

const formData = ref({
  paymentType: "",
  downPaymentAmount: 0,
  fullPaymentAmount: 0,
  remainingBalance: 0,
  paymentDate: "",
  proofOfPayment: null,
});

const openFullscreenImage = (imageUrl) => {
  if (imageUrl) {
    fullscreenImageUrl.value = imageUrl;
    showFullscreenImage.value = true;
  }
};

const closeFullscreenImage = () => {
  showFullscreenImage.value = false;
  fullscreenImageUrl.value = null;
};

const selectOptionModePayment = (option) => {
  selectedModeOfPayment.value = option.value;
  dropdownOpenModePayment.value = false;
};

const selectOptionTypePayment = (option) => {
  selectedPaymentType.value = option.value;
  dropdownOpenTypePayment.value = false;
};

const statusMessage = computed(() => {
  if (isBookingStatusCancelled()) return '';
  if (isBookingStatusPending && !paymentStatus) return '⏳ Booking Under Review';
  if (paymentStatus === 'Under Review') return '⏳ Payment Under Review';
  return '';
});


const filteredBookings = computed(() => {
  if (selectedStatusFilter.value === "All") {
    return bookings.value.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
  }
  return bookings.value.filter(
    (booking) => booking.status === selectedStatusFilter.value
  );
});

const uniqueStatuses = computed(() => {
  const statuses = new Set(bookings.value.map((b) => b.status));
  return ["All", ...Array.from(statuses)];
});

const onFileChange = (event) => {
  const file = event.target.files[0];
  selectedFile.value = file;
  previewUrl.value = file ? URL.createObjectURL(file) : null;
};

async function viewReceipt() {
  const currentBooking = filteredBookings.value[selectedBookingIndex.value];
   try {
    const response = await axios.get(`/api/receipts/${currentBooking.id}`);

    receiptData.value = response.data.data;
     
    showReceiptModal.value = true;

  } catch (error) {
    console.error(error);
    toast.error("Something went wrong while submitting your payment.");
  }

}

const submitPayment = () => {
  const currentBooking = filteredBookings.value[selectedBookingIndex.value];
  if (!currentBooking) {
    toast.error("No booking selected.");
    return;
  }

  toast.success("Payment submitted successfully!");
};

const closeReceiptModal = () => {
  showReceiptModal.value = false;
};

const isPaymentRejected = () => {
  if (!payments.value.length || !filteredBookings.value.length) return false;
  const currentBooking = filteredBookings.value[selectedBookingIndex.value];
  if (!currentBooking) return false;
  const currentPayment = payments.value.find(
    (p) => p.booking_id === currentBooking.id
  );

  if (currentPayment?.rejected_at) {
    rejectionDate.value = currentPayment?.rejected_at;
    rejectionCategory.value = currentPayment?.rejection_category;
    rejectionReason.value = currentPayment?.rejection_reason;
  }

  return currentPayment?.rejected_at;
};

const isBookingRejected = () => {
  if (!filteredBookings.value.length) return false;

  const currentBooking = filteredBookings.value[selectedBookingIndex.value];

  if (!currentBooking) return false;

  if (currentBooking.rejected_at) {
    rejectionDate.value = currentBooking.rejected_at;
    rejectionCategory.value = currentBooking.rejection_category;
    rejectionReason.value = currentBooking.rejection_reason;
    return true;
  }

  return false;
};

const proofOfPaymentUrl = computed(() => {
  if (!payments.value.length || !filteredBookings.value.length) return null;

  const currentBookingId = filteredBookings.value[selectedBookingIndex.value].id;
  const currentPayment = payments.value.find(p => p.booking_id === currentBookingId);

  if (!currentPayment?.proof_of_payment) return null;

  let proofArray;
  try {
    proofArray = JSON.parse(currentPayment.proof_of_payment);
  } catch (e) {
    proofArray = [currentPayment.proof_of_payment];
  }

  return proofArray?.[0] ? `/storage/${proofArray[0]}` : null;
});

onMounted(async () => {
  bookings.value = await fetchBookingsByUser(userId);

  if (filteredBookings.value.length) {
    payments.value = await fetchPaymentsByBookingId(
      filteredBookings.value[selectedBookingIndex.value].id
    );
  }
});

watch(selectedBookingIndex, async (newIndex) => {
  if (filteredBookings.value.length && filteredBookings.value[newIndex]) {
    const bookingId = filteredBookings.value[newIndex].id;
    payments.value = await fetchPaymentsByBookingId(bookingId);

    selectedFile.value = null;
    previewUrl.value = null;
  }
});

watch(selectedStatusFilter, async () => {
  selectedBookingIndex.value = 0;
  isFilterOpen.value = false;

  if (filteredBookings.value.length) {
    const bookingId = filteredBookings.value[0].id;
    payments.value = await fetchPaymentsByBookingId(bookingId);
  }
});

const paymentStatus = computed(() => {
  if (!payments.value.length || !filteredBookings.value.length);
  const currentBookingId =
    filteredBookings.value[selectedBookingIndex.value].id;
  const currentPayment = payments.value.find(
    (p) => p.booking_id === currentBookingId
  );
  return currentPayment ? currentPayment.payment_status : null;
});

const typeOfPayment = computed(() => {
  if (!payments.value.length || !filteredBookings.value.length) return "";

  const currentBookingId =
    filteredBookings.value[selectedBookingIndex.value].id;
  const currentPayment = payments.value.find(
    (p) => p.booking_id === currentBookingId
  );

  return currentPayment?.payment_history?.paymentType || "";
});

async function cancelBooking() {
  const currentBooking = filteredBookings.value[selectedBookingIndex.value];

  const data = new FormData();
  data.append("status", "Cancelled");

  try {
    const response = await axios.post(
      `/api/bookings/${currentBooking.id}?_method=PUT`,
      data
    );

    if (response.status === 200) {
      toast.success("Booking successfully cancelled!");
    }
    payments.value = await fetchPaymentsByBookingId(currentBooking.id);
  } catch (error) {
    console.error(error);
    toast.error("Something went wrong while submitting your payment.");
  }

}

async function submitProofOfPayment() {
  const currentBooking = filteredBookings.value[selectedBookingIndex.value];
  if (!currentBooking) return toast.error("No booking selected.");

  if (
    selectedPaymentType.value === "down" &&
    !formData.value.downPaymentAmount
  ) {
    return toast.error("Please enter a down payment amount.");
  }
  if (!selectedFile.value) {
    return toast.error("Please upload a proof of payment.");
  }

  const total = Number(currentBooking.total_price);
  const paidAmount =
    selectedPaymentType.value === "Full Payment"
      ? total
      : Number(formData.value.downPaymentAmount);
  const remaining = Math.max(total - paidAmount, 0);

  const payment_history = {
    paymentType: selectedPaymentType.value,
    fullPaymentAmount: selectedPaymentType.value === "Full Payment" ? total : 0,
    downPaymentAmount:
      selectedPaymentType.value === "Down Payment" ? paidAmount : 0,
    remainingBalance: remaining,
    paymentDate: new Date().toISOString().split("T")[0],
    proofOfPayment: selectedFile.value ? selectedFile.value.name : null,
    modeOfPayment: selectedModeOfPayment.value,
  };

  const data = new FormData();
  data.append("proof_of_payment", selectedFile.value);
  data.append("payment_history", JSON.stringify(payment_history));
  data.append("mode_of_payment", selectedModeOfPayment.value);
  data.append("payment_status", "Under Review");
  data.append("total_price", payment_history.remainingBalance);
  data.append("type_of_payment", selectedPaymentType.value);
  data.append("type", "payment_submission");

  try {
    const response = await axios.post(
      `/api/payments/${currentBooking.id}?_method=PUT`,
      data
    );

    if (response.status === 200) {
      showSuccessAnimation.value = true;

      setTimeout(() => {
        showSuccessAnimation.value = false;
      }, 10000);

      toast.success("Payment successfully submitted!");
      payments.value = await fetchPaymentsByBookingId(currentBooking.id);
    }
  } catch (error) {
    console.error(error);
    toast.error("Something went wrong while submitting your payment.");
  }
}

const toggleModeDropdown = async (event) => {
  event.stopPropagation();
  const wasOpen = dropdownOpenModePayment.value;
  closeAllDropdowns();
  await nextTick();
  dropdownOpenModePayment.value = !wasOpen;
};

const toggleTypeDropdown = async (event) => {
  event.stopPropagation();
  const wasOpen = dropdownOpenTypePayment.value;
  closeAllDropdowns();
  await nextTick();
  dropdownOpenTypePayment.value = !wasOpen;
};

const closeAllDropdowns = () => {
  dropdownOpenModePayment.value = false;
  dropdownOpenTypePayment.value = false;
};

const handleClickOutside = (event) => {
  const filterDropdown = document.querySelector(".filter-dropdown");
  const modeDropdown = document.querySelector(".mode-payment-dropdown");
  const typeDropdown = document.querySelector(".type-payment-dropdown");

  if (
    !filterDropdown?.contains(event.target) &&
    !modeDropdown?.contains(event.target) &&
    !typeDropdown?.contains(event.target)
  ) {
    closeAllDropdowns();
  }
};

const isFullyPaid = () => {
  if (!payments.value.length || !filteredBookings.value.length) return "";

  const currentBookingId =
    filteredBookings.value[selectedBookingIndex.value].id;
  const currentPayment = payments.value.find(
    (p) => p.booking_id === currentBookingId
  );

  return currentPayment?.is_fully_paid ?? "";
};

const isBookingStatusPending = () => {
  const currentBooking = filteredBookings.value[selectedBookingIndex.value];

  if (!currentBooking) return false;

  return currentBooking.status === "Pending";
};

const isBookingStatusCancelled = () => {
  const currentBooking = filteredBookings.value[selectedBookingIndex.value];

  if (!currentBooking) return false;

  return currentBooking.status === "Cancelled";
}

const handleBookingClick = (index) => {
  selectedBookingIndex.value = index;
};

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});

defineOptions({ layout: LandingIndex });
</script>
