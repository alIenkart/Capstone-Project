<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  type: {
    type: String,
    default: 'terms', // 'terms' or 'privacy'
    validator: (value) => ['terms', 'privacy'].includes(value)
  }
})

const emit = defineEmits(['close'])

const termsContent = [
  {
    title: "Booking Policy",
    content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut fermentum, turpis non facilisis egestas, nunc neque dapibus libero, a varius leo ante vitae purus."
  },
  {
    title: "Payment Terms",
    content: "Curabitur imperdiet nunc ac nibh finibus, sed interdum turpis aliquet. All payments must be made via the provided QRPh code after booking confirmation. Non-payment may result in cancellation."
  },
  {
    title: "Cancellation and Refunds",
    content: "Integer fringilla, orci at facilisis sagittis, erat magna vestibulum justo, nec finibus lorem orci vel purus. Refunds will only be issued for cancellations made 7 days prior to the scheduled date."
  },
  {
    title: "Changes and Rescheduling",
    content: "Sed at nisl magna. Aenean consequat finibus ipsum, sit amet ultricies erat fermentum vel. Requests for date changes must be made at least 5 days in advance."
  },
  {
    title: "Group and Joint Bookings",
    content: "Pellentesque convallis eros vitae ligula posuere, non suscipit libero fermentum. Group representatives are responsible for payment and coordination."
  },
  {
    title: "Travel Package Inclusions and Exclusions",
    content: "Fusce vitae lectus non lacus feugiat faucibus. Inclusions and exclusions are stated on the individual package details. Additional charges may apply for optional activities."
  },
  {
    title: "Liability and Safety",
    content: "Aliquam erat volutpat. We are not liable for any loss, injury, or inconvenience caused by force majeure events or customer negligence."
  },
  {
    title: "Communication",
    content: "Vivamus mattis tellus sit amet sapien tincidunt, nec consequat magna iaculis. Official communication will be sent via your registered email or the platform inbox."
  },
  {
    title: "Acceptance",
    content: "Ut quis gravida orci, in rutrum ipsum. By proceeding with a booking, you agree to these terms and conditions in full."
  }
]

const privacyContent = [
  {
    title: "Information We Collect",
    content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer porta erat a neque dignissim, vitae sagittis ligula fermentum.",
    subItems: [
      "Lorem name, lorem number, lorem email",
      "Lorem booking data",
      "Lorem payment records",
      "Uploaded lorem files"
    ]
  },
  {
    title: "How We Use Your Information",
    content: "Fusce facilisis metus vel lorem vestibulum, vitae ullamcorper justo pulvinar. Your information is used to:",
    subItems: [
      "Confirm lorem bookings",
      "Send lorem notifications",
      "Provide lorem support",
      "Improve lorem service"
    ]
  },
  {
    title: "Data Security",
    content: "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae. Integer vehicula lorem nec lectus porttitor bibendum. Data is secured via lorem encryptions and protocols."
  },
  {
    title: "Sharing of Information",
    content: "Lorem ipsum dolor sit amet, sed non magna ut sapien blandit vehicula. Your data may be shared with:",
    subItems: [
      "Authorized lorem personnel",
      "Lorem processors (e.g., QRPh platforms)",
      "Authorities if lorem required by law"
    ]
  }
]

const currentContent = computed(() => {
  return props.type === 'terms' ? termsContent : privacyContent
})

const modalTitle = computed(() => {
  return props.type === 'terms' ? 'Terms and Conditions' : 'Privacy Policy'
})

function closeModal() {
  emit('close')
}
</script>

<template>
  <div v-if="show" class="fixed inset-0 z-[9999] overflow-y-auto">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="closeModal"></div>
    
    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
      <div class="relative bg-white rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <!-- Header -->
        <div class="bg-[#1E71B8] text-white px-6 py-4 flex justify-between items-center">
          <h2 class="text-xl font-bold">{{ modalTitle }}</h2>
          <button @click="closeModal" class="text-white hover:text-gray-300 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <!-- Content -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
          <div class="space-y-6">
            <div v-for="(item, index) in currentContent" :key="index" class="border-b border-gray-200 pb-4 last:border-b-0">
              <h3 class="text-lg font-semibold text-[#1E71B8] mb-2">{{ index + 1 }}. {{ item.title }}</h3>
              <p class="text-gray-700 mb-3">{{ item.content }}</p>
              <ul v-if="item.subItems" class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                <li v-for="subItem in item.subItems" :key="subItem">{{ subItem }}</li>
              </ul>
            </div>
          </div>
        </div>
        
        <!-- Footer -->
        <div class="px-6 py-4 flex justify-center">
          <button 
            @click="closeModal"
            class="bg-[#1E71B8] hover:bg-[#008DDA] text-white px-6 py-2 rounded-lg font-semibold transition-colors"
          >
            Accept all & Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
