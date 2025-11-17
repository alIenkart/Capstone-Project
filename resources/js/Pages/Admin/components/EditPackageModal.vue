<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-md transition-opacity" @click="closeModal"></div>
    <div class="flex min-h-full items-center justify-center p-4 sm:p-6">
      <div
        class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all sm:my-8 w-full max-w-7xl mx-auto">
        <button type="button"
          class="absolute right-4 top-4 z-10 rounded-full p-2 text-white/80 hover:text-white hover:bg-white/20 transition-all"
          @click="closeModal">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <div class="bg-gradient-to-r from-[#217093] to-[#2a8bb5] px-5 py-6 sm:px-8 sm:py-8">
          <h3 class="text-3xl font-bold text-white tracking-tight">
            Edit Package
          </h3>
          <p class="mt-2 text-white/80 text-sm">Edit travel package</p>
        </div>

        <form @submit.prevent="updatePackage"
          class="px-5 py-6 sm:px-8 sm:py-8 max-h-[calc(100vh-280px)] overflow-y-auto bg-gradient-to-br from-slate-50 to-white">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-6">
            <div class="space-y-6">
              <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center gap-3 mb-5">
                  <h4 class="text-xl font-bold text-slate-800">
                    Package Image
                  </h4>
                </div>
                <div
                  class="relative flex items-center justify-center border-2 border-dashed rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 p-8 text-slate-500 cursor-pointer hover:text-[#217093] hover:border-[#217093] hover:bg-gradient-to-br hover:from-blue-50 hover:to-slate-50 transition-all group"
                  :class="imagePreview
                    ? 'border-[#217093] bg-white'
                    : 'border-slate-300'
                    ">
                  <label for="imageUpload" class="flex flex-col items-center justify-center w-full cursor-pointer">
                    <template v-if="imagePreview">
                      <img :src="imagePreview" alt="Preview"
                        class="w-full h-72 object-cover rounded-xl shadow-2xl ring-4 ring-[#217093]/20" />
                      <div
                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                        <span
                          class="text-white font-semibold text-sm bg-[#217093] px-4 py-2 rounded-full shadow-lg">Click
                          to change</span>
                      </div>
                    </template>
                    <template v-else>
                      <div
                        class="p-5 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl mb-4 group-hover:from-[#217093]/20 group-hover:to-blue-200 transition-all shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                          stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                      </div>
                      <span class="text-base font-bold text-slate-700 group-hover:text-[#217093] mb-1">Upload Package
                        Image</span>
                      <span class="text-xs text-slate-400">PNG, JPG • Max 10MB</span>
                    </template>
                    <input type="file" id="imageUpload" class="hidden" @change="handleImageUpload" />
                  </label>
                </div>
              </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
              <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center gap-3 mb-5">
                  <h4 class="text-xl font-bold text-slate-800">
                    Package Information
                  </h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                  <div class="md:col-span-2">
                    <label for="name"
                      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Package
                      Name*</label>
                    <input type="text" id="name" v-model="formData.package_name"
                      class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all"
                      placeholder="e.g., Paradise Island Getaway" required />
                  </div>

                  <DateRangePicker v-model:modelValueStart="formData.start_date"
                    v-model:modelValueEnd="formData.end_date" />

                  <div>
                    <label for="destination"
                      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Destination</label>
                    <input type="text" id="destination" v-model="formData.destination"
                      class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all"
                      placeholder="e.g., Boracay" />
                  </div>

                  <div class="md:col-span-2">
                    <label for="region"
                      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Region</label>

                    <div class="relative" ref="regionDropdown">
                      <button type="button" @click="isRegionFilterOpen = !isRegionFilterOpen"
                        class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <span class="font-semibold text-gray-800">
                          {{
                            formData.region === ""
                              ? "Select region"
                              : formData.region
                          }}
                        </span>
                        <svg :class="[
                          'w-5 h-5 text-blue-600 transition-transform duration-300',
                          isRegionFilterOpen ? 'rotate-180' : '',
                        ]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                      </button>

                      <div v-if="isRegionFilterOpen"
                        class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden max-h-96 overflow-y-auto">
                        <div @click="handleRegionSelect('')" :class="[
                          'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 sticky top-0 bg-white hover:bg-blue-50',
                          formData.region === ''
                            ? 'bg-blue-50 border-l-4 border-l-blue-500'
                            : '',
                        ]">
                          <span :class="[
                            'font-medium',
                            formData.region === ''
                              ? 'text-blue-700'
                              : 'text-gray-700',
                          ]">
                            All Regions
                          </span>
                          <svg v-if="formData.region === ''" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                              clip-rule="evenodd"></path>
                          </svg>
                        </div>

                        <div v-for="region in regionOptions" :key="region" @click="handleRegionSelect(region)" :class="[
                          'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 hover:bg-blue-50',
                          formData.region === region
                            ? 'bg-blue-50 border-l-4 border-l-blue-500'
                            : '',
                        ]">
                          <span :class="[
                            'font-medium',
                            formData.region === region
                              ? 'text-blue-700'
                              : 'text-gray-700',
                          ]">
                            {{ region }}
                          </span>
                          <svg v-if="formData.region === region" class="w-5 h-5 text-blue-600 ml-auto"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                              clip-rule="evenodd"></path>
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="space-y-4">
                    <MultiSelectDropdown label="Tour Classification" :options="[
                      'Land Travel',
                      'Water Adventure',
                      'Air Travel',
                    ]" v-model="formData.tour_classification" placeholder="Select Classification" />
                  </div>
                </div>
              </div>

              <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center gap-3 mb-5">
                  <h4 class="text-xl font-bold text-slate-800">
                    Pricing Information
                  </h4>
                  <span v-if="isSeasonalActive" class="text-xs font-bold px-3 py-1 rounded-full"
                    style="background-color: rgba(33, 112, 147, 0.1); color: #217093;">
                    SEASONAL ACTIVE
                  </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                  <div>
                    <label for="basePrice"
                      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Base
                      Price per Pax*</label>
                    <div class="relative">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-slate-400">
                        <path fill-rule="evenodd"
                          d="M11.99 2.243a4.49 4.49 0 0 0-3.398 1.55 4.49 4.49 0 0 0-3.497 1.306 4.491 4.491 0 0 0-1.307 3.498 4.491 4.491 0 0 0-1.548 3.397c0 1.357.6 2.573 1.548 3.397a4.491 4.491 0 0 0 1.307 3.498 4.49 4.49 0 0 0 3.498 1.307 4.49 4.49 0 0 0 3.397 1.549 4.49 4.49 0 0 0 3.397-1.549 4.49 4.49 0 0 0 3.497-1.307 4.491 4.491 0 0 0 1.306-3.497 4.491 4.491 0 0 0 1.55-3.398c0-1.357-.601-2.573-1.549-3.397a4.491 4.491 0 0 0-1.307-3.498 4.49 4.49 0 0 0-3.498-1.307 4.49 4.49 0 0 0-3.396-1.549Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6Zm-5.78-.905a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm4.5 4.5a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                          clip-rule="evenodd" />
                      </svg>
                      <input type="number" id="basePrice" v-model="formData.pax_rate" :disabled="isSeasonalActive"
                        class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 pl-9 pr-4 py-3 text-sm font-bold outline-none transition-all disabled:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-60"
                        placeholder="0.00" required />
                    </div>
                    <p v-if="isSeasonalActive" class="text-xs text-slate-500 mt-1">Disabled when seasonal pricing is
                      active</p>
                  </div>

                  <div>
                    <label for="kidsBasePrice"
                      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kids
                      Price per Pax</label>
                    <div class="relative">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-slate-400">
                        <path fill-rule="evenodd"
                          d="M11.99 2.243a4.49 4.49 0 0 0-3.398 1.55 4.49 4.49 0 0 0-3.497 1.306 4.491 4.491 0 0 0-1.307 3.498 4.491 4.491 0 0 0-1.548 3.397c0 1.357.6 2.573 1.548 3.397a4.491 4.491 0 0 0 1.307 3.498 4.49 4.49 0 0 0 3.498 1.307 4.49 4.49 0 0 0 3.397 1.549 4.49 4.49 0 0 0 3.397-1.549 4.49 4.49 0 0 0 3.497-1.307 4.491 4.491 0 0 0 1.306-3.497 4.491 4.491 0 0 0 1.55-3.398c0-1.357-.601-2.573-1.549-3.397a4.491 4.491 0 0 0-1.307-3.498 4.49 4.49 0 0 0-3.498-1.307 4.49 4.49 0 0 0-3.396-1.549Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6Zm-5.78-.905a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm4.5 4.5a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                          clip-rule="evenodd" />
                      </svg>
                      <input type="number" id="kidsBasePrice" v-model="formData.kids_pax_rate"
                        :disabled="isSeasonalActive"
                        class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 pl-9 pr-4 py-3 text-sm font-bold outline-none transition-all disabled:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-60"
                        placeholder="0.00" />
                    </div>
                    <p v-if="isSeasonalActive" class="text-xs text-slate-500 mt-1">Disabled when seasonal pricing is
                      active</p>
                  </div>

                  <div>
                    <label for="discountedRate"
                      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Discounted
                      Rate</label>
                    <div class="relative">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-slate-400">
                        <path fill-rule="evenodd"
                          d="M11.99 2.243a4.49 4.49 0 0 0-3.398 1.55 4.49 4.49 0 0 0-3.497 1.306 4.491 4.491 0 0 0-1.307 3.498 4.491 4.491 0 0 0-1.548 3.397c0 1.357.6 2.573 1.548 3.397a4.491 4.491 0 0 0 1.307 3.498 4.49 4.49 0 0 0 3.498 1.307 4.49 4.49 0 0 0 3.397 1.549 4.49 4.49 0 0 0 3.397-1.549 4.49 4.49 0 0 0 3.497-1.307 4.491 4.491 0 0 0 1.306-3.497 4.491 4.491 0 0 0 1.55-3.398c0-1.357-.601-2.573-1.549-3.397a4.491 4.491 0 0 0-1.307-3.498 4.49 4.49 0 0 0-3.498-1.307 4.49 4.49 0 0 0-3.396-1.549Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6Zm-5.78-.905a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm4.5 4.5a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                          clip-rule="evenodd" />
                      </svg>
                      <input type="number" id="discountedRate" v-model="formData.discounted_rate"
                        class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 pl-9 pr-4 py-3 text-sm font-bold outline-none transition-all"
                        placeholder="0.00" />
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="bg-gradient-to-br from-blue-50 to-slate-50 rounded-2xl p-6 border border-blue-200 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-5">
                  <div>
                    <h4 class="text-xl font-bold text-slate-800">Seasonal Package</h4>
                    <p v-if="isSeasonalActive" class="text-xs text-green-600 mt-1 font-semibold">✓ Seasonal pricing is
                      active</p>
                  </div>
                  <div class="flex gap-2">
                    <button v-if="!isSeasonalActive" type="button" @click="toggleSeasonalMode"
                      class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-bold rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0"
                      style="background: linear-gradient(to right, #217093, #2a8bb5);"
                      @mouseenter="$event.target.style.background = 'linear-gradient(to right, #1a5a7a, #217093)'"
                      @mouseleave="$event.target.style.background = 'linear-gradient(to right, #217093, #2a8bb5)'">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 10V3L4 14h7v7l9-11h-7z" />
                      </svg>
                      Activate Seasonal Pricing
                    </button>
                    <button v-else type="button" @click="deactivateSeasonalPricing"
                      class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0">
                      Deactivate Seasonal
                    </button>
                  </div>
                </div>

                <div v-if="isSeasonalActive" class="space-y-4">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                      <label class="block text-xs font-semibold text-slate-700 mb-2">Seasonal Base Price per
                        Pax*</label>
                      <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                          class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: #217093">
                          <path fill-rule="evenodd"
                            d="M11.99 2.243a4.49 4.49 0 0 0-3.398 1.55 4.49 4.49 0 0 0-3.497 1.306 4.491 4.491 0 0 0-1.307 3.498 4.491 4.491 0 0 0-1.548 3.397c0 1.357.6 2.573 1.548 3.397a4.491 4.491 0 0 0 1.307 3.498 4.49 4.49 0 0 0 3.498 1.307 4.49 4.49 0 0 0 3.397 1.549 4.49 4.49 0 0 0 3.397-1.549 4.49 4.49 0 0 0 3.497-1.307 4.491 4.491 0 0 0 1.306-3.497 4.491 4.491 0 0 0 1.55-3.398c0-1.357-.601-2.573-1.549-3.397a4.491 4.491 0 0 0-1.307-3.498 4.49 4.49 0 0 0-3.498-1.307 4.49 4.49 0 0 0-3.396-1.549Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6Zm-5.78-.905a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm4.5 4.5a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                            clip-rule="evenodd" />
                        </svg>
                        <input type="number" v-model.number="seasonalPaxRate"
                          class="w-full rounded-lg border-2 outline-none transition-all pl-10 pr-4 py-2.5 text-sm font-medium bg-white"
                          style="border-color: #217093;"
                          @focus="$event.target.style.borderColor = '#2a8bb5'; $event.target.style.boxShadow = 'inset 0 0 0 3px rgba(42, 139, 181, 0.1)'"
                          @blur="$event.target.style.borderColor = '#217093'; $event.target.style.boxShadow = 'none'"
                          placeholder="0.00" step="0.01" />
                      </div>
                    </div>

                    <div>
                      <label class="block text-xs font-semibold text-slate-700 mb-2">Seasonal Kids Price per Pax</label>
                      <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                          class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: #217093">
                          <path fill-rule="evenodd"
                            d="M11.99 2.243a4.49 4.49 0 0 0-3.398 1.55 4.49 4.49 0 0 0-3.497 1.306 4.491 4.491 0 0 0-1.307 3.498 4.491 4.491 0 0 0-1.548 3.397c0 1.357.6 2.573 1.548 3.397a4.491 4.491 0 0 0 1.307 3.498 4.49 4.49 0 0 0 3.498 1.307 4.49 4.49 0 0 0 3.397 1.549 4.49 4.49 0 0 0 3.397-1.549 4.49 4.49 0 0 0 3.497-1.307 4.491 4.491 0 0 0 1.306-3.497 4.491 4.491 0 0 0 1.55-3.398c0-1.357-.601-2.573-1.549-3.397a4.491 4.491 0 0 0-1.307-3.498 4.49 4.49 0 0 0-3.498-1.307 4.49 4.49 0 0 0-3.396-1.549Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6Zm-5.78-.905a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm4.5 4.5a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                            clip-rule="evenodd" />
                        </svg>
                        <input type="number" v-model.number="seasonalKidsPaxRate"
                          class="w-full rounded-lg border-2 outline-none transition-all pl-10 pr-4 py-2.5 text-sm font-medium bg-white"
                          style="border-color: #217093;"
                          @focus="$event.target.style.borderColor = '#2a8bb5'; $event.target.style.boxShadow = 'inset 0 0 0 3px rgba(42, 139, 181, 0.1)'"
                          @blur="$event.target.style.borderColor = '#217093'; $event.target.style.boxShadow = 'none'"
                          placeholder="0.00" step="0.01" />
                      </div>
                    </div>
                  </div>

                  <button type="button" @click="updateSeasonalPricing"
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-bold rounded-lg hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Update Seasonal Pricing
                  </button>
                </div>

                <p v-else class="text-sm text-slate-600">Toggle this to activate seasonal pricing for this package.</p>
              </div>
              <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center gap-3 mb-5">
                  <h4 class="text-xl font-bold text-slate-800">
                    Package Settings
                  </h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                  <div>
                    <label for="maxOccupancy"
                      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Maximum
                      Occupancy</label>
                    <input type="number" id="maxOccupancy" v-model.number="formData.capacity"
                      class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all"
                      placeholder="0" min="0" />
                  </div>

                  <div class="relative" ref="statusDropdown">
                    <label for="status"
                      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                    <button type="button" @click="isStatusOpen = !isStatusOpen"
                      class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                      <span class="font-semibold text-gray-800">
                        {{
                          formData.status === "active" ? "Active" : "Inactive"
                        }}
                      </span>
                      <svg :class="[
                        'w-5 h-5 text-blue-600 transition-transform duration-300',
                        isStatusOpen ? 'rotate-180' : '',
                      ]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                      </svg>
                    </button>

                    <div v-if="isStatusOpen"
                      class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden">
                      <div @click="handleStatusSelect('active')" :class="[
                        'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 hover:bg-blue-50',
                        formData.status === 'active'
                          ? 'bg-blue-50 border-l-4 border-l-blue-500'
                          : '',
                      ]">
                        <span :class="[
                          'font-medium',
                          formData.status === 'active'
                            ? 'text-blue-700'
                            : 'text-gray-700',
                        ]">
                          Active
                        </span>
                        <svg v-if="formData.status === 'active'" class="w-5 h-5 text-blue-600 ml-auto"
                          fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                        </svg>
                      </div>
                      <div @click="handleStatusSelect('inactive')" :class="[
                        'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                        formData.status === 'inactive'
                          ? 'bg-blue-50 border-l-4 border-l-blue-500'
                          : '',
                      ]">
                        <span :class="[
                          'font-medium',
                          formData.status === 'inactive'
                            ? 'text-blue-700'
                            : 'text-gray-700',
                        ]">
                          Inactive
                        </span>
                        <svg v-if="formData.status === 'inactive'" class="w-5 h-5 text-blue-600 ml-auto"
                          fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                  <div>
                    <label for="slotAvailable"
                      class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Slots
                      Available</label>
                    <div class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 pl-4">
                      {{ formData.available_slot }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center gap-3 mb-5">
                  <h4 class="text-xl font-bold text-slate-800">Description*</h4>
                </div>
                <textarea id="description" v-model="formData.description" rows="5"
                  class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none"
                  placeholder="Describe the package in detail. What makes it special?" required></textarea>
              </div>

              <div
                class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-5">
                  <div class="flex items-center gap-3">
                    <h4 class="text-xl font-bold text-slate-800">Itinerary*</h4>
                  </div>
                  <div class="text-sm font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">
                    Day {{ itineraryDays.length }} / Day {{ maxItineraryDays }}
                  </div>
                </div>
                <div class="space-y-4">
                  <TransitionGroup name="list">
                    <div v-for="(day, index) in itineraryDays" :key="day.id"
                      class="bg-white border-2 border-blue-200 rounded-xl p-5 hover:border-blue-400 transition-all shadow-sm hover:shadow-md">
                      <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                          <h4 class="text-lg font-bold text-slate-800">
                            Day {{ index + 1 }}
                          </h4>
                        </div>
                        <button v-if="itineraryDays.length > 1" type="button" @click="removeItineraryDay(day.id)"
                          class="p-2 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-600 transition-all">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </div>
                      <textarea v-model="day.content"
                        :placeholder="`Describe the activities and highlights for Day ${day.id}...`" rows="4"
                        class="w-full rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 px-4 py-3 text-sm outline-none transition-all resize-none"></textarea>
                    </div>
                  </TransitionGroup>

                  <div v-if="isAddDayButtonDisabled" class="group relative">
                    <button type="button" disabled
                      class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-gradient-to-r from-slate-300 to-slate-400 text-white text-sm font-bold rounded-xl cursor-not-allowed opacity-60 shadow-lg">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                      </svg>
                      Add Another Day
                    </button>
                    <div
                      class="opacity-0 group-hover:opacity-100 absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-2 bg-slate-800 text-white text-xs rounded-lg whitespace-nowrap transition-opacity z-10 pointer-events-none">
                      <span v-if="!formData.start_date || !formData.end_date">Please select start and end dates
                        first</span>
                      <span v-else>Maximum {{ maxItineraryDays }} days reached</span>
                    </div>
                  </div>

                  <button v-else type="button" @click="addItineraryDay"
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-bold rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Another Day
                  </button>
                </div>
              </div>

              <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center gap-3 mb-5">
                  <h4 class="text-xl font-bold text-slate-800">
                    Terms & Conditions*
                  </h4>
                </div>
                <textarea id="termsCondition" v-model="formData.terms_condition" rows="5"
                  class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none"
                  placeholder="Enter terms and conditions that apply to this package..." required></textarea>
              </div>

              <div
                class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all mb-6">
                <div class="flex items-center gap-3 mb-5">
                  <h4 class="text-xl font-bold text-slate-800">Exclusions*</h4>
                </div>
                <textarea id="exclusions" v-model="formData.exclusions" rows="5"
                  class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none"
                  placeholder="List what's not included in the package..." required></textarea>
              </div>
            </div>
          </div>
        </form>

        <div class="bg-gradient-to-r from-slate-50 to-white px-5 sm:px-8 py-6 border-t-2 border-slate-200">
          <div class="flex flex-col sm:flex-row sm:justify-end gap-3">
            <button type="button"
              class="flex items-center justify-center gap-2 rounded-xl px-6 sm:px-7 py-3 text-sm font-bold bg-slate-600 text-white hover:bg-slate-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto"
              @click="closeModal">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Cancel
            </button>
            <button type="submit" @click="updatePackage"
              class="flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#217093] to-[#2a8bb5] hover:from-[#1a5a7a] hover:to-[#217093] px-6 sm:px-7 py-3 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Seasonal Confirmation Modal -->
  <div v-if="showSeasonalConfirmation"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div
      class="bg-gradient-to-br from-white to-blue-50 rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl border border-blue-200">
      <div class="mb-6">
        <div class="flex items-center gap-3 mb-3">
          <div class="p-3 rounded-lg" style="background-color: #217093">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-slate-800">Activate Seasonal Package</h3>
        </div>
        <p class="text-sm text-slate-600 mt-2 ml-12">This will enable seasonal pricing for this package. You'll be able
          to
          set custom rates.</p>
      </div>
      <div class="flex gap-3">
        <button @click="cancelSeasonalMode"
          class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 font-semibold rounded-lg hover:bg-slate-200 transition-all">
          Cancel
        </button>
        <button @click="confirmSeasonalMode"
          class="flex-1 px-4 py-2.5 text-white font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0"
          style="background: linear-gradient(to right, #217093, #2a8bb5); cursor: pointer;"
          @mouseenter="$event.target.style.background = 'linear-gradient(to right, #1a5a7a, #217093)'"
          @mouseleave="$event.target.style.background = 'linear-gradient(to right, #217093, #2a8bb5)'">
          Yes, Activate
        </button>
      </div>
    </div>
  </div>

  <!-- Seasonal Pricing Input Modal -->
  <div v-if="isSeasonalMode" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div
      class="bg-gradient-to-br from-white to-blue-50 rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl border border-blue-200">
      <div class="flex items-center gap-3 mb-6">
        <div class="p-3 rounded-lg" style="background-color: #217093">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800">Set Seasonal Pricing</h3>
      </div>

      <div class="space-y-4 mb-6">
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Seasonal Base Price per Pax*</label>
          <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
              class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: #217093">
              <path fill-rule="evenodd"
                d="M11.99 2.243a4.49 4.49 0 0 0-3.398 1.55 4.49 4.49 0 0 0-3.497 1.306 4.491 4.491 0 0 0-1.307 3.498 4.491 4.491 0 0 0-1.548 3.397c0 1.357.6 2.573 1.548 3.397a4.491 4.491 0 0 0 1.307 3.498 4.49 4.49 0 0 0 3.498 1.307 4.49 4.49 0 0 0 3.397 1.549 4.49 4.49 0 0 0 3.397-1.549 4.49 4.49 0 0 0 3.497-1.307 4.491 4.491 0 0 0 1.306-3.497 4.491 4.491 0 0 0 1.55-3.398c0-1.357-.601-2.573-1.549-3.397a4.491 4.491 0 0 0-1.307-3.498 4.49 4.49 0 0 0-3.498-1.307 4.49 4.49 0 0 0-3.396-1.549Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6Zm-5.78-.905a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm4.5 4.5a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                clip-rule="evenodd" />
            </svg>
            <input type="number" v-model="seasonalPaxRate"
              class="w-full rounded-lg border-2 outline-none transition-all pl-10 pr-4 py-2.5 text-sm font-medium bg-white hover:bg-slate-50"
              style="border-color: #217093; color: #217093;"
              @focus="$event.target.style.borderColor = '#2a8bb5'; $event.target.style.boxShadow = 'inset 0 0 0 3px rgba(42, 139, 181, 0.1)'"
              @blur="$event.target.style.borderColor = '#217093'; $event.target.style.boxShadow = 'none'"
              placeholder="0.00" step="0.01" />
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Seasonal Kids Price per Pax</label>
          <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
              class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: #217093">
              <path fill-rule="evenodd"
                d="M11.99 2.243a4.49 4.49 0 0 0-3.398 1.55 4.49 4.49 0 0 0-3.497 1.306 4.491 4.491 0 0 0-1.307 3.498 4.491 4.491 0 0 0-1.548 3.397c0 1.357.6 2.573 1.548 3.397a4.491 4.491 0 0 0 1.307 3.498 4.49 4.49 0 0 0 3.498 1.307 4.49 4.49 0 0 0 3.397 1.549 4.49 4.49 0 0 0 3.397-1.549 4.49 4.49 0 0 0 3.497-1.307 4.491 4.491 0 0 0 1.306-3.497 4.491 4.491 0 0 0 1.55-3.398c0-1.357-.601-2.573-1.549-3.397a4.491 4.491 0 0 0-1.307-3.498 4.49 4.49 0 0 0-3.498-1.307 4.49 4.49 0 0 0-3.396-1.549Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6Zm-5.78-.905a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm4.5 4.5a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                clip-rule="evenodd" />
            </svg>
            <input type="number" v-model="seasonalKidsPaxRate"
              class="w-full rounded-lg border-2 outline-none transition-all pl-10 pr-4 py-2.5 text-sm font-medium bg-white hover:bg-slate-50"
              style="border-color: #217093; color: #217093;"
              @focus="$event.target.style.borderColor = '#2a8bb5'; $event.target.style.boxShadow = 'inset 0 0 0 3px rgba(42, 139, 181, 0.1)'"
              @blur="$event.target.style.borderColor = '#217093'; $event.target.style.boxShadow = 'none'"
              placeholder="0.00" step="0.01" />
          </div>
        </div>
      </div>

      <div class="flex gap-3">
        <button @click="cancelSeasonalPricing" type="button"
          class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 font-semibold rounded-lg hover:bg-slate-200 transition-all">
          Cancel
        </button>
        <button @click="saveSeasonalPricing" type="button"
          class="flex-1 px-4 py-2.5 text-white font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0"
          style="background: linear-gradient(to right, #217093, #2a8bb5); cursor: pointer;"
          @mouseenter="$event.target.style.background = 'linear-gradient(to right, #1a5a7a, #217093)'"
          @mouseleave="$event.target.style.background = 'linear-gradient(to right, #217093, #2a8bb5)'">
          Save Seasonal Pricing
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, computed } from "vue";
import axios from "axios";
import { useToast } from "vue-toastification";
import MultiSelectDropdown from "@/components/MultiSelectDropdown.vue";
import DateRangePicker from "./Analytics/DateRangePicker.vue";

