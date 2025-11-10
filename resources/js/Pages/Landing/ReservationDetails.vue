<template>
  <div class="w-full min-h-screen bg-gradient-to-br from-[#f8fafc] to-[#f1f5f9] py-8">
    <div class="flex items-center gap-2 mb-16 mt-2 w-full max-w-6xl justify-center mx-auto px-4">
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] bg-[#008DDA] flex items-center justify-center">
          <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="8" />
          </svg>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-sm md:text-base">Availability</span>
      </div>
      <span class="w-8 md:w-16 h-0.5 bg-gradient-to-r from-[#008DDA] to-[#1E71B8] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] bg-[#008DDA] flex items-center justify-center">
          <span class="w-2 h-2 rounded-full"></span>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-sm md:text-base border-b-2 border-[#008DDA]">
          Reservation Details
        </span>
      </div>
      <span class="w-8 md:w-16 h-0.5 bg-gray-300 mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center"></span>
        <span class="ml-1 text-gray-400 font-semibold text-sm md:text-base">Confirmation</span>
      </div>
    </div>

    <div class="flex flex-col lg:flex-row w-full max-w-7xl justify-center gap-8 mx-auto px-4">
      <div class="flex-1">
        <div class="flex justify-start mb-6">
          <button @click="emit('back')"
            class="px-6 py-2.5 rounded-lg font-semibold text-sm transition-all duration-300 bg-white text-[#1E71B8] border border-[#1E71B8] hover:bg-[#1E71B8] hover:text-white shadow-md hover:shadow-lg">
            ← Back
          </button>
        </div>

        <div class="mb-8">
          <h2 class="text-2xl md:text-3xl font-bold text-[#1E71B8] mb-6 flex items-center gap-2">
            <svg class="w-9 h-9" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd"
                d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                clip-rule="evenodd" />
            </svg>
            Travelers
          </h2>

          <div
            class="bg-white rounded-2xl border border-gray-200 shadow-md hover:shadow-lg transition-all duration-300 p-6 mb-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
              <div>
                <h3 class="text-xl font-bold text-[#1E71B8]">Adults</h3>
                <p class="text-xs text-gray-500 mt-1">*Age 13 and above</p>
              </div>
            </div>

            <div class="flex items-center justify-between gap-3 bg-gray-50 rounded-lg p-4">
              <div
                class="bg-gradient-to-r from-[#1E71B8] to-[#155E9C] rounded-lg px-4 py-2 text-white font-semibold text-lg">
                ₱{{ selectedPackage.pax_rate?.toLocaleString() }}
              </div>
              <div class="flex items-center gap-3">
                <button @click="pax > 0 && pax--"
                  class="w-10 h-10 rounded-full bg-[#1E71B8] text-white font-bold text-lg flex items-center justify-center transition-all duration-300 hover:bg-[#155E9C] active:scale-95">
                  −
                </button>
                <input type="text" :value="pax"
                  class="w-16 h-10 rounded-lg text-center border-2 border-[#1E71B8] bg-white text-[#1E71B8] font-bold text-lg"
                  readonly />
                <button @click="pax++"
                  class="w-10 h-10 rounded-full bg-[#1E71B8] text-white font-bold text-lg flex items-center justify-center transition-all duration-300 hover:bg-[#155E9C] active:scale-95">
                  +
                </button>
              </div>
            </div>
          </div>

          <div
            class="bg-white rounded-2xl border border-gray-200 shadow-md hover:shadow-lg transition-all duration-300 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
              <div>
                <h3 class="text-xl font-bold text-[#1E71B8]">Kids</h3>
                <p class="text-xs text-gray-500 mt-1">*Age 2-12 years old</p>
              </div>
            </div>

            <div class="flex items-center justify-between gap-3 bg-gray-50 rounded-lg p-4">
              <div
                class="bg-gradient-to-r from-[#1E71B8] to-[#155E9C] rounded-lg px-4 py-2 text-white font-semibold text-lg">
                ₱{{ selectedPackage.kids_pax_rate?.toLocaleString() }}
              </div>
              <div class="flex items-center gap-3">
                <button @click="kidsPax > 0 && kidsPax--"
                  class="w-10 h-10 rounded-full bg-[#1E71B8] text-white font-bold text-lg flex items-center justify-center transition-all duration-300 hover:bg-[#155E9C] active:scale-95">
                  −
                </button>
                <input type="text" :value="kidsPax"
                  class="w-16 h-10 rounded-lg text-center border-2 border-[#1E71B8] bg-white text-[#1E71B8] font-bold text-lg"
                  readonly />
                <button @click="kidsPax++"
                  class="w-10 h-10 rounded-full bg-[#1E71B8] text-white font-bold text-lg flex items-center justify-center transition-all duration-300 hover:bg-[#155E9C] active:scale-95">
                  +
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="mb-8">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-[#1E71B8] flex items-center gap-2">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Itinerary
            </h2>

            <div v-if="isExclusiveTour" class="flex flex-wrap items-center gap-3">
              <button @click="toggleCustomize"
                class="px-5 py-2.5 rounded-lg text-white font-semibold transition-all duration-300 shadow-md hover:shadow-lg"
                :class="isEditingItinerary
                    ? 'bg-gradient-to-r from-[#73BE5D] to-[#5ca348] hover:shadow-xl'
                    : 'bg-gradient-to-r from-[#1E71B8] to-[#155E9C] hover:shadow-xl'
                  ">
                {{ isEditingItinerary ? "✓ Save" : "✎ Customize" }}
              </button>

              <div v-if="isEditingItinerary" class="relative group">
                <button @click="addNewDay" :disabled="Object.keys(editableItinerary).length >=
                  booking.getHowManyDays
                  "
                  class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg shadow-md bg-gradient-to-r from-[#1E71B8] to-[#155E9C] text-white transition-all duration-300 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                  </svg>
                  Add Day
                </button>

                <div v-if="
                  Object.keys(editableItinerary).length >=
                  booking.getHowManyDays
                "
                  class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-900 text-white text-xs px-3 py-2 rounded-lg shadow-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap z-10">
                  You've reached the maximum number of days.
                </div>
              </div>
            </div>
          </div>

          <div v-if="displayItinerary.length === 0"
            class="w-full rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            <p class="text-gray-500 text-lg">No itinerary available yet.</p>
          </div>

          <div v-else class="grid gap-4">
            <div v-for="(item, index) in displayItinerary" :key="item.dayNumber"
              class="bg-gradient-to-r from-blue-50 to-blue-100 p-5 rounded-xl border-l-4 border-[#1E71B8] shadow-sm hover:shadow-md transition-all duration-300">
              <h4 class="font-bold text-lg text-[#1E71B8] mb-3 flex items-center gap-2">
                Day {{ item.dayNumber }}
              </h4>
              <template v-if="isEditingItinerary">
                <textarea v-model="editableItinerary[`day_${item.dayNumber}`]" rows="4"
                  class="w-full p-4 border-2 border-gray-200 rounded-lg text-gray-700 font-medium resize-none focus:outline-none focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8] focus:ring-opacity-20 transition-all duration-300"></textarea>
              </template>
              <template v-else>
                <p class="text-gray-700 whitespace-pre-line leading-relaxed">
                  {{ item.content }}
                </p>
              </template>
            </div>
          </div>
        </div>
      </div>

      <div class="w-full lg:w-96 flex flex-col gap-5">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-md p-6">
          <h3 class="text-[#1E71B8] font-bold text-lg mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
            </svg>
            Discount ID
          </h3>

          <div class="space-y-3">
            <div v-if="discountImages.length > 0" class="space-y-2">
              <div v-for="image in discountImages" :key="image.id" class="relative group">
                <img :src="image.preview" :alt="image.name"
                  class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 shadow-sm" />
                <button @click="removeImage(image.id)"
                  class="absolute -top-2 -right-2 w-7 h-7 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-red-600 shadow-lg">
                  ✕
                </button>
              </div>
            </div>

            <button @click="triggerFileInput" :disabled="discountImages.length >= 1"
              class="w-full py-3 px-4 rounded-lg border-2 border-dashed transition-all duration-300" :class="discountImages.length >= 1
                  ? 'bg-gray-50 border-gray-300 text-gray-400 cursor-not-allowed'
                  : 'bg-blue-50 border-[#1E71B8] text-[#1E71B8] hover:bg-blue-100'
                ">
              <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="font-semibold">{{
                  discountImages.length >= 1 ? "✓ Uploaded" : "Upload ID"
                  }}</span>
              </div>
            </button>
            <input id="discount-image-upload" type="file" accept="image/*" @change="handleImageUpload" class="hidden" />
            <p class="text-gray-500 text-xs text-center">
              *One valid ID upload allowed
            </p>
          </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-md p-6">
          <h3 class="text-[#1E71B8] font-bold text-lg mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
            </svg>
            Remarks
          </h3>
          <textarea v-model="remarks" placeholder="Extra baggage, include infants, etc..."
            class="w-full h-24 px-4 py-3 bg-gray-50 text-gray-800 placeholder-gray-400 rounded-lg border-2 border-gray-200 resize-none focus:outline-none focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8] focus:ring-opacity-20 transition-all duration-300 font-medium"></textarea>
        </div>

        <div
          class="bg-gradient-to-br from-[#1E71B8] to-[#155E9C] rounded-2xl p-6 shadow-lg text-white overflow-hidden relative">
          <div class="absolute -top-12 -right-12 w-32 h-32 bg-white opacity-10 rounded-full"></div>
          <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-[#73BE5D] opacity-10 rounded-full"></div>

          <div class="relative z-10">
            <div class="mb-5 pb-5 border-b border-white border-opacity-20">
              <p class="text-white text-opacity-70 text-xs uppercase tracking-widest font-semibold mb-1">
                Destination
              </p>
              <h2 class="text-2xl font-bold">
                {{ selectedPackage.destination }}
              </h2>
            </div>

            <div class="space-y-4 mb-6">
              <div class="flex items-center justify-between bg-white bg-opacity-10 rounded-lg p-3">
                <span class="text-white text-opacity-80 text-sm">Tour Type</span>
                <span class="font-semibold">{{ booking.tourType }}</span>
              </div>

              <div class="flex items-center justify-between bg-white bg-opacity-10 rounded-lg p-3">
                <span class="text-white text-opacity-80 text-sm">Duration</span>
                <span class="font-semibold">{{ durationDays }} Day<span v-if="durationDays !== 1">s</span></span>
              </div>

              <div class="bg-white bg-opacity-10 rounded-lg p-3 space-y-2 text-sm">
                <div class="flex items-center justify-between">
                  <span class="text-white text-opacity-80">Start Date</span>
                  <span class="font-semibold">{{
                    formatDate(booking.startDate)
                    }}</span>
                </div>
                <div class="flex items-center justify-between">
                  <span class="text-white text-opacity-80">End Date</span>
                  <span class="font-semibold">{{
                    formatDate(booking.endDate)
                    }}</span>
                </div>
              </div>
            </div>

            <div class="h-px bg-gradient-to-r from-transparent via-[#73BE5D] to-transparent mb-4"></div>

            <div class="space-y-3 mb-5 text-sm">
              <div class="flex justify-between">
                <span class="text-white text-opacity-80">Adults × {{ pax }}</span>
                <span class="font-semibold">₱{{ adultTotalAmount.toLocaleString() }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-white text-opacity-80">Kids × {{ kidsPax }}</span>
                <span class="font-semibold">₱{{ kidsTotalAmount.toLocaleString() }}</span>
              </div>

              <div class="h-px bg-white bg-opacity-20"></div>

              <div class="flex justify-between items-center text-lg">
                <span class="font-bold">Total</span>
                <span class="text-[#73BE5D] font-bold text-2xl">₱{{ totalAmountWithDiscount.toLocaleString() }}</span>
              </div>
            </div>

            <button @click="postPackage" :disabled="pax + kidsPax === 0 || (isExclusiveTour && isEditingItinerary)
              "
              class="w-full py-3 px-4 rounded-lg font-bold text-[#1E71B8] text-lg transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
              :class="pax + kidsPax === 0 || (isExclusiveTour && isEditingItinerary)
                  ? 'bg-gray-300'
                  : 'bg-[#73BE5D] hover:bg-[#5ca348] active:scale-95'
                ">
              Proceed to Payment
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import LandingIndex from "./LandingIndex.vue";
import { storeBooking } from "../../state/storeBooking";
import { computed, ref, onMounted, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { api } from "../../api/api";
import { useToast } from "vue-toastification";

defineOptions({ layout: LandingIndex });

const service = new api();
const toast = useToast();
const emit = defineEmits(["next", "back"]);
const page = usePage();
const booking = storeBooking();
const id = computed(() => page.props.id);
const selectedPackage = ref({});
const pax = ref(0);
const kidsPax = ref(0);
const discountImages = ref([]);
const remarks = ref("");
const isEditingItinerary = ref(false);
const editableItinerary = ref({});

const durationDays = computed(() => booking.getHowManyDays);

const adultTotalAmount = computed(() => {
  const amount = selectedPackage.value.pax_rate || 0;
  return amount * pax.value;
});

const kidsTotalAmount = computed(() => {
  const amount = selectedPackage.value.kids_pax_rate || 0;
  return amount * kidsPax.value;
});

const totalAmount = computed(
  () => adultTotalAmount.value + kidsTotalAmount.value
);
const discountRate = 0.2;
const totalAmountWithDiscount = computed(() => {
  const subtotal = totalAmount.value;
  const discountAmount = subtotal * discountRate;
  return subtotal - discountAmount;
});

const isExclusiveTour = computed(
  () => booking.tourType?.toLowerCase() === "exclusive"
);

const displayItinerary = computed(() => {
  let itinerary = isEditingItinerary.value
    ? editableItinerary.value
    : booking.customItinerary && Object.keys(booking.customItinerary).length > 0
      ? booking.customItinerary
      : booking.itinerary;

  if (itinerary && typeof itinerary === "object" && !Array.isArray(itinerary)) {
    return Object.entries(itinerary)
      .sort(([keyA], [keyB]) => {
        const numA = parseInt(keyA.replace("day_", ""));
        const numB = parseInt(keyB.replace("day_", ""));
        return numA - numB;
      })
      .map(([key, value]) => {
        const dayNumber = parseInt(key.replace("day_", ""));
        return {
          dayNumber: dayNumber,
          content: value,
        };
      });
  }

  return Array.isArray(itinerary) ? itinerary : [];
});

const formatDate = (dateString) => {
  if (!dateString) return "N/A";
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", {
    month: "short",
    day: "numeric",
    year: "numeric",
  });
};

const toggleCustomize = () => {
  if (!isExclusiveTour.value) return;
  if (isEditingItinerary.value) {
    booking.customItinerary = editableItinerary.value;
    toast.success("Customization saved successfully!");
    isEditingItinerary.value = false;
  } else {
    const sourceItinerary =
      booking.customItinerary && Object.keys(booking.customItinerary).length > 0
        ? booking.customItinerary
        : booking.itinerary;
    editableItinerary.value = JSON.parse(JSON.stringify(sourceItinerary || {}));
    isEditingItinerary.value = true;
  }
};

const addNewDay = () => {
  const maxDays = booking.getHowManyDays;
  const currentDayCount = Object.keys(editableItinerary.value).length;

  if (currentDayCount < maxDays) {
    const newDayNumber = currentDayCount + 1;
    editableItinerary.value[`day_${newDayNumber}`] = "";
  }
};

const removeDay = (dayNumber) => {
  const currentDayCount = Object.keys(editableItinerary.value).length;

  if (currentDayCount > 1) {
    const newItinerary = {};
    let newDayCounter = 1;

    Object.keys(editableItinerary.value)
      .sort((a, b) => {
        const numA = parseInt(a.replace("day_", ""));
        const numB = parseInt(b.replace("day_", ""));
        return numA - numB;
      })
      .forEach((key) => {
        const currentDayNum = parseInt(key.replace("day_", ""));
        if (currentDayNum !== dayNumber) {
          newItinerary[`day_${newDayCounter}`] = editableItinerary.value[key];
          newDayCounter++;
        }
      });

    editableItinerary.value = newItinerary;
  } else {
    toast.warning("You must have at least one day in the itinerary.");
  }
};

const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (!file || !file.type.startsWith("image/")) {
    toast.error("Please upload a valid image file.");
    return;
  }

  if (discountImages.value.length >= 1) {
    toast.warning("You can only upload one discount ID image.");
    event.target.value = "";
    return;
  }

  const reader = new FileReader();
  reader.onload = (e) => {
    discountImages.value = [
      {
        id: Date.now(),
        file,
        preview: e.target.result,
        name: file.name,
      },
    ];
  };
  reader.readAsDataURL(file);
  event.target.value = "";
};

const removeImage = (imageId) => {
  discountImages.value = discountImages.value.filter(
    (img) => img.id !== imageId
  );
};

const triggerFileInput = () => {
  document.getElementById("discount-image-upload").click();
};

const postPackage = () => {
  if (pax.value === 0 && kidsPax.value === 0) {
    toast.error("Please select at least one traveler before proceeding.");
    return;
  }

  if (isExclusiveTour.value && isEditingItinerary.value) {
    toast.warning(
      "Please save your itinerary customization before proceeding."
    );
    return;
  }

  booking.setPackageId(id.value);
  booking.setAdultsQuantity(pax.value);
  booking.setKidsQuantity(kidsPax.value);
  booking.setAmount(totalAmount.value);
  booking.setTotalAmountWithDiscount(totalAmountWithDiscount.value);
  booking.setPackageDestination(selectedPackage.value.destination);
  booking.setDuration(durationDays.value);
  booking.setAdultRate(selectedPackage.value.pax_rate || 0);
  booking.setKidsRate(selectedPackage.value.kids_pax_rate || 0);
  booking.setAdultTotalAmount(adultTotalAmount.value);
  booking.setKidsTotalAmount(kidsTotalAmount.value);
  booking.setDiscountImages(discountImages.value);
  booking.setRemarks(remarks.value);

  const finalItinerary = booking.customItinerary?.length
    ? booking.customItinerary
    : booking.itinerary || [];
  booking.setItinerary(finalItinerary);

  emit("next");
};

const fetchSelectedPackage = async () => {
  try {
    const response = await service.getPackage(id.value);
    const data = response.data.data;

    if (data.itinerary && typeof data.itinerary === "string") {
      try {
        data.itinerary = JSON.parse(data.itinerary);
      } catch (e) {
        console.error("Failed to parse itinerary:", e);
      }
    }

    selectedPackage.value = data;

    booking.setItinerary(data.itinerary);

  } catch (error) {
    console.error("Error fetching selectedPackage:", error);
  }
};


onMounted(() => {
  fetchSelectedPackage();
});
</script>

<style scoped>
button {
  transition: all 0.3s ease;
}

input,
textarea {
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
