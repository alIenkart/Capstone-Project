<template>
  <div class="w-full">
    <!-- Top banner -->
    <div class="w-full h-40 bg-[#1E71B8]"></div>

    <!-- Content card -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 -mt-16">
      <div class="bg-white rounded-lg shadow-md">
        <!-- Header with avatar and title -->
        <div class="relative pt-8 pb-2 sm:pt-10 sm:pb-0">
          <div class="absolute -top-16 sm:-top-20 left-6">
            <div class="relative">
              <img
                src="https://api.dicebear.com/9.x/thumbs/svg?seed=avatar"
                alt="Profile Avatar"
                class="w-40 h-40 sm:w-48 sm:h-48 rounded-full object-cover border-4 border-white shadow-md"
              />
              <button
                type="button"
                class="absolute bottom-2 right-2 bg-white/90 hover:bg-white text-[#1E71B8] p-2 rounded-full shadow border"
              >
                <!-- Pencil icon -->
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path d="M12 20h9" />
                  <path
                    d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"
                  />
                </svg>
              </button>
            </div>
          </div>

          <div class="mt-28 sm:mt-10 px-6 sm:pl-52">
            <div class="flex items-center gap-3">
              <h2 class="text-3xl font-semibold text-slate-800">
                Profile Details
              </h2>
              <button
                type="button"
                class="text-slate-500 hover:text-[#1E71B8]"
                aria-label="Edit profile"
                @click="isEditing = true"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path d="M12 20h9" />
                  <path
                    d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Form -->
        <div class="px-6 sm:px-8 pb-8 sm:pb-10 pt-2 sm:pt-6">
          <form
            @submit.prevent="saveChanges"
            class="grid grid-cols-1 md:grid-cols-2 gap-6"
          >
            <!-- First Name -->
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1"
                >First Name</label
              >
              <input
                v-model="firstName"
                type="text"
                :readonly="!isEditing"
                :disabled="!isEditing"
                class="w-full rounded-md border border-[#1E71B8] focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8] px-3 py-2 outline-none disabled:opacity-50 disabled:bg-gray-100"
                placeholder="John"
              />
            </div>

            <!-- Phone Number with edit icon -->
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1"
                >Phone Number</label
              >
              <div class="relative">
                <input
                  v-model="phone"
                  type="text"
                  :readonly="!isEditing"
                  :disabled="!isEditing"
                  class="w-full rounded-md border border-[#1E71B8] focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8] px-3 py-2 pr-9 outline-none disabled:opacity-50 disabled:bg-gray-100"
                  placeholder="+63XXXXXXXXXX"
                />
              </div>
            </div>

            <!-- Last Name -->
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1"
                >Last Name</label
              >
              <input
                v-model="lastName"
                type="text"
                :readonly="!isEditing"
                :disabled="!isEditing"
                class="w-full rounded-md border border-[#1E71B8] focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8] px-3 py-2 outline-none disabled:opacity-50 disabled:bg-gray-100"
                placeholder="Doe"
              />
            </div>

            <!-- Password with edit icon -->
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1"
                >Password</label
              >
              <div class="relative">
                <input
                  v-model="password"
                  type="password"
                  :readonly="!isEditing"
                  :disabled="!isEditing"
                  class="w-full rounded-md border border-[#1E71B8] focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8] px-3 py-2 pr-9 outline-none tracking-widest disabled:opacity-50 disabled:bg-gray-100"
                  placeholder="##########"
                />
              </div>
            </div>

            <!-- Email with edit icon -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-slate-700 mb-1"
                >Email</label
              >
              <div class="relative">
                <input
                  v-model="email"
                  type="email"
                  :readonly="!isEditing"
                  :disabled="!isEditing"
                  class="w-full rounded-md border border-[#1E71B8] focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8] px-3 py-2 pr-9 outline-none disabled:opacity-50 disabled:bg-gray-100"
                  placeholder="name@example.com"
                />
              </div>
            </div>

            <!-- Save Button -->
            <div class="md:col-span-2 flex justify-end">
              <button
                type="submit"
                :disabled="!isEditing"
                class="inline-flex items-center gap-2 bg-[#1E71B8] text-white hover:bg-[#1763a1] active:bg-[#145a93] disabled:opacity-60 disabled:cursor-not-allowed px-5 py-2.5 rounded-md shadow"
              >
                Save Changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <Footer></Footer>
</template>

<script setup>
import LandingIndex from "./LandingIndex.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import { useToast } from "vue-toastification";
import Footer from "./Footer.vue";

defineOptions({ layout: LandingIndex });
const page = usePage();
const user = computed(() => page.props.auth?.user);
const toast = useToast();

const firstName = ref("");
const lastName = ref("");
const email = ref("");
const phone = ref("");
const password = ref("password");

const saveChanges = () => {
  try {
    isEditing.value = false;
    toast.success("Profile updated successfully!");
  } catch (e) {
    console.error(e);
  }
};

onMounted(() => {
  firstName.value = user?.value?.first_name ?? "";
  lastName.value = user?.value?.last_name ?? "";
  email.value = user?.value?.email ?? "";
  phone.value = user?.value?.phone_number ?? "";
});

// Global edit mode – enables fields and save button
const isEditing = ref(false);
</script>
