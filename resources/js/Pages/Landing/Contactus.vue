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
                        <div class="text-center">
                            <p class="mt-3 font-medium text-[#1E71B8] mb-2">Cellphone</p>
                            <div class="mx-auto h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-gray-700">
                                    <path d="M10.5 18.75a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" />
                                    <path fill-rule="evenodd" d="M8.625.75A3.375 3.375 0 0 0 5.25 4.125v15.75a3.375 3.375 0 0 0 3.375 3.375h6.75a3.375 3.375 0 0 0 3.375-3.375V4.125A3.375 3.375 0 0 0 15.375.75h-6.75ZM7.5 4.125C7.5 3.504 8.004 3 8.625 3H9.75v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V3h1.125c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-6.75A1.125 1.125 0 0 1 7.5 19.875V4.125Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="mt-2 text-sm text-[#000000]">+639395218437</p>
                        </div>

                        <div class="text-center">
                            <p class="mt-3 font-medium text-[#1E71B8] mb-2">Email</p>
                            <div class="mx-auto h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-gray-700">
                                    <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                    <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                </svg>
                            </div>
                            <div class="mt-2 text-sm text-[#000000]">
                                <p>traveller.laguna<br />@gmail.com</p>
                                <p class="mt-1">jetravelandtours<br />@gmail.com</p>
                            </div>
                        </div>

                        <div class="text-center">
                            <p class="mt-3 font-medium text-[#1E71B8] mb-2">Location</p>
                            <div class="mx-auto h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-gray-700">
                                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="mt-2 text-sm text-[#000000]">Unit 201 2nd floor<br />M.B. Aguirre<br />Brgy. San Jose<br />City of Biñan,<br />Laguna</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                        <div class="text-center">
                            <p class="font-medium text-[#1E71B8] mb-2">Telegram</p>
                            <div class="mx-auto mt-3 h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telegram h-8 w-8 text-gray-700" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09"/>
                                </svg>
                            </div>
                            <p class="mt-2 text-sm text-[#000000]">+639354924326</p>
                        </div>

                        <div class="text-center">
                            <p class="font-medium text-[#1E71B8] mb-2">Viber</p>
                            <div class="mx-auto mt-3 h-16 w-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="h-8 w-8 text-gray-700">
                                    <path d="M444.3 49.9c-12.7-11.7-64.1-49-178.7-49.5 0 0-135.1-8.1-200.9 52.3-36.6 36.6-49.5 90.3-50.9 156.8s-3.1 191.1 117 224.9l.1 0-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM458.2 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9 .4-85.7 .4-85.7l0 0C43.4 372.7 49.4 266.6 50.5 211.1s11.6-101 42.6-131.6c55.7-50.5 170.4-43 170.4-43 96.9 .4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9 .6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4 .7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5 .9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9 .1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7 .5 133 51.4 133.7 139.2zM375.2 329l0 .2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8l.2 0c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1 .8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z"/></svg>
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

const validateField = (key) => {
	const msg = validators[key](form[key] ?? '')
	errors[key] = msg
	return !msg
}

const validateAll = () => {
	return Object.keys(validators).every((k) => validateField(k))
}

const onSubmit = (event) => {
	event.preventDefault()
	if (!validateAll()) return
	postInquiry()
}

const resetForm = () => {
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

const closeSuccessModal = () => {
  showSuccessModal.value = false
}
</script>