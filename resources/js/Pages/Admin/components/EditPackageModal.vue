<template>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-md transition-opacity" @click="closeModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all sm:my-8 w-full max-w-7xl">
                <button type="button"
                    class="absolute right-4 top-4 z-10 rounded-full p-2 text-white/80 hover:text-white hover:bg-white/20 transition-all"
                    @click="closeModal">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="bg-gradient-to-r from-[#217093] to-[#2a8bb5] px-8 py-8">
                    <h3 class="text-3xl font-bold text-white tracking-tight">Edit Package</h3>
                    <p class="mt-2 text-white/80 text-sm">Edit travel package</p>
                </div>

                <form @submit.prevent="updatePackage"
                    class="px-8 py-8 max-h-[calc(100vh-280px)] overflow-y-auto bg-gradient-to-br from-slate-50 to-white">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="space-y-6">
                            <div
                                class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Package Image</h4>
                                </div>
                                <div class="relative flex items-center justify-center border-2 border-dashed rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 p-8 text-slate-500 cursor-pointer hover:text-[#217093] hover:border-[#217093] hover:bg-gradient-to-br hover:from-blue-50 hover:to-slate-50 transition-all group"
                                    :class="imagePreview ? 'border-[#217093] bg-white' : 'border-slate-300'">
                                    <label for="imageUpload"
                                        class="flex flex-col items-center justify-center w-full cursor-pointer">
                                        <template v-if="imagePreview">
                                            <img :src="imagePreview" alt="Preview"
                                                class="w-full h-72 object-cover rounded-xl shadow-2xl ring-4 ring-[#217093]/20" />
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                                                <span
                                                    class="text-white font-semibold text-sm bg-[#217093] px-4 py-2 rounded-full shadow-lg">Click
                                                    to change</span>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div
                                                class="p-5 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl mb-4 group-hover:from-[#217093]/20 group-hover:to-blue-200 transition-all shadow-inner">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-base font-bold text-slate-700 group-hover:text-[#217093] mb-1">Upload
                                                Package Image</span>
                                            <span class="text-xs text-slate-400">PNG, JPG • Max 10MB</span>
                                        </template>
                                        <input type="file" id="imageUpload" class="hidden"
                                            @change="handleImageUpload" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-6">
                            <div
                                class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Package Information</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="md:col-span-2">
                                        <label for="name"
                                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Package
                                            Name*</label>
                                        <input type="text" id="name" v-model="formData.package_name"
                                            class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all"
                                            placeholder="e.g., Paradise Island Getaway" required />
                                    </div>
                                    <div>
                                        <label for="duration"
                                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Duration
                                            (Days)</label>
                                        <input type="number" id="duration" v-model="formData.tour_duration"
                                            class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all"
                                            placeholder="0" />
                                    </div>
                                    <div>
                                        <label for="destination"
                                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Destination</label>
                                        <input type="text" id="destination" v-model="formData.destination"
                                            class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all"
                                            placeholder="e.g., Boracay" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="region"
                                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Region</label>
                                        <select id="region" v-model="formData.region"
                                            class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm font-medium outline-none transition-all">
                                            <option value="">Select region</option>
                                            <option value="National Capital Region (NCR)">National Capital Region (NCR)
                                            </option>
                                            <option value="Cordillera Administrative Region (CAR)">Cordillera
                                                Administrative Region (CAR)</option>
                                            <option value="Region I: Ilocos Region">Region I: Ilocos Region</option>
                                            <option value="Region II: Cagayan Valley">Region II: Cagayan Valley</option>
                                            <option value="Region III: Central Luzon">Region III: Central Luzon</option>
                                            <option value="Region IV-A: Calabarzon (CALaBarzon)">Region IV-A: Calabarzon
                                                (CALABARZON)</option>
                                            <option value="Region IV-B: Mimaropa (MIMAROPA)">Region IV-B: Mimaropa
                                                (MIMAROPA)</option>
                                            <option value="Region V: Bicol Region">Region V: Bicol Region</option>
                                            <option value="Region VI: Western Visayas">Region VI: Western Visayas
                                            </option>
                                            <option value="Region VII: Central Visayas">Region VII: Central Visayas
                                            </option>
                                            <option value="Region VIII: Eastern Visayas">Region VIII: Eastern Visayas
                                            </option>
                                            <option value="Region IX: Zamboanga Peninsula">Region IX: Zamboanga
                                                Peninsula</option>
                                            <option value="Region X: Northern Mindanao">Region X: Northern Mindanao
                                            </option>
                                            <option value="Region XI: Davao Region">Region XI: Davao Region</option>
                                            <option value="Region XII: SOCCSKSARGEN">Region XII: SOCCSKSARGEN</option>
                                            <option value="Region XIII: Caraga">Region XIII: Caraga</option>
                                            <option value="BARMM: Bangsamoro Autonomous Region in Muslim Mindanao">
                                                BARMM: Bangsamoro Autonomous Region in Muslim Mindanao</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Pricing Information</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <div>
                                        <label for="basePrice"
                                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Base
                                            Price per Pax*</label>
                                        <div class="relative">
                                            <span
                                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-lg">₱</span>
                                            <input type="number" id="basePrice" v-model="formData.pax_rate"
                                                class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 pl-9 pr-4 py-3 text-sm font-bold outline-none transition-all"
                                                placeholder="0.00" required />
                                        </div>
                                    </div>
                                    <div>
                                        <label for="kidsBasePrice"
                                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kids
                                            Price per Pax</label>
                                        <div class="relative">
                                            <span
                                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-lg">₱</span>
                                            <input type="number" id="kidsBasePrice" v-model="formData.kids_pax_rate"
                                                class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 pl-9 pr-4 py-3 text-sm font-bold outline-none transition-all"
                                                placeholder="0.00" />
                                        </div>
                                    </div>
                                    <div>
                                        <label for="discountedRate"
                                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Discounted
                                            Rate</label>
                                        <div class="relative">
                                            <span
                                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-lg">₱</span>
                                            <input type="number" id="discountedRate" v-model="formData.discounted_rate"
                                                class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 pl-9 pr-4 py-3 text-sm font-bold outline-none transition-all"
                                                placeholder="0.00" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Description*</h4>
                                </div>
                                <textarea id="description" v-model="formData.description" rows="5"
                                    class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none"
                                    placeholder="Describe the package in detail. What makes it special?"
                                    required></textarea>
                            </div>

                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center gap-3">
                                        <h4 class="text-xl font-bold text-slate-800">Itinerary*</h4>
                                    </div>
                                    <div class="text-sm font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">
                                        Day {{ itineraryDays.length }}
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <TransitionGroup name="list">
                                        <div v-for="(day, index) in itineraryDays" :key="day.id"
                                            class="bg-white border-2 border-blue-200 rounded-xl p-5 hover:border-blue-400 transition-all shadow-sm hover:shadow-md">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center gap-3">
                                                    <h4 class="text-lg font-bold text-slate-800">Day {{ index + 1 }}</h4>
                                                </div>
                                                <button v-if="itineraryDays.length > 1" type="button"
                                                    @click="removeItineraryDay(day.id)"
                                                    class="p-2 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-600 transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <textarea v-model="day.content"
                                                :placeholder="`Describe the activities and highlights for Day ${day.id}...`"
                                                rows="4"
                                                class="w-full rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 px-4 py-3 text-sm outline-none transition-all resize-none"></textarea>
                                        </div>
                                    </TransitionGroup>

                                    <button type="button" @click="addItineraryDay"
                                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-bold rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Another Day
                                    </button>
                                </div>
                            </div>

                            <div
                                class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Terms & Conditions*</h4>
                                </div>
                                <textarea id="termsCondition" v-model="formData.terms_condition" rows="5"
                                    class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none"
                                    placeholder="Enter terms and conditions that apply to this package..."
                                    required></textarea>
                            </div>

                            <div
                                class="bg-white rounded-2xl p-6 border border-slate-200 shadow-md hover:shadow-xl transition-all mb-6">
                                <div class="flex items-center gap-3 mb-5">
                                    <h4 class="text-xl font-bold text-slate-800">Exclusions*</h4>
                                </div>
                                <textarea id="exclusions" v-model="formData.exclusions" rows="5"
                                    class="w-full rounded-xl border-2 border-slate-200 focus:border-[#217093] focus:ring-4 focus:ring-[#217093]/10 px-4 py-3 text-sm outline-none transition-all resize-none"
                                    placeholder="List what's not included in the package..." required></textarea>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="bg-gradient-to-r from-slate-50 to-white px-8 py-6 border-t-2 border-slate-200">
                    <div class="flex justify-end gap-3">
                        <button type="button"
                            class="flex items-center gap-2 rounded-xl px-7 py-3 text-sm font-bold bg-slate-600 text-white hover:bg-slate-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0"
                            @click="closeModal">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        <button type="submit" @click="updatePackage"
                            class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#217093] to-[#2a8bb5] hover:from-[#1a5a7a] hover:to-[#217093] px-7 py-3 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const props = defineProps({
    show: Boolean,
    packageId: [Number, String, null]
})

