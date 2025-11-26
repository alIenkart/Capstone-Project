<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
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
                  {{ selectedRole === "" ? "All Roles" : selectedRole }}
                </span>
                <svg :class="[
                  'w-5 h-5 text-blue-600 transition-transform duration-300',
                  isRoleFilterOpen ? 'rotate-180' : '',
                ]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div v-if="isRoleFilterOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden">
                <div v-for="option in roleOptions" :key="option" @click="handleRoleSelect(option)" :class="[
                  'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                  selectedRole === option
                    ? 'bg-blue-50 border-l-4 border-l-blue-500'
                    : '',
                ]">
                  <span :class="[
                    'font-medium',
                    selectedRole === option
                      ? 'text-blue-700'
                      : 'text-gray-700',
                  ]">
                    {{ option === "" ? "All Roles" : option }}
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
                  {{
                    selectedEmailStatus === ""
                      ? "All Status"
                      : selectedEmailStatus === "verified"
                        ? "Verified"
                        : "Not Verified"
                  }}
                </span>
                <svg :class="[
                  'w-5 h-5 text-blue-600 transition-transform duration-300',
                  isEmailStatusFilterOpen ? 'rotate-180' : '',
                ]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div v-if="isEmailStatusFilterOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden">
                <div v-for="option in emailStatusOptions" :key="option" @click="handleEmailStatusSelect(option)" :class="[
                  'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                  selectedEmailStatus === option
                    ? 'bg-blue-50 border-l-4 border-l-blue-500'
                    : '',
                ]">
                  <span :class="[
                    'font-medium',
                    selectedEmailStatus === option
                      ? 'text-blue-700'
                      : 'text-gray-700',
                  ]">
                    {{
                      option === ""
                        ? "All Status"
                        : option === "verified"
                          ? "Verified"
                          : "Not Verified"
                    }}
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

            <button @click="showAddModal = true"
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
                    'bg-purple-100 text-purple-700': user.role === 'Admin' || user.role === 'admin',
                    'bg-blue-100 text-blue-700' : user.role === 'Customer' || user.role === 'customer',
                  }" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize">
                    {{ user.role }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-center">
                  <span :class="{
                    'bg-green-100 text-green-700': user.email_verified_at,
                    'bg-orange-100 text-orange-700': !user.email_verified_at,
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
                    {{ user.email_verified_at ? "Verified" : "Not Verified" }}
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
              Showing <span class="font-semibold">{{ startIndex + 1 }}</span> to
              <span class="font-semibold">{{ endIndex }}</span> of
              <span class="font-semibold">{{ filteredUsers.length }}</span>
              results
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
                  : 'border-2 border-gray-200 hover:bg-gray-100',
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

    <div v-if="showAddModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-2 sm:p-4">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
        <div
          class="sticky top-0 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] px-4 sm:px-6 lg:px-8 py-4 sm:py-6 flex items-center justify-between gap-4">
          <div class="min-w-0 flex-1">
            <h2 class="text-lg sm:text-2xl font-bold text-white truncate">Add New User</h2>
            <p class="text-blue-100 text-xs sm:text-sm mt-1 hidden sm:block">Create a new user account</p>
          </div>
          <button @click="showAddModal = false"
            class="text-white hover:bg-white/20 p-2 rounded-lg transition-all flex-shrink-0">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">
          <div>
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Email Address</label>
            <div class="relative">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="absolute left-3 top-3.5 w-4 sm:w-5 h-4 sm:h-5 text-gray-500">
                <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                <path
                  d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
              </svg>
              <input v-model="formData.email" type="email" placeholder="john@example.com" :class="{
                'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-200': errors.email,
                'border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200': !errors.email
              }"
                class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-2.5 text-sm border-2 rounded-lg focus:outline-none transition-all" />
            </div>
            <p v-if="errors.email" class="text-red-600 text-xs mt-1">{{ errors.email }}</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <div>
              <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">First Name</label>
              <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                  class="absolute left-3 top-3.5 w-4 sm:w-5 h-4 sm:h-5 text-gray-500">
                  <path fill-rule="evenodd"
                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                    clip-rule="evenodd" />
                </svg>
                <input v-model="formData.first_name" type="text" placeholder="John" :class="{
                  'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-200': errors.first_name,
                  'border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200': !errors.first_name
                }"
                  class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-2.5 text-sm border-2 rounded-lg focus:outline-none transition-all" />
              </div>
              <p v-if="errors.first_name" class="text-red-600 text-xs mt-1">{{ errors.first_name }}</p>
            </div>

            <div>
              <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Last Name</label>
              <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                  class="absolute left-3 top-3.5 w-4 sm:w-5 h-4 sm:h-5 text-gray-500">
                  <path fill-rule="evenodd"
                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                    clip-rule="evenodd" />
                </svg>
                <input v-model="formData.last_name" type="text" placeholder="Cordova" :class="{
                  'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-200': errors.last_name,
                  'border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200': !errors.last_name
                }"
                  class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-2.5 text-sm border-2 rounded-lg focus:outline-none transition-all" />
              </div>
              <p v-if="errors.last_name" class="text-red-600 text-xs mt-1">{{ errors.last_name }}</p>
            </div>
          </div>

          <div>
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Contact Number</label>
            <div class="relative">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="absolute left-3 top-3.5 w-4 sm:w-5 h-4 sm:h-5 text-gray-500">
                <path d="M10.5 18.75a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" />
                <path fill-rule="evenodd"
                  d="M8.625.75A3.375 3.375 0 0 0 5.25 4.125v15.75a3.375 3.375 0 0 0 3.375 3.375h6.75a3.375 3.375 0 0 0 3.375-3.375V4.125A3.375 3.375 0 0 0 15.375.75h-6.75ZM7.5 4.125C7.5 3.504 8.004 3 8.625 3H9.75v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V3h1.125c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-6.75A1.125 1.125 0 0 1 7.5 19.875V4.125Z"
                  clip-rule="evenodd" />
              </svg>
              <input v-model="formData.phone_number" type="tel" maxlength="11" placeholder="09123456789"
                @input="formData.phone_number = formData.phone_number.replace(/\D/g, '')" :class="{
                  'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-200': errors.phone_number,
                  'border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200': !errors.phone_number
                }"
                class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2 sm:py-2.5 text-sm border-2 rounded-lg focus:outline-none transition-all" />
            </div>
            <p v-if="errors.phone_number" class="text-red-600 text-xs mt-1">{{ errors.phone_number }}</p>
          </div>

          <div>
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Role</label>
            <div class="relative" data-filter-container>
              <button @click="isRoleFormDropdownOpen = !isRoleFormDropdownOpen" type="button" :class="{
                'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-200': errors.role,
                'border-blue-200 focus:border-blue-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2': !errors.role
              }"
                class="w-full flex items-center justify-between px-4 py-2.5 sm:py-3 bg-gradient-to-r from-blue-50 to-blue-100 border rounded-lg hover:border-blue-300 focus:outline-none transition-all duration-200">
                <span class="font-semibold text-gray-800">
                  {{ formData.role || "Select Role" }}
                </span>
                <svg :class="[
                  'w-5 h-5 text-blue-600 transition-transform duration-300',
                  isRoleFormDropdownOpen ? 'rotate-180' : '',
                ]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div v-if="isRoleFormDropdownOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden">
                <div v-for="option in ['Admin', 'Customer']" :key="option" @click="handleRoleFormSelect(option)" :class="[
                  'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                  formData.role === option
                    ? 'bg-blue-50 border-l-4 border-l-blue-500'
                    : '',
                ]">
                  <span :class="[
                    'font-medium',
                    formData.role === option
                      ? 'text-blue-700'
                      : 'text-gray-700',
                  ]">
                    {{ option }}
                  </span>
                  <svg v-if="formData.role === option" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
              </div>
            </div>
            <p v-if="errors.role" class="text-red-600 text-xs mt-1">{{ errors.role }}</p>
          </div>

          <div>
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Password</label>
            <div class="relative">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="absolute left-3 top-3.5 w-4 sm:w-5 h-4 sm:h-5 text-gray-500">
                <path fill-rule="evenodd"
                  d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                  clip-rule="evenodd" />
              </svg>
              <input v-model="formData.password" :type="showPassword ? 'text' : 'password'" placeholder="••••••••"
                :class="{
                  'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-200': errors.password,
                  'border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200': !errors.password
                }"
                class="w-full pl-9 sm:pl-10 pr-9 sm:pr-12 py-2 sm:py-2.5 text-sm border-2 rounded-lg focus:outline-none transition-all" />
              <button @click="showPassword = !showPassword" type="button"
                class="absolute right-2 sm:right-3 top-3.5 text-gray-400 hover:text-gray-600">
                <svg v-if="!showPassword" class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
              </button>
            </div>
            <div v-if="formData.password" class="flex items-center gap-2 mt-2">
              <div class="h-1 sm:h-1.5 flex-1 bg-gray-200 rounded-full overflow-hidden">
                <div :class="{
                  'w-1/4 bg-red-500': passwordStrength.level === 1,
                  'w-2/4 bg-orange-500': passwordStrength.level === 2,
                  'w-3/4 bg-yellow-500': passwordStrength.level === 3,
                  'w-full bg-green-500': passwordStrength.level === 4
                }" class="h-full transition-all" />
              </div>
              <span :class="passwordStrength.color" class="text-xs font-semibold">{{ passwordStrength.text }}</span>
            </div>
            <p v-if="errors.password" class="text-red-600 text-xs mt-1">{{ errors.password }}</p>
          </div>

          <div>
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Confirm Password</label>
            <div class="relative">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="absolute left-3 top-3.5 w-4 sm:w-5 h-4 sm:h-5 text-gray-500">
                <path fill-rule="evenodd"
                  d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                  clip-rule="evenodd" />
              </svg>
              <input v-model="formData.password_confirmation" :type="showConfirmPassword ? 'text' : 'password'"
                placeholder="••••••••" :class="{
                  'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-200': errors.password_confirmation,
                  'border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200': !errors.password_confirmation
                }"
                class="w-full pl-9 sm:pl-10 pr-9 sm:pr-12 py-2 sm:py-2.5 text-sm border-2 rounded-lg focus:outline-none transition-all" />
              <button @click="showConfirmPassword = !showConfirmPassword" type="button"
                class="absolute right-2 sm:right-3 top-3.5 text-gray-400 hover:text-gray-600">
                <svg v-if="!showConfirmPassword" class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
              </button>
            </div>
            <div v-if="formData.password_confirmation && formData.password === formData.password_confirmation"
              class="flex items-center gap-2 mt-2">
              <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd" />
              </svg>
              <span class="text-xs font-semibold text-green-600">Passwords match</span>
            </div>
            <p v-if="errors.password_confirmation" class="text-red-600 text-xs mt-1">{{ errors.password_confirmation }}
            </p>
          </div>

          <div class="flex flex-col-reverse sm:flex-row gap-2 sm:gap-3 pt-4 sm:pt-6 border-t">
            <button @click="handleSubmit" :disabled="isLoading"
              class="flex-1 px-3 sm:px-4 py-2 sm:py-2.5 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white text-sm sm:text-base font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
              {{ isLoading ? 'Creating...' : 'Create User' }}
            </button>
            <button @click="showAddModal = false"
              class="flex-1 px-3 sm:px-4 py-2 sm:py-2.5 border-2 border-gray-300 text-gray-700 text-sm sm:text-base font-semibold rounded-lg hover:bg-gray-50 transition-all">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>

    <EditUserModal v-if="showEditModal" :user="selectedUser" :show="showEditModal" @updated="handleUserUpdated"
      @close="showEditModal = false" />
  </div>
