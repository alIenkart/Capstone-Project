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
          <div ref="reportRef" class="space-y-6">
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

          <div class="flex justify-end space-x-2 mt-6">
            <button @click="isModalOpen = false" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300">
              Cancel
            </button>
            <button @click="downloadData" :disabled="role === 'Staff'" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-lg">
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
  </div>
</template>

<script setup>
import AdminIndex from "./AdminIndex.vue";
import PackagesChart from "./components/Analytics/PackagesChart.vue";
import BookingsChart from "./components/Analytics/BookingsChart.vue";
import PaymentsChart from "./components/Analytics/PaymentsChart.vue";
import TravelDestinationChart from "./components/Analytics/TravelDestinationChart.vue";
import SalesChart from "./components/Analytics/SalesChart.vue";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import { onMounted, ref, watch, computed } from "vue";
import { api } from "../../api/api";
import { usePage } from "@inertiajs/vue3";

defineOptions({ layout: AdminIndex });

const page = usePage();
const role = page?.props?.auth?.user?.role;
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
const reportRef = ref(null);

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
  const pdfHeight = pdf.internal.pageSize.getHeight();
  const margin = 10; // 10mm margin on all sides

  const imgWidth = pdfWidth - 2 * margin;
  const imgHeight = (canvas.height * imgWidth) / canvas.width;

  let position = margin;

  if (imgHeight < pdfHeight - 2 * margin) {
    pdf.addImage(imgData, "PNG", margin, position, imgWidth, imgHeight);
  } else {
    let heightLeft = imgHeight;
    let pageCanvasHeight = ((pdfHeight - 2 * margin) * canvas.width) / imgWidth; // convert PDF height to canvas height
    let pageOffset = 0;

    while (heightLeft > 0) {
      const pageCanvas = document.createElement("canvas");
      pageCanvas.width = canvas.width;
      pageCanvas.height = pageCanvasHeight;

      const ctx = pageCanvas.getContext("2d");
      ctx.drawImage(
        canvas,
        0,
        pageOffset,
        canvas.width,
        pageCanvasHeight,
        0,
        0,
        canvas.width,
        pageCanvasHeight
      );

      const pageData = pageCanvas.toDataURL("image/png");
      pdf.addImage(pageData, "PNG", margin, margin, imgWidth, pdfHeight - 2 * margin);

      heightLeft -= pageCanvasHeight;
      pageOffset += pageCanvasHeight;

      if (heightLeft > 0) pdf.addPage();
    }
  }
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
