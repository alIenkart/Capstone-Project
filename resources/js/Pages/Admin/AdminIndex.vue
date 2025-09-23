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
  <div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
      <div class="admin-logo">
        <span class="admin-profile-icon">
          <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="8" r="6" stroke="#fff" stroke-width="2" fill="none"/>
            <path d="M4 22c0-5 4-8 8-8s8 3 8 8" stroke="#fff" stroke-width="2" fill="none"/>
          </svg>
        </span>
        <span>ADMIN</span>
      </div>
      <nav class="admin-nav">
        <Link href="/admin/admindashboard" class="admin-link" :class="isActive('/admin/admindashboard')">Dashboard</Link>
        <Link href="/admin/users" class="admin-link" :class="isActive('/admin/users')">Users</Link>
        <Link href="/admin/packages" class="admin-link" :class="isActive('/admin/packages')">Packages</Link>
        <Link href="/admin/booking-entries" class="admin-link" :class="isActive('/admin/booking-entries')">Booking Entries</Link>
        <Link href="/admin/payment-confirmation" class="admin-link" :class="isActive('/admin/payment-confirmation')">Payment Confirmation</Link>
        <Link href="/admin/content-management" class="admin-link" :class="isActive('/admin/content-management')">Content Management</Link>
        <Link href="/admin/review-feedback" class="admin-link" :class="isActive('/admin/review-feedback')">Review & Feedback</Link>
      </nav>
      <div class="admin-sidebar-bottom">
        <Link href="/admin/settings" class="admin-link settings-link">
          <span class="icon">&#9881;</span> Settings
        </Link>
        <Link :href="route('logout')" method="post" as="button" class="admin-link logout-link">
          <span class="icon">&#x21B6;</span> Logout
        </Link>
      </div>
    </aside>
    <!-- Main Content -->
    <div class="admin-main">
      <header class="admin-header">
        <h2>{{ headerTitle }}</h2>
      </header>
      <main class="admin-content">
        <slot />
      </main>
    </div>
  </div>
</template>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #f5f5f5;
}
.admin-sidebar {
  width: 220px;
  background: #217093;
  color: #fff;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 0;
}
.admin-logo {
  display: flex;
  align-items: center;
  padding: 24px 16px 16px 16px;
  border-bottom: 1px solid #1a5a73;
}
.admin-logo-img {
  width: 36px;
  height: 36px;
  margin-right: 10px;
}
.admin-title {
  font-size: 1.3rem;
  font-weight: bold;
  letter-spacing: 2px;
}
.admin-nav {
  display: flex;
  flex-direction: column;
  gap: 2px;
  margin-top: 24px;
}
.admin-link {
  color: #fff;
  text-decoration: none;
  padding: 14px 24px;
  font-size: 1rem;
  transition: background 0.2s, color 0.2s;
  border-left: 4px solid transparent;
  display: flex;
  align-items: center;
}
.admin-link:hover, .admin-link.active-admin-link {
  background: #176080;
  color: #fff;
  border-left: 4px solid #008DDA;
}
.admin-sidebar-bottom {
  display: flex;
  flex-direction: column;
  gap: 2px;
  margin-bottom: 24px;
}
.settings-link .icon, .logout-link .icon {
  margin-right: 8px;
  font-size: 1.2em;
}
.logout-link {
  color: #fff;
}
.admin-main {
  flex: 1;
  display: flex;
  flex-direction: column;
}
.admin-header {
  background: #eaeaea;
  padding: 22.5px 32px;
  border-bottom: 1px solid #ddd;
}
.admin-header h2 {
  margin: 0;
  font-size: 1.3rem;
  color: #444;
  font-weight: 600;
  letter-spacing: 1px;
  text-align: center;
}
.admin-content {
  padding: 32px;
  overflow-x: auto;
}
</style>