const props = defineProps({
  show: Boolean,
  packageId: [Number, String, null],
});

const toast = useToast();
const emit = defineEmits(["close", "saved"]);

const formData = ref({
  id: null,
  package_name: "",
  destination: "",
  region: "",
  description: "",
  start_date: "",
  end_date: "",
  tour_duration: "",
  image_path: "",
  itinerary: "",
  terms_condition: "",
  exclusions: "",
  capacity: 0,
  available_slot: 0,
  status: "active",
  pax_rate: 0,
  kids_pax_rate: 0,
  discounted_rate: 0,
  tour_classification: [],
});

const itineraryDays = ref([{ id: 1, content: "" }]);
const imagePreview = ref(null);
const isStatusOpen = ref(false);
const isRegionFilterOpen = ref(false);
const statusDropdown = ref(null);
const regionDropdown = ref(null);
const showSeasonalConfirmation = ref(false);
const isSeasonalMode = ref(false);
const seasonalPaxRate = ref(0);
const seasonalKidsPaxRate = ref(0);
const isSeasonalActive = ref(false);
const originalPaxRate = ref(0);
const originalKidsPaxRate = ref(0);

const regionOptions = ref([
  "National Capital Region (NCR)",
  "Cordillera Administrative Region (CAR)",
  "Region I: Ilocos Region",
  "Region II: Cagayan Valley",
  "Region III: Central Luzon",
  "Region IV-A: Calabarzon (CALABARZON)",
  "Region IV-B: Mimaropa (MIMAROPA)",
  "Region V: Bicol Region",
  "Region VI: Western Visayas",
  "Region VII: Central Visayas",
  "Region VIII: Eastern Visayas",
  "Region IX: Zamboanga Peninsula",
  "Region X: Northern Mindanao",
  "Region XI: Davao Region",
  "Region XII: SOCCSKSARGEN",
  "Region XIII: Caraga",
  "BARMM: Bangsamoro Autonomous Region in Muslim Mindanao",
]);

