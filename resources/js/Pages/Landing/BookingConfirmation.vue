<template>
  <div
    class="w-full min-h-screen bg-gradient-to-br from-[#f8fafc] to-[#f1f5f9] py-8"
  >
    <div
      class="flex items-center gap-2 mb-12 mt-2 w-full max-w-6xl justify-center mx-auto px-4"
    >
      <div class="flex items-center gap-1">
        <span
          class="w-4 h-4 rounded-full border-2 border-[#008DDA] bg-[#008DDA] flex items-center justify-center"
        >
          <svg
            class="w-2 h-2 text-white"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <circle cx="8" cy="8" r="8" />
          </svg>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-sm md:text-base"
          >Availability</span
        >
      </div>
      <span
        class="w-8 md:w-16 h-0.5 bg-gradient-to-r from-[#008DDA] to-[#1E71B8] mx-2"
      ></span>
      <div class="flex items-center gap-1">
        <span
          class="w-4 h-4 rounded-full border-2 border-[#008DDA] bg-[#008DDA] flex items-center justify-center"
        >
          <svg
            class="w-2 h-2 text-white"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <circle cx="8" cy="8" r="8" />
          </svg>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-sm md:text-base"
          >Reservation Details</span
        >
      </div>
      <span
        class="w-8 md:w-16 h-0.5 bg-gradient-to-r from-[#008DDA] to-[#1E71B8] mx-2"
      ></span>
      <div class="flex items-center gap-1">
        <span
          class="w-4 h-4 rounded-full border-2 border-[#1E71B8] bg-[#1E71B8] flex items-center justify-center"
        >
          <span
            class="w-4 h-4 rounded-full border-2 border-[#1E71B8] flex items-center justify-center"
          >
            <span class="w-2 h-2 rounded-full bg-[#1E71B8]"></span>
          </span>
        </span>
        <span class="ml-1 text-[#1E71B8] font-semibold text-sm md:text-base"
          >Confirmation</span
        >
      </div>
    </div>

    <div
      class="flex flex-col lg:flex-row w-full max-w-7xl justify-center gap-8 mx-auto px-4"
    >
      <div class="flex-1">
        <div class="flex justify-start mb-6">
          <button
            @click="emit('back')"
            class="px-6 py-2.5 rounded-lg font-semibold text-sm transition-all duration-300 bg-white text-[#1E71B8] border border-[#1E71B8] hover:bg-[#1E71B8] hover:text-white shadow-md hover:shadow-lg"
          >
            ← Back
          </button>
        </div>

        <div class="mb-8">
          <h2
            class="text-3xl font-bold text-[#1E71B8] mb-6 flex items-center gap-2"
          >
            <svg
              class="w-8 h-8"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              ></path>
            </svg>
            Your Details
          </h2>

          <form
            class="bg-white rounded-2xl border border-gray-200 shadow-md p-6 md:p-8"
          >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <label
                  class="block text-[#1E71B8] font-bold text-sm uppercase tracking-wide mb-2"
                  >First Name</label
                >
                <input
                  type="text"
                  v-model="first_name"
                  :class="[
                    'w-full border-2 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#1E71B8] focus:border-transparent transition-all duration-300',
                    errors.first_name
                      ? 'border-red-500'
                      : 'border-gray-200 hover:border-gray-300',
                  ]"
                />
                <p
                  v-if="errors.first_name"
                  class="text-red-600 text-xs mt-2 font-medium"
                >
                  {{ errors.first_name }}
                </p>
              </div>

              <div>
                <label
                  class="block text-[#1E71B8] font-bold text-sm uppercase tracking-wide mb-2"
                  >Last Name</label
                >
                <input
                  type="text"
                  v-model="last_name"
                  :class="[
                    'w-full border-2 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#1E71B8] focus:border-transparent transition-all duration-300',
                    errors.last_name
                      ? 'border-red-500'
                      : 'border-gray-200 hover:border-gray-300',
                  ]"
                />
                <p
                  v-if="errors.last_name"
                  class="text-red-600 text-xs mt-2 font-medium"
                >
                  {{ errors.last_name }}
                </p>
              </div>

              <div>
                <label
                  class="block text-[#1E71B8] font-bold text-sm uppercase tracking-wide mb-2"
                  >Email</label
                >
                <input
                  type="email"
                  v-model="email"
                  :class="[
                    'w-full border-2 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#1E71B8] focus:border-transparent transition-all duration-300',
                    errors.email
                      ? 'border-red-500'
                      : 'border-gray-200 hover:border-gray-300',
                  ]"
                />
                <p
                  v-if="errors.email"
                  class="text-red-600 text-xs mt-2 font-medium"
                >
                  {{ errors.email }}
                </p>
              </div>

              <div>
                <label
                  class="block text-[#1E71B8] font-bold text-sm uppercase tracking-wide mb-2"
                  >Contact No.</label
                >
                <input
                  type="text"
                  v-model="phone_number"
                  :class="[
                    'w-full border-2 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#1E71B8] focus:border-transparent transition-all duration-300',
                    errors.phone_number
                      ? 'border-red-500'
                      : 'border-gray-200 hover:border-gray-300',
                  ]"
                />
                <p
                  v-if="errors.phone_number"
                  class="text-red-600 text-xs mt-2 font-medium"
                >
                  {{ errors.phone_number }}
                </p>
              </div>

              <div class="md:col-span-2">
                <label
                  class="block text-[#1E71B8] font-bold text-sm uppercase tracking-wide mb-2"
                  >Address (For Pickups)</label
                >
                <input
                  type="text"
                  v-model="address"
                  :class="[
                    'w-full border-2 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-[#1E71B8] focus:border-transparent transition-all duration-300',
                    errors.address
                      ? 'border-red-500'
                      : 'border-gray-200 hover:border-gray-300',
                  ]"
                />
                <p
                  v-if="errors.address"
                  class="text-red-600 text-xs mt-2 font-medium"
                >
                  {{ errors.address }}
                </p>
              </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
              <div class="flex items-start gap-3">
                <input
                  type="checkbox"
                  id="agree"
                  v-model="agreeChecked"
                  class="accent-[#1E71B8] mt-1 w-5 h-5 cursor-pointer"
                />
                <label
                  for="agree"
                  class="text-gray-700 text-sm leading-relaxed"
                >
                  I confirm that I have read and agree to the
                  <a
                    href="#"
                    @click.prevent="openModal('terms')"
                    class="text-[#1E71B8] font-semibold underline hover:text-[#155E9C] transition-colors"
                    >Terms and Conditions</a
                  >
                  and
                  <a
                    href="#"
                    @click.prevent="openModal('privacy')"
                    class="text-[#1E71B8] font-semibold underline hover:text-[#155E9C] transition-colors"
                    >Privacy Policy</a
                  >.
                </label>
              </div>
            </div>

            <button
              @click="postBooking"
              type="button"
              :disabled="!agreeChecked || isLoading"
              :class="[
                'w-full py-3 text-white font-bold rounded-lg shadow-lg text-lg transition-all duration-300 flex items-center justify-center gap-2',
                !agreeChecked || isLoading
                  ? 'bg-gray-400 cursor-not-allowed'
                  : 'bg-gradient-to-r from-[#1E71B8] to-[#155E9C] hover:shadow-xl active:scale-95',
              ]"
            >
              <svg
                v-if="isLoading"
                class="animate-spin h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              {{ isLoading ? "Processing..." : "Book Now" }}
            </button>
          </form>
        </div>
      </div>

      <div class="w-full lg:w-96">
        <div
          class="bg-gradient-to-br from-[#1E71B8] to-[#155E9C] rounded-2xl p-6 shadow-lg text-white overflow-hidden relative h-fit sticky top-8"
        >
          <div
            class="absolute -top-12 -right-12 w-32 h-32 bg-white opacity-10 rounded-full"
          ></div>
          <div
            class="absolute -bottom-8 -left-8 w-24 h-24 bg-[#73BE5D] opacity-10 rounded-full"
          ></div>

          <div class="relative z-10">
            <div class="mb-5 pb-5 border-b border-white border-opacity-20">
              <p
                class="text-white text-opacity-70 text-xs uppercase tracking-widest font-semibold mb-1"
              >
                Booking Summary
              </p>
              <h2 class="text-2xl font-bold">
                {{ booking.packageDestination }}
              </h2>
            </div>

            <div class="space-y-4 mb-6">
              <div
                class="flex items-center justify-between bg-white bg-opacity-10 rounded-lg p-3"
              >
                <span class="text-white text-opacity-80 text-sm"
                  >Tour Type</span
                >
                <span class="font-semibold">{{ booking.tourType }}</span>
              </div>

              <div
                class="flex items-center justify-between bg-white bg-opacity-10 rounded-lg p-3"
              >
                <span class="text-white text-opacity-80 text-sm">Duration</span>
                <span class="font-semibold"
                  >{{ booking.duration }} Day<span v-if="durationDays !== 1"
                    >s</span
                  ></span
                >
              </div>

              <div
                class="bg-white bg-opacity-10 rounded-lg p-3 space-y-2 text-sm"
              >
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

            <div
              class="h-px bg-gradient-to-r from-transparent via-[#73BE5D] to-transparent mb-4"
            ></div>

            <div class="space-y-3 mb-5 text-sm">
              <div class="flex justify-between">
                <span class="text-white text-opacity-80"
                  >Adults × {{ booking.adultsQuantity }}</span
                >
                <span class="font-semibold"
                  >₱{{
                    (
                      booking.adultRate * booking.adultsQuantity
                    ).toLocaleString()
                  }}</span
                >
              </div>
              <div class="flex justify-between">
                <span class="text-white text-opacity-80"
                  >Kids × {{ booking.kidsQuantity }}</span
                >
                <span class="font-semibold"
                  >₱{{
                    (booking.kidsRate * booking.kidsQuantity).toLocaleString()
                  }}</span
                >
              </div>

              <div class="h-px bg-white bg-opacity-20"></div>

              <div class="flex justify-between items-center text-lg">
                <span class="font-bold">Total</span>
                <span class="text-[#73BE5D] font-bold text-2xl"
                  >₱{{ booking.amountWithDiscount.toLocaleString() }}</span
                >
              </div>
            </div>

            <div
              class="bg-[#73BE5D] bg-opacity-20 border border-[#73BE5D] rounded-lg p-3 text-xs text-center font-semibold"
            >
              ✓ Ready to confirm your booking
            </div>
          </div>
        </div>
      </div>
    </div>

    <TermsAndPrivacyModal
      :show="showModal"
      :type="modalType"
      @close="closeModal"
    />

    <BookingSuccessModal
      :show="showSuccessModal"
      @close="closeSuccessModal"
      @returnHome="returnHome"
    />

    <LoadingOverlay :show="isLoading" message="Processing your booking..." />
  </div>