</template>

<script setup>
import AdminIndex from "./AdminIndex.vue";
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';
import EditUserModal from "./components/EditUserModal.vue";
import { api } from "../../api/api";

defineOptions({ layout: AdminIndex });

const service = new api();
const users = ref([]);
const selectedUser = ref(null);
const showEditModal = ref(false);

const searchQuery = ref("");
const selectedRole = ref("");
const selectedEmailStatus = ref("");

const isRoleFilterOpen = ref(false);
const isEmailStatusFilterOpen = ref(false);
const isRoleFormDropdownOpen = ref(false);

const currentPage = ref(1);
const itemsPerPage = ref(10);

const roleOptions = ["", "Admin", "Customer"];
const emailStatusOptions = ["", "verified", "not_verified"];

const showAddModal = ref(false);
const showPassword = ref(false);
const showConfirmPassword = ref(false);
const errors = ref({});
const isLoading = ref(false);

const formData = ref({
  first_name: '',
  last_name: '',
  email: '',
  phone_number: '',
  password: '',
  password_confirmation: '',
  role: '',
});

const passwordStrength = computed(() => {
  const pwd = formData.value.password;
  if (!pwd) return { level: 0, text: '', color: '' };

  let strength = 0;
  if (pwd.length >= 8) strength++;
  if (/[A-Z]/.test(pwd)) strength++;
  if (/[0-9]/.test(pwd)) strength++;
  if (/[^A-Za-z0-9]/.test(pwd)) strength++;

  const strengths = [
    { level: 0, text: '', color: '' },
    { level: 1, text: 'Very Weak', color: 'text-red-600' },
    { level: 2, text: 'Weak', color: 'text-orange-600' },
    { level: 3, text: 'Moderate', color: 'text-yellow-600' },
    { level: 4, text: 'Strong', color: 'text-green-600' },
  ];
  return strengths[strength];
});

