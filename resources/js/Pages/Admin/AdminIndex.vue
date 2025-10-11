<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const isActive = (path) => page.url.startsWith(path) ? 'active-admin-link' : ''

const headerTitle = computed(() => {
  if (page.url.startsWith('/admin/admindashboard')) return 'Dashboard'
  if (page.url.startsWith('/admin/users')) return 'Users'
  if (page.url.startsWith('/admin/packages')) return 'Packages'
  if (page.url.startsWith('/admin/booking-entries')) return 'Booking Entries'
  if (page.url.startsWith('/admin/payment-confirmation')) return 'Payment Confirmation'
  if (page.url.startsWith('/admin/content-management')) return 'Content Management'
  if (page.url.startsWith('/admin/review-feedback')) return 'Review & Feedback'
  if (page.url.startsWith('/admin/settings')) return 'Settings'
  return 'Admin'
})
</script>

<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-56 bg-[#1E71B8] text-white flex flex-col justify-between fixed left-0 top-0 h-screen">
      <!-- Top Section: Logo + Navigation -->
      <div class="flex flex-col">
        <div class="flex items-center px-4 py-6 border-b border-[#73BE5D]">
          <span class="mr-3">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="8" r="6" stroke="#fff" stroke-width="2" fill="none"/>
              <path d="M4 22c0-5 4-8 8-8s8 3 8 8" stroke="#fff" stroke-width="2" fill="none"/>
            </svg>
          </span>
          <span class="text-xl font-bold tracking-wider">ADMIN</span>
        </div>
        <nav class="flex flex-col gap-0.5 mt-4">
          <Link href="/admin/admindashboard" class="flex items-center px-6 py-3.5 text-white hover:bg-[#73BE5D] transition-colors border-l-4 border-transparent hover:border-[#73BE5D]" :class="isActive('/admin/admindashboard') ? 'bg-[#73BE5D] border-[#73BE5D]' : ''">Dashboard</Link>
          <Link href="/admin/users" class="flex items-center px-6 py-3.5 text-white hover:bg-[#73BE5D] transition-colors border-l-4 border-transparent hover:border-[#73BE5D]" :class="isActive('/admin/users') ? 'bg-[#73BE5D] border-[#73BE5D]' : ''">Users</Link>
          <Link href="/admin/packages" class="flex items-center px-6 py-3.5 text-white hover:bg-[#73BE5D] transition-colors border-l-4 border-transparent hover:border-[#73BE5D]" :class="isActive('/admin/packages') ? 'bg-[#73BE5D] border-[#73BE5D]' : ''">Packages</Link>
          <Link href="/admin/booking-entries" class="flex items-center px-6 py-3.5 text-white hover:bg-[#73BE5D] transition-colors border-l-4 border-transparent hover:border-[#73BE5D]" :class="isActive('/admin/booking-entries') ? 'bg-[#73BE5D] border-[#73BE5D]' : ''">Booking Entries</Link>
          <Link href="/admin/payment-confirmation" class="flex items-center px-6 py-3.5 text-white hover:bg-[#73BE5D] transition-colors border-l-4 border-transparent hover:border-[#73BE5D]" :class="isActive('/admin/payment-confirmation') ? 'bg-[#73BE5D] border-[#73BE5D]' : ''">Payment Confirmation</Link>
          <Link href="/admin/content-management" class="flex items-center px-6 py-3.5 text-white hover:bg-[#73BE5D] transition-colors border-l-4 border-transparent hover:border-[#73BE5D]" :class="isActive('/admin/content-management') ? 'bg-[#73BE5D] border-[#73BE5D]' : ''">Content Management</Link>
          <Link href="/admin/review-feedback" class="flex items-center px-6 py-3.5 text-white hover:bg-[#73BE5D] transition-colors border-l-4 border-transparent hover:border-[#73BE5D]" :class="isActive('/admin/review-feedback') ? 'bg-[#73BE5D] border-[#73BE5D]' : ''">Review & Feedback</Link>
        </nav>
      </div>
      
      <!-- Bottom Section: Settings + Logout -->
      <div class="flex flex-col gap-0.5 mb-6">
        <Link href="/admin/settings" class="flex items-center px-6 py-3.5 text-white hover:bg-[#73BE5D] transition-colors border-l-4 border-transparent hover:border-[#73BE5D]">
          <span class="mr-2 text-lg">⚙</span> Settings
        </Link>
        <Link :href="route('logout')" method="post" as="button" class="flex items-center px-6 py-3.5 text-white hover:bg-[#73BE5D] transition-colors border-l-4 border-transparent hover:border-[#73BE5D]">
          <span class="mr-2 text-lg">↶</span> Logout
        </Link>
      </div>
    </aside>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col ml-56">
      <header class="bg-gray-200 px-8 py-6 border-b border-gray-300">
        <h2 class="text-xl font-semibold text-[#1E71B8] text-center tracking-wide">{{ headerTitle }}</h2>
      </header>
      <main class="flex-1 p-8 overflow-x-auto">
        <slot />
      </main>
    </div>
  </div>
</template>
