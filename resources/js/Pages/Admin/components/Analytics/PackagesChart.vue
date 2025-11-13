<template>
  <div class="rounded-xl w-80 max-w-full font-sans">
    <p class="font-semibold text-lg text-gray-800 mb-5">Packages</p>
    <div class="w-full h-64">
      <Pie :data="chartData" :options="chartOptions" />
    </div>
    <div class="flex justify-around mt-4">
      <div class="flex items-center text-gray-600 text-sm">
        <span class="w-3 h-3 rounded-full bg-green-400 mr-2"></span> Active {{ props.activePackages }} 
      </div>
      <div class="flex items-center text-gray-600 text-sm">
        <span class="w-3 h-3 rounded-full bg-red-400 mr-2"></span> Inactive {{ props.inactivePackages }}
      </div>
    </div>

    <div class="flex justify-around mt-4 text-gray-600 text-sm">Total Active Packages: {{totalPackages}}</div>

  </div>
</template>

<script setup>
import { Pie } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from "chart.js";
import { computed } from "vue";

ChartJS.register(Title, Tooltip, Legend, ArcElement);

const props = defineProps({
  activePackages: { type: Number, required: true },
  inactivePackages: { type: Number, required: true },
});

const chartData = computed(() => ({
  labels: ["Active", "Inactive"],
  datasets: [
    {
      label: "Packages",
      data: [props.activePackages, props.inactivePackages],
      backgroundColor: ["rgba(80, 255, 120, 0.7)", "rgba(255, 60, 90, 0.7)"],
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

const totalPackages = computed(() => props.activePackages + props.inactivePackages);
</script>
