<template>
  <div class="rounded-xl w-80 max-w-full font-sans">
    <p class="font-semibold text-lg text-gray-800 mb-5">Packages</p>
    <div class="w-full h-64">
      <Pie :data="chartData" :options="chartOptions" />
    </div>
    <div class="flex justify-around mt-4">
      <div class="flex items-center text-gray-600 text-sm">
        <span class="w-3 h-3 rounded-full bg-green-400 mr-2"></span> Active
      </div>
      <div class="flex items-center text-gray-600 text-sm">
        <span class="w-3 h-3 rounded-full bg-red-400 mr-2"></span> Inactive
      </div>
    </div>
  </div>
</template>

<script setup>
import { Pie } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from "chart.js";

ChartJS.register(Title, Tooltip, Legend, ArcElement);

const chartData = {
  labels: ["Active", "Inactive"],
  datasets: [
    {
      label: "Packages",
      data: [40, 25],
      backgroundColor: ["rgba(80, 255, 120, 0.7)", "rgba(255, 60, 90, 0.7)"],
      borderRadius: 10,
      hoverOffset: 10,
    },
  ],
};

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
