<script setup>
import LandingIndex from './LandingIndex.vue'
defineOptions({ layout: LandingIndex })
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
        <span class="w-4 h-4 rounded-full border-2 border-[#ff7f2a] flex items-center justify-center">
          <span class="w-2 h-2 rounded-full bg-[#ff7f2a]"></span>
        </span>
        <span class="ml-1 text-[#ff7f2a] font-semibold text-base border-b-2 border-[#ff7f2a] pb-0.5">Select Package</span>
      </div>
      <span class="w-16 h-0.5 bg-[#ff7f2a] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#ff7f2a] flex items-center justify-center"></span>
        <span class="ml-1 text-[#ff7f2a] font-semibold text-base">Confirmation</span>
      </div>
    </div>
    <!-- Main Content -->
    <div class="flex flex-row w-full max-w-6xl justify-center gap-8">
      <!-- Left Side: Package Selection -->
      <div class="flex-1">
        <div class="font-bold text-xl mb-4 text-[#f28c3a]">Package Type</div>
        <select class="w-full border-2 border-[#f28c3a] rounded-xl px-4 py-3 mb-6 text-[#f28c3a] bg-white focus:outline-none focus:ring-2 focus:ring-[#ff7f2a]">
          <option>La Union Travel Getaway - 3 Days & 2 Nights</option>
        </select>
        <div class="flex w-full mb-2">
          <div class="flex-1 font-semibold text-[#f28c3a]">Travellers</div>
          <div class="flex-1 font-semibold text-[#f28c3a] text-center">Rate</div>
          <div class="flex-1 font-semibold text-[#f28c3a] text-right">Quantity</div>
        </div>
        <div class="w-full flex items-center bg-[#f28c3a] rounded-xl px-6 py-5 mb-6">
          <div class="flex-1 text-white font-medium text-lg">Regular</div>
          <div class="flex-1 text-white font-medium text-lg text-center">P XXXX</div>
          <div class="flex-1 flex items-center justify-end gap-2">
            <button class="w-8 h-8 rounded-full bg-white text-[#f28c3a] font-bold text-lg flex items-center justify-center border border-[#f28c3a] hover:bg-[#ffe5d0]">-</button>
            <input type="text" value="10" class="w-14 h-8 rounded-lg text-center border border-[#f28c3a] bg-white text-[#f28c3a] font-semibold" readonly>
            <button class="w-8 h-8 rounded-full bg-white text-[#f28c3a] font-bold text-lg flex items-center justify-center border border-[#f28c3a] hover:bg-[#ffe5d0]">+</button>
          </div>
        </div>
        <div class="mb-4">
          <div class="font-medium text-[#f28c3a] mb-2">Upload Discount ID:</div>
          <div class="flex items-center gap-3">
            <label class="flex items-center px-4 py-2 bg-[#b3d8f7] text-[#2471a3] rounded-lg cursor-pointer">
              <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 16v-4m0 0V8m0 4h4m-4 0H8m12 4v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4"></path></svg>
              Add Image
              <input type="file" class="hidden" />
            </label>
            <div class="flex items-center bg-gray-100 px-3 py-2 rounded">
              <img src="https://via.placeholder.com/24" alt="sample" class="w-6 h-6 mr-2 rounded" />
              <span class="text-gray-700 text-sm">sample.jpeg</span>
              <button class="ml-2 text-gray-500 hover:text-red-500 font-bold text-lg">&times;</button>
            </div>
          </div>
        </div>
        <div class="mb-4">
          <div class="font-medium text-[#f28c3a] mb-2">Enter voucher code:</div>
          <input type="text" class="w-64 border-2 border-[#f28c3a] rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff7f2a] bg-white text-[#f28c3a]" />
        </div>
      </div>
      <!-- Right Side: Summary Card -->
      <div class="w-full max-w-sm bg-[#f28c3a] rounded-xl p-8 flex flex-col justify-between min-h-[350px]">
        <div>
          <div class="font-bold text-white text-lg mb-2">La Union Travel Getaway - 3 Days</div>
          <div class="text-white mb-4">
            <div>Starting Date: <span class="text-white">MM/DD/YY</span></div>
          </div>
          <div class="text-white mb-4">
            <div class="mb-1">Travellers</div>
            <div class="flex justify-between">
              <span>Rate P XXXX x (10)</span>
              <span>P XXXX</span>
            </div>
            <div class="flex justify-between">
              <span>Discount ID</span>
              <span>- 20%</span>
            </div>
          </div>
          <div class="flex justify-between items-center font-bold text-white text-lg mt-4">
            <span>Total :</span>
            <span>P XXXX</span>
          </div>
          <hr class="border-[#ffb97a] my-4" />
        </div>
        <button class="w-full rounded-full py-3 font-bold text-lg transition bg-[#d95f00] text-white hover:bg-[#b94c00] mt-2">
          Proceed
        </button>
      </div>
    </div>
  </div>
</template>