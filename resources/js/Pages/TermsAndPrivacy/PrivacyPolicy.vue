<template>
    <Transition enterActiveClass="transition ease-out duration-300" enterFromClass="opacity-0"
        enterToClass="opacity-100" leaveActiveClass="transition ease-in duration-200" leaveFromClass="opacity-100"
        leaveToClass="opacity-0">
        <div v-if="isOpen" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40" @click="close">
        </div>
    </Transition>

    <Transition enterActiveClass="transition ease-out duration-300" enterFromClass="opacity-0 scale-95"
        enterToClass="opacity-100 scale-100" leaveActiveClass="transition ease-in duration-200"
        leaveFromClass="opacity-100 scale-100" leaveToClass="opacity-0 scale-95">
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="close">
            <div class="bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                <div class="bg-gradient-to-r from-[#1E71B8] to-[#008DDA] px-8 py-6 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white tracking-wide">Privacy Policy</h2>
                    <button @click="close"
                        class="text-white/80 hover:text-white transition-all duration-200 p-1 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="overflow-y-auto flex-1 px-8 py-8 space-y-6 text-gray-700 text-sm leading-relaxed">
                    <p class="font-semibold text-[#1E71B8] mb-4">
                        At JE Travel & Tours, we value your privacy and are committed to protecting your personal data.
                        This Privacy Policy explains how we collect, use, and safeguard your information in compliance
                        with the Data Privacy Act of 2012 (Republic Act No. 10173) of the Philippines.
                    </p>

                    <div class="border-l-4 border-[#73BE5D] pl-5">
                        <h3 class="text-lg font-bold text-[#1E71B8] mb-4">1. INFORMATION WE COLLECT</h3>
                        <p class="mb-3">We collect only the information necessary to process your travel bookings and
                            improve our system. This includes:</p>
                        <ul class="space-y-2 ml-2">
                            <li><span class="font-semibold">Personal Information:</span> Full name, contact number,
                                email address, and date of birth.</li>
                            <li><span class="font-semibold">Travel Details:</span> Preferred destinations, travel dates,
                                and names of companion passengers.</li>
                            <li><span class="font-semibold">Payment Information:</span> Transaction references,
                                screenshots of bank transfers/deposits, and payment status recorded in our system. Note:
                                We do not store your raw credit card numbers; specific payment details are processed by
                                our secure third-party payment partners.</li>
                            <li><span class="font-semibold">Identification Documents:</span> Copies of Government-issued
                                IDs or Birth Certificates (for minors) strictly for booking verification and age
                                validation as required by airlines or shipping lines.</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-[#008DDA] pl-5">
                        <h3 class="text-lg font-bold text-[#1E71B8] mb-4">2. HOW WE USE YOUR DATA</h3>
                        <p class="mb-3">Your data is used strictly for the following purposes:</p>
                        <ul class="space-y-2 ml-2">
                            <li><span class="font-semibold">Booking Processing:</span> To secure slots with airlines,
                                hotels, and tour operators on your behalf.</li>
                            <li><span class="font-semibold">Verification:</span> To confirm your identity and validate
                                payments within our system.</li>
                            <li><span class="font-semibold">Communication:</span> To send booking confirmations,
                                vouchers, itinerary updates, and alerts regarding schedule changes or natural disasters.
                            </li>
                            <li><span class="font-semibold">Customer Support:</span> To resolve booking issues or handle
                                refund/rescheduling requests.</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-[#73BE5D] pl-5">
                        <h3 class="text-lg font-bold text-[#1E71B8] mb-4">3. DATA SHARING & THIRD PARTIES</h3>
                        <p class="mb-3">We do not sell your personal data. However, to fulfill your travel request, we
                            must share specific details with:</p>
                        <ul class="space-y-2 ml-2">
                            <li><span class="font-semibold">Third-Party Suppliers:</span> Airlines, Shipping Lines,
                                Hotels, and Van Operators. These entities require passenger manifests to allow you to
                                board or check in.</li>
                            <li><span class="font-semibold">Government Authorities:</span> Only when required by law
                                (e.g., contact tracing, tourism manifests, or coast guard requirements).</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-[#008DDA] pl-5">
                        <h3 class="text-lg font-bold text-[#1E71B8] mb-4">4. DATA SECURITY</h3>
                        <p class="mb-3">We implement strict organizational, physical, and technical security measures to
                            protect your data:</p>
                        <ul class="space-y-2 ml-2">
                            <li><span class="font-semibold">Digital Security:</span> Our TravelKoTo system uses secure
                                servers and encryption to prevent unauthorized access.</li>
                            <li><span class="font-semibold">Access Control:</span> Only authorized JE Travel & Tours
                                staff with a specific role (e.g., Booking Admin) can access your personal records.</li>
                            <li><span class="font-semibold">Record Keeping:</span> Payment records are strictly
                                monitored to ensure accurate crediting of your 20-50% down payments.</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-[#73BE5D] pl-5">
                        <h3 class="text-lg font-bold text-[#1E71B8] mb-4">5. DATA RETENTION</h3>
                        <p class="mb-3">We retain your personal data only for as long as necessary:</p>
                        <ul class="space-y-2 ml-2">
                            <li><span class="font-semibold">Active Bookings:</span> Data is kept active until your trip
                                is completed.</li>
                            <li><span class="font-semibold">Inactive Records:</span> After your trip, basic transaction
                                records are kept for tax, accounting, and legal purposes, after which they are securely
                                deleted or anonymized.</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-[#008DDA] pl-5">
                        <h3 class="text-lg font-bold text-[#1E71B8] mb-4">6. YOUR RIGHTS</h3>
                        <p class="mb-3">Under the Data Privacy Act of 2012, you have the right to:</p>
                        <ul class="space-y-2 ml-2">
                            <li><span class="font-semibold">Access:</span> Request a copy of the personal data we hold
                                about you.</li>
                            <li><span class="font-semibold">Correct:</span> Request correction of any errors in your
                                information.</li>
                            <li><span class="font-semibold">Object:</span> Withhold consent to processing (though this
                                may prevent us from fulfilling your booking).</li>
                            <li><span class="font-semibold">File a Complaint:</span> If you believe your data rights
                                have been violated.</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-[#73BE5D] pl-5">
                        <h3 class="text-lg font-bold text-[#1E71B8] mb-4">7. CONTACT US</h3>
                        <p class="mb-3">For privacy-related concerns or to exercise your rights, please contact our
                            office at:</p>
                        <ul class="space-y-2 ml-2">
                            <li><span class="font-semibold">Email:</span> traveller.laguna@gmail.com |
                                jetravelandtours@gmail.com</li>
                            <li><span class="font-semibold">Office Address:</span> Unit 201 2nd floor, M.B. Aguirre,
                                Brgy. San Jose, City of Biñan, Laguna</li>
                            <li><span class="font-semibold">Phone:</span> +63 939 521 843</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-5 flex justify-end border-t border-gray-200">
                    <button @click="close"
                        class="px-6 py-2.5 bg-gradient-to-r from-[#1E71B8] to-[#008DDA] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

defineProps({
    isOpen: Boolean
})

const emit = defineEmits(['close'])

const close = () => {
    emit('close')
}
</script>