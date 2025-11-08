<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
    <div class="max-w-[1600px] mx-auto">
      <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
          <div class="relative flex-1 max-w-md">
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
              stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input v-model="searchQuery" type="text" placeholder="Search users..."
              class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all" />
          </div>

          <div class="flex items-center gap-3 flex-wrap">
            <div class="relative" data-filter-container>
              <button @click="handleFilterClick('role')"
                class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 min-w-[180px]">
                <span class="font-semibold text-gray-800">
                  {{ selectedRole === '' ? 'All Roles' : selectedRole }}
                </span>
                <svg
                  :class="['w-5 h-5 text-blue-600 transition-transform duration-300', isRoleFilterOpen ? 'rotate-180' : '']"
                  fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div v-if="isRoleFilterOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden">
                <div v-for="option in roleOptions" :key="option" @click="handleRoleSelect(option)" :class="[
                  'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                  selectedRole === option ? 'bg-blue-50 border-l-4 border-l-blue-500' : ''
                ]">
                  <span :class="['font-medium', selectedRole === option ? 'text-blue-700' : 'text-gray-700']">
                    {{ option === '' ? 'All Roles' : option }}
                  </span>
                  <svg v-if="selectedRole === option" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="relative" data-filter-container>
              <button @click="handleFilterClick('emailStatus')"
                class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 min-w-[180px]">
                <span class="font-semibold text-gray-800">
                  {{ selectedEmailStatus === '' ? 'All Status' : selectedEmailStatus === 'verified' ? 'Verified' : 'Not Verified' }}
                </span>
                <svg
                  :class="['w-5 h-5 text-blue-600 transition-transform duration-300', isEmailStatusFilterOpen ? 'rotate-180' : '']"
                  fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div v-if="isEmailStatusFilterOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden">
                <div v-for="option in emailStatusOptions" :key="option" @click="handleEmailStatusSelect(option)" :class="[
                  'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                  selectedEmailStatus === option ? 'bg-blue-50 border-l-4 border-l-blue-500' : ''
                ]">
                  <span :class="['font-medium', selectedEmailStatus === option ? 'text-blue-700' : 'text-gray-700']">
                    {{ option === '' ? 'All Status' : option === 'verified' ? 'Verified' : 'Not Verified' }}
                  </span>
                  <svg v-if="selectedEmailStatus === option" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
              </div>
            </div>

            <button
              class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Add New User
            </button>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div v-if="filteredUsers.length > 0" class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white">
                <th class="px-6 py-4 text-center text-sm font-semibold">User ID</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Customer Name</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Email</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Contact Number</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Role</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Email Status</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr v-for="user in paginatedUsers" :key="user.id" class="hover:bg-blue-50/50 transition-colors">
                <td class="px-6 py-4 text-sm font-medium text-gray-900 text-center">
                  <span
                    class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-semibold">
                    #{{ user.id }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-700 text-center">
                  <div class="flex items-center justify-center gap-2">
                    {{ user.first_name }} {{ user.last_name }}
                  </div>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-700 text-center">
                  <span class="inline-flex items-center gap-1.5">
                    {{ user.email }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-700 text-center">
                  <span v-if="user.phone_number" class="inline-flex items-center gap-1.5">
                    {{ user.phone_number }}
                  </span>
                  <span v-else class="text-gray-400 italic">N/A</span>
                </td>
                <td class="px-6 py-4 text-sm text-center">
                  <span :class="{
                    'bg-purple-100 text-purple-700': user.role === 'Admin',
                    'bg-blue-100 text-blue-700': user.role === 'Customer'
                  }" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize">
                    {{ user.role }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-center">
                  <span :class="{
                    'bg-green-100 text-green-700': user.email_verified_at,
                    'bg-orange-100 text-orange-700': !user.email_verified_at
                  }" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold">
                    <svg v-if="user.email_verified_at" class="w-4 h-4" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ user.email_verified_at ? 'Verified' : 'Not Verified' }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-center">
                  <button @click="openUpdateEntryModal(user)"
                    class="p-2 hover:bg-[#1E71B8] hover:text-white rounded-lg transition-all group" title="Edit">
                    <svg class="w-5 h-5 text-[#1E71B8] group-hover:text-white transition-colors" fill="none"
                      stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-else class="py-16 text-center">
          <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          <h3 class="text-lg font-semibold text-gray-700 mb-2">No users found</h3>
          <p class="text-gray-500">Try adjusting your search or filter criteria</p>
          <button v-if="hasActiveFilters" @click="clearFilters"
            class="mt-4 px-6 py-2 bg-[#1E71B8] text-white rounded-lg hover:bg-[#2a8bb5] transition-all">
            Clear All Filters
          </button>
        </div>

        <div v-if="filteredUsers.length > 0" class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <p class="text-sm text-gray-700">
              Showing <span class="font-semibold">{{ startIndex + 1 }}</span> to <span class="font-semibold">{{ endIndex }}</span> of <span class="font-semibold">{{ filteredUsers.length }}</span> results
            </p>
            <div class="flex gap-2">
              <button @click="previousPage" :disabled="currentPage === 1"
                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                Previous
              </button>
              <button v-for="page in visiblePages" :key="page" @click="currentPage = page" :class="[
                'px-4 py-2 rounded-lg font-semibold transition-all',
                currentPage === page
                  ? 'bg-[#1E71B8] text-white'
                  : 'border-2 border-gray-200 hover:bg-gray-100'
              ]">
                {{ page }}
              </button>
              <button @click="nextPage" :disabled="currentPage === totalPages"
                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <EditUserModal v-if="showEditModal" :user="selectedUser" :show="showEditModal" @updated="handleUserUpdated"
      @close="showEditModal = false" />
  </div>
