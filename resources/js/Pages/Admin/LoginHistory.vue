<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-8">
        <div class="max-w-8xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="relative flex-1 max-w-md">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input v-model="searchQuery" type="text" placeholder="Search records..."
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none transition-all" />
                    </div>

                    <div class="flex items-center gap-3 flex-wrap">
                        <div class="relative">
                            <button @click="isFilterOpen = !isFilterOpen"
                                class="w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 min-w-[180px]">
                                <span class="font-semibold text-gray-800">{{ filterType }}</span>
                                <svg :class="['w-5 h-5 text-blue-600 transition-transform duration-300', isFilterOpen ? 'rotate-180' : '']"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>

                            <div v-if="isFilterOpen" @click.stop
                                class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl z-10 overflow-hidden">
                                <div v-for="option in filterOptions" :key="option" @click="handleFilterSelect(option)"
                                    :class="['px-4 py-3 cursor-pointer transition-all duration-150 flex items-center gap-3 border-b border-gray-100 last:border-b-0 hover:bg-blue-50', filterType === option ? 'bg-blue-50 border-l-4 border-l-blue-500' : '']">
                                    <span
                                        :class="['font-medium', filterType === option ? 'text-blue-700' : 'text-gray-700']">
                                        {{ option }}
                                    </span>
                                    <svg v-if="filterType === option" class="w-5 h-5 text-blue-600 ml-auto"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div v-if="paginatedData.length > 0" class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white">
                                <th class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap">
                                    First Name
                                </th>
                                <th class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap">
                                    Last Name
                                </th>
                                <th class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap">
                                    Email
                                </th>
                                <th class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap">
                                    Contact Number
                                </th>
                                <th class="px-6 py-4 text-center text-sm font-semibold whitespace-nowrap">
                                    Login Time
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="row in paginatedData" :key="row.id"
                                class="hover:bg-blue-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-center">
                                    {{ row.firstName }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-center">
                                    {{ row.lastName }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 text-center">{{ row.email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 text-center">{{ row.contact }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-100 text-[#1E71B8] font-medium text-xs">
                                        {{ row.loginTime }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else class="py-16 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                        No login records found
                    </h3>
                    <p class="text-gray-500">Try adjusting your search or filter criteria</p>
                </div>

                <div v-if="paginatedData.length > 0" class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-semibold">{{ startIndex + 1 }}</span> to
                            <span class="font-semibold">{{ endIndex }}</span> of
                            <span class="font-semibold">{{ filteredData.length }}</span> results
                        </p>
                        <div class="flex gap-2">
                            <button @click="previousPage" :disabled="currentPage === 1"
                                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                Previous
                            </button>
                            <button v-for="page in visiblePages" :key="page" @click="currentPage = page"
                                :class="['px-4 py-2 rounded-lg font-semibold transition-all', currentPage === page ? 'bg-[#1E71B8] text-white' : 'border-2 border-gray-200 hover:bg-gray-100']">
                                {{ page }}
                            </button>
                            <button @click="nextPage" :disabled="currentPage === totalPages"
                                class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AdminIndex from './AdminIndex.vue'
import { ref, computed, watch } from 'vue'

defineOptions({ layout: AdminIndex })

const searchQuery = ref('')
const filterType = ref('All')
const isFilterOpen = ref(false)
const currentPage = ref(1)
const itemsPerPage = 10

const loginData = [
    { id: 1, firstName: 'John', lastName: 'Doe', email: 'john@example.com', contact: '+1 234 567 8900', loginTime: '2024-11-07 10:30 AM' },
    { id: 2, firstName: 'Jane', lastName: 'Smith', email: 'jane@example.com', contact: '+1 234 567 8901', loginTime: '2024-11-07 09:15 AM' },
    { id: 3, firstName: 'Michael', lastName: 'Johnson', email: 'michael@example.com', contact: '+1 234 567 8902', loginTime: '2024-11-06 03:45 PM' },
    { id: 4, firstName: 'Sarah', lastName: 'Williams', email: 'sarah@example.com', contact: '+1 234 567 8903', loginTime: '2024-11-06 02:20 PM' },
    { id: 5, firstName: 'David', lastName: 'Brown', email: 'david@example.com', contact: '+1 234 567 8904', loginTime: '2024-11-06 01:10 PM' },
    { id: 6, firstName: 'Emma', lastName: 'Davis', email: 'emma@example.com', contact: '+1 234 567 8905', loginTime: '2024-11-05 11:50 AM' },
    { id: 7, firstName: 'Robert', lastName: 'Miller', email: 'robert@example.com', contact: '+1 234 567 8906', loginTime: '2024-11-05 10:30 AM' },
    { id: 8, firstName: 'Lisa', lastName: 'Wilson', email: 'lisa@example.com', contact: '+1 234 567 8907', loginTime: '2024-11-04 04:15 PM' },
    { id: 9, firstName: 'James', lastName: 'Moore', email: 'james@example.com', contact: '+1 234 567 8908', loginTime: '2024-11-04 03:45 PM' },
    { id: 10, firstName: 'Patricia', lastName: 'Taylor', email: 'patricia@example.com', contact: '+1 234 567 8909', loginTime: '2024-11-04 02:20 PM' },
    { id: 11, firstName: 'Christopher', lastName: 'Anderson', email: 'chris@example.com', contact: '+1 234 567 8910', loginTime: '2024-11-03 11:00 AM' },
    { id: 12, firstName: 'Mary', lastName: 'Thomas', email: 'mary@example.com', contact: '+1 234 567 8911', loginTime: '2024-11-03 09:30 AM' },
]

const filterOptions = ['All', 'Today', 'This Week', 'This Month']

const getDateFilter = () => {
    const today = new Date('2024-11-07')
    const oneWeekAgo = new Date(today)
    oneWeekAgo.setDate(today.getDate() - 7)
    const oneMonthAgo = new Date(today)
    oneMonthAgo.setMonth(today.getMonth() - 1)

    return {
        today,
        oneWeekAgo,
        oneMonthAgo
    }
}

const parseLoginTime = (timeStr) => {
    return new Date(timeStr.split(' ')[0])
}

const filteredData = computed(() => {
    let filtered = loginData
    const { today, oneWeekAgo, oneMonthAgo } = getDateFilter()

    if (filterType.value === 'Today') {
        filtered = filtered.filter(item => {
            const itemDate = parseLoginTime(item.loginTime)
            return itemDate.toDateString() === today.toDateString()
        })
    } else if (filterType.value === 'This Week') {
        filtered = filtered.filter(item => {
            const itemDate = parseLoginTime(item.loginTime)
            return itemDate >= oneWeekAgo && itemDate <= today
        })
    } else if (filterType.value === 'This Month') {
        filtered = filtered.filter(item => {
            const itemDate = parseLoginTime(item.loginTime)
            return itemDate >= oneMonthAgo && itemDate <= today
        })
    }

    if (searchQuery.value.trim()) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter(item =>
            item.firstName.toLowerCase().includes(query) ||
            item.lastName.toLowerCase().includes(query) ||
            item.email.toLowerCase().includes(query) ||
            item.contact.includes(query)
        )
    }

    return filtered
})

const totalPages = computed(() => Math.ceil(filteredData.value.length / itemsPerPage))

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage
    const end = start + itemsPerPage
    return filteredData.value.slice(start, end)
})

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage)

const endIndex = computed(() => Math.min(currentPage.value * itemsPerPage, filteredData.value.length))

const visiblePages = computed(() => {
    const pages = []
    const maxVisible = 5
    let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2))
    let end = Math.min(totalPages.value, start + maxVisible - 1)
    if (end - start + 1 < maxVisible) {
        start = Math.max(1, end - maxVisible + 1)
    }
    for (let i = start; i <= end; i++) {
        pages.push(i)
    }
    return pages
})

const handleFilterSelect = (option) => {
    filterType.value = option
    isFilterOpen.value = false
    currentPage.value = 1
}

const previousPage = () => {
    if (currentPage.value > 1) currentPage.value--
}

const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++
}

watch(searchQuery, () => {
    currentPage.value = 1
})

watch(filterType, () => {
    currentPage.value = 1
})
</script>