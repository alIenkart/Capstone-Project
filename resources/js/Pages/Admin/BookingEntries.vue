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
                <th class="px-6 py-4 text-center text-sm font-semibold">
                  Booking ID
                </th>
                <th class="px-6 py-4 text-center text-sm font-semibold">
                  Package ID
                </th>
                <th class="px-6 py-4 text-center text-sm font-semibold">
                  Customer Name
                </th>
                <th class="px-6 py-4 text-center text-sm font-semibold">
                  Status
                </th>
                <th class="px-6 py-4 text-center text-sm font-semibold">
                  Total Pax
                </th>
                <th class="px-6 py-4 text-center text-sm font-semibold">
                  Discount
                </th>
                <th class="px-6 py-4 text-center text-sm font-semibold">
                  Entry Date
                </th>
                <th class="px-6 py-4 text-center text-sm font-semibold">
                  Total Sum
                </th>
                <th class="px-6 py-4 text-center text-sm font-semibold">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr v-if="filteredBookings.length === 0">
                <td colspan="9" class="px-6 py-12 text-center">
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
                class="hover:bg-blue-50/50 transition-colors"
              >
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-900 text-center"
                >
                  <span
                    class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-semibold"
                  >
                    #{{ entry.id }}
                  </span>
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  {{ entry.package_id }}
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-900 text-center"
                >
                  {{ entry.customer_name }}
                </td>
                <td class="px-6 py-4 text-sm text-center">
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
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                  >
                    {{ entry.status }}
                  </span>
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  {{ entry.total_quantity }}
                </td>
                <td class="px-6 py-4 text-sm font-medium text-center">
                  <span
                    v-if="entry.discount_images"
                    class="inline-flex items-center gap-1 text-green-600 font-medium"
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
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                    Yes
                  </span>
                  <span v-else class="text-gray-500 font-medium">No</span>
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  {{
                    new Date(entry.created_at).toLocaleDateString("en-US", {
                      month: "short",
                      day: "numeric",
                      year: "numeric",
                    })
                  }}
                </td>
                <td
                  class="px-6 py-4 text-sm font-semibold text-gray-700 text-center"
                >
                ₱{{ (entry.total_price) - (entry.discount_amount || 0) }}
                </td>
                <td class="px-6 py-4 text-sm text-center">
                  <button
                    @click="openUpdateEntryModal(entry)"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white rounded-lg font-medium transition-all shadow hover:shadow-lg transform hover:-translate-y-0.5"
                  >
                    <svg
                      class="w-4 h-4"
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
                    Review
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

const filterOptions = ["", "Approved", "Pending", "Rejected"];

const filteredBookings = computed(() => {
  let filtered = bookings.value;

  if (statusFilter.value) {
    filtered = filtered.filter(
      (booking) => booking.status === statusFilter.value
    );
  }

  if (searchQuery.value.trim()) {
    const query = searchQuery.value.toLowerCase().trim();
    filtered = filtered.filter((booking) => {
      const bookingId = String(booking.id).toLowerCase();
      const packageId = String(booking.package_id).toLowerCase();
      const customerName = String(booking.customer_name).toLowerCase();
      const status = String(booking.status).toLowerCase();

      return (
        bookingId.includes(query) ||
        packageId.includes(query) ||
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
};

const handleFilterSelect = (option) => {
  statusFilter.value = option;
  isFilterOpen.value = false;
};

onMounted(() => {
  fetchBookings();
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>