// Computed property to calculate max itinerary days based on date range
const maxItineraryDays = computed(() => {
  if (formData.value.start_date && formData.value.end_date) {
    const startParts = formData.value.start_date.split("-");
    const endParts = formData.value.end_date.split("-");

    const start = new Date(
      parseInt(startParts[0]),
      parseInt(startParts[1]) - 1,
      parseInt(startParts[2])
    );
    const end = new Date(
      parseInt(endParts[0]),
      parseInt(endParts[1]) - 1,
      parseInt(endParts[2])
    );

    const oneDay = 1000 * 60 * 60 * 24;
    const diffDays = Math.floor((end - start) / oneDay) + 1;
    return diffDays > 0 ? diffDays : 0;
  }
  return 0;
});

// Computed property to check if add day button should be disabled
const isAddDayButtonDisabled = computed(() => {
  return (
    (itineraryDays.value.length >= maxItineraryDays.value &&
      maxItineraryDays.value > 0) ||
    !formData.value.start_date ||
    !formData.value.end_date
  );
});

watch([() => props.show, () => props.packageId], ([newShow, newPackageId]) => {
  if (newShow && newPackageId !== null) {
    fetchPackage(newPackageId);
  } else if (!newShow) {
    resetForm();
    isStatusOpen.value = false;
    isRegionFilterOpen.value = false;
    showSeasonalConfirmation.value = false;
    isSeasonalMode.value = false;
    seasonalPaxRate.value = 0;
    seasonalKidsPaxRate.value = 0;
  }
});

