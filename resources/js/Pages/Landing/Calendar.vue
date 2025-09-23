<script setup>
import { storeBooking } from '../../state/storeBooking'
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import LandingIndex from './LandingIndex.vue'
import { useToast } from 'vue-toastification'
defineOptions({ layout: LandingIndex })

const emit = defineEmits(['next'])
const booking = storeBooking()
// calendar state
const selectedDate = ref('')
const currentDate = new Date()
const currentMonthIndex = ref(currentDate.getMonth()) // 0-11
const currentYear = ref(currentDate.getFullYear())

// dropdowns
const tourType = ref('Joiners')
const tourTypes = ['Joiners', 'Private', 'Exclusive']
const tourClassification = ref('Land Travel')
const tourClassifications = ['Land Travel', 'Water Adventure', 'Air Travel']
const isTypeOpen = ref(false)
const isClassOpen = ref(false)
const typeDropdownRef = ref(null)
const classDropdownRef = ref(null)
const calendarWrapperRef = ref(null)
const tooltipRef = ref(null)

function selectTourType(t) {
  tourType.value = t
  isTypeOpen.value = false
}

function selectTourClassification(c) {
  tourClassification.value = c
  isClassOpen.value = false
}

function handleClickOutside(event) {
  const typeEl = typeDropdownRef.value
  const classEl = classDropdownRef.value
  const wrapperEl = calendarWrapperRef.value
  const target = event.target
  const clickedInsideType = typeEl && typeEl.contains && typeEl.contains(target)
  const clickedInsideClass = classEl && classEl.contains && classEl.contains(target)
  const clickedInsideTooltip = tooltipRef.value && tooltipRef.value.contains && tooltipRef.value.contains(target)
  const clickedInsideWrapper = wrapperEl && wrapperEl.contains && wrapperEl.contains(target)
  if (!clickedInsideType && !clickedInsideClass && !clickedInsideTooltip && !clickedInsideWrapper) {
    isTypeOpen.value = false
    isClassOpen.value = false
    isTooltipOpen.value = false
  }
}

// simple availability map for demo; in a real app fetch from API
// values: 'closed' | 'available' | 'accepting' | 'full'
const availabilityByDate = ref({
  // example dates
  '2025-01-10': 'accepting',
  '2025-01-11': 'available',
  '2025-01-12': 'full',
})

// sample tour info by date (replace with API data later)
const tourInfoByDate = ref({
  '2025-09-23': { title: 'Baguio Tour', slotsBooked: 4, slotsTotal: 10, status: 'Accepting Joiners', price: 'P XXXX' },
  '2025-09-24': { title: 'Boracay Tour', slotsBooked: 10, slotsTotal: 10, status: 'Slots Full', price: 'P XXXX' },
  '2025-09-25': { title: 'La Union Tour', slotsBooked: 0, slotsTotal: 10, status: 'Closed', price: 'P XXXX' },
})

// tooltip state
const isTooltipOpen = ref(false)
const tooltipX = ref(0)
const tooltipY = ref(0)
const tooltipData = ref({ title: '', date: '', slotsBooked: 0, slotsTotal: 0, status: '', price: '' })

function formatHuman(ymd) {
  const [y, m, d] = ymd.split('-').map(Number)
  const date = new Date(y, m - 1, d)
  return date.toLocaleDateString('en-US', { day: '2-digit', month: 'long', year: 'numeric' })
}

function showTooltip(event, dateKey) {
  const info = tourInfoByDate.value[dateKey] || null
  isTooltipOpen.value = true
  tooltipData.value = {
    title: info ? info.title : 'Tour',
    date: formatHuman(dateKey),
    slotsBooked: info ? info.slotsBooked : 0,
    slotsTotal: info ? info.slotsTotal : 0,
    status: info ? info.status : 'Available',
    price: info ? info.price : 'P -',
  }

  const wrapper = calendarWrapperRef.value
  if (wrapper && wrapper.getBoundingClientRect) {
    const rect = wrapper.getBoundingClientRect()
    const clickX = event.clientX - rect.left
    const clickY = event.clientY - rect.top
    // clamp position to keep the card inside the wrapper
    tooltipX.value = Math.max(8, Math.min(clickX, rect.width - 360))
    tooltipY.value = Math.max(8, Math.min(clickY, rect.height - 220))
  } else {
    tooltipX.value = 12
    tooltipY.value = 12
  }
}

function closeTooltip() {
  isTooltipOpen.value = false
}

const monthName = computed(() =>
  new Date(currentYear.value, currentMonthIndex.value, 1).toLocaleString('default', { month: 'long' })
)

function formatYmd(year, monthIndex, day) {
  const m = String(monthIndex + 1).padStart(2, '0')
  const d = String(day).padStart(2, '0')
  return `${year}-${m}-${d}`
}

