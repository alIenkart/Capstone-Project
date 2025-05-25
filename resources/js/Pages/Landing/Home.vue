<script setup>
import { ref } from 'vue'
import '../../css/home.css'

const showMore = ref(false)

function toggleMore() {
  showMore.value = !showMore.value
}
</script>

<template>
  <div>
    <!-- Hero Section -->
    <section class="home-hero">
      <div class="home-hero-content">
        <div class="home-hero-title">JE TRAVEL & TOURS</div>
        <div class="home-hero-desc">
          Wander More, Worry Less! Let's Plan Your Next Adventure.<br>
          A Travel & Tours in Biñan Laguna<br>
          We Offer Local Tours!
        </div>
        <router-link to="/destination" class="home-hero-btn">
          BOOK NOW
        </router-link>
      </div>
    </section>

    <!-- Welcome Section -->
<section class="home-section">
  <div class="home-section-title">WELCOME TO JE TRAVEL & TOURS!</div>
  <div class="home-section-desc">
    <span>
      Planning a trips? JE Travel & Tours is here to provide you a wide range of tour and guidance towards a meaningful and memorable travel. The agency is specialized in creating seamless travel experiences and is
      <span v-if="showMore">
         dedicated to providing clear and reliable service to make your journey enjoyable and stress free. Let the team help you to plan your next journey! Book now!
      </span>
    </span>
  </div>
  <button class="view-btn" @click="toggleMore">
    {{ showMore ? 'See less' : 'See more' }}
  </button>
</section>

    <!-- Destinations Section -->
    <section class="home-section">
      <div class="home-section-title">Exclusive Destination</div>
      <div class="destinations-row">
        <div class="destination-card">
          <img src="../assets/launion.jpg" alt="La Union" />
          <div class="destination-meta">₱ XXXX</div>
          <div class="destination-title">La Union</div>
          <div class="destination-days">
            <span>5 Days</span>
          </div>
          <button class="view-btn">View Details</button>
        </div>
        <div class="destination-card">
          <img src="../assets/baguio.jpg" alt="Baguio City" />
          <div class="destination-meta">₱ XXXX</div>
          <div class="destination-title">Baguio City</div>
          <div class="destination-days">
            <span>4 Days</span>
          </div>
          <button class="view-btn">View Details</button>
        </div>
        <div class="destination-card">
          <img src="../assets/panay.jpg" alt="Panay, Capiz" />
          <div class="destination-meta">₱ XXXX</div>
          <div class="destination-title">Panay, Capiz</div>
          <div class="destination-days">
            <span>4 Days</span>
          </div>
          <button class="view-btn">View Details</button>
        </div>
      </div>
    </section>
  </div>
</template>