watch([() => formData.value.start_date, () => formData.value.end_date], () => {
  adjustItineraryDays();
});

const fetchPackage = async (id) => {
  try {
    const response = await axios.get(`/api/packages/${id}`);
    const packageData = response.data.data;

    isSeasonalActive.value = packageData.is_seasonal || false;

    originalPaxRate.value = packageData.pax_rate || 0;
    originalKidsPaxRate.value = packageData.kids_pax_rate || 0;

    if (packageData.is_seasonal) {
      seasonalPaxRate.value = packageData.seasonal_pax_rate || 0;
      seasonalKidsPaxRate.value = packageData.seasonal_kids_pax_rate || 0;
    } else {
      seasonalPaxRate.value = 0;
      seasonalKidsPaxRate.value = 0;
    }

    formData.value = {
      id: packageData.id,
      package_name: packageData.package_name || "",
      destination: packageData.destination || "",
      region: packageData.region || "",
      description: packageData.description || "",
      start_date: packageData.start_date || "",
      end_date: packageData.end_date || "",
      tour_duration: packageData.tour_duration || "",
      image_path: packageData.image_path || "",
      itinerary: packageData.itinerary || "",
      terms_condition: packageData.terms_condition || "",
      exclusions: packageData.exclusions || "",
      capacity: packageData.capacity || 0,
      available_slot: packageData.available_slot || 0,
      status: packageData.status || "active",
      pax_rate: packageData.pax_rate || 0,
      kids_pax_rate: packageData.kids_pax_rate || 0,
      discounted_rate: packageData.discounted_rate || 0,
      tour_classification: packageData.tour_classification || [],
    };

    const apiItinerary =
      typeof packageData.itinerary === "string"
        ? JSON.parse(packageData.itinerary)
        : packageData.itinerary || {};

    itineraryDays.value = Object.keys(apiItinerary).map((key, index) => ({
      id: index + 1,
      number_of_day: index + 1,
      content: apiItinerary[key],
    }));

    imagePreview.value = formData.value.image_path
      ? `/storage/${formData.value.image_path}`
      : null;

    if (formData.value.start_date && formData.value.end_date) {
      const startDateOnly =
        formData.value.start_date.split("T")[0] || formData.value.start_date;
      const endDateOnly =
        formData.value.end_date.split("T")[0] || formData.value.end_date;
      formData.value.start_date = startDateOnly;
      formData.value.end_date = endDateOnly;
    }
  } catch (error) {
    console.error("Error fetching package:", error);
    toast.error("Error fetching package data.");
    closeModal();
  }
};

