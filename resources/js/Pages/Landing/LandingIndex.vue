<template>
  <div class="min-h-screen flex flex-col">
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
      <div class="flex items-center justify-between px-8 h-20">
        <div class="flex-shrink-0">
          <img src="/storage/logo/Logo.png" alt="JE Travel & Tours" class="h-12" />
        </div>

        <div class="flex items-center gap-20 flex-1 justify-center">
          <Link href="/" class="text-blue-600 font-medium text-m uppercase hover:text-green-500 transition">Home</Link>
          <Link href="/destination" class="text-blue-600 font-medium text-m uppercase hover:text-green-500 transition">Destinations</Link>
          <Link href="/blogs" class="text-blue-600 font-medium text-m uppercase hover:text-green-500 transition">Travel Blogs</Link>
          <Link href="/aboutus" class="text-blue-600 font-medium text-m uppercase hover:text-green-500 transition">About Us</Link>
          <Link href="/contactus" class="text-blue-600 font-medium text-m uppercase hover:text-green-500 transition">Contact Us</Link>
        </div>

        <div v-if="user" class="flex items-center gap-6">
          <div class="relative" ref="notificationRef">
            <button
              @click="showNotifications = !showNotifications"
              class="relative p-2 text-blue-600 hover:bg-gray-100 rounded-full transition"
            >
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
              </svg>
              <span v-if="unreadCount > 0" class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                {{ unreadCount }}
              </span>
            </button>

            <div v-if="showNotifications" class="absolute right-0 mt-3 w-96 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-white font-semibold text-lg">Notifications</h3>
              </div>

              <div class="max-h-96 overflow-y-auto">
                <div v-if="notifications.length > 0">
                  <div
                    v-for="notif in notifications"
                    :key="notif.id"
                    @click="notif.read = true"
                    class="border-b border-gray-100 hover:bg-gray-50 transition cursor-pointer"
                  >
                    <div v-if="notif.type === 'booking'" class="p-4 bg-white hover:bg-gray-50">
                      <div class="border-2 border-gray-300 rounded-lg p-4">
                        <div class="flex items-start justify-between mb-3">
                          <h4 class="font-bold text-gray-900 text-sm">{{ notif.title }}</h4>
                          <div class="flex items-center gap-2" v-if="!notif.read">
                            <span class="text-xs font-mono bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ notif.bookingId }}</span>
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                          </div>
                          <div class="flex items-center gap-2" v-else>
                            <span class="text-xs font-mono bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ notif.bookingId }}</span>
                          </div>
                        </div>
                        <p class="text-gray-700 text-sm leading-relaxed mb-3">
                          {{ notif.message }}
                        </p>
                        <p class="text-gray-500 text-xs">{{ notif.time }}</p>
                      </div>
                    </div>
                    <div v-else class="px-6 py-4">
                      <div class="flex items-start gap-3">
                        <div
                          class="w-2 h-2 rounded-full mt-2 flex-shrink-0"
                          :class="notif.read ? 'bg-gray-300' : 'bg-blue-600'"
                        ></div>
                        <div class="flex-1 min-w-0">
                          <p class="text-gray-800 font-medium text-sm leading-relaxed">
                            {{ notif.message }}
                          </p>
                          <p class="text-gray-500 text-xs mt-1">{{ notif.time }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else class="px-6 py-12 text-center">
                  <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mx-auto text-gray-300 mb-2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                  </svg>
                  <p class="text-gray-500 text-sm">No notifications</p>
                </div>
              </div>

              <div class="bg-gray-50 px-6 py-3 text-center border-t border-gray-100">
                <button @click="markAllAsRead" class="text-blue-600 text-sm font-medium hover:text-blue-700 transition">
                  Mark All as Read
                </button>
              </div>
            </div>
          </div>

          <div class="relative" ref="dropdownRef">
            <button
              @click="showDropdown = !showDropdown"
              class="p-2 text-blue-600 hover:bg-gray-100 rounded-full transition border-2 border-blue-600"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
            </button>

            <div v-if="showDropdown" class="absolute right-0 mt-3 w-48 bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
              <Link href="/profile" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition border-b border-gray-100">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-600">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                  <circle cx="12" cy="7" r="4"/>
                </svg>
                <span class="text-sm font-medium">Profile</span>
              </Link>
              <Link href="/yourbookings" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition border-b border-gray-100">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-600">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                  <line x1="16" y1="2" x2="16" y2="6"/>
                  <line x1="8" y1="2" x2="8" y2="6"/>
                  <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <span class="text-sm font-medium">Your Bookings</span>
              </Link>
              <Link :href="route('logout')" method="post" as="button" class="w-full flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-red-500">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                  <polyline points="16 17 21 12 16 7"/>
                  <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                <span class="text-sm font-medium">Logout</span>
              </Link>
            </div>
          </div>
        </div>

        <div v-else>
          <Link href="/login" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition text-sm">
            Login
          </Link>
        </div>
      </div>
    </nav>

    <main class="flex-1 bg-white">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const showDropdown = ref(false)
const showNotifications = ref(false)
const page = usePage()
const user = computed(() => page.props.auth?.user)
const dropdownRef = ref(null)
const notificationRef = ref(null)

const notifications = ref([
  { 
    id: 1, 
    title: 'Your Booking is Confirmed!',
    message: 'Your booking for Baguio Tour - 3 Days on January 2, 2025 has been confirmed. Please proceed with the payment of ₱ XXXX using the QR code provided to in the My Booking section. Make sure to upload your payment receipt for verification. Thank you!',
    bookingId: 'BT0125',
    time: 'March 2, 2025 at 1:15 pm',
    read: false,
    type: 'booking'
  },
  { 
    id: 2, 
    title: 'Your Booking is Confirmed!',
    message: 'Your booking for Baguio Tour - 3 Days on January 2, 2025 has been confirmed. Please proceed with the payment of ₱ XXXX using the QR code provided to in the My Booking section. Make sure to upload your payment receipt for verification. Thank you!',
    bookingId: 'BT0125',
    time: 'March 2, 2025 at 1:15 pm',
    read: false,
    type: 'booking'
  },
  { 
    id: 3, 
    title: 'Your Booking is Confirmed!',
    message: 'Your booking for Baguio Tour - 3 Days on January 2, 2025 has been confirmed. Please proceed with the payment of ₱ XXXX using the QR code provided to in the My Booking section. Make sure to upload your payment receipt for verification. Thank you!',
    bookingId: 'BT0125',
    time: 'March 2, 2025 at 1:15 pm',
    read: false,
    type: 'booking'
  },
  { 
    id: 4, 
    title: 'Your Booking is Confirmed!',
    message: 'Your booking for Baguio Tour - 3 Days on January 2, 2025 has been confirmed. Please proceed with the payment of ₱ XXXX using the QR code provided to in the My Booking section. Make sure to upload your payment receipt for verification. Thank you!',
    bookingId: 'BT0125',
    time: 'March 2, 2025 at 1:15 pm',
    read: false,
    type: 'booking'
  },
])

const unreadCount = computed(() => notifications.value.filter(n => !n.read).length)

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    showDropdown.value = false
  }
  if (notificationRef.value && !notificationRef.value.contains(event.target)) {
    showNotifications.value = false
  }
}

onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside)
})

router.on('navigate', () => {
  showDropdown.value = false
  showNotifications.value = false
})

const markAllAsRead = () => {
  notifications.value.forEach(notif => {
    notif.read = true
  })
}
</script>