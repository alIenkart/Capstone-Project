<script setup>
import LoadingOverlay from '../../components/LoadingOverlay.vue'
import InquirySuccessModal from '../../components/InquirySuccessModal.vue'
import LandingIndex from './LandingIndex.vue'
import { reactive, computed, ref } from 'vue'
import { api } from '../../api/api'

defineOptions({ layout: LandingIndex })

const service = new api();
const isLoading = ref(false)
const showSuccessModal = ref(false)

const form = reactive({
	name: '',
	email: '',
	destination: '',
	contactNumber: '',
	adults: '',
	children: '',
	seniors: '',
	subject: '',
	message: ''
})

const errors = reactive({
	name: '',
	email: '',
	destination: '',
	contactNumber: '',
	adults: '',
	children: '',
	seniors: '',
	subject: '',
	message: ''
})

const validators = {
	name: (v) => v && String(v).trim().length > 0 ? '' : 'Name is required.',
	email: (v) => v && String(v).includes('@') ? '' : 'Valid email is required.',
	destination: (v) => v && String(v).trim().length > 0 ? '' : 'Destination is required.',
	contactNumber: (v) => /^\d+$/.test(String(v)) ? '' : 'Contact number must be an integer.',
	adults: (v) => /^\d+$/.test(String(v)) ? '' : 'Number of adults must be an integer.',
	children: (v) => /^\d+$/.test(String(v)) ? '' : 'Number of children must be an integer.',
	seniors: (v) => /^\d+$/.test(String(v)) ? '' : 'Number of seniors must be an integer.',
	subject: (v) => v && String(v).trim().length > 0 ? '' : 'Inquiry subject is required.',
	message: (v) => v && String(v).trim().length > 0 ? '' : 'Message is required.'
}

function validateField(key) {
	const msg = validators[key](form[key] ?? '')
	errors[key] = msg
	return !msg
}

function validateAll() {
	return Object.keys(validators).every((k) => validateField(k))
}

function onSubmit(event) {
	event.preventDefault()
	if (!validateAll()) return
	postInquiry()
}

function resetForm() {
	Object.keys(form).forEach(key => {
		form[key] = ''
	})
	Object.keys(errors).forEach(key => {
		errors[key] = ''
	})
}

const hasErrors = computed(() => Object.values(errors).some((m) => m && m.length > 0))

async function postInquiry() {
	isLoading.value = true

	try {
		const payload = {
			name: form.name,
			email: form.email,
			destination: form.destination,
			contact_number: form.contactNumber,
			adults: Number(form.adults),
			children: Number(form.children),
			seniors: Number(form.seniors),
			subject: form.subject,
			message: form.message
		}

		await service.createInquiry(payload)

		await new Promise(resolve => setTimeout(resolve, 500))
		showSuccessModal.value = true
		resetForm()
	} catch (error) {
		console.error('Error submitting inquiry:', error)
	} finally {
		isLoading.value = false
	}
}

function closeSuccessModal() {
  showSuccessModal.value = false
}
</script>

