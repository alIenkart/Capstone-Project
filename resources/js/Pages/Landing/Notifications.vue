<template>
    <div class="min-h-screen w-full bg-[#f4f8fb]">
        <div class="w-full bg-[#1E71B8] py-4 px-8 shadow-sm flex items-center justify-between">
            <h2 class="text-white text-3xl font-bold tracking-tight">Notifications</h2>
            <button @click="markAllAsRead" class="text-sm text-white/90 hover:text-white transition">
                Mark all as read
            </button>
        </div>

        <div class="max-w-5xl mx-auto mt-10 px-6 pb-20 space-y-6">
            <div v-for="(notification, index) in notifications" :key="index"
                class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 relative transition hover:shadow-md">
                <div class="flex justify-between items-start">
                    <h3 class="font-semibold text-gray-800 text-lg">
                        {{ notification.title }}
                    </h3>
                    <span class="text-xs text-gray-500">{{ notification.date }}</span>
                </div>

                <p class="text-sm text-gray-600 mt-2 leading-relaxed" v-html="notification.message"></p>

                <div class="flex justify-between items-center mt-4">
                    <span class="text-xs text-gray-500">
                        Booking ID: <strong>B{{ String(notification.bookingId).padStart(5, '0') }}</strong>
                    </span>
                    <span v-if="notification.unread"
                        class="absolute top-3 right-5 w-3 h-3 bg-red-500 rounded-full"></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import LandingIndex from './LandingIndex.vue'
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { fetchBookingsByUser, fetchPaymentsByUserId } from '@/api/booking'

const user = usePage().props.auth.user
const userId = user?.id
const bookings = ref([])
const payments = ref([])
const notifications = ref([])

const markAllAsRead = () => {
    notifications.value.forEach((n) => (n.unread = false))
}

// ✅ Define this function first so it's available for generateNotifications()
function formatDateTime(isoString) {
    const date = new Date(isoString)
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true,
    })
}

const generateNotifications = () => {
    notifications.value = payments.value
        .map((payment) => {
            const booking = bookings.value.find((b) => b.id === payment.booking_id)
            if (!booking) return null

            let title = ''
            let message = ''

            if (payment.payment_status === 'Pending') {
                title = 'Your Booking is Confirmed!'
                message = `
            Your booking for <strong>${booking.package_destination} - ${booking.duration} Day(s)</strong> 
            on <strong>${formatDateTime(booking.start_date)}</strong> has been confirmed.<br>
            Please proceed with the payment of <strong>₱${payment.remaining_payment.toLocaleString()}</strong> using the QR code provided in 
            the <strong>My Booking</strong> section.<br>
            Make sure to upload your payment receipt for verification. Thank you!
          `
            } else if (payment.payment_status === 'Verified' || payment.payment_status === 'Paid') {
                title = 'Payment Successfully Verified'
                message = `
            Your payment of <strong>₱${payment.total_price.toLocaleString()}</strong> for 
            <strong>${booking.package_destination} - ${booking.duration} Day(s)</strong> on 
            <strong>${formatDateTime(booking.start_date)}</strong> has been successfully verified.<br>
            Your booking is now fully secured. Please check <strong>My Booking</strong> section to download your official receipt.
          `
            } else {
                title = 'Payment Update'
                message = `
            Your payment for <strong>${booking.package_destination}</strong> is currently marked as 
            <strong>${payment.payment_status}</strong>.
          `
            }

            return {
                title,
                date: formatDateTime(payment.created_at),
                message,
                bookingId: booking.id,
                unread: true,
            }
        })
        .filter(Boolean)
}

onMounted(async () => {
    bookings.value = await fetchBookingsByUser(userId)
    payments.value = await fetchPaymentsByUserId(userId)
    generateNotifications()
})

defineOptions({ layout: LandingIndex })
</script>