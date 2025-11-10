<template>
  <section class="max-w-7xl mx-auto px-6 lg:px-8 py-12 lg:py-20">
    <div v-if="aboutUs" class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-center">
      <div class="rounded-3xl overflow-hidden shadow-xl ring-1 ring-gray-200/60 bg-gray-50 group">
        <img :src="`/storage/${aboutUs.image}`" :alt="aboutUs.title"
          class="w-full h-full object-cover aspect-[4/3] md:aspect-[4/5] group-hover:scale-105 transition-transform duration-500"
          loading="lazy" />
      </div>
      <div class="space-y-8">
        <div>
          <h2
            class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent uppercase tracking-tight">
            {{ aboutUs.title }}
          </h2>
          <div class="mt-4 h-1 w-24 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full"></div>
        </div>

        <div class="space-y-3">
          <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wide">Mission</h3>
          <p class="text-gray-700 text-base leading-relaxed font-light">
            {{ aboutUs.mission }}
          </p>
        </div>

        <div class="space-y-3">
          <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wide">Vision</h3>
          <p class="text-gray-700 text-base leading-relaxed font-light">
            {{ aboutUs.vision }}
          </p>
        </div>

        <div class="space-y-4">
          <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wide">
            Why Choose Us
          </h3>
          <ul class="space-y-3">
            <li v-for="(reason, index) in whyChooseUsList" :key="index" class="flex items-start gap-3 group">
              <div
                class="flex-shrink-0 w-6 h-6 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center mt-0.5 group-hover:scale-110 transition-transform">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <span class="text-gray-700 text-base font-light">{{ reason }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="max-w-7xl mx-auto px-6 lg:px-8 py-12 lg:py-20 bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <div v-if="ourStory" class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-center">
      <div class="space-y-8">
        <div>
          <h2
            class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent uppercase tracking-tight">
            Our Story
          </h2>
          <div class="mt-4 h-1 w-24 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full"></div>
        </div>

        <div class="space-y-2">
          <h3 class="text-2xl font-bold text-gray-900">{{ ourStory.name }}</h3>
          <p class="text-gray-600 text-base font-light">{{ ourStory.subtitle }}</p>
        </div>

        <p class="text-gray-700 text-base leading-relaxed font-light">
          {{ ourStory.description }}
        </p>
      </div>

      <div
        class="rounded-3xl overflow-hidden shadow-2xl ring-1 ring-gray-200/60 bg-white justify-self-center md:justify-self-end order-1 md:order-2 group">
        <img :src="`/storage/${ourStory.image}`" :alt="ourStory.name"
          class="w-72 h-72 md:w-[380px] md:h-[380px] object-cover group-hover:scale-110 transition-transform duration-500"
          loading="lazy" />
      </div>
    </div>
  </section>

  <section class="max-w-7xl mx-auto px-6 lg:px-8 py-16 lg:py-24">
    <div class="space-y-12">
      <div class="text-center">
        <h2
          class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent uppercase tracking-tight">
          Accreditation
        </h2>
        <div class="mx-auto mt-4 h-1 w-24 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full"></div>
      </div>

      <div v-if="accreditation"
        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 md:gap-8 justify-items-center">
        <div v-for="item in accreditation" :key="item.id"
          class="flex items-center justify-center rounded-2xl border border-gray-200/60 bg-white shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 h-64 w-64 overflow-hidden group">
          <img :src="`/storage/${item.image}`" :alt="`Accreditation ${item.id}`"
            class="h-full w-full object-contain p-4 group-hover:scale-110 transition-transform duration-500"
            loading="lazy" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import LandingIndex from "./LandingIndex.vue";
import { onMounted, ref, computed } from "vue";
import { api } from "@/api/api";

defineOptions({ layout: LandingIndex });

const service = new api();
const aboutUs = ref(null);
const ourStory = ref(null);
const accreditation = ref(null);

const whyChooseUsList = computed(() => {
  if (!aboutUs.value?.why_choose_us) return [];
  return aboutUs.value.why_choose_us.split("\n").filter((item) => item.trim());
});

const loadAboutUs = async () => {
  try {
    const response = await service.getAboutUs();
    aboutUs.value = response.data;
  } catch (error) {
    console.error("Error loading About Us:", error);
  }
};

const loadOurStory = async () => {
  try {
    const response = await service.getOurStory();
    ourStory.value = response.data;
  } catch (error) {
    console.error("Error loading Our Story:", error);
  }
};

const loadAccreditation = async () => {
  try {
    const response = await service.getAccreditations();
    accreditation.value = response.data;
  } catch (error) {
    console.error("Error loading Accreditations:", error);
  }
};

onMounted(() => {
  loadAboutUs();
  loadOurStory();
  loadAccreditation();
});
</script>
