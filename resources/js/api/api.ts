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
}