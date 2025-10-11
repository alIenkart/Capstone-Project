<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="relative bg-white rounded-2xl border-2 border-gray-300 shadow-2xl w-full max-w-2xl px-8 py-8">
      <button
        class="absolute top-4 right-4 text-2xl text-[#1E71B8] hover:text-[#73BE5D] font-bold"
        @click="$emit('close')"
        aria-label="Close"
      >×</button>

      <h2 class="text-xl font-bold mb-6 text-[#1E71B8]">User Details - ID #{{ user.id }}</h2>

      <div class="grid grid-cols-1 gap-4">
        <p><strong class="text-[#1E71B8]">Name:</strong> {{ user.first_name }} {{ user.last_name }}</p>
        <p><strong class="text-[#1E71B8]">Email:</strong> {{ user.email }}</p>
        <p><strong class="text-[#1E71B8]">Contact Number:</strong> {{ user.phone_number || 'N/A' }}</p>
        <p><strong class="text-[#1E71B8]">Email Verified:</strong> {{ user.email_verified_at ? 'Yes' : 'No' }}</p>

        <label class="font-semibold block mt-4 mb-1 text-[#1E71B8]">Role</label>
            <select v-model="form.role" class="w-full rounded-xl border-2 border-[#1E71B8] px-4 py-2 text-[#1E71B8] focus:border-[#73BE5D] focus:ring-[#73BE5D]">
                <option value="Customer">Customer</option>
                <option value="Admin">Admin</option>
        </select>
        <button
          @click="updateRole"
          class="bg-[#73BE5D] text-white px-6 py-2 rounded-xl font-semibold hover:bg-[#6aae56]"
        >
          Save
        </button>
      </div>

      <div class="flex justify-end mt-6 gap-4">
        <button
          @click="$emit('close')"
          class="bg-[#1E71B8] text-white px-6 py-2 rounded-xl font-semibold hover:bg-[#73BE5D]"
        >
          Close
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { api } from '../../../api/api'
import { useToast } from 'vue-toastification'

const props = defineProps({
  user: Object,
  show: Boolean
})
const toast = useToast();
const emit = defineEmits(['close', 'updated'])

const service = new api()

const form = ref({
  role: props.user.role
})

const updateRole = async () => {
  try {
    await service.updateUser(props.user.id, {
    role: form.value.role
    })
    toast.success('User role updated successfully!')
    emit('updated')
    emit('close')
  } catch (error) {
    console.error('Error updating user role:', error)
    alert('Failed to update user role.')
  }
}
</script>
