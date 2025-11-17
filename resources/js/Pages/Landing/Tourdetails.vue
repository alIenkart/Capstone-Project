<template>
  <div
    class="bg-gradient-to-br from-[#f8fafc] to-[#f1f5f9] min-h-screen w-full flex flex-col items-center"
  >
    <div class="w-full max-w-7xl px-4 md:px-8 py-8 flex flex-col">
      <div class="mb-8">
        <h2 class="text-4xl font-bold text-[#1E71B8] mb-3">
          {{ selectedPackage.package_name || "Loading destination..." }}
        </h2>
        <p class="text-lg text-[#1E71B8] font-medium mb-3">
          {{ selectedPackage.destination }}
        </p>
        <div
          class="h-1 w-40 bg-gradient-to-r from-[#1E71B8] to-[#73BE5D] rounded-full"
        ></div>
      </div>

      <div class="flex flex-col lg:flex-row gap-8 w-full">
        <div class="flex-1 min-w-0 max-w-full">
          <div
            class="rounded-2xl overflow-hidden mb-8 bg-gray-200 flex items-center justify-center w-full shadow-lg"
          >
            <img
              :src="'/storage/' + selectedPackage.image_path"
              :alt="selectedPackage.destination"
              class="w-full h-auto object-contain"
            />
          </div>

          <div class="mb-8">
            <h3
              class="font-bold text-2xl mb-3 text-[#1E71B8] flex items-center gap-2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-7 h-7"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"
                />
              </svg>
              Description
            </h3>
            <p
              class="text-base text-gray-700 leading-relaxed bg-white rounded-xl p-6 border border-gray-200 shadow-sm"
            >
              {{ selectedPackage.description || "Loading description..." }}
            </p>
          </div>

          <div
            class="bg-white rounded-2xl border border-gray-200 shadow-md overflow-hidden"
          >
            <div class="flex flex-wrap">
              <button
                class="tab-btn"
                :class="{ 'tab-btn-active': activeTab === 'itinerary' }"
                @click="setTab('itinerary')"
              >
                <svg
                  class="w-5 h-5 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                  ></path>
                </svg>
                Itinerary
              </button>
              <button
                class="tab-btn"
                :class="{ 'tab-btn-active': activeTab === 'terms' }"
                @click="setTab('terms')"
              >
                <svg
                  class="w-5 h-5 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                  ></path>
                </svg>
                Terms & Conditions
              </button>
              <button
                class="tab-btn"
                :class="{ 'tab-btn-active': activeTab === 'exclusions' }"
                @click="setTab('exclusions')"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-5 h-5 mr-2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"
                  />
                </svg>
                Exclusions
              </button>
            </div>

            <div class="p-6 md:p-8">
              <div v-if="activeTab === 'itinerary'" class="animate-fade-in">
                <h3
                  class="font-bold text-xl text-[#1E71B8] mb-6 flex items-center gap-2"
                >
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    ></path>
                  </svg>
                  Your Journey
                </h3>
                <div class="space-y-4">
                  <div
                    v-for="day in parsedItinerary"
                    :key="day.dayNumber"
                    class="bg-gradient-to-r from-blue-50 to-blue-100 p-5 rounded-xl border-l-4 border-[#1E71B8] shadow-sm hover:shadow-md transition-all duration-300"
                  >
                    <h4
                      class="font-bold text-lg text-[#1E71B8] mb-3 flex items-center gap-2"
                    >
                      Day {{ day.dayNumber }}
                    </h4>
                    <p
                      class="text-gray-700 whitespace-pre-line leading-relaxed"
                    >
                      {{ day.content }}
                    </p>
                  </div>

                  <div
                    v-if="parsedItinerary.length === 0"
                    class="p-5 bg-gray-50 rounded-xl border border-gray-200"
                  >
                    <p class="text-gray-600">{{ selectedPackage.itinerary }}</p>
                  </div>
                </div>
              </div>

              <div v-if="activeTab === 'terms'" class="animate-fade-in">
                <h3
                  class="font-bold text-xl text-[#1E71B8] mb-6 flex items-center gap-2"
                >
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    ></path>
                  </svg>
                  Terms & Conditions
                </h3>
                <div
                  class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-6"
                >
                  <p class="font-semibold text-gray-800">
                    These Terms and Conditions govern the use of services
                    provided by Traveller Laguna. By confirming booking with our
                    agency, customers must consider the terms outlined below.
                  </p>
                </div>

                <div class="space-y-4">
                  <div
                    v-for="term in parsedTerms"
                    :key="term.number"
                    class="bg-white border border-gray-200 p-5 rounded-xl hover:shadow-md transition-all duration-300"
                  >
                    <div class="flex items-start gap-4">
                      <div class="flex-1">
                        <h4
                          v-if="term.title"
                          class="font-bold text-gray-800 mb-2"
                        >
                          {{ term.title }}
                        </h4>
                        <p
                          class="text-gray-700 whitespace-pre-line leading-relaxed"
                        >
                          {{ term.content }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div v-if="activeTab === 'exclusions'" class="animate-fade-in">
                <h3
                  class="font-bold text-xl text-[#1E71B8] mb-6 flex items-center gap-2"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"
                    />
                  </svg>
                  Not Included
                </h3>
                <div class="space-y-4">
                  <div
                    v-for="exclusion in parsedExclusions"
                    :key="exclusion.number"
                    class="bg-white border border-gray-200 p-5 rounded-xl hover:shadow-md transition-all duration-300"
                  >
                    <div class="flex items-start gap-4">
                      <div class="flex-1">
                        <h4
                          v-if="exclusion.title"
                          class="font-bold text-gray-800 mb-2"
                        >
                          {{ exclusion.title }}
                        </h4>
                        <p
                          class="text-gray-700 whitespace-pre-line leading-relaxed"
                        >
                          {{ exclusion.content }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col gap-6 w-full lg:w-96 h-fit">
          <div
            :class="selectedPackage.is_seasonal ? 'bg-gradient-to-br from-orange-500 to-red-600' : 'bg-gradient-to-br from-[#1E71B8] to-[#155E9C]'"
            class="rounded-2xl p-6 shadow-lg text-white overflow-hidden relative"
          >
            <div
              class="absolute -top-12 -right-12 w-32 h-32 bg-white opacity-10 rounded-full"
            ></div>
            <div
              :class="selectedPackage.is_seasonal ? 'bg-red-700' : 'bg-[#73BE5D]'"
              class="absolute -bottom-8 -left-8 w-24 h-24 opacity-10 rounded-full"
            ></div>

            <div class="relative z-10">
              <div v-if="selectedPackage.is_seasonal" class="mb-5 pb-5 border-b border-white border-opacity-20">
                <p class="text-white text-opacity-70 text-xs uppercase tracking-widest font-semibold mb-2">
                  Seasonal Rate
                </p>
                <div class="flex items-center gap-3 mb-3">
                  <div>
                    <div class="flex items-baseline gap-1">
                      <span class="text-lg font-bold">₱</span>
                      <span class="text-3xl font-bold">{{
                        selectedPackage?.seasonal_pax_rate?.toLocaleString()
                      }}</span>
                      <span class="text-sm text-white text-opacity-80">/pax</span>
                    </div>
                  </div>
                  <div class="flex flex-col items-start">
                    <span class="text-sm text-white text-opacity-80 line-through">₱{{ selectedPackage?.pax_rate?.toLocaleString() }}</span>
                    <span class="text-xs font-bold bg-white text-orange-600 px-2 py-1 rounded-full mt-1">
                      SAVE {{ calculateDiscount(selectedPackage?.pax_rate, selectedPackage?.seasonal_pax_rate) }}%
                    </span>
                  </div>
                </div>
              </div>

              <div v-else class="mb-5 pb-5 border-b border-white border-opacity-20">
                <p
                  class="text-white text-opacity-70 text-xs uppercase tracking-widest font-semibold mb-2"
                >
                  Starting from
                </p>
                <div class="flex items-baseline gap-1">
                  <span class="text-lg font-bold">₱</span>
                  <span class="text-3xl font-bold">{{
                    selectedPackage?.pax_rate?.toLocaleString()
                  }}</span>
                  <span class="text-sm text-white text-opacity-80">/pax</span>
                </div>
              </div>

              <div class="mb-6">
                <div :class="selectedPackage.is_seasonal ? 'bg-red-700' : 'bg-[#73BE5D]'" class="rounded-lg px-4 py-3 text-center">
                  <p
                    class="text-white text-opacity-80 text-xs uppercase tracking-wide mb-1"
                  >
                    Duration
                  </p>
                  <p class="font-bold text-2xl text-white">
                    {{ selectedPackage.tour_duration }} Days
                  </p>
                </div>
              </div>

              <button
                v-if="selectedPackage.id"
                @click="handleBookNow"
                class="w-full py-3 px-4 bg-white font-bold text-lg rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 active:scale-95"
                :class="selectedPackage.is_seasonal ? 'text-orange-600 hover:bg-orange-50' : 'text-[#1E71B8] hover:bg-blue-50'"
              >
                BOOK NOW →
              </button>
            </div>
          </div>

          <div
            v-if="relatedTrips.length > 0"
            class="bg-white rounded-2xl border border-gray-200 shadow-md p-6"
          >
            <h3 class="font-bold text-lg text-[#1E71B8] mb-4 flex items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-6 h-6"
              >
                <path
                  fill-rule="evenodd"
                  d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                  clip-rule="evenodd"
                />
              </svg>
              Related Trips
            </h3>

            <div class="space-y-4">
              <div
                v-for="pkg in relatedTrips"
                :key="pkg.id"
                :class="pkg.is_seasonal ? 'bg-gradient-to-br from-orange-50 to-red-50' : 'bg-gradient-to-br from-blue-50 to-gray-50'"
                class="rounded-xl overflow-hidden border hover:shadow-lg transition-all duration-300"
                :style="pkg.is_seasonal ? 'border-color: rgb(249, 115, 22);' : 'border-color: rgb(229, 231, 235);'"
              >
                <div
                  class="h-40 bg-gray-200 overflow-hidden flex items-center justify-center relative"
                >
                  <img
                    :src="'/storage/' + pkg.image_path"
                    :alt="pkg.destination"
                    class="w-full h-full object-contain"
                  />
                  <div v-if="pkg.is_seasonal" class="absolute top-3 right-3 z-10 bg-gradient-to-r from-orange-500 to-red-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                    SEASONAL
                  </div>
                </div>

                <div class="p-4">
                  <h3
                    class="font-bold text-[#1E71B8] text-2xl text-center pb-2"
                  >
                    {{ pkg.package_name }}
                  </h3>

                  <div class="space-y-2 mb-4">
                    <div v-if="pkg.is_seasonal" class="flex items-center gap-2 m-0.5">
                      <div>
                        <span class="font-bold text-orange-600 px-2 py-1 bg-gradient-to-r from-orange-500/10 to-red-600/10 rounded-full border border-orange-500/20 inline-block text-sm">₱{{ pkg.seasonal_pax_rate?.toLocaleString() }}</span>
                      </div>
                      <span class="text-sm text-gray-500 line-through">₱{{ pkg.pax_rate?.toLocaleString() }}</span>
                    </div>
                    <div v-else class="flex items-center gap-1 text-gray-700 m-0.5">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 448 512"
                        class="w-4 h-4 text-[#1E71B8]"
                      >
                        <path
                          d="M112 32C94.3 32 80 46.3 80 64l0 64-24 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l24 0 0 32-24 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l24 0 0 192c0 17.7 14.3 32 32 32s32-14.3 32-32l0-96 96 0c65.6 0 122-39.5 146.7-96l37.3 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-24.8 0c.5-5.3 .8-10.6 .8-16s-.3-10.7-.8-16l24.8 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-37.3 0C362 71.5 305.6 32 240 32L112 32zm199.6 96l-167.6 0 0-32 96 0c28.4 0 54 12.4 71.6 32zM144 176l190.7 0c.9 5.2 1.3 10.5 1.3 16s-.5 10.8-1.3 16l-190.7 0 0-32zm167.6 80c-17.6 19.6-43.1 32-71.6 32l-96 0 0-32 167.6 0z"
                        />
                      </svg>
                      <span
                        class="text-lg font-semibold text-[#1E71B8] m-0.5"
                        >{{ pkg.pax_rate?.toLocaleString() }}</span
                      >
                    </div>
                    <div class="flex items-center gap-1 text-gray-700">
                      <svg
                        class="w-5 h-5 text-[#1E71B8]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                        ></path>
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                        ></path>
                      </svg>
                      <span class="text-lg font-semibold text-[#1E71B8]">{{
                        pkg.destination
                      }}</span>
                    </div>
                    <div class="flex items-center gap-1 text-gray-700">
                      <svg
                        class="w-5 h-5 text-[#1E71B8]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                      </svg>
                      <span class="text-lg font-semibold text-[#1E71B8]"
                        >{{ pkg.tour_duration }} Days</span
                      >
                    </div>
                  </div>

                  <Link
                    :href="route('tourdetails', { id: pkg.id })"
                    class="w-full py-2 px-3 border-2 border-[#1E71B8] text-[#1E71B8] rounded-lg font-semibold hover:bg-[#1E71B8] hover:text-white transition-all duration-300 text-center text-sm block"
                  >
                    View Details
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footer></Footer>
</template>

<script setup>
import LandingIndex from "./LandingIndex.vue";
import { computed, ref, onMounted, } from "vue";
import { usePage, router, Link } from "@inertiajs/vue3";
import { api } from "../../api/api";
import { storeBooking } from "@/state/storeBooking";
import { cloneDeep } from "lodash";
import { useToast } from "vue-toastification";
import Footer from "./Footer.vue";

defineOptions({ layout: LandingIndex });

const booking = storeBooking();
const service = new api();
const page = usePage();
const toast = useToast();
const id = computed(() => page.props.id);

const selectedPackage = ref({});
const packages = ref([]);
const activeTab = ref("itinerary");

const parsedItinerary = computed(() => {
  if (!selectedPackage.value.itinerary) {
    return [];
  }

  let itineraryData = selectedPackage.value.itinerary;

  if (typeof itineraryData === "string") {
    try {
      itineraryData = JSON.parse(itineraryData);
    } catch (e) {
      console.error("Invalid JSON itinerary:", e);
      itineraryData = itineraryData.trim();
    }
  }

  if (typeof itineraryData === "object" && !Array.isArray(itineraryData)) {
    const days = Object.keys(itineraryData)
      .sort((a, b) => {
        const numA = parseInt(a.replace(/\D/g, "")) || 0;
        const numB = parseInt(b.replace(/\D/g, "")) || 0;
        return numA - numB;
      })
      .map((key, index) => ({
        dayNumber: index + 1,
        content: itineraryData[key],
      }));

    return days;
  }

  if (Array.isArray(itineraryData)) {
    return itineraryData.map((content, index) => ({
      dayNumber: index + 1,
      content,
    }));
  }

  if (typeof itineraryData === "string") {
    const daySections = itineraryData
      .split("\n\n")
      .filter((section) => section.trim() !== "");

    if (daySections.length > 1) {
      return daySections.map((section, index) => ({
        dayNumber: index + 1,
        content: section.replace(/^Day\s+\d+:\s*/i, "").trim(),
      }));
    }

    return [
      {
        dayNumber: 1,
        content: itineraryData.trim(),
      },
    ];
  }

  return [];
});

const parsedTerms = computed(() => {
  if (!selectedPackage.value.terms_condition) {
    return [];
  }

  const termsString = selectedPackage.value.terms_condition;
  const lines = termsString.split("\n").filter((line) => line.trim() !== "");

  const terms = [];
  let currentTerm = null;

  lines.forEach((line) => {
    const trimmedLine = line.trim();
    const numberMatch = trimmedLine.match(/^(\d+)\.?\s*(.*)$/);

    if (numberMatch) {
      if (currentTerm) {
        terms.push(currentTerm);
      }

      const number = parseInt(numberMatch[1]);
      const title = numberMatch[2].trim();

      currentTerm = {
        number: number,
        title: title,
        content: "",
      };
    } else if (currentTerm) {
      if (currentTerm.content) {
        currentTerm.content += "\n" + trimmedLine;
      } else {
        currentTerm.content = trimmedLine;
      }
    } else {
      terms.push({
        number: terms.length + 1,
        title: "",
        content: trimmedLine,
      });
    }
  });

  if (currentTerm) {
    terms.push(currentTerm);
  }

  return terms;
});

const parsedExclusions = computed(() => {
  if (!selectedPackage.value.exclusions) {
    return [];
  }

  const exclusionsString = selectedPackage.value.exclusions;
  const lines = exclusionsString
    .split("\n")
    .filter((line) => line.trim() !== "");

  const exclusions = [];
  let currentExclusion = null;

  lines.forEach((line) => {
    const trimmedLine = line.trim();
    const numberMatch = trimmedLine.match(/^(\d+)\.?\s*(.*)$/);

    if (numberMatch) {
      if (currentExclusion) {
        exclusions.push(currentExclusion);
      }

      const number = parseInt(numberMatch[1]);
      const title = numberMatch[2].trim();

      currentExclusion = {
        number: number,
        title: title,
        content: "",
      };
    } else if (currentExclusion) {
      if (currentExclusion.content) {
        currentExclusion.content = trimmedLine;
      }
    } else {
      exclusions.push({
        number: exclusions.length + 1,
        title: "",
        content: trimmedLine,
      });
    }
  });

  if (currentExclusion) {
    exclusions.push(currentExclusion);
  }

  return exclusions;
});

const fetchSelectedPackage = async () => {
  try {
    const response = await service.getPackage(id.value);
    selectedPackage.value = response.data.data;
    const packageSelected = cloneDeep(selectedPackage.value);
    booking.setPackage(packageSelected);
  } catch (error) {
    console.error("Error fetching selectedPackage:", error);
  }
};

const fetchPackages = async () => {
  try {
    const response = await service.getPackages();
    packages.value = response.data.data;
  } catch (error) {
    console.error("Error fetching packages:", error);
  }
};

const setTab = (tab) => {
  activeTab.value = tab;
};

const calculateDiscount = (originalPrice, seasonalPrice) => {
  if (originalPrice <= 0) return 0;
  const discount = ((originalPrice - seasonalPrice) / originalPrice) * 100;
  return Math.round(discount);
};

const handleBookNow = () => {
  if (!page.props?.auth?.user?.id) {
    toast.warning("You need to login first.");
  }

  if (!selectedPackage.value || !selectedPackage.value.id) {
    console.error("No package selected");
    return;
  }

  const date = [
    { startDate: selectedPackage.value.start_date },
    { endDate: selectedPackage.value.end_date },
  ];

  booking.setPackageId(selectedPackage.value?.id);
  booking.setPackageDestination(selectedPackage.value?.destination);
  booking.setDuration(selectedPackage.value?.tour_duration);
  booking.setAdultRate(selectedPackage.value.is_seasonal ? selectedPackage.value?.seasonal_pax_rate : selectedPackage.value?.pax_rate);
  booking.setItinerary(selectedPackage.value?.itinerary);
  booking.setDate(date);

  if (selectedPackage.value.kids_rate) {
    booking.setKidsRate(selectedPackage.value?.kids_rate);
  }

  if (selectedPackage.value.package_type) {
    booking.setPackageType(selectedPackage.value?.package_type);
  }

  router.visit(route("process-booking", selectedPackage.value?.id));
};

const relatedTrips = computed(() => {
  if (!packages.value.length || !selectedPackage.value?.id) {
    return [];
  }

  const selectedClassifications = selectedPackage.value.tour_classification || [];

  const filteredPackages = packages.value.filter((pkg) => {
    if (pkg.id === selectedPackage.value.id) return false;

    return pkg.tour_classification?.some((cls) =>
      selectedClassifications.includes(cls)
    );
  });

  return filteredPackages.sort(() => 0.5 - Math.random()).slice(0, 2);
});


onMounted(() => {
  fetchSelectedPackage();
  fetchPackages();
});
</script>

<style scoped>
.tab-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 1rem;
  background: #f3f4f6;
  color: #1e71b8;
  font-weight: 600;
  border: none;
  transition: all 0.3s ease;
  cursor: pointer;
}

.tab-btn:hover {
  background: #e5e7eb;
  color: #155e9c;
}

.tab-btn.tab-btn-active {
  background: linear-gradient(to right, #1e71b8, #155e9c);
  color: white;
  border-bottom: 3px solid #73be5d;
}

@media (max-width: 1024px) {
  .tab-btn {
    font-size: 0.875rem;
  }
}

@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.3s ease-out;
}

button {
  transition: all 0.3s ease;
}

::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: #1e71b8;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: #155e9c;
}
</style>