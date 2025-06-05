<script setup>
import AdminIndex from './AdminIndex.vue'
import NewPackageModal from '@/Pages/Admin/components/NewPackageModal.vue'
import EditPackageModal from '@/Pages/Admin/components/EditPackageModal.vue'
import { ref, onMounted } from 'vue'
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
    console.log('New package data:', packageData)
    fetchPackages();
    // TODO: Implement API call to save the package if not done in modal
}

const openEditModal = (packageId) => {
    selectedPackageId.value = packageId;
    showEditModal.value = true;
}

const handlePackageUpdated = (updatedPackage) => {
    console.log('Package updated:', updatedPackage);
    fetchPackages();
    // Optionally, find and update the specific package in the `packages` array to avoid full refetch
}

// Function to fetch packages
const fetchPackages = async () => {
    try {
        const response = await axios.get('/api/packages')
        packages.value = response.data.data
    } catch (error) {
        console.error('Error fetching packages:', error)
    }
}

// Fetch packages when the component is mounted
onMounted(() => {
    fetchPackages()
})
</script>

<template>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                This is the packages page
            </h1>
            <button
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2"
                @click="createNewPackage"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add New Package
            </button>
        </div>

        <div class="mt-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package ID</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package Name</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max Occupancy</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Type</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Price per Pax</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Package rows will go here -->
                    <tr v-for="packageItem in packages" :key="packageItem.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ packageItem.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ packageItem.package_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ packageItem.destination }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ packageItem.capacity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ packageItem.joint_booking ? 'Joint' : 'Exclusive' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ packageItem.tour_duration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ packageItem.status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ packageItem.pax_rate }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-indigo-600 hover:text-indigo-900" @click="openEditModal(packageItem.id)">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

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