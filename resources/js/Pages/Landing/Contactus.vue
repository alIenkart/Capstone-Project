<template>
  <LoadingOverlay :show="isLoading" message="Submitting your Inquiry..." />

  <InquirySuccessModal :show="showSuccessModal" @close="closeSuccessModal" />

  <div class="min-h-screen bg-gradient-to-b from-white to-blue-50 py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h1 class="text-5xl md:text-6xl font-bold text-[#1E71B8] mb-4">
          GET IN TOUCH
        </h1>
        <p class="text-lg text-gray-600">We'd love to hear from you. Send us your inquiry today!</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
        <div class="space-y-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
              class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-[#1E71B8]/30 transform hover:-translate-y-2 p-6 flex flex-col items-center text-center">
              <div
                class="absolute inset-0 bg-gradient-to-br from-[#1E71B8]/5 to-[#008DDA]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
              </div>
              <div class="relative z-10 w-full">
                <div
                  class="mx-auto h-20 w-20 rounded-full bg-gradient-to-br from-[#008DDA]/20 to-[#73BE5D]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="h-10 w-10 text-[#008DDA]">
                    <path d="M10.5 18.75a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" />
                    <path fill-rule="evenodd"
                      d="M8.625.75A3.375 3.375 0 0 0 5.25 4.125v15.75a3.375 3.375 0 0 0 3.375 3.375h6.75a3.375 3.375 0 0 0 3.375-3.375V4.125A3.375 3.375 0 0 0 15.375.75h-6.75ZM7.5 4.125C7.5 3.504 8.004 3 8.625 3H9.75v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V3h1.125c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-6.75A1.125 1.125 0 0 1 7.5 19.875V4.125Z"
                      clip-rule="evenodd" />
                  </svg>
                </div>
                <h3 class="font-bold text-[#1E71B8] text-lg mb-3 group-hover:text-[#008DDA] transition-colors">Cellphone
                </h3>
                <p class="text-gray-700 font-semibold">+639395218437</p>
              </div>
            </div>

            <div
              class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-[#1E71B8]/30 transform hover:-translate-y-2 p-6 flex flex-col items-center text-center">
              <div
                class="absolute inset-0 bg-gradient-to-br from-[#1E71B8]/5 to-[#008DDA]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
              </div>
              <div class="relative z-10 w-full">
                <div
                  class="mx-auto h-20 w-20 rounded-full bg-gradient-to-br from-[#008DDA]/20 to-[#73BE5D]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="h-10 w-10 text-[#008DDA]">
                    <path
                      d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                    <path
                      d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                  </svg>
                </div>
                <h3 class="font-bold text-[#1E71B8] text-lg mb-3 group-hover:text-[#008DDA] transition-colors">Email
                </h3>
                <p class="text-gray-700 font-semibold text-sm">traveller.laguna@gmail.com</p>
                <p class="text-gray-700 font-semibold text-sm mt-1">jetravelandtours@gmail.com</p>
              </div>
            </div>

            <div
              class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-[#1E71B8]/30 transform hover:-translate-y-2 p-6 flex flex-col items-center text-center md:col-span-2">
              <div
                class="absolute inset-0 bg-gradient-to-br from-[#1E71B8]/5 to-[#008DDA]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
              </div>
              <div class="relative z-10 w-full">
                <div
                  class="mx-auto h-20 w-20 rounded-full bg-gradient-to-br from-[#008DDA]/20 to-[#73BE5D]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="h-10 w-10 text-[#008DDA]">
                    <path fill-rule="evenodd"
                      d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                      clip-rule="evenodd" />
                  </svg>
                </div>
                <h3 class="font-bold text-[#1E71B8] text-lg mb-3 group-hover:text-[#008DDA] transition-colors">Location
                </h3>
                <p class="text-gray-700 font-semibold text-sm leading-relaxed">Unit 201 2nd floor, M.B. Aguirre, Brgy.
                  San Jose, City of Biñan, Laguna</p>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6">
            <div
              class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-[#1E71B8]/30 transform hover:-translate-y-2 p-6 flex flex-col items-center text-center">
              <div
                class="absolute inset-0 bg-gradient-to-br from-[#1E71B8]/5 to-[#008DDA]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
              </div>
              <div class="relative z-10 w-full">
                <div
                  class="mx-auto h-20 w-20 rounded-full bg-gradient-to-br from-[#008DDA]/20 to-[#73BE5D]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-telegram h-10 w-10 text-[#008DDA]" viewBox="0 0 16 16">
                    <path
                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09" />
                  </svg>
                </div>
                <h3 class="font-bold text-[#1E71B8] text-lg mb-3 group-hover:text-[#008DDA] transition-colors">Telegram
                </h3>
                <p class="text-gray-700 font-semibold text-sm">+639354924326</p>
              </div>
            </div>

            <div
              class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-[#1E71B8]/30 transform hover:-translate-y-2 p-6 flex flex-col items-center text-center">
              <div
                class="absolute inset-0 bg-gradient-to-br from-[#1E71B8]/5 to-[#008DDA]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
              </div>
              <div class="relative z-10 w-full">
                <div
                  class="mx-auto h-20 w-20 rounded-full bg-gradient-to-br from-[#008DDA]/20 to-[#73BE5D]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"
                    class="h-10 w-10 text-[#008DDA]">
                    <path
                      d="M444.3 49.9c-12.7-11.7-64.1-49-178.7-49.5 0 0-135.1-8.1-200.9 52.3-36.6 36.6-49.5 90.3-50.9 156.8s-3.1 191.1 117 224.9l.1 0-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM458.2 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9 .4-85.7 .4-85.7l0 0C43.4 372.7 49.4 266.6 50.5 211.1s11.6-101 42.6-131.6c55.7-50.5 170.4-43 170.4-43 96.9 .4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9 .6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4 .7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5 .9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9 .1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7 .5 133 51.4 133.7 139.2zM375.2 329l0 .2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8l.2 0c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1 .8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z" />
                  </svg>
                </div>
                <h3 class="font-bold text-[#1E71B8] text-lg mb-3 group-hover:text-[#008DDA] transition-colors">Viber
                </h3>
                <p class="text-gray-700 font-semibold text-sm">+639354924326</p>
              </div>
            </div>
          </div>
        </div>

        <div
          class="group relative overflow-hidden rounded-3xl bg-white shadow-2xl border border-gray-100 hover:border-[#1E71B8]/30 transition-all duration-500">
          <div
            class="absolute inset-0 bg-gradient-to-br from-[#1E71B8]/5 to-[#008DDA]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
          </div>

          <div class="bg-gradient-to-r from-[#1E71B8] to-[#008DDA] px-8 py-6">
            <h2 class="text-2xl font-bold text-white">Customer Inquiry Form</h2>
            <p class="text-blue-100 text-sm mt-1">Fill out the form below and we'll get back to you soon</p>
          </div>

          <form class="relative z-10 p-8 space-y-5" @submit="onSubmit" novalidate>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <input v-model="form.name" @blur="validateField('name')" type="text" placeholder="Full Name"
                  class="w-full rounded-lg border-2 px-4 py-3 text-sm transition-all duration-300 focus:outline-none"
                  :class="errors.name
                      ? 'border-red-500 focus:ring-2 focus:ring-red-500/50'
                      : 'border-gray-200 focus:border-[#008DDA] focus:ring-2 focus:ring-[#008DDA]/20'
                    " />
                <p v-if="errors.name" class="text-red-500 text-xs mt-1.5 font-medium">{{ errors.name }}</p>
              </div>

              <div>
                <input v-model="form.email" @blur="validateField('email')" type="email" placeholder="Email Address"
                  class="w-full rounded-lg border-2 px-4 py-3 text-sm transition-all duration-300 focus:outline-none"
                  :class="errors.email
                      ? 'border-red-500 focus:ring-2 focus:ring-red-500/50'
                      : 'border-gray-200 focus:border-[#008DDA] focus:ring-2 focus:ring-[#008DDA]/20'
                    " />
                <p v-if="errors.email" class="text-red-500 text-xs mt-1.5 font-medium">{{ errors.email }}</p>
              </div>
            </div>

            <div>
              <input v-model="form.destination" @blur="validateField('destination')" type="text"
                placeholder="Destination / Trip Name"
                class="w-full rounded-lg border-2 px-4 py-3 text-sm transition-all duration-300 focus:outline-none"
                :class="errors.destination
                    ? 'border-red-500 focus:ring-2 focus:ring-red-500/50'
                    : 'border-gray-200 focus:border-[#008DDA] focus:ring-2 focus:ring-[#008DDA]/20'
                  " />
              <p v-if="errors.destination" class="text-red-500 text-xs mt-1.5 font-medium">{{ errors.destination }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <input v-model="form.contactNumber" @input="
                  form.contactNumber = form.contactNumber
                    .replace(/[^0-9]/g, '')
                    .slice(0, 11)
                  " @blur="validateField('contactNumber')" type="text" inputmode="numeric" pattern="[0-9]*"
                  placeholder="Contact Number"
                  class="w-full rounded-lg border-2 px-4 py-3 text-sm transition-all duration-300 focus:outline-none"
                  :class="errors.contactNumber
                      ? 'border-red-500 focus:ring-2 focus:ring-red-500/50'
                      : 'border-gray-200 focus:border-[#008DDA] focus:ring-2 focus:ring-[#008DDA]/20'
                    " />
                <p v-if="errors.contactNumber" class="text-red-500 text-xs mt-1.5 font-medium">
                  {{ errors.contactNumber }}
                </p>
              </div>

              <div>
                <input v-model="form.subject" @blur="validateField('subject')" type="text" placeholder="Inquiry Subject"
                  class="w-full rounded-lg border-2 px-4 py-3 text-sm transition-all duration-300 focus:outline-none"
                  :class="errors.subject
                      ? 'border-red-500 focus:ring-2 focus:ring-red-500/50'
                      : 'border-gray-200 focus:border-[#008DDA] focus:ring-2 focus:ring-[#008DDA]/20'
                    " />
                <p v-if="errors.subject" class="text-red-500 text-xs mt-1.5 font-medium">{{ errors.subject }}</p>
              </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
              <div>
                <label class="text-xs font-semibold text-gray-700 block mb-2">Adults</label>
                <input v-model="form.adults" @blur="validateField('adults')" type="number" min="0" placeholder="0"
                  class="w-full rounded-lg border-2 px-4 py-3 text-sm transition-all duration-300 focus:outline-none"
                  :class="errors.adults
                      ? 'border-red-500 focus:ring-2 focus:ring-red-500/50'
                      : 'border-gray-200 focus:border-[#008DDA] focus:ring-2 focus:ring-[#008DDA]/20'
                    " />
                <p v-if="errors.adults" class="text-red-500 text-xs mt-1.5 font-medium">{{ errors.adults }}</p>
              </div>

              <div>
                <label class="text-xs font-semibold text-gray-700 block mb-2">Children</label>
                <input v-model="form.children" @blur="validateField('children')" type="number" min="0" placeholder="0"
                  class="w-full rounded-lg border-2 px-4 py-3 text-sm transition-all duration-300 focus:outline-none"
                  :class="errors.children
                      ? 'border-red-500 focus:ring-2 focus:ring-red-500/50'
                      : 'border-gray-200 focus:border-[#008DDA] focus:ring-2 focus:ring-[#008DDA]/20'
                    " />
                <p v-if="errors.children" class="text-red-500 text-xs mt-1.5 font-medium">{{ errors.children }}</p>
              </div>

              <div>
                <label class="text-xs font-semibold text-gray-700 block mb-2">Seniors</label>
                <input v-model="form.seniors" @blur="validateField('seniors')" type="number" min="0" placeholder="0"
                  class="w-full rounded-lg border-2 px-4 py-3 text-sm transition-all duration-300 focus:outline-none"
                  :class="errors.seniors
                      ? 'border-red-500 focus:ring-2 focus:ring-red-500/50'
                      : 'border-gray-200 focus:border-[#008DDA] focus:ring-2 focus:ring-[#008DDA]/20'
                    " />
                <p v-if="errors.seniors" class="text-red-500 text-xs mt-1.5 font-medium">{{ errors.seniors }}</p>
              </div>
            </div>

            <div>
              <textarea v-model="form.message" @blur="validateField('message')" rows="5" placeholder="Your Message"
                class="w-full rounded-lg border-2 px-4 py-3 text-sm transition-all duration-300 focus:outline-none resize-none"
                :class="errors.message
                    ? 'border-red-500 focus:ring-2 focus:ring-red-500/50'
                    : 'border-gray-200 focus:border-[#008DDA] focus:ring-2 focus:ring-[#008DDA]/20'
                  " />
              <p v-if="errors.message" class="text-red-500 text-xs mt-1.5 font-medium">{{ errors.message }}</p>
            </div>

            <button type="submit"
              class="w-full bg-gradient-to-r from-[#008DDA] to-[#73BE5D] hover:from-[#1E71B8] hover:to-[#008DDA] text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path
                  d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z" />
              </svg>
              Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="overflow-hidden rounded-2xl shadow-lg mt-6">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d442.0685093738609!2d121.08241071926787!3d14.338545201625292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d9d72a3f94ed%3A0x5a4b87bcc1ffb340!2sJE%20Travel%20%26%20Tours!5e0!3m2!1sen!2sph!4v1762866562418!5m2!1sen!2sph"
      width="1900" height="450" style="border:0; padding: 0px 10px 0px 10px;" allowfullscreen="" loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  <Footer></Footer>
</template>

<script setup>
import LoadingOverlay from "../../components/LoadingOverlay.vue";
import InquirySuccessModal from "../../components/InquirySuccessModal.vue";
import LandingIndex from "./LandingIndex.vue";
import { reactive, computed, ref } from "vue";
import { api } from "../../api/api";
import { usePage, router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import Footer from "./Footer.vue";

defineOptions({ layout: LandingIndex });

const service = new api();
const page = usePage();
const toast = useToast();
const isLoading = ref(false);
const showSuccessModal = ref(false);

const form = reactive({
  name: "",
  email: "",
  destination: "",
  contactNumber: "",
  adults: "",
  children: "",
  seniors: "",
  subject: "",
  message: "",
});

const errors = reactive({
  name: "",
  email: "",
  destination: "",
  contactNumber: "",
  adults: "",
  children: "",
  seniors: "",
  subject: "",
  message: "",
});

const validators = {
  name: (v) => (v && String(v).trim().length > 0 ? "" : "Name is required."),
  email: (v) =>
    v && String(v).includes("@") ? "" : "Valid email is required.",
  destination: (v) =>
    v && String(v).trim().length > 0 ? "" : "Destination is required.",
  contactNumber: (v) =>
    /^\d+$/.test(String(v)) ? "" : "Contact number must be 11 digit number.",
  adults: (v) =>
    /^\d+$/.test(String(v)) ? "" : "Number of adults must be an integer.",
  children: (v) =>
    /^\d+$/.test(String(v)) ? "" : "Number of children must be an integer.",
  seniors: (v) =>
    /^\d+$/.test(String(v)) ? "" : "Number of seniors must be an integer.",
  subject: (v) =>
    v && String(v).trim().length > 0 ? "" : "Inquiry subject is required.",
  message: (v) =>
    v && String(v).trim().length > 0 ? "" : "Message is required.",
};

const validateField = (key) => {
  const msg = validators[key](form[key] ?? "");
  errors[key] = msg;
  return !msg;
};

const validateAll = () => {
  return Object.keys(validators).every((k) => validateField(k));
};

const onSubmit = (event) => {
  event.preventDefault();
  if (!validateAll()) return;
  postInquiry();
};

const resetForm = () => {
  Object.keys(form).forEach((key) => {
    form[key] = "";
  });
  Object.keys(errors).forEach((key) => {
    errors[key] = "";
  });
};

const hasErrors = computed(() =>
  Object.values(errors).some((m) => m && m.length > 0)
);

async function postInquiry() {
  if (!page.props.auth.user) {
    toast.warning("You need to login/register first");
    router.visit(route("login"));
    return;
  }

  isLoading.value = true;

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
      message: form.message,
    };

    await service.createInquiry(payload);

    await new Promise((resolve) => setTimeout(resolve, 500));
    showSuccessModal.value = true;
    resetForm();
  } catch (error) {
    console.error("Error submitting inquiry:", error);
  } finally {
    isLoading.value = false;
  }
}

const closeSuccessModal = () => {
  showSuccessModal.value = false;
};
</script>
