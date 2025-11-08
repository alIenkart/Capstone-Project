<template>
    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-12 lg:py-16">
        <div v-if="aboutUs" class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-start">
            <div class="rounded-xl overflow-hidden shadow ring-1 ring-gray-200/60 bg-gray-50">
                <img :src="`/storage/${aboutUs.image}`" :alt="aboutUs.title"
                    class="w-full h-full object-cover aspect-[4/3] md:aspect-[4/5]" loading="lazy" />
            </div>

            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-semibold tracking-wide text-[#1E71B8] uppercase">
                        {{ aboutUs.title }}
                    </h2>
                    <div class="mt-2 h-0.5 w-32 bg-sky-500"></div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-[#000000] uppercase">Mission</h3>
                    <p class="text-[#000000] text-base leading-relaxed">
                        {{ aboutUs.mission }}
                    </p>
                </div>

                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-[#000000] uppercase">Vision</h3>
                    <p class="text-[#000000] text-base leading-relaxed">
                        {{ aboutUs.vision }}
                    </p>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-[#000000] uppercase">Why Must Choose Us</h3>
                    <ul class="list-disc pl-6 space-y-2 text-[#000000] text-base">
                        <li v-for="(reason, index) in whyChooseUsList" :key="index">
                            {{ reason }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-12 lg:pb-20">
        <div v-if="ourStory" class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-start">
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-semibold tracking-wide text-[#1E71B8] uppercase">Our Story</h2>
                    <div class="mt-2 h-0.5 w-32 bg-sky-500"></div>
                </div>

                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-[#1E71B8]">{{ ourStory.name }}</h3>
                    <p class="text-[#000000] font-base">{{ ourStory.subtitle }}</p>
                </div>

                <p class="text-[#000000] text-base leading-relaxed">
                    {{ ourStory.description }}
                </p>
            </div>

            <div
                class="rounded-2xl overflow-hidden shadow ring-1 ring-gray-200/60 bg-gray-50 justify-self-center md:justify-self-end">
                <img :src="`/storage/${ourStory.image}`" :alt="ourStory.name"
                    class="w-72 h-72 md:w-[380px] md:h-[380px] object-cover" loading="lazy" />
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-16 lg:pb-24">
        <div class="space-y-8">
            <div class="text-center">
                <h2 class="text-2xl font-semibold tracking-wide text-[#1E71B8] uppercase">Accreditation</h2>
                <div class="mx-auto mt-2 h-0.5 w-32 bg-sky-500"></div>
            </div>

            <div v-if="accreditation"
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 md:gap-8 justify-items-center">
                <div v-for="item in accreditation" :key="item.id"
                    class="flex items-center justify-center rounded-xl border border-gray-200 bg-white shadow-sm h-64 w-64 overflow-hidden">
                    <img :src="`/storage/${item.image}`" :alt="`Accreditation ${item.id}`"
                        class="h-full w-full object-contain" loading="lazy" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import LandingIndex from './LandingIndex.vue';
import { onMounted, ref, computed } from 'vue';
import { api } from '@/api/api';

const service = new api();
const aboutUs = ref(null);
const ourStory = ref(null);
const accreditation = ref(null);

const whyChooseUsList = computed(() => {
    if (!aboutUs.value?.why_choose_us) return [];
    return aboutUs.value.why_choose_us.split('\n').filter(item => item.trim());
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

defineOptions({ layout: LandingIndex });
</script>