<template>
    <div>
        <p style="font-weight: bold;">Packages</p>
    </div>

    <div class="chart-container">
        <Pie :data="chartData" :options="chartOptions" />
    </div>
</template>


<script setup>
import { Pie } from 'vue-chartjs'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement)

const chartData = {
    labels: ['Active', 'Inactive'],
    datasets: [
        {
        label: 'Packages',
        data: [40, 25],
        backgroundColor: ['rgba(80, 255, 120, 0.7)', 'rgba(255, 60, 90, 0.7)'],
        },
    ],
}

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false,
      },
    },
}
</script>

<style scoped>
.chart-container {
  width: 300px;
  height: 250px;
  max-width: 1000px;
}
</style>