const closeAllFilters = () => {
  isRoleFilterOpen.value = false;
  isEmailStatusFilterOpen.value = false;
};

const handleFilterClick = (filterType) => {
  if (filterType === "role") {
    isRoleFilterOpen.value = !isRoleFilterOpen.value;
    isEmailStatusFilterOpen.value = false;
  } else if (filterType === "emailStatus") {
    isRoleFilterOpen.value = false;
    isEmailStatusFilterOpen.value = !isEmailStatusFilterOpen.value;
  }
};

const handleRoleSelect = (option) => {
  selectedRole.value = option;
  closeAllFilters();
};

const handleEmailStatusSelect = (option) => {
  selectedEmailStatus.value = option;
  closeAllFilters();
};

const handleRoleFormSelect = (option) => {
  formData.value.role = option;
  isRoleFormDropdownOpen.value = false;
};

const hasActiveFilters = computed(() => {
  return (
    searchQuery.value !== "" ||
    selectedRole.value !== "" ||
    selectedEmailStatus.value !== ""
  );
});

const filteredUsers = computed(() => {
  let filtered = users.value;

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter((user) => {
      const fullName = `${user.first_name} ${user.last_name}`.toLowerCase();
      const email = user.email.toLowerCase();
      const phone = user.phone_number?.toLowerCase() || "";
      const id = user.id.toString();

      return (
        fullName.includes(query) ||
        email.includes(query) ||
        phone.includes(query) ||
        id.includes(query)
      );
    });
  }

  if (selectedRole.value) {
    filtered = filtered.filter((user) => user.role === selectedRole.value);
  }

  if (selectedEmailStatus.value) {
    if (selectedEmailStatus.value === "verified") {
      filtered = filtered.filter((user) => user.email_verified_at !== null);
    } else if (selectedEmailStatus.value === "not_verified") {
      filtered = filtered.filter((user) => user.email_verified_at === null);
    }
  }

  return filtered;
});

