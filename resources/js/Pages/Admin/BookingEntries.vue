<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
    <div class="max-w-[1600px] mx-auto">
      <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div
          class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4"
        >
          <div class="relative flex-1 max-w-md">
            <svg
              class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search bookings..."
              class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
            />
          </div>

          <div class="flex items-center gap-3 flex-wrap">
            <div class="relative" data-filter-container>
              <button
                @click="isFilterOpen = !isFilterOpen"
                data-filter-button
                class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 group min-w-[200px]"
              >
                <div class="flex items-center gap-2">
                  <svg
                    class="w-5 h-5 text-blue-600"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                    ></path>
                  </svg>
                  <span class="font-semibold text-gray-800">
                    {{ statusFilter === "" ? "All Status" : statusFilter }}
                  </span>
                </div>
                <svg
                  :class="[
                    'w-5 h-5 text-blue-600 transition-transform duration-300',
                    isFilterOpen ? 'rotate-180' : '',
                  ]"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div
                v-if="isFilterOpen"
                data-filter-menu
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden"
              >
                <div
                  v-for="option in filterOptions"
                  :key="option"
                  @click="handleFilterSelect(option)"
                  :class="[
                    'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                    (option === '' && statusFilter === '') ||
                    (option !== '' && statusFilter === option)
                      ? 'bg-blue-50 border-l-4 border-l-blue-500'
                      : '',
                  ]"
                >
                  <span
                    :class="[
                      'font-medium',
                      (option === '' && statusFilter === '') ||
                      (option !== '' && statusFilter === option)
                        ? 'text-blue-700'
                        : 'text-gray-700',
                    ]"
                  >
                    {{ option === "" ? "All Status" : option }}
                  </span>
                  <svg
                    v-if="
                      (option === '' && statusFilter === '') ||
                      (option !== '' && statusFilter === option)
                    "
                    class="w-5 h-5 text-blue-600 ml-auto"
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

            <div class="relative" data-tour-filter-container>
              <button
                @click="isTourTypeFilterOpen = !isTourTypeFilterOpen"
                data-tour-filter-button
                class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 group min-w-[200px]"
              >
                <div class="flex items-center gap-2">
                  <svg
                    class="w-5 h-5 text-blue-600"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                    ></path>
                  </svg>
                  <span class="font-semibold text-gray-800">
                    {{
                      tourTypeFilter === "" ? "All Tour Types" : tourTypeFilter
                    }}
                  </span>
                </div>
                <svg
                  :class="[
                    'w-5 h-5 text-blue-600 transition-transform duration-300',
                    isTourTypeFilterOpen ? 'rotate-180' : '',
                  ]"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div
                v-if="isTourTypeFilterOpen"
                data-tour-filter-menu
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden"
              >
                <div
                  v-for="option in tourTypeOptions"
                  :key="option"
                  @click="handleTourTypeSelect(option)"
                  :class="[
                    'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                    (option === '' && tourTypeFilter === '') ||
                    (option !== '' && tourTypeFilter === option)
                      ? 'bg-blue-50 border-l-4 border-l-blue-500'
                      : '',
                  ]"
                >
                  <span
                    :class="[
                      'font-medium',
                      (option === '' && tourTypeFilter === '') ||
                      (option !== '' && tourTypeFilter === option)
                        ? 'text-blue-700'
                        : 'text-gray-700',
                    ]"
                  >
                    {{ option === "" ? "All Tour Types" : option }}
                  </span>
                  <svg
                    v-if="
                      (option === '' && tourTypeFilter === '') ||
                      (option !== '' && tourTypeFilter === option)
                    "
                    class="w-5 h-5 text-blue-600 ml-auto"
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

            <button
              @click="openNewEntryModal"
              class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
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
                  d="M12 4v16m8-8H4"
                />
              </svg>
              Add New Entry
            </button>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr
                class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white"
              >
                <th class="px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Booking ID
                </th>
                <th class="hidden lg:table-cell px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Package ID
                </th>
                <th class="px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Tour Type
                </th>
                <th class="px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Customer Name
                </th>
                <th class="px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Status
                </th>
                <th class="hidden sm:table-cell px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Total Pax
                </th>
                <th class="hidden xl:table-cell px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Discount
                </th>
                <th class="hidden md:table-cell px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Entry Date
                </th>
                <th class="px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Total Sum
                </th>
                <th class="px-2 py-3 md:px-6 md:py-4 text-center text-xs md:text-sm font-semibold">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr v-if="filteredBookings.length === 0">
                <td colspan="10" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center gap-3">
                    <svg
                      class="w-16 h-16 text-gray-300"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    <div class="text-gray-500">
                      <p class="text-lg font-semibold">No bookings found</p>
                      <p class="text-sm">
                        Try adjusting your search or filters
                      </p>
                    </div>
                  </div>
                </td>
              </tr>
              <tr
                v-for="entry in filteredBookings"
                :key="entry.id"
                :class="[
                  'transition-colors',
                  getWarningInfo(entry) ? 'bg-amber-50/50 hover:bg-amber-100/50' : 'hover:bg-blue-50/50'
                ]"
              >
                <td
                  class="px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm font-medium text-gray-900 text-center"
                >
                  <span
                    class="inline-flex items-center px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-semibold"
                  >
                    #{{ entry.id }}
                  </span>
                </td>
                <td
                  class="hidden lg:table-cell px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm font-medium text-gray-700 text-center"
                >
                  {{ entry.package_id }}
                </td>
                <td
                  class="px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm font-medium text-gray-700 text-center"
                >
                  {{ entry.tour_type }}
                </td>
                <td
                  class="px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm font-medium text-gray-900 text-center"
                >
                  {{ entry.customer_name }}
                </td>
                <td class="px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm text-center">
                  <span
                    :class="{
                      'font-medium bg-green-100 text-green-700':
                        entry.status === 'Approved',
                      'font-medium bg-yellow-100 text-yellow-700':
                        entry.status === 'Pending',
                      'font-medium bg-red-100 text-red-700':
                        entry.status === 'Rejected',
                      'font-medium bg-gray-100 text-gray-700': ![
                        'Approved',
                        'Pending',
                        'Rejected',
                      ].includes(entry.status),
                    }"
                    class="inline-flex items-center px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-semibold"
                  >
                    {{ entry.status }}
                  </span>
                  <div v-if="getWarningInfo(entry)" class="mt-1.5 flex flex-col items-center group relative">
                    <div class="flex items-center gap-1 text-amber-600 animate-pulse">
                      <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-[10px] font-bold uppercase tracking-tight">Warning</span>
                    </div>
                    <!-- Clean Tooltip -->
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2.5 bg-gray-900 text-white text-[10px] rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-all duration-200 pointer-events-none z-50 text-center leading-relaxed">
                      {{ getWarningInfo(entry) }}
                      <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                    </div>
                  </div>
                </td>
                <td
                  class="hidden sm:table-cell px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm font-medium text-gray-700 text-center"
                >
                  {{ entry.total_quantity }}
                </td>
                <td class="hidden xl:table-cell px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm font-medium text-center">
                  <span
                    v-if="entry.discount_images"
                    class="inline-flex items-center gap-1 text-green-600 font-medium"
                  >
                    <svg
                      class="w-4 h-4 md:w-5 md:h-5"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    Yes
                  </span>
                  <span v-else class="text-gray-500 font-medium">No</span>
                </td>
                <td
                  class="hidden md:table-cell px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm font-medium text-gray-700 text-center"
                >
                  {{
                    new Date(entry.created_at).toLocaleString("en-US", {
                      month: "short",
                      day: "numeric",
                      year: "numeric",
                      hour: "numeric",
                      minute: "2-digit",
                      hour12: true,
                    })
                  }}
                </td>
                <td
                  class="px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm font-semibold text-gray-700 text-center"
                >
                ₱{{ (entry.total_price) - (entry.discount_amount || 0) }}
                </td>
                <td class="px-2 py-3 md:px-6 md:py-4 text-xs md:text-sm text-center">
                  <button
                    @click="openUpdateEntryModal(entry)"
                    class="inline-flex items-center gap-1 px-2 py-1.5 md:gap-1.5 md:px-4 md:py-2 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white rounded-lg font-medium transition-all shadow hover:shadow-lg transform hover:-translate-y-0.5"
                  >
                    <svg
                      class="w-3.5 h-3.5 md:w-4 md:h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                      />
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                      />
                    </svg>
                    <span class="hidden md:inline">Review</span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <p class="text-sm text-gray-700">
              Showing
              <span class="font-semibold">{{
                filteredBookings.length > 0 ? 1 : 0
              }}</span>
              to
              <span class="font-semibold">{{ filteredBookings.length }}</span>
              of
              <span class="font-semibold">{{ filteredBookings.length }}</span>
              results
            </p>
            <div class="flex gap-2">
              <button
                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                disabled
              >
                Previous
              </button>
              <button
                class="px-4 py-2 bg-[#1E71B8] text-white rounded-lg font-semibold"
              >
                1
              </button>
              <button
                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <NewEntryModal
      v-if="showNewEntryModal"
      @close="handleNewEntryClose"
      @booking-created="handleNewBooking"
    />

    <UpdateEntryModal
      v-if="updateEntryModal"
      :booking="selectedBooking"
      @close="updateEntryModal = false"
      @booking-updated="handleUpdatedBooking"
    />
  </div>
