<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification'

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    packageId: {
        type: [Number, String, null],
        default: null,
    },
});
const toast = useToast();
const emit = defineEmits(['close', 'saved']);

const formData = ref({
    id: null,
    package_name: '',
    destination: '',
    region: '',
    description: '',
    tour_duration: '',
    image_path: '', // Or handle image file
    itinerary: '',
    terms_condition: '',
    exclusions: '',
    capacity: 0,
    joint_booking: false,
    status: 'active',
    pax_rate: 0,
    kids_pax_rate: 0,
    discounted_rate: 0,
});

const showDeleteConfirmationModal = ref(false); // Reactive variable for delete confirmation modal
const imagePreview = ref(null);

// Watch for changes in show and packageId props to fetch package data when modal opens with an ID
watch([() => props.show, () => props.packageId], ([newShow, newPackageId]) => {
    if (newShow && newPackageId !== null) {
        fetchPackage(newPackageId);
    } else if (!newShow) {
        resetForm();
        showDeleteConfirmationModal.value = false; // Close confirmation modal if main modal closes
    }
});

const fetchPackage = async (id) => {
    try {
        const response = await axios.get(`/api/packages/${id}`);
        const packageData = response.data.data;
        // Populate formData with fetched data
        formData.value = {
            id: packageData.id,
            package_name: packageData.package_name || '',
            destination: packageData.destination || '',
            region: packageData.region || '',
            description: packageData.description || '',
            tour_duration: packageData.tour_duration || '',
            image_path: packageData.image_path || '',
            itinerary: packageData.itinerary || '',
            terms_condition: packageData.terms_condition || '',
            exclusions: packageData.exclusions || '',
            capacity: packageData.capacity || 0,
            joint_booking: packageData.joint_booking === 1, // Convert boolean from API (might be 0/1)
            status: packageData.status || 'active',
            pax_rate: packageData.pax_rate || 0,
            kids_pax_rate: packageData.kids_pax_rate || 0,
            discounted_rate: packageData.discounted_rate || 0,
        };
        // Set image preview to current image
        if (formData.value.image_path) {
            imagePreview.value = `/storage/${formData.value.image_path}`;
        } else {
            imagePreview.value = null;
        }
    } catch (error) {
        console.error('Error fetching package:', error);
        // Optionally show an error message to the user
        alert('Error fetching package data.');
        closeModal(); // Close modal if data fetching fails
    }
};

const closeModal = () => {
    emit('close');
};

const updatePackage = async () => {
    try {
        let response;
        if (formData.value.image) {
            // If a new image is selected, use FormData
            const data = new FormData();
            data.append('package_name', formData.value.package_name);
            data.append('destination', formData.value.destination);
            data.append('region', formData.value.region || '');
            data.append('description', formData.value.description);
            data.append('tour_duration', formData.value.tour_duration);
            data.append('itinerary', formData.value.itinerary);
            data.append('terms_condition', formData.value.terms_condition);
            data.append('exclusions', formData.value.exclusions);
            data.append('capacity', parseInt(formData.value.capacity) || 0);
            data.append('joint_booking', formData.value.joint_booking ? 'true' : 'false');
            data.append('status', formData.value.status.toLowerCase());
            data.append('pax_rate', parseFloat(formData.value.pax_rate) || 0);
            data.append('kids_pax_rate', formData.value.kids_pax_rate !== undefined && formData.value.kids_pax_rate !== null && formData.value.kids_pax_rate !== '' ? parseFloat(formData.value.kids_pax_rate) : '');
            data.append('discounted_rate', parseFloat(formData.value.discounted_rate) || 0);
            data.append('image', formData.value.image);

            response = await axios.post(`/api/packages/${formData.value.id}?_method=PUT`, data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
        } else {
            // No new image, send JSON
            const payload = {
                package_name: formData.value.package_name,
                destination: formData.value.destination,
                region: formData.value.region || '',
                description: formData.value.description,
                tour_duration: formData.value.tour_duration,
                itinerary: formData.value.itinerary,
                terms_condition: formData.value.terms_condition,
                exclusions: formData.value.exclusions,
                capacity: parseInt(formData.value.capacity) || 0,
                joint_booking: !!formData.value.joint_booking,
                status: formData.value.status.toLowerCase(),
                pax_rate: parseFloat(formData.value.pax_rate) || 0,
                kids_pax_rate: formData.value.kids_pax_rate === '' || formData.value.kids_pax_rate === null || formData.value.kids_pax_rate === undefined ? null : parseFloat(formData.value.kids_pax_rate),
                discounted_rate: parseFloat(formData.value.discounted_rate) || 0,
            };
            response = await axios.put(`/api/packages/${formData.value.id}`, payload);
        }
        toast.success('Package updated successfully!');
        emit('saved', response.data.data);
        closeModal();
    } catch (error) {
        console.error('Error updating package:', error.response ? error.response.data : error);
        if (error.response && error.response.data && error.response.data.errors) {
            let errorMessages = 'Validation Errors:\n'
            for (const field in error.response.data.errors) {
                errorMessages += `- ${field}: ${error.response.data.errors[field].join(', ')}\n`
            }
            alert('Error updating package:\n' + errorMessages)
        } else {
            alert('Error updating package. Please check the console for details.')
        }
    }
};

const resetForm = () => {
     formData.value = {
        id: null,
        package_name: '',
        destination: '',
        region: '',
        description: '',
        tour_duration: '',
        image_path: '',
        itinerary: '',
        terms_condition: '',
        exclusions: '',
        capacity: 0,
        joint_booking: false,
        status: 'active',
        pax_rate: 0,
        discounted_rate: 0,
    };
}

// TODO: Implement image upload handling if necessary
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    formData.value.image = file;
    if (file) {
        imagePreview.value = URL.createObjectURL(file);
    } else if (formData.value.image_path) {
        imagePreview.value = `/storage/${formData.value.image_path}`;
    } else {
        imagePreview.value = null;
    }
};

