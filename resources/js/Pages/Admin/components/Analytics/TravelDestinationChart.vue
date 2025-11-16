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
import { computed } from "vue";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

const props = defineProps({
  destinations: { type: Object, required: true },
});

const categories = computed(() => Object.keys(props.destinations));
const dataValues = computed(() => Object.values(props.destinations));

const chartData = computed(() => ({
  labels: categories.value,
  datasets: [
    {
      label: "Location",
      data: dataValues.value,
      backgroundColor: categories.value.map(() => "rgba(54, 162, 235, 0.3)"),
      borderColor: categories.value.map(() => "rgba(54, 162, 235, 0.6)"),
      borderWidth: 1,
      borderRadius: 6,
      barPercentage: 0.6,
    },
  ],
}));

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
