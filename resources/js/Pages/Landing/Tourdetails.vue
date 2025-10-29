<script setup>
import LandingIndex from './LandingIndex.vue'
import { computed, ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { api } from '../../api/api';
import { Link } from '@inertiajs/vue3'
import { storeBooking } from '@/state/storeBooking';
import { cloneDeep } from 'lodash';

defineOptions({ layout: LandingIndex })

const booking = storeBooking();
const service = new api();
const page = usePage();
const id = computed(() => page.props.id);

const selectedPackage = ref({});
const packages = ref([])
const activeTab = ref('terms');

// Add this computed property to parse itinerary into days
const parsedItinerary = computed(() => {
  if (!selectedPackage.value.itinerary) {
    return [];
  }
  
  const itineraryString = selectedPackage.value.itinerary;
  
  // Try to split by "Day X:" pattern first
  const dayPattern = /Day\s+\d+:/gi;
  const dayMatches = [...itineraryString.matchAll(dayPattern)];
  
  if (dayMatches.length > 0) {
    const days = [];
    let lastIndex = 0;
    
    dayMatches.forEach((match, index) => {
      const startIndex = match.index;
      const endIndex = index < dayMatches.length - 1 ? dayMatches[index + 1].index : itineraryString.length;
      
      // Extract content between day markers
      const section = itineraryString.substring(startIndex, endIndex).trim();
      const lines = section.split('\n');
      const content = lines.slice(1).join('\n').trim(); // Skip the "Day X:" line
      
      days.push({
        dayNumber: index + 1,
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
        dayNumber: index + 1,
        content: content
      };
    });
    
    return days;
  }
  
  // If no structured days found, treat as single day
  return [{
    dayNumber: 1,
    content: itineraryString.trim()
  }];
});

// Add computed property to parse terms and conditions into numbered sections
const parsedTerms = computed(() => {
  if (!selectedPackage.value.terms_condition) {
    return [];
  }
  
  const termsString = selectedPackage.value.terms_condition;
  
  // Split by line breaks and filter out empty lines
  const lines = termsString.split('\n').filter(line => line.trim() !== '');
  
  const terms = [];
  let currentTerm = null;
  
  lines.forEach((line) => {
    const trimmedLine = line.trim();
    
    // Check if line starts with a number followed by a period or dot
    const numberMatch = trimmedLine.match(/^(\d+)\.?\s*(.*)$/);
    
    if (numberMatch) {
      // If we have a previous term, save it
      if (currentTerm) {
        terms.push(currentTerm);
      }
      
      // Start a new term
      const number = parseInt(numberMatch[1]);
      const title = numberMatch[2].trim();
      
      currentTerm = {
        number: number,
        title: title,
        content: ''
      };
    } else if (currentTerm) {
      // This line belongs to the current term
      if (currentTerm.content) {
        currentTerm.content += '\n' + trimmedLine;
      } else {
        currentTerm.content = trimmedLine;
      }
    } else {
      // This line doesn't have a number and no current term, treat as standalone
      terms.push({
        number: terms.length + 1,
        title: '',
        content: trimmedLine
      });
    }
  });
  
  // Don't forget to add the last term
  if (currentTerm) {
    terms.push(currentTerm);
  }
  
  return terms;
});

// Add computed property to parse exclusions into numbered sections
const parsedExclusions = computed(() => {
  if (!selectedPackage.value.exclusions) {
    return [];
  }
  
  const exclusionsString = selectedPackage.value.exclusions;
  
  // Split by line breaks and filter out empty lines
  const lines = exclusionsString.split('\n').filter(line => line.trim() !== '');
  
  const exclusions = [];
  let currentExclusion = null;
  
  lines.forEach((line) => {
    const trimmedLine = line.trim();
    
    // Check if line starts with a number followed by a period or dot
    const numberMatch = trimmedLine.match(/^(\d+)\.?\s*(.*)$/);
    
    if (numberMatch) {
      // If we have a previous exclusion, save it
      if (currentExclusion) {
        exclusions.push(currentExclusion);
      }
      
      // Start a new exclusion
      const number = parseInt(numberMatch[1]);
      const title = numberMatch[2].trim();
      
      currentExclusion = {
        number: number,
        title: title,
        content: ''
      };
    } else if (currentExclusion) {
      // This line belongs to the current exclusion
      if (currentExclusion.content) {
        currentExclusion.content += '\n' + trimmedLine;
      } else {
        currentExclusion.content = trimmedLine;
      }
    } else {
      // This line doesn't have a number and no current exclusion, treat as standalone
      exclusions.push({
        number: exclusions.length + 1,
        title: '',
        content: trimmedLine
      });
    }
  });
  
  // Don't forget to add the last exclusion
  if (currentExclusion) {
    exclusions.push(currentExclusion);
  }
  
  return exclusions;
});

const fetchSelectedPackage = async () => {
  try {
    const response = await service.getPackage(id.value);
    selectedPackage.value = response.data.data;
    const packageSelected = cloneDeep(selectedPackage.value)
    booking.setPackage(packageSelected)
  } catch (error) {
    console.error('Error fetching selectedPackage:', error);
  }
};

const fetchPackages = async () => {
    try {
        const response = await service.getPackages();
        packages.value = response.data.data
    } catch (error) {
        console.error('Error fetching packages:', error)
    }
}

function setTab(tab) {
  activeTab.value = tab;
}

const relatedTrips = computed(() => {
  if (!packages.value.length || !selectedPackage.value?.id) {
    return []
  }

  const otherPackages = packages.value.filter(
    pkg => pkg.id !== selectedPackage.value.id
  )

  return otherPackages.sort(() => 0.5 - Math.random()).slice(0, 2)
})

onMounted(() => {
  fetchSelectedPackage();
  fetchPackages();
});
</script>

<template>
  <div class="bg-[#fcfcfc] min-h-screen w-full flex flex-col items-center">
    <!-- Main Container -->
    <div class="w-full max-w-[1400px] px-2 md:px-8 py-8 flex flex-col">
      <!-- Tour Title -->
      <h2 class="text-2xl font-bold text-[#1E71B8] mb-2">
        {{ selectedPackage.destination || 'Loading destination...' }}
      </h2>
      <hr class="border-[#1E71B8] border-t-2 w-40 md:w-80 mb-6" />

      <!-- Main Content Row -->
      <div class="flex flex-col lg:flex-row gap-8 w-full">
        <!-- Left Side: Main Image, Description, Tabs, Terms -->
        <div class="flex-1 min-w-0 max-w-full">
          <!-- Main Image -->
          <div class="rounded-2xl overflow-hidden mb-6 bg-gray-200 flex items-center justify-center w-full">
            <img 
              :src="'/storage/' + selectedPackage.image_path" 
              :alt="selectedPackage.destination" 
              class="w-full h-auto object-contain"
            />
          </div>
          <!-- Description -->
          <h3 class="font-bold text-xl mb-2 text-[#222]">Description</h3>
          <p class="text-base text-gray-800 mb-4">
            {{ selectedPackage.description || 'Loading description...' }}
          </p>
          <!-- Tabs -->
          <div class="tabs-row mb-4">
            <button class="tab-btn"
              :class="{ 'tab-btn-active': activeTab === 'itinerary' }"
              @click="setTab('itinerary')">
              Itinerary
            </button>
            <button class="tab-btn"
              :class="{ 'tab-btn-active': activeTab === 'terms' }"
              @click="setTab('terms')">
              Terms & Conditions
            </button>
            <button class="tab-btn"
              :class="{ 'tab-btn-active': activeTab === 'exclusions' }"
              @click="setTab('exclusions')">
              Exclusions
            </button>
          </div>

          <!-- Itinerary Content -->
          <div v-if="activeTab === 'itinerary'" class="mb-8">
            <h3 class="font-bold text-[#1E71B8] mb-2">Itinerary</h3>
            <div class="text-base text-gray-800">
              <!-- Display each day separately -->
              <div v-for="day in parsedItinerary" :key="day.dayNumber" class="mb-6 p-4 bg-gray-50 rounded-lg border-l-4 border-[#1E71B8]">
                <h4 class="font-semibold text-lg text-[#1E71B8] mb-2">Day {{ day.dayNumber }}</h4>
                <p class="whitespace-pre-line">{{ day.content }}</p>
              </div>
              
              <!-- Fallback if no days are parsed -->
              <div v-if="parsedItinerary.length === 0" class="p-4 bg-gray-50 rounded-lg">
                <p>{{ selectedPackage.itinerary }}</p>
              </div>
            </div>
          </div>

          <!-- Terms & Conditions Content -->
          <div v-if="activeTab === 'terms'" class="mb-8">
            <h3 class="font-bold text-[#1E71B8] mb-2">Terms & Conditions</h3>
            <div class="text-base text-gray-800">
              <p class="font-bold mb-4">
                These Terms and Conditions govern the use of services provided by Traveller Laguna. By confirming booking with our agency, customers must consider the terms outlined below.
              </p>
              
              <!-- Numbered Terms and Conditions -->
              <div class="space-y-4">
                <div v-for="term in parsedTerms" :key="term.number" class="flex items-start gap-3">
                  <span class="flex-shrink-0 w-6 h-6 bg-[#1E71B8] text-white rounded-full flex items-center justify-center text-sm font-semibold">
                    {{ term.number }}
                  </span>
                  <div class="flex-1">
                    <h4 v-if="term.title" class="font-semibold text-gray-800 mb-1">{{ term.title }}</h4>
                    <p class="text-gray-700 whitespace-pre-line">{{ term.content }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Exclusions Content -->
          <div v-if="activeTab === 'exclusions'" class="mb-8">
            <h3 class="font-bold text-[#1E71B8] mb-2">Exclusions</h3>
            <div class="text-base text-gray-800">
              <!-- Numbered Exclusions -->
              <div class="space-y-4">
                <div v-for="exclusion in parsedExclusions" :key="exclusion.number" class="flex items-start gap-3">
                  <span class="flex-shrink-0 w-6 h-6 bg-[#1E71B8] text-white rounded-full flex items-center justify-center text-sm font-semibold">
                    {{ exclusion.number }}
                  </span>
                  <div class="flex-1">
                    <h4 v-if="exclusion.title" class="font-semibold text-gray-800 mb-1">{{ exclusion.title }}</h4>
                    <p class="text-gray-700 whitespace-pre-line">{{ exclusion.content }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Right Side: Booking Card + Related Trips -->
        <div class="flex flex-col gap-8 w-full lg:w-[320px] xl:w-[350px] 2xl:w-[400px] min-w-[220px] max-w-[400px]">
          <!-- Booking Card -->
          <div
            class="rounded-2xl p-6 text-white shadow"
            style="background:#1E71B8;"
          >
            <div class="flex flex-col gap-2">
              <div class="flex justify-between items-start">
                <div>
                  <span class="font-bold text-xl">From</span><br>
                  <span class="currency-badge" aria-hidden="true">₱</span>
                  <span class="font-semibold text-lg"> {{ selectedPackage.pax_rate }} / per pax</span>
                </div>
                <span
                  class="bg-[#73BE5D] px-4 py-5 rounded-lg text-white font-bold text-right text-xl text-base leading-tight"
                  style="display:inline-block; "
                >
                  <span class="text-lg font-bold">{{ selectedPackage.tour_duration }} Days</span>
                </span>
              </div>
              <hr class="border-[#73BE5D] my-4" />
              <Link
                  v-if="selectedPackage.id"
  :href="route('process-booking', selectedPackage.id)"
                class="w-full rounded-xl py-3 font-bold text-lg transition text-center"
                style="background:#73BE5D; color:white;"
              >
                BOOK NOW!
              </Link>
            </div>
          </div>

          <!-- Related Trips (a bit wider) -->
          <div class="related-trip" v-for="pkg in relatedTrips" :key="pkg.id">
            <div class="font-bold text-lg mb-2 text-[#222] text-center">Related Trips</div>
            <div class="flex flex-col gap-6">
              <div class="flex flex-col items-center bg-white rounded-xl shadow p-4 w-full max-w-[200px] mx-auto">
                <div class="w-full h-full bg-gray-200 rounded-xl mb-2 flex items-center justify-center object-cover overflow-hidden">
                  <img :src="'/storage/' + pkg.image_path" :alt="pkg.destination" />
                </div>
                <div class="font-semibold text-[#1E71B8] w-full text-left">₱ {{ pkg.pax_rate }}</div>
                <div class="text-[#1E71B8] flex items-center gap-1 w-full justify-start text-left">
                  <svg width="16" height="16" fill="none" stroke="#1E71B8" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                  {{ pkg.destination }}
                </div>
                <div class="text-[#1E71B8] flex items-center gap-1 w-full justify-start text-left">
                  <svg width="16" height="16" fill="none" stroke="#1E71B8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                  {{ pkg.tour_duration }} Days
                </div>
                <Link :href="route('tourdetails', { id: pkg.id })"
                  class="mt-2 px-4 py-2 border border-[#1E71B8] text-[#1E71B8] rounded-full font-semibold hover:bg-[#1E71B8] hover:text-white transition text-center block">
                  View Details
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<style scoped>
.tabs-row {
  display: flex;
  gap: 8px;
}
.tab-btn {
  flex: 1;
  background: #1E71B8;
  color: #fff;
  font-weight: 600;
  padding: 0.5rem 0;
  border: 2px solid #1E71B8;
  border-radius: 0;
  transition: background 0.2s, color 0.2s;
}
.currency-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  color: #fff;
  font-size: 1.2rem;
}
.tab-btn:first-child {
  border-radius: 8px 0 0 8px;
}
.tab-btn:last-child {
  border-radius: 0 8px 8px 0;
}
.tab-btn:hover,
.tab-btn.tab-btn-active {
  background: #73BE5D;
  border: 2px solid #73BE5D;
  color: #fff;
}
@media (max-width: 1024px) {
  .tabs-row {
    flex-direction: column;
  }
  .tab-btn:first-child,
  .tab-btn:last-child {
    border-radius: 8px;
  }
}
</style>