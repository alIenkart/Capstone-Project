<script setup>
import LandingIndex from './LandingIndex.vue'
defineOptions({ layout: LandingIndex })
</script>
<template>
  <div class="w-full min-h-screen bg-white">
    <!-- Header -->
    <div class="w-full bg-[#f28c3a] py-3 px-8">
      <h2 class="text-white text-2xl font-semibold">My Bookings</h2>
    </div>
    <div class="flex w-full h-[calc(100vh-56px)]">
      <!-- Sidebar -->
      <div class="w-80 bg-[#f7f7f7] border-r border-gray-200 h-full">
        <div class="flex flex-col gap-4 py-4">
          <!-- Active Booking -->
          <div class="flex items-center justify-between bg-[#f28c3a] text-white px-6 py-4 cursor-pointer rounded-lg">
            <div>
              <div class="font-semibold">Baguio Tour - 3 Days</div>
              <div class="flex items-center gap-2 text-xs mt-1">
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3M16 7V3M3 11h18M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>
                  2 April 2025
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 0 1 6 6c0 4-6 10-6 10S4 12 4 8a6 6 0 0 1 6-6zm0 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                  10
                </span>
              </div>
            </div>
            <span class="text-xs">B10125</span>
          </div>
          <!-- Inactive Booking -->
          <div class="flex items-center justify-between bg-[#eaeaea] text-[#444] px-6 py-4 cursor-pointer rounded-lg">
            <div>
              <div class="font-semibold">La Union Tour- 3 Days</div>
              <div class="flex items-center gap-2 text-xs mt-1">
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3M16 7V3M3 11h18M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>
                  10 January 2025
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 0 1 6 6c0 4-6 10-6 10S4 12 4 8a6 6 0 0 1 6-6zm0 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                  4
                </span>
              </div>
            </div>
            <span class="text-xs">B10225</span>
          </div>
        </div>
      </div>
      <!-- Main Content -->
      <div class="flex-1 bg-white p-8">
        <div class="flex justify-between items-start">
          <div>
            <div class="text-2xl font-semibold mb-2">Baguio Tour - 3 Days</div>
            <div class="flex flex-wrap gap-6 mb-2 text-base">
              <div class="flex items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3M16 7V3M3 11h18M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>
                2 April 2025
              </div>
              <div class="flex items-center gap-1">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 0 1 6 6c0 4-6 10-6 10S4 12 4 8a6 6 0 0 1 6-6zm0 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                10
              </div>
              <div>Booking Type: <span class="font-semibold">Exclusive</span></div>
              <div>Booking Date: <span class="font-semibold">26 March 2025</span></div>
            </div>
            <div class="flex flex-wrap gap-6 mb-4 text-base">
              <div>Total Amount Due: <span class="font-semibold">P XXXX</span></div>
              <div>Booking Status: <span class="bg-green-400 text-white px-3 py-1 rounded-full text-sm">Confirmed</span></div>
              <div>Payment Status: <span class="bg-yellow-400 text-white px-3 py-1 rounded-full text-sm">Pending</span></div>
            </div>
          </div>
          <div class="flex flex-col items-end gap-2">
            <span class="text-base font-semibold">B10125</span>
            <button class="bg-[#f28c3a] hover:bg-[#e67c1a] text-white px-4 py-2 rounded-lg font-semibold transition">Cancel Booking</button>
          </div>
        </div>
        <div class="flex gap-12 mt-8">
          <!-- QR and Note -->
          <div>
            <div class="text-center font-medium mb-2">Dorie Magjobos<br /><span class="text-xs text-gray-500">XXXX XXX 1200</span></div>
            <div class="flex justify-center">
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=sample" alt="QR Code" class="bg-white rounded-lg border p-2" />
            </div>
            <div class="text-center text-xs text-red-500 mt-2">Note: Scan this QR code. Make sure to pay the exact amount</div>
          </div>
          <!-- Upload Payment Receipt -->
          <div class="flex-1">
            <div class="font-medium mb-2">Upload Payment Receipt</div>
            <div class="flex items-center gap-3 mb-4">
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
              <button class="bg-[#f28c3a] hover:bg-[#e67c1a] text-white px-8 py-2 rounded-lg font-semibold transition">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>