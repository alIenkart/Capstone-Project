<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const props = defineProps({
    show: {
        type: Boolean,
        required: true
    }
})
const toast = useToast();
const emit = defineEmits(['close', 'save'])

const formData = ref({
    image: null,
    name: '',
    duration: '',
    destination: '',
    region: '',
    description: '',
    itinerary: '',
    termsCondition: '',
    exclusions: '',
    basePrice: '',
    kidsBasePrice: '',
    maxOccupancy: '',
    bookingType: 'Exclusive', // Default value based on screenshot
    status: 'Active', // Default value based on screenshot
    discountedRate: ''
})

const imagePreview = ref(null)

// Reset form when modal is shown
watch(() => props.show, (newValue) => {
    if (newValue) {
        formData.value = {
            image: null,
            name: '',
            duration: '',
            destination: '',
            region: '',
            description: '',
            itinerary: '',
            termsCondition: '',
            exclusions: '',
            basePrice: '',
            kidsBasePrice: '',
            maxOccupancy: '',
            bookingType: 'Exclusive',
            status: 'Active',
            discountedRate: ''
        }
        imagePreview.value = null // Reset image preview when modal is shown
    }
})

const closeModal = () => {
    emit('close')
}

const savePackage = async () => {
    // Basic validation (can be enhanced)
    if (!formData.value.name || !formData.value.basePrice) {
        alert('Please fill in Package Name and Base Price.')
        return
    }

    const data = new FormData();
    if (formData.value.image) {
        data.append('image', formData.value.image);
    }
    data.append('package_name', formData.value.name);
    data.append('tour_duration', formData.value.duration ? formData.value.duration.toString() : '0');
    data.append('destination', formData.value.destination);
    data.append('region', formData.value.region || '');
    data.append('description', formData.value.description || '');
    data.append('itinerary', formData.value.itinerary || '');
    data.append('terms_condition', formData.value.termsCondition || '');
    data.append('exclusions', formData.value.exclusions || '');
    data.append('capacity', formData.value.maxOccupancy ? parseInt(formData.value.maxOccupancy) : 0);
    data.append('joint_booking', formData.value.bookingType === 'Shared' ? 'true' : 'false'); // send as string
    data.append('status', formData.value.status.toLowerCase());
    data.append('pax_rate', formData.value.basePrice ? parseFloat(formData.value.basePrice) : 0);
    data.append('kids_pax_rate', formData.value.kidsBasePrice ? parseFloat(formData.value.kidsBasePrice) : '');
    data.append('discounted_rate', formData.value.discountedRate ? parseFloat(formData.value.discountedRate) : 0);

    try {
        const response = await axios.post('/api/packages', data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        toast.success('Package created successfully!');
        emit('save', response.data.data);
        closeModal();
    } catch (error) {
        console.error('Error creating package:', error.response?.data || error);
        if (error.response && error.response.data && error.response.data.errors) {
            let errorMessages = 'Validation Errors:\n';
            for (const field in error.response.data.errors) {
                errorMessages += `- ${field}: ${error.response.data.errors[field].join(', ')}\n`;
            }
            alert('Error creating package:\n' + errorMessages);
        } else {
            alert('Error creating package. Please check the console for details.');
        }
    }
}

const handleImageUpload = (event) => {
    const file = event.target.files[0]
    formData.value.image = file
    if (file) {
        imagePreview.value = URL.createObjectURL(file)
    } else {
        imagePreview.value = null
    }
}
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="closeModal"></div>

        <!-- Modal panel -->
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
                            New Package
                        </h3>
                        
                        <form @submit.prevent="savePackage" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Image Upload Placeholder -->
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
                                            v-model="formData.name"
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
                                                v-model="formData.duration"
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
                                    </div>

                                    <div>
                                        <label for="basePrice" class="block text-sm font-medium text-gray-700">Base Price per Pax</label>
                                        <input
                                            type="number"
                                            id="basePrice"
                                            v-model="formData.basePrice"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label for="kidsBasePrice" class="block text-sm font-medium text-gray-700">Kids Price per Pax</label>
                                        <input
                                            type="number"
                                            id="kidsBasePrice"
                                            v-model="formData.kidsBasePrice"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                        />
                                    </div>

                                    <div>
                                        <label for="maxOccupancy" class="block text-sm font-medium text-gray-700">Maximum Occupancy</label>
                                        <input
                                            type="number"
                                            id="maxOccupancy"
                                            v-model="formData.maxOccupancy"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                        />
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="bookingType" class="block text-sm font-medium text-gray-700">Booking Type</label>
                                            <select
                                                id="bookingType"
                                                v-model="formData.bookingType"
                                                class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                            >
                                                <option value="Exclusive">Exclusive</option>
                                                <option value="Shared">Shared</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                            <select
                                                id="status"
                                                v-model="formData.status"
                                                class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                            >
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="discountedRate" class="block text-sm font-medium text-gray-700">Discounted Rate</label>
                                        <input
                                            type="number"
                                            id="discountedRate"
                                            v-model="formData.discountedRate"
                                            class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description*</label>
                                <textarea
                                    id="description"
                                    v-model="formData.description"
                                    rows="3"
                                    class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                    required
                                ></textarea>
                            </div>

                            <div>
                                <label for="itinerary" class="block text-sm font-medium text-gray-700">Itinerary*</label>
                                <textarea
                                    id="itinerary"
                                    v-model="formData.itinerary"
                                    rows="6"
                                    class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                ></textarea>
                            </div>

                            <div>
                                <label for="termsCondition" class="block text-sm font-medium text-gray-700">Terms & Condition*</label>
                                <textarea
                                    id="termsCondition"
                                    v-model="formData.termsCondition"
                                    rows="3"
                                    class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                ></textarea>
                            </div>

                            <div>
                                <label for="exclusions" class="block text-sm font-medium text-gray-700">Exclusions*</label>
                                <textarea
                                    id="exclusions"
                                    v-model="formData.exclusions"
                                    rows="3"
                                    class="mt-1 block w-full rounded-xl border-2 border-gray-300 focus:border-[#217093] focus:ring-[#217093] sm:text-sm"
                                ></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="inline-flex justify-center rounded-xl bg-gray-600 px-8 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#217093] focus:outline-none focus:ring-2 focus:ring-[#217093] focus:ring-offset-2"
                                >
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>