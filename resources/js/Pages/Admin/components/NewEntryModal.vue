<template>
  <div
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm animate-fadeIn"
  >
    <div
      class="relative bg-white rounded-3xl shadow-2xl w-full max-w-6xl mx-4 max-h-[95vh] overflow-hidden flex flex-col animate-slideUp"
    >
      <button
        class="absolute top-6 right-6 z-10 w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-red-500 hover:text-white transition-all duration-300 hover:rotate-90"
        @click="$emit('close')"
        aria-label="Close"
      >
        <svg
          class="w-5 h-5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>

      <div class="px-8 pt-8 pb-6">
        <h2
          class="text-center text-2xl font-bold bg-gradient-to-r from-[#1E71B8] to-[#73BE5D] bg-clip-text text-transparent mb-8"
        >
          {{ stepTitles[currentStep] }}
        </h2>

        <div class="flex items-center gap-3 mb-8 justify-center">
          <div
            v-for="(title, index) in stepTitles"
            :key="index"
            class="flex items-center gap-3"
          >
            <div class="relative">
              <div
                :class="[
                  'w-12 h-12 rounded-full flex items-center justify-center font-bold text-base transition-all duration-500 relative z-10',
                  currentStep >= index
                    ? 'bg-gradient-to-br from-[#1E71B8] to-[#73BE5D] text-white shadow-lg scale-110'
                    : 'bg-gray-200 text-gray-500 scale-100',
                ]"
              >
                <span v-if="currentStep > index" class="animate-checkmark"
                  >✓</span
                >
                <span v-else>{{ index + 1 }}</span>
              </div>
              <div
                v-if="currentStep >= index"
                class="absolute inset-0 rounded-full bg-gradient-to-br from-[#1E71B8] to-[#73BE5D] animate-ping opacity-20"
              ></div>
            </div>
            <div
              v-if="index < stepTitles.length - 1"
              :class="[
                'w-16 h-1 rounded-full transition-all duration-500',
                currentStep > index
                  ? 'bg-gradient-to-r from-[#1E71B8] to-[#73BE5D]'
                  : 'bg-gray-200',
              ]"
            ></div>
          </div>
        </div>
      </div>

      <div class="flex-1 overflow-y-auto px-8 pb-8">
        <div
          v-if="currentStep === 0"
          class="grid grid-cols-1 lg:grid-cols-2 gap-8"
        >
          <div class="space-y-6">
            <div class="group">
              <label
                class="block font-semibold mb-3 text-[#1E71B8] text-sm uppercase tracking-wide"
                >Customer Name</label
              >
              <input
                v-model="customerName"
                type="text"
                class="w-full rounded-2xl border-2 border-gray-200 px-5 py-4 focus:border-[#73BE5D] focus:ring-4 focus:ring-[#73BE5D]/10 outline-none transition-all duration-300 hover:border-[#1E71B8]"
                placeholder="Enter customer name"
              />
            </div>

            <div class="group">
              <label
                class="block font-semibold mb-3 text-[#1E71B8] text-sm uppercase tracking-wide"
                >Package Name</label
              >
              <div class="relative" ref="packageDropdownRef">
                <button
                  type="button"
                  @click="isPackageOpen = !isPackageOpen"
                  :class="[
                    'w-full flex items-center justify-between px-5 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#1E71B8]/10 transition-all duration-300 hover:shadow-md',
                    selectedPackage === ''
                      ? 'border-gray-200 text-gray-400'
                      : 'border-[#1E71B8] text-gray-900',
                  ]"
                >
                  <span class="font-semibold">{{
                    selectedPackage
                      ? packages.find((p) => p.id === selectedPackage)
                          ?.package_name
                      : "Select Package"
                  }}</span>
                  <svg
                    :class="[
                      'w-5 h-5 transition-transform duration-300',
                      isPackageOpen ? 'rotate-180' : '',
                    ]"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19 9l-7 7-7-7"
                    ></path>
                  </svg>
                </button>

                <div
                  v-if="isPackageOpen"
                  @click.stop
                  class="absolute top-full left-0 right-0 mt-2 bg-white border-2 border-gray-100 rounded-2xl shadow-2xl z-50 overflow-hidden max-h-72 overflow-y-auto animate-slideDown"
                >
                  <div
                    v-for="pkg in packages"
                    :key="pkg.id"
                    @click="handlePackageSelect(pkg.id)"
                    :class="[
                      'px-5 py-4 cursor-pointer transition-all duration-200 flex items-center gap-3',
                      selectedPackage === pkg.id
                        ? 'bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-l-[#1E71B8]'
                        : 'hover:bg-gray-50',
                    ]"
                  >
                    <span
                      :class="[
                        'font-medium',
                        selectedPackage === pkg.id
                          ? 'text-[#1E71B8]'
                          : 'text-gray-700',
                      ]"
                    >
                      {{ pkg.package_name || "Unknown" }}
                    </span>
                    <svg
                      v-if="selectedPackage === pkg.id"
                      class="w-5 h-5 text-[#1E71B8] ml-auto animate-checkmark"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div
            class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white rounded-3xl p-8 min-h-[300px] shadow-xl relative overflow-hidden"
          >
            <div
              class="absolute top-0 right-0 w-64 h-64 bg-[#1E71B8] rounded-full blur-3xl opacity-10"
            ></div>
            <div
              class="absolute bottom-0 left-0 w-64 h-64 bg-[#73BE5D] rounded-full blur-3xl opacity-10"
            ></div>
            <div class="relative z-10">
              <div
                class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2"
              >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                  <path
                    fill-rule="evenodd"
                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
                Package Preview
              </div>
              <div v-if="selectedPackageData.id" class="space-y-4">
                <div>
                  <div class="text-xs text-gray-400 mb-1">Package</div>
                  <div class="text-xl font-bold text-[#73BE5D]">
                    {{ selectedPackageData.package_name }}
                  </div>
                </div>
                <div>
                  <div class="text-xs text-gray-400 mb-1">Destination</div>
                  <div class="font-semibold">
                    {{ selectedPackageData.destination }}
                  </div>
                </div>
                <div
                  class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-700"
                >
                  <div>
                    <div class="text-xs text-gray-400 mb-1">Adult Rate</div>
                    <div class="text-lg font-bold text-white">
                      ₱{{ selectedPackageData.pax_rate }}
                    </div>
                  </div>
                  <div>
                    <div class="text-xs text-gray-400 mb-1">Kids Rate</div>
                    <div class="text-lg font-bold text-white">
                      ₱{{ selectedPackageData.kids_pax_rate }}
                    </div>
                  </div>
                </div>
              </div>
              <div v-else class="flex items-center justify-center h-full">
                <div class="text-center text-gray-500">
                  <svg
                    class="w-16 h-16 mx-auto mb-3 opacity-30"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                    ></path>
                  </svg>
                  <p class="text-sm">Select a package to see details</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="currentStep === 1" class="w-full">
          <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative z-50" ref="typeDropdownRef">
              <label
                class="block text-[#1E71B8] mb-3 font-semibold text-sm uppercase tracking-wide"
                >Tour Type</label
              >
              <button
                type="button"
                class="w-full border-2 border-gray-200 rounded-2xl px-5 py-4 bg-white text-left text-[#1E71B8] flex items-center justify-between hover:border-[#1E71B8] hover:shadow-md transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-[#1E71B8]/10"
                @click="
                  isTypeOpen = !isTypeOpen;
                  isClassOpen = false;
                "
              >
                <span class="font-semibold">{{ tourType }}</span>
                <svg
                  :class="[
                    'w-5 h-5 transition-transform duration-300',
                    isTypeOpen ? 'rotate-180' : '',
                  ]"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19 9l-7 7-7-7"
                  ></path>
                </svg>
              </button>
              <div
                v-if="isTypeOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border-2 border-gray-100 rounded-2xl shadow-2xl z-[100] overflow-hidden animate-slideDown max-h-60 overflow-y-auto"
              >
                <a
                  v-for="t in tourTypes"
                  :key="t"
                  href="#"
                  class="block px-5 py-3 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200"
                  :class="{
                    'bg-gradient-to-r from-blue-50 to-indigo-50 text-[#73BE5D] font-semibold border-l-4 border-[#73BE5D]':
                      t === tourType,
                  }"
                  @click.prevent="selectTourType(t)"
                >
                  <div class="flex items-center justify-between">
                    <span>{{ t }}</span>
                    <svg
                      v-if="t === tourType"
                      class="w-5 h-5 text-[#73BE5D] animate-checkmark"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </div>
                </a>
              </div>
            </div>
            <div class="relative z-50" ref="classDropdownRef">
              <label
                class="block text-[#1E71B8] mb-3 font-semibold text-sm uppercase tracking-wide"
                >Tour Classification</label
              >
              <button
                type="button"
                class="w-full border-2 border-gray-200 rounded-2xl px-5 py-4 bg-white text-left text-[#1E71B8] flex items-center justify-between hover:border-[#1E71B8] hover:shadow-md transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-[#1E71B8]/10"
                @click="
                  isClassOpen = !isClassOpen;
                  isTypeOpen = false;
                "
              >
                <span class="font-semibold">{{ tourClassification }}</span>
                <svg
                  :class="[
                    'w-5 h-5 transition-transform duration-300',
                    isClassOpen ? 'rotate-180' : '',
                  ]"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19 9l-7 7-7-7"
                  ></path>
                </svg>
              </button>
              <div
                v-if="isClassOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border-2 border-gray-100 rounded-2xl shadow-2xl z-[100] overflow-hidden animate-slideDown max-h-60 overflow-y-auto"
              >
                <a
                  v-for="c in tourClassifications"
                  :key="c"
                  href="#"
                  class="block px-5 py-3 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200"
                  :class="{
                    'bg-gradient-to-r from-blue-50 to-indigo-50 text-[#73BE5D] font-semibold border-l-4 border-[#73BE5D]':
                      c === tourClassification,
                  }"
                  @click.prevent="selectTourClassification(c)"
                >
                  <div class="flex items-center justify-between">
                    <span>{{ c }}</span>
                    <svg
                      v-if="c === tourClassification"
                      class="w-5 h-5 text-[#73BE5D] animate-checkmark"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </div>
                </a>
              </div>
            </div>
          </div>

          <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-48 flex-shrink-0">
              <div
                class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 shadow-sm"
              >
                <h3
                  class="text-sm font-bold text-[#1E71B8] mb-4 uppercase tracking-wide"
                >
                  Legends
                </h3>
                <div class="space-y-3">
                  <div class="flex items-center gap-3 group">
                    <span
                      class="w-4 h-4 rounded-full bg-[#d9d9d9] shadow-sm group-hover:scale-110 transition-transform"
                    ></span>
                    <span class="text-sm text-gray-700 font-medium"
                      >Closed</span
                    >
                  </div>
                  <div class="flex items-center gap-3 group">
                    <span
                      class="w-4 h-4 rounded-full bg-gray-800 shadow-sm group-hover:scale-110 transition-transform"
                    ></span>
                    <span class="text-sm text-gray-700 font-medium"
                      >Available</span
                    >
                  </div>
                  <div class="flex items-center gap-3 group">
                    <span
                      class="w-4 h-4 rounded-full bg-[#2f5f98] shadow-sm group-hover:scale-110 transition-transform"
                    ></span>
                    <span class="text-sm text-gray-700 font-medium"
                      >Slots Full</span
                    >
                  </div>
                  <div class="flex items-center gap-3 group">
                    <span
                      class="w-4 h-4 rounded-full bg-[#45a834] shadow-sm group-hover:scale-110 transition-transform"
                    ></span>
                    <span class="text-sm text-gray-700 font-medium"
                      >Accepting Joiners</span
                    >
                  </div>
                </div>
              </div>
            </div>

            <div class="flex-1">
              <div
                class="bg-white rounded-3xl p-8 shadow-xl border-2 border-gray-100 relative z-0"
              >
                <div
                  v-if="tourType === 'Exclusive'"
                  class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-[#1E71B8] p-4 rounded-xl"
                >
                  <div class="flex items-start gap-3">
                    <svg
                      class="w-5 h-5 text-[#1E71B8] flex-shrink-0 mt-0.5"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                    <div>
                      <p class="text-sm font-semibold text-[#1E71B8] mb-1">
                        Select date range
                      </p>
                      <p class="text-xs text-gray-600">
                        Click start date, then click end date to complete your
                        selection.
                      </p>
                    </div>
                  </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                  <button
                    @click="prevMonth"
                    class="w-10 h-10 rounded-xl border-2 text-[#1E71B8] border-[#1E71B8] hover:bg-[#1E71B8] hover:text-white transition-all duration-300 font-bold flex items-center justify-center hover:scale-110"
                  >
                    ‹
                  </button>
                  <div
                    class="text-xl font-bold text-[#1E71B8] uppercase tracking-wide"
                  >
                    {{ monthName }} {{ currentYear }}
                  </div>
                  <button
                    @click="nextMonth"
                    class="w-10 h-10 rounded-xl border-2 text-[#1E71B8] border-[#1E71B8] hover:bg-[#1E71B8] hover:text-white transition-all duration-300 font-bold flex items-center justify-center hover:scale-110"
                  >
                    ›
                  </button>
                </div>

                <div
                  class="grid grid-cols-7 gap-2 text-center text-sm font-bold text-[#1E71B8] mb-4"
                >
                  <div>Sun</div>
                  <div>Mon</div>
                  <div>Tue</div>
                  <div>Wed</div>
                  <div>Thu</div>
                  <div>Fri</div>
                  <div>Sat</div>
                </div>

                <div
                  class="grid grid-cols-7 gap-2 relative"
                  ref="calendarWrapperRef"
                >
                  <div
                    v-for="(cell, i) in calendarDays"
                    :key="i"
                    class="h-16 rounded-xl flex items-center justify-center select-none text-sm font-semibold transition-all duration-300 relative overflow-hidden"
                    :class="{
                      'bg-gradient-to-br from-[#73BE5D] to-[#5fa84d] text-white shadow-lg scale-105':
                        cell.isInRange && !cell.isPast,
                      'bg-gray-100 text-gray-400 cursor-not-allowed opacity-40':
                        !cell.day || cell.isPast,
                      'bg-[#d9d9d9] text-gray-700 cursor-pointer hover:scale-110 hover:shadow-md':
                        cell.day &&
                        cell.status === 'closed' &&
                        !cell.isPast &&
                        !cell.isInRange,
                      'bg-gradient-to-br from-[#45a834] to-[#3a8f2b] text-white cursor-pointer hover:scale-110 hover:shadow-lg':
                        cell.day &&
                        cell.status === 'accepting' &&
                        !cell.isPast &&
                        !cell.isInRange,
                      'bg-gradient-to-br from-[#2f5f98] to-[#254d7d] text-white cursor-pointer hover:scale-110 hover:shadow-lg':
                        cell.day &&
                        cell.status === 'full' &&
                        !cell.isPast &&
                        !cell.isInRange,
                      'text-black cursor-pointer hover:scale-110 hover:shadow-lg':
                        cell.day &&
                        cell.status === 'available' &&
                        !cell.isPast &&
                        !cell.isInRange,
                    }"
                    @click="handleDateClick($event, cell)"
                  >
                    <span v-if="cell.day">{{ cell.day }}</span>
                    <div
                      v-if="cell.isInRange && !cell.isPast"
                      class="absolute inset-0 bg-white/10 animate-pulse"
                    ></div>
                  </div>

                  <div
                    v-if="isTooltipOpen"
                    ref="tooltipRef"
                    class="rounded-2xl border-2 border-[#1E71B8] shadow-2xl bg-white z-50"
                    :style="{
                      position: 'absolute',
                      left: tooltipX + 'px',
                      top: tooltipY + 'px',
                      width: '340px',
                    }"
                    @click.stop
                  >
                    <div class="px-5 pt-5 pb-4">
                      <div class="flex items-start justify-between mb-3">
                        <div class="text-[#1E71B8] font-bold text-lg">
                          {{ tooltipData.title }}
                        </div>
                        <button
                          class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-red-500 hover:text-white transition-all duration-300 font-bold"
                          @click="closeTooltip"
                        >
                          ×
                        </button>
                      </div>
                      <div
                        class="h-1 w-full bg-gradient-to-r from-[#1E71B8] to-[#73BE5D] rounded-full mb-4"
                      ></div>
                      <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                          <span class="font-semibold text-[#1E71B8]"
                            >Date:</span
                          >
                          <span class="text-gray-700">{{
                            tooltipData.date
                          }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-semibold text-[#1E71B8]"
                            >Slots Booked:</span
                          >
                          <span class="text-gray-700"
                            >{{ tooltipData.slotsBooked }} /
                            {{ tooltipData.slotsTotal }}</span
                          >
                        </div>
                        <div class="flex justify-between">
                          <span class="font-semibold text-[#1E71B8]"
                            >Status:</span
                          >
                          <span class="text-gray-700">{{
                            tooltipData.status
                          }}</span>
                        </div>
                        <div class="flex justify-between">
                          <span class="font-semibold text-[#1E71B8]"
                            >Price:</span
                          >
                          <span class="text-gray-700">{{
                            tooltipData.price
                          }}</span>
                        </div>
                        <div
                          v-if="tourType === 'Joiners' && packageDuration > 1"
                          class="pt-2 border-t border-gray-200"
                        >
                          <div class="flex justify-between">
                            <span class="font-semibold text-[#1E71B8]"
                              >Duration:</span
                            >
                            <span class="text-gray-700"
                              >{{ packageDuration }} days</span
                            >
                          </div>
                        </div>
                        <div
                          v-if="
                            tourType === 'Exclusive' &&
                            selectedDate &&
                            selectedEndDate
                          "
                          class="pt-2 border-t border-gray-200"
                        >
                          <div
                            class="text-xs text-[#1E71B8] font-semibold mb-1"
                          >
                            Selected Range:
                          </div>
                          <div class="text-xs text-gray-600">
                            {{ formatHuman(selectedDate) }} -
                            {{ formatHuman(selectedEndDate) }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          v-if="currentStep === 2"
          class="grid grid-cols-1 lg:grid-cols-2 gap-8"
        >
          <div class="space-y-6">
            <div
              class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 shadow-sm"
            >
              <div class="flex justify-between items-center mb-4">
                <span
                  class="text-sm font-bold text-[#1E71B8] uppercase tracking-wide"
                  >Travellers</span
                >
                <span
                  class="text-sm font-bold text-[#1E71B8] uppercase tracking-wide"
                  >Rate</span
                >
                <span
                  class="text-sm font-bold text-[#1E71B8] uppercase tracking-wide"
                  >Quantity</span
                >
              </div>

              <p class="text-xs text-gray-500 mb-3">*Age around 13 and above</p>
              <div
                class="bg-gradient-to-r from-[#1E71B8] to-[#2980c9] rounded-2xl px-6 py-5 mb-6 shadow-lg"
              >
                <div class="flex items-center justify-between">
                  <div class="text-white font-semibold text-lg">Adults</div>
                  <div class="text-white font-semibold text-lg">
                    ₱ {{ selectedPackageData.pax_rate }}
                  </div>
                  <div class="flex items-center gap-2">
                    <button
                      @click="pax > 1 && pax--"
                      class="w-9 h-9 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center hover:bg-gray-100 hover:scale-110 transition-all duration-300 shadow-md"
                    >
                      -
                    </button>
                    <input
                      type="text"
                      :value="pax"
                      class="w-16 h-9 rounded-xl text-center border-2 border-white/20 bg-white/10 text-white font-bold backdrop-blur-sm"
                      readonly
                    />
                    <button
                      @click="pax++"
                      class="w-9 h-9 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center hover:bg-gray-100 hover:scale-110 transition-all duration-300 shadow-md"
                    >
                      +
                    </button>
                  </div>
                </div>
              </div>

              <p class="text-xs text-gray-500 mb-3">*Age around 2-12</p>
              <div
                class="bg-gradient-to-r from-[#1E71B8] to-[#2980c9] rounded-2xl px-6 py-5 shadow-lg"
              >
                <div class="flex items-center justify-between">
                  <div class="text-white font-semibold text-lg">Kids</div>
                  <div class="text-white font-semibold text-lg">
                    ₱ {{ selectedPackageData.kids_pax_rate }}
                  </div>
                  <div class="flex items-center gap-2">
                    <button
                      @click="kidsPax > 1 && kidsPax--"
                      class="w-9 h-9 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center hover:bg-gray-100 hover:scale-110 transition-all duration-300 shadow-md"
                    >
                      -
                    </button>
                    <input
                      type="text"
                      :value="kidsPax"
                      class="w-16 h-9 rounded-xl text-center border-2 border-white/20 bg-white/10 text-white font-bold backdrop-blur-sm"
                      readonly
                    />
                    <button
                      @click="kidsPax++"
                      class="w-9 h-9 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center hover:bg-gray-100 hover:scale-110 transition-all duration-300 shadow-md"
                    >
                      +
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <label
                class="block font-semibold mb-3 text-[#1E71B8] text-sm uppercase tracking-wide"
                >Remarks</label
              >
              <textarea
                v-model="remarks"
                placeholder="Extra baggage, include infants etc."
                class="w-full h-24 px-4 py-3 bg-white text-gray-800 placeholder-gray-400 rounded-2xl border-2 border-gray-200 resize-none focus:outline-none focus:ring-4 focus:ring-[#1E71B8]/10 focus:border-[#1E71B8] transition-all duration-300 hover:border-gray-300"
              ></textarea>
            </div>

            <div>
              <label
                class="block font-semibold mb-3 text-[#1E71B8] text-sm uppercase tracking-wide"
                >Discount ID Images</label
              >
              <div class="space-y-3">
                <div
                  v-if="discountImages.length > 0"
                  class="grid grid-cols-3 gap-3"
                >
                  <div
                    v-for="image in discountImages"
                    :key="image.id"
                    class="relative group"
                  >
                    <img
                      :src="image.preview"
                      :alt="image.name"
                      class="w-full h-20 object-cover rounded-xl border-2 border-gray-200 group-hover:border-[#1E71B8] transition-all duration-300"
                    />
                    <button
                      @click="removeImage(image.id)"
                      class="absolute -top-2 -right-2 w-7 h-7 bg-red-500 text-white rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg hover:bg-red-600 hover:scale-110"
                    >
                      ×
                    </button>
                  </div>
                </div>
                <button
                  @click="triggerFileInput"
                  :disabled="discountImages.length >= 3"
                  class="w-full py-3 px-4 bg-gradient-to-r from-blue-50 to-indigo-50 text-[#1E71B8] text-sm font-semibold rounded-2xl border-2 border-dashed border-[#1E71B8] hover:border-[#73BE5D] hover:from-green-50 hover:to-emerald-50 hover:text-[#73BE5D] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:border-[#1E71B8] disabled:hover:from-blue-50 disabled:hover:to-indigo-50"
                >
                  <div class="flex items-center justify-center gap-2">
                    <svg
                      class="w-5 h-5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                      />
                    </svg>
                    <span>{{
                      discountImages.length >= 3
                        ? "Maximum 3 Images"
                        : "Add Image"
                    }}</span>
                  </div>
                </button>
                <input
                  id="discount-image-upload"
                  type="file"
                  multiple
                  accept="image/*"
                  @change="handleImageUpload"
                  class="hidden"
                />
              </div>
              <p class="text-gray-400 text-xs mt-2">
                * Maximum of 3 Discount ID Upload
              </p>
            </div>

            <div class="mt-6">
              <div class="flex w-full mb-6 items-center justify-between">
                <h2 class="text-2xl font-bold text-[#1E71B8] tracking-tight">
                  Itinerary
                </h2>

                <div v-if="isExclusiveTour" class="flex items-center gap-3">
                  <button
                    @click="toggleCustomize"
                    class="px-5 py-2.5 rounded-xl text-white font-medium transition-all duration-300"
                    :class="
                      isEditingItinerary
                        ? 'bg-[#73BE5D] hover:bg-[#5AA449]'
                        : 'bg-[#1E71B8] hover:bg-[#155E9C]'
                    "
                  >
                    {{
                      isEditingItinerary ? "Save Customization" : "Customize"
                    }}
                  </button>

                  <div
                    v-if="isEditingItinerary"
                    class="relative group flex items-center gap-3"
                  >
                    <button
                      @click="addNewDay"
                      :disabled="editableItinerary.length >= durationDays"
                      class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-xl shadow-md bg-[#1E71B8] text-white transition-all duration-200 hover:bg-[#155E9C] disabled:bg-gray-300 disabled:text-gray-700 disabled:cursor-not-allowed"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 4v16m8-8H4"
                        />
                      </svg>
                      Add Day
                    </button>

                    <div
                      v-if="editableItinerary.length >= durationDays"
                      class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs px-3 py-1.5 rounded-lg shadow-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap"
                    >
                      {{
                        durationDays === 0
                          ? "Please select your start and end dates first."
                          : "You've reached the maximum number of days allowed by your booking."
                      }}
                    </div>
                  </div>
                </div>
              </div>

              <div
                v-if="itineraryDays.length === 0"
                class="w-full rounded-2xl border border-gray-200 bg-white p-6 text-center text-gray-500 italic shadow-sm"
              >
                No itinerary available yet.
              </div>

              <div v-else class="grid gap-6">
                <div
                  v-for="(day, index) in isEditingItinerary
                    ? editableItinerary
                    : itineraryDays"
                  :key="day.id"
                  class="w-full rounded-2xl bg-gradient-to-br from-white to-[#f9fcff] border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300"
                >
                  <div
                    class="px-6 py-4 border-b border-gray-100 bg-[#f8fbff] rounded-t-2xl flex justify-between items-center"
                  >
                    <h3
                      class="text-lg font-semibold text-[#1E71B8] tracking-wide"
                    >
                      Day {{ day.id }}
                    </h3>
                    <button
                      v-if="isEditingItinerary"
                      @click="removeDay(index)"
                      class="text-red-500 hover:text-red-600 text-sm font-semibold flex items-center gap-1 transition"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"
                        />
                      </svg>
                      Remove
                    </button>
                  </div>
                  <div
                    class="px-6 py-5 text-gray-700 leading-relaxed whitespace-pre-wrap text-[15px]"
                  >
                    <template v-if="isEditingItinerary">
                      <textarea
                        v-model="editableItinerary[index].content"
                        rows="5"
                        class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1E71B8]"
                      ></textarea>
                    </template>
                    <template v-else>
                      {{ day.content }}
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div
            class="bg-gradient-to-br from-[#1E71B8] via-[#2980c9] to-[#1E71B8] rounded-3xl p-8 flex flex-col justify-between min-h-[500px] shadow-2xl relative overflow-hidden"
          >
            <div
              class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl"
            ></div>
            <div
              class="absolute bottom-0 left-0 w-64 h-64 bg-[#73BE5D]/10 rounded-full blur-3xl"
            ></div>
            <div class="relative z-10 space-y-6">
              <div>
                <div class="text-2xl font-bold text-white mb-1">
                  {{ selectedPackageData.package_name }}
                </div>
                <div class="text-white/80 mb-4 flex items-center gap-2">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                  {{ selectedPackageData.destination }}
                </div>
              </div>

              <div
                class="space-y-3 bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20"
              >
                <div class="flex items-center gap-2 text-white/90">
                  <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                  </svg>
                  <span class="text-sm">Tour Type:</span>
                  <span class="font-semibold ml-auto">{{ tourType }}</span>
                </div>
                <div class="flex items-center gap-2 text-white/90">
                  <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                    ></path>
                  </svg>
                  <span class="text-sm">Classification:</span>
                  <span class="font-semibold ml-auto">{{
                    tourClassification
                  }}</span>
                </div>
                <div class="flex items-center gap-2 text-white/90">
                  <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    ></path>
                  </svg>
                  <span class="text-sm">Duration:</span>
                  <span class="font-semibold ml-auto"
                    >{{ durationDays }} Day<span v-if="durationDays !== 1"
                      >s</span
                    ></span
                  >
                </div>
                <div class="flex items-center gap-2 text-white/90">
                  <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    ></path>
                  </svg>
                  <span class="text-sm">Start Date:</span>
                  <span class="font-semibold ml-auto">{{ selectedDate }}</span>
                </div>
              </div>

              <div class="space-y-3">
                <div
                  class="text-white/80 text-sm font-semibold uppercase tracking-wide mb-2"
                >
                  Travellers Breakdown
                </div>
                <div class="flex justify-between items-center text-white/90">
                  <span class="text-sm"
                    >Adult ₱{{ selectedPackageData.pax_rate }} × {{ pax }}</span
                  >
                  <span class="font-bold text-lg">₱{{ adultTotalAmount }}</span>
                </div>
                <div class="flex justify-between items-center text-white/90">
                  <span class="text-sm"
                    >Kids ₱{{ selectedPackageData.kids_pax_rate }} ×
                    {{ kidsPax }}</span
                  >
                  <span class="font-bold text-lg">₱{{ kidsTotalAmount }}</span>
                </div>
              </div>

              <div
                class="h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"
              ></div>

              <div
                class="flex justify-between items-center bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20"
              >
                <span class="text-white font-bold text-xl">Total Amount</span>
                <span class="text-white font-bold text-3xl"
                  >₱{{ totalAmount }}</span
                >
              </div>
            </div>

            <button
              @click="submitBooking"
              class="relative z-10 w-full rounded-2xl py-4 font-bold text-lg transition-all duration-300 bg-[#73BE5D] text-white hover:bg-[#6aae56] hover:shadow-2xl hover:scale-105 active:scale-95 flex items-center justify-center gap-2 mt-6"
            >
              <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 13l4 4L19 7"
                ></path>
              </svg>
              Confirm Booking
            </button>
          </div>
        </div>
      </div>

      <div
        class="px-8 pb-8 flex justify-between items-center border-t border-gray-100 pt-6"
      >
        <button
          v-if="currentStep > 0"
          @click="prevStep"
          class="px-8 py-3 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 rounded-2xl font-semibold hover:from-gray-200 hover:to-gray-300 transition-all duration-300 hover:shadow-lg hover:scale-105 active:scale-95 flex items-center gap-2"
        >
          <svg
            class="w-5 h-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 19l-7-7 7-7"
            ></path>
          </svg>
          Back
        </button>
        <div v-else></div>
        <button
          v-if="currentStep < 2"
          @click="nextStep"
          class="px-8 py-3 bg-gradient-to-r from-[#1E71B8] to-[#2980c9] text-white rounded-2xl font-semibold hover:from-[#2980c9] hover:to-[#1E71B8] transition-all duration-300 hover:shadow-lg hover:scale-105 active:scale-95 flex items-center gap-2"
        >
          Next
          <svg
            class="w-5 h-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7 7"
            ></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, onBeforeUnmount, watch } from "vue";
import { api } from "../../../api/api";
import { useToast } from "vue-toastification";

const emit = defineEmits(["close", "booking-created"]);
const toast = useToast();
const service = new api();

const currentStep = ref(0);
const stepTitles = ["Booking Info", "Select Date", "Reservation Details"];
const packages = ref([]);
const selectedPackage = ref("");
const pax = ref(0);
const kidsPax = ref(0);
const customerName = ref("");
const voucherCode = ref("");
const selectedDate = ref("");
const selectedEndDate = ref("");
const remarks = ref("");
const discountImages = ref([]);
const currentDate = new Date();
const currentMonthIndex = ref(currentDate.getMonth());
const currentYear = ref(currentDate.getFullYear());

const isPackageOpen = ref(false);
const isTypeOpen = ref(false);
const isClassOpen = ref(false);
const isTooltipOpen = ref(false);
const tooltipX = ref(0);
const tooltipY = ref(0);
const tooltipData = ref({});
const tourInfoByDate = ref({});

const tourType = ref("Joiners");
const tourTypes = ["Joiners", "Exclusive"];
const tourClassification = ref("");
const tourClassifications = ref([]);

const packageDropdownRef = ref(null);
const typeDropdownRef = ref(null);
const classDropdownRef = ref(null);
const calendarWrapperRef = ref(null);
const tooltipRef = ref(null);

const isEditingItinerary = ref(false);
const editableItinerary = ref([]);
const customItinerary = ref([]);

const availabilityByDate = ref({
  "2025-01-10": "accepting",
  "2025-01-11": "available",
  "2025-01-12": "full",
});

const selectedPackageData = computed(() => {
  return packages.value.find((pkg) => pkg.id === selectedPackage.value) || {};
});

const packageDuration = computed(() => {
  const duration = selectedPackageData.value.tour_duration;
  return duration ? parseInt(duration) : 1;
});

const adultTotalAmount = computed(() => {
  const amount = selectedPackageData.value.pax_rate || 0;
  return amount * pax.value;
});

const kidsTotalAmount = computed(() => {
  const amount = selectedPackageData.value.kids_pax_rate || 0;
  return amount * kidsPax.value;
});

const totalAmount = computed(() => {
  return adultTotalAmount.value + kidsTotalAmount.value;
});

const durationDays = computed(() => {
  const start = selectedDate.value;
  const end = selectedEndDate.value || start;
  if (!start || !end) return 0;
  const [sy, sm, sd] = String(start).split("-").map(Number);
  const [ey, em, ed] = String(end).split("-").map(Number);
  const startDateUtc = Date.UTC(sy, (sm || 1) - 1, sd || 1);
  const endDateUtc = Date.UTC(ey, (em || 1) - 1, ed || 1);
  const diffMs = endDateUtc - startDateUtc;
  const days = Math.floor(diffMs / (1000 * 60 * 60 * 24)) + 1;
  return days > 0 ? days : 0;
});

const isExclusiveTour = computed(
  () => tourType.value?.toLowerCase() === "exclusive"
);

const monthName = computed(() =>
  new Date(currentYear.value, currentMonthIndex.value, 1).toLocaleString(
    "default",
    { month: "long" }
  )
);

const isDateInRange = (dateKey) => {
  if (!selectedDate.value) return false;

  if (tourType.value === "Exclusive") {
    if (!selectedEndDate.value) return dateKey === selectedDate.value;
    const current = new Date(dateKey);
    const start = new Date(selectedDate.value);
    const end = new Date(selectedEndDate.value);
    return current >= start && current <= end;
  } else {
    const selected = new Date(selectedDate.value);
    const current = new Date(dateKey);
    const duration = packageDuration.value;
    const endDate = new Date(selected);
    endDate.setDate(endDate.getDate() + (duration - 1));
    return current >= selected && current <= endDate;
  }
};

const calendarDays = computed(() => {
  const firstDay = new Date(currentYear.value, currentMonthIndex.value, 1);
  const startWeekday = firstDay.getDay();
  const daysInMonth = new Date(
    currentYear.value,
    currentMonthIndex.value + 1,
    0
  ).getDate();

  const grid = [];
  for (let i = 0; i < startWeekday; i++) {
    grid.push({
      day: null,
      dateKey: null,
      status: null,
      isPast: false,
      isInRange: false,
    });
  }
  for (let d = 1; d <= daysInMonth; d++) {
    const key = formatYmd(currentYear.value, currentMonthIndex.value, d);
    const isPast = isPastDate(currentYear.value, currentMonthIndex.value, d);
    const inRange = isDateInRange(key);

    grid.push({
      day: d,
      dateKey: key,
      status: availabilityByDate.value[key] || "available",
      isPast: isPast,
      isInRange: inRange,
    });
  }
  while (grid.length % 7 !== 0) {
    grid.push({
      day: null,
      dateKey: null,
      status: null,
      isPast: false,
      isInRange: false,
    });
  }
  return grid;
});

const parseItineraryToDays = (itineraryString) => {
  if (typeof itineraryString === "object" && itineraryString !== null) {
    return Object.entries(itineraryString).map(([key, value], index) => ({
      id: index + 1,
      content: value || "",
    }));
  }
  if (typeof itineraryString !== "string" || itineraryString.trim() === "") {
    return [{ id: 1, content: "" }];
  }
  const dayPattern = /Day\s+\d+:/gi;
  const dayMatches = [...itineraryString.matchAll(dayPattern)];
  if (dayMatches.length > 0) {
    const days = [];
    dayMatches.forEach((match, index) => {
      const startIndex = match.index;
      const endIndex =
        index < dayMatches.length - 1
          ? dayMatches[index + 1].index
          : itineraryString.length;
      const section = itineraryString.substring(startIndex, endIndex).trim();
      const lines = section.split("\n");
      const content = lines.slice(1).join("\n").trim();
      days.push({ id: index + 1, content });
    });
    return days;
  }
  const daySections = itineraryString
    .split("\n\n")
    .filter((section) => section.trim() !== "");
  if (daySections.length > 1) {
    return daySections.map((section, index) => ({
      id: index + 1,
      content: section.replace(/^Day\s+\d+:\s*/i, "").trim(),
    }));
  }
  return [{ id: 1, content: itineraryString.trim() }];
};

const itineraryDays = computed(() => {
  return customItinerary.value?.length
    ? customItinerary.value
    : parseItineraryToDays(selectedPackageData.value.itinerary || "");
});

watch(
  () => selectedPackageData.value.itinerary,
  (newItinerary) => {
    editableItinerary.value = parseItineraryToDays(newItinerary || "");
  },
  { immediate: true }
);

const toggleCustomize = () => {
  if (!isExclusiveTour.value) return;
  if (isEditingItinerary.value) {
    customItinerary.value = editableItinerary.value;
    toast.success("Customization saved successfully!");
    isEditingItinerary.value = false;
  } else {
    editableItinerary.value = [...itineraryDays.value];
    isEditingItinerary.value = true;
  }
};

const addNewDay = () => {
  const maxDays = durationDays.value;
  if (editableItinerary.value.length < maxDays) {
    editableItinerary.value.push({
      id: editableItinerary.value.length + 1,
      content: "",
    });
  }
};

const removeDay = (index) => {
  if (editableItinerary.value.length > 1) {
    editableItinerary.value.splice(index, 1);
    editableItinerary.value.forEach((day, idx) => {
      day.id = idx + 1;
    });
  } else {
    toast.warning("You must have at least one day in the itinerary.");
  }
};

const formatYmd = (year, monthIndex, day) => {
  const m = String(monthIndex + 1).padStart(2, "0");
  const d = String(day).padStart(2, "0");
  return `${year}-${m}-${d}`;
};

const isPastDate = (year, monthIndex, day) => {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const cellDate = new Date(year, monthIndex, day);
  cellDate.setHours(0, 0, 0, 0);
  return cellDate < today;
};

const handleDateClick = (event, cell) => {
  if (!cell.day || cell.isPast) return;

  if (tourType.value === "Exclusive") {
    if (!selectedDate.value || selectedEndDate.value) {
      selectedDate.value = cell.dateKey;
      selectedEndDate.value = "";
    } else {
      const start = new Date(selectedDate.value);
      const end = new Date(cell.dateKey);
      if (end < start) {
        selectedEndDate.value = selectedDate.value;
        selectedDate.value = cell.dateKey;
      } else {
        selectedEndDate.value = cell.dateKey;
      }
      showTooltip(event, cell.dateKey);
    }
  } else {
    selectedDate.value = cell.dateKey;
    const startDate = new Date(cell.dateKey);
    const duration = packageDuration.value;
    const calculatedEndDate = new Date(startDate);
    calculatedEndDate.setDate(calculatedEndDate.getDate() + (duration - 1));
    selectedEndDate.value = formatYmd(
      calculatedEndDate.getFullYear(),
      calculatedEndDate.getMonth(),
      calculatedEndDate.getDate()
    );
    showTooltip(event, cell.dateKey);
  }
};

const showTooltip = (event, dateKey) => {
  const info = tourInfoByDate.value[dateKey] || null;
  isTooltipOpen.value = true;
  tooltipData.value = {
    title: info ? info.title : selectedPackageData.value.package_name || "Tour",
    date: formatHuman(dateKey),
    slotsBooked: info ? info.slotsBooked : 0,
    slotsTotal: info
      ? info.slotsTotal
      : selectedPackageData.value.capacity || 0,
    status: info ? info.status : "Available",
    price: info ? info.price : `₱${selectedPackageData.value.pax_rate || 0}`,
  };

  const wrapper = calendarWrapperRef.value;
  if (wrapper && wrapper.getBoundingClientRect) {
    const rect = wrapper.getBoundingClientRect();
    const clickX = event.clientX - rect.left;
    const clickY = event.clientY - rect.top;
    tooltipX.value = Math.max(8, Math.min(clickX, rect.width - 360));
    tooltipY.value = Math.max(8, Math.min(clickY, rect.height - 220));
  } else {
    tooltipX.value = 12;
    tooltipY.value = 12;
  }
};

const closeTooltip = () => {
  isTooltipOpen.value = false;
};

const formatHuman = (ymd) => {
  const [y, m, d] = ymd.split("-").map(Number);
  const date = new Date(y, m - 1, d);
  return date.toLocaleDateString("en-US", {
    day: "2-digit",
    month: "long",
    year: "numeric",
  });
};

const prevMonth = () => {
  if (currentMonthIndex.value === 0) {
    currentMonthIndex.value = 11;
    currentYear.value -= 1;
  } else {
    currentMonthIndex.value -= 1;
  }
};

const nextMonth = () => {
  if (currentMonthIndex.value === 11) {
    currentMonthIndex.value = 0;
    currentYear.value += 1;
  } else {
    currentMonthIndex.value += 1;
  }
};

const selectTourType = (t) => {
  tourType.value = t;
  isTypeOpen.value = false;
  selectedDate.value = "";
  selectedEndDate.value = "";
};

const selectTourClassification = (c) => {
  tourClassification.value = c;
  isClassOpen.value = false;
};

const handlePackageSelect = (id) => {
  selectedPackage.value = id;
  isPackageOpen.value = false;
  tourClassifications.value =
    packages.value.find((p) => p.id === id)?.tour_classification || [];
  if (tourClassifications.value.length > 0) {
    tourClassification.value = tourClassifications.value[0];
  }
};

const handleImageUpload = (event) => {
  const files = Array.from(event.target.files);
  const imageFiles = files.filter((file) => file.type.startsWith("image/"));
  const remainingSlots = 3 - discountImages.value.length;
  const filesToAdd = imageFiles.slice(0, remainingSlots);

  filesToAdd.forEach((file) => {
    const reader = new FileReader();
    reader.onload = (e) => {
      discountImages.value.push({
        id: Date.now() + Math.random(),
        file: file,
        preview: e.target.result,
        name: file.name,
      });
    };
    reader.readAsDataURL(file);
  });

  event.target.value = "";
};

const removeImage = (imageId) => {
  discountImages.value = discountImages.value.filter(
    (img) => img.id !== imageId
  );
};

const triggerFileInput = () => {
  document.getElementById("discount-image-upload").click();
};

const handleClickOutside = (event) => {
  const packageEl = packageDropdownRef.value;
  const typeEl = typeDropdownRef.value;
  const classEl = classDropdownRef.value;
  const wrapperEl = calendarWrapperRef.value;
  const target = event.target;

  const clickedInsidePackage =
    packageEl && packageEl.contains && packageEl.contains(target);
  const clickedInsideType =
    typeEl && typeEl.contains && typeEl.contains(target);
  const clickedInsideClass =
    classEl && classEl.contains && classEl.contains(target);
  const clickedInsideTooltip =
    tooltipRef.value &&
    tooltipRef.value.contains &&
    tooltipRef.value.contains(target);
  const clickedInsideWrapper =
    wrapperEl && wrapperEl.contains && wrapperEl.contains(target);

  if (!clickedInsidePackage) {
    isPackageOpen.value = false;
  }
  if (
    !clickedInsideType &&
    !clickedInsideClass &&
    !clickedInsideTooltip &&
    !clickedInsideWrapper
  ) {
    isTypeOpen.value = false;
    isClassOpen.value = false;
    isTooltipOpen.value = false;
  }
};

const nextStep = () => {
  if (currentStep.value === 0) {
    if (!customerName.value) {
      toast.warning("Please enter customer name");
      return;
    }
    if (!selectedPackage.value) {
      toast.warning("Please select a package");
      return;
    }
  }
  if (currentStep.value === 1) {
    if (!selectedDate.value) {
      toast.warning("Please select a date");
      return;
    }
    if (tourType.value === "Exclusive" && !selectedEndDate.value) {
      toast.warning("Please select an end date");
      return;
    }
  }
  currentStep.value++;
};

const prevStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--;
  }
};

