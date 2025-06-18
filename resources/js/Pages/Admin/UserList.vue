<script setup>
import AdminIndex from './AdminIndex.vue'
import EditUserModal from './components/EditUserModal.vue'
import { api } from '../../api/api'
import { ref, onMounted } from 'vue'

defineOptions({ layout: AdminIndex })

const service = new api();
const users = ref([])
const selectedUser = ref(null)
const showEditModal = ref(false)

const openUpdateEntryModal = (user) => {
  selectedUser.value = user
  showEditModal.value = true
}

const handleUserUpdated = async () => {
  await fetchUsers()  
  showEditModal.value = false
}
const fetchUsers = async () => {
    try {
        const response = await service.getUsers();
        users.value = response.data.data
        console.log('Users fetched successfully:', users.value)
    } catch (error) {
        console.error('Error fetching users:', error)
    }
}

onMounted(() => {
    fetchUsers()
})

</script>

<template>
  <div class="admin-users-wrapper">
    <h2 class="admin-users-title">Users List</h2>
    <div class="admin-users-controls">
      <input
        type="text"
        placeholder="Search"
        class="admin-users-search"
      />
      <div class="admin-users-filters">
        <select class="admin-users-select">
          <option>All</option>
          <option>Approved</option>
          <option>Pending Review</option>
          <option>Rejected</option>
        </select>
        <button class="admin-users-filter-btn" title="Filter">
          <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-.293.707l-6.414 6.414A1 1 0 0 0 14 14.414V19a1 1 0 0 1-1.447.894l-4-2A1 1 0 0 1 8 17v-2.586a1 1 0 0 0-.293-.707L1.293 6.707A1 1 0 0 1 1 6V4z"/>
          </svg>
        </button>
        <button class="admin-users-add-btn" @click="openNewEntryModal">
          Add new user
        </button>
      </div>
    </div>
    <div class="admin-users-table-wrapper">
      <table class="admin-users-table">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>Role</th>
            <th>Email</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.first_name }} {{ user.last_name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phone_number || 'N/A' }}</td>
                <td>{{ user.role }}</td>
                <td>{{ user.email_verified_at ? 'Verified' : 'Not Verified' }}</td>
                <td>
                <button class="admin-users-edit-btn" title="Edit" @click="openUpdateEntryModal(user)">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 1 1 2.828 2.828L11.828 15.828a2 2 0 0 1-1.414.586H7v-3a2 2 0 0 1 .586-1.414z"/>
                    </svg>
                </button>
                </td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>

    <EditUserModal
        v-if="showEditModal"
        :user="selectedUser"
        :show="showEditModal"
        @updated="handleUserUpdated"
        @close="showEditModal = false"
    />
</template>

<style scoped>
.admin-users-wrapper {
  padding: 32px 0 0 0;
}
.admin-users-title {
  text-align: center;
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 24px;
}
.admin-users-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
  gap: 18px;
}
.admin-users-search {
  width: 240px;
  padding: 8px 16px;
  border: 1.5px solid #888;
  border-radius: 8px;
  font-size: 1rem;
}
.admin-users-filters {
  display: flex;
  align-items: center;
  gap: 10px;
}
.admin-users-select {
  padding: 8px 16px;
  border: 1.5px solid #888;
  border-radius: 8px;
  font-size: 1rem;
}
.admin-users-filter-btn {
  background: #fff;
  border: 1.5px solid #888;
  border-radius: 8px;
  padding: 7px 10px;
  cursor: pointer;
  transition: background 0.2s;
  display: flex;
  align-items: center;
}
.admin-users-filter-btn:hover {
  background: #f0f0f0;
}
.admin-users-add-btn {
  background: #fff;
  border: 1.5px solid #888;
  border-radius: 8px;
  padding: 7px 18px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
  margin-left: 10px;
}
.admin-users-add-btn:hover {
  background: #217093;
  color: #fff;
  border-color: #217093;
}
.admin-users-table-wrapper {
  margin-top: 18px;
  overflow-x: auto;
}
.admin-users-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
}
.admin-users-table th,
.admin-users-table td {
  border: 2px solid #888;
  padding: 10px 8px;
  text-align: left;
  font-size: 1rem;
}
.admin-users-table th {
  background: #e5e5e5;
  font-weight: 600;
}
.admin-users-edit-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  color: #222;
  transition: color 0.2s;
}
.admin-users-edit-btn:hover {
  color: #217093;
}
</style>