</template>

<script setup>
import AdminIndex from "./AdminIndex.vue";
import NewEntryModal from "@/Pages/Admin/components/NewEntryModal.vue";
import UpdateEntryModal from "@/Pages/Admin/components/UpdateEntryModal.vue";
import { api } from "../../api/api";
import { ref, onMounted, computed, onBeforeUnmount } from "vue";

defineOptions({ layout: AdminIndex });

const service = new api();
const bookings = ref([]);
const showNewEntryModal = ref(false);
const updateEntryModal = ref(false);
const selectedBooking = ref(null);
const searchQuery = ref("");
const statusFilter = ref("");
const isFilterOpen = ref(false);
const tourTypeFilter = ref("");
const isTourTypeFilterOpen = ref(false);
const automationSettings = ref(null);

const filterOptions = ["", "Approved", "Pending", "Rejected"];
const tourTypeOptions = ["", "Joiners", "Exclusive"];

const fetchAutomationSettings = async () => {
  try {
    const response = await service.getAutomationSettings();
    automationSettings.value = response.data;
  } catch (error) {
    console.error("Error fetching automation settings:", error);
  }
};

const getWarningInfo = (booking) => {
  if (!automationSettings.value?.is_automation_enabled || booking.status === 'Cancelled' || booking.status === 'Rejected' || booking.status === 'Approved') return null;

  const travelDate = new Date(booking.start_date);
  if (isNaN(travelDate.getTime())) return null;

  // Normalize both dates to midnight local time
  const tDate = new Date(travelDate.getFullYear(), travelDate.getMonth(), travelDate.getDate());
  const today = new Date();
  const tToday = new Date(today.getFullYear(), today.getMonth(), today.getDate());

  const diffTime = tDate - tToday;
  const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24));

  if (diffDays >= 0 && diffDays <= automationSettings.value.warning_days) {
    return automationSettings.value.warning_message;
  }

  return null;
};

