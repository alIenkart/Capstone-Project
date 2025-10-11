<script setup>
import LandingIndex from './LandingIndex.vue'
import { storeBooking } from '../../state/storeBooking'
import { computed, ref, onMounted, onBeforeUnmount, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { api } from '../../api/api';
defineOptions({ layout: LandingIndex })

const service = new api();
const emit = defineEmits(['next', 'back'])
const page = usePage();
const booking = storeBooking()
const id = computed(() => page.props.id);
const selectedPackage = ref({});
const pax = ref(1);
const kidsPax = ref(1);
const discountImages = ref([]);
const remarks = ref('');

// Duration in days based on booking dates (inclusive)
const durationDays = computed(() => {
  const start = booking.startDate
  const end = booking.endDate
  if (!start || !end) return 0
  // Parse YYYY-MM-DD safely in UTC to avoid timezone shifts
  const [sy, sm, sd] = String(start).split('-').map(Number)
  const [ey, em, ed] = String(end).split('-').map(Number)
  const startDateUtc = Date.UTC(sy, (sm || 1) - 1, sd || 1)
  const endDateUtc = Date.UTC(ey, (em || 1) - 1, ed || 1)
  const diffMs = endDateUtc - startDateUtc
  const days = Math.floor(diffMs / (1000 * 60 * 60 * 24)) + 1 // inclusive
  return days > 0 ? days : 0
})


const adultTotalAmount = computed(() => {
  const amount = selectedPackage.value.pax_rate || 0
  return amount * pax.value
})

const kidsTotalAmount = computed(() => {
  const amount = selectedPackage.value.kids_pax_rate || 0
  return amount * kidsPax.value
})

// Subtotal (Adults + Kids)
const totalAmount = computed(() => {
  return adultTotalAmount.value + kidsTotalAmount.value
})

// Apply a 20% discount (temporary static until discount logic is wired)
const discountRate = 0.20
const totalAmountWithDiscount = computed(() => {
  const subtotal = totalAmount.value
  const discountAmount = subtotal * discountRate
  return subtotal - discountAmount
})


function postPackage() {
  booking.setPackageId(id.value)
  booking.setAdultsQuantity(pax.value)
  booking.setKidsQuantity(kidsPax.value)
  booking.setAmount(totalAmount.value)
  booking.setTotalAmountWithDiscount(totalAmountWithDiscount.value)
  booking.setPackageDestination(selectedPackage.value.destination)
  booking.setDuration(durationDays.value)
  booking.setAdultRate(selectedPackage.value.pax_rate || 0)
  booking.setKidsRate(selectedPackage.value.kids_pax_rate || 0)
  booking.setAdultTotalAmount(adultTotalAmount.value)
  booking.setKidsTotalAmount(kidsTotalAmount.value)
  booking.setDiscountImages(discountImages.value)
  booking.setRemarks(remarks.value)
  emit('next')
}

// Parse itinerary string into day panels
const parseItineraryToDays = (itineraryString) => {
  if (!itineraryString || itineraryString.trim() === '') {
    return [{ id: 1, content: '' }];
  }
  
  // Try to split by "Day X:" pattern first
  const dayPattern = /Day\s+\d+:/gi;
  const dayMatches = [...itineraryString.matchAll(dayPattern)];
  
  if (dayMatches.length > 0) {
    const days = [];
    
    dayMatches.forEach((match, index) => {
      const startIndex = match.index;
      const endIndex = index < dayMatches.length - 1 ? dayMatches[index + 1].index : itineraryString.length;
      
      // Extract content between day markers
      const section = itineraryString.substring(startIndex, endIndex).trim();
      const lines = section.split('\n');
      const content = lines.slice(1).join('\n').trim(); // Skip the "Day X:" line
      
      days.push({
        id: index + 1,
        content: content
      });
    });
    
    return days;
  }
  
  // Fallback: try splitting by double newlines
  const daySections = itineraryString.split('\n\n').filter(section => section.trim() !== '');
  if (daySections.length > 1) {
    const days = daySections.map((section, index) => {
      // Remove "Day X:" prefix if it exists
      const content = section.replace(/^Day\s+\d+:\s*/i, '').trim();
      return {
        id: index + 1,
        content: content
      };
    });
    
    return days;
  }
  
  // If no structured days found, treat as single day
  return [{ id: 1, content: itineraryString.trim() }];
};

// Computed property to get parsed itinerary days
const itineraryDays = computed(() => {
  return parseItineraryToDays(selectedPackage.value.itinerary || '');
});

// Image upload functions
const handleImageUpload = (event) => {
  const files = Array.from(event.target.files);
  
  // Filter to only allow images and limit to 3 total
  const imageFiles = files.filter(file => file.type.startsWith('image/'));
  const remainingSlots = 3 - discountImages.value.length;
  const filesToAdd = imageFiles.slice(0, remainingSlots);
  
  filesToAdd.forEach(file => {
    const reader = new FileReader();
    reader.onload = (e) => {
      discountImages.value.push({
        id: Date.now() + Math.random(),
        file: file,
        preview: e.target.result,
        name: file.name
      });
    };
    reader.readAsDataURL(file);
  });
  
  // Clear the input
  event.target.value = '';
};

const removeImage = (imageId) => {
  discountImages.value = discountImages.value.filter(img => img.id !== imageId);
};

const triggerFileInput = () => {
  document.getElementById('discount-image-upload').click();
};

const fetchSelectedPackage = async () => {
  try {
    const response = await service.getPackage(id.value);
    selectedPackage.value = response.data.data;
  } catch (error) {
    console.error('Error fetching selectedPackage:', error);
  }
};

onMounted(() => {
  fetchSelectedPackage();
});

</script>
<template>
  <div class="w-full min-h-screen flex flex-col items-center bg-[#fcfcfc] py-8">
    <!-- Stepper at the top -->
    <div class="flex items-center gap-2 mb-16 mt-2 w-full max-w-5xl justify-center">
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] bg-[#008DDA] flex items-center justify-center">
          <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base">Availability</span>
      </div>
      <span class="w-16 h-0.5 bg-[#008DDA] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] flex items-center justify-center">
          <span class="w-2 h-2 rounded-full bg-[#008DDA]"></span>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base border-b-2 border-[#008DDA] pb-0.5">Reservation Details</span>
      </div>
      <span class="w-16 h-0.5 bg-[#008DDA] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] flex items-center justify-center"></span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base">Confirmation</span>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-row w-full max-w-6xl justify-center gap-8">
      <!-- Left Side: Package Selection -->
      <div class="flex-1">
        <div class="flex justify-start mb-4">
          <button @click="emit('back')" class="w-24 rounded-full py-2 font-bold text-lg transition bg-[#1E71B8] text-white hover:bg-[#73BE5D]">
            Back
          </button>
        </div>
        <div class="flex w-full mb-2">
          <div class="flex-1 font-semibold text-[#1E71B8]">Travellers</div>
          <div class="flex-1 font-semibold text-[#1E71B8] text-center">Rate</div>
          <div class="flex-1 font-semibold text-[#1E71B8] text-right">Quantity</div>
        </div>
        <p class="message">*Age around 13 and above</p>
        <div class="w-full flex items-center bg-[#1E71B8] rounded-xl px-6 py-5 mb-6">
          <div class="flex-1 text-white font-medium text-lg">Adults</div>
          <div class="flex-1 text-white font-medium text-lg text-center">₱ {{ selectedPackage.pax_rate }}</div>
          <div class="flex-1 flex items-center justify-end gap-2">
            <button @click="pax > 1 && pax--" class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">-</button>
            <input type="text" :value="pax" class="w-14 h-8 rounded-lg text-center border border-[#1E71B8] bg-white text-[#1E71B8] font-semibold" readonly>
            <button @click="pax++" class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">+</button>
          </div>
        </div>
        <p class="message">*Age around 2-12</p>
        <div class="w-full flex items-center bg-[#1E71B8] rounded-xl px-6 py-5 mb-6">
          <div class="flex-1 text-white font-medium text-lg">Kids</div>
          <div class="flex-1 text-white font-medium text-lg text-center">₱ {{ selectedPackage.kids_pax_rate }}</div>
          <div class="flex-1 flex items-center justify-end gap-2">
            <button @click="kidsPax > 1 && kidsPax--" class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">-</button>
            <input type="text" :value="kidsPax" class="w-14 h-8 rounded-lg text-center border border-[#1E71B8] bg-white text-[#1E71B8] font-semibold" readonly>
            <button @click="kidsPax++" class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">+</button>
          </div>
        </div>

        <!-- Itinerary Section -->
        <div class="mt-8">
          <div class="flex w-full mb-2">
            <div class="flex-1 font-semibold text-[#1E71B8]">Itinerary</div>
          </div>
          
          <!-- Day-based itinerary panels -->
          <div v-if="itineraryDays.length > 0" class="space-y-4">
            <div 
              v-for="day in itineraryDays" 
              :key="day.id"
              class="w-full rounded-xl border border-[#1E71B8] bg-white p-4"
            >
              <div class="flex items-center mb-3">
                <h3 class="text-[#1E71B8] font-semibold text-lg">DAY {{ day.id }}</h3>
              </div>
              <div class="text-[#000000] whitespace-pre-wrap pl-11">{{ day.content }}</div>
            </div>
          </div>
          
          <!-- Fallback for empty itinerary -->
          <div v-else class="w-full rounded-xl border border-[#000000] bg-white text-[#000000] p-4">
            <div class="text-gray-500 italic">No itinerary available</div>
          </div>
        </div>
      </div>
      
      <!-- Right Side: Additional Info and Summary Card -->
      <div class="w-full max-w-sm flex flex-col gap-4">
        <!-- Discount ID Image Uploader -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
          <div class="text-[#1E71B8] font-semibold text-sm mb-2">Discount ID Images</div>
          <div class="space-y-2">
            <!-- Image Preview Grid -->
            <div v-if="discountImages.length > 0" class="grid grid-cols-3 gap-2 mb-2">
              <div 
                v-for="image in discountImages" 
                :key="image.id"
                class="relative group"
              >
                <img 
                  :src="image.preview" 
                  :alt="image.name"
                  class="w-full h-16 object-cover rounded-lg border border-gray-300"
                />
                <button 
                  @click="removeImage(image.id)"
                  class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                >
                  ×
                </button>
              </div>
            </div>
            
            <!-- Upload Button -->
            <button 
              @click="triggerFileInput"
              :disabled="discountImages.length >= 3"
              class="w-full py-2 px-3 bg-[#1E71B8] bg-opacity-10 text-[#1E71B8] text-sm rounded-lg border border-[#1E71B8] border-dashed hover:bg-opacity-20 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <div class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>{{ discountImages.length >= 3 ? 'Max 3 images' : 'Add Image' }}</span>
              </div>
            </button>
            
            <!-- Hidden File Input -->
            <input 
              id="discount-image-upload"
              type="file" 
              multiple 
              accept="image/*"
              @change="handleImageUpload"
              class="hidden"
            />
          </div>
          <p class="text-gray-500 text-xs mt-2">* Maximum of 3 Discount ID Upload</p>
        </div>

        <!-- Remarks Section -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
          <div class="text-[#1E71B8] font-semibold text-sm mb-2">Remarks</div>
          <textarea 
            v-model="remarks"
            placeholder="*Extra baggage, include infants etc."
            class="w-full h-20 px-3 py-2 bg-gray-50 text-gray-800 placeholder-gray-500 rounded-lg border border-gray-300 resize-none focus:outline-none focus:ring-2 focus:ring-[#1E71B8] focus:border-[#1E71B8]"
          ></textarea>
        </div>

        <!-- Summary Card -->
        <div class="bg-[#1E71B8] rounded-xl p-8 flex flex-col justify-between min-h-[350px]">
          <div>
            <!-- Package Details -->
          <div class="font-bold text-white text-lg mb-2">{{selectedPackage.destination}}</div>
          <div class="text-white mb-4">
            <div>Tour Type: <span class="text-white">{{ booking.tourType }}</span></div>
          </div>
          <div class="text-white mb-4">
            <div>Duration: <span class="text-white">{{ durationDays }} Day<span v-if="durationDays !== 1">s</span></span></div>
          </div>
          <div class="text-white mb-4">
            <div>Starting Date: <span class="text-white">{{ booking.startDate }}</span></div>
          </div>
          <div class="text-white mb-4">
            <div class="mb-1">Travellers</div>
            <div class="flex justify-between">
              <span>Adult Rate ₱ {{ selectedPackage.pax_rate }} x ({{ pax }})</span>
              <span>₱ {{ adultTotalAmount }}</span>
            </div>
            <div class="flex justify-between">
              <span>Kids Rate ₱ {{ selectedPackage.kids_pax_rate }} x ({{ kidsPax }})</span>
              <span>₱ {{ kidsTotalAmount }}</span>
            </div>
            <div class="flex justify-between">
              <span>Discount ID</span>
              <span>{{selectedPackage.discounted_rate}}%</span>
            </div>
          </div>
          <hr class="border-[#73BE5D] my-4" />
          <div class="flex justify-between items-center font-bold text-white text-lg mt-4">
            <span>Total :</span>
              <span>₱ {{ totalAmountWithDiscount }}</span>
          </div>
        </div>
          <button @click=postPackage class="w-full rounded-full py-3 font-bold text-lg transition bg-[#73BE5D] text-white hover:bg-[#6aae56] mt-2">
            Proceed
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.message {
  color: #6B7899;
  font-size: 0.8rem;
}
</style>