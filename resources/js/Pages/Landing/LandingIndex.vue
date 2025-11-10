<template>
  <div class="min-h-screen flex flex-col">
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-md backdrop-blur-sm bg-opacity-95">
      <div class="flex items-center justify-between px-8 md:px-16 h-24 gap-12">
        <div class="flex-shrink-0">
          <img
            src="/storage/logo/Logo.png"
            alt="JE Travel & Tours"
            class="h-12 hover:opacity-80 transition-opacity duration-300"
          />
        </div>

        <div class="hidden lg:flex items-center gap-16 flex-1 justify-center">
          <Link
            href="/"
            class="text-[#008DDA] font-semibold text-base uppercase transition-all duration-300 relative group whitespace-nowrap"
          >
            Home
            <span class="absolute -bottom-2 left-0 w-0 h-1 bg-gradient-to-r from-[#008DDA] to-[#73BE5D] group-hover:w-full transition-all duration-300"></span>
          </Link>
          <Link
            href="/destination"
            class="text-[#008DDA] font-semibold text-base uppercase transition-all duration-300 relative group whitespace-nowrap"
          >
            Destinations
            <span class="absolute -bottom-2 left-0 w-0 h-1 bg-gradient-to-r from-[#008DDA] to-[#73BE5D] group-hover:w-full transition-all duration-300"></span>
          </Link>
          <Link
            href="/blogs"
            class="text-[#008DDA] font-semibold text-base uppercase transition-all duration-300 relative group whitespace-nowrap"
          >
            Travel Blogs
            <span class="absolute -bottom-2 left-0 w-0 h-1 bg-gradient-to-r from-[#008DDA] to-[#73BE5D] group-hover:w-full transition-all duration-300"></span>
          </Link>
          <Link
            href="/aboutus"
            class="text-[#008DDA] font-semibold text-base uppercase transition-all duration-300 relative group whitespace-nowrap"
          >
            About Us
            <span class="absolute -bottom-2 left-0 w-0 h-1 bg-gradient-to-r from-[#008DDA] to-[#73BE5D] group-hover:w-full transition-all duration-300"></span>
          </Link>
          <Link
            href="/contactus"
            class="text-[#008DDA] font-semibold text-base uppercase transition-all duration-300 relative group whitespace-nowrap"
          >
            Contact Us
            <span class="absolute -bottom-2 left-0 w-0 h-1 bg-gradient-to-r from-[#008DDA] to-[#73BE5D] group-hover:w-full transition-all duration-300"></span>
          </Link>
        </div>

        <div v-if="user" class="flex items-center gap-6 md:gap-8">
          <div class="relative" ref="notificationRef">
            <button
              @click="toggleNotifications"
              class="relative p-2 text-[#008DDA] hover:bg-blue-50 rounded-full transition-all duration-300 hover:shadow-md"
            >
              <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                <path d="M13.73 21a2 2 0 0 1-3.46 0" />
              </svg>
              <span
                v-if="unreadCount > 0"
                class="absolute top-0 right-0 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-lg"
              >
                {{ unreadCount }}
              </span>
            </button>

            <transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div
                v-if="showNotifications"
                class="absolute right-0 mt-3 w-full md:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
              >
                <div
                  class="bg-gradient-to-r from-[#1E71B8] to-[#008DDA] px-6 py-4 flex items-center justify-between"
                >
                  <h3 class="text-white font-bold text-lg">Notifications</h3>
                  <button
                    @click="showNotifications = false"
                    class="text-white hover:bg-white/20 p-1 rounded-full transition-all duration-300"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>

                <div class="max-h-96 overflow-y-auto">
                  <div v-if="notifications.length > 0" class="divide-y divide-gray-100">
                    <div
                      v-for="notif in notifications"
                      :key="notif.id"
                      @click="markAsRead(notif.id)"
                      class="p-4 hover:bg-gradient-to-r hover:from-blue-50 hover:to-transparent transition-all duration-300 cursor-pointer border-l-4 border-transparent hover:border-[#008DDA]"
                      :class="notif.is_read ? 'bg-white' : 'bg-blue-50'"
                    >
                      <div class="flex items-start justify-between mb-2">
                        <h4 class="font-bold text-gray-900 text-sm flex-1">
                          {{ notif.title }}
                        </h4>
                        <div class="flex items-center gap-2 ml-2">
                          <span
                            class="text-xs font-mono bg-gradient-to-r from-[#008DDA] to-[#1E71B8] text-white px-2 py-1 rounded-full"
                          >
                            B{{ String(notif.booking_id).padStart(5, "0") }}
                          </span>
                          <div
                            v-if="!notif.is_read"
                            class="w-3 h-3 rounded-full bg-gradient-to-r from-red-500 to-red-600 shadow-lg"
                          ></div>
                        </div>
                      </div>
                      <p class="text-gray-700 text-sm leading-relaxed mb-2">
                        {{ notif.message }}
                      </p>
                      <p class="text-gray-500 text-xs">
                        {{ formatNotificationDate(notif.created_at) }}
                      </p>
                    </div>
                  </div>
                  <div v-else class="px-6 py-12 text-center">
                    <svg
                      width="32"
                      height="32"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      class="mx-auto text-gray-300 mb-2"
                    >
                      <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                      <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <p class="text-gray-500 text-sm font-medium">No notifications yet</p>
                  </div>
                </div>

                <div
                  class="bg-gradient-to-r from-blue-50 to-transparent px-6 py-3 text-center border-t border-gray-100"
                >
                  <button
                    @click="markAllAsRead"
                    class="text-[#008DDA] text-sm font-semibold hover:text-[#1E71B8] transition-all duration-300"
                  >
                    Mark All as Read
                  </button>
                </div>
              </div>
            </transition>
          </div>

          <div class="relative" ref="dropdownRef">
            <button
              @click="showDropdown = !showDropdown"
              class="p-2 text-[#008DDA] hover:bg-blue-50 rounded-full transition-all duration-300 border-2 border-[#008DDA] hover:shadow-md hover:border-[#73BE5D]"
            >
              <svg
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
              </svg>
            </button>

            <transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div
                v-if="showDropdown"
                class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
              >
                <Link
                  href="/profile"
                  class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-transparent transition-all duration-300 border-b border-gray-100 group"
                >
                  <svg
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    class="text-[#008DDA] group-hover:text-[#73BE5D] transition-all duration-300"
                  >
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                  </svg>
                  <span class="text-sm font-semibold">Profile</span>
                </Link>
                <Link
                  href="/yourbookings"
                  class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-transparent transition-all duration-300 border-b border-gray-100 group"
                >
                  <svg
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    class="text-[#008DDA] group-hover:text-[#73BE5D] transition-all duration-300"
                  >
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                  </svg>
                  <span class="text-sm font-semibold">Your Bookings</span>
                </Link>
                <Link
                  :href="route('logout')"
                  method="post"
                  as="button"
                  class="w-full flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-transparent transition-all duration-300 group"
                >
                  <svg
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    class="text-red-500 group-hover:text-red-600 transition-all duration-300"
                  >
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                  </svg>
                  <span class="text-sm font-semibold">Logout</span>
                </Link>
              </div>
            </transition>
          </div>
        </div>

        <div v-else class="flex items-center group cursor-pointer">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="w-5 h-5 text-[#008DDA] transition-all duration-300 group-hover:text-[#73BE5D] group-hover:scale-110"
          >
            <path
              fill-rule="evenodd"
              d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
              clip-rule="evenodd"
            />
          </svg>

          <Link
            href="/login"
            class="text-sm md:text-base font-semibold text-[#008DDA] transition-all duration-300 group-hover:text-[#73BE5D] ml-2"
          >
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
import { ref, computed, onMounted, onUnmounted } from "vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import { api } from "@/api/api";

