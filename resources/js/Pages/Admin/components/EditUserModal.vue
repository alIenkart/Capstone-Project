<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-2 sm:p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] px-4 sm:px-6 lg:px-8 py-4 sm:py-6 flex items-center justify-between gap-4">
        <div class="min-w-0 flex-1">
          <h2 class="text-lg sm:text-2xl font-bold text-white truncate">Edit User</h2>
          <p class="text-blue-100 text-xs sm:text-sm mt-1 hidden sm:block">
            Update user details and role
          </p>
        </div>
        <button @click="$emit('close')"
          class="text-white hover:bg-white/20 p-2 rounded-lg transition-all flex-shrink-0">
          <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">
        <div>
          <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Email Address</label>
          <input v-model="form.email" type="email" placeholder="john@example.com"
            class="w-full px-4 py-2 sm:py-2.5 border-2 border-gray-200 rounded-lg focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200 outline-none transition-all" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
          <div>
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">First Name</label>
            <input v-model="form.first_name" type="text" placeholder="John"
              class="w-full px-4 py-2 sm:py-2.5 border-2 border-gray-200 rounded-lg focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200 outline-none transition-all" />
          </div>

          <div>
            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Last Name</label>
            <input v-model="form.last_name" type="text" placeholder="Cordova"
              class="w-full px-4 py-2 sm:py-2.5 border-2 border-gray-200 rounded-lg focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200 outline-none transition-all" />
          </div>
        </div>

        <div>
          <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Contact Number</label>
          <input v-model="form.phone_number" type="tel" placeholder="09123456789" maxlength="11"
            @input="form.phone_number = form.phone_number.replace(/\D/g, '')"
            class="w-full px-4 py-2 sm:py-2.5 border-2 border-gray-200 rounded-lg focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200 outline-none transition-all" />
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 bg-gray-50 rounded-xl">
          <span class="text-sm font-semibold text-gray-700">Email Verified</span>
          <span :class="user.email_verified_at ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700'"
            class="px-3 py-1 rounded-full text-sm font-medium">
            {{ user.email_verified_at ? 'Verified' : 'Not Verified' }}
          </span>
        </div>

        <div class="relative" data-filter-container>
          <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Role</label>
          <button @click="isRoleDropdownOpen = !isRoleDropdownOpen"
            class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
            <span class="font-semibold text-gray-800">
              {{ form.role || 'Select Role' }}
            </span>
            <svg :class="[
              'w-5 h-5 text-blue-600 transition-transform duration-300',
              isRoleDropdownOpen ? 'rotate-180' : '',
            ]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
          </button>

          <div v-if="isRoleDropdownOpen"
            class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden">
            <div v-for="option in roleOptions" :key="option" @click="handleRoleSelect(option)" :class="[
              'px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50',
              form.role === option
                ? 'bg-blue-50 border-l-4 border-l-blue-500'
                : '',
            ]">
              <span :class="[
                'font-medium',
                form.role === option
                  ? 'text-blue-700'
                  : 'text-gray-700',
              ]">
                {{ option }}
              </span>
              <svg v-if="form.role === option" class="w-5 h-5 text-blue-600 ml-auto" fill="currentColor"
                viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                  clip-rule="evenodd"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="relative">
          <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">New Password</label>
          <input v-model="form.password" :type="showPassword ? 'text' : 'password'" placeholder="Enter new password"
            class="w-full px-4 py-2 sm:py-2.5 pr-10 border-2 border-gray-200 rounded-lg focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200 outline-none transition-all" />
          <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center text-gray-400"
            @click="showPassword = !showPassword" tabindex="-1">
            <svg v-if="!showPassword" class="w-5 h-5 mt-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-5 h-5 mt-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
          </button>
        </div>

        <div class="relative">
          <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Confirm Password</label>
          <input v-model="form.password_confirmation" :type="showPasswordConfirm ? 'text' : 'password'"
            placeholder="Confirm new password"
            class="w-full px-4 py-2 sm:py-2.5 pr-10 border-2 border-gray-200 rounded-lg focus:border-[#1E71B8] focus:ring-2 focus:ring-blue-200 outline-none transition-all" />
          <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center text-gray-400"
            @click="showPasswordConfirm = !showPasswordConfirm" tabindex="-1">
            <svg v-if="!showPasswordConfirm" class="w-5 h-5 mt-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-5 h-5 mt-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
          </button>
        </div>
      </div>

      <div
        class="flex flex-col-reverse sm:flex-row gap-2 sm:gap-3 px-4 sm:px-6 lg:px-8 py-4 sm:py-6 bg-gray-50 border-t">
        <button @click="$emit('close')"
          class="flex-1 px-3 sm:px-4 py-2 sm:py-2.5 border-2 border-gray-300 text-gray-700 text-sm sm:text-base font-semibold rounded-lg hover:bg-gray-50 transition-all">
          Cancel
        </button>
        <button @click="updateUser" :disabled="!hasChanges || isLoading" :class="[
          'flex-1 px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl',
          hasChanges && !isLoading
            ? 'bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white hover:from-[#2a8bb5] hover:to-[#1E71B8]'
            : 'bg-gray-200 text-gray-400 cursor-not-allowed'
        ]">
          {{ isLoading ? 'Saving...' : 'Save Changes' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import axios from "axios";
import { useToast } from "vue-toastification";

const props = defineProps({
  user: Object,
  show: Boolean,
});

const emit = defineEmits(["close", "updated"]);

const toast = useToast();
const isLoading = ref(false);
const showPassword = ref(false);
const showPasswordConfirm = ref(false);
const isRoleDropdownOpen = ref(false);
const form = ref({ ...props.user });

const roleOptions = ["Admin", "Customer", "Staff"];

const hasChanges = computed(() => {
  return JSON.stringify(form.value) !== JSON.stringify(props.user);
});

const handleRoleSelect = (option) => {
  form.value.role = option;
  isRoleDropdownOpen.value = false;
};

const updateUser = async () => {
  if (!hasChanges.value) return;
  isLoading.value = true;

  if (form.value.password && form.value.password !== form.value.password_confirmation) {
    toast.error("Passwords do not match");
    isLoading.value = false;
    return;
  }

  try {
    const payload = { ...form.value };
    if (!payload.password) {
      delete payload.password;
      delete payload.password_confirmation;
    }
    await axios.put(`/api/users/${props.user.id}`, payload);
    toast.success("User updated successfully");
    emit("updated", form.value);
    emit("close");
  } catch (error) {
    toast.error(error.response?.data?.message || "Failed to update user");
  } finally {
    isLoading.value = false;
  }
};

const handleClickOutside = (event) => {
  if (!event.target.closest("[data-filter-container]")) {
    isRoleDropdownOpen.value = false;
  }
};

watch(
  () => props.user,
  (newUser) => {
    form.value = { ...newUser };
  },
  { immediate: true }
);

watch(isRoleDropdownOpen, (newValue) => {
  if (newValue) {
    document.addEventListener("click", handleClickOutside);
  } else {
    document.removeEventListener("click", handleClickOutside);
  }
});
</script>