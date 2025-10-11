<script setup>
import { ref, onMounted} from 'vue'
import { Link } from '@inertiajs/vue3'
import { api } from '../../api/api';
import LandingIndex from './LandingIndex.vue'

defineOptions({ layout: LandingIndex })

const service = new api();
const showMore = ref(false)
const packages = ref([])

const fetchPackages = async () => {
    try {
        const response = await service.getPackages();
        packages.value = response.data.data
    } catch (error) {
        console.error('Error fetching packages:', error)
    }
}

function toggleMore() {
  showMore.value = !showMore.value
}

onMounted(() => {
  fetchPackages();
});
</script>

<template>
  <div class="home-page">
    <!-- Hero Section -->
    <section
      class="home-hero"
      style="background: url('/storage/home-header/boracay.jpg') center/cover no-repeat;"
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
        <div class="destination-card"
          v-for="pkg in packages" :key="pkg.id">
        <img :src="'/storage/' + pkg.image_path" :alt="pkg.destination" />
        <div class="destination-meta">
          <span class="currency-badge" aria-hidden="true">₱</span>
          <span>{{ pkg.pax_rate }}</span>
        </div>
        <div class="destination-title">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0Z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          <span>{{ pkg.destination }}</span>
        </div>
        <div class="destination-days">
          <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 6v6l4 2"/>
          </svg>
          <span>{{ pkg.tour_duration }} Days</span>
        </div>
        <Link :href="route('tourdetails', { id: pkg.id })"
          class="mt-2 px-4 py-2 border border-[#008DDA] text-[#008DDA] rounded-full font-semibold hover:bg-[#008DDA] hover:text-white transition text-center block">
          View Details
        </Link>
      </div>
    </div>
  </section>
</div>
</template>

<style scoped>
.home-page {
  margin-bottom: 2%;
}
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
  background: #008DDA;
  color: #fff;
  border: 2px solid #008DDA;
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
  background: #73BE5D;
  color: #fff;
  border-color: #73BE5D;
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
  border-bottom: 3px solid #1E71B8;
  display: inline-block;
  padding-bottom: 4px;
  color:#1E71B8;
}

.home-section-desc {
  color: #000000;
  margin-bottom: 32px;
  font-size: 1.1rem;
  line-height: 1.5;
}

.home-section-desc span {
  transition: color 0.3s;
}
.home-section .view-btn {
  background: #fff;
  color: #008DDA;
  border: 2px solid #008DDA;
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
  background: #008DDA;
  color: #fff;
  border-color: #008DDA;
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
  color: #008DDA;
  display: flex;
  align-items: center;
  gap: 6px;
  width: 100%;
  justify-content: flex-start;
  text-align: left;
}

.destination-meta {
  font-weight: bold;
  color: #008DDA;
  font-size: 1rem;
  margin-bottom: 4px;
  display: flex;
  align-items: center;
  gap: 6px;
  width: 100%;
  justify-content: flex-start;
  text-align: left;
}
.currency-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  color: #008DDA;
  font-size: 1.1rem;
}

.destination-days {
  font-weight: bold;
  color: #008DDA;
  font-size: 1rem;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 6px;
  width: 100%;
  justify-content: flex-start;
  text-align: left;
}
.icon {
  width: 18px;
  height: 18px;
}

.destination-card .view-btn {
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

.destination-card .view-btn:hover {
  background: #008DDA;
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