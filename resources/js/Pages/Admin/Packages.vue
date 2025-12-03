<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
    <div class="max-w-[1600px] mx-auto">
      <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div
          class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4"
        >
          <div class="relative flex-1 max-w-md">
            <svg
              class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search packages..."
              class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
            />
          </div>

          <div class="flex items-center gap-3 flex-wrap">
            <div class="relative" data-filter-container>
              <button
                @click="handleFilterClick('status')"
                class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 min-w-[180px]"
              >
                <span class="font-semibold text-gray-800">
                  {{ selectedStatus === "" ? "All Status" : selectedStatus }}
                </span>
                <svg
                  :class="[
                    'w-5 h-5 text-blue-600 transition-transform duration-300',
                    isStatusFilterOpen ? 'rotate-180' : '',
                  ]"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div
                v-if="isStatusFilterOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden"
              >
                <div
                  v-for="option in statusOptions"
                  :key="option"
                  @click="handleStatusSelect(option)"
                  :class="[
                    'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                    selectedStatus === option
                      ? 'bg-blue-50 border-l-4 border-l-blue-500'
                      : '',
                  ]"
                >
                  <span
                    :class="[
                      'font-medium',
                      selectedStatus === option
                        ? 'text-blue-700'
                        : 'text-gray-700',
                    ]"
                  >
                    {{ option === "" ? "All Status" : option }}
                  </span>
                  <svg
                    v-if="selectedStatus === option"
                    class="w-5 h-5 text-blue-600 ml-auto"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="relative" data-filter-container>
              <button
                @click="handleFilterClick('bookingType')"
                class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 min-w-[180px]"
              >
                <span class="font-semibold text-gray-800">
                  {{
                    selectedBookingType === ""
                      ? "All Types"
                      : selectedBookingType === "exclusive"
                      ? "Exclusive"
                      : "Joint"
                  }}
                </span>
                <svg
                  :class="[
                    'w-5 h-5 text-blue-600 transition-transform duration-300',
                    isBookingTypeFilterOpen ? 'rotate-180' : '',
                  ]"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div
                v-if="isBookingTypeFilterOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden"
              >
                <div
                  v-for="option in bookingTypeOptions"
                  :key="option"
                  @click="handleBookingTypeSelect(option)"
                  :class="[
                    'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                    selectedBookingType === option
                      ? 'bg-blue-50 border-l-4 border-l-blue-500'
                      : '',
                  ]"
                >
                  <span
                    :class="[
                      'font-medium',
                      selectedBookingType === option
                        ? 'text-blue-700'
                        : 'text-gray-700',
                    ]"
                  >
                    {{
                      option === ""
                        ? "All Types"
                        : option === "exclusive"
                        ? "Exclusive"
                        : "Joint"
                    }}
                  </span>
                  <svg
                    v-if="selectedBookingType === option"
                    class="w-5 h-5 text-blue-600 ml-auto"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="relative" data-filter-container>
              <button
                @click="handleFilterClick('region')"
                class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 min-w-[180px]"
              >
                <span class="font-semibold text-gray-800">
                  {{ selectedRegion === "" ? "All Regions" : selectedRegion }}
                </span>
                <svg
                  :class="[
                    'w-5 h-5 text-blue-600 transition-transform duration-300',
                    isRegionFilterOpen ? 'rotate-180' : '',
                  ]"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
              </button>

              <div
                v-if="isRegionFilterOpen"
                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden max-h-96 overflow-y-auto"
              >
                <div
                  @click="handleRegionSelect('')"
                  :class="[
                    'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 sticky top-0 bg-white hover:bg-blue-50',
                    selectedRegion === ''
                      ? 'bg-blue-50 border-l-4 border-l-blue-500'
                      : '',
                  ]"
                >
                  <span
                    :class="[
                      'font-medium',
                      selectedRegion === '' ? 'text-blue-700' : 'text-gray-700',
                    ]"
                  >
                    All Regions
                  </span>
                  <svg
                    v-if="selectedRegion === ''"
                    class="w-5 h-5 text-blue-600 ml-auto"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>

                <div
                  v-for="region in uniqueRegions"
                  :key="region"
                  @click="handleRegionSelect(region)"
                  :class="[
                    'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
                    selectedRegion === region
                      ? 'bg-blue-50 border-l-4 border-l-blue-500'
                      : '',
                  ]"
                >
                  <span
                    :class="[
                      'font-medium',
                      selectedRegion === region
                        ? 'text-blue-700'
                        : 'text-gray-700',
                    ]"
                  >
                    {{ region }}
                  </span>
                  <svg
                    v-if="selectedRegion === region"
                    class="w-5 h-5 text-blue-600 ml-auto"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
              </div>
            </div>

            <button
              @click="createNewPackage"
              :disabled="isStaffRole"
              :title="isStaffRole ? 'Staff users cannot create packages' : 'Add New Package'"
              class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8] text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:shadow-lg disabled:hover:translate-y-0"
            >
              <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4v16m8-8H4"
                />
              </svg>
              Add New Package
            </button>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div v-if="filteredPackages.length > 0" class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr
                class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white"
              >
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Package ID
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Package Name
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Destination
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Region
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Max Occupancy
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Booking Type
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Duration
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Status
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Base Price
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Kids Price
                </th>
                <th 
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Status
                </th>
                <th
                  class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap"
                >
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr
                v-for="packageItem in paginatedPackages"
                :key="packageItem.id"
                class="hover:bg-blue-50/50 transition-colors"
              >
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-900 text-center"
                >
                  <span
                    class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-semibold"
                  >
                    #{{ packageItem.id }}
                  </span>
                </td>
                <td
                  class="px-6 py-4 text-sm text-gray-700 font-medium text-center"
                >
                  {{ packageItem.package_name }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-700 text-center">
                  <span class="inline-flex items-center gap-1.5 font-medium">
                    {{ packageItem.destination }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700 text-center">
                  <span class="px-2.5 py-1 rounded-lg font-medium">
                    {{ packageItem.region }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700 text-center">
                  <span class="inline-flex items-center gap-1.5 font-medium">
                    {{ packageItem.capacity }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-center">
                  <span
                    :class="{
                      'bg-blue-100 text-blue-700': !packageItem.joint_booking,
                      'bg-indigo-100 text-indigo-700':
                        packageItem.joint_booking,
                    }"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                  >
                    {{ packageItem.joint_booking ? "Joint" : "Exclusive" }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700 text-center">
                  <span class="inline-flex items-center gap-1.5 font-medium">
                    {{ packageItem.tour_duration }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-center">
                  <span
                    :class="{
                      'bg-green-100 text-green-700':
                        packageItem.status === 'active',
                      'bg-gray-100 text-gray-700':
                        packageItem.status === 'inactive',
                    }"
                    class="inline-flex items-center text-gray-700 px-3 py-1 rounded-full text-xs font-medium"
                  >
                    {{ _.startCase(packageItem.status) }}
                  </span>
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  ₱{{ Number(packageItem.pax_rate).toLocaleString() }}
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium text-gray-700 text-center"
                >
                  ₱{{ Number(packageItem.kids_pax_rate).toLocaleString() }}
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-700 text-center">
                  <label class="relative inline-flex items-center" :class="isStaffRole ? 'cursor-not-allowed' : 'cursor-pointer'">
                    <input
                      type="checkbox"
                      :disabled="isStaffRole"
                      :checked="packageItem.status === 'active'"
                      @change="toggleStatus(packageItem)"
                      class="sr-only peer"
                    />
                    <div
                      :class="[
                        'w-11 h-6 rounded-full transition-all',
                        packageItem.status === 'active' ? 'bg-green-500' : 'bg-gray-300',
                        isStaffRole ? 'opacity-50' : ''
                      ]"
                    ></div>
                    <div
                      :class="[
                        'absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform',
                        packageItem.status === 'active' ? 'translate-x-5' : '',
                        isStaffRole ? 'opacity-50' : ''
                      ]"
                    ></div>
                  </label>
                </td>
                <td class="px-6 py-4 text-sm text-center">
                  <div class="flex items-center justify-center gap-2">
                    <button
                      @click="openEditModal(packageItem.id)"
                      class="p-2 hover:bg-[#1E71B8] hover:text-white rounded-lg transition-all group"
                      title="Edit"
                    >
                      <svg
                        class="w-5 h-5 text-[#1E71B8] group-hover:text-white transition-colors"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                      </svg>
                    </button>
                    <button
                      @click="openDeleteConfirm(packageItem.id)"
                      :disabled="isStaffRole"
                      :title="isStaffRole ? 'Staff users cannot delete packages' : 'Delete'"
                      class="p-2 hover:bg-red-500 hover:text-white rounded-lg transition-all group disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                      <svg
                        class="w-5 h-5 text-red-500 group-hover:text-white transition-colors"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-else class="py-16 text-center">
          <svg
            class="w-16 h-16 mx-auto text-gray-300 mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
            />
          </svg>
          <h3 class="text-lg font-semibold text-gray-700 mb-2">
            No packages found
          </h3>
          <p class="text-gray-500">
            Try adjusting your search or filter criteria
          </p>
          <button
            v-if="hasActiveFilters"
            @click="clearFilters"
            class="mt-4 px-6 py-2 bg-[#1E71B8] text-white rounded-lg hover:bg-[#2a8bb5] transition-all"
          >
            Clear All Filters
          </button>
        </div>

        <div
          v-if="filteredPackages.length > 0"
          class="bg-gray-50 px-6 py-4 border-t border-gray-200"
        >
          <div class="flex items-center justify-between">
            <p class="text-sm text-gray-700">
              Showing <span class="font-semibold">{{ startIndex + 1 }}</span> to
              <span class="font-semibold">{{ endIndex }}</span> of
              <span class="font-semibold">{{ filteredPackages.length }}</span>
              results
            </p>
            <div class="flex gap-2">
              <button
                @click="previousPage"
                :disabled="currentPage === 1"
                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Previous
              </button>
              <button
                v-for="page in visiblePages"
                :key="page"
                @click="currentPage = page"
                :class="[
                  'px-4 py-2 rounded-lg font-semibold transition-all',
                  currentPage === page
                    ? 'bg-[#1E71B8] text-white'
                    : 'border-2 border-gray-200 hover:bg-gray-100',
                ]"
              >
                {{ page }}
              </button>
              <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <NewPackageModal
      :show="showModal"
      @close="showModal = false"
      @save="handleSavePackage"
    />
    <EditPackageModal
      :show="showEditModal"
      :packageId="selectedPackageId"
      @close="
        showEditModal = false;
        selectedPackageId = null;
      "
      @saved="handlePackageUpdated"
    />

    <div v-if="showDeleteConfirm" class="fixed inset-0 z-50 overflow-y-auto">
      <div
        class="fixed inset-0 bg-black/70 backdrop-blur-md transition-opacity"
        @click="showDeleteConfirm = false"
      ></div>
      <div class="flex min-h-full items-center justify-center p-4">
        <div
          class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all w-full max-w-md"
        >
          <div class="bg-gradient-to-r from-red-500 to-red-600 px-8 py-6">
            <h3 class="text-2xl font-bold text-white">Delete Package</h3>
          </div>

          <div class="px-8 py-6">
            <p class="text-gray-700 mb-2">
              Are you sure you want to delete this package?
            </p>
            <p class="text-gray-500 text-sm">This action cannot be undone.</p>
          </div>

          <div
            class="bg-gradient-to-r from-gray-50 to-white px-8 py-6 border-t-2 border-gray-200"
          >
            <div class="flex justify-end gap-3">
              <button
                type="button"
                @click="showDeleteConfirm = false"
                class="flex items-center gap-2 rounded-xl px-7 py-3 text-sm font-bold bg-gray-600 text-white hover:bg-gray-700 transition-all shadow-lg hover:shadow-xl"
              >
                Cancel
              </button>
              <button
                type="button"
                @click="confirmDelete"
                class="flex items-center gap-2 rounded-xl px-7 py-3 text-sm font-bold bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white shadow-lg hover:shadow-xl transition-all"
              >
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  />
                </svg>
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import AdminIndex from "./AdminIndex.vue";
import NewPackageModal from "@/Pages/Admin/components/NewPackageModal.vue";
import EditPackageModal from "@/Pages/Admin/components/EditPackageModal.vue";
import { ref, onMounted, computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import _ from "lodash";
import axios from "axios";
import { useToast } from "vue-toastification";

defineOptions({ layout: AdminIndex });

const toast = useToast();
const page = usePage();
const role = page?.props?.auth?.user?.role;
const showModal = ref(false);
const showEditModal = ref(false);
const showDeleteConfirm = ref(false);
const selectedPackageId = ref(null);
const packageToDelete = ref(null);
const packages = ref([]);

const searchQuery = ref("");
const selectedStatus = ref("");
const selectedBookingType = ref("");
const selectedRegion = ref("");

const isStatusFilterOpen = ref(false);
const isBookingTypeFilterOpen = ref(false);
const isRegionFilterOpen = ref(false);

const currentPage = ref(1);
const itemsPerPage = ref(10);

const statusOptions = ["", "Active", "Inactive"];
const bookingTypeOptions = ["", "exclusive", "joint"];

const isStaffRole = computed(() => {
  return role?.toLowerCase() === "staff";
});

const hasActiveFilters = computed(() => {
  return (
    searchQuery.value !== "" ||
    selectedStatus.value !== "" ||
    selectedBookingType.value !== "" ||
    selectedRegion.value !== ""
  );
});

const uniqueRegions = computed(() => {
  const regions = packages.value.map((pkg) => pkg.region).filter(Boolean);
  return [...new Set(regions)].sort();
});

const filteredPackages = computed(() => {
  let filtered = packages.value;

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter((pkg) => {
      const packageName = pkg.package_name?.toLowerCase() || "";
      const destination = pkg.destination?.toLowerCase() || "";
      const region = pkg.region?.toLowerCase() || "";
      const id = pkg.id?.toString() || "";

      return (
        packageName.includes(query) ||
        destination.includes(query) ||
        region.includes(query) ||
        id.includes(query)
      );
    });
  }

  if (selectedStatus.value) {
    filtered = filtered.filter((pkg) => pkg.status === selectedStatus.value);
  }

  if (selectedBookingType.value) {
    if (selectedBookingType.value === "joint") {
      filtered = filtered.filter(
        (pkg) => pkg.joint_booking === true || pkg.joint_booking === 1
      );
    } else if (selectedBookingType.value === "exclusive") {
      filtered = filtered.filter(
        (pkg) => pkg.joint_booking === false || pkg.joint_booking === 0
      );
    }
  }

  if (selectedRegion.value) {
    filtered = filtered.filter((pkg) => pkg.region === selectedRegion.value);
  }

  return filtered;
});

const totalPages = computed(() => {
  return Math.ceil(filteredPackages.value.length / itemsPerPage.value);
});

const paginatedPackages = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredPackages.value.slice(start, end);
});

