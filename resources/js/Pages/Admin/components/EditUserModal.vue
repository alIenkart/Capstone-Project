<template>
  <div
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 sm:p-6"
  >
    <div
      class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden mx-auto"
    >
      <!-- Header -->
      <div class="bg-[#1E71B8] px-5 py-5 sm:px-8 sm:py-6">
        <button
          class="absolute top-7 right-6 text-white/80 hover:text-white transition-colors"
          @click="$emit('close')"
          aria-label="Close"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
        <h2 class="text-2xl font-bold text-white">User Details</h2>
      </div>

      <!-- Content -->
      <div class="px-5 py-6 sm:px-8 space-y-6">
        <!-- Name Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2"
              >First Name</label
            >
            <input
              v-model="form.first_name"
              type="text"
              class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
              placeholder="Enter first name"
            />
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2"
              >Last Name</label
            >
            <input
              v-model="form.last_name"
              type="text"
              class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
              placeholder="Enter last name"
            />
          </div>
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2"
            >Email</label
          >
          <input
            v-model="form.email"
            type="email"
            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
            placeholder="Enter email address"
          />
        </div>

        <!-- Contact Number -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2"
            >Contact Number</label
          >
          <input
            v-model="form.phone_number"
            type="tel"
            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all"
            placeholder="Enter contact number"
          />
        </div>

        <!-- Email Verified Status -->
        <div
          class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 bg-gray-50 rounded-xl"
        >
          <span class="text-sm font-semibold text-gray-700"
            >Email Verified</span
          >
          <span
            :class="
              user.email_verified_at
                ? 'bg-green-100 text-green-700'
                : 'bg-red-100 text-red-700'
            "
            class="px-3 py-1 rounded-full text-sm font-medium"
          >
            {{ user.email_verified_at ? "Verified" : "Not Verified" }}
          </span>
        </div>

        <!-- Role -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2"
            >Role</label
          >
          <select
            v-model="form.role"
            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all bg-white cursor-pointer"
          >
            <option value="Customer">Customer</option>
            <option value="Admin">Admin</option>
          </select>
        </div>
      </div>

      <!-- Footer Actions -->
      <div class="px-5 py-6 sm:px-8 bg-gray-50 flex flex-col sm:flex-row sm:justify-end gap-3">
        <button
          @click="$emit('close')"
          class="px-6 py-3 rounded-xl font-semibold text-gray-700 bg-white border-2 border-gray-200 hover:bg-gray-50 transition-all w-full sm:w-auto text-center"
        >
          Cancel
        </button>
        <button
          @click="updateUser"
          :disabled="!hasChanges || isLoading"
          :class="[
            'px-6 py-3 rounded-xl font-semibold text-white transition-all w-full sm:w-auto text-center',
            hasChanges && !isLoading
              ? 'bg-[#1E71B8] hover:shadow-lg hover:scale-105 cursor-pointer'
              : 'bg-gray-300 cursor-not-allowed opacity-60',
          ]"
        >
          {{ isLoading ? "Saving..." : "Save Changes" }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import axios from "axios";
import { useToast } from "vue-toastification";

const props = defineProps({
  user: Object,
  show: Boolean,
});

const toast = useToast();
const emit = defineEmits(["close", "updated"]);

const isLoading = ref(false);

const form = ref({
  first_name: props.user.first_name,
  last_name: props.user.last_name,
  email: props.user.email,
  phone_number: props.user.phone_number || "",
  role: props.user.role,
});

// Computed property to check if there are any changes
const hasChanges = computed(() => {
  return (
    form.value.first_name !== props.user.first_name ||
    form.value.last_name !== props.user.last_name ||
    form.value.email !== props.user.email ||
    form.value.phone_number !== (props.user.phone_number || "") ||
    form.value.role !== props.user.role
  );
});

const updateUser = async () => {
  if (!hasChanges.value || isLoading.value) return;

  isLoading.value = true;

  try {
    const response = await axios.patch(
      `/api/users/${props.user.id}`,
      form.value
    );

    toast.success("User updated successfully!");
    emit("updated");
    emit("close");
  } catch (error) {
    console.error("Error updating user:", error);

    if (error.response?.data?.errors) {
      // Handle validation errors
      Object.values(error.response.data.errors).forEach((errorArray) => {
        errorArray.forEach((err) => toast.error(err));
      });
    } else if (error.response?.data?.message) {
      toast.error(error.response.data.message);
    } else {
      toast.error("Failed to update user. Please try again.");
    }
  } finally {
    isLoading.value = false;
  }
};
</script>
