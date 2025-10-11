<script setup>
import AdminIndex from './AdminIndex.vue'
defineOptions({ layout: AdminIndex })
</script>

<template>
  <div class="dashboard-wrapper">
    <!-- Summary Cards -->
    <div class="dashboard-cards">
      <div class="dashboard-card">
        <div class="card-title">Total Bookings</div>
        <div class="card-value">1,221</div>
        <div class="card-link">Month <span class="divider">|</span> Year</div>
      </div>
      <div class="dashboard-card">
        <div class="card-title">Total Earnings</div>
        <div class="card-value">64,546</div>
        <div class="card-link">Month <span class="divider">|</span> Year</div>
      </div>
      <div class="dashboard-card">
        <div class="card-title">Upcoming Tours</div>
        <div class="card-value">11</div>
        <div class="card-link">Week <span class="divider">|</span> Month <span class="divider">|</span> Calendar</div>
      </div>
      <div class="dashboard-card">
        <div class="card-title">Pending Bookings</div>
        <div class="card-value">23</div>
        <div class="card-link">Week <span class="divider">|</span> Month <span class="divider">|</span> View</div>
      </div>
    </div>

    <!-- Charts Area -->
    <div class="dashboard-charts">
      <div class="chart-box">
        <div class="chart-title">Top Travel Destinations <span class="chart-link">Months <span class="divider">|</span> Year</span></div>
        <img src="https://dummyimage.com/400x180/daeaf6/217093&text=Bar+Chart" alt="Bar Chart" class="chart-img" />
      </div>
      <div class="chart-box">
        <div class="chart-title">Monthly sales Overview <span class="chart-link">Months <span class="divider">|</span> Year</span></div>
        <img src="https://dummyimage.com/400x180/daeaf6/217093&text=Line+Chart" alt="Line Chart" class="chart-img" />
      </div>
    </div>

    <!-- Approved & Paid Bookings -->
    <div class="dashboard-bookings">
      <div class="bookings-title">Approved & Paid Bookings</div>
      <div class="booking-list">
        <div class="booking-card">
          <div class="booking-row">
            <span class="booking-date"><i class="fa fa-calendar"></i> 10 January 2025</span>
            <span class="booking-pax"><i class="fa fa-users"></i> 10 pax</span>
            <span class="booking-type">Booking Type: Exclusive</span>
          </div>
          <div class="booking-details">
            <div>
              <div class="booking-tour">Baguio Tour - 3 Days & 2 Nights</div>
              <div>Customer: John Doe</div>
            </div>
            <div>
              <div>Payment Status: <span class="verified"><i class="fa fa-check-square"></i> Verified</span></div>
              <div>Note: Senior/PWD is applied</div>
            </div>
          </div>
        </div>
        <div class="booking-card">
          <div class="booking-row">
            <span class="booking-date"><i class="fa fa-calendar"></i> 2 January 2025</span>
            <span class="booking-pax"><i class="fa fa-users"></i> 10 pax</span>
            <span class="booking-type">Booking Type: Joint</span>
          </div>
          <div class="booking-details">
            <div>
              <div class="booking-tour">La Union Tour - 3 Days & 2 Nights</div>
              <div>Customer: John Doe</div>
              <div>Customer: Michael Herb</div>
              <div>Customer: Jane Dani</div>
            </div>
            <div>
              <div>Payment Status: <span class="verified"><i class="fa fa-check-square"></i> Verified</span></div>
              <div>Note: Senior/PWD is applied</div>
              <div>Note: N/A</div>
            </div>
          </div>
        </div>
      </div>
      <div class="bookings-footer">
        <button class="see-more-btn">See more</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.dashboard-wrapper {
  padding: 0 0 32px 0;
}
.dashboard-cards {
  display: flex;
  gap: 18px;
  margin: 0 0 18px 0;
  justify-content: space-between;
}
.dashboard-card {
  background: #1E71B8;
  color: #fff;
  flex: 1 1 0;
  border-radius: 8px;
  padding: 18px 24px 12px 24px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  min-width: 0;
}
.card-title {
  font-size: 1.1rem;
  font-weight: 500;
  margin-bottom: 8px;
}
.card-value {
  font-size: 2.2rem;
  font-weight: bold;
  margin-bottom: 8px;
}
.card-link {
  font-size: 0.95rem;
  opacity: 0.9;
}
.divider {
  margin: 0 4px;
  color: #fff;
  opacity: 0.7;
}
.dashboard-charts {
  display: flex;
  gap: 18px;
  margin-bottom: 32px;
}
.chart-box {
  background: #fff;
  border-radius: 8px;
  flex: 1 1 0;
  padding: 18px 18px 8px 18px;
  min-width: 0;
  box-shadow: 0 2px 8px rgba(33,112,147,0.04);
}
.chart-title {
  font-size: 1.1rem;
  font-weight: 500;
  margin-bottom: 8px;
  color: #1E71B8;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.chart-link {
  font-size: 0.95rem;
  color: #1E71B8;
  opacity: 0.8;
}
.chart-img {
  width: 100%;
  height: 180px;
  object-fit: contain;
  background: #daeaf6;
  border-radius: 6px;
}
.dashboard-bookings {
  background: #d3d3d3;
  border-radius: 10px;
  padding: 24px 24px 16px 24px;
  margin-top: 18px;
}
.bookings-title {
  font-size: 1.2rem;
  font-weight: bold;
  margin-bottom: 18px;
}
.booking-list {
  display: flex;
  flex-direction: column;
  gap: 18px;
}
.booking-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(33,112,147,0.06);
  padding: 18px 24px;
  margin-bottom: 0;
  display: flex;
  flex-direction: column;
  gap: 10px;
  border: 1.5px solid #bdbdbd;
}
.booking-row {
  display: flex;
  gap: 24px;
  align-items: center;
  font-size: 1.05rem;
  font-weight: 500;
  margin-bottom: 6px;
}
.booking-date, .booking-pax, .booking-type {
  display: flex;
  align-items: center;
  gap: 6px;
}
.booking-details {
  display: flex;
  justify-content: space-between;
  gap: 24px;
  font-size: 1rem;
  flex-wrap: wrap;
}
.booking-tour {
  font-weight: 500;
  color: #1E71B8;
}
.verified {
  color: #1E71B8;
  font-weight: 500;
}
.bookings-footer {
  display: flex;
  justify-content: flex-end;
  margin-top: 14px;
}
.see-more-btn {
  background: #73BE5D;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 10px 48px;
  font-size: 1.1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.see-more-btn:hover {
  background: #6aae56;
}
@media (max-width: 900px) {
  .dashboard-cards, .dashboard-charts {
    flex-direction: column;
    gap: 12px;
  }
}
</style>