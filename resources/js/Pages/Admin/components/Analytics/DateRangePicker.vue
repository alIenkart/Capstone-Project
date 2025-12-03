<template>
  <div class="relative" ref="calendarContainer">
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div>
        <label
          class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3"
        >
          Start Date*
        </label>
        <button
          :disabled="disabled"
          type="button"
          @click="openCalendar('start')"
          class="w-full px-4 py-3 bg-gradient-to-r from-slate-100 to-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 font-medium hover:border-[#217093] hover:bg-blue-50 transition-all focus:outline-none focus:ring-4 focus:ring-[#217093]/20 disabled:bg-slate-100 disabled:cursor-not-allowed disabled:text-slate-500"
        >
          {{ formatDate(startDate) || "Select start date" }}
        </button>
      </div>

      <div>
        <label
          class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3"
        >
          End Date*
        </label>
        <button
          type="button"
          @click="openCalendar('end')"
          :disabled="!startDate || disabled"
          class="w-full px-4 py-3 bg-gradient-to-r from-slate-100 to-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 font-medium hover:border-[#217093] hover:bg-blue-50 transition-all focus:outline-none focus:ring-4 focus:ring-[#217093]/20 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ formatDate(endDate) || "Select end date" }}
        </button>
      </div>
    </div>

    <Teleport to="body" v-if="showCalendar">
      <div class="fixed inset-0 z-40" @click="closeCalendar"></div>
      <div
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 bg-white rounded-2xl shadow-2xl border border-slate-200 p-8 w-full max-w-md"
        ref="calendarPopup"
      >
        <div class="flex items-center justify-between mb-8">
          <button
            type="button"
            @click="previousMonth"
            class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-600 hover:text-slate-900"
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
                d="M15 19l-7-7 7-7"
              />
            </svg>
          </button>

          <h2 class="text-xl font-bold text-slate-800">
            {{ months[currentMonth.getMonth()] }}
            {{ currentMonth.getFullYear() }}
          </h2>

          <button
            type="button"
            @click="nextMonth"
            class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-600 hover:text-slate-900"
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
                d="M9 5l7 7-7 7"
              />
            </svg>
          </button>
        </div>

        <div class="grid grid-cols-7 gap-2 mb-4">
          <div
            v-for="day in weekDays"
            :key="day"
            class="text-center text-xs font-semibold text-slate-500 py-3"
          >
            {{ day }}
          </div>
        </div>

        <div class="grid grid-cols-7 gap-2 mb-6">
          <div
            v-for="(day, idx) in daysArray"
            :key="idx"
            class="aspect-square flex items-center justify-center"
          >
            <template v-if="day">
              <button
                type="button"
                @click="selectDate(day)"
                :disabled="isPastDate(day)"
                :class="[
                  'w-full h-full rounded-lg text-sm font-semibold transition-all flex items-center justify-center relative',
                  isPastDate(day)
                    ? 'text-slate-300 cursor-not-allowed bg-slate-50'
                    : isStartDate(day) || isEndDate(day)
                    ? 'bg-gradient-to-r from-[#217093] to-[#2a8bb5] text-white shadow-lg scale-105'
                    : isDateInRange(day)
                    ? 'bg-[#2a8bb5]/15 text-[#2a8bb5]'
                    : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900',
                ]"
              >
                {{ day }}
              </button>
            </template>
          </div>
        </div>

        <div class="border-t border-slate-200 pt-6">
          <div class="mb-6">
            <div class="flex items-center justify-between mb-3">
              <div>
                <p class="text-xs text-slate-500 mb-1">Selected Range</p>
                <p class="text-sm font-semibold text-slate-800">
                  {{ formatDate(startDate) || "—" }} →
                  {{ formatDate(endDate) || "—" }}
                </p>
              </div>
              <div v-if="startDate && endDate" class="text-right">
                <p class="text-xs text-slate-500 mb-1">Duration</p>
                <p class="text-lg font-bold text-[#2a8bb5]">
                  {{ calculateDays() }} days
                </p>
              </div>
            </div>
          </div>

          <div class="flex gap-3">
            <button
              type="button"
              @click="closeCalendar"
              class="flex-1 px-4 py-3 bg-slate-100 text-slate-700 font-semibold rounded-xl hover:bg-slate-200 transition-all"
            >
              Cancel
            </button>
            <button
              type="button"
              @click="confirmSelection"
              :disabled="!startDate || !endDate"
              class="flex-1 px-4 py-3 bg-gradient-to-r from-[#217093] to-[#2a8bb5] text-white font-semibold rounded-xl hover:from-[#1a5a7a] hover:to-[#217093] transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Confirm
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from "vue";