const totalPages = computed(() => {
  return Math.ceil(filteredUsers.value.length / itemsPerPage.value);
});

const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredUsers.value.slice(start, end);
});

const startIndex = computed(() => {
  return (currentPage.value - 1) * itemsPerPage.value;
});

const endIndex = computed(() => {
  return Math.min(
    currentPage.value * itemsPerPage.value,
    filteredUsers.value.length
  );
});

const visiblePages = computed(() => {
  const pages = [];
  const maxVisible = 5;
  let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2));
  let end = Math.min(totalPages.value, start + maxVisible - 1);

  if (end - start + 1 < maxVisible) {
    start = Math.max(1, end - maxVisible + 1);
  }

  for (let i = start; i <= end; i++) {
    pages.push(i);
  }

  return pages;
});

const validateForm = () => {
  const newErrors = {};
  const { first_name, last_name, email, phone_number, password, password_confirmation } = formData.value;

  if (!first_name.trim()) newErrors.first_name = 'First name is required';
  if (!last_name.trim()) newErrors.last_name = 'Last name is required';
  if (!email.trim()) newErrors.email = 'Email is required';
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) newErrors.email = 'Invalid email format';
  if (!phone_number.trim()) newErrors.phone_number = 'Contact number is required';
  if (phone_number.replace(/\D/g, '').length !== 11) newErrors.phone_number = 'Must be exactly 11 digits';
  if (!password) newErrors.password = 'Password is required';
  if (password.length < 8) newErrors.password = 'Password must be at least 8 characters';
  if (!password_confirmation) newErrors.password_confirmation = 'Please confirm your password';
  if (password !== password_confirmation) newErrors.password_confirmation = 'Passwords do not match';
  if (!formData.value.role) newErrors.role = 'Role is required';

  errors.value = newErrors;
  return Object.keys(newErrors).length === 0;
};

