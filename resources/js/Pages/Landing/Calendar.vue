<template>
  <div
    class="w-full min-h-screen bg-gradient-to-br from-[#f8fafc] to-[#f1f5f9] py-8"
  >
    <div
      class="flex items-center gap-2 mb-12 mt-2 w-full max-w-6xl justify-center mx-auto px-4"
    >
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
          >Availability</span
        >
      </div>
      <span
        class="w-8 md:w-16 h-0.5 bg-gradient-to-r from-[#1E71B8] to-[#155E9C] mx-2"
      ></span>
      <div class="flex items-center gap-1">
        <span
          class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center"
        ></span>
        <span class="ml-1 text-gray-400 font-semibold text-sm md:text-base"
          >Reservation Details</span
        >
      </div>
      <span class="w-8 md:w-16 h-0.5 bg-gray-300 mx-2"></span>
      <div class="flex items-center gap-1">
        <span
          class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center"
        ></span>
        <span class="ml-1 text-gray-400 font-semibold text-sm md:text-base"
          >Confirmation</span
        >
      </div>
    </div>

    <div
      class="flex flex-col lg:flex-row w-full max-w-7xl justify-center gap-6 mx-auto px-4"
    >
      <div
        class="bg-white rounded-2xl border border-gray-200 shadow-md p-6 lg:min-w-[200px] h-fit"
      >
        <h3 class="text-lg text-[#1E71B8] font-bold mb-4 uppercase">Legends</h3>
        <div class="space-y-3">
          <div class="flex items-center gap-3">
            <span
              class="w-4 h-4 rounded-full bg-[#737373] flex-shrink-0"
            ></span>
            <span class="text-sm text-[#737373] font-medium">Closed</span>
          </div>
          <div class="flex items-center gap-3">
            <span
              class="w-4 h-4 rounded-full bg-[#302e2e] flex-shrink-0"
            ></span>
            <span class="text-sm text-[#302e2e] font-medium">Available</span>
          </div>
          <div class="flex items-center gap-3">
            <span
              class="w-4 h-4 rounded-full bg-[#2f5f98] flex-shrink-0"
            ></span>
            <span class="text-sm text-[#2f5f98] font-medium">Slots Full</span>
          </div>
          <div class="flex items-center gap-3">
            <span
              class="w-4 h-4 rounded-full bg-[#45a834] flex-shrink-0"
            ></span>
            <span class="text-sm text-[#45a834] font-medium"
              >Accepting Joiners</span
            >
          </div>
        </div>
      </div>

      <div class="flex-1 flex flex-col items-center">
        <div
          class="w-full bg-white rounded-2xl border border-gray-200 shadow-md p-6 md:p-8"
        >
          <div class="flex flex-col gap-6">
            <div class="flex flex-col sm:flex-row gap-4">
              <div class="flex-1 relative" ref="typeDropdownRef">
                <label
                  class="text-[#1E71B8] mb-2 font-bold text-sm uppercase tracking-wide block"
                  >Tour Type</label
                >
                <button
                  type="button"
                  class="w-full border-2 border-[#1E71B8] rounded-xl px-4 py-3 bg-white text-left text-[#1E71B8] font-semibold flex items-center justify-between transition-all duration-300 hover:bg-blue-50"
                  @click="
                    isTypeOpen = !isTypeOpen;
                    isClassOpen = false;
                  "
                >
                  <span>{{ tourType }}</span>
                  <span class="ml-3 inline-flex items-center">
                    <svg
                      v-if="!isTypeOpen"
                      xmlns="http://www.w3.org/2000/svg"
                      width="20"
                      height="20"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="#1E71B8"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                    <svg
                      v-else
                      xmlns="http://www.w3.org/2000/svg"
                      width="20"
                      height="20"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="#1E71B8"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <polyline points="18 15 12 9 6 15"></polyline>
                    </svg>
                  </span>
                </button>
                <div v-if="isTypeOpen" class="dropdown-menu-wrapper">
                  <div class="dropdown-menu">
                    <a
                      v-for="t in tourTypes"
                      :key="t"
                      href="#"
                      class="dropdown-item"
                      :class="{
                        'bg-blue-100 text-[#73BE5D] font-semibold':
                          t === tourType,
                      }"
                      @click.prevent="selectTourType(t)"
                      >{{ t }}</a
                    >
                  </div>
                </div>
              </div>

              <div class="flex-1 relative" ref="classDropdownRef">
                <label
                  class="text-[#1E71B8] mb-2 font-bold text-sm uppercase tracking-wide block"
                  >Tour Classification</label
                >
                <button
                  type="button"
                  class="w-full border-2 border-[#1E71B8] rounded-xl px-4 py-3 bg-white text-left text-[#1E71B8] font-semibold flex items-center justify-between transition-all duration-300 hover:bg-blue-50"
                  @click="
                    isClassOpen = !isClassOpen;
                    isTypeOpen = false;
                  "
                >
                  <span>{{ tourClassification }}</span>
                  <span class="ml-3 inline-flex items-center">
                    <svg
                      v-if="!isClassOpen"
                      xmlns="http://www.w3.org/2000/svg"
                      width="20"
                      height="20"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="#1E71B8"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                    <svg
                      v-else
                      xmlns="http://www.w3.org/2000/svg"
                      width="20"
                      height="20"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="#1E71B8"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <polyline points="18 15 12 9 6 15"></polyline>
                    </svg>
                  </span>
                </button>
                <div v-if="isClassOpen" class="dropdown-menu-wrapper">
                  <div class="dropdown-menu">
                    <a
                      v-for="c in tourClassifications"
                      :key="c"
                      href="#"
                      class="dropdown-item"
                      :class="{
                        'bg-blue-100 text-[#73BE5D] font-semibold':
                          c === tourClassification,
                      }"
                      @click.prevent="selectTourClassification(c)"
                      >{{ c }}</a
                    >
                  </div>
                </div>
              </div>
            </div>

            <div
              v-if="tourType === 'Exclusive'"
              class="bg-gradient-to-r from-blue-50 to-blue-100 border border-[#1E71B8] p-4 rounded-xl flex items-start gap-3"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-6 h-6 text-[#1E71B8] flex-shrink-0"
              >
                <path
                  d="M12 11.993a.75.75 0 0 0-.75.75v.006c0 .414.336.75.75.75h.006a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75H12ZM12 16.494a.75.75 0 0 0-.75.75v.005c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H12ZM8.999 17.244a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.006ZM7.499 16.494a.75.75 0 0 0-.75.75v.005c0 .414.336.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H7.5ZM13.499 14.997a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.005a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.005ZM14.25 16.494a.75.75 0 0 0-.75.75v.006c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75h-.005ZM15.75 14.995a.75.75 0 0 1 .75-.75h.005a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75H16.5a.75.75 0 0 1-.75-.75v-.006ZM13.498 12.743a.75.75 0 0 1 .75-.75h2.25a.75.75 0 1 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75ZM6.748 14.993a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"
                />
                <path
                  fill-rule="evenodd"
                  d="M18 2.993a.75.75 0 0 0-1.5 0v1.5h-9V2.994a.75.75 0 1 0-1.5 0v1.497h-.752a3 3 0 0 0-3 3v11.252a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3V7.492a3 3 0 0 0-3-3H18V2.993ZM3.748 18.743v-7.5a1.5 1.5 0 0 1 1.5-1.5h13.5a1.5 1.5 0 0 1 1.5 1.5v7.5a1.5 1.5 0 0 1-1.5 1.5h-13.5a1.5 1.5 0 0 1-1.5-1.5Z"
                  clip-rule="evenodd"
                />
              </svg>
              <p class="text-[#1E71B8] font-semibold text-sm mt-0.5">
                Select date range: Click start date, then click end date to
                complete your selection.
              </p>
            </div>

            <div class="mt-2">
              <div class="flex items-center justify-between mb-6">
                <button
                  @click="prevMonth"
                  class="px-4 py-2.5 rounded-lg border-2 border-[#1E71B8] text-[#1E71B8] font-bold transition-all duration-300 hover:bg-[#1E71B8] hover:text-white active:scale-95"
                >
                  ‹
                </button>
                <div
                  class="text-2xl font-bold text-[#1E71B8] uppercase tracking-wide"
                >
                  {{ monthName }} {{ currentYear }}
                </div>
                <button
                  @click="nextMonth"
                  class="px-4 py-2.5 rounded-lg border-2 border-[#1E71B8] text-[#1E71B8] font-bold transition-all duration-300 hover:bg-[#1E71B8] hover:text-white active:scale-95"
                >
                  ›
                </button>
              </div>

              <div class="grid grid-cols-7 gap-2 text-center mb-4">
                <div class="text-[#1E71B8] font-bold text-sm">Sun</div>
                <div class="text-[#1E71B8] font-bold text-sm">Mon</div>
                <div class="text-[#1E71B8] font-bold text-sm">Tue</div>
                <div class="text-[#1E71B8] font-bold text-sm">Wed</div>
                <div class="text-[#1E71B8] font-bold text-sm">Thu</div>
                <div class="text-[#1E71B8] font-bold text-sm">Fri</div>
                <div class="text-[#1E71B8] font-bold text-sm">Sat</div>
              </div>

              <div
                class="grid grid-cols-7 gap-3"
                ref="calendarWrapperRef"
                style="position: relative"
              >
                <div
                  v-for="(cell, i) in days"
                  :key="i"
                  class="h-14 rounded-lg flex items-center justify-center select-none font-semibold text-sm transition-all duration-300"
                  :class="{
                    'bg-gradient-to-br from-[#73BE5D] to-[#5ca348] text-white shadow-md':
                      cell.isInRange && !cell.isPast && !cell.isOutOfRange,
                    'bg-gray-100 text-gray-400 cursor-not-allowed':
                      !cell.day || cell.isPast || cell.isOutOfRange,
                    'bg-gray-300 text-gray-700 cursor-not-allowed':
                      tourType === 'Joiners' && cell.day,
                    'bg-gray-300 text-gray-700 cursor-pointer hover:bg-gray-400':
                      tourType !== 'Joiners' &&
                      cell.day &&
                      cell.status === 'closed' &&
                      !cell.isPast &&
                      !cell.isInRange &&
                      !cell.isOutOfRange,
                    'bg-gradient-to-br from-[#45a834] to-[#3a8a2a] text-white cursor-pointer shadow-md hover:shadow-lg':
                      tourType !== 'Joiners' &&
                      cell.day &&
                      cell.status === 'accepting' &&
                      !cell.isPast &&
                      !cell.isInRange &&
                      !cell.isOutOfRange,
                    'bg-gradient-to-br from-[#2f5f98] to-[#1e3f68] text-white cursor-pointer shadow-md hover:shadow-lg':
                      tourType !== 'Joiners' &&
                      cell.day &&
                      cell.status === 'full' &&
                      !cell.isPast &&
                      !cell.isInRange &&
                      !cell.isOutOfRange,
                    'cursor-pointer bg-white border-2 border-[#1E71B8] hover:bg-blue-50':
                      tourType !== 'Joiners' &&
                      cell.day &&
                      !selectedDate &&
                      !cell.isPast &&
                      !cell.isOutOfRange &&
                      cell.status === 'available',
                    'opacity-50':
                      (cell.isPast && cell.day) || cell.isOutOfRange,
                  }"
                  @click="handleDateClick($event, cell)"
                >
                  <span v-if="cell.day">{{ cell.day }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button
          @click="postDate"
          class="mt-8 px-8 py-3 bg-gradient-to-r from-[#1E71B8] to-[#155E9C] text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 active:scale-95 text-lg"
        >
          Next →
        </button>
      </div>
    </div>
    <div
      v-if="isTooltipOpen"
      class="fixed inset-0 z-40 bg-black/30"
      @click="isTooltipOpen = false"
    ></div>
    <div
      v-if="isTooltipOpen"
      ref="tooltipRef"
      class="rounded-2xl shadow-2xl bg-white z-50 overflow-hidden"
      :style="{
        position: 'fixed',
        left: '50%',
        top: '50%',
        transform: 'translate(-50%, -50%)',
        width: '380px',
        maxHeight: '90vh',
        border: '1px solid rgba(30, 113, 184, 0.1)',
        overflowY: 'auto',
      }"
    >
      <div
        class="h-24 bg-gradient-to-br from-[#1E71B8] to-[#155E9C] relative overflow-hidden"
      >
        <div class="absolute inset-0 opacity-10">
          <svg
            class="w-full h-full"
            viewBox="0 0 100 100"
            preserveAspectRatio="none"
          >
            <defs>
              <pattern
                id="pattern"
                x="0"
                y="0"
                width="20"
                height="20"
                patternUnits="userSpaceOnUse"
              >
                <circle cx="10" cy="10" r="1" fill="white" />
              </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#pattern)" />
          </svg>
        </div>
        <button
          type="button"
          @click.stop="isTooltipOpen = false"
          class="absolute top-3 right-3 z-50 w-8 h-8 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-200 flex items-center justify-center group"
          style="pointer-events: auto"
        >
          <svg
            class="w-5 h-5 text-white group-hover:scale-110 transition-transform"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
        <div class="relative pt-6 px-6">
          <h3 class="text-white font-bold text-xl">{{ tooltipData.title }}</h3>
          <div
            class="w-12 h-1 bg-gradient-to-r from-[#73BE5D] to-transparent rounded-full mt-2"
          ></div>
        </div>
      </div>
      <div class="px-6 py-6 space-y-4">
        <div class="flex items-start gap-3 pb-4 border-b border-gray-100">
          <div class="flex-1">
            <p
              class="text-xs font-semibold text-gray-500 uppercase tracking-wide"
            >
              Date
            </p>
            <p class="text-sm text-gray-800 font-medium mt-1">
              {{ tooltipData.date }}
            </p>
          </div>
        </div>
        <div class="flex items-start gap-3 pb-4 border-b border-gray-100">
          <div class="flex-1">
            <p
              class="text-xs font-semibold text-gray-500 uppercase tracking-wide"
            >
              Slots Booked
            </p>
            <div class="flex items-center gap-2 mt-1">
              <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                <div
                  class="h-full bg-gradient-to-r from-[#73BE5D] to-[#5ca348] transition-all"
                  :style="{
                    width:
                      tooltipData.slotsTotal > 0
                        ? (tooltipData.slotsBooked / tooltipData.slotsTotal) *
                            100 +
                          '%'
                        : '0%',
                  }"
                ></div>
              </div>
              <span class="text-sm font-semibold text-gray-700"
                >{{ tooltipData.slotsBooked }}/{{
                  tooltipData.slotsTotal
                }}</span
              >
            </div>
          </div>
        </div>
        <div class="flex items-start gap-3 pb-4 border-b border-gray-100">
          <div class="flex-1">
            <p
              class="text-xs font-semibold text-gray-500 uppercase tracking-wide"
            >
              Status
            </p>
            <div class="flex items-center gap-2 mt-1">
              <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold"
                :class="{
                  'bg-green-100 text-green-800':
                    tooltipData.status === 'Available' ||
                    tooltipData.status === 'Accepting Joiners',
                  'bg-red-100 text-red-800':
                    tooltipData.status === 'Slots Full',
                  'bg-gray-100 text-gray-800': tooltipData.status === 'Closed',
                }"
              >
                {{ tooltipData.status }}
              </span>
            </div>
          </div>
        </div>
        <div class="flex items-start gap-3 pb-4">
          <div class="flex-1">
            <p
              class="text-xs font-semibold text-gray-500 uppercase tracking-wide"
            >
              Price
            </p>
            <p class="text-lg font-bold text-[#73BE5D] mt-1">
              ₱ {{ tooltipData.price }}
            </p>
          </div>
        </div>
        <div
          v-if="tourType === 'Joiners'"
          class="flex items-start gap-3 pt-2 bg-blue-50 -mx-6 -mb-6 px-6 py-4 rounded-b-2xl border-t border-blue-100"
        >
          <div>
            <p
              class="text-xs font-semibold text-[#1E71B8] uppercase tracking-wide"
            >
              Tour Duration
            </p>
            <p class="text-sm font-semibold text-[#1E71B8] mt-1">
              {{ tourDuration }} day{{ tourDuration > 1 ? "s" : "" }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { storeBooking } from "../../state/storeBooking";
import { ref, onMounted, onBeforeUnmount, computed, watch } from "vue";
import LandingIndex from "./LandingIndex.vue";
import { useToast } from "vue-toastification";

defineOptions({ layout: LandingIndex });

const emit = defineEmits(["next"]);
const booking = storeBooking();
const selectedDate = ref("");
const selectedend_date = ref("");
const currentDate = new Date();
const currentMonthIndex = ref(currentDate.getMonth());
const currentYear = ref(currentDate.getFullYear());

const tourType = ref("Joiners");
const tourTypes = ["Joiners", "Exclusive"];
const tourClassification = ref("");
const tourClassifications = ref(null);
const isTypeOpen = ref(false);
const isClassOpen = ref(false);
const typeDropdownRef = ref(null);
const classDropdownRef = ref(null);
const calendarWrapperRef = ref(null);
const tooltipRef = ref(null);

const availabilityByDate = ref({});
const tourInfoByDate = ref({});

const generatePackageDates = () => {
  const pkg = booking.selectedPackage;
  if (!pkg || !pkg.start_date || !pkg.end_date) return;

  const startDateStr = pkg.start_date.split("T")[0];
  const endDateStr = pkg.end_date.split("T")[0];

  const [sy, sm, sd] = startDateStr.split("-").map(Number);
  const [ey, em, ed] = endDateStr.split("-").map(Number);

  let currentDay = sd;
  let currentMonth = sm;
  let currentYear = sy;

  const endDay = ed;
  const endMonth = em;
  const endYear = ey;

  while (
    currentYear < endYear ||
    (currentYear === endYear && currentMonth < endMonth) ||
    (currentYear === endYear &&
      currentMonth === endMonth &&
      currentDay <= endDay)
  ) {
    const m = String(currentMonth).padStart(2, "0");
    const d = String(currentDay).padStart(2, "0");
    const dateKey = `${currentYear}-${m}-${d}`;

    const booked = Math.floor(Math.random() * (pkg.capacity + 1));
    let status = "available";
    if (booked === 0) status = "accepting";
    if (booked >= pkg.capacity) status = "full";

    availabilityByDate.value[dateKey] = status;

    tourInfoByDate.value[dateKey] = {
      title: pkg.package_name,
      slotsBooked: booked,
      slotsTotal: pkg.capacity,
      status:
        status === "accepting"
          ? "Accepting Joiners"
          : status === "full"
          ? "Slots Full"
          : "Available",
      price: `₱ ${pkg.pax_rate}`,
    };

    currentDay++;

    const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
    if (currentDay > daysInMonth) {
      currentDay = 1;
      currentMonth++;

      if (currentMonth > 12) {
        currentMonth = 1;
        currentYear++;
      }
    }
  }
};

const isTooltipOpen = ref(false);
const tooltipX = ref(0);
const tooltipY = ref(0);
const tooltipData = ref({
  title: "",
  date: "",
  slotsBooked: 0,
  slotsTotal: 0,
  status: "",
  price: "",
});

const monthName = computed(() =>
  new Date(currentYear.value, currentMonthIndex.value, 1).toLocaleString(
    "default",
    { month: "long" }
  )
);

const tourDuration = computed(() => {
  const duration = booking.selectedPackage?.tour_duration;
  return duration ? parseInt(duration) : 1;
});

const isWithinBookingRange = (dateKey) => {
  if (
    tourType.value !== "Joiners" ||
    !booking.start_date ||
    !booking.end_date
  ) {
    return true;
  }

  const current = new Date(dateKey);
  const start = new Date(booking.start_date);
  const end = new Date(booking.end_date);

  current.setHours(0, 0, 0, 0);
  start.setHours(0, 0, 0, 0);
  end.setHours(0, 0, 0, 0);

  return current >= start && current <= end;
};

const isDateInRange = (dateKey) => {
  if (!selectedDate.value) return false;

  if (tourType.value === "Exclusive") {
    if (!selectedend_date.value) return dateKey === selectedDate.value;

    const [cy, cm, cd] = dateKey.split("-").map(Number);
    const [sy, sm, sd] = selectedDate.value.split("-").map(Number);
    const [ey, em, ed] = selectedend_date.value.split("-").map(Number);

    const current = cy * 10000 + cm * 100 + cd;
    const start = sy * 10000 + sm * 100 + sd;
    const end = ey * 10000 + em * 100 + ed;

    return current >= start && current <= end;
  } else {
    const [year, month, day] = selectedDate.value.split("-").map(Number);
    const [cy, cm, cd] = dateKey.split("-").map(Number);
    const duration = tourDuration.value;

    let endDay = day + duration - 1;
    let endMonth = month;
    let endYear = year;

    const daysInMonth = new Date(endYear, endMonth, 0).getDate();
    if (endDay > daysInMonth) {
      endDay -= daysInMonth;
      endMonth++;
      if (endMonth > 12) {
        endMonth = 1;
        endYear++;
      }
    }

    const selected = year * 10000 + month * 100 + day;
    const current = cy * 10000 + cm * 100 + cd;
    const end = endYear * 10000 + endMonth * 100 + endDay;

    return current >= selected && current <= end;
  }
};

const days = computed(() => {
  const firstDay = new Date(currentYear.value, currentMonthIndex.value, 1);
  const startWeekday = firstDay.getDay();
  const daysInMonth = new Date(
    currentYear.value,
    currentMonthIndex.value + 1,
    0
  ).getDate();

  const grid = [];
  for (let i = 0; i < startWeekday; i++) {
    grid.push({
      day: null,
      dateKey: null,
      status: null,
      isPast: false,
      isInRange: false,
      isOutOfRange: false,
    });
  }
  for (let d = 1; d <= daysInMonth; d++) {
    const key = formatYmd(currentYear.value, currentMonthIndex.value, d);
    const isPast = isPastDate(currentYear.value, currentMonthIndex.value, d);
    const inRange = isDateInRange(key);
    const outOfRange =
      tourType.value === "Joiners" && !isWithinBookingRange(key);

    grid.push({
      day: d,
      dateKey: key,
      status: availabilityByDate.value[key] || "available",
      isPast: isPast,
      isInRange: inRange,
      isOutOfRange: outOfRange,
    });
  }
  while (grid.length % 7 !== 0) {
    grid.push({
      day: null,
      dateKey: null,
      status: null,
      isPast: false,
      isInRange: false,
      isOutOfRange: false,
    });
  }
  return grid;
});

watch([currentMonthIndex, currentYear], () => {
  if (selectedDate.value) {
    days.value;
  }
});

const formatHuman = (ymd) => {
  const [y, m, d] = ymd.split("-").map(Number);
  const date = new Date(y, m - 1, d);
  return date.toLocaleDateString("en-US", {
    day: "2-digit",
    month: "long",
    year: "numeric",
  });
};

const selectTourType = (t) => {
  tourType.value = t;
  isTypeOpen.value = false;

  if (t === "Joiners") {
    if (booking.start_date && booking.end_date) {
      const parseISODate = (isoString) => {
        const date = new Date(isoString);
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, "0");
        const d = String(date.getDate()).padStart(2, "0");
        return `${y}-${m}-${d}`;
      };
      selectedDate.value = parseISODate(booking.start_date);
      selectedend_date.value = "";
    } else {
      selectedDate.value = "";
      selectedend_date.value = "";
    }
  } else if (t === "Exclusive") {
    selectedDate.value = "";
    selectedend_date.value = "";
  }
};

