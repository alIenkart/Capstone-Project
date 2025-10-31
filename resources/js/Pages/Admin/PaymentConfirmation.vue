<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
    <div class="max-w-[1600px] mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Payment Management</h1>
        <p class="text-gray-600">Review and approve customer payment submissions</p>
      </div>

      <!-- Controls Section -->
      <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
          <!-- Search Bar -->
          <div class="relative flex-1 max-w-md">
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search by ID, customer name, entry, method..."
              class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
            />
            <button
              v-if="searchQuery"
              @click="searchQuery = ''"
              class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <!-- Filters -->
          <div class="flex items-center gap-3 flex-wrap">
            <!-- Status Filter -->
            <div class="relative">
              <select 
                v-model="statusFilter"
                class="appearance-none pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all cursor-pointer bg-white font-medium text-gray-700"
              >
                <option>All Status</option>
                <option>Approved</option>
                <option>Pending</option>
                <option>Rejected</option>
              </select>
              <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Card -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white">
                <th class="px-6 py-4 text-left text-sm font-semibold">Payment ID</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Booking ID</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Customer Name</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Payment Entry</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Payment Method</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr v-if="filteredPayments.length === 0">
                <td colspan="7" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center gap-3">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-gray-500">
                      <p class="text-lg font-semibold">No payments found</p>
                      <p class="text-sm">Try adjusting your search or filters</p>
                    </div>
                    <button 
                      v-if="hasActiveFilters"
                      @click="resetFilters"
                      class="mt-2 px-4 py-2 bg-[#1E71B8] text-white rounded-lg font-medium hover:bg-[#2a8bb5] transition-all"
                    >
                      Clear all filters
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-for="p in filteredPayments" :key="p.payment_id" class="hover:bg-blue-50/50 transition-colors">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                  <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-semibold">
                    #{{ p.id }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm">
                  <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 font-medium">
                    #{{ p.booking_id }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                  {{ p.booking?.customer_name || 'N/A' }}
                </td>
                <td class="px-6 py-4 text-sm">
                  <span class="inline-flex items-center gap-1.5 text-gray-700">
                    <svg class="w-5 h-5 text-[#1E71B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ p.payment_entry }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm">
                  <span 
                    :class="{
                      'bg-green-100 text-green-700': p.payment_status === 'Approved',
                      'bg-yellow-100 text-yellow-700': p.payment_status === 'Pending',
                      'bg-red-100 text-red-700': p.payment_status === 'Rejected',
                      'bg-gray-100 text-gray-700': !['Approved', 'Pending', 'Rejected'].includes(p.payment_status)
                    }"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                  >
                    {{ p.payment_status }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm">
                  <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-purple-100 text-purple-700 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    {{ p.payment_method }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm">
                  <button 
                    @click="openApprovalPaymentModal(p)"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white rounded-lg font-medium transition-all shadow hover:shadow-lg transform hover:-translate-y-0.5"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Review
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <p class="text-sm text-gray-700">
              Showing <span class="font-semibold">{{ filteredPayments.length > 0 ? 1 : 0 }}</span> to <span class="font-semibold">{{ filteredPayments.length }}</span> of <span class="font-semibold">{{ filteredPayments.length }}</span> results
            </p>
            <div class="flex gap-2">
              <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                Previous
              </button>
              <button class="px-4 py-2 bg-[#1E71B8] text-white rounded-lg font-semibold">
                1
              </button>
              <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Approval Payment Modal -->
    <ApprovalPaymentModal
      v-if="showApprovalPaymentModal"
      :payment="selectedPayment"
      @close="handleApprovalPaymentClose"
    />
  </div>
</template>

<script setup>
import AdminIndex from './AdminIndex.vue'
import { ref, onMounted, computed } from 'vue'
import { api } from '../../api/api'
import ApprovalPaymentModal from '@/Pages/Admin/components/ApprovalPaymentModal.vue'

defineOptions({ layout: AdminIndex })

const service = new api();
const payments = ref([])
const searchQuery = ref('')
const statusFilter = ref('All Status')

const fetchPayments = async () => {
    try {
        const response = await service.getPayments();
        payments.value = response.data
        console.log('Payments fetched:', payments.value)
    } catch (error) {
        console.error('Error fetching bookings:', error)
    }
}

onMounted(() => {
    fetchPayments()
})

const showApprovalPaymentModal = ref(false)
const selectedPayment = ref(null)

const openApprovalPaymentModal = (payment = null) => {
  selectedPayment.value = payment
  showApprovalPaymentModal.value = true
}

const handleApprovalPaymentClose = () => {
  showApprovalPaymentModal.value = false
  selectedPayment.value = null
  fetchPayments() // Refresh payments after modal closes
}

// Computed property for filtered payments
const filteredPayments = computed(() => {
  let result = payments.value

  // Apply search filter
  if (searchQuery.value.trim()) {
    const query = searchQuery.value.toLowerCase().trim()
    result = result.filter(p => {
      const paymentId = p.id?.toString().toLowerCase() || ''
      const bookingId = p.booking_id?.toString().toLowerCase() || ''
      const customerName = p.booking?.customer_name?.toLowerCase() || ''
      const paymentEntry = p.payment_entry?.toLowerCase() || ''
      const paymentMethod = p.payment_method?.toLowerCase() || ''
      
      return paymentId.includes(query) ||
             bookingId.includes(query) ||
             customerName.includes(query) ||
             paymentEntry.includes(query) ||
             paymentMethod.includes(query)
    })
  }

  // Apply status filter
  if (statusFilter.value !== 'All Status') {
    result = result.filter(p => p.payment_status === statusFilter.value)
  }

  return result
})

// Reset all filters
const resetFilters = () => {
  searchQuery.value = ''
  statusFilter.value = 'All Status'
}

// Check if any filters are active
const hasActiveFilters = computed(() => {
  return searchQuery.value.trim() !== '' || statusFilter.value !== 'All Status'
})
</script>