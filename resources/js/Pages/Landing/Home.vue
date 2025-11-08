<template>
  <div class="mb-8">

    <section class="relative w-full min-h-[350px] flex flex-col justify-center text-white px-12 py-12"
      :style="{ backgroundImage: `url(${headerImage})`, backgroundPosition: 'center', backgroundSize: 'cover', backgroundRepeat: 'no-repeat' }">
      <div class="absolute inset-0 bg-black/45"></div>
      <div class="relative z-10 max-w-lg ml-16">
        <h1 class="text-3xl font-bold mb-3">{{ headerSubtitle }}</h1>
        <p class="text-lg mb-8" v-html="headerDescription"></p>
        <Link href="/destination"
          class="inline-block bg-[#008DDA] text-white border-2 border-[#008DDA] rounded-xl px-12 py-3 text-lg font-medium hover:bg-[#73BE5D] hover:border-[#73BE5D]">
        BOOK NOW
        </Link>
      </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 text-center mt-12">
      <h2 class="text-xl font-bold text-[#1E71B8] border-b-4 border-[#1E71B8] inline-block pb-1 mb-3 mt-8">
        WELCOME TO JE TRAVEL & TOURS!
      </h2>
      <p class="text-base text-black mb-8">
        Planning a trips? JE Travel & Tours is here to provide you a wide range of tour and guidance towards a
        meaningful and memorable travel. The agency is specialized in creating seamless travel experiences and is
        <span v-if="showMore">
          dedicated to providing clear and reliable service to make your journey enjoyable and stress free. Let the team
          help you to plan your next journey! Book now!
        </span>
      </p>
      <button
        class="mt-2 px-8 py-2 border-2 border-[#008DDA] text-[#008DDA] rounded-full font-medium bg-white hover:bg-[#008DDA] hover:text-white transition"
        @click="toggleMore">
        {{ showMore ? 'See less' : 'See more' }}
      </button>
    </section>

    <section class="max-w-6xl mx-auto px-4 mt-16 text-center">
      <h2 class="text-2xl font-semibold text-[#1E71B8] relative inline-block mb-12">
        Exclusive Destination
        <span class="absolute left-0 bottom-[-8px] w-full h-[3px] bg-[#1E71B8] rounded-full"></span>
      </h2>
      <div class="flex flex-wrap justify-center gap-10">
        <div v-for="pkg in packages" :key="pkg.id"
          class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 w-[270px] md:w-[340px] flex flex-col overflow-hidden border border-gray-100 hover:border-[#1E71B8]/30">
          <div
            class="relative w-full h-48 rounded-2xl overflow-hidden mb-5 flex items-center justify-center bg-gray-50 group">
            <img :src="'/storage/' + pkg.image_path" :alt="pkg.destination"
              class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105" />
            <div
              class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            </div>
          </div>
          <div class="flex items-center gap-2 text-gray-600 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512"
              class="w-5 h-5 text-[#008DDA] flex-shrink-0">
              <path
                d="M112 32C94.3 32 80 46.3 80 64l0 64-24 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l24 0 0 32-24 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l24 0 0 192c0 17.7 14.3 32 32 32s32-14.3 32-32l0-96 96 0c65.6 0 122-39.5 146.7-96l37.3 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-24.8 0c.5-5.3 .8-10.6 .8-16s-.3-10.7-.8-16l24.8 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-37.3 0C362 71.5 305.6 32 240 32L112 32zm199.6 96l-167.6 0 0-32 96 0c28.4 0 54 12.4 71.6 32zM144 176l190.7 0c.9 5.2 1.3 10.5 1.3 16s-.5 10.8-1.3 16l-190.7 0 0-32zm167.6 80c-17.6 19.6-43.1 32-71.6 32l-96 0 0-32 167.6 0z" />
            </svg>
            <span class="font-medium text-lg">{{ pkg.pax_rate.toLocaleString() }}</span>
          </div>
          <div class="flex items-center gap-2 text-gray-600 mb-2">
            <svg class="w-5 h-5 text-[#008DDA]" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0Z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
            <span class="font-medium text-lg">{{ pkg.destination }}</span>
          </div>
          <div class="flex items-center gap-2 text-gray-600 mb-5">
            <svg class="w-5 h-5 text-[#008DDA]" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10" />
              <path d="M12 6v6l4 2" />
            </svg>
            <span class="font-medium text-lg">{{ pkg.tour_duration }} Days</span>
          </div>
          <Link :href="route('tourdetails', { id: pkg.id })"
            class="mt-auto w-full px-6 py-2.5 rounded-full font-medium text-[#008DDA] border border-[#008DDA] hover:bg-[#008DDA] hover:text-white transition-all duration-300 text-center shadow-sm">
          View Details
          </Link>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { api } from '../../api/api';
import LandingIndex from './LandingIndex.vue';

defineOptions({ layout: LandingIndex });

const service = new api();
const showMore = ref(false);
const packages = ref([]);
const header = ref({ image: '', subtitle: '', description: '' });

const fetchPackages = async () => {
  try {
    const response = await service.getPackages()
    packages.value = response.data.data
  } catch (error) {
    console.error('Error fetching packages:', error)
  }
};

const getImageUrl = (path) => path ? `${window.location.origin}/storage/${path}` : '';

const loadTravelBlogs = async () => {
  try {
    const response = await service.getContents()
    if (response.data.length > 0) {
      const blog = response.data[0];
      header.value = {
        image: blog.image,
        subtitle: blog.subtitle,
        description: blog.description
      }
    }
  } catch (err) {
    console.error('Failed to load travel blogs', err)
  }
};

const headerImage = computed(() => getImageUrl(header.value.image))
const headerSubtitle = computed(() => header.value.subtitle)
const headerDescription = computed(() => header.value.description.replace(/\n/g, '<br>'))

const toggleMore = () => {
  showMore.value = !showMore.value
};

onMounted(() => {
  fetchPackages();
  loadTravelBlogs();
});
</script>