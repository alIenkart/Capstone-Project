<template>
  <div class="layout-root">
    <!-- Navbar -->
    <nav class="navbar">
      <div class="navbar-logo">
        <Link href="/">
          <img class="logo-img" src="/storage/logo/Logo.png" alt="JE Travel & Tours" />
        </Link>
      </div>
      <div class="navbar-links">
        <Link href="/" class="link uppercase" :class="page.url === '/' ? 'active-link' : ''">Home</Link>
        <Link href="/destination" class="link uppercase" :class="page.url === '/destination' ? 'active-link' : ''">Destinations</Link>
        <Link href="/blogs" class="link uppercase" :class="page.url === '/blogs' ? 'active-link' : ''">Travel Blogs</Link>
        <Link href="/aboutus" class="link uppercase" :class="page.url === '/aboutus' ? 'active-link' : ''">About Us</Link>
        <Link href="/contactus" class="link uppercase" :class="page.url === '/contactus' ? 'active-link' : ''">Contact Us</Link>
      </div>
      
      <div v-if="user" class="profile-dropdown" ref="dropdown">
        <button class="profile-btn" @click="toggleDropdown">
          <span class="profile-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="8" r="4" stroke="#008DDA" stroke-width="2" fill="none"/>
              <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke="#008DDA" stroke-width="2" fill="none"/>
            </svg>
          </span>
        </button>
        <div
          v-if="showDropdown"
          class="dropdown-menu"
        >
          <Link href="/profile" class="dropdown-item">Profile</Link>
          <Link href="/yourbookings" class="dropdown-item">Your Bookings</Link>
          <Link href="/notifications" class="dropdown-item">Notifications</Link>
          <Link :href="route('logout')" method="post" as="button" class="dropdown-item" :data="{ redirect: route('login') }">Logout</Link>
        </div>
      </div>

      <div v-else>
        <Link href="/login" class="login-btn">Login</Link>
      </div>
    </nav>

    <!-- Main Content -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
  </div>
  <Footer />
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Footer from './Footer.vue'

const showDropdown = ref(false)
const page = usePage()
const user = computed(() => page.props.auth?.user)
const dropdown = ref(null)

function toggleDropdown() {
  showDropdown.value = !showDropdown.value
}

function handleClickOutside(event) {
  if (dropdown.value && !dropdown.value.contains(event.target)) {
    showDropdown.value = false
  }
}

onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside)
})
</script>

<style>
:root, html, body {
  height: 100%;
  width: 100%;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  background: #fff;
}

body {
  min-height: 100vh;
  width: 100vw;
  margin: 0;
  padding: 0;
  overflow-x: hidden;
}

#app {
  min-height: 100vh;
  width: 100vw;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
}

.layout-root {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.main-content, main {
  flex: 1 0 auto;
  width: 100vw;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  background: #fff;
  overflow-x: hidden;
  display: block;
}
.navbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #fff;
  padding: 0 30px;
  height: 70px;
  border-bottom: 1px solid #eee;
  position: sticky;
  top: 0;
  z-index: 1000;
}
.logo-img {
  height: 50px;
  display: block;
}
.navbar-links {
  display: flex;
  align-items: center;
  gap: 100px;
  flex: 1;
  justify-content: center;
}
.link {
  color: #008DDA;
  text-decoration: none;
  font-weight: 500;
  padding: 8px 0;
  border: none;
  background: none;
  font-size: 16px;
  position: relative;
  transition: color 0.2s;
}
.link.active-link {
  color: #008DDA;
  font-weight: bold;
  border-bottom: 2px solid #008DDA;
}
.link:hover {
  color: #73BE5D;
}
.profile-dropdown {
  position: relative;
  display: flex;
  align-items: center;
  height: 70px;
}
.profile-btn {
  background: none;
  border: none;
  color: #008DDA;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  padding: 8px;
  border-radius: 50%;
  transition: background 0.2s;
}
.profile-btn:hover {
  background: #eeece9;
}
.profile-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #fff;
  border: 2px solid #008DDA;
}
.dropdown-menu {
  position: absolute;
  top: 60px;
  right: 0;
  background: #fff;
  border: 1px solid #eee;
  box-shadow: 0 4px 16px rgba(0,0,0,0.10);
  border-radius: 8px;
  min-width: 180px;
  z-index: 100;
  padding: 12px 0;
  display: flex;
  flex-direction: column;
  gap: 0;
}
.dropdown-item {
  display: block;
  padding: 12px 24px;
  color: #008DDA;
  text-align: left;
  text-decoration: none;
  font-size: 15px;
  transition: background 0.2s, color 0.2s;
  border-radius: 0;
}
.dropdown-item:hover {
  background: #eeece9;
  color: #73BE5D;
}
</style>