const closeModal = () => {
  emit("close");
};

const calculateDuration = () => {
  if (formData.value.start_date && formData.value.end_date) {
    const start = new Date(formData.value.start_date + "T00:00:00");
    const end = new Date(formData.value.end_date + "T00:00:00");
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
    return diffDays;
  }
  return 0;
};

const adjustItineraryDays = () => {
  const currentDays = itineraryDays.value.length;
  const maxDays = maxItineraryDays.value;

  if (maxDays > 0 && currentDays > maxDays) {
    itineraryDays.value = itineraryDays.value.slice(0, maxDays);
    itineraryDays.value.forEach((day, index) => {
      day.id = index + 1;
    });
    toast.warning(
      `Itinerary reduced to ${maxDays} days based on your date range.`
    );
  }
};

const updatePackage = async () => {
  try {
    if (
      !formData.value.package_name ||
      !formData.value.start_date ||
      !formData.value.end_date
    ) {
      toast.error(
        "Please fill in Package Name, Start Date, and End Date."
      );
      return;
    }

    if (!isSeasonalActive.value && !formData.value.pax_rate) {
      toast.error("Please fill in Base Price per Pax.");
      return;
    }

    if (
      new Date(formData.value.start_date) > new Date(formData.value.end_date)
    ) {
      toast.error("Start Date must be before End Date.");
      return;
    }

    const duration = calculateDuration();
    let response;
    const formattedItinerary = {};
    itineraryDays.value.forEach((day) => {
      formattedItinerary[`day_${day.id}`] = day.content;
    });

    if (formData.value.image) {
      const data = new FormData();
      data.append("package_name", formData.value.package_name);
      data.append("destination", formData.value.destination);
      data.append("region", formData.value.region || "");
      data.append("description", formData.value.description);
      data.append("start_date", formData.value.start_date);
      data.append("end_date", formData.value.end_date);
      data.append("tour_duration", duration.toString());
      data.append("itinerary", JSON.stringify(formattedItinerary));
      data.append("terms_condition", formData.value.terms_condition);
      data.append("exclusions", formData.value.exclusions);
      data.append("capacity", parseInt(formData.value.capacity) || 0);
      data.append("status", formData.value.status.toLowerCase());
      data.append(
        "discounted_rate",
        parseFloat(formData.value.discounted_rate) || 0
      );
      data.append("image", formData.value.image);

      if (!isSeasonalActive.value) {
        data.append("pax_rate", parseFloat(formData.value.pax_rate) || 0);
        data.append("kids_pax_rate", formData.value.kids_pax_rate || 0);
      }

      formData.value.tour_classification.forEach((item, index) => {
        data.append(`tour_classification[${index}]`, item);
      });

      response = await axios.post(
        `/api/packages/${formData.value.id}?_method=PUT`,
        data,
        {
          headers: { "Content-Type": "application/form-data" },
        }
      );
    } else {
      const payload = {
        package_name: formData.value.package_name,
        destination: formData.value.destination,
        region: formData.value.region || "",
        description: formData.value.description,
        start_date: formData.value.start_date,
        end_date: formData.value.end_date,
        tour_duration: duration.toString(),
        itinerary: JSON.stringify(formattedItinerary),
        terms_condition: formData.value.terms_condition,
        exclusions: formData.value.exclusions,
        capacity: parseInt(formData.value.capacity) || 0,
        status: formData.value.status.toLowerCase(),
        discounted_rate: parseFloat(formData.value.discounted_rate) || 0,
        tour_classification: formData.value.tour_classification,
      };

      if (!isSeasonalActive.value) {
        payload.pax_rate = parseFloat(formData.value.pax_rate) || 0;
        payload.kids_pax_rate = formData.value.kids_pax_rate || 0;
      }

      response = await axios.put(`/api/packages/${formData.value.id}`, payload);
    }

    toast.success("Package updated successfully!");
    emit("saved", response.data.data);
    closeModal();
  } catch (error) {
    console.error("Error updating package:", error);
    toast.error("Error updating package");
  }
};

