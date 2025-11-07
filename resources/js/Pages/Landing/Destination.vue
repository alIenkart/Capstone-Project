<script setup>
import { ref, onMounted, computed } from 'vue'
import LandingIndex from './LandingIndex.vue'
import axios from 'axios'
import { api } from '../../api/api'
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: LandingIndex })

const service = new api();
const packages = ref([])
const showFilter = ref(false)
const searchQuery = ref('')
const selectedRegion = ref(null)

const toggleFilter = () => {
  showFilter.value = !showFilter.value
}

const closeFilter = () => {
  showFilter.value = false
}

// Computed property for filtered packages
const filteredPackages = computed(() => {
  const hasQuery = Boolean(searchQuery.value.trim())
  const query = searchQuery.value.toLowerCase().trim()

  // If no search and no region filter, return all
  if (!hasQuery && !selectedRegion.value) {
    return packages.value
  }

  return packages.value.filter(pkg => {
    // Region filter
    const regionMatch = selectedRegion.value ? pkg.region === selectedRegion.value : true

    if (!hasQuery) {
      return regionMatch
    }

    // Text search filters
    const packageNameMatch = pkg.package_name?.toLowerCase().includes(query)
    const paxRateMatch = pkg.pax_rate?.toString().includes(query)
    const destinationMatch = pkg.destination?.toLowerCase().includes(query)

    return regionMatch && (packageNameMatch || paxRateMatch || destinationMatch)
  })
})

// Unique regions derived from filteredPackages
const regions = computed(() => {
  const unique = new Set(
    packages.value
      .map(pkg => pkg.region)
      .filter(region => Boolean(region))
  )
  return Array.from(unique).sort()
})

const selectRegion = (region) => {
  selectedRegion.value = region
  showFilter.value = false
}

const fetchPackages = async () => {
    try {
        const response = await service.getPackages();
        packages.value = response.data.data
    } catch (error) {
        console.error('Error fetching packages:', error)
    }
}

onMounted(() => {
    fetchPackages()
})
</script>

<template>
  <section class="destination-page">
    <div class="destination-header">
      <div class="destination-title">DESTINATIONS</div>
      <div class="destination-subtitle">ALL DESTINATIONS</div>
    </div>
    <div class="destination-controls">
      <input 
        type="text" 
        class="destination-search" 
        placeholder="E.g. name, price, or destination" 
        v-model="searchQuery"
      />
        <div class="destination-filter">
        <button class="filter-btn" @click="toggleFilter">{{ selectedRegion || 'Filter' }}</button>
        <ul 
            class="filter-dropdown" 
            v-show="showFilter"
        >
            <li @click="selectRegion(null)">All regions</li>
            <li v-for="region in regions" :key="region" @click="selectRegion(region)">{{ region }}</li>
        </ul>
        </div>
    </div>

    <div class="destination-list">
      <div
        class="destination-card"
        v-for="pkg in filteredPackages"
        :key="pkg.id"
      >
        <img :src="'/storage/' + pkg.image_path" :alt="pkg.title" />
        <div class="destination-meta">₱ {{ pkg.pax_rate }}</div>
        <div class="destination-title">{{ pkg.destination }}</div>
        <div class="destination-days">
          <span>{{ pkg.tour_duration   }} Days</span>
        </div>
          <Link :href="route('tourdetails', { id: pkg.id })"
            class="mt-2 px-4 py-2 border border-[#008DDA] text-[#008DDA] rounded-full font-semibold hover:bg-[#008DDA] hover:text-white transition text-center block">
            View Details
          </Link>
      </div>
    </div>
  </section>
</template>
<style scoped>
.destination-page {
  max-width: 1200px;
  margin: 40px auto 0 auto;
  padding: 0 16px;
}

.destination-header {
  text-align: left;
  margin-bottom: 12px;
}

.destination-title {
  color: #008DDA;
  font-size: 1.5rem;
  font-weight: 800;
  margin-bottom: 6px;
  text-align: center;
}

.destination-subtitle {
  color: #008DDA;
  font-size: 1.1rem;
  border-bottom: 3px solid #008DDA;
  display: inline-block;
  margin-bottom: 18px;
}

.destination-controls {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 12px;
  margin-bottom: 24px;
}

.destination-search {
  border: 1.5px solid #008DDA;
  border-radius: 18px;
  padding: 6px 18px;
  font-size: 1rem;
  outline: none;
}

.destination-filter {
  position: relative;
}

.filter-btn {
  background: #fff;
  color: #008DDA;
  border: 1.5px solid #008DDA;
  border-radius: 18px;
  padding: 6px 18px;
  cursor: pointer;
  font-size: 1rem;
}

.filter-dropdown {
  display: block;
  position: absolute;
  top: 36px;
  left: 0;
  background: #fff;
  border: 1px solid #eee;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  min-width: 160px;
  z-index: 10;
  padding: 0;
  margin: 0;
  list-style: none;
}

.filter-dropdown li {
  padding: 10px 18px;
  color: #008DDA;
  cursor: pointer;
  transition: background 0.2s;
}

.filter-dropdown li:hover {
  background: #f5f5f5;
}

.destination-list {
  display: flex;
  flex-wrap: wrap;
  gap: 32px;
  background: #fff;
  border-radius: 16px;
  padding: 32px 24px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.04);
  justify-content: flex-start;
}

.destination-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.04);
  padding: 24px 18px 18px 18px;
  width: 270px;
  flex: 1 1 300px;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 24px;
  transition: box-shadow 0.2s;
}

.destination-card img {
  width: 100%;
  height: 250px;
  object-fit: contain;
  border-radius: 12px;
  margin-bottom: 16px;
}

.destination-meta {
  color: #008DDA;
  font-weight: bold;
  margin-bottom: 6px;
}

.destination-days {
  color: #008DDA;
  font-size: 1rem;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.view-btn {
  border: 1.5px solid #008DDA;
  color: #008DDA;
  background: #fff;
  border-radius: 24px;
  padding: 8px 32px;
  font-size: 1rem;
  cursor: pointer;
  margin-top: 10px;
  transition: background 0.2s, color 0.2s;
}

.view-btn:hover {
  background: #008DDA;
  color: #fff;
}
</style>