const selectTourClassification = (c) => {
  tourClassification.value = c;
  isClassOpen.value = false;
};

const handleClickOutside = (event) => {
  const typeEl = typeDropdownRef.value;
  const classEl = classDropdownRef.value;
  const wrapperEl = calendarWrapperRef.value;
  const target = event.target;
  const clickedInsideType =
    typeEl && typeEl.contains && typeEl.contains(target);
  const clickedInsideClass =
    classEl && classEl.contains && classEl.contains(target);
  const clickedInsideTooltip =
    tooltipRef.value &&
    tooltipRef.value.contains &&
    tooltipRef.value.contains(target);
  const clickedInsideWrapper =
    wrapperEl && wrapperEl.contains && wrapperEl.contains(target);
  if (
    !clickedInsideType &&
    !clickedInsideClass &&
    !clickedInsideTooltip &&
    !clickedInsideWrapper
  ) {
    isTypeOpen.value = false;
    isClassOpen.value = false;
    isTooltipOpen.value = false;
  }
};

const showTooltip = (event, dateKey) => {
  const info = tourInfoByDate.value[dateKey] || null;
  isTooltipOpen.value = true;

  let dateDisplay = formatHuman(dateKey);

  if (tourType.value === "Joiners") {
    const [year, month, day] = dateKey.split("-").map(Number);

    let endDay = day + tourDuration.value - 1;
    let endMonth = month;
    let endYear = year;

    const daysInMonth = new Date(endYear, endMonth, 0).getDate();
    if (endDay > daysInMonth) {
      endDay -= daysInMonth;
      endMonth++;
      if (endMonth > 12) {
        endMonth = 1;
        endYear++;
      }
    }

    const endDateKey = `${endYear}-${String(endMonth).padStart(
      2,
      "0"
    )}-${String(endDay).padStart(2, "0")}`;

    dateDisplay = `${formatHuman(dateKey)} - ${formatHuman(endDateKey)}`;
  }

  tooltipData.value = {
    title: info ? info.title : "Tour",
    date: dateDisplay,
    slotsBooked: info ? info.slotsBooked : 0,
    slotsTotal: info ? info.slotsTotal : 0,
    status: info ? info.status : "Available",
    price: info ? info.price : "₱ -",
  };

  const wrapper = calendarWrapperRef.value;
  if (wrapper && wrapper.getBoundingClientRect) {
    const rect = wrapper.getBoundingClientRect();
    const clickX = event.clientX - rect.left;
    const clickY = event.clientY - rect.top;
    tooltipX.value = Math.max(8, Math.min(clickX, rect.width - 380));
    tooltipY.value = Math.max(8, Math.min(clickY, rect.height - 240));
  } else {
    tooltipX.value = 12;
    tooltipY.value = 12;
  }
};