</template>

<script setup>
import AdminIndex from './AdminIndex.vue'
import EditUserModal from './components/EditUserModal.vue'
import { api } from '../../api/api'
import { ref, onMounted, computed, watch, onBeforeUnmount } from 'vue'

defineOptions({ layout: AdminIndex })

const service = new api()
const users = ref([])
const selectedUser = ref(null)
const showEditModal = ref(false)

const searchQuery = ref('')
const selectedRole = ref('')
const selectedEmailStatus = ref('')

const isRoleFilterOpen = ref(false)
const isEmailStatusFilterOpen = ref(false)

const currentPage = ref(1)
const itemsPerPage = ref(10)

const roleOptions = ['', 'Admin', 'Customer']
const emailStatusOptions = ['', 'verified', 'not_verified']

const closeAllFilters = () => {
  isRoleFilterOpen.value = false
  isEmailStatusFilterOpen.value = false
}

const handleFilterClick = (filterType) => {
  if (filterType === 'role') {
    isRoleFilterOpen.value = !isRoleFilterOpen.value
    isEmailStatusFilterOpen.value = false
  } else if (filterType === 'emailStatus') {
    isRoleFilterOpen.value = false
    isEmailStatusFilterOpen.value = !isEmailStatusFilterOpen.value
  }
}

const handleRoleSelect = (option) => {
  selectedRole.value = option
  closeAllFilters()
}

const handleEmailStatusSelect = (option) => {
  selectedEmailStatus.value = option
  closeAllFilters()
}

const hasActiveFilters = computed(() => {
  return searchQuery.value !== '' || selectedRole.value !== '' || selectedEmailStatus.value !== ''
})

const filteredUsers = computed(() => {
  let filtered = users.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(user => {
      const fullName = `${user.first_name} ${user.last_name}`.toLowerCase()
      const email = user.email.toLowerCase()
      const phone = user.phone_number?.toLowerCase() || ''
      const id = user.id.toString()

      return fullName.includes(query) ||
        email.includes(query) ||
        phone.includes(query) ||
        id.includes(query)
    })
  }

  if (selectedRole.value) {
    filtered = filtered.filter(user => user.role === selectedRole.value)
  }

  if (selectedEmailStatus.value) {
    if (selectedEmailStatus.value === 'verified') {
      filtered = filtered.filter(user => user.email_verified_at !== null)
    } else if (selectedEmailStatus.value === 'not_verified') {
      filtered = filtered.filter(user => user.email_verified_at === null)
    }
  }

  return filtered
})

const totalPages = computed(() => {
  return Math.ceil(filteredUsers.value.length / itemsPerPage.value)
})

const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredUsers.value.slice(start, end)
})

const startIndex = computed(() => {
  return (currentPage.value - 1) * itemsPerPage.value
})

const endIndex = computed(() => {
  return Math.min(currentPage.value * itemsPerPage.value, filteredUsers.value.length)
})

const visiblePages = computed(() => {
  const pages = []
  const maxVisible = 5
  let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2))
  let end = Math.min(totalPages.value, start + maxVisible - 1)

  if (end - start + 1 < maxVisible) {
    start = Math.max(1, end - maxVisible + 1)
  }

  for (let i = start; i <= end; i++) {
    pages.push(i)
  }

  return pages
})

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
    const response = await service.getUsers()
    users.value = response.data.data
  } catch (error) {
    console.error('Error fetching users:', error)
  }
}

const clearFilters = () => {
  searchQuery.value = ''
  selectedRole.value = ''
  selectedEmailStatus.value = ''
  currentPage.value = 1
}

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
  }
}

const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    closeAllFilters()
  }
}

watch([searchQuery, selectedRole, selectedEmailStatus], () => {
  currentPage.value = 1
})

onMounted(() => {
  fetchUsers()
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>