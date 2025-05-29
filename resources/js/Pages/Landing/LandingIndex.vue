<template>
  <div>
    <!-- Navbar -->
    <nav class="navbar">
      <div class="navbar-logo">
        <img class="logo-img" src="build/assets/travelogo.jpg" alt="JE Travel & Tours" />
      </div>
      <div class="navbar-links">
        <Link href="/home" class="link" :class="page.url === '/home' ? 'active-link' : ''">Home</Link>
        <Link href="/destination" class="link" :class="page.url === '/destination' ? 'active-link' : ''">Destinations</Link>
        <Link href="/blogs" class="link" :class="page.url === '/blogs' ? 'active-link' : ''">Travel Blogs</Link>
        <Link href="/aboutus" class="link" :class="page.url === '/aboutus' ? 'active-link' : ''">About Us</Link>
        <Link href="/contactus" class="link" :class="page.url === '/contactus' ? 'active-link' : ''">Contact Us</Link>
      </div>
      <div class="profile-dropdown"
           @mouseenter="showDropdown = true"
           @mouseleave="showDropdown = false">
        <button class="profile-btn" @click="showDropdown = !showDropdown">
          <span class="profile-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="8" r="4" stroke="#e67e22" stroke-width="2" fill="none"/>
              <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke="#e67e22" stroke-width="2" fill="none"/>
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
          <Link href="/logout" class="dropdown-item">Logout</Link>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="home-footer">
      <div class="footer-main">
        2025 Copyright. JE Travel & Tours | Unit 201 2nd floor M.B. Aguirre Brgy. San Jose City of Biñan, Laguna | +639395218437
      </div>
      <div class="footer-links">
        <a href="#" class="footer-link">Piracy Policy</a>
        <span class="footer-separator">|</span>
        <a href="#" class="footer-link">Terms & Conditions</a>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const showDropdown = ref(false)
const page = usePage().url
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
  color: #e67e22;
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
  color: #e67e22;
  font-weight: bold;
  border-bottom: 2px solid #e67e22;
}
.link:hover {
  color: #d35400;
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
  color: #e67e22;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  padding: 8px;
  border-radius: 50%;
  transition: background 0.2s;
}
.profile-btn:hover {
  background: #fbeee0;
}
.profile-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #fff;
  border: 2px solid #e67e22;
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
  color: #e67e22;
  text-align: left;
  text-decoration: none;
  font-size: 15px;
  transition: background 0.2s, color 0.2s;
  border-radius: 0;
}
.dropdown-item:hover {
  background: #fbeee0;
  color: #d35400;
}
.home-footer {
  background: #e67e22;
  padding: 24px 0 12px 0;
  text-align: center;
  border-top: 1px solid #eee;
  margin-top: 0px;
}
.footer-main {
  color: #fff;
  font-size: 15px;
  margin-bottom: 8px;
  line-height: 1.6;
}
.footer-links {
  margin-top: 0;
}
.footer-link {
  color: #fff;
  text-decoration: none;
  margin: 0 8px;
  font-weight: 500;
  transition: color 0.2s, text-decoration 0.2s;
}
.footer-link:hover {
  color: #fbeee0;
  text-decoration: underline;
}
.footer-separator {
  color: #fff;
  margin: 0 4px;
}
</style>