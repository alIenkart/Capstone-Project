<template>
    <div class="rounded-xl w-full max-w-full font-sans flex flex-col h-full">
        <p class="font-semibold text-lg text-gray-800 mb-4">Payments</p>
        <div class="w-full h-64">
            <Pie :data="chartData" :options="chartOptions" />
        </div>
        <div class="grid grid-cols-2 gap-2 mt-4 legend-grid">
            <div class="flex items-center text-gray-600 text-sm">
                <span class="w-3 h-3 rounded-full bg-green-600 mr-2"></span>
                <span>Fully Paid</span>
            </div>
            <div class="flex items-center text-gray-600 text-sm">
                <span class="w-3 h-3 rounded-full bg-blue-600 mr-2"></span>
                <span>Down Payment</span>
            </div>
            <div class="flex items-center text-gray-600 text-sm">
                <span class="w-3 h-3 rounded-full bg-yellow-400 mr-2"></span>
                <span>Under Review</span>
            </div>
        </div>
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
            label: 'Payments',
            data: [40, 25, 10],
            backgroundColor: [
                'rgba(40, 167, 69, 0.7)',
                'rgba(0, 123, 255, 0.7)',
                'rgba(255, 193, 7, 0.7)',
            ],
            borderRadius: 10,
            hoverOffset: 10,
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
.legend-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}

.legend-grid>div {
    white-space: nowrap;
}
</style>