const toast = useToast()
const emit = defineEmits(['close', 'saved'])

const formData = ref({
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
    kids_pax_rate: 0,
    discounted_rate: 0
})

const itineraryDays = ref([{ id: 1, content: '' }])
const showDeleteConfirmationModal = ref(false)
const imagePreview = ref(null)

watch([() => props.show, () => props.packageId], ([newShow, newPackageId]) => {
    if (newShow && newPackageId !== null) {
        fetchPackage(newPackageId)
    } else if (!newShow) {
        resetForm()
        showDeleteConfirmationModal.value = false
    }
})

const fetchPackage = async (id) => {
    try {
        const response = await axios.get(`/api/packages/${id}`)
        const packageData = response.data.data
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
            joint_booking: packageData.joint_booking === 1,
            status: packageData.status || 'active',
            pax_rate: packageData.pax_rate || 0,
            kids_pax_rate: packageData.kids_pax_rate || 0,
            discounted_rate: packageData.discounted_rate || 0
        }
        
        const apiItinerary = typeof packageData.itinerary === 'string'
            ? JSON.parse(packageData.itinerary) : packageData.itinerary || {}
        
        itineraryDays.value = Object.keys(apiItinerary).map((key, index) => ({
            id: index + 1,
            number_of_day: index + 1, 
            content: apiItinerary[key]
        }))
        imagePreview.value = formData.value.image_path ? `/storage/${formData.value.image_path}` : null
    } catch (error) {
        console.error('Error fetching package:', error)
        alert('Error fetching package data.')
        closeModal()
    }
}

const closeModal = () => {
    emit('close')
}

const updatePackage = async () => {
    try {
        let response
        const formattedItinerary = {}
        itineraryDays.value.forEach(day => {
            formattedItinerary[`day_${day.id}`] = day.content
        })
        if (formData.value.image) {
            const data = new FormData()
            data.append('package_name', formData.value.package_name)
            data.append('destination', formData.value.destination)
            data.append('region', formData.value.region || '')
            data.append('description', formData.value.description)
            data.append('tour_duration', formData.value.tour_duration)
            data.append('itinerary', JSON.stringify(formattedItinerary))
            data.append('terms_condition', formData.value.terms_condition)
            data.append('exclusions', formData.value.exclusions)
            data.append('capacity', parseInt(formData.value.capacity) || 0)
            data.append('joint_booking', formData.value.joint_booking ? 'true' : 'false')
            data.append('status', formData.value.status.toLowerCase())
            data.append('pax_rate', parseFloat(formData.value.pax_rate) || 0)
            data.append('kids_pax_rate', formData.value.kids_pax_rate || 0)
            data.append('discounted_rate', parseFloat(formData.value.discounted_rate) || 0)
            data.append('image', formData.value.image)

            response = await axios.post(`/api/packages/${formData.value.id}?_method=PUT`, data, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
        } else {
            const payload = {
                package_name: formData.value.package_name,
                destination: formData.value.destination,
                region: formData.value.region || '',
                description: formData.value.description,
                tour_duration: formData.value.tour_duration,
                itinerary: JSON.stringify(formattedItinerary),
                terms_condition: formData.value.terms_condition,
                exclusions: formData.value.exclusions,
                capacity: parseInt(formData.value.capacity) || 0,
                joint_booking: !!formData.value.joint_booking,
                status: formData.value.status.toLowerCase(),
                pax_rate: parseFloat(formData.value.pax_rate) || 0,
                kids_pax_rate: formData.value.kids_pax_rate || 0,
                discounted_rate: parseFloat(formData.value.discounted_rate) || 0
            }
            response = await axios.put(`/api/packages/${formData.value.id}`, payload)
        }

        toast.success('Package updated successfully!')
        emit('saved', response.data.data)
        closeModal()
    } catch (error) {
        console.error('Error updating package:', error)
        alert('Error updating package. Please check console.')
    }
}

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
        discounted_rate: 0
    }
    itineraryDays.value = [{ id: 1, content: '' }]
}

const handleImageUpload = (event) => {
    const file = event.target.files[0]
    formData.value.image = file
    imagePreview.value = file ? URL.createObjectURL(file) : (formData.value.image_path ? `/storage/${formData.value.image_path}` : null)
}

const removeItineraryDay = (dayId) => {
    if (itineraryDays.value.length <= 1) {
        toast.warning('You must have at least one day in the itinerary.')
        return
    }

    itineraryDays.value = itineraryDays.value.filter(day => day.id !== dayId)

    itineraryDays.value.forEach((day, index) => {
        day.id = index + 1
    })
}

const addItineraryDay = () => {
    const newDayNumber = itineraryDays.value.length + 1
    itineraryDays.value.push({ id: newDayNumber, content: '' })
}
</script>
