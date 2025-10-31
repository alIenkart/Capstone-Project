<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const isActive = (path) => page.url.startsWith(path)

const headerTitle = computed(() => {
  if (page.url.startsWith('/admin/admindashboard')) return 'Dashboard'
  if (page.url.startsWith('/admin/users')) return 'Users'
  if (page.url.startsWith('/admin/packages')) return 'Package Management'
  if (page.url.startsWith('/admin/booking-entries')) return 'Booking Entries'
  if (page.url.startsWith('/admin/payment-confirmation')) return 'Payment Confirmation'
  if (page.url.startsWith('/admin/content-management')) return 'Content Management'
  if (page.url.startsWith('/admin/review-feedback')) return 'Review & Feedback'
  if (page.url.startsWith('/admin/settings')) return 'Settings'
  return 'Admin'
})

const navigationItems = [
  { href: '/admin/admindashboard', label: 'Dashboard' },
  { href: '/admin/users', label: 'Users' },
  { href: '/admin/packages', label: 'Packages' },
  { href: '/admin/booking-entries', label: 'Booking Entries' },
  { href: '/admin/payment-confirmation', label: 'Payment Confirmation' },
  { href: '/admin/content-management', label: 'Content Management' },
  { href: '/admin/review-feedback', label: 'Review & Feedback' },
]
</script>

<template>
  <div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Sidebar -->
    <aside
      class="w-64 bg-gradient-to-b from-[#1E71B8] to-[#1557a0] text-white flex flex-col justify-between fixed left-0 top-0 h-screen z-50 shadow-2xl">
      <!-- Top Section: Logo + Navigation -->
      <div class="flex flex-col">
        <!-- Logo Area -->
        <div class="px-6 py-8 border-b border-white/10">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-white">
                <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" fill="none" />
                <path d="M5 20c0-4 3-6 7-6s7 2 7 6" stroke="currentColor" stroke-width="2" fill="none" />
              </svg>
            </div>
            <span class="text-2xl font-bold tracking-tight">ADMIN</span>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col gap-1 px-3 mt-6">
          <Link v-for="item in navigationItems" :key="item.href" :href="item.href"
            class="group relative flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 hover:text-white transition-all duration-200 hover:bg-white/10"
            :class="isActive(item.href) ? 'bg-[#73BE5D] text-white shadow-lg shadow-[#73BE5D]/30' : ''">
          <span class="font-medium text-base">{{ item.label }}</span>
          <div v-if="isActive(item.href)"
            class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-white rounded-r-full"></div>
          </Link>
        </nav>
      </div>

      <!-- Bottom Section: Settings + Logout -->
      <div class="flex flex-col gap-1 px-3 mb-6">
        <Link href="/admin/settings"
          class="group relative flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 hover:text-white transition-all duration-200 hover:bg-white/10"
          :class="isActive('/admin/settings') ? 'bg-[#73BE5D] text-white shadow-lg shadow-[#73BE5D]/30' : ''">
        <span class="font-medium text-base">Settings</span>
        </Link>
        <Link :href="route('logout')" method="post" as="button"
          class="group flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 hover:text-white transition-all duration-200 hover:bg-red-500/20 w-full text-left mt-2 border border-white/10">
        <span class="font-medium text-base">Logout</span>
        </Link>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col ml-64">
      <!-- Header -->
      <header class="bg-white/80 backdrop-blur-md px-8 py-5 border-b border-gray-200/50 sticky top-0 z-40 shadow-sm">
        <div class="flex items-center justify-between">
          <h2 class="text-2xl font-bold text-gray-800">{{ headerTitle }}</h2>
          <div class="flex items-center gap-4">
          </div>
        </div>
      </header>

      <!-- Main Content Area -->
      <main class="flex-1 overflow-auto p-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<style scoped>
/* Smooth scrollbar styling */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: transparent;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>