</template>

<script setup>
import LandingIndex from "./LandingIndex.vue";
import { api } from "../../api/api";
import { usePage } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import { storeBooking } from "../../state/storeBooking";
import { useToast } from "vue-toastification";
import TermsAndPrivacyModal from "../../components/TermsAndPrivacyModal.vue";
import BookingSuccessModal from "../../components/BookingSuccessModal.vue";
import LoadingOverlay from "../../components/LoadingOverlay.vue";

defineOptions({ layout: LandingIndex });

const emit = defineEmits(["back"]);
const service = new api();
const page = usePage();
const user = computed(() => page.props.auth?.user);
const booking = storeBooking();
const toast = useToast();

const first_name = ref("");
const last_name = ref("");
const email = ref("");
const phone_number = ref("");
const address = ref("");
const agreeChecked = ref(false);
const showModal = ref(false);
const modalType = ref("terms");
const showSuccessModal = ref(false);
const isLoading = ref(false);

const errors = ref({
  first_name: "",
  last_name: "",
  email: "",
  phone_number: "",
  address: "",
});

const validateFields = () => {
  let isValid = true;
  errors.value = {
    first_name: "",
    last_name: "",
    email: "",
    phone_number: "",
    address: "",
  };

  if (!first_name.value || !first_name.value.trim()) {
    errors.value.first_name = "First Name is required.";
    isValid = false;
  }
  if (!last_name.value || !last_name.value.trim()) {
    errors.value.last_name = "Last Name is required.";
    isValid = false;
  }
  if (!email.value || !email.value.trim()) {
    errors.value.email = "Email is required.";
    isValid = false;
  } else {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
      errors.value.email = "Enter a valid email address.";
      isValid = false;
    }
  }
  if (!phone_number.value || !phone_number.value.trim()) {
    errors.value.phone_number = "Contact No. is required.";
    isValid = false;
  } else {
    const digits = phone_number.value.replace(/\D/g, "");
    if (digits.length < 7) {
      errors.value.phone_number = "Enter a valid contact number.";
      isValid = false;
    }
  }
  if (!address.value || !address.value.trim()) {
    errors.value.address = "Address is required.";
    isValid = false;
  }

  if (!agreeChecked.value) {
    toast.error("You must agree to the Terms and Privacy Policy.");
    isValid = false;
  }

  return isValid;
};

