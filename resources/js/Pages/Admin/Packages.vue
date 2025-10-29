<script setup>
import AdminIndex from './AdminIndex.vue'
import NewPackageModal from '@/Pages/Admin/components/NewPackageModal.vue'
import EditPackageModal from '@/Pages/Admin/components/EditPackageModal.vue'
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

defineOptions({ layout: AdminIndex })

const showModal = ref(false)
const showEditModal = ref(false)
const selectedPackageId = ref(null)
const packages = ref([])

const createNewPackage = () => {
    showModal.value = true
}

const handleSavePackage = (packageData) => {
    fetchPackages();
}

const openEditModal = (packageId) => {
    selectedPackageId.value = packageId;
    showEditModal.value = true;
}

const handlePackageUpdated = (updatedPackage) => {
    fetchPackages();
}

const fetchPackages = async () => {
    try {
        const response = await axios.get('/api/packages')
        packages.value = response.data.data
    } catch (error) {
        console.error('Error fetching packages:', error)
    }
}

const activePackages = computed(() => packages.value.filter(p => p.status === 'Active').length)
const inactivePackages = computed(() => packages.value.filter(p => p.status === 'Inactive').length)

onMounted(() => {
    fetchPackages()
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
    <div class="max-w-[1800px] mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Package Management</h1>
        <p class="text-gray-600">Create and manage tour packages</p>
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
              type="text"
              placeholder="Search packages..."
              class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
            />
          </div>

          <!-- Filters and Actions -->
          <div class="flex items-center gap-3 flex-wrap">
            <!-- Status Filter -->
            <div class="relative">
              <select class="appearance-none pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all cursor-pointer bg-white font-medium text-gray-700">
                <option>All Status</option>
                <option>Active</option>
                <option>Inactive</option>
              </select>
              <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </div>

            <!-- Filter Button -->
            <button class="p-3 border-2 border-gray-200 hover:border-[#1E71B8] rounded-xl transition-all hover:bg-[#1E71B8] hover:text-white group">
              <svg class="w-5 h-5 text-gray-700 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
              </svg>
            </button>

            <!-- Add New Package Button -->
            <button 
              @click="createNewPackage"
              class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
              Add New Package
            </button>
          </div>
        </div>
      </div>

      <!-- Table Card -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white">
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Package ID</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Package Name</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Destination</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Region</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Max Occupancy</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Booking Type</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Duration</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Status</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Base Price</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Kids Price</th>
                <th class="px-6 py-4 text-left text-sm font-semibold whitespace-nowrap">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr v-for="packageItem in packages" :key="packageItem.id" class="hover:bg-blue-50/50 transition-colors">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                  <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-semibold">
                    #{{ packageItem.id }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-900 whitespace-nowrap">
                  {{ packageItem.package_name }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                  <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    {{ packageItem.destination }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                  <span class="px-2.5 py-1 rounded-lg bg-purple-100 text-purple-700 font-medium">
                    {{ packageItem.region }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                  <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    {{ packageItem.capacity }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm whitespace-nowrap">
                  <span 
                    :class="{
                      'bg-blue-100 text-blue-700': !packageItem.joint_booking,
                      'bg-indigo-100 text-indigo-700': packageItem.joint_booking
                    }"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                  >
                    {{ packageItem.joint_booking ? 'Joint' : 'Exclusive' }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                  <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ packageItem.tour_duration }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm whitespace-nowrap">
                  <span 
                    :class="{
                      'bg-green-100 text-green-700': packageItem.status === 'Active',
                      'bg-gray-100 text-gray-700': packageItem.status === 'Inactive'
                    }"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                  >
                    {{ packageItem.status }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-900 whitespace-nowrap">
                  ₱{{ packageItem.pax_rate }}
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-900 whitespace-nowrap">
                  ₱{{ packageItem.kids_pax_rate }}
                </td>
                <td class="px-6 py-4 text-sm whitespace-nowrap">
                  <button 
                    @click="openEditModal(packageItem.id)"
                    class="p-2 hover:bg-[#1E71B8] hover:text-white rounded-lg transition-all group"
                    title="Edit"
                  >
                    <svg class="w-5 h-5 text-[#1E71B8] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
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
              Showing <span class="font-semibold">1</span> to <span class="font-semibold">{{ packages.length }}</span> of <span class="font-semibold">{{ packages.length }}</span> results
            </p>
            <div class="flex gap-2">
              <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                Previous
              </button>
              <button class="px-4 py-2 bg-[#1E71B8] text-white rounded-lg font-semibold">
                1
              </button>
              <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all">
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modals -->
    <NewPackageModal
      :show="showModal"
      @close="showModal = false"
      @save="handleSavePackage"
    />

    <EditPackageModal
      :show="showEditModal"
      :packageId="selectedPackageId"
      @close="showEditModal = false; selectedPackageId = null"
      @saved="handlePackageUpdated"
    />
  </div>
</template>