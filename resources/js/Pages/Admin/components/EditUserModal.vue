<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="relative bg-white rounded-2xl border-2 border-gray-300 shadow-2xl w-full max-w-2xl px-8 py-8">
      <button
        class="absolute top-4 right-4 text-2xl text-black hover:text-blue-600 font-bold"
        @click="$emit('close')"
        aria-label="Close"
      >×</button>

      <h2 class="text-xl font-bold mb-6">User Details - ID #{{ user.id }}</h2>

      <div class="grid grid-cols-1 gap-4">
        <p><strong>Name:</strong> {{ user.first_name }} {{ user.last_name }}</p>
        <p><strong>Email:</strong> {{ user.email }}</p>
        <p><strong>Contact Number:</strong> {{ user.phone_number || 'N/A' }}</p>
        <p><strong>Email Verified:</strong> {{ user.email_verified_at ? 'Yes' : 'No' }}</p>

        <label class="font-semibold block mt-4 mb-1">Role</label>
            <select v-model="form.role" class="w-full rounded-xl border-2 border-gray-300 px-4 py-2">
                <option value="Customer">Customer</option>
                <option value="Admin">Admin</option>
        </select>
        <button
          @click="updateRole"
          class="bg-blue-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-blue-700"
        >
          Save
        </button>
      </div>

      <div class="flex justify-end mt-6 gap-4">
        <button
          @click="$emit('close')"
          class="bg-gray-300 text-gray-800 px-6 py-2 rounded-xl font-semibold hover:bg-gray-400"
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

const props = defineProps({
  user: Object,
  show: Boolean
})

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
    alert('User role updated successfully.')
    emit('updated')
    emit('close')
  } catch (error) {
    console.error('Error updating user role:', error)
    alert('Failed to update user role.')
  }
}
</script>
