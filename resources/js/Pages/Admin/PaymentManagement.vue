<template>
    <!-- Section Header -->
    <section class="bg-white rounded-2xl shadow-lg p-6">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
        <h2 class="text-2xl font-bold text-[#1E71B8]">Mode of Payment</h2>

        <button
          @click="showAddModal = true"
          class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r 
                 from-[#1E71B8] to-[#2a8bb5] hover:from-[#2a8bb5] hover:to-[#1E71B8]
                 text-white font-semibold rounded-xl transition-all shadow-lg"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4v16m8-8H4"/>
          </svg>
          Add Mode of Payment
        </button>
      </div>

      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div v-if="storedModeOfPayments.length > 0" class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white">
                <th class="px-6 py-4 text-center text-sm font-semibold">ID</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Mode of Payment</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Created By</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Created At</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr v-for="mode in storedModeOfPayments" :key="mode.id" class="hover:bg-blue-50/50 transition-colors">
                <td class="px-6 py-4 text-sm font-medium text-gray-900 text-center">
                  <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-semibold">
                    #{{ mode.id }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-700 text-center">
                  {{ mode.mode_of_payment }}
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-700 text-center">
                  {{ mode.created_by }}
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-700 text-center">
                  {{ new Date(mode.created_at).toLocaleString() }}
                </td>
                <td class="px-6 py-4 text-sm text-center flex justify-center gap-2">
                  <!-- Edit & Delete buttons (placeholders) -->
                  <button class="p-2 hover:bg-[#1E71B8] hover:text-white rounded-lg transition-all group" title="Edit"
                    @click="openUpdateModal(mode)">
                    <svg class="w-5 h-5 text-[#1E71B8] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button class="p-2 hover:bg-red-500 hover:text-white rounded-lg transition-all group" title="Delete"
                    @click="openDeleteModal(mode)">
                    <svg class="w-5 h-5 text-red-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-else class="p-6 text-center text-gray-500">No mode of payments found.</div>
      </div>
    </section>

    <AddModeOfPayment :show="showAddModal" @close="showAddModal = false" @saved="fetchModeOfPayments" />
    <UpdateModeOfPayment :show="showUpdateModal" :payment="paymentToUpdate" @close="showUpdateModal = false" @saved="fetchModeOfPayments" />
    <DeleteModeOfPayment :show="showDeleteModal" :payment="paymentToDelete" @close="showDeleteModal = false" @saved="fetchModeOfPayments" />
</template>

<script setup>
import AdminIndex from "./AdminIndex.vue";
import { ref, onMounted } from "vue";
import { api } from "../../api/api";
import AddModeOfPayment from "./components/AddModeOfPayment.vue";
import UpdateModeOfPayment from "./components/UpdateModeOfPayment.vue";
import DeleteModeOfPayment from "./components/DeleteModeOfPayment.vue";

defineOptions({ layout: AdminIndex });

const service = new api();
const storedModeOfPayments = ref([]);

const showAddModal = ref(false);
const showUpdateModal = ref(false);
const showDeleteModal = ref(false);

const paymentToUpdate = ref(null);
const paymentToDelete = ref(null);

const fetchModeOfPayments = async () => {
  try {
    const res = await service.fetchModeOfPayments();
    storedModeOfPayments.value = res.data.data;
  } catch (error) {
    console.error(error);
  }
};

const openUpdateModal = (mode) => {
  paymentToUpdate.value = mode;
  showUpdateModal.value = true;
};

const openDeleteModal = (mode) => {
  paymentToDelete.value = mode;
  showDeleteModal.value = true;
};

onMounted(() => {
  fetchModeOfPayments();
});
</script>