const formatYmd = (year, monthIndex, day) => {
  const m = String(monthIndex + 1).padStart(2, "0");
  const d = String(day).padStart(2, "0");
  return `${year}-${m}-${d}`;
};

const isPastDate = (year, monthIndex, day) => {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const cellDate = new Date(year, monthIndex, day);
  cellDate.setHours(0, 0, 0, 0);
  return cellDate < today;
};

const prevMonth = () => {
  if (currentMonthIndex.value === 0) {
    currentMonthIndex.value = 11;
    currentYear.value -= 1;
  } else {
    currentMonthIndex.value -= 1;
  }
};

const nextMonth = () => {
  if (currentMonthIndex.value === 11) {
    currentMonthIndex.value = 0;
    currentYear.value += 1;
  } else {
    currentMonthIndex.value += 1;
  }
};

const handleDateClick = (event, cell) => {
  if (!cell.day || cell.isPast || cell.isOutOfRange) {
    return;
  }

  if (tourType.value === "Joiners") {
    showTooltip(event, cell.dateKey);
    return;
  }

  if (tourType.value === "Exclusive") {
    if (!selectedDate.value || selectedend_date.value) {
      selectedDate.value = cell.dateKey;
      selectedend_date.value = "";
    } else {
      const start = new Date(selectedDate.value);
      const end = new Date(cell.dateKey);

      if (end < start) {
        selectedend_date.value = selectedDate.value;
        selectedDate.value = cell.dateKey;
      } else {
        selectedend_date.value = cell.dateKey;
      }
    }
  }
};

