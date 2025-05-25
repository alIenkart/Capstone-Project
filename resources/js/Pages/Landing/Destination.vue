<script setup>
import { ref } from 'vue'
import '../../css/destination.css'

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
        <img src="../assets/siargao.jpg" alt="Siargao Island" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Siargao Island, Siargao del Norte</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="../assets/batangas.jpg" alt="Beach Tour, Batangas" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Beach Tour, Batangas</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="../assets/mariveles.jpg" alt="Mariveles, Bataan" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Mariveles, Bataan</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
            <div class="destination-card">
        <img src="../assets/siargao.jpg" alt="Siargao Island" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Siargao Island, Siargao del Norte</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="../assets/batangas.jpg" alt="Beach Tour, Batangas" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Beach Tour, Batangas</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="../assets/mariveles.jpg" alt="Mariveles, Bataan" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Mariveles, Bataan</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
            <div class="destination-card">
        <img src="../assets/siargao.jpg" alt="Siargao Island" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Siargao Island, Siargao del Norte</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="../assets/batangas.jpg" alt="Beach Tour, Batangas" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Beach Tour, Batangas</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
      <div class="destination-card">
        <img src="../assets/mariveles.jpg" alt="Mariveles, Bataan" />
        <div class="destination-meta">₱ XXXX</div>
        <div class="destination-title">Mariveles, Bataan</div>
        <div class="destination-days"><span>5 Days</span></div>
        <button class="view-btn">View Details</button>
      </div>
    </div>
  </section>
</template>