const props = defineProps({
  modelValueStart: {
    type: String,
    default: "",
  },
  modelValueEnd: {
    type: String,
    default: "",
  },
  disabled: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(["update:modelValueStart", "update:modelValueEnd"]);

const startDate = ref(props.modelValueStart);
const endDate = ref(props.modelValueEnd);
const showCalendar = ref(false);
const activeInput = ref(null);
const currentMonth = ref(new Date());
const calendarContainer = ref(null);
const calendarPopup = ref(null);

const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];
const weekDays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

const daysInMonth = (date) =>
  new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
const firstDayOfMonth = (date) =>
  new Date(date.getFullYear(), date.getMonth(), 1).getDay();

const getTodayDate = () => {
  const today = new Date();
  return new Date(today.getFullYear(), today.getMonth(), today.getDate());
};

const daysArray = computed(() => {
  const days = [];
  const totalDays = daysInMonth(currentMonth.value);
  const firstDay = firstDayOfMonth(currentMonth.value);

  for (let i = 0; i < firstDay; i++) {
    days.push(null);
  }

  for (let i = 1; i <= totalDays; i++) {
    days.push(i);
  }

  return days;
});

const dateToString = (date) => {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  return `${year}-${month}-${day}`;
};

const formatDate = (dateString) => {
  if (!dateString) return "";
  const [year, month, day] = dateString.split("-");
  const date = new Date(year, month - 1, day);
  return date.toLocaleDateString("en-US", {
    month: "short",
    day: "numeric",
    year: "numeric",
  });
};

const calculateDays = () => {
  if (!startDate.value || !endDate.value) return 0;
  const [startYear, startMonth, startDay] = startDate.value.split("-");
  const [endYear, endMonth, endDay] = endDate.value.split("-");
  const start = new Date(startYear, startMonth - 1, startDay);
  const end = new Date(endYear, endMonth - 1, endDay);
  return Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
};

const isPastDate = (day) => {
  const date = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth(),
    day
  );
  const today = getTodayDate();
  return date < today;
};

const isStartDate = (day) => {
  if (!startDate.value) return false;
  const dateStr = dateToString(
    new Date(
      currentMonth.value.getFullYear(),
      currentMonth.value.getMonth(),
      day
    )
  );
  return dateStr === startDate.value;
};

const isEndDate = (day) => {
  if (!endDate.value) return false;
  const dateStr = dateToString(
    new Date(
      currentMonth.value.getFullYear(),
      currentMonth.value.getMonth(),
      day
    )
  );
  return dateStr === endDate.value;
};

const isDateInRange = (day) => {
  if (!startDate.value || !endDate.value) return false;
  const [startYear, startMonth, startDay] = startDate.value.split("-");
  const [endYear, endMonth, endDay] = endDate.value.split("-");
  const start = new Date(startYear, startMonth - 1, startDay);
  const end = new Date(endYear, endMonth - 1, endDay);
  const date = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth(),
    day
  );
  return date > start && date < end;
};

const openCalendar = (input) => {
  activeInput.value = input;
  showCalendar.value = true;
  currentMonth.value = new Date();
};

const closeCalendar = () => {
  showCalendar.value = false;
  activeInput.value = null;
};

const previousMonth = () => {
  currentMonth.value = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth() - 1
  );
};

const nextMonth = () => {
  currentMonth.value = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth() + 1
  );
};

const selectDate = (day) => {
  if (isPastDate(day)) return;

  const selected = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth(),
    day
  );
  const dateString = dateToString(selected);

  if (activeInput.value === "start") {
    startDate.value = dateString;
    if (!endDate.value || dateString > endDate.value) {
      endDate.value = "";
    }
    activeInput.value = "end";
  } else if (activeInput.value === "end") {
    if (dateString >= startDate.value) {
      endDate.value = dateString;
    }
  }
};

const confirmSelection = () => {
  if (startDate.value && endDate.value) {
    emit("update:modelValueStart", startDate.value);
    emit("update:modelValueEnd", endDate.value);
    closeCalendar();
  }
};

const handleClickOutside = (e) => {
  if (
    calendarContainer.value &&
    !calendarContainer.value.contains(e.target) &&
    calendarPopup.value &&
    !calendarPopup.value.contains(e.target)
  ) {
    closeCalendar();
  }
};

watch(
  () => props.modelValueStart,
  (newValue) => {
    startDate.value = newValue;
  }
);

watch(
  () => props.modelValueEnd,
  (newValue) => {
    endDate.value = newValue;
  }
);

onMounted(() => {
  document.addEventListener("mousedown", handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener("mousedown", handleClickOutside);
});
</script>