const checkAllAutoRejections = async () => {
  if (!automationSettings.value?.is_automation_enabled) return;

  const today = new Date();
  const tToday = new Date(today.getFullYear(), today.getMonth(), today.getDate());

  const pendingBookings = bookings.value.filter((b) => b.status === "Pending");
  let hasRejections = false;

  for (const booking of pendingBookings) {
    const travelDate = new Date(booking.start_date);
    if (isNaN(travelDate.getTime())) continue;

    const tDate = new Date(travelDate.getFullYear(), travelDate.getMonth(), travelDate.getDate());

    const diffTime = tDate - tToday;
    const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays <= automationSettings.value.cancellation_days) {
      try {
        await service.updateBooking(booking.id, {
          status: "Rejected",
          rejection_category: "Past Due Payment",
          remarks:
            automationSettings.value.cancellation_message ||
            "Automated rejection due to past due payment.",
        });
        hasRejections = true;
      } catch (error) {
        console.error(`Auto-rejection failed for booking ${booking.id}:`, error);
      }
    }
  }

  // Handle Payment Reminders (Warnings)
  const warningBookings = bookings.value.filter((b) => b.status === "Pending" && !b.reminder_sent_at);
  let hasReminders = false;

  for (const booking of warningBookings) {
    if (getWarningInfo(booking)) {
      try {
        await service.sendPaymentReminder(booking.id, automationSettings.value.cancellation_days);
        hasReminders = true;
      } catch (error) {
        console.error(`Failed to send reminder for booking ${booking.id}:`, error);
      }
    }
  }

  if (hasRejections || hasReminders) {
    await fetchBookings();
  }
};