const showDropdown = ref(false);
const showNotifications = ref(false);
const page = usePage();
const user = computed(() => page.props.auth?.user);
const dropdownRef = ref(null);
const notificationRef = ref(null);
const service = new api();

const notifications = ref([]);
const unreadCount = ref(0);

const loadNotifications = async () => {
  if (!user.value) return;

  try {
    const response = await service.getNotifications(user.value.id);

    if (Array.isArray(response.data)) {
      notifications.value = response.data;
    } else if (response?.data?.data) {
      notifications.value = response.data.data;
    } else {
      notifications.value = [];
    }

    notifications.value.sort(
      (a, b) => new Date(b.created_at) - new Date(a.created_at)
    );
  } catch (error) {
    console.error("Failed to load notifications:", error);
  }
};

const loadUnreadCount = async () => {
  if (!user.value) return;

  try {
    const response = await service.getUnreadNotificationCount(user.value.id);
    unreadCount.value = response?.data?.count || 0;
  } catch (error) {
    console.error("Failed to load unread count:", error);
  }
};

const toggleNotifications = async () => {
  showNotifications.value = !showNotifications.value;
  if (showNotifications.value) {
    await loadNotifications();
  }
};

const markAsRead = async (notificationId) => {
  try {
    const response = await service.markNotificationAsRead(notificationId);
    if (response?.data?.success) {
      const notif = notifications.value.find((n) => n.id === notificationId);
      if (notif) {
        notif.is_read = true;
      }
      await loadUnreadCount();
    }
  } catch (error) {
    console.error("Failed to mark notification as read:", error);
  }
};

const markAllAsRead = async () => {
  if (!user.value) return;

  try {
    const response = await service.markAllNotificationsAsRead(user.value.id);
    if (response?.data?.success) {
      notifications.value.forEach((notif) => {
        notif.is_read = true;
      });
      unreadCount.value = 0;
    }
  } catch (error) {
    console.error("Failed to mark all as read:", error);
  }
};

const formatNotificationDate = (dateString) => {
  const date = new Date(dateString);
  const options = {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "numeric",
    minute: "2-digit",
    hour12: true,
  };
  return date.toLocaleDateString("en-US", options).replace(",", " at");
};

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    showDropdown.value = false;
  }
  if (notificationRef.value && !notificationRef.value.contains(event.target)) {
    showNotifications.value = false;
  }
};

onMounted(async () => {
  document.addEventListener("mousedown", handleClickOutside);
  if (user.value) {
    await loadUnreadCount();

    const interval = setInterval(() => {
      loadUnreadCount();
    }, 10000);

    onUnmounted(() => {
      clearInterval(interval);
    });
  }
});

onUnmounted(() => {
  document.removeEventListener("mousedown", handleClickOutside);
});

router.on("navigate", () => {
  showDropdown.value = false;
  showNotifications.value = false;
});
</script>