const startIndex = computed(() => {
  return (currentPage.value - 1) * itemsPerPage.value;
});

const endIndex = computed(() => {
  return Math.min(
    currentPage.value * itemsPerPage.value,
    filteredPackages.value.length
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

const createNewPackage = () => {
  showModal.value = true;
};

const handleSavePackage = (packageData) => {
  fetchPackages();
};

const openEditModal = (packageId) => {
  selectedPackageId.value = packageId;
  showEditModal.value = true;
};

const handlePackageUpdated = (updatedPackage) => {
  fetchPackages();
};

const openDeleteConfirm = (packageId) => {
  packageToDelete.value = packageId;
  showDeleteConfirm.value = true;
};

const confirmDelete = async () => {
  try {
    await axios.delete(`/api/packages/${packageToDelete.value}`);
    toast.success("Package deleted successfully!");
    showDeleteConfirm.value = false;
    packageToDelete.value = null;
    fetchPackages();
  } catch (error) {
    console.error("Error deleting package:", error);
    toast.error("Error deleting package");
  }
};

const toggleStatus = async (packageItem) => {
  try {
    const newStatus = packageItem.status === 'active' ? 'inactive' : 'active'
    packageItem.status = newStatus

    await axios.patch(`/api/packages/${packageItem.id}/toggle-status`, {
      status: newStatus
    })

    toast.success(`Package status has been successfully updated to ${newStatus}`)
  } catch (error) {
    toast.error('Failed to toggle status:', error)
    packageItem.status = packageItem.status === 'active' ? 'inactive' : 'active'
  }
}

const fetchPackages = async () => {
  try {
    const response = await axios.get("/api/packages");
    packages.value = response.data.data;
  } catch (error) {
    console.error("Error fetching packages:", error);
  }
};

const clearFilters = () => {
  searchQuery.value = "";
  selectedStatus.value = "";
  selectedBookingType.value = "";
  selectedRegion.value = "";
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

const closeAllFilters = () => {
  isStatusFilterOpen.value = false;
  isBookingTypeFilterOpen.value = false;
  isRegionFilterOpen.value = false;
};

const handleStatusSelect = (option) => {
  selectedStatus.value = option;
  isStatusFilterOpen.value = false;
};

const handleBookingTypeSelect = (option) => {
  selectedBookingType.value = option;
  isBookingTypeFilterOpen.value = false;
};

const handleRegionSelect = (region) => {
  selectedRegion.value = region;
  isRegionFilterOpen.value = false;
};

const handleFilterClick = (filterType) => {
  if (filterType === "status") {
    isStatusFilterOpen.value = !isStatusFilterOpen.value;
    isBookingTypeFilterOpen.value = false;
    isRegionFilterOpen.value = false;
  } else if (filterType === "bookingType") {
    isStatusFilterOpen.value = false;
    isBookingTypeFilterOpen.value = !isBookingTypeFilterOpen.value;
    isRegionFilterOpen.value = false;
  } else if (filterType === "region") {
    isStatusFilterOpen.value = false;
    isBookingTypeFilterOpen.value = false;
    isRegionFilterOpen.value = !isRegionFilterOpen.value;
  }
};

watch(
  [searchQuery, selectedStatus, selectedBookingType, selectedRegion],
  () => {
    currentPage.value = 1;
  }
);

onMounted(() => {
  fetchPackages();

  document.addEventListener("click", (e) => {
    if (!e.target.closest(".relative")) {
      closeAllFilters();
    }
  });
});
</script>