const handleSubmit = async () => {
  if (validateForm()) {
    try {
      isLoading.value = true;
      const payload = {
        first_name: formData.value.first_name,
        last_name: formData.value.last_name,
        email: formData.value.email,
        phone_number: formData.value.phone_number,
        password: formData.value.password,
        password_confirmation: formData.value.password_confirmation,
        role: formData.value.role,
      };

      await service.createUser(payload);

      formData.value = {
        first_name: '',
        last_name: '',
        email: '',
        phone_number: '',
        password: '',
        password_confirmation: '',
        role: '',
      };
      errors.value = {};
      showAddModal.value = false;
      isRoleFormDropdownOpen.value = false;

      await fetchUsers();

      toast.success('User created successfully');
    } catch (error) {
      console.error('Error creating user:', error);
      if (error.response?.data?.errors) {
        errors.value = error.response.data.errors;
      } else {
        toast.error(error.response?.data?.message || 'Failed to create user');
      }
    } finally {
      isLoading.value = false;
    }
  }
};

const openUpdateEntryModal = (user) => {
  selectedUser.value = user;
  showEditModal.value = true;
};

const handleUserUpdated = async () => {
  await fetchUsers();
  showEditModal.value = false;
};

const fetchUsers = async () => {
  try {
    const response = await service.getUsers();
    users.value = response.data.data;
  } catch (error) {
    console.error("Error fetching users:", error);
  }
};

const clearFilters = () => {
  searchQuery.value = "";
  selectedRole.value = "";
  selectedEmailStatus.value = "";
  currentPage.value = 1;
};

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const handleClickOutside = (event) => {
  if (!event.target.closest(".relative")) {
    closeAllFilters();
    isRoleFormDropdownOpen.value = false;
  }
};

watch([searchQuery, selectedRole, selectedEmailStatus], () => {
  currentPage.value = 1;
});

watch(showAddModal, (newValue) => {
  if (!newValue) {
    isRoleFormDropdownOpen.value = false;
  }
});

onMounted(() => {
  fetchUsers();
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>