<template>
    <div>
        <p style="font-weight: bold;">Payments</p>
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
    labels: ['Fully Paid', 'Down Payment', 'Under Review'],
    datasets: [
        {
        label: 'Packages',
        data: [40, 25, 10],
        backgroundColor: [
            'rgba(40, 167, 69, 0.7)',
            'rgba(0, 123, 255, 0.7)',
            'rgba(255, 193, 7, 0.7)',
            
            ],
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
