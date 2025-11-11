<template>
  <footer class="bg-gradient-to-br from-[#1E71B8] to-[#008DDA] border-t border-[#0D5FA8]/30 mt-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
        <div>
          <h3 class="text-white text-2xl font-extrabold tracking-wide mb-8">JE TRAVEL & TOURS</h3>
          <ul class="space-y-5">
            <li>
              <Link href="/aboutus"
                class="text-blue-100 hover:text-[#73BE5D] text-sm tracking-wide transition-all duration-300 relative group font-semibold">
              About Us
              <span
                class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-[#73BE5D] to-[#008DDA] group-hover:w-full transition-all duration-300 rounded-full"></span>
              </Link>
            </li>
            <li>
              <button @click="showUnderConstruction"
                class="text-blue-100 hover:text-[#73BE5D] text-sm tracking-wide transition-all duration-300 relative group font-semibold text-left">
                Piracy Policy
                <span
                  class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-[#73BE5D] to-[#008DDA] group-hover:w-full transition-all duration-300 rounded-full"></span>
              </button>
            </li>
            <li>
              <button @click="isModalOpen = true"
                class="text-blue-100 hover:text-[#73BE5D] text-sm tracking-wide transition-all duration-300 relative group font-semibold text-left">
                Terms & Conditions
                <span
                  class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-[#73BE5D] to-[#008DDA] group-hover:w-full transition-all duration-300 rounded-full"></span>
              </button>
            </li>
          </ul>
        </div>

        <div>
          <h3 class="text-white text-2xl font-extrabold tracking-wide mb-8">NEED HELP?</h3>
          <ul class="space-y-5">
            <li>
              <Link href="/contactus"
                class="text-blue-100 hover:text-[#73BE5D] text-sm tracking-wide transition-all duration-300 relative group font-semibold">
              Contact Us
              <span
                class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-[#73BE5D] to-[#008DDA] group-hover:w-full transition-all duration-300 rounded-full"></span>
              </Link>
            </li>
          </ul>
        </div>

        <div>
          <h3 class="text-white text-2xl font-extrabold tracking-wide mb-6">STAY CONNECTED</h3>
          <div class="flex gap-5 ml-1">
            <a 
              href="https://www.facebook.com/Djjjtravelandtour"
              target="_blank"
              class="text-blue-100 hover:text-[#73BE5D] transition-all duration-300 transform hover:scale-110"
              title="Instagram">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-facebook w-7 h-7"
                viewBox="0 0 16 16">
                <path
                  d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
              </svg>
            </a>
            <a @click="showNoLinks"
              class="text-blue-100 hover:text-[#73BE5D] transition-all duration-300 transform hover:scale-110"
              title="Facebook">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-instagram w-7 h-7"
                viewBox="0 0 16 16">
                <path
                  d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
              </svg>
            </a>
            <a @click="showNoLinks"
              class="text-blue-100 hover:text-[#73BE5D] transition-all duration-300 transform hover:scale-110"
              title="Tiktok">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-twitter-x w-7 h-7"
                viewBox="0 0 16 16">
                <path
                  d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
              </svg>
            </a>
            <a @click="showNoLinks"
              class="text-blue-100 hover:text-[#73BE5D] transition-all duration-300 transform hover:scale-110"
              title="X">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-tiktok w-7 h-7"
                viewBox="0 0 16 16">
                <path
                  d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z" />
              </svg>
            </a>
          </div>
        </div>
      </div>

      <div class="h-px bg-gradient-to-r from-transparent via-blue-200/30 to-transparent mb-8"></div>

      <div class="text-center">
        <p class="text-blue-100 text-sm font-medium tracking-wide">
          © 2025 JE Travel & Tours. All rights reserved.
        </p>
      </div>
    </div>

    <Transition enterActiveClass="transition ease-out duration-300" enterFromClass="opacity-0"
      enterToClass="opacity-100" leaveActiveClass="transition ease-in duration-200" leaveFromClass="opacity-100"
      leaveToClass="opacity-0">
      <div v-if="isModalOpen" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40" @click="isModalOpen = false">
      </div>
    </Transition>

    <Transition enterActiveClass="transition ease-out duration-300" enterFromClass="opacity-0 scale-95"
      enterToClass="opacity-100 scale-100" leaveActiveClass="transition ease-in duration-200"
      leaveFromClass="opacity-100 scale-100" leaveToClass="opacity-0 scale-95">
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @click.self="isModalOpen = false">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
          <div class="bg-gradient-to-r from-[#1E71B8] to-[#008DDA] px-8 py-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-white tracking-wide">Terms & Conditions</h2>
            <button @click="isModalOpen = false"
              class="text-white/80 hover:text-white transition-all duration-200 p-1 hover:scale-110">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="overflow-y-auto flex-1 px-8 py-8 space-y-8">
            <p class="text-gray-700 text-sm leading-relaxed">
              These Terms and Conditions govern the use of services provided by
              <span class="font-semibold text-[#1E71B8]">Traveller Laguna</span>. By confirming booking with our agency,
              customers must consider the terms outlined below.
            </p>

            <div class="space-y-8">
              <div class="border-l-4 border-[#73BE5D] pl-5">
                <h3 class="text-lg font-bold text-[#1E71B8] mb-3 flex items-center gap-2">
                  <span class="w-2 h-2 bg-[#73BE5D] rounded-full"></span>
                  Booking and Reservations Confirmation
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                  All bookings require a confirmed down payment to secure reservations. Prices are subject to change
                  until
                  full payment is received and confirmed. Full payment must be settled on or before the specified due
                  date.
                </p>
              </div>

              <div class="border-l-4 border-[#008DDA] pl-5">
                <h3 class="text-lg font-bold text-[#1E71B8] mb-3 flex items-center gap-2">
                  <span class="w-2 h-2 bg-[#008DDA] rounded-full"></span>
                  Cancellation and Refund Policy
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                  Cancellations must be submitted before the specified booking date via email or other contact channels.
                  Refunds follow the policies of third-party providers (airlines, hotels, etc.). Non-refundable fees and
                  penalties may apply.
                </p>
              </div>

              <div class="border-l-4 border-[#73BE5D] pl-5">
                <h3 class="text-lg font-bold text-[#1E71B8] mb-3 flex items-center gap-2">
                  <span class="w-2 h-2 bg-[#73BE5D] rounded-full"></span>
                  Changes and Amendments
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                  Traveller Laguna reserves the right to modify itineraries due to unforeseen circumstances. Clients
                  will
                  be notified of any changes, and reasonable alternatives will be provided. Any client-requested changes
                  after booking may incur additional charges.
                </p>
              </div>
            </div>
          </div>

          <div class="bg-gray-50 px-8 py-5 flex justify-end border-t border-gray-200">
            <button @click="isModalOpen = false"
              class="px-6 py-2.5 bg-gradient-to-r from-[#1E71B8] to-[#008DDA] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
              Close
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </footer>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from "@inertiajs/vue3";
import { useToast } from 'vue-toastification'

const isModalOpen = ref(false)
const toast = useToast()

const showUnderConstruction = () => {
  toast.info('This page is under construction. We\'ll be back soon!')
}

const showNoLinks = () => {
  toast.info('No link is currently available.')
}
</script>
