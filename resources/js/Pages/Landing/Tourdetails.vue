<script setup>
import LandingIndex from './LandingIndex.vue'
defineOptions({ layout: LandingIndex })
</script>

<template>
  <div class="bg-[#fcfcfc] min-h-screen w-full flex flex-col items-center">
    <!-- Main Container -->
    <div class="w-full max-w-[1400px] px-2 md:px-8 py-8 flex flex-col">
      <!-- Tour Title -->
      <h2 class="text-2xl font-bold text-[#ff7f2a] mb-2">La Union Tour</h2>
      <hr class="border-[#ff7f2a] border-t-2 w-40 md:w-80 mb-6" />

      <!-- Main Content Row -->
      <div class="flex flex-col lg:flex-row gap-8 w-full">
        <!-- Left Side: Main Image, Description, Tabs, Terms -->
        <div class="flex-1 min-w-0 max-w-full">
          <!-- Main Image -->
          <div class="rounded-2xl overflow-hidden mb-6 bg-gray-200 flex items-center justify-center w-full" style="height:340px;">
            <span class="text-gray-500 text-lg"></span>
          </div>
          <!-- Description -->
          <h3 class="font-bold text-xl mb-2 text-[#222]">Description</h3>
          <p class="text-base text-gray-800 mb-4">
            Ready to leave work behind for ocean breezes and swap your busy schedule for some quality time by the sea? La Union awaits, and you won't want to miss it. Known as the Surfing Capital of the North, this coastal spot is more than just a surfer's paradise. It's where you can enjoy the sun, take in amazing views, and relax. Go on an exciting hike to Tangadan Falls or find peace at the Ma-Cho Temple, which offers a beautiful ocean view. Whether you're looking for adventure or downtime, La Union has unforgettable moments. And the food! Crispy bagnet, tasty Vigan longganisa, and seafood so fresh it melts in your mouth.
          </p>
          <!-- Tabs -->
          <div class="tabs-row mb-4">
            <button class="tab-btn">Itinerary</button>
            <button class="tab-btn tab-btn-active">Terms & Conditions</button>
            <button class="tab-btn">Exclusions</button>
          </div>
          <!-- Terms & Conditions Content -->
          <div class="mb-8">
            <h3 class="font-bold text-[#ff7f2a] mb-2">Terms & Conditions</h3>
            <div class="text-base text-gray-800">
              <p>
                These Terms and Conditions govern the use of services provided by Traveller Laguna. By confirming booking with our agency, customers must consider the terms outlined below.
              </p>
              <ol class="list-decimal ml-6 mt-2">
                <li class="mb-2">
                  <b>Booking and Reservations Confirmation:</b>
                  All bookings required a confirmed down payment to secure reservations.
                  <span class="text-[#ff7f2a]"> The prices are subject to change until full payment is received and confirmed.</span>
                  Full payment must be settled on or before the specified due date.
                </li>
                <li class="mb-2">
                  <b>Cancellation and Refund Policy:</b>
                  Cancellations must be submitted before the specified date of booking and must be submitted through emails or other contacts. Refunds are subject to the policies of third-party providers (airlines, hotels, etc.). Non-refundable service fees and penalties may apply and no refund will be issued for unused services.
                </li>
                <li>
                  <b>Changes and Amendments:</b>
                  Traveller Laguna reserves the right to modify itineraries due to unforeseen circumstances. Clients will be notified of any changes, and reasonable alternatives will be provided. Additionally, any request for changes by the client after booking may incur additional charges.
                </li>
              </ol>
            </div>
          </div>
        </div>
        <!-- Right Side: Booking Card + Related Trips -->
        <div class="flex flex-col gap-8 w-full lg:w-[320px] xl:w-[350px] 2xl:w-[400px] min-w-[220px] max-w-[400px]">
          <!-- Booking Card -->
          <div
            class="rounded-2xl p-6 text-white shadow"
            style="background:#f28c3a;"
          >
            <div class="flex flex-col gap-2">
              <div class="flex justify-between items-start">
                <div>
                  <span>From</span><br>
                  <span class="font-semibold text-lg">₱ XXXX / per pax</span>
                </div>
                <span
                  class="bg-[#d95f00] px-4 py-2 rounded-lg text-white font-semibold text-right text-base leading-tight"
                  style="display:inline-block;"
                >
                  Starting from<br>
                  <span class="text-2xl font-bold">3 Days</span>
                </span>
              </div>
              <hr class="border-[#e6a86c] my-4" />
              <button
                class="w-full rounded-xl py-3 font-bold text-lg transition"
                style="background:#d95f00; color:white;"
              >
                BOOK NOW!
              </button>
            </div>
          </div>

          <!-- Related Trips (a bit wider) -->
          <div>
            <div class="font-bold text-lg mb-2 text-[#222] text-center">Related Trips</div>
            <div class="flex flex-col gap-6">
              <div class="flex flex-col items-center bg-white rounded-xl shadow p-4 w-full max-w-[200px] mx-auto">
                <div class="w-[160px] h-[150px] bg-gray-200 rounded-xl mb-2 flex items-center justify-center overflow-hidden">
                  <span class="text-gray-500"></span>
                </div>
                <div class="font-semibold text-[#ff7f2a]">₱ XXXX</div>
                <div class="text-[#ff7f2a] flex items-center gap-1">
                  <svg width="16" height="16" fill="none" stroke="#ff7f2a" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                  Baguio City
                </div>
                <div class="text-[#ff7f2a] flex items-center gap-1">
                  <svg width="16" height="16" fill="none" stroke="#ff7f2a" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                  4 Days
                </div>
                <button class="mt-2 px-4 py-2 border border-[#ff7f2a] text-[#ff7f2a] rounded-full font-semibold hover:bg-[#ff7f2a] hover:text-white transition">View Details</button>
              </div>
              <div class="flex flex-col items-center bg-white rounded-xl shadow p-4 w-full max-w-[200px] mx-auto">
                <div class="w-[160px] h-[150px] bg-gray-200 rounded-xl mb-2 flex items-center justify-center overflow-hidden">
                  <span class="text-gray-500"></span>
                </div>
                <div class="font-semibold text-[#ff7f2a]">₱ XXXX</div>
                <div class="text-[#ff7f2a] flex items-center gap-1">
                  <svg width="16" height="16" fill="none" stroke="#ff7f2a" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                  Panay, Capiz
                </div>
                <div class="text-[#ff7f2a] flex items-center gap-1">
                  <svg width="16" height="16" fill="none" stroke="#ff7f2a" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                  4 Days
                </div>
                <button class="mt-2 px-4 py-2 border border-[#ff7f2a] text-[#ff7f2a] rounded-full font-semibold hover:bg-[#ff7f2a] hover:text-white transition">View Details</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<style scoped>
.tabs-row {
  display: flex;
  gap: 8px;
}
.tab-btn {
  flex: 1;
  background: #ff7f2a;
  color: #fff;
  font-weight: 600;
  padding: 0.5rem 0;
  border: 2px solid #ff7f2a;
  border-radius: 0;
  transition: background 0.2s, color 0.2s;
}
.tab-btn:first-child {
  border-radius: 8px 0 0 8px;
}
.tab-btn:last-child {
  border-radius: 0 8px 8px 0;
}
.tab-btn:hover,
.tab-btn.tab-btn-active {
  background: #d95f00;
  color: #fff;
}
@media (max-width: 1024px) {
  .tabs-row {
    flex-direction: column;
  }
  .tab-btn:first-child,
  .tab-btn:last-child {
    border-radius: 8px;
  }
}
</style>