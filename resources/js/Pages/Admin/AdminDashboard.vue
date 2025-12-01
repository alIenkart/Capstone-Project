<template>
  <div class="pb-10 bg-gray-50 min-h-screen">

    <div class="flex justify-end mb-6">
    <div class="inline-flex text-sm font-medium text-gray-900 bg-gray-100 p-1 rounded-lg">
        <span :class="['px-3 py-1 cursor-pointer rounded-md shadow-sm transition-colors',
            selectedPeriod === 'Monthly' ? 'text-blue-600 bg-white' : 'hover:text-gray-700']"
          @click="selectedPeriod = 'Monthly'">
          Monthly
        </span>
        <span :class="['px-3 py-1 cursor-pointer rounded-md shadow-sm transition-colors',
            selectedPeriod === 'Yearly' ? 'text-blue-600 bg-white' : 'hover:text-gray-700']"
          @click="selectedPeriod = 'Yearly'">
          Yearly
        </span>
      </div>
      <button @click="isModalOpen = true" class="px-4 py-2 ml-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12m0 0l-4-4m4 4l4-4"/>
        </svg>
      </button>


      <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 w-[900px] relative max-h-[90vh] overflow-y-auto">
          <!-- <h2 class="text-lg font-semibold mb-4">Select Period to Download</h2>
          <div class="relative mb-6 w-48 ml-auto">
            <button @click="isPeriodOpen = !isPeriodOpen" class="w-full px-4 py-2 border border-gray-300 rounded-md text-left hover:border-blue-500 flex justify-between items-center">
              {{ selectedPeriod }}
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <div
              v-if="isPeriodOpen"
              class="absolute left-0 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl z-50"
            >
              <div
                @click="handlePeriodSelect('Monthly')"
                :class="['px-4 py-3 cursor-pointer flex justify-between hover:bg-blue-50', selectedPeriod === 'Monthly' ? 'bg-blue-50 border-l-4 border-blue-500' : '']"
              >
                <span :class="selectedPeriod === 'Monthly' ? 'text-blue-700 font-medium' : 'text-gray-700 font-medium'">
                  Monthly
                </span>
                <svg v-if="selectedPeriod === 'Monthly'" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>

              <div
                @click="handlePeriodSelect('Yearly')"
                :class="['px-4 py-3 cursor-pointer flex justify-between hover:bg-blue-50', selectedPeriod === 'Yearly' ? 'bg-blue-50 border-l-4 border-blue-500' : '']"
              >
                <span :class="selectedPeriod === 'Yearly' ? 'text-blue-700 font-medium' : 'text-gray-700 font-medium'">
                  Yearly
                </span>
                <svg v-if="selectedPeriod === 'Yearly'" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
            </div>
          </div> -->

          <!-- Report Tables -->
          <div class="space-y-6">
           <h2 class="text-2xl font-semibold text-gray-800 mb-4">
              <div class="flex items-center justify-center gap-3">
                <img
                  src="/storage/logo/Logo.png"
                  alt="JE Travel & Tours"
                  class="w-16 h-16 object-contain"
                />
                <span>JE Travel & Tours Analytics Report for {{ reportLabel }}</span>
              </div>
            </h2>

            <h3 class="font-semibold text-lg mt-4 mb-2">Sales Overview</h3>
            <table class="w-full border border-gray-200 mb-4">
              <thead>
                <tr class="bg-gray-100">
                  <th class="px-4 py-2 border">{{ selectedPeriod === 'Monthly' ? 'Month' : 'Year' }}</th>
                  <th class="px-4 py-2 border">Revenue</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in revenue" :key="item.month || item.year">
                  <td class="px-4 py-2 border">{{ formatMonthYear(item.month || item.year) }}</td>  
                  <td class="px-4 py-2 border">{{ item.total_revenue }}</td>
                </tr>
              </tbody>
            </table>

            <h3 class="font-semibold text-lg mt-4 mb-2">Packages</h3>
            <table class="w-full border border-gray-200 mb-4">
              <thead>
                <tr class="bg-gray-100">
                  <th class="px-4 py-2 border">Status</th>
                  <th class="px-4 py-2 border">Count</th>
                </tr>
              </thead>
              <tbody>
                <tr><td class="px-4 py-2 border">Active</td><td class="px-4 py-2 border">{{ activePackages }}</td></tr>
                <tr><td class="px-4 py-2 border">Inactive</td><td class="px-4 py-2 border">{{ inactivePackages }}</td></tr>
                <tr class="font-semibold"><td class="px-4 py-2 border">Total Packages Created</td><td class="px-4 py-2 border">{{ activePackages + inactivePackages }}</td></tr>
              </tbody>
            </table>

            <h3 class="font-semibold text-lg mt-4 mb-2">Bookings</h3>
            <table class="w-full border border-gray-200 mb-4">
              <thead>
                <tr class="bg-gray-100">
                  <th class="px-4 py-2 border">Status</th>
                  <th class="px-4 py-2 border">Count</th>
                </tr>
              </thead>
              <tbody>
                <tr><td class="px-4 py-2 border">Approved</td><td class="px-4 py-2 border">{{ approvedBooking }}</td></tr>
                <tr><td class="px-4 py-2 border">Pending</td><td class="px-4 py-2 border">{{ pendingBooking }}</td></tr>
                <tr><td class="px-4 py-2 border">Cancelled</td><td class="px-4 py-2 border">{{ cancelledBooking }}</td></tr>
                <tr><td class="px-4 py-2 border">Rejected</td><td class="px-4 py-2 border">{{ rejectedBooking }}</td></tr>
                <tr class="font-semibold bg-gray-50">
                <td class="px-4 py-2 border">Total Bookings</td>
                <td class="px-4 py-2 border">
                  {{ approvedBooking + pendingBooking + cancelledBooking + rejectedBooking }}
                </td>
                </tr>
              </tbody>
            </table>

            <!-- Payments Table -->
            <h3 class="font-semibold text-lg mt-4 mb-2">Payments</h3>
            <table class="w-full border border-gray-200 mb-4">
              <thead>
                <tr class="bg-gray-100">
                  <th class="px-4 py-2 border">Type</th>
                  <th class="px-4 py-2 border">Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="px-4 py-2 border">Fully Paid</td>
                  <td class="px-4 py-2 border">{{ fullyPaid }}</td>
                </tr>
                <tr>
                  <td class="px-4 py-2 border">Down Payment</td>
                  <td class="px-4 py-2 border">{{ downPayment }}</td>
                </tr>
                <tr>
                  <td class="px-4 py-2 border">Under Review</td>
                  <td class="px-4 py-2 border">{{ underReview }}</td>
                </tr>
                <!-- <tr class="font-semibold bg-gray-50">
                  <td class="px-4 py-2 border">Total Payments</td>
                  <td class="px-4 py-2 border">
                  {{ Number(fullyPaid) + Number(downPayment) + Number(underReview) }}
                  </td>
                </tr> -->
              </tbody>
            </table>


            <h3 class="font-semibold text-lg mt-4 mb-2">Top Travel Destinations</h3>
            <table class="w-full border border-gray-200 mb-4">
              <thead>
                <tr class="bg-gray-100">
                  <th class="px-4 py-2 border">Destinations</th>
                  <th class="px-4 py-2 border">Bookings</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(count, dest) in destinations" :key="dest">
                  <td class="px-4 py-2 border">{{ dest }}</td>
                  <td class="px-4 py-2 border">{{ count }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Modal Footer -->
          <div class="flex justify-end space-x-2 mt-6">
            <button @click="isModalOpen = false" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300">
              Cancel
            </button>
            <button @click="downloadData" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
              Download
            </button>
          </div>

        </div>
      </div>
    </div>
      
    <div class="flex flex-wrap gap-4 mb-4 justify-between">
      <div class="flex-1 min-w-0">
        <div class="bg-white text-black rounded-lg p-6 flex flex-col h-[430px]">
          <PackagesChart
            :activePackages="activePackages"
            :inactivePackages="inactivePackages"
          />
        </div>
      </div>

      <div class="flex-1 min-w-0">
        <div class="bg-white text-black rounded-lg p-6 flex flex-col h-[430px]">
          <BookingsChart 
            :approvedBooking="approvedBooking"
            :pendingBooking="pendingBooking"
            :rejectedBooking="rejectedBooking"
            :cancelledBooking="cancelledBooking"
          />
        </div>
      </div>

      <div class="flex-1 min-w-0">
        <div class="bg-white text-black rounded-lg p-6 flex flex-col h-[430px]">
          <PaymentsChart 
            :fullyPaid="fullyPaid"
            :downPayment="downPayment"
            :underReview="underReview"
          />
        </div>
      </div>

      <div class="flex-1 min-w-0">
        <div class="bg-white text-black rounded-lg p-6 flex flex-col h-[430px]">
          <TravelDestinationChart 
            :destinations="destinations"
          />
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl p-8 shadow-lg mb-8">
      <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Sales Overview</h2>
      </div>
      <SalesChart 
        :revenue="revenue"
      />
    </div>


    <div class="space-y-6 pt-4">
      <!-- <h3 class="text-xl font-semibold text-gray-800">
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
      </div> -->
      
      <!-- <div class="flex justify-center pt-6">
        <button
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-10 py-3 text-base transition-colors shadow-md hover:shadow-lg"
        >
          See All Bookings
        </button>
      </div> -->
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
import { onMounted, ref, watch, computed } from "vue";
import { api } from "../../api/api";

defineOptions({ layout: AdminIndex });
const service = new api();
const data = ref({});
const selectedPeriod = ref('Monthly');
const activePackages = ref(0);
const inactivePackages = ref(0);
const approvedBooking = ref(0);
const pendingBooking = ref(0);
const rejectedBooking = ref(0);
const cancelledBooking = ref(0);
const fullyPaid = ref(0);
const downPayment = ref(0);
const underReview = ref(0);
const destinations = ref([]);
const revenue = ref([]);
const isModalOpen = ref(false)
const isPeriodOpen = ref(false)

const fetchData = async (period) => {
  try {
    const response = await service.fetchAnalyticsData(period);
    data.value = response.data;

    activePackages.value = data.value.data.packages.active_packages;
    inactivePackages.value = data.value.data.packages.inactive_packages;
    approvedBooking.value = data.value.data.bookings.approved;
    pendingBooking.value = data.value.data.bookings.pending;
    rejectedBooking.value = data.value.data.bookings.rejected;
    cancelledBooking.value = data.value.data.bookings.cancelled;
    fullyPaid.value = data.value.data.payments.fully_paid;
    downPayment.value = data.value.data.payments.down_payment;
    underReview.value = data.value.data.payments.under_review;
    destinations.value = data.value.data.destinations;
    revenue.value = data.value.data.revenue;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

const downloadData = async () => {
  const element = reportRef.value;
  if (!element) return;

  isModalOpen.value = false;

  const canvas = await html2canvas(element, { scale: 2 });
  const imgData = canvas.toDataURL("image/png");

  const pdf = new jsPDF("p", "mm", "a4");

  const pdfWidth = pdf.internal.pageSize.getWidth();
  const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

  pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);

  pdf.save(`JE-Analytics-Report-${reportLabel.value}.pdf`);
};

const reportLabel = computed(() => {
  const now = new Date();

  if (selectedPeriod.value === "Yearly") {
    return now.getFullYear(); 
  }

  return now.toLocaleString("en-US", { month: "long", year: "numeric" });
});

const handlePeriodSelect = (period) => {
  selectedPeriod.value = period
  isPeriodOpen.value = false
}

const formatMonthYear = (value) => {
  if (!value) return '-';

  if (/^\d{4}$/.test(value)) return value;
 
  if (/^\d{4}-\d{2}$/.test(value)) {
    const [year, month] = value.split('-').map(Number);
    const date = new Date(year, month - 1);
    return date.toLocaleString('en-US', { month: 'long', year: 'numeric' }); // e.g., "December 2025"
  }

  return value;
};

watch(selectedPeriod, (newPeriod) => {
  fetchData(newPeriod);
});

onMounted(() => {
  fetchData(selectedPeriod.value);
});
</script>
