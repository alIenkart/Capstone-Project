export async function fetchBookingsByUser(userId) {
    const response = await fetch(`/api/bookings/by-user?user_id=${userId}`);
    if (!response.ok) throw new Error('Failed to fetch bookings');
    return await response.json();
}

export async function fetchPaymentsByBookingId(bookingId) {
    const response = await fetch(`/api/payments?booking_id=${bookingId}`);
    if (!response.ok) throw new Error('Failed to fetch payments');
    return await response.json();
}

export async function fetchPaymentsByUserId(userId) {
    const response = await fetch(`/api/payments?booking_id=${userId}`);
    if (!response.ok) throw new Error('Failed to fetch payments');
    return await response.json();
}

export async function fetchPaymentsByPaymentId(paymentId) {
    const response = await fetch(`/api/payments?payment_id=${paymentId}`);
    if (!response.ok) throw new Error('Failed to fetch payments');
    return await response.json();
}