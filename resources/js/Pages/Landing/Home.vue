<template>
  <div class="mb-8">
    <section
      class="relative w-full min-h-[500px] flex flex-col justify-center text-white px-6 md:px-12 py-16 md:py-20 overflow-hidden"
      :style="{
        backgroundImage: `url(${headerImage})`,
        backgroundPosition: 'center',
        backgroundSize: 'cover',
        backgroundRepeat: 'no-repeat',
      }">
      <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

      <div class="absolute inset-0 opacity-20">
        <div
          class="absolute top-10 left-10 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-pulse">
        </div>
        <div
          class="absolute bottom-10 right-10 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"
          style="animation-delay: 2s;"></div>
      </div>

      <div class="relative z-10 max-w-2xl">

        <h1 class="text-5xl md:text-6xl font-bold mb-4 leading-tight">{{ headerSubtitle }}</h1>
        <p class="text-lg md:text-xl text-gray-100 mb-8 leading-relaxed" v-html="headerDescription"></p>

        <Link href="/destination"
          class="inline-flex items-center gap-2 bg-[#008DDA] text-white border-2 border-[#008DDA] rounded-xl px-8 md:px-12 py-3 md:py-4 text-lg font-semibold hover:bg-[#73BE5D] hover:border-[#73BE5D] transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
        BOOK NOW
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24">
          <path d="M5 12h14M12 5l7 7-7 7" />
        </svg>
        </Link>
      </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 md:px-6 py-16 md:py-20">
      <div
        class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-3xl p-8 md:p-12 border border-blue-100 shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="text-center mb-8">
          <h2 class="text-3xl md:text-4xl font-bold mb-2">
            <span class="text-[#1E71B8]">WELCOME TO</span>
            <span class="block mt-2 bg-gradient-to-r from-[#1E71B8] to-[#008DDA] bg-clip-text text-transparent">JE
              TRAVEL & TOURS!</span>
          </h2>
          <div class="w-16 h-1 bg-gradient-to-r from-[#1E71B8] to-[#008DDA] mx-auto mt-4 rounded-full"></div>
        </div>

        <p class="text-base md:text-lg text-gray-700 mb-4 leading-relaxed text-center">
          Planning a trip? JE Travel & Tours is here to provide you with a wide range of tour and guidance towards a
          meaningful and memorable travel. The agency is specialized in creating seamless travel experiences and is
          <span v-if="showMore" class="block text-gray-600 animate-fadeIn">
            dedicated to providing clear and reliable service to make your journey enjoyable and stress-free. Let the
            team help you to plan your next journey! Book now!
          </span>
        </p>

        <div class="flex justify-center">
          <button
            class="mt-4 px-8 py-3 border-2 border-[#008DDA] text-[#008DDA] rounded-full font-semibold bg-white hover:bg-[#008DDA] hover:text-white transition-all duration-300 transform hover:scale-105 flex items-center gap-2 shadow-md hover:shadow-lg"
            @click="toggleMore">
            {{ showMore ? "See Less" : "See More" }}
            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': showMore }"
              xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
          </button>
        </div>
      </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 md:px-6 py-16 md:py-24">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-[#1E71B8] mb-4 relative inline-block">
          Exclusive Destinations
          <span
            class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-[#1E71B8] to-[#008DDA] rounded-full"></span>
        </h2>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
        <div v-for="pkg in packages" :key="pkg.id"
          class="group relative h-full overflow-hidden rounded-3xl bg-white shadow-md hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-[#1E71B8]/30 transform hover:-translate-y-2 flex flex-col">
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
            <div
              class="inline-flex items-center gap-1 mb-4 w-fit px-3 py-1 bg-gradient-to-r from-[#008DDA]/10 to-[#73BE5D]/10 rounded-full border border-[#008DDA]/20">
              <span class="font-bold text-[#008DDA]">₱{{ pkg.pax_rate.toLocaleString() }}</span>
            </div>

            <h3
              class="text-2xl font-bold text-[#1E71B8] mb-4 group-hover:text-[#008DDA] transition-colors duration-300 line-clamp-2">
              {{ pkg.destination }}
            </h3>

            <div
              class="w-8 h-1 bg-gradient-to-r from-[#008DDA] to-[#73BE5D] rounded-full mb-4 group-hover:w-16 transition-all duration-300">
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
              class="w-full px-6 py-3 rounded-xl font-semibold text-[#008DDA] border-2 border-[#008DDA] bg-white hover:bg-[#008DDA] hover:text-white transition-all duration-300 text-center shadow-sm hover:shadow-md flex items-center justify-center gap-2 group/btn">
            View Details
            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" xmlns="http://www.w3.org/2000/svg"
              fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
            </Link>
          </div>
        </div>
      </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 md:px-6 py-16 md:py-24" v-if="seasonalPackages.length > 0">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-[#1E71B8] mb-4 relative inline-block">
          Special Offers
          <span
            class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-[#1E71B8] to-[#008DDA] rounded-full"></span>
        </h2>
        <p class="text-gray-600 mt-6 text-lg">Limited time seasonal packages at exclusive rates</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
        <div v-for="pkg in seasonalPackages" :key="pkg.id"
          class="group relative h-full overflow-hidden rounded-3xl bg-white shadow-md hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-[#1E71B8]/30 transform hover:-translate-y-2 flex flex-col">
          
          <div class="absolute top-4 right-4 z-20 bg-gradient-to-r from-orange-500 to-red-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
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
            <div class="space-y-2 mb-4">
              <div class="flex items-center gap-3">
                <div
                  class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-orange-500/10 to-red-600/10 rounded-full border border-orange-500/20">
                  <span class="font-bold text-orange-600 text-sm">₱{{ pkg.seasonal_pax_rate.toLocaleString() }}</span>
                </div>
              </div>
            </div>

            <h3
              class="text-2xl font-bold text-[#1E71B8] mb-4 group-hover:text-[#008DDA] transition-colors duration-300 line-clamp-2">
              {{ pkg.destination }}
            </h3>

            <div
              class="w-8 h-1 bg-gradient-to-r from-orange-500 to-red-600 rounded-full mb-4 group-hover:w-16 transition-all duration-300">
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
              class="w-full px-6 py-3 rounded-xl font-semibold text-white border-2 bg-gradient-to-r from-orange-500 to-red-600 border-orange-500 hover:from-orange-600 hover:to-red-700 hover:border-orange-600 transition-all duration-300 text-center shadow-sm hover:shadow-md flex items-center justify-center gap-2 group/btn">
            Book Now
            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" xmlns="http://www.w3.org/2000/svg"
              fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
            </Link>
          </div>
        </div>
      </div>
    </section>
  </div>
  <Footer></Footer>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import { api } from "../../api/api";
import LandingIndex from "./LandingIndex.vue";
import Footer from "./Footer.vue";

defineOptions({ layout: LandingIndex });

const service = new api();
const showMore = ref(false);
const packages = ref([]);
const seasonalPackages = ref([]);
const header = ref({ image: "", subtitle: "", description: "" });

const fetchPackages = async () => {
  try {
    const response = await service.getPackages();
    const allPackages = response.data.data.filter(pkg => pkg.status === "active");
    packages.value = allPackages.filter(pkg => !pkg.is_seasonal);
    seasonalPackages.value = allPackages.filter(pkg => pkg.is_seasonal);
  } catch (error) {
    console.error("Error fetching packages:", error);
  }
};

const getImageUrl = (path) =>
  path ? `${window.location.origin}/storage/${path}` : "";

const loadTravelBlogs = async () => {
  try {
    const response = await service.getContents();
    if (response.data.length > 0) {
      const blog = response.data[0];
      header.value = {
        image: blog.image,
        subtitle: blog.subtitle,
        description: blog.description,
      };
    }
  } catch (err) {
    console.error("Failed to load travel blogs", err);
  }
};

const headerImage = computed(() => getImageUrl(header.value.image));
const headerSubtitle = computed(() => header.value.subtitle);
const headerDescription = computed(() =>
  header.value.description.replace(/\n/g, "<br>")
);

const toggleMore = () => {
  showMore.value = !showMore.value;
};

onMounted(() => {
  fetchPackages();
  loadTravelBlogs();
});
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeIn {
  animation: fadeIn 0.5s ease-out;
}
</style>