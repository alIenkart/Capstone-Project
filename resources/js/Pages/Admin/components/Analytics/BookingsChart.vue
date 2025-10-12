<template>
    <div>
        <p style="font-weight: bold;">Bookings</p>
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
    labels: ['Pending Review',
            'Approved',
            'Cancelled',
            'Rejected',
            'Completed'
        ],

    datasets: [
        {
        label: 'Packages',
        data: [40, 25, 15, 5, 10],
        backgroundColor: [
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 99, 132, 0.7)'
        ]
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