const toast = useToast();

const postDate = () => {
  if (!selectedDate.value) {
    toast.warning("Please select a date before continuing.");
    return;
  }

  if (tourType.value === "Exclusive" && !selectedend_date.value) {
    toast.warning("Please select an end date for your exclusive tour.");
    return;
  }

  booking.reset();
  booking.tourType = tourType.value;
  booking.tourClassification = tourClassification.value;

  let end_date = selectedDate.value;
  if (tourType.value === "Exclusive") {
    end_date = selectedend_date.value;
  } else {
    const [year, month, day] = selectedDate.value.split("-").map(Number);
    const duration = tourDuration.value;

    let endDay = day + duration - 1;
    let endMonth = month;
    let endYear = year;

    const daysInMonth = new Date(endYear, endMonth, 0).getDate();
    if (endDay > daysInMonth) {
      endDay -= daysInMonth;
      endMonth++;
      if (endMonth > 12) {
        endMonth = 1;
        endYear++;
      }
    }

    end_date = `${endYear}-${String(endMonth).padStart(2, "0")}-${String(
      endDay
    ).padStart(2, "0")}`;
  }

  booking.setCalendar({
    start_date: selectedDate.value,
    end_date: end_date,
  });

  booking.setTourType(booking.tourType);
  booking.setTourClassification(booking.tourClassification);
  emit("next");
};

