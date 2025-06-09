<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="relative bg-white rounded-2xl border-2 border-gray-300 shadow-2xl w-full max-w-4xl px-8 py-8">
      <!-- Close button -->
      <button
        class="absolute top-4 right-4 text-2xl text-black hover:text-[#217093] font-bold"
        @click="$emit('close')"
        aria-label="Close"
      >×</button>
      <h2 class="text-center text-lg font-bold mb-6">New Booking Entry</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left: Booking Form -->
        <div>
          <div class="mb-4">
            <label class="block font-semibold mb-1">Customer Name</label>
            <input
              type="text"
              class="w-full rounded-xl border-2 border-gray-300 px-4 py-2 focus:border-[#217093] focus:ring-[#217093]"
              value="Kurt Allen Esmeria"
            />
          </div>
          <div class="mb-4">
            <label class="block font-semibold mb-1">Package Name</label>
            <select class="w-full rounded-xl border-2 border-gray-300 px-4 py-2 focus:border-[#217093] focus:ring-[#217093]">
              <option>Puerto Travel Getaway</option>
              <option>Baguio Tour</option>
              <option>Boracay Escape</option>
            </select>
          </div>
          <div class="mb-2 font-semibold">Travellers</div>
          <div class="flex items-center mb-4">
            <div class="flex-1">Regular</div>
            <div class="flex-1 text-center">P XXXX</div>
            <div class="flex-1 flex items-center justify-end gap-2">
              <button class="w-8 h-8 rounded-full bg-gray-200 text-lg font-bold flex items-center justify-center">-</button>
              <input type="text" class="w-10 text-center rounded border border-gray-300" value="2" readonly />
              <button class="w-8 h-8 rounded-full bg-gray-200 text-lg font-bold flex items-center justify-center">+</button>
            </div>
          </div>
          <div class="mb-4">
            <label class="block font-semibold mb-1">Upload Discount ID:</label>
            <button class="flex items-center gap-2 bg-[#c6e6f7] text-[#217093] px-4 py-2 rounded-lg font-semibold">
              <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
              </svg>
              Add Image
            </button>
          </div>
          <div class="mb-4">
            <label class="block font-semibold mb-1">Enter voucher code:</label>
            <input
              type="text"
              class="w-full rounded-xl border-2 border-gray-300 px-4 py-2 focus:border-[#217093] focus:ring-[#217093]"
            />
          </div>
        </div>
        <!-- Right: Booking Summary -->
        <div>
          <div class="bg-gray-900 text-white rounded-xl p-6 mb-4 min-h-[270px]">
            <div class="font-semibold mb-2">Tour Name</div>
            <div class="text-sm mb-2">Starting Date: MM/DD/YY</div>
            <div class="mb-2">
              <div class="flex justify-between">
                <span>Adult P XXXX x (2)</span>
                <span>P XXXX</span>
              </div>
              <div class="flex justify-between">
                <span>Senior/Kid P XXXX x (2)</span>
                <span>P XXXX</span>
              </div>
            </div>
            <div class="flex justify-between font-bold border-t border-gray-600 pt-2 mt-2">
              <span>Total :</span>
              <span>P XXXX</span>
            </div>
          </div>
          <div class="flex justify-center">
            <button class="rounded-xl bg-gray-200 px-8 py-2 text-gray-900 font-semibold hover:bg-gray-300 transition">Confirm</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>