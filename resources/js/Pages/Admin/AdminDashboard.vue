<template>
  <div class="pb-10 bg-gray-50 min-h-screen">
    <div class="flex flex-wrap gap-4 mb-4 justify-between">
      <div class="flex-1 min-w-0">
        <div class="bg-white text-black rounded-lg p-6 flex flex-col h-[430px]">
          <PackagesChart />
        </div>
      </div>

      <div class="flex-1 min-w-0">
        <div class="bg-white text-black rounded-lg p-6 flex flex-col h-[430px]">
          <BookingsChart />
        </div>
      </div>

      <div class="flex-1 min-w-0">
        <div class="bg-white text-black rounded-lg p-6 flex flex-col h-[430px]">
          <PaymentsChart />
        </div>
      </div>

      <div class="flex-1 min-w-0">
        <div class="bg-white text-black rounded-lg p-6 flex flex-col h-[430px]">
          <TravelDestinationChart />
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl p-8 shadow-lg mb-8">
      <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Sales Overview</h2>
        <div
          class="flex text-sm font-medium text-gray-500 bg-gray-100 p-1 rounded-lg"
        >
          <span
            class="px-3 py-1 cursor-pointer rounded-md text-blue-600 bg-white shadow-sm transition-colors"
          >
            Monthly
          </span>
          <span
            class="px-3 py-1 cursor-pointer transition-colors hover:text-gray-700"
          >
            Yearly
          </span>
        </div>
      </div>
      <SalesChart />
    </div>

    ---

    <div class="space-y-6 pt-4">
      <h3 class="text-xl font-semibold text-gray-800">
        Approved & Paid Bookings
      </h3>

      <div class="flex flex-col gap-5">
        <div
          class="bg-white rounded-xl p-4 shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300"
        >
          <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-4"
          >
            <div class="space-y-1">
              <div class="font-bold text-lg text-blue-700">
                Baguio Tour - 3 Days & 2 Nights
              </div>
              <div class="text-sm text-gray-500">Customer: John Doe</div>
            </div>

            <div
              class="mt-3 sm:mt-0 flex flex-wrap gap-4 text-sm text-gray-600 font-medium"
            >
              <span
                class="flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-700 rounded-full"
              >
                <i class="fa fa-users"></i> 10 pax
              </span>
              <span
                class="flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-full"
              >
                Booking Type: Exclusive
              </span>
            </div>
          </div>

          <div
            class="flex flex-col md:flex-row justify-between gap-4 text-gray-600"
          >
            <div class="space-y-1 text-sm">
              <div class="flex items-center gap-2">
                <i class="fa fa-calendar text-gray-400 w-4"></i>
                <span class="font-medium text-gray-700">10 January 2025</span>
              </div>
              <div>Note: Senior/PWD is applied</div>
            </div>

            <div class="space-y-1 text-sm">
              <div class="flex items-center gap-2">
                Payment Status:
                <span
                  class="text-green-600 font-bold flex items-center gap-1 bg-green-50 px-3 py-1 rounded-full"
                >
                  <i class="fa fa-check-circle"></i> Verified
                </span>
              </div>
            </div>
          </div>
        </div>

        <div
          class="bg-white rounded-xl p-4 shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300"
        >
          <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-4"
          >
            <div class="space-y-1">
              <div class="font-bold text-lg text-blue-700">
                La Union Tour - 3 Days & 2 Nights
              </div>
              <div class="text-sm text-gray-500">
                Customers: John Doe, Michael Herb, Jane Dani
              </div>
            </div>

            <div
              class="mt-3 sm:mt-0 flex flex-wrap gap-4 text-sm text-gray-600 font-medium"
            >
              <span
                class="flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-700 rounded-full"
              >
                <i class="fa fa-users"></i> 10 pax
              </span>
              <span
                class="flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-full"
              >
                Booking Type: Joint
              </span>
            </div>
          </div>

          <div
            class="flex flex-col md:flex-row justify-between gap-4 text-gray-600"
          >
            <div class="space-y-1 text-sm">
              <div class="flex items-center gap-2">
                <i class="fa fa-calendar text-gray-400 w-4"></i>
                <span class="font-medium text-gray-700">2 January 2025</span>
              </div>
              <div>Note: Senior/PWD is applied</div>
              <div>Note: N/A</div>
            </div>

            <div class="space-y-1 text-sm">
              <div class="flex items-center gap-2">
                Payment Status:
                <span
                  class="text-green-600 font-bold flex items-center gap-1 bg-green-50 px-3 py-1 rounded-full"
                >
                  <i class="fa fa-check-circle"></i> Verified
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="flex justify-center pt-6">
        <button
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-10 py-3 text-base transition-colors shadow-md hover:shadow-lg"
        >
          See All Bookings
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import AdminIndex from "./AdminIndex.vue";
import PackagesChart from "./components/Analytics/PackagesChart.vue";
import BookingsChart from "./components/Analytics/BookingsChart.vue";
import PaymentsChart from "./components/Analytics/PaymentsChart.vue";
import TravelDestinationChart from "./components/Analytics/TravelDestinationChart.vue";
import SalesChart from "./components/Analytics/SalesChart.vue";

defineOptions({ layout: AdminIndex });
</script>