const discountIdImage = computed(() => booking.discountIdImage);
const selectedIdType = computed(() => booking.selectedIdType);

const durationDays = computed(() => {
  const start = booking.startDate;
  const end = booking.endDate;
  if (!start || !end) return 0;
  const [sy, sm, sd] = String(start).split("-").map(Number);
  const [ey, em, ed] = String(end).split("-").map(Number);
  const startDateUtc = Date.UTC(sy, (sm || 1) - 1, sd || 1);
  const endDateUtc = Date.UTC(ey, (em || 1) - 1, ed || 1);
  const diffMs = endDateUtc - startDateUtc;
  const days = Math.floor(diffMs / (1000 * 60 * 60 * 24)) + 1;
  return days > 0 ? days : 0;
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

async function postBooking() {
  if (!validateFields()) {
    return;
  }

  let itineraryArray = [];

  if (booking.itinerary && typeof booking.itinerary === "object") {
    if (Array.isArray(booking.itinerary)) {
      itineraryArray = booking.itinerary;
    } else {
      itineraryArray = Object.entries(booking.itinerary).map(
        ([key, content], index) => ({
          id: index + 1,
          day: key,
          content: content,
        })
      );
    }
  }

  if (!itineraryArray || itineraryArray.length === 0) {
    toast.error(
      "Itinerary data is missing. Please go back and select a package again."
    );
    return;
  }

  isLoading.value = true;

  booking.setUser({
    first_name: first_name.value,
    last_name: last_name.value,
    email: email.value,
    phone_number: phone_number.value,
    address: address.value,
  });

  const formData = new FormData();
  formData.append("package_id", booking.packageId);
  formData.append(
    "customer_name",
    `${booking.user.first_name} ${booking.user.last_name}`
  );
  formData.append("customer_id", user.value.id);
  formData.append("voucher_id", booking.voucherCode || "");
  formData.append(
    "total_quantity",
    booking.adultsQuantity + booking.kidsQuantity
  );
  formData.append("total_price", booking.amountWithDiscount);
  formData.append("status", "Pending");
  formData.append("remarks", booking.remarks || "");

  formData.append("package_destination", booking.packageDestination);
  formData.append("tour_type", booking.tourType);
  formData.append("duration", booking.duration);
  formData.append("start_date", booking.startDate);
  formData.append("end_date", booking.endDate);

  const itineraryString = JSON.stringify(itineraryArray);
  formData.append("itinerary", itineraryString);

  formData.append("adults_quantity", booking.adultsQuantity);
  formData.append("kids_quantity", booking.kidsQuantity);
  formData.append("adult_rate", booking.adultRate);
  formData.append("kids_rate", booking.kidsRate);
  formData.append("adult_total_amount", booking.adultTotalAmount);
  formData.append("kids_total_amount", booking.kidsTotalAmount);
  formData.append("original_amount", booking.amount);

  formData.append("customer_email", booking.user.email);
  formData.append("customer_phone", booking.user.phone_number);
  formData.append("customer_address", booking.user.address);

  if (booking.discountImages && booking.discountImages.length > 0) {
    booking.discountImages.forEach((image, index) => {
      formData.append(`discount_images[${index}]`, image.file);
    });
  }

  if (discountIdImage.value) {
    formData.append("discount_id_image", discountIdImage.value);
  }
  if (selectedIdType.value) {
    formData.append("id_type", selectedIdType.value);
  }

  try {
    await service.createBooking(formData);
    await new Promise((resolve) => setTimeout(resolve, 500));
    isLoading.value = false;
    showSuccessModal.value = true;
  } catch (error) {
    console.error("Error saving booking:", error);
    console.error("Error response:", error.response?.data);
    isLoading.value = false;
    toast.error("Failed to create booking. Please try again.");
  }
}

const openModal = (type) => {
  modalType.value = type;
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

const closeSuccessModal = () => {
  showSuccessModal.value = false;
};

const returnHome = () => {
  window.location.href = route("destination");
};

const loadUserData = () => {
  if (user.value) {
    first_name.value = user.value.first_name || "";
    last_name.value = user.value.last_name || "";
    email.value = user.value.email || "";
    phone_number.value = user.value.phone_number || "";
  }
};

onMounted(() => {
  loadUserData();
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