const resetForm = () => {
  formData.value = {
    id: null,
    package_name: "",
    destination: "",
    region: "",
    description: "",
    start_date: "",
    end_date: "",
    tour_duration: "",
    image_path: "",
    itinerary: "",
    terms_condition: "",
    exclusions: "",
    capacity: 0,
    status: "active",
    pax_rate: 0,
    kids_pax_rate: 0,
    discounted_rate: 0,
    tour_classification: [],
  };
  itineraryDays.value = [{ id: 1, content: "" }];
  imagePreview.value = null;
};

const handleImageUpload = (event) => {
  const file = event.target.files[0];
  formData.value.image = file;
  imagePreview.value = file
    ? URL.createObjectURL(file)
    : formData.value.image_path
      ? `/storage/${formData.value.image_path}`
      : null;
};

const handleStatusSelect = (value) => {
  formData.value.status = value;
  isStatusOpen.value = false;
};

const handleRegionSelect = (region) => {
  formData.value.region = region;
  isRegionFilterOpen.value = false;
};

const removeItineraryDay = (dayId) => {
  if (itineraryDays.value.length <= 1) {
    toast.warning("You must have at least one day in the itinerary.");
    return;
  }

  itineraryDays.value = itineraryDays.value.filter((day) => day.id !== dayId);

  itineraryDays.value.forEach((day, index) => {
    day.id = index + 1;
  });
};

