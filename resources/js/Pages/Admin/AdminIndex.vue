<template>
  <div
    :class="[
      'flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 transition-all duration-300',
      { 'overflow-hidden': isLoggingOut },
    ]"
  >
    <div
      :class="[
        'fixed inset-0 z-[100] transition-opacity duration-500 ease-in-out',
        isLoggingOut ? 'opacity-100' : 'opacity-0 pointer-events-none',
      ]"
      class="flex flex-col items-center justify-center bg-white"
    >
      <svg
        class="animate-spin h-12 w-12 text-[#1E71B8]"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
      <p class="mt-4 text-gray-700 font-medium text-lg">Logging out...</p>
    </div>

    <aside
      :class="[
        'fixed top-0 left-0 h-screen z-50 transform transition-all duration-300 ease-in-out flex flex-col justify-between shadow-2xl bg-gradient-to-b from-[#1E71B8] to-[#1557a0]',
        isSidebarOpen ? 'w-64' : 'w-[50px]',
      ]"
    >
      <div class="flex flex-col">
        <div
          class="flex items-center justify-between px-6 py-8 border-b border-white/10"
          v-if="isSidebarOpen"
        >
          <div class="flex items-center gap-3">
            <div
              class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm"
            >
              <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                class="text-white"
              >
                <circle
                  cx="12"
                  cy="8"
                  r="4"
                  stroke="currentColor"
                  stroke-width="2"
                  fill="none"
                />
                <path
                  d="M5 20c0-4 3-6 7-6s7 2 7 6"
                  stroke="currentColor"
                  stroke-width="2"
                  fill="none"
                />
              </svg>
            </div>
            <span class="text-white text-2xl font-bold tracking-tight">{{
              adminName.toUpperCase()
            }}</span>
          </div>
          <button
            @click="toggleSidebar"
            class="text-white/80 hover:text-white focus:outline-none"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="2.5"
              stroke="currentColor"
              class="w-7 h-7"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"
              />
            </svg>
          </button>
        </div>

        <div
          v-else
          class="flex items-center justify-center px-3 py-8 border-b border-white/10 cursor-pointer"
          @click="toggleSidebar"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2.5"
            stroke="currentColor"
            class="w-7 h-7 text-white"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"
            />
          </svg>
        </div>

        <nav v-if="isSidebarOpen" class="flex flex-col gap-1 px-3 mt-6">
          <Link
            v-for="item in navigationItems"
            :key="item.href"
            :href="item.href"
            class="group relative flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 hover:text-white transition-all duration-200 hover:bg-white/10"
            :class="
              isActive(item.href)
                ? 'bg-[#73BE5D] text-white shadow-lg shadow-[#73BE5D]/30'
                : ''
            "
          >
            <span class="font-medium text-base">{{ item.label }}</span>
            <div
              v-if="isActive(item.href)"
              class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-white rounded-r-full"
            ></div>
          </Link>
        </nav>
      </div>

      <div v-if="isSidebarOpen" class="flex flex-col gap-1 px-3 mb-6 mt-auto">
        <!-- <Link
          href="/admin/settings"
          class="group relative flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 hover:text-white transition-all duration-200 hover:bg-white/10"
          :class="
            isActive('/admin/settings')
              ? 'bg-[#73BE5D] text-white shadow-lg shadow-[#73BE5D]/30'
              : ''
          "
        >
          <span class="font-medium text-base">Settings</span>
        </Link> -->

        <button
          @click="handleLogout"
          class="group flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 hover:text-white transition-all duration-200 hover:bg-red-500/20 w-full text-left mt-2 border border-white/10"
        >
          <span class="font-medium text-base">Logout</span>
        </button>
      </div>
    </aside>

    <div
      v-if="isSidebarOpen && !isLoggingOut"
      class="fixed inset-0 bg-black/40 z-40 lg:hidden"
      @click="toggleSidebar"
    ></div>

    <div
      :class="[
        'flex-1 flex flex-col transition-all duration-300 ease-in-out',
        isSidebarOpen ? 'lg:ml-64' : 'ml-[50px]',
      ]"
    >
      <header
        class="bg-white/80 backdrop-blur-md px-8 py-5 border-b border-gray-200/50 sticky top-0 z-40 flex items-center justify-between"
      >
        <div class="mb-1">
          <h1 class="text-3xl font-bold text-gray-800 mb-2">
            {{ headerTitle.title }}
          </h1>
          <p class="text-gray-500">{{ headerTitle.subtitle }}</p>
        </div>
      </header>

      <main class="flex-1 overflow-auto p-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const isSidebarOpen = ref(true);
const toggleSidebar = () => (isSidebarOpen.value = !isSidebarOpen.value);

const isLoggingOut = ref(false);

const handleLogout = () => {
  isLoggingOut.value = true;
  setTimeout(() => {
    router.post(route("logout"));
  }, 1000);
};

const page = usePage();

const adminName = computed(() => {
  return page.props.auth?.user?.first_name || "ADMIN";
});

const isActive = (path) => page.url.startsWith(path);

const headerTitle = computed(() => {
  if (page.url.startsWith("/admin/admindashboard"))
    return {
      title: "Dashboard",
      subtitle: "Overview of system statistics and activity",
    };
  if (page.url.startsWith("/admin/users"))
    return {
      title: "User Management",
      subtitle: "Manage system users and their permissions",
    };
  if (page.url.startsWith("/admin/packages"))
    return {
      title: "Package Management",
      subtitle: "Create and manage tour packages",
    };
  if (page.url.startsWith("/admin/booking-entries"))
    return {
      title: "Booking Entries",
      subtitle: "Manage and track all customer bookings",
    };
  if (page.url.startsWith("/admin/payment-confirmation"))
    return {
      title: "Payment Management",
      subtitle: "Review and approve customer payment submissions",
    };
  if (page.url.startsWith("/admin/content-management"))
    return {
      title: "Content Management",
      subtitle: "Manage site content and pages",
    };
  if (page.url.startsWith("/admin/review-feedback"))
    return {
      title: "Review & Feedback",
      subtitle: "View user reviews and feedback",
    };
  if (page.url.startsWith("/admin/login-history"))
    return { title: "Login History", subtitle: "Track user login activity" };
  if (page.url.startsWith("/admin/settings"))
    return { title: "Settings", subtitle: "Configure system preferences" };
  return { title: "Admin", subtitle: "" };
});

const navigationItems = [
  { href: "/admin/admindashboard", label: "Dashboard" },
  { href: "/admin/users", label: "Users" },
  { href: "/admin/packages", label: "Packages" },
  { href: "/admin/booking-entries", label: "Booking Entries" },
  { href: "/admin/payment-confirmation", label: "Payment Management" },
  { href: "/admin/content-management", label: "Content Management" },
  { href: "/admin/review-feedback", label: "Review & Feedback" },
  { href: "/admin/login-history", label: "Login History" },
];
</script>

<style scoped>
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
