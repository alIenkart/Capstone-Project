<template>
  <div class="flex flex-col space-y-4 w-full max-w-4xl mx-auto">
    <div>
      <p class="font-semibold text-lg text-gray-800">Top Travel Destination</p>
    </div>
    <div class="w-full h-80">
      <Bar :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script setup>
import { Bar } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

const categories = [
  "South Korea",
  "Canada",
  "United Kingdom",
  "Netherlands",
  "Italy",
  "France",
  "Japan",
  "United States",
  "China",
  "Germany",
];

const dataValues = [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380];

const chartData = {
  labels: categories,
  datasets: [
    {
      label: "Location",
      data: dataValues,
      backgroundColor: categories.map(() => "rgba(54, 162, 235, 0.3)"),
      borderColor: categories.map(() => "rgba(54, 162, 235, 0.6)"),
      borderWidth: 1,
      borderRadius: 6,
      barPercentage: 0.6,
    },
  ],
};

const chartOptions = {
  indexAxis: "y",
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: false },
    tooltip: { enabled: true },
  },
  scales: {
    x: {
      beginAtZero: true,
      grid: { color: "rgba(0,0,0,0.05)" },
      ticks: { color: "#4B5563", font: { size: 12 } },
    },
    y: {
      ticks: { color: "#4B5563", font: { size: 12 }, autoSkip: false },
      grid: { drawTicks: false, drawBorder: false },
    },
  },
};
</script>
