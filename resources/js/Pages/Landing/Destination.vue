<template>
  <section class="min-h-screen bg-gradient-to-b from-white to-blue-50">
    <div class="max-w-7xl mx-auto px-4 md:px-6 pt-12 md:pt-16 pb-8">
      <div class="text-center mb-12">
        <h1 class="text-5xl md:text-6xl font-bold text-[#1E71B8] mb-4">
          DESTINATIONS
        </h1>
      </div>

      <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
        <div>
          <h2 class="text-xl md:text-2xl font-bold text-[#008DDA] border-b-4 border-[#008DDA] pb-2">
            ALL DESTINATIONS
          </h2>
        </div>

        <div class="flex flex-col md:flex-row gap-4 items-center w-full md:w-auto">
          <div class="w-full md:w-auto">
            <input type="text"
              class="w-full md:w-80 border-2 border-[#008DDA] rounded-full px-6 py-3 text-base focus:outline-none focus:ring-2 focus:ring-[#008DDA]/50 focus:border-[#008DDA] transition-all duration-300 placeholder-gray-400"
              placeholder="Search by name, price, or destination" v-model="searchQuery" />
          </div>

          <div class="relative w-full md:w-auto" ref="filterRef">
            <button
              class="w-full md:w-auto bg-white text-[#008DDA] border-2 border-[#008DDA] rounded-full px-6 py-3 font-semibold text-base hover:bg-[#008DDA] hover:text-white transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center gap-2"
              @click.stop="toggleFilter">
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path
                  d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2.586a1 1 0 0 1-.293.707l-6.414 6.414a1 1 0 0 0-.293.707V17l-4 4v-6.586a1 1 0 0 0-.293-.707L3.293 7.293A1 1 0 0 1 3 6.586V4Z" />
              </svg>
              {{ selectedRegion || "Filter by Region" }}
            </button>

            <transition enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95">
              <ul v-show="showFilter"
                class="absolute top-full right-0 mt-2 bg-white border-2 border-[#008DDA]/20 rounded-2xl shadow-xl z-20 min-w-48 overflow-hidden backdrop-blur-sm">
                <li @click="selectRegion(null)"
                  class="px-6 py-3 text-[#008DDA] cursor-pointer hover:bg-gradient-to-r hover:from-blue-50 hover:to-transparent transition-all duration-200 font-medium hover:text-[#1E71B8]">
                  All Regions
                </li>
                <li v-for="region in regions" :key="region" @click="selectRegion(region)"
                  class="px-6 py-3 text-[#008DDA] cursor-pointer hover:bg-gradient-to-r hover:from-blue-50 hover:to-transparent transition-all duration-200 font-medium hover:text-[#1E71B8] border-t border-gray-100">
                  {{ region }}
                </li>
              </ul>
            </transition>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 md:px-6 pb-20">
      <!-- Regular Packages -->
      <div v-if="filteredPackages.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
        <div v-for="pkg in filteredPackages" :key="pkg.id"
          class="group relative overflow-hidden rounded-3xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-[#1E71B8]/30 transform hover:-translate-y-2 flex flex-col h-full">
          
          <div v-if="pkg.is_seasonal" class="absolute top-4 right-4 z-20 bg-gradient-to-r from-orange-500 to-red-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
            SEASONAL
          </div>

          <div
            class="absolute inset-0 bg-gradient-to-br from-[#1E71B8]/5 to-[#008DDA]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
          </div>

          <div
            class="relative w-full h-56 overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center group/img">
            <img :src="'/storage/' + pkg.image_path" :alt="pkg.destination"
              class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover/img:scale-110" />
            <div
              class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover/img:opacity-100 transition-opacity duration-500">
            </div>
          </div>

          <div class="relative z-10 p-6 flex flex-col flex-grow">
            <div v-if="pkg.is_seasonal" class="mb-4">
              <div class="flex items-center gap-3 mb-3">
                <div>
                  <span class="font-bold text-orange-600 px-3 py-1 bg-gradient-to-r from-orange-500/10 to-red-600/10 rounded-full border border-orange-500/20 inline-block">₱{{ pkg.seasonal_pax_rate.toLocaleString() }}</span>
                </div>
                <span class="text-sm text-gray-500 line-through">₱{{ pkg.pax_rate.toLocaleString() }}</span>
              </div>
              <span class="text-xs font-bold text-white bg-gradient-to-r from-orange-500 to-red-600 px-2 py-1 rounded-full shadow-lg">
              SAVE {{ calculateDiscount(pkg.pax_rate, pkg.seasonal_pax_rate) }}%
            </span>
            </div>
            <div v-else
              class="inline-flex items-center gap-1 mb-4 w-fit px-3 py-1 bg-gradient-to-r from-[#008DDA]/10 to-[#73BE5D]/10 rounded-full border border-[#008DDA]/20">
              <span class="font-bold text-[#008DDA]">₱{{ pkg.pax_rate.toLocaleString() }}</span>
            </div>

            <h3
              class="text-2xl font-bold text-[#1E71B8] mb-4 group-hover:text-[#008DDA] transition-colors duration-300 line-clamp-2">
              {{ pkg.destination }}
            </h3>

            <div
              :class="pkg.is_seasonal ? 'w-8 h-1 bg-gradient-to-r from-orange-500 to-red-600 rounded-full mb-4 group-hover:w-16 transition-all duration-300' : 'w-8 h-1 bg-gradient-to-r from-[#008DDA] to-[#73BE5D] rounded-full mb-4 group-hover:w-16 transition-all duration-300'">
            </div>

            <div class="space-y-3 mb-6 flex-grow">
              <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-5 h-5 text-[#008DDA] flex-shrink-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <span class="text-sm text-gray-600">{{ pkg.package_name }}</span>
              </div>

              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-[#008DDA] flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                  stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <circle cx="12" cy="12" r="10" />
                  <path d="M12 6v6l4 2" />
                </svg>
                <span class="font-semibold text-gray-800 group-hover:text-[#008DDA] transition-colors">{{
                  pkg.tour_duration }} Days</span>
              </div>
            </div>

            <Link :href="route('tourdetails', { id: pkg.id })"
              :class="pkg.is_seasonal ? 'w-full px-6 py-3 rounded-xl font-semibold text-white border-2 bg-gradient-to-r from-orange-500 to-red-600 border-orange-500 hover:from-orange-600 hover:to-red-700 hover:border-orange-600 transition-all duration-300 text-center shadow-sm hover:shadow-md flex items-center justify-center gap-2 group/btn' : 'w-full px-6 py-3 rounded-xl font-semibold text-[#008DDA] border-2 border-[#008DDA] bg-white hover:bg-[#008DDA] hover:text-white transition-all duration-300 text-center shadow-sm hover:shadow-md flex items-center justify-center gap-2 group/btn'">
            View Details
            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" xmlns="http://www.w3.org/2000/svg"
              fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
            </Link>
          </div>
        </div>
      </div>

      <div v-else class="flex flex-col items-center justify-center py-20">
        <svg class="w-24 h-24 text-gray-300 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
          stroke-width="2" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8" />
          <path d="m21 21-4.35-4.35" />
        </svg>
        <h3 class="text-2xl font-bold text-gray-600 mb-2">No destinations found</h3>
        <p class="text-gray-500 text-lg">Try adjusting your search or filters</p>
      </div>
    </div>
  </section>
  <Footer></Footer>
</template>

<script setup>
import { ref, onMounted, computed, onBeforeUnmount } from "vue";
import LandingIndex from "./LandingIndex.vue";
import axios from "axios";
import { api } from "../../api/api";
import { Link } from "@inertiajs/vue3";
import Footer from "./Footer.vue";

defineOptions({ layout: LandingIndex });

const service = new api();
const packages = ref([]);
const showFilter = ref(false);
const searchQuery = ref("");
const selectedRegion = ref(null);
const filterRef = ref(null);

const toggleFilter = () => {
  showFilter.value = !showFilter.value;
};

const closeFilter = () => {
  showFilter.value = false;
};

const filteredPackages = computed(() => {
  const hasQuery = Boolean(searchQuery.value.trim());
  const query = searchQuery.value.toLowerCase().trim();

  if (!hasQuery && !selectedRegion.value) {
    return packages.value;
  }

  return packages.value.filter((pkg) => {
    const regionMatch = selectedRegion.value
      ? pkg.region === selectedRegion.value
      : true;

    if (!hasQuery) {
      return regionMatch;
    }

    const packageNameMatch = pkg.package_name?.toLowerCase().includes(query);
    const paxRateMatch = pkg.pax_rate?.toString().includes(query);
    const destinationMatch = pkg.destination?.toLowerCase().includes(query);

    return (
      regionMatch && (packageNameMatch || paxRateMatch || destinationMatch)
    );
  });
});

const regions = computed(() => {
  const unique = new Set(
    packages.value.map((pkg) => pkg.region).filter((region) => Boolean(region))
  );
  return Array.from(unique).sort();
});

const selectRegion = (region) => {
  selectedRegion.value = region;
  showFilter.value = false;
};

const fetchPackages = async () => {
  try {
    const response = await service.getPackages();
    packages.value = response.data.data.filter(pkg => pkg.status === "active");
  } catch (error) {
    console.error("Error fetching packages:", error);
  }
};

const handleClickOutside = (event) => {
  if (filterRef.value && !filterRef.value.contains(event.target)) {
    showFilter.value = false;
  }
};

const calculateDiscount = (originalPrice, seasonalPrice) => {
  if (originalPrice <= 0) return 0;
  const discount = ((originalPrice - seasonalPrice) / originalPrice) * 100;
  return Math.round(discount);
};

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
  fetchPackages();
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>