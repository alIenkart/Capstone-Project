<template>
  <div class="rounded-xl w-full max-w-full font-sans flex flex-col h-full">
    <p class="font-semibold text-lg text-gray-800 mb-4">Bookings</p>
    <div class="w-full h-64">
      <Pie :data="chartData" :options="chartOptions" />
    </div>
    <div class="grid grid-cols-2 gap-1 mt-4 legend-grid">
      <div class="flex items-center text-gray-600 text-sm">
        <span class="w-3 h-3 rounded-full bg-blue-400 mr-2"></span> Approved
      </div>
      <div class="flex items-center text-gray-600 text-sm">
        <span class="w-3 h-3 rounded-full bg-yellow-400 mr-2"></span> Pending
      </div>
      <div class="flex items-center text-gray-600 text-sm">
        <span class="w-3 h-3 rounded-full bg-teal-400 mr-2"></span> Cancelled
      </div>
      <div class="flex items-center text-gray-600 text-sm">
        <span class="w-3 h-3 rounded-full bg-purple-400 mr-2"></span> Rejected
      </div>
    </div>
  </div>
</template>

<script setup>
import { Pie } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from "chart.js";
import { computed } from "vue";

ChartJS.register(Title, Tooltip, Legend, ArcElement);

const props = defineProps({
  approvedBooking: { type: Number, required: true },
  pendingBooking: { type: Number, required: true },
  rejectedBooking: { type: Number, required: true },
  cancelledBooking: { type: Number, required: true },
});

const chartData = computed(() => ({
  labels: ["Pending Review", "Approved", "Cancelled", "Rejected", "Completed"],
  datasets: [
    {
      label: "Bookings",
      data: [
        props.approvedBooking, 
        props.pendingBooking,
        props.rejectedBooking,
        props.cancelledBooking,
      ],
        backgroundColor: [
        "rgba(54, 162, 235, 0.7)",
        "rgba(255, 206, 86, 0.7)",
        "rgba(75, 192, 192, 0.7)",
        "rgba(153, 102, 255, 0.7)",
        "rgba(255, 99, 132, 0.7)",
      ],
      borderRadius: 10,
      hoverOffset: 10,
    },
  ],
}));

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false,
    },
  },
};
</script>

<style scoped>
.legend-grid {
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

.legend-grid > div {
  white-space: nowrap;
}
</style>