onMounted(() => {
  tourClassifications.value = booking.selectedPackage.tour_classification;
  tourClassification.value = booking.selectedPackage.tour_classification[0];

  generatePackageDates();

  if (booking.start_date && booking.end_date) {
    const start_dateFormatted = booking.start_date.split("T")[0];
    const end_dateFormatted = booking.end_date.split("T")[0];

    if (tourType.value === "Joiners") {
      selectedDate.value = start_dateFormatted;
      selectedend_date.value = "";

      const [year, month] = start_dateFormatted.split("-").map(Number);
      currentMonthIndex.value = month - 1;
      currentYear.value = year;
    } else {
      selectedDate.value = start_dateFormatted;
      selectedend_date.value = end_dateFormatted;
    }
  } else {
    selectedDate.value = "";
    selectedend_date.value = "";
  }

  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>

<style scoped>
.dropdown-menu-wrapper {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 50;
  margin-top: 8px;
}

.dropdown-menu {
  position: relative;
  background: #fff;
  border: 2px solid #1e71b8;
  box-shadow: 0 8px 24px rgba(30, 113, 184, 0.15);
  border-radius: 12px;
  min-width: 100%;
  padding: 8px 0;
  display: flex;
  flex-direction: column;
  gap: 0;
}

.dropdown-item {
  display: block;
  padding: 12px 20px;
  color: #1e71b8;
  text-align: left;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.2s ease;
  cursor: pointer;
}

.dropdown-item:hover {
  background: #f0f9ff;
  color: #73be5d;
  padding-left: 24px;
}
</style>