const filteredBookings = computed(() => {
  let filtered = bookings.value;

  if (statusFilter.value) {
    filtered = filtered.filter(
      (booking) => booking.status === statusFilter.value
    );
  }

  if (tourTypeFilter.value) {
    filtered = filtered.filter(
      (booking) => booking.tour_type === tourTypeFilter.value
    );
  }

  if (searchQuery.value.trim()) {
    const query = searchQuery.value.toLowerCase().trim();
    filtered = filtered.filter((booking) => {
      const bookingId = String(booking.id).toLowerCase();
      const packageId = String(booking.package_id).toLowerCase();
      const tourType = String(booking.tour_type || "").toLowerCase();
      const customerName = String(booking.customer_name).toLowerCase();
      const status = String(booking.status).toLowerCase();

      return (
        bookingId.includes(query) ||
        packageId.includes(query) ||
        tourType.includes(query) ||
        customerName.includes(query) ||
        status.includes(query)
      );
    });
  }

  return filtered;
});

const formatNumber = (num) => {
  return new Intl.NumberFormat().format(num);
};

const fetchBookings = async () => {
  try {
    const response = await service.getBookings();
    bookings.value = response.data.sort(
      (a, b) => new Date(b.created_at) - new Date(a.created_at)
    );
  } catch (error) {
    console.error("Error fetching bookings:", error);
  }
};

const openNewEntryModal = () => {
  showNewEntryModal.value = true;
};

const handleNewEntryClose = () => {
  showNewEntryModal.value = false;
};

const handleNewBooking = () => {
  fetchBookings();
  showNewEntryModal.value = false;
};

const handleUpdatedBooking = () => {
  fetchBookings();
  updateEntryModal.value = false;
};

const openUpdateEntryModal = (entry) => {
  selectedBooking.value = entry;
  updateEntryModal.value = true;
};

const handleClickOutside = (event) => {
  const filterContainer = document.querySelector("[data-filter-container]");
  if (filterContainer && !filterContainer.contains(event.target)) {
    isFilterOpen.value = false;
  }

  const tourFilterContainer = document.querySelector(
    "[data-tour-filter-container]"
  );
  if (tourFilterContainer && !tourFilterContainer.contains(event.target)) {
    isTourTypeFilterOpen.value = false;
  }
};

const handleFilterSelect = (option) => {
  statusFilter.value = option;
  isFilterOpen.value = false;
};

const handleTourTypeSelect = (option) => {
  tourTypeFilter.value = option;
  isTourTypeFilterOpen.value = false;
};

onMounted(async () => {
  await fetchBookings();
  await fetchAutomationSettings();
  checkAllAutoRejections();
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>
