<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import LandingIndex from './LandingIndex.vue'
defineOptions({ layout: LandingIndex })

const showMore = ref(false)

function toggleMore() {
  showMore.value = !showMore.value
}
</script>

<template>
  <div>
    <!-- Hero Section -->
    <section
      class="home-hero"
      style="background: url('build/assets/homepage-background.jpg') center/cover no-repeat;"
    >
      <div class="home-hero-content">
        <div class="home-hero-title">JE TRAVEL & TOURS</div>
        <div class="home-hero-desc">
          Wander More, Worry Less! Let's Plan Your Next Adventure.<br>
          A Travel & Tours in Biñan Laguna<br>
          We Offer Local Tours!
        </div>
          <Link href="/destination" class="home-hero-btn">
            BOOK NOW
          </Link>
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
      <img src="/assets/launion.jpg" alt="La Union" />
      <div class="destination-meta">₱ XXXX</div>
      <div class="destination-title">La Union</div>
      <div class="destination-days">
        <span>5 Days</span>
      </div>
      <button class="view-btn">View Details</button>
    </div>
    <div class="destination-card">
      <img src="/assets/baguio.jpg" alt="Baguio City" />
      <div class="destination-meta">₱ XXXX</div>
      <div class="destination-title">Baguio City</div>
      <div class="destination-days">
        <span>4 Days</span>
      </div>
      <button class="view-btn">View Details</button>
    </div>
    <div class="destination-card">
      <img src="/assets/panay.jpg" alt="Panay, Capiz" />
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

<style scoped>
.home-hero {
  position: relative;
  width: 100%;
  min-height: 350px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: #fff;
  padding: 48px 0 32px 0;
  text-shadow: 0 2px 8px rgba(0,0,0,0.2);
  overflow: hidden;
}

.home-hero::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.45);
  z-index: 1;
}

.home-hero-content {
  position: relative;
  z-index: 2;
  max-width: 700px;
  margin-left: 60px;
  margin-right: auto;
  padding: 32px 32px 32px 0;
  box-sizing: border-box;
}

.home-hero-title {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 12px;
}

.home-hero-desc {
  font-size: 1.1rem;
  margin-bottom: 32px;
}

.home-hero-btn {
  background: #f58220;
  color: #fff;
  border: 2px solid #f58220;
  border-radius: 12px;
  padding: 12px 48px;
  font-size: 1.1rem;
  font-weight: 500;
  cursor: pointer;
  margin-top: 16px;
  text-decoration: none;
  display: inline-block;
  transition: background 0.2s, color 0.2s, border 0.2s;
}

.home-hero-btn:hover {
  background: #d96c0a;
  color: #fff;
  border-color: #d96c0a;
  text-decoration: none;
}

.home-section {
  max-width: 1100px;
  margin: 40px auto 0 auto;
  padding: 0 16px;
  text-align: center;
}

.home-section-title {
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 8px;
  margin-top: 32px;
  border-bottom: 3px solid #222;
  display: inline-block;
  padding-bottom: 4px;
}

.home-section-desc {
  color: #333;
  margin-bottom: 32px;
  font-size: 1.1rem;
  line-height: 1.5;
}

.home-section-desc span {
  transition: color 0.3s;
}
.home-section .view-btn {
  background: #fff;
  color: #f58220;
  border: 2px solid #f58220;
  border-radius: 24px;
  padding: 8px 32px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  margin-top: 10px;
  transition: background 0.2s, color 0.2s, border 0.2s;
  display: inline-block;
}

.home-section .view-btn:hover {
  background: #f58220;
  color: #fff;
  border-color: #f58220;
}
.destinations-row {
  display: flex;
  flex-wrap: wrap;
  gap: 32px;
  justify-content: center;
  margin-top: 24px;
}

.destination-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.04);
  padding: 24px 18px 18px 18px;
  width: 270px;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: box-shadow 0.2s;
}

.destination-card img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 12px;
  margin-bottom: 16px;
}

.destination-title {
  font-weight: bold;
  font-size: 1.1rem;
  margin-bottom: 4px;
  color: #f58220;
}

.destination-meta {
  color: #f58220;
  font-size: 1rem;
  margin-bottom: 4px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.destination-days {
  color: #f58220;
  font-size: 1rem;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.destination-card .view-btn {
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

.destination-card .view-btn:hover {
  background: #f58220;
  color: #fff;
}

@media (max-width: 900px) {
  .destinations-row {
    flex-direction: column;
    align-items: center;
  }
  .destination-card {
    width: 90%;
    max-width: 350px;
  }
  .home-hero-content {
    padding: 16px;
  }
}
</style>