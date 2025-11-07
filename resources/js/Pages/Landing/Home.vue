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

    <section class="max-w-6xl mx-auto px-4 mt-12 text-center">
      <h2 class="text-xl font-bold text-[#1E71B8] border-b-4 border-[#1E71B8] inline-block pb-1 mb-8">
        Exclusive Destination
      </h2>
      <div class="flex flex-wrap justify-center gap-8">
        <div v-for="pkg in packages" :key="pkg.id"
          class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-start w-[270px] md:w-[350px]">
          <img :src="'/storage/' + pkg.image_path" :alt="pkg.destination"
            class="w-full h-40 object-cover rounded-xl mb-4" />
          <div class="flex items-center gap-2 text-[#008DDA] font-bold mb-1">
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full">₱</span>
            <span>{{ pkg.pax_rate }}</span>
          </div>
          <div class="flex items-center gap-2 text-[#008DDA] font-bold mb-1">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0Z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
            <span>{{ pkg.destination }}</span>
          </div>
          <div class="flex items-center gap-2 text-[#008DDA] font-bold mb-3">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10" />
              <path d="M12 6v6l4 2" />
            </svg>
            <span>{{ pkg.tour_duration }} Days</span>
          </div>
          <Link :href="route('tourdetails', { id: pkg.id })"
            class="mt-2 px-8 py-2 border border-[#008DDA] text-[#008DDA] rounded-full font-semibold hover:bg-[#008DDA] hover:text-white transition text-center block w-full">
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
    if(response.data.length > 0) {
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