import { plainInstance } from './axios-api'

export class api {
    //Packages API
    getPackages() {
        return plainInstance.get("/api/packages");
    }

    //Booking API
    getBookings(){
        return plainInstance.get("/api/bookings");
    }

    createBooking(payload){
        return plainInstance.post("/api/bookings", payload);
    }

    updateBooking(id, payload) {
        return plainInstance.patch(`/api/bookings/${id}`, payload)
    }

    //Payment API
    getPayments() {
        return plainInstance.get("/api/payments");
    }
}