const addItineraryDay = () => {
  if (!formData.value.start_date || !formData.value.end_date) {
    toast.error("Please select start and end dates first.");
    return;
  }

  if (isAddDayButtonDisabled.value) {
    toast.error(
      `Maximum ${maxItineraryDays.value} days allowed for this date range.`
    );
    return;
  }

  const newDayNumber = itineraryDays.value.length + 1;
  itineraryDays.value.push({ id: newDayNumber, content: "" });
};

const toggleSeasonalMode = () => {
  showSeasonalConfirmation.value = true;
};

const confirmSeasonalMode = () => {
  isSeasonalMode.value = true;
  showSeasonalConfirmation.value = false;
};

const cancelSeasonalMode = () => {
  showSeasonalConfirmation.value = false;
};

const saveSeasonalPricing = async () => {
  try {
    if (!seasonalPaxRate.value) {
      toast.error("Please enter seasonal base price");
      return;
    }

    originalPaxRate.value = formData.value.pax_rate;
    originalKidsPaxRate.value = formData.value.kids_pax_rate;

    const payload = {
      is_seasonal: true,
      seasonal_pax_rate: parseFloat(seasonalPaxRate.value),
      seasonal_kids_pax_rate: seasonalKidsPaxRate.value ? parseFloat(seasonalKidsPaxRate.value) : null,
    };

    const response = await axios.put(
      `/api/packages/${formData.value.id}/seasonal-pricing`,
      payload
    );

    isSeasonalActive.value = true;

    seasonalPaxRate.value = response.data.data.seasonal_pax_rate;
    seasonalKidsPaxRate.value = response.data.data.seasonal_kids_pax_rate || '';

    toast.success("Seasonal pricing activated successfully!");
    isSeasonalMode.value = false;

  } catch (error) {
    console.error("Error updating seasonal pricing:", error);
    toast.error("Error updating seasonal pricing");
  }
};