const showDeleteConfirmation = () => {
    showDeleteConfirmationModal.value = true;
};

const cancelDelete = () => {
    showDeleteConfirmationModal.value = false;
};

const confirmDelete = async () => {
    console.log('Attempting to delete package with id:', formData.value.id);
    try {
        const response = await axios.delete(`/api/packages/${formData.value.id}`);
        console.log('Package deleted successfully:', response.data);
        alert('Package deleted successfully!');
        emit('saved', null); // Emit null to indicate package deletion
        closeModal(); // Close both modals
    } catch (error) {
        console.error('Error deleting package:', error.response ? error.response.data : error);
        alert('Error deleting package. Please check the console for details.');
        cancelDelete(); // Close only the confirmation modal on error
    }
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="closeModal"></div>

        <!-- Main Edit Modal panel -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-2xl border-2 border-gray-300 bg-white px-6 py-6 text-left shadow-2xl transition-all sm:my-8 w-full max-w-4xl">
                <!-- Close button -->
                <div class="absolute right-0 top-0 pr-4 pt-4">
                    <button
                        type="button"
                        class="rounded-full bg-white text-gray-400 hover:text-gray-500 focus:outline-none"
                        @click="closeModal"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal content -->
                <div>
                    <div class="text-center sm:text-left w-full">
                        <h3 class="text-xl font-semibold leading-6 text-gray-900 mb-6">
                            Edit Package
                        </h3>
                        
                        <form @submit.prevent="updatePackage" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Image Upload/Display Placeholder -->
                                <div class="flex items-center justify-center border-2 border-dashed border-gray-400 rounded-xl bg-gray-50 p-6 text-gray-500 cursor-pointer hover:text-[#217093] hover:border-[#217093]">
                                    <label for="imageUpload" class="flex flex-col items-center justify-center w-full h-full cursor-pointer">
                                        <template v-if="imagePreview">
                                            <img :src="imagePreview" alt="Preview" class="w-32 h-32 object-cover rounded-xl mb-2" />
                                            <span class="text-xs text-gray-400">Click to change</span>
                                        </template>
                                        <template v-else>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16l5-5m0 0l5 5m-5-5v10m7-10l5-5m0 0l5 5m-5-5v10M3 19h18a2 2 0 002-2V7a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm">Add Image Here</span>
                                        </template>
                                        <input type="file" id="imageUpload" class="hidden" @change="handleImageUpload" />
                                    </label>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Package Name</label>
                                        <input
                                            type="text"
                                            id="name"
                                            v-model="formData.package_name"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                            required
                                        />
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="duration" class="block text-sm font-medium text-gray-700">Duration (Days)</label>
                                            <input
                                                type="number"
                                                id="duration"
                                                v-model="formData.tour_duration"
                                                class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                            />
                                        </div>
                                        <div>
                                            <label for="destination" class="block text-sm font-medium text-gray-700">Destination</label>
                                            <input
                                                type="text"
                                                id="destination"
                                                v-model="formData.destination"
                                                class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                            />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="region" class="block text-sm font-medium text-gray-700">Region</label>
                                        <select
                                            id="region"
                                            v-model="formData.region"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                        >
                                            <option value="National Capital Region (NCR)">National Capital Region (NCR)</option>
                                            <option value="Cordillera Administrative Region (CAR)">Cordillera Administrative Region (CAR)</option>
                                            <option value="Region I: Ilocos Region">Region I: Ilocos Region</option>
                                            <option value="Region II: Cagayan Valley">Region II: Cagayan Valley</option>
                                            <option value="Region III: Central Luzon">Region III: Central Luzon</option>
                                            <option value="Region IV-A: Calabarzon (CALaBarzon)">Region IV-A: Calabarzon (CALABARZON)</option>
                                            <option value="Region IV-B: Mimaropa (MIMAROPA)">Region IV-B: Mimaropa (MIMAROPA)</option>
                                            <option value="Region V: Bicol Region">Region V: Bicol Region</option>
                                            <option value="Region VI: Western Visayas">Region VI: Western Visayas</option>
                                            <option value="Region VII: Central Visayas">Region VII: Central Visayas</option>
                                            <option value="Region VIII: Eastern Visayas">Region VIII: Eastern Visayas</option>
                                            <option value="Region IX: Zamboanga Peninsula">Region IX: Zamboanga Peninsula</option>
                                            <option value="Region X: Northern Mindanao">Region X: Northern Mindanao</option>
                                            <option value="Region XI: Davao Region">Region XI: Davao Region</option>
                                            <option value="Region XII: SOCCSKSARGEN">Region XII: SOCCSKSARGEN</option>
                                            <option value="Region XIII: Caraga">Region XIII: Caraga</option>
                                            <option value="BARMM: Bangsamoro Autonomous Region in Muslim Mindanao">BARMM: Bangsamoro Autonomous Region in Muslim Mindanao</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="basePrice" class="block text-sm font-medium text-gray-700">Base Price per Pax</label>
                                        <input
                                            type="number"
                                            id="basePrice"
                                            v-model="formData.pax_rate"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label for="kidsBasePrice" class="block text-sm font-medium text-gray-700">Kids Price per Pax</label>
                                        <input
                                            type="number"
                                            id="kidsBasePrice"
                                            v-model="formData.kids_pax_rate"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                        />
                                    </div>

                                    <div>
                                        <label for="maxOccupancy" class="block text-sm font-medium text-gray-700">Maximum Occupancy</label>
                                        <input
                                            type="number"
                                            id="maxOccupancy"
                                            v-model="formData.capacity"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                        />
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="bookingType" class="block text-sm font-medium text-gray-700">Booking Type</label>
                                            <select
                                                id="bookingType"
                                                v-model="formData.joint_booking"
                                                class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                            >
                                                <option :value="false">Exclusive</option>
                                                <option :value="true">Shared</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                            <select
                                                id="status"
                                                v-model="formData.status"
                                                class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                            >
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="discountedRate" class="block text-sm font-medium text-gray-700">Discounted Rate</label>
                                        <input
                                            type="number"
                                            id="discountedRate"
                                            v-model="formData.discounted_rate"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea
                                    id="description"
                                    v-model="formData.description"
                                    rows="3"
                                    class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                    required
                                ></textarea>
                            </div>

                            <div>
                                <label for="itinerary" class="block text-sm font-medium text-gray-700">Itinerary</label>
                                <textarea
                                    id="itinerary"
                                    v-model="formData.itinerary"
                                    rows="3"
                                    class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                    required
                                ></textarea>
                            </div>

                            <div>
                                <label for="termsCondition" class="block text-sm font-medium text-gray-700">Terms & Condition</label>
                                <textarea
                                    id="termsCondition"
                                    v-model="formData.terms_condition"
                                    rows="3"
                                    class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                    required
                                ></textarea>
                            </div>

                            <div>
                                <label for="exclusions" class="block text-sm font-medium text-gray-700">Exclusions</label>
                                <textarea
                                    id="exclusions"
                                    v-model="formData.exclusions"
                                    rows="3"
                                    class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                    required
                                ></textarea>
                            </div>

                            <div class="mt-6 flex justify-end gap-x-6">
                                <button type="button" class="rounded-xl px-3 py-2 text-sm font-semibold leading-6 text-gray-900" @click="closeModal">Cancel</button>
                                <button type="button" class="rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600" @click="showDeleteConfirmation">Delete</button>
                                <button type="submit" class="rounded-xl bg-[#217093] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#14516b] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#217093]">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteConfirmationModal" class="fixed inset-0 z-50 overflow-y-auto">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="cancelDelete"></div>

            <!-- Modal panel -->
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-6 py-6 text-left shadow-xl transition-all sm:my-8 w-full max-w-sm">
                    <!-- Modal content -->
                    <div class="">
                        <div class="text-center">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4">Confirm Deletion</h3>
                            <p class="text-sm text-gray-500">Are you sure you want to delete this package? This action cannot be undone.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-center gap-x-6">
                        <button type="button" class="rounded-md px-3 py-2 text-sm font-semibold leading-6 text-gray-900" @click="cancelDelete">No</button>
                        <button type="button" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600" @click="confirmDelete">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
