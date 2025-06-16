<script setup>
import AdminIndex from './AdminIndex.vue'
import NewEntryModal from '@/Pages/Admin/components/NewEntryModal.vue'
import { ref } from 'vue'

defineOptions({ layout: AdminIndex })

const showNewEntryModal = ref(false)

const bookingEntries = [
  {
    booking_id: 'B10425',
    package_id: 'P10625',
    customer_name: 'John Bert',
    status: 'Approved',
    total_pax: 10,
    discount_id: 'Yes',
    entry_date: '4/18/2025',
    total_sum: '15,000'
  }
]

const openNewEntryModal = () => {
  showNewEntryModal.value = true
}
const handleNewEntryClose = () => {
  showNewEntryModal.value = false
}
</script>

<template>
  <div class="admin-bookings-wrapper">
    <h2 class="admin-bookings-title">Booking Entries</h2>
    <div class="admin-bookings-controls">
      <input
        type="text"
        placeholder="Search"
        class="admin-bookings-search"
      />
      <div class="admin-bookings-filters">
        <select class="admin-bookings-select">
          <option>All</option>
          <option>Approved</option>
          <option>Pending Review</option>
          <option>Rejected</option>
        </select>
        <button class="admin-bookings-filter-btn" title="Filter">
          <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-.293.707l-6.414 6.414A1 1 0 0 0 14 14.414V19a1 1 0 0 1-1.447.894l-4-2A1 1 0 0 1 8 17v-2.586a1 1 0 0 0-.293-.707L1.293 6.707A1 1 0 0 1 1 6V4z"/>
          </svg>
        </button>
        <button class="admin-bookings-add-btn" @click="openNewEntryModal">
          Add new Entry
        </button>
      </div>
    </div>
    <div class="admin-bookings-table-wrapper">
      <table class="admin-bookings-table">
        <thead>
          <tr>
            <th>Booking ID</th>
            <th>Package ID</th>
            <th>Customer Name</th>
            <th>Booking Status</th>
            <th>Total Pax</th>
            <th>Discount ID</th>
            <th>Entry Date</th>
            <th>Total Sum</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="entry in bookingEntries" :key="entry.booking_id + entry.package_id">
            <td>{{ entry.booking_id }}</td>
            <td>{{ entry.package_id }}</td>
            <td>{{ entry.customer_name }}</td>
            <td>{{ entry.status }}</td>
            <td>{{ entry.total_pax }}</td>
            <td>
              <span v-if="entry.discount_id === 'Yes'">
                <svg class="inline" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <rect x="3" y="3" width="18" height="18" rx="3" stroke="#888"/>
                  <path d="M8 12l2 2 4-4" stroke="#217093" stroke-width="2" fill="none"/>
                </svg>
                Yes
              </span>
              <span v-else>No</span>
            </td>
            <td>{{ entry.entry_date }}</td>
            <td>{{ entry.total_sum }}</td>
            <td>
              <button class="admin-bookings-edit-btn" title="Edit">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 1 1 2.828 2.828L11.828 15.828a2 2 0 0 1-1.414.586H7v-3a2 2 0 0 1 .586-1.414z"/>
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- New Entry Modal -->
    <NewEntryModal v-if="showNewEntryModal" @close="handleNewEntryClose" />
  </div>
</template>

<style scoped>
.admin-bookings-wrapper {
  padding: 32px 0 0 0;
}
.admin-bookings-title {
  text-align: center;
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 24px;
}
.admin-bookings-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
  gap: 18px;
}
.admin-bookings-search {
  width: 240px;
  padding: 8px 16px;
  border: 1.5px solid #888;
  border-radius: 8px;
  font-size: 1rem;
}
.admin-bookings-filters {
  display: flex;
  align-items: center;
  gap: 10px;
}
.admin-bookings-select {
  padding: 8px 16px;
  border: 1.5px solid #888;
  border-radius: 8px;
  font-size: 1rem;
}
.admin-bookings-filter-btn {
  background: #fff;
  border: 1.5px solid #888;
  border-radius: 8px;
  padding: 7px 10px;
  cursor: pointer;
  transition: background 0.2s;
  display: flex;
  align-items: center;
}
.admin-bookings-filter-btn:hover {
  background: #f0f0f0;
}
.admin-bookings-add-btn {
  background: #fff;
  border: 1.5px solid #888;
  border-radius: 8px;
  padding: 7px 18px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
  margin-left: 10px;
}
.admin-bookings-add-btn:hover {
  background: #217093;
  color: #fff;
  border-color: #217093;
}
.admin-bookings-table-wrapper {
  margin-top: 18px;
  overflow-x: auto;
}
.admin-bookings-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
}
.admin-bookings-table th,
.admin-bookings-table td {
  border: 2px solid #888;
  padding: 10px 8px;
  text-align: left;
  font-size: 1rem;
}
.admin-bookings-table th {
  background: #e5e5e5;
  font-weight: 600;
}
.admin-bookings-edit-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  color: #222;
  transition: color 0.2s;
}
.admin-bookings-edit-btn:hover {
  color: #217093;
}
</style>