async function submitBooking() {
  try {
    const payload = {
      package_id: selectedPackage.value,
      customer_name: customerName.value,
      voucher_id: voucherCode.value,
      total_quantity: pax.value + kidsPax.value,
      adult_quantity: pax.value,
      kids_quantity: kidsPax.value,
      total_price: totalAmount.value,
      tour_date: selectedDate.value,
      tour_end_date: selectedEndDate.value || selectedDate.value,
      tour_type: tourType.value,
      tour_classification: tourClassification.value,
      remarks: remarks.value,
      discount_images: discountImages.value,
      custom_itinerary: customItinerary.value.length
        ? customItinerary.value
        : null,
    };

    const response = await service.createBooking(payload);
    emit("booking-created");
    toast.success("Booking successfully created!");
  } catch (error) {
    toast.error("Failed to create booking.");
  }
}

const fetchPackages = async () => {
  try {
    const response = await service.getPackages();
    packages.value = response.data.data;
  } catch (error) {
    toast.error("Failed to fetch packages.");
  }
};

onMounted(() => {
  fetchPackages();
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes slideDown {
  from {
    transform: translateY(-10px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes checkmark {
  from {
    transform: scale(0);
  }
  to {
    transform: scale(1);
  }
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease-out;
}

.animate-slideUp {
  animation: slideUp 0.4s ease-out;
}

.animate-slideDown {
  animation: slideDown 0.3s ease-out;
}

.animate-checkmark {
  animation: checkmark 0.3s ease-out;
}
</style>