const updateSeasonalPricing = async () => {
  try {
    if (!seasonalPaxRate.value) {
      toast.error("Please enter seasonal base price");
      return;
    }

    const payload = {
      is_seasonal: true,
      seasonal_pax_rate: parseFloat(seasonalPaxRate.value),
      seasonal_kids_pax_rate: seasonalKidsPaxRate.value ? parseFloat(seasonalKidsPaxRate.value) : null,
    };

    const response = await axios.put(
      `/api/packages/${formData.value.id}/seasonal-pricing`,
      payload
    );

    seasonalPaxRate.value = response.data.data.seasonal_pax_rate;
    seasonalKidsPaxRate.value = response.data.data.seasonal_kids_pax_rate || seasonalKidsPaxRate.value;

    toast.success("Seasonal pricing updated successfully!");
  } catch (error) {
    console.error("Error updating seasonal pricing:", error);
    toast.error("Error updating seasonal pricing");
  }
};

const cancelSeasonalPricing = () => {
  isSeasonalMode.value = false;
  seasonalPaxRate.value = 0;
  seasonalKidsPaxRate.value = 0;
};

const deactivateSeasonalPricing = async () => {
  try {
    const payload = {
      is_seasonal: false,
      pax_rate: parseFloat(originalPaxRate.value) || 0,
      kids_pax_rate: originalKidsPaxRate.value ? parseFloat(originalKidsPaxRate.value) : null,
    };

    const response = await axios.put(
      `/api/packages/${formData.value.id}/deactivate-seasonal`,
      payload
    );

    isSeasonalActive.value = false;

    formData.value.pax_rate = response.data.data.pax_rate;
    formData.value.kids_pax_rate = response.data.data.kids_pax_rate;

    seasonalPaxRate.value = 0;
    seasonalKidsPaxRate.value = 0;

    toast.success("Seasonal pricing deactivated successfully!");
  } catch (error) {
    console.error("Error deactivating seasonal pricing:", error);
    toast.error("Error deactivating seasonal pricing");
  }
};

onMounted(() => {
  document.addEventListener("click", (e) => {
    if (statusDropdown.value && !statusDropdown.value.contains(e.target)) {
      isStatusOpen.value = false;
    }
    if (regionDropdown.value && !regionDropdown.value.contains(e.target)) {
      isRegionFilterOpen.value = false;
    }
  });
});
</script>

<style scoped>
.list-enter-active,
.list-leave-active {
  transition: all 0.3s ease;
}

.list-enter-from {
  opacity: 0;
  transform: translateY(-20px);
}

.list-leave-to {
  opacity: 0;
  transform: translateX(20px);
}

.list-move {
  transition: transform 0.3s ease;
}
</style>