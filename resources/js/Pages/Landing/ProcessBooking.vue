<script setup>
import { ref, computed } from 'vue'
import LandingIndex from './LandingIndex.vue'
import Calendar from './Calendar.vue'
import ReservationDetails from './ReservationDetails.vue'
import BookingConfirmation from './BookingConfirmation.vue'

defineOptions({ layout: LandingIndex })

const steps = ['calendar', 'select', 'confirmation']
const stepIndex = ref(0)

const currentStep = computed(() => steps[stepIndex.value])

function goNext() {
  if (stepIndex.value < steps.length - 1) stepIndex.value++
}

function goBack() {
  if (stepIndex.value > 0) stepIndex.value--
}
</script>

<template>
  <div>
    <Calendar 
      v-if="currentStep === 'calendar'" 
      @next="goNext" 
    />
    <ReservationDetails
      v-else-if="currentStep === 'select'" 
      @next="goNext" 
      @back="goBack"
    />
    <BookingConfirmation 
      v-else-if="currentStep === 'confirmation'" 
      @back="goBack"
    />
  </div>
</template>