<template>
    <LoadingOverlay 
      :show="isLoading" 
      message="Submitting your Inquiry..."
    />

    <InquirySuccessModal 
      :show="showSuccessModal" 
      @close="closeSuccessModal"
    />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left: Get in Touch -->
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-[#008DDA] text-white text-center py-4">
                    <h2 class="text-xl font-bold tracking-wide">GET IN TOUCH</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Cellphone -->
                        <div class="text-center">
                            <p class="mt-3 font-medium text-[#1E71B8] mb-2">Cellphone</p>
                            <div class="mx-auto h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <!-- Phone Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-gray-700">
                                    <path d="M2.25 6.75c0-2.071 1.679-3.75 3.75-3.75h1.5A2.25 2.25 0 0 1 9.75 5.25v2.06a2.25 2.25 0 0 1-.659 1.591l-1.09 1.09a.75.75 0 0 0-.145.85a12.02 12.02 0 0 0 6.393 6.393a.75.75 0 0 0 .85-.145l1.09-1.09a2.25 2.25 0 0 1 1.591-.659h2.06A2.25 2.25 0 0 1 22.5 18v1.5a3.75 3.75 0 0 1-3.75 3.75h-.75C8.303 23.25.75 15.697.75 6.75v-.75z" />
                                </svg>
                            </div>
                            <p class="mt-2 text-sm text-[#000000]">+639395218437</p>
                        </div>

                        <!-- Email -->
                        <div class="text-center">
                            <p class="mt-3 font-medium text-[#1E71B8] mb-2">Email</p>
                            <div class="mx-auto h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <!-- Mail Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-gray-700">
                                    <path d="M1.5 6.75A2.25 2.25 0 0 1 3.75 4.5h16.5A2.25 2.25 0 0 1 22.5 6.75v10.5A2.25 2.25 0 0 1 20.25 19.5H3.75A2.25 2.25 0 0 1 1.5 17.25V6.75zm2.347-.577a.75.75 0 0 0-.694 1.33l7.5 3.913a.75.75 0 0 0 .694 0l7.5-3.913a.75.75 0 1 0-.694-1.33L12 9.99 3.847 6.173z" />
                                </svg>
                            </div>
                            <div class="mt-2 text-sm text-[#000000]">
                                <p>traveller.laguna<br />@gmail.com</p>
                                <p class="mt-1">jetravelandtours<br />@gmail.com</p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="text-center">
                            <p class="mt-3 font-medium text-[#1E71B8] mb-2">Location</p>
                            <div class="mx-auto h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <!-- Location Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-8 w-8 text-gray-700">
                                    <path fill-rule="evenodd" d="M12 2.25a7.5 7.5 0 0 0-7.5 7.5c0 4.387 4.557 9.53 6.525 11.55a1.5 1.5 0 0 0 2.122 0C15.943 19.28 19.5 14.137 19.5 9.75a7.5 7.5 0 0 0-7.5-7.5zm0 10.5a3 3 0 1 1 0-6a3 3 0 0 1 0 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="mt-2 text-sm text-[#000000]">Unit 201 2nd floor<br />M.B. Aguirre<br />Brgy. San Jose<br />City of Biñan,<br />Laguna</p>
                        </div>
                    </div>

                    <!-- Social row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                        <!-- Telegram -->
                        <div class="text-center">
                            <p class="font-medium text-[#1E71B8] mb-2">Telegram</p>
                            <div class="mx-auto mt-3 h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <!-- Paper Airplane Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-gray-700">
                                    <path d="M2.28 2.28a.75.75 0 0 1 .74-.06l18 7.5a.75.75 0 0 1 0 1.38l-6.87 2.86a1.5 1.5 0 0 0-.84.84l-2.86 6.87a.75.75 0 0 1-1.38 0l-7.5-18a.75.75 0 0 1 .21-.89z" />
                                </svg>
                            </div>
                            <p class="mt-2 text-sm text-[#000000]">+639354924326</p>
                        </div>

                        <!-- Viber -->
                        <div class="text-center">
                            <p class="font-medium text-[#1E71B8] mb-2">Viber</p>
                            <div class="mx-auto mt-3 h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <!-- Phone Bubble Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-gray-700">
                                    <path d="M12 3.75c-4.556 0-8.25 3.29-8.25 7.35c0 1.77.67 3.41 1.8 4.7l-.73 3.03a.75.75 0 0 0 .92.9l3.26-.75c1.03.38 2.15.59 3.3.59c4.556 0 8.25-3.29 8.25-7.35S16.556 3.75 12 3.75zm2.25 4.5a.75.75 0 0 1 1.5 0v3a.75.75 0 0 1-1.5 0v-3zM9 8.25a.75.75 0 0 0-1.5 0v3A.75.75 0 0 0 9 11.25v-3zm2.25 0a.75.75 0 0 0-1.5 0v3a.75.75 0 0 0 1.5 0v-3z" />
                                </svg>
                            </div>
                            <p class="mt-2 text-sm text-[#000000]">+639354924326</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Form -->
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-[#008DDA] text-white text-center py-4">
                    <h2 class="text-xl font-bold tracking-wide">CONTACT US</h2>
                </div>
                <div class="bg-[#008DDA]/90 p-6">
                    <div class="bg-[#008DDA] rounded-lg p-6">
                        <h3 class="text-white text-xl font-semibold">Customer Inquiry Form</h3>
                        <form class="mt-6 space-y-4" @submit="onSubmit" novalidate>
                            <div>
                                <input v-model="form.name" @blur="validateField('name')" type="text" placeholder="Name " class="w-full rounded-md border px-4 py-2 text-sm placeholder-gray-500 text-gray-900 bg-white focus:ring-2" :class="errors.name ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-[#008DDA]'" />
                                <p v-if="errors.name" class="text-red-100 text-xs mt-1">{{ errors.name }}</p>
                            </div>
                            <div>
                                <input v-model="form.email" @blur="validateField('email')" type="email" placeholder="Email " class="w-full rounded-md border px-4 py-2 text-sm placeholder-gray-500 text-gray-900 bg-white focus:ring-2" :class="errors.email ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-[#008DDA]'" />
                                <p v-if="errors.email" class="text-red-100 text-xs mt-1">{{ errors.email }}</p>
                            </div>
                            <div>
                                <input v-model="form.destination" @blur="validateField('destination')" type="text" placeholder="Destination/Trip Name" class="w-full rounded-md border px-4 py-2 text-sm placeholder-gray-500 text-gray-900 bg-white focus:ring-2" :class="errors.destination ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-[#008DDA]'" />
                                <p v-if="errors.destination" class="text-red-100 text-xs mt-1">{{ errors.destination }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <input v-model="form.contactNumber" @blur="validateField('contactNumber')" type="text" placeholder="Contact Number " class="w-full rounded-md border px-4 py-2 text-sm placeholder-gray-500 text-gray-900 bg-white focus:ring-2" :class="errors.contactNumber ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-[#008DDA]'" />
                                    <p v-if="errors.contactNumber" class="text-red-100 text-xs mt-1">{{ errors.contactNumber }}</p>
                                </div>
                                <div>
                                    <input v-model="form.adults" @blur="validateField('adults')" type="number" min="0" placeholder="Number of Adults " class="w-full rounded-md border px-4 py-2 text-sm placeholder-gray-500 text-gray-900 bg-white focus:ring-2" :class="errors.adults ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-[#008DDA]'" />
                                    <p v-if="errors.adults" class="text-red-100 text-xs mt-1">{{ errors.adults }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <input v-model="form.children" @blur="validateField('children')" type="number" min="0" placeholder="Number of Children " class="w-full rounded-md border px-4 py-2 text-sm placeholder-gray-500 text-gray-900 bg-white focus:ring-2" :class="errors.children ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-[#008DDA]'" />
                                    <p v-if="errors.children" class="text-red-100 text-xs mt-1">{{ errors.children }}</p>
                                </div>
                                <div>
                                    <input v-model="form.seniors" @blur="validateField('seniors')" type="number" min="0" placeholder="Number of Seniors " class="w-full rounded-md border px-4 py-2 text-sm placeholder-gray-500 text-gray-900 bg-white focus:ring-2" :class="errors.seniors ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-[#008DDA]'" />
                                    <p v-if="errors.seniors" class="text-red-100 text-xs mt-1">{{ errors.seniors }}</p>
                                </div>
                            </div>

                            <div>
                                <input v-model="form.subject" @blur="validateField('subject')" type="text" placeholder="Inquiry subject" class="w-full rounded-md border px-4 py-2 text-sm placeholder-gray-500 text-gray-900 bg-white focus:ring-2" :class="errors.subject ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-[#008DDA]'" />
                                <p v-if="errors.subject" class="text-red-100 text-xs mt-1">{{ errors.subject }}</p>
                            </div>
                            <div>
                                <textarea v-model="form.message" @blur="validateField('message')" rows="4" placeholder="Message " class="w-full rounded-md border px-4 py-2 text-sm placeholder-gray-500 text-gray-900 bg-white focus:ring-2" :class="errors.message ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-[#008DDA]'" />
                                <p v-if="errors.message" class="text-red-100 text-xs mt-1">{{ errors.message }}</p>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-white text-[#008DDA] font-semibold px-5 py-2 hover:bg-gray-100 transition">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>