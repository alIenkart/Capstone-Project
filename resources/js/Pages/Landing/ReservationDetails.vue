<template>
  <div class="w-full min-h-screen flex flex-col items-center bg-[#fcfcfc] py-8">
    <div class="flex items-center gap-2 mb-16 mt-2 w-full max-w-5xl justify-center">
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] bg-[#008DDA] flex items-center justify-center">
          <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="8" />
          </svg>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base">Availability</span>
      </div>
      <span class="w-16 h-0.5 bg-[#008DDA] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] flex items-center justify-center">
          <span class="w-2 h-2 rounded-full bg-[#008DDA]"></span>
        </span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base border-b-2 border-[#008DDA] pb-0.5">
          Reservation Details
        </span>
      </div>
      <span class="w-16 h-0.5 bg-[#008DDA] mx-2"></span>
      <div class="flex items-center gap-1">
        <span class="w-4 h-4 rounded-full border-2 border-[#008DDA] flex items-center justify-center"></span>
        <span class="ml-1 text-[#008DDA] font-semibold text-base">Confirmation</span>
      </div>
    </div>

    <div class="flex flex-row w-full max-w-6xl justify-center gap-8">
      <div class="flex-1">
        <div class="flex justify-start mb-4">
          <button @click="emit('back')"
            class="w-24 rounded-full py-2 font-bold text-lg transition bg-[#1E71B8] text-white hover:bg-[#73BE5D]">
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
            <button @click="pax > 0 && pax--"
              class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">-</button>
            <input type="text" :value="pax"
              class="w-14 h-8 rounded-lg text-center border border-[#1E71B8] bg-white text-[#1E71B8] font-semibold"
              readonly>
            <button @click="pax++"
              class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">+</button>
          </div>
        </div>

        <p class="message">*Age around 2-12</p>
        <div class="w-full flex items-center bg-[#1E71B8] rounded-xl px-6 py-5 mb-6">
          <div class="flex-1 text-white font-medium text-lg">Kids</div>
          <div class="flex-1 text-white font-medium text-lg text-center">₱ {{ selectedPackage.kids_pax_rate }}</div>
          <div class="flex-1 flex items-center justify-end gap-2">
            <button @click="kidsPax > 0 && kidsPax--"
              class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">-</button>
            <input type="text" :value="kidsPax"
              class="w-14 h-8 rounded-lg text-center border border-[#1E71B8] bg-white text-[#1E71B8] font-semibold"
              readonly>
            <button @click="kidsPax++"
              class="w-8 h-8 rounded-full bg-white text-[#1E71B8] font-bold text-lg flex items-center justify-center border border-[#1E71B8] hover:bg-[#ffe5d0]">+</button>
          </div>
        </div>

        <div class="mt-10">
          <div class="flex w-full mb-6 items-center justify-between">
            <h2 class="text-2xl font-bold text-[#1E71B8] tracking-tight">Itinerary</h2>

            <div v-if="isExclusiveTour" class="flex items-center gap-3">
              <button @click="toggleCustomize"
                class="px-5 py-2.5 rounded-xl text-white font-medium transition-all duration-300" :class="isEditingItinerary
                  ? 'bg-[#73BE5D] hover:bg-[#5AA449]'
                  : 'bg-[#1E71B8] hover:bg-[#155E9C]'">
                {{ isEditingItinerary ? 'Save Customization' : 'Customize' }}
              </button>

              <div v-if="isEditingItinerary" class="relative group flex items-center gap-3">
                <button @click="addNewDay" :disabled="editableItinerary.length >= booking.getHowManyDays" class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-xl shadow-md
                         bg-[#1E71B8] text-white transition-all duration-200
                         hover:bg-[#155E9C] disabled:bg-gray-300 disabled:text-gray-700 disabled:cursor-not-allowed">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                  </svg>
                  Add Day
                </button>

                <div v-if="editableItinerary.length >= booking.getHowManyDays" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white
                         text-xs px-3 py-1.5 rounded-lg shadow-lg opacity-0 pointer-events-none
                         group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                  {{
                    booking.getHowManyDays === 0
                      ? 'Please select your start and end dates first.'
                      : 'You\'ve reached the maximum number of days allowed by your booking.'
                  }}
                </div>
              </div>
            </div>
          </div>

          <div v-if="displayItinerary.length === 0"
            class="w-full rounded-2xl border border-gray-200 bg-white p-6 text-center text-gray-500 italic shadow-sm">
            No itinerary available yet.
          </div>

          <div v-else class="grid gap-6">
            <div v-for="(day, index) in displayItinerary" :key="day.id"
              class="w-full rounded-2xl bg-gradient-to-br from-white to-[#f9fcff] border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300">
              <div
                class="px-6 py-4 border-b border-gray-100 bg-[#f8fbff] rounded-t-2xl flex justify-between items-center">
                <h3 class="text-lg font-semibold text-[#1E71B8] tracking-wide">Day {{ day.id }}</h3>
                <button v-if="isEditingItinerary" @click="removeDay(index)"
                  class="text-red-500 hover:text-red-600 text-sm font-semibold flex items-center gap-1 transition">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  Remove
                </button>
              </div>
              <div class="px-6 py-5 text-gray-700 leading-relaxed whitespace-pre-wrap text-[15px]">
                <template v-if="isEditingItinerary">
                  <textarea v-model="editableItinerary[index].content" rows="5"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1E71B8]"></textarea>
                </template>
                <template v-else>
                  {{ day.content }}
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="w-full max-w-sm flex flex-col gap-4">
        <div class="bg-white rounded-xl p-6 border border-gray-200">
          <div class="text-[#1E71B8] font-semibold text-sm mb-2">Discount ID Image</div>
          <div class="space-y-2">
            <div v-if="discountImages.length > 0" class="mb-2">
              <div v-for="image in discountImages" :key="image.id" class="relative group">
                <img :src="image.preview" :alt="image.name"
                  class="w-full h-28 object-cover rounded-lg border border-gray-300" />
                <button @click="removeImage(image.id)"
                  class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                  ×
                </button>
              </div>
            </div>
            <button @click="triggerFileInput" :disabled="discountImages.length >= 1"
              class="w-full py-2 px-3 bg-[#1E71B8] bg-opacity-10 text-[#1E71B8] text-sm rounded-lg border border-[#1E71B8] border-dashed hover:bg-opacity-20 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
              <div class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>{{ discountImages.length >= 1 ? 'Only 1 image allowed' : 'Upload ID' }}</span>
              </div>
            </button>
            <input id="discount-image-upload" type="file" accept="image/*" @change="handleImageUpload" class="hidden" />
          </div>
          <p class="text-gray-500 text-xs mt-2">* Only one valid Discount ID upload allowed</p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200">
          <div class="text-[#1E71B8] font-semibold text-sm mb-2">Remarks</div>
          <textarea v-model="remarks" placeholder="*Extra baggage, include infants etc."
            class="w-full h-20 px-3 py-2 bg-gray-50 text-gray-800 placeholder-gray-500 rounded-lg border border-gray-300 resize-none focus:outline-none focus:ring-2 focus:ring-[#1E71B8] focus:border-[#1E71B8]"></textarea>
        </div>

        <div class="bg-[#1E71B8] rounded-xl p-8 flex flex-col justify-between min-h-[350px]">
          <div>
            <div class="font-bold text-white text-lg mb-2">{{ selectedPackage.destination }}</div>
            <div class="text-white mb-4">
              <div>Tour Type: <span class="text-white">{{ booking.tourType }}</span></div>
            </div>
            <div class="text-white mb-4">
              <div>Duration: <span class="text-white">{{ durationDays }} Day<span
                    v-if="durationDays !== 1">s</span></span>
              </div>
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
            </div>
            <hr class="border-[#73BE5D] my-4" />
            <div class="flex justify-between items-center font-bold text-white text-lg mt-4">
              <span>Total :</span>
              <span>₱ {{ totalAmountWithDiscount }}</span>
            </div>
          </div>
          <button @click="postPackage" :disabled="(pax + kidsPax) === 0 || (isExclusiveTour && isEditingItinerary)"
            class="w-full rounded-full py-3 font-bold text-lg transition bg-[#73BE5D] text-white hover:bg-[#6aae56] mt-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
            Proceed
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import LandingIndex from './LandingIndex.vue'
import { storeBooking } from '../../state/storeBooking'
import { computed, ref, onMounted, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { api } from '../../api/api'
import { useToast } from 'vue-toastification'

defineOptions({ layout: LandingIndex })

const service = new api()
const toast = useToast()
const emit = defineEmits(['next', 'back'])
const page = usePage()
const booking = storeBooking()
const id = computed(() => page.props.id)
const selectedPackage = ref({})
const pax = ref(0)
const kidsPax = ref(0)
const discountImages = ref([])
const remarks = ref('')
const isEditingItinerary = ref(false)
const editableItinerary = ref([])

const durationDays = computed(() => booking.getHowManyDays)

const adultTotalAmount = computed(() => {
  const amount = selectedPackage.value.pax_rate || 0
  return amount * pax.value
})

const kidsTotalAmount = computed(() => {
  const amount = selectedPackage.value.kids_pax_rate || 0
  return amount * kidsPax.value
})

const totalAmount = computed(() => adultTotalAmount.value + kidsTotalAmount.value)
const discountRate = 0.2
const totalAmountWithDiscount = computed(() => {
  const subtotal = totalAmount.value
  const discountAmount = subtotal * discountRate
  return subtotal - discountAmount
})

const isExclusiveTour = computed(() =>
  booking.tourType?.toLowerCase() === 'exclusive'
)

const displayItinerary = computed(() => {
  return isEditingItinerary.value ? editableItinerary.value : booking.itinerary || []
})

const toggleCustomize = () => {
  if (!isExclusiveTour.value) return
  if (isEditingItinerary.value) {
    booking.customItinerary = editableItinerary.value
    toast.success('Customization saved successfully!')
    isEditingItinerary.value = false
  } else {
    editableItinerary.value = JSON.parse(JSON.stringify(booking.itinerary || []))
    isEditingItinerary.value = true
  }
}

const addNewDay = () => {
  const maxDays = booking.getHowManyDays
  if (editableItinerary.value.length < maxDays) {
    editableItinerary.value.push({
      id: editableItinerary.value.length + 1,
      content: ''
    })
  }
}

const removeDay = (index) => {
  if (editableItinerary.value.length > 1) {
    editableItinerary.value.splice(index, 1)
    editableItinerary.value.forEach((day, idx) => {
      day.id = idx + 1
    })
  } else {
    toast.warning('You must have at least one day in the itinerary.')
  }
}

const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (!file || !file.type.startsWith('image/')) {
    toast.error('Please upload a valid image file.')
    return
  }

  if (discountImages.value.length >= 1) {
    toast.warning('You can only upload one discount ID image.')
    event.target.value = ''
    return
  }

  const reader = new FileReader()
  reader.onload = (e) => {
    discountImages.value = [{
      id: Date.now(),
      file,
      preview: e.target.result,
      name: file.name
    }]
  }
  reader.readAsDataURL(file)
  event.target.value = ''
}

const removeImage = (imageId) => {
  discountImages.value = discountImages.value.filter((img) => img.id !== imageId)
}

const triggerFileInput = () => {
  document.getElementById('discount-image-upload').click()
}

const postPackage = () => {
  if (pax.value === 0 && kidsPax.value === 0) {
    toast.error('Please select at least one traveler before proceeding.')
    return
  }

  if (isExclusiveTour.value && isEditingItinerary.value) {
    toast.warning('Please save your itinerary customization before proceeding.')
    return
  }

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

  const finalItinerary = booking.customItinerary?.length
    ? booking.customItinerary
    : booking.itinerary || []
  booking.setItinerary(finalItinerary)

  emit('next')
}

const fetchSelectedPackage = async () => {
  try {
    const response = await service.getPackage(id.value)
    selectedPackage.value = response.data.data
  } catch (error) {
    console.error('Error fetching selectedPackage:', error)
  }
}

onMounted(() => {
  fetchSelectedPackage()
})
</script>

<style>
.message {
  color: #6B7899;
  font-size: 0.8rem;
}
</style>