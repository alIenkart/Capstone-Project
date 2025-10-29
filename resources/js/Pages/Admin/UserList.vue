<script setup>
import AdminIndex from './AdminIndex.vue'
import EditUserModal from './components/EditUserModal.vue'
import { api } from '../../api/api'
import { ref, onMounted, computed } from 'vue'

defineOptions({ layout: AdminIndex })

const service = new api();
const users = ref([])
const selectedUser = ref(null)
const showEditModal = ref(false)

const openUpdateEntryModal = (user) => {
  selectedUser.value = user
  showEditModal.value = true
}

const handleUserUpdated = async () => {
  await fetchUsers()  
  showEditModal.value = false
}

const fetchUsers = async () => {
    try {
        const response = await service.getUsers();
        users.value = response.data.data
        console.log('Users fetched successfully:', users.value)
    } catch (error) {
        console.error('Error fetching users:', error)
    }
}

const adminUsers = computed(() => users.value.filter(u => u.role === 'admin').length)
const customerUsers = computed(() => users.value.filter(u => u.role === 'customer').length)
const verifiedUsers = computed(() => users.value.filter(u => u.email_verified_at).length)

onMounted(() => {
    fetchUsers()
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
    <div class="max-w-[1600px] mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">User Management</h1>
        <p class="text-gray-600">Manage system users and their permissions</p>
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
              placeholder="Search users..."
              class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
            />
          </div>

          <!-- Filters and Actions -->
          <div class="flex items-center gap-3 flex-wrap">
            <!-- Role Filter -->
            <div class="relative">
              <select class="appearance-none pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all cursor-pointer bg-white font-medium text-gray-700">
                <option>All Roles</option>
                <option>Admin</option>
                <option>Customer</option>
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

            <!-- Add New User Button -->
            <button 
              class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
              Add New User
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
                <th class="px-6 py-4 text-left text-sm font-semibold">User ID</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Customer Name</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Contact Number</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Role</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Email Status</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr v-for="user in users" :key="user.id" class="hover:bg-blue-50/50 transition-colors">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                  <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-semibold">
                    #{{ user.id }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                  <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#1E71B8] to-[#2a8bb5] flex items-center justify-center text-white font-semibold text-xs">
                      {{ user.first_name.charAt(0) }}{{ user.last_name.charAt(0) }}
                    </div>
                    {{ user.first_name }} {{ user.last_name }}
                  </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                  <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ user.email }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                  <span v-if="user.phone_number" class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ user.phone_number }}
                  </span>
                  <span v-else class="text-gray-400 italic">N/A</span>
                </td>
                <td class="px-6 py-4 text-sm">
                  <span 
                    :class="{
                      'bg-purple-100 text-purple-700': user.role === 'admin',
                      'bg-blue-100 text-blue-700': user.role === 'customer'
                    }"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize"
                  >
                    {{ user.role }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm">
                  <span 
                    :class="{
                      'bg-green-100 text-green-700': user.email_verified_at,
                      'bg-orange-100 text-orange-700': !user.email_verified_at
                    }"
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold"
                  >
                    <svg v-if="user.email_verified_at" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ user.email_verified_at ? 'Verified' : 'Not Verified' }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm">
                  <button 
                    @click="openUpdateEntryModal(user)"
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
              Showing <span class="font-semibold">1</span> to <span class="font-semibold">{{ users.length }}</span> of <span class="font-semibold">{{ users.length }}</span> results
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

    <!-- Edit User Modal -->
    <EditUserModal
      v-if="showEditModal"
      :user="selectedUser"
      :show="showEditModal"
      @updated="handleUserUpdated"
      @close="showEditModal = false"
    />
  </div>
</template>