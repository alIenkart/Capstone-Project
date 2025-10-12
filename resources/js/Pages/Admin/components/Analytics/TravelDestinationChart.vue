<template>
    <div>
        <p style="font-weight: bold;">Top Travel Destination</p>
    </div>

    <div class="chart-container">
        <Bar :data="chartData" :options="chartOptions" />
    </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const categories = [
  'South Korea', 'Canada', 'United Kingdom', 'Netherlands',
  'Italy', 'France', 'Japan', 'United States', 'China', 'Germany'
]

const dataValues = [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]

const chartData = {
  labels: categories,
  datasets: [
        {
        label: 'Location',
        data: dataValues,
        backgroundColor: ['rgba(54, 162, 235, 0.3)',],
        borderColor: ['rgba(54, 162, 235, 0.6)',],
        }
    ]
}

const chartOptions = {
  indexAxis: 'y',
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    },
    tooltip: {
      enabled: true
    }
  },
  scales: {
    x: {
      beginAtZero: true
    },
    y: {
      ticks: {
        autoSkip: false,
      }
    }
  }
}
</script>

<style scoped>
.chart-container {
  width: 400px;
  height: 300px;
  max-width: 1000px;
}
</style>