const days = computed(() => {
  const firstDay = new Date(currentYear.value, currentMonthIndex.value, 1)
  const startWeekday = firstDay.getDay() // 0=Sun
  const daysInMonth = new Date(currentYear.value, currentMonthIndex.value + 1, 0).getDate()
  const grid = []
  for (let i = 0; i < startWeekday; i++) {
    grid.push({ day: null, dateKey: null, status: null })
  }
  for (let d = 1; d <= daysInMonth; d++) {
    const key = formatYmd(currentYear.value, currentMonthIndex.value, d)
    grid.push({ day: d, dateKey: key, status: availabilityByDate.value[key] || 'available' })
  }
  while (grid.length % 7 !== 0) {
    grid.push({ day: null, dateKey: null, status: null })
  }
  return grid
})

function prevMonth() {
  if (currentMonthIndex.value === 0) {
    currentMonthIndex.value = 11
    currentYear.value -= 1
  } else {
    currentMonthIndex.value -= 1
  }
}

function nextMonth() {
  if (currentMonthIndex.value === 11) {
    currentMonthIndex.value = 0
    currentYear.value += 1
  } else {
    currentMonthIndex.value += 1
  }
}

const toast = useToast();

function postDate() {
  if (!selectedDate.value) {
    toast.warning('Please select a date before continuing.')
    return
  }

  booking.tourType = tourType.value
  booking.tourClassification = tourClassification.value

  booking.setCalendar({
    startDate: selectedDate.value,
    endDate: selectedDate.value,
  })
  emit('next')
}

onMounted(() => {
  console.log(booking.$state) 
  selectedDate.value = booking.startDate || ''

  document.addEventListener('click', handleClickOutside)
});

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
<template>
  <div class="w-full min-h-screen flex flex-col items-center bg-[#fcfcfc] py-8">
    <!-- Stepper at the top -->
    <div class="flex items-center gap-2 mb-8 mt-2 w-full max-w-5xl justify-center">
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#1E71B8] flex items-center justify-center">
          <span class="w-2 h-2 rounded-full bg-[#1E71B8]"></span>
        </span>
        <span class="ml-1 text-[#1E71B8] font-semibold text-base">Availability</span>
      </div>
      <span class="w-16 h-0.5 bg-[#1E71B8] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#1E71B8] flex items-center justify-center"></span>
        <span class="ml-1 text-[#1E71B8] font-semibold text-base">Reservation Details</span>
      </div>
      <span class="w-16 h-0.5 bg-[#1E71B8] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#1E71B8] flex items-center justify-center"></span>
        <span class="ml-1 text-[#1E71B8] font-semibold text-base">Confirmation</span>
      </div>
    </div>
    <div class="flex flex-row w-full max-w-[1400px] justify-center flex-1 items-start">
      <!-- Legends (left) -->
      <div class="flex flex-col items-start mt-4 min-w-[160px]">
        <span class="text-lg text-[#1E71B8] mb-2 ml-0 uppercase">Legends</span>
        <div class="flex items-center gap-2 mb-2">
          <span class="inline-block w-3 h-3 rounded-full bg-[#737373]"></span>
          <span class="text-base text-[#737373]">Closed</span>
        </div>
        <div class="flex items-center gap-2 mb-2">
          <span class="inline-block w-3 h-3 rounded-full bg-[#302e2e]"></span>
          <span class="text-base text-[#302e2e]">Available</span>
        </div>
        <div class="flex items-center gap-2 mb-2">
          <span class="inline-block w-3 h-3 rounded-full bg-[#2f5f98]"></span>
          <span class="text-base text-[#2f5f98]">Slots Full</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="inline-block w-3 h-3 rounded-full bg-[#45a834]"></span>
          <span class="text-base text-[#45a834]">Accepting Joiners</span>
        </div>
      </div>
      <!-- Calendar -->
      <div class="flex-1 flex flex-col items-center">
        <div class="w-full max-w-[1600px]">
          <div
            class="w-full bg-white rounded-xl flex items-center justify-center"
            style="height:650px; border-radius: 16px; border: 1px solid #eee;"
          >
            <div class="w-full px-6 py-6">
              <div class="flex flex-col gap-4">
                <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-end">
                  <div class="flex-1 relative" ref="typeDropdownRef">
                    <label class="text-[#1E71B8] mb-1 font-semibold block">Tour Type</label>
                    <button type="button"
                            class="w-full border border-[#1E71B8] rounded-xl px-4 py-3 bg-white text-left text-[#1E71B8] flex items-center justify-between"
                            @click="isTypeOpen = !isTypeOpen; isClassOpen = false">
                      <span>{{ tourType }}</span>
                      <span class="ml-3 inline-flex items-center">
                        <svg v-if="!isTypeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1E71B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1E71B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <polyline points="18 15 12 9 6 15"></polyline>
                        </svg>
                      </span>
                    </button>
                    <div v-if="isTypeOpen" class="dropdown-menu" style="position:absolute; width:100%; top: 100%;">
                      <a v-for="t in tourTypes" :key="t" href="#" class="dropdown-item" :class="{ 'bg-[#eee] text-[#73BE5D]': t === tourType }" @click.prevent="selectTourType(t)">{{ t }}</a>
                    </div>
                  </div>
                  <div class="flex-1 relative" ref="classDropdownRef">
                    <label class="text-[#1E71B8] mb-1 font-semibold block">Tour Classification</label>
                    <button type="button"
                            class="w-full border border-[#1E71B8] rounded-xl px-4 py-3 bg-white text-left text-[#1E71B8] flex items-center justify-between"
                            @click="isClassOpen = !isClassOpen; isTypeOpen = false">
                      <span>{{ tourClassification }}</span>
                      <span class="ml-3 inline-flex items-center">
                        <svg v-if="!isClassOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1E71B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1E71B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <polyline points="18 15 12 9 6 15"></polyline>
                        </svg>
                      </span>
                    </button>
                    <div v-if="isClassOpen" class="dropdown-menu" style="position:absolute; width:100%; top: 100%;">
                      <a v-for="c in tourClassifications" :key="c" href="#" class="dropdown-item" :class="{ 'bg-[#eee] text-[#73BE5D]': c === tourClassification }" @click.prevent="selectTourClassification(c)">{{ c }}</a>
                    </div>
                  </div>
                </div>

                <div class="mt-4">
                  <div class="flex items-center justify-between mb-4">
                    <button @click="prevMonth" class="px-3 py-2 rounded-lg border text-[#1E71B8] border-[#1E71B8] hover:bg-[#1E71B8] hover:text-[#ffffff]">‹</button>
                    <div class="text-xl font-bold text-[#1E71B8] uppercase">{{ monthName }} {{ currentYear }}</div>
                    <button @click="nextMonth" class="px-3 py-2 rounded-lg border text-[#1E71B8] border-[#1E71B8] hover:bg-[#1E71B8] hover:text-[#ffffff]">›</button>
                  </div>

                  <div class="grid grid-cols-7 gap-2 text-center text-base text-semibold text-[#1E71B8]">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                  </div>

                  <div class="grid grid-cols-7 gap-2" ref="calendarWrapperRef" style="position: relative;">
                    <div v-for="(cell, i) in days" :key="i"
                         class="h-16 rounded-lg flex items-center justify-center cursor-pointer select-none"
                         :class="{
                           'bg-[#73BE5D] text-[#000000]': cell.dateKey && selectedDate === cell.dateKey,
                           'bg-gray-100 text-gray-400 cursor-default': !cell.day,
                           'bg-[#d9d9d9] text-black': cell.status === 'closed',
                           'bg-[#45a834] text-white': cell.status === 'accepting',
                           'bg-[#2f5f98] text-white': cell.status === 'full',
                           'hover:bg-[#73BE5D]': cell.day && !selectedDate,
                         }"
                         @click.stop="cell.day && (selectedDate = cell.dateKey, showTooltip($event, cell.dateKey))">
                      <span v-if="cell.day">{{ cell.day }}</span>
                    </div>
                    <div v-if="isTooltipOpen" ref="tooltipRef" class="rounded-xl border border-[#1E71B8] shadow-md bg-white"
                         :style="{ position: 'absolute', left: tooltipX + 'px', top: tooltipY + 'px', width: '340px' }"
                         @click.stop>
                      <div class="px-4 pt-4 pb-3">
                        <div class="flex items-start justify-between mb-2">
                          <div class="text-[#1E71B8] font-semibold">{{ tooltipData.title }}</div>
                          <button class="text-[#1E71B8] font-bold" @click="closeTooltip">X</button>
                        </div>
                        <div class="h-0.5 w-full bg-[#73BE5D] mb-3"></div>
                        <div class="text-sm">
                          <div class="mb-1"><span class="font-semibold text-[#1E71B8]">Date:</span> {{ tooltipData.date }}</div>
                          <div class="mb-1"><span class="font-semibold text-[#1E71B8]">Slots Booked:</span> {{ tooltipData.slotsBooked }} / {{ tooltipData.slotsTotal }}</div>
                          <div class="mb-1"><span class="font-semibold text-[#1E71B8]">Status:</span> {{ tooltipData.status }}</div>
                          <div class="mb-3"><span class="font-semibold text-[#1E71B8]">Price:</span> {{ tooltipData.price }}</div>
                          <div class="w-full flex justify-center">
                            <button class="px-8 py-2 bg-[#1E71B8] text-white rounded-md">JOIN</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <button @click="postDate" class="mt-8 mb-0 px-16 py-4 bg-[#1E71B8] text-white font-semibold rounded-xl shadow hover:bg-[#73BE5D] transition text-lg" style="min-width:200px;">
          Next
        </button>
      </div>
    </div>
  </div>
</template>
<style scoped>
select option:hover {
  background-color: #fbeee0 !important;
  color: #73BE5D !important;
}
select option:checked {
  background-color: #fbeee0 !important;
  color: #73BE5D !important;
}
</style>