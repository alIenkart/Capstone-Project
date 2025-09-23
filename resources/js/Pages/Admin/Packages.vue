<script setup>
import AdminIndex from './AdminIndex.vue'
import NewPackageModal from '@/Pages/Admin/components/NewPackageModal.vue'
import EditPackageModal from '@/Pages/Admin/components/EditPackageModal.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'

defineOptions({ layout: AdminIndex })

const showModal = ref(false)
const showEditModal = ref(false)
const selectedPackageId = ref(null)
const packages = ref([])

const createNewPackage = () => {
    showModal.value = true
}

const handleSavePackage = (packageData) => {
    fetchPackages();
}

const openEditModal = (packageId) => {
    selectedPackageId.value = packageId;
    showEditModal.value = true;
}

const handlePackageUpdated = (updatedPackage) => {
    fetchPackages();
}

const fetchPackages = async () => {
    try {
        const response = await axios.get('/api/packages')
        packages.value = response.data.data
    } catch (error) {
        console.error('Error fetching packages:', error)
    }
}

onMounted(() => {
    fetchPackages()
})
</script>

<template>
  <div class="admin-packages-wrapper">
    <h2 class="admin-packages-title">Package Management</h2>
    <div class="admin-packages-controls">
      <input
        type="text"
        placeholder="Search"
        class="admin-packages-search"
      />
      <div class="admin-packages-filters">
        <select class="admin-packages-select">
          <option>All</option>
          <option>Active</option>
          <option>Inactive</option>
        </select>
        <button class="admin-packages-filter-btn" title="Filter">
          <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-.293.707l-6.414 6.414A1 1 0 0 0 14 14.414V19a1 1 0 0 1-1.447.894l-4-2A1 1 0 0 1 8 17v-2.586a1 1 0 0 0-.293-.707L1.293 6.707A1 1 0 0 1 1 6V4z"/>
          </svg>
        </button>
        <button class="admin-packages-add-btn" @click="createNewPackage">
          Add new Package
        </button>
      </div>
    </div>
    <div class="admin-packages-table-wrapper">
      <table class="admin-packages-table">
        <thead>
          <tr>
            <th>Package ID</th>
            <th>Package Name</th>
            <th>Destination</th>
            <th>Region</th>
            <th>Max Occupancy</th>
            <th>Booking Type</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Base Price per Pax</th>
            <th>Kids Price per Pax</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="packageItem in packages" :key="packageItem.id">
            <td>{{ packageItem.id }}</td>
            <td>{{ packageItem.package_name }}</td>
            <td>{{ packageItem.destination }}</td>
            <td>{{ packageItem.region }}</td>
            <td>{{ packageItem.capacity }}</td>
            <td>{{ packageItem.joint_booking ? 'Joint' : 'Exclusive' }}</td>
            <td>{{ packageItem.tour_duration }}</td>
            <td>{{ packageItem.status }}</td>
            <td>{{ packageItem.pax_rate }}</td>
            <td>{{ packageItem.kids_pax_rate }}</td>
            <td>
              <button class="admin-packages-edit-btn" @click="openEditModal(packageItem.id)" title="Edit">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 1 1 2.828 2.828L11.828 15.828a2 2 0 0 1-1.414.586H7v-3a2 2 0 0 1 .586-1.414z"/>
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <NewPackageModal
      :show="showModal"
      @close="showModal = false"
      @save="handleSavePackage"
    />

    <EditPackageModal
      :show="showEditModal"
      :packageId="selectedPackageId"
      @close="showEditModal = false; selectedPackageId = null"
      @saved="handlePackageUpdated"
    />
  </div>
</template>

<style scoped>
.admin-packages-wrapper {
  padding: 32px 0 0 0;
}
.admin-packages-title {
  text-align: center;
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 24px;
}
.admin-packages-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
  gap: 18px;
}
.admin-packages-search {
  width: 240px;
  padding: 8px 16px;
  border: 1.5px solid #888;
  border-radius: 8px;
  font-size: 1rem;
}
.admin-packages-filters {
  display: flex;
  align-items: center;
  gap: 10px;
}
.admin-packages-select {
  padding: 8px 16px;
  border: 1.5px solid #888;
  border-radius: 8px;
  font-size: 1rem;
}
.admin-packages-filter-btn {
  background: #fff;
  border: 1.5px solid #888;
  border-radius: 8px;
  padding: 7px 10px;
  cursor: pointer;
  transition: background 0.2s;
  display: flex;
  align-items: center;
}
.admin-packages-filter-btn:hover {
  background: #f0f0f0;
}
.admin-packages-add-btn {
  background: #fff;
  border: 1.5px solid #888;
  border-radius: 8px;
  padding: 7px 18px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
  margin-left: 10px;
}
.admin-packages-add-btn:hover {
  background: #217093;
  color: #fff;
  border-color: #217093;
}
.admin-packages-table-wrapper {
  margin-top: 18px;
  overflow-x: auto;
}
.admin-packages-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
}
.admin-packages-table th,
.admin-packages-table td {
  border: 2px solid #888;
  padding: 10px 8px;
  text-align: left;
  font-size: 1rem;
}
.admin-packages-table th {
  background: #e5e5e5;
  font-weight: 600;
}
.admin-packages-edit-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  color: #222;
  transition: color 0.2s;
}
.admin-packages-edit-btn:hover {
  color: #217093;
}

/* Mobile/tablet responsiveness */
.admin-packages-table-wrapper {
  -webkit-overflow-scrolling: touch;
}

.admin-packages-table {
  min-width: 900px; /* force horizontal scroll on small screens */
}

@media (max-width: 1024px) {
  .admin-packages-table th,
  .admin-packages-table td {
    padding: 8px 6px;
    font-size: 0.95rem;
  }
}

@media (max-width: 768px) {
  .admin-packages-title {
    font-size: 1.1rem;
  }

  .admin-packages-controls {
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
  }

  .admin-packages-search {
    width: 100%;
  }

  .admin-packages-filters {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }

  .admin-packages-select {
    flex: 1 1 180px;
  }

  .admin-packages-filter-btn {
    padding: 8px 12px;
  }

  .admin-packages-add-btn {
    width: 100%;
    text-align: center;
  }

  .admin-packages-table th,
  .admin-packages-table td {
    padding: 8px 6px;
    font-size: 0.9rem;
  }

  .admin-packages-table {
    min-width: 720px; /* ensure columns remain readable; scroll handles overflow */
  }
}

@media (max-width: 480px) {
  .admin-packages-filter-btn svg {
    width: 18px;
    height: 18px;
  }

  .admin-packages-select {
    flex: 1 1 100%;
  }
}
</style>