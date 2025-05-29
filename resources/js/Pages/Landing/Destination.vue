<script setup>
import { ref } from 'vue'
import LandingIndex from './LandingIndex.vue'
defineOptions({ layout: LandingIndex })

const showFilter = ref(false)

function toggleFilter() {
  showFilter.value = !showFilter.value
}

function closeFilter() {
  showFilter.value = false
}
</script>

<template>
  <section class="destination-page">
    <div class="destination-header">
      <div class="destination-title">DESTINATIONS</div>
      <div class="destination-subtitle">ALL DESTINATIONS</div>
    </div>
    <div class="destination-controls">
      <input type="text" class="destination-search" placeholder="Search" />
        <div class="destination-filter">
        <button class="filter-btn" @click="toggleFilter">Filter</button>
        <ul 
            class="filter-dropdown" 
            v-show="showFilter"
            @mouseleave="closeFilter"
        >
            <li>Metro Manila</li>
            <li>North Luzon</li>
            <li>South Luzon</li>
            <li>Central Visayas</li>
            <li>Western Visayas</li>
            <li>Northern Mindanao</li>
            <li>Davao Region</li>
        </ul>
        </div>
    </div>
    <div class="destination-list">
      <div class="destination-card">
        <img src="/assets/siargao.jpg" alt="Siargao Island" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Siargao Island, Siargao del Norte</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="/assets/batangas.jpg" alt="Beach Tour, Batangas" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Beach Tour, Batangas</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="/assets/mariveles.jpg" alt="Mariveles, Bataan" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Mariveles, Bataan</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
            <div class="destination-card">
        <img src="/assets/siargao.jpg" alt="Siargao Island" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Siargao Island, Siargao del Norte</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="/assets/batangas.jpg" alt="Beach Tour, Batangas" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Beach Tour, Batangas</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="/assets/mariveles.jpg" alt="Mariveles, Bataan" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Mariveles, Bataan</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
            <div class="destination-card">
        <img src="/assets/siargao.jpg" alt="Siargao Island" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Siargao Island, Siargao del Norte</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="/assets/batangas.jpg" alt="Beach Tour, Batangas" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Beach Tour, Batangas</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="/assets/mariveles.jpg" alt="Mariveles, Bataan" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Mariveles, Bataan</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
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
  color: #f58220;
  font-size: 1.5rem;
  font-weight: bold;
  letter-spacing: 1px;
}

.destination-subtitle {
  color: #f58220;
  font-size: 1rem;
  border-bottom: 3px solid #f58220;
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
  border: 1.5px solid #f58220;
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
  color: #f58220;
  border: 1.5px solid #f58220;
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
  color: #f58220;
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
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  padding: 16px;
  width: 300px;
  flex: 1 1 300px;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 24px;
}

.destination-card img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 12px;
  margin-bottom: 12px;
}

.destination-meta {
  color: #f58220;
  font-weight: bold;
  margin-bottom: 6px;
}

.destination-title {
  color: #f58220;
  font-size: 1.1rem;
  font-weight: 500;
  margin-bottom: 6px;
  text-align: center;
}

.destination-days {
  color: #f58220;
  font-size: 1rem;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.view-btn {
  border: 1.5px solid #f58220;
  color: #f58220;
  background: #fff;
  border-radius: 24px;
  padding: 8px 32px;
  font-size: 1rem;
  cursor: pointer;
  margin-top: 10px;
  transition: background 0.2s, color 0.2s;
}

.view-btn:hover {
  background: #f58220;
  color: #fff;
}
</style>