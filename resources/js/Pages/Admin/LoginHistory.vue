<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
    <div class="max-w-8xl mx-auto">
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
              placeholder="Search records..."
              class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
            />
          </div>

          <div class="relative" data-filter-container>
            <button
              @click="isFilterOpen = !isFilterOpen"
              class="flex items-center justify-between w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 min-w-[180px]"
            >
              <span class="font-semibold text-gray-800">
                {{ filterType }}
              </span>
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
              class="absolute top-full right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden min-w-[180px]"
            >
              <div
                v-for="option in filterOptions"
                :key="option"
                @click="handleFilterSelect(option)"
                :class="[
                  'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                  filterType === option
                    ? 'bg-blue-50 border-l-4 border-l-blue-500'
                    : '',
                ]"
              >
                <span
                  :class="[
                    'font-medium',
                    filterType === option
                      ? 'text-blue-700'
                      : 'text-gray-700',
                  ]"
                >
                  {{ option }}
                </span>
                <svg
                  v-if="filterType === option"
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
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div v-if="paginatedData.length > 0" class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr
                class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white"
              >
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  First Name
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Last Name
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Email
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Contact Number
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Login Time
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr
                v-for="row in paginatedData"
                :key="row.id"
                class="hover:bg-blue-50/50 transition-colors"
              >
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  {{ row?.first_name || "N/A" }}
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  {{ row?.last_name || "N/A" }}
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  {{ row.email }}
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  {{ row?.phone_number || "N/A" }}
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  <span
                    class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-medium text-xs"
                  >
                    {{ formatDate(row.logged_in_at) }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-else class="py-16 text-center">
          <svg
            class="w-16 h-16 mx-auto text-gray-300 mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
            />
          </svg>
          <h3 class="text-lg font-semibold text-gray-700 mb-2">
            No login records found
          </h3>
          <p class="text-gray-500">
            Try adjusting your search or filter criteria
          </p>
        </div>

        <div
          v-if="paginatedData.length > 0"
          class="bg-gray-50 px-6 py-4 border-t border-gray-200"
        >
          <div
            class="flex flex-col sm:flex-row items-center justify-between gap-4"
          >
            <p class="text-sm text-gray-700">
              Showing <span class="font-semibold">{{ startIndex + 1 }}</span> to
              <span class="font-semibold">{{ endIndex }}</span> of
              <span class="font-semibold">{{ filteredData.length }}</span>
              results
            </p>
            <div class="flex gap-2">
              <button
                @click="previousPage"
                :disabled="currentPage === 1"
                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Previous
              </button>
              <button
                v-for="page in visiblePages"
                :key="page"
                @click="currentPage = page"
                :class="[
                  'px-4 py-2 rounded-lg font-semibold transition-all',
                  currentPage === page
                    ? 'bg-[#1E71B8] text-white'
                    : 'border-2 border-gray-200 hover:bg-gray-100',
                ]"
              >
                {{ page }}
              </button>
              <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import AdminIndex from "./AdminIndex.vue";
import { ref, computed, watch, onMounted, onBeforeUnmount } from "vue";
import { api } from "@/api/api";
import { useToast } from "vue-toastification";

defineOptions({ layout: AdminIndex });

const props = defineProps({
  histories: {
    type: Object,
    required: true,
    default: () => ({ data: [] }),
  },
});

const service = new api();
const toast = useToast();
const searchQuery = ref("");
const filterType = ref("All");
const users = ref();
const isFilterOpen = ref(false);
const currentPage = ref(1);
const itemsPerPage = 10;

const filterOptions = ["All", "Today", "This Week", "This Month"];

const getDateFilter = () => {
  const today = new Date();
  const oneWeekAgo = new Date(today);
  oneWeekAgo.setDate(today.getDate() - 7);
  const oneMonthAgo = new Date(today);
  oneMonthAgo.setMonth(today.getMonth() - 1);

  return {
    today,
    oneWeekAgo,
    oneMonthAgo,
  };
};

const parseLoginTime = (timeStr) => {
  return new Date(timeStr);
};

const formatDate = (dateStr) => {
  return new Date(dateStr).toLocaleString();
};

const filteredData = computed(() => {
  let filtered = props.histories?.data || [];
  const { today, oneWeekAgo, oneMonthAgo } = getDateFilter();

  if (filterType.value === "Today") {
    filtered = filtered.filter((item) => {
      const itemDate = parseLoginTime(item.logged_in_at);
      return itemDate.toDateString() === today.toDateString();
    });
  } else if (filterType.value === "This Week") {
    filtered = filtered.filter((item) => {
      const itemDate = parseLoginTime(item.logged_in_at);
      return itemDate >= oneWeekAgo && itemDate <= today;
    });
  } else if (filterType.value === "This Month") {
    filtered = filtered.filter((item) => {
      const itemDate = parseLoginTime(item.logged_in_at);
      return itemDate >= oneMonthAgo && itemDate <= today;
    });
  }

  if (searchQuery.value.trim()) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(
      (item) =>
        item.email.toLowerCase().includes(query) ||
        item.user?.first_name?.toLowerCase().includes(query) ||
        item.user?.last_name?.toLowerCase().includes(query) ||
        item.user?.phone_number?.includes(query)
    );
  }

  filtered.sort((a, b) => {
    const dateA = parseLoginTime(a.logged_in_at);
    const dateB = parseLoginTime(b.logged_in_at);
    return dateB - dateA;
  });

  if (!users.value || users.value.length === 0) {
    return filtered;
  }

  const enriched = filtered.map((item) => {
    const user = users.value.find((u) => u.id === item.user_id);

    return {
      ...item,
      first_name: user?.first_name || "",
      last_name: user?.last_name || "",
      phone_number: user?.phone_number || "",
    };
  });

  return enriched;
});

const totalPages = computed(() =>
  Math.ceil(filteredData.value.length / itemsPerPage)
);

const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredData.value.slice(start, end);
});

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage);

const endIndex = computed(() =>
  Math.min(currentPage.value * itemsPerPage, filteredData.value.length)
);

const visiblePages = computed(() => {
  const pages = [];
  const maxVisible = 5;
  let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2));
  let end = Math.min(totalPages.value, start + maxVisible - 1);
  if (end - start + 1 < maxVisible) {
    start = Math.max(1, end - maxVisible + 1);
  }
  for (let i = start; i <= end; i++) {
    pages.push(i);
  }
  return pages;
});

const handleFilterSelect = (option) => {
  filterType.value = option;
  isFilterOpen.value = false;
  currentPage.value = 1;
};

const handleClickOutside = (event) => {
  if (!event.target.closest("[data-filter-container]")) {
    isFilterOpen.value = false;
  }
};

const previousPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};

const loadUsers = async () => {
  try {
    const allUsers = await service.getUsers();
    users.value = allUsers.data.data;
  } catch (e) {
    toast.error("Something wrong. Check your console.");
    console.error(e);
  }
};

watch(searchQuery, () => {
  currentPage.value = 1;
});

watch(filterType, () => {
  currentPage.value = 1;
});

watch(isFilterOpen, (newValue) => {
  if (newValue) {
    document.addEventListener("click", handleClickOutside);
  } else {
    document.removeEventListener("click", handleClickOutside);
  }
});

onMounted(() => {
  loadUsers();
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>