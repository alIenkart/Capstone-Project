<template>
  <div class="bg-white rounded-2xl p-6 shadow-sm w-full max-w-5xl mx-auto mt-6">
    <div class="w-full h-80">
      <Bar :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script setup>
import { Bar } from "vue-chartjs";
import { computed } from "vue";
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

const props = defineProps({
  revenue: { type: Array, required: true },
});

// Month labels
const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

const chartData = computed(() => {
  if (props.revenue.length === 0) {
    return { labels: [], datasets: [] };
  }

  let labels = [];
  let data = [];

  if (props.revenue[0].month) {
    labels = months;
    data = Array(12).fill(0);

    props.revenue.forEach(item => {
      const [year, month] = item.month.split("-").map(Number);
      if (month >= 1 && month <= 12) {
        data[month - 1] = item.total_revenue;
      }
    });
  } else if (props.revenue[0].year) {
    labels = props.revenue.map(item => item.year);
    data = props.revenue.map(item => item.total_revenue);
  }

  return {
    labels,
    datasets: [
      {
        label: props.revenue[0].month ? "Monthly Sales" : "Yearly Sales",
        data,
        backgroundColor: "rgba(54, 162, 235, 0.3)",
        borderColor: "rgba(54, 162, 235, 0.6)",
        borderWidth: 1,
        borderRadius: 6,
        barPercentage: 0.7,
        categoryPercentage: 0.7,
      },
    ],
  };
});

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: false },
    tooltip: { enabled: true },
  },
  scales: {
    y: {
      beginAtZero: true,
      grid: {
        color: "rgba(200, 200, 200, 0.3)",
        borderColor: "transparent",
      },
      ticks: {
        color: "#555",
        stepSize: 10,
        font: { size: 12 },
      },
    },
    x: {
      grid: { display: false },
      ticks: {
        color: "#555",
        maxRotation: 0,
        minRotation: 0,
        autoSkip: false,
        font: { size: 12 },
      },
    },
  },
};
</script>

<style scoped>
.chart-container {
  width: 100%;
  height: 100%;
}
</style>
