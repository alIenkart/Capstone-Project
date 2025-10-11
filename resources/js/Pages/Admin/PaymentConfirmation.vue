<script setup>
import AdminIndex from './AdminIndex.vue'
import { ref, onMounted } from 'vue'
import { api } from '../../api/api'
import ApprovalPaymentModal from '@/Pages/Admin/components/ApprovalPaymentModal.vue'

defineOptions({ layout: AdminIndex })

const service = new api();
const payments = ref([])

const fetchPayments = async () => {
    try {
        const response = await service.getPayments();
        payments.value = response.data
        console.log('Payments fetched:', payments.value)
    } catch (error) {
        console.error('Error fetching bookings:', error)
    }
}

onMounted(() => {
    fetchPayments()
})

const showApprovalPaymentModal = ref(false)
const openApprovalPaymentModal = () => {
  showApprovalPaymentModal.value = true
}
const handleApprovalPaymentClose = () => {
  showApprovalPaymentModal.value = false
}
</script>

<template>
  <div class="admin-payment-wrapper">
    <h2 class="admin-payment-title">
      Payment Confirmation
    </h2>
          <!-- Button to open modal for demo (Pakiremove na lang po if done na) -->
      <button @click="openApprovalPaymentModal">
        Show Payment Approval Modal
      </button>
    <div class="admin-payment-controls">
      <input
        type="text"
        placeholder="Search"
        class="admin-payment-search"
      />
      <div class="admin-payment-filters">
        <select class="admin-payment-select">
          <option>All</option>
          <option>Approved</option>
          <option>Pending Confirmation</option>
          <option>Rejected</option>
        </select>
        <button class="admin-payment-filter-btn" title="Filter">
          <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-.293.707l-6.414 6.414A1 1 0 0 0 14 14.414V19a1 1 0 0 1-1.447.894l-4-2A1 1 0 0 1 8 17v-2.586a1 1 0 0 0-.293-.707L1.293 6.707A1 1 0 0 1 1 6V4z"/>
          </svg>
        </button>
      </div>
    </div>
    <div class="admin-payment-table-wrapper">
      <table class="admin-payment-table">
        <thead>
          <tr>
            <th>Payment ID</th>
            <th>Booking ID</th>
            <th>Customer Name</th>
            <th>Payment Entry</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="p in payments" :key="p.payment_id">
            <td>{{ p.id }}</td>
            <td>{{ p.booking_id }}</td>
            <td>{{ p.booking?.customer_name || 'N/A' }}</td>
            <td>
              <svg class="inline mr-1" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="18" height="18" rx="3" stroke="#888"/>
                <path d="M8 12l2 2 4-4" stroke="#217093" stroke-width="2" fill="none"/>
              </svg>
              {{ p.payment_entry }}
            </td>
            <td>{{ p.payment_status }}</td>
            <td>{{ p.payment_method }}</td>
            <td>
              <button class="admin-payment-edit-btn" title="Edit" @click="openApprovalPaymentModal">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 1 1 2.828 2.828L11.828 15.828a2 2 0 0 1-1.414.586H7v-3a2 2 0 0 1 .586-1.414z"/>
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Approval Payment Modal -->
    <ApprovalPaymentModal
      v-if="showApprovalPaymentModal"
      @close="handleApprovalPaymentClose"
    />
  </div>
</template>

<style scoped>
.admin-payment-wrapper {
  padding: 32px 0 0 0;
}
.admin-payment-title {
  text-align: center;
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 24px;
  color: #1E71B8;
}
.admin-payment-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
  gap: 18px;
}
.admin-payment-search {
  width: 240px;
  padding: 8px 16px;
  border: 1.5px solid #1E71B8;
  border-radius: 8px;
  font-size: 1rem;
  color: #1E71B8;
}
.admin-payment-filters {
  display: flex;
  align-items: center;
  gap: 10px;
}
.admin-payment-select {
  padding: 8px 16px;
  border: 1.5px solid #1E71B8;
  border-radius: 8px;
  font-size: 1rem;
  color: #1E71B8;
}
.admin-payment-filter-btn {
  background: #fff;
  border: 1.5px solid #1E71B8;
  border-radius: 8px;
  padding: 7px 10px;
  cursor: pointer;
  transition: background 0.2s;
  display: flex;
  align-items: center;
  color: #1E71B8;
}
.admin-payment-filter-btn:hover {
  background: #73BE5D;
  color: #fff;
}
.admin-payment-table-wrapper {
  margin-top: 18px;
  overflow-x: auto;
}
.admin-payment-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
}
.admin-payment-table th,
.admin-payment-table td {
  border: 2px solid #1E71B8;
  padding: 10px 8px;
  text-align: left;
  font-size: 1rem;
}
.admin-payment-table th {
  background: #1E71B8;
  color: #fff;
  font-weight: 600;
}
.admin-payment-edit-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  color: #1E71B8;
  transition: color 0.2s;
}
.admin-payment-edit-btn:hover {
  color: #73BE5D;
}
</style>