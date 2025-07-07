<script setup>
import { storeBooking } from '../../state/storeBooking'
import { ref, onMounted} from 'vue'
import LandingIndex from './LandingIndex.vue'
defineOptions({ layout: LandingIndex })

const emit = defineEmits(['next'])
const booking = storeBooking()
const startDate = ref('')
const endDate = ref('')

function postDate() {
  booking.setCalendar({
    startDate: startDate.value,
    endDate: endDate.value,
  })
  emit('next')
}

onMounted(() => {
  console.log(booking.$state) 

});
</script>
<template>
  <div class="w-full min-h-screen flex flex-col items-center bg-[#fcfcfc] py-8">
    <!-- Stepper at the top -->
    <div class="flex items-center gap-2 mb-8 mt-2 w-full max-w-5xl justify-center">
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#ff7f2a] flex items-center justify-center">
          <span class="w-2 h-2 rounded-full bg-[#ff7f2a]"></span>
        </span>
        <span class="ml-1 text-[#ff7f2a] font-semibold text-base">Availability</span>
      </div>
      <span class="w-16 h-0.5 bg-[#ff7f2a] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#ff7f2a] flex items-center justify-center"></span>
        <span class="ml-1 text-[#ff7f2a] font-semibold text-base">Select Package</span>
      </div>
      <span class="w-16 h-0.5 bg-[#ff7f2a] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#ff7f2a] flex items-center justify-center"></span>
        <span class="ml-1 text-[#ff7f2a] font-semibold text-base">Confirmation</span>
      </div>
    </div>
    <div class="flex flex-row w-full max-w-[1400px] justify-center flex-1 items-start">
      <!-- Legends (left) -->
      <div class="flex flex-col items-start mt-4 min-w-[120px]">
        <span class="text-xs text-gray-500 mb-2 ml-1 italic">Legends</span>
        <div class="flex items-center gap-2 mb-2">
          <span class="inline-block w-3 h-3 rounded-full bg-[#ff6b6b]"></span>
          <span class="text-sm text-[#ff6b6b]">Closed</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="inline-block w-3 h-3 rounded-full bg-black"></span>
          <span class="text-sm text-black">Available</span>
        </div>
      </div>
      <!-- Calendar -->
      <div class="flex-1 flex flex-col items-center">
        <div class="w-full max-w-[1600px]">
          <div
            class="w-full bg-white rounded-xl flex items-center justify-center"
            style="height:650px; border-radius: 16px; border: 1px solid #eee;"
          >
            <span class="text-gray-400 text-2xl">
              // insert calendar

              <div class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex flex-col">
                  <label for="startDate" class="text-[#f28c3a] mb-1 font-semibold">Start Date</label>
                  <input 
                    type="date" 
                    id="startDate"
                    v-model="startDate"
                    class="border border-[#f28c3a] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#ff7f2a]"
                  />
                </div>

                <div class="flex flex-col">
                  <label for="endDate" class="text-[#f28c3a] mb-1 font-semibold">End Date</label>
                  <input 
                    type="date" 
                    id="endDate"
                    v-model="endDate"
                    class="border border-[#f28c3a] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#ff7f2a]"
                  />
                </div>
              </div>

            </span>
          </div>
        </div>

        <button @click="postDate" class="mt-8 mb-0 px-16 py-4 bg-[#f28c3a] text-white font-semibold rounded-xl shadow hover:bg-[#d95f00] transition text-lg" style="min-width:200px;">
          Next
        </button>
      </div>
    </div>
  </div>
</template>