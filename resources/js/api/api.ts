import { plainInstance } from './axios-api'

export class api {
    //User API
    getUsers() {
        return plainInstance.get("/api/users");
    }

    updateUser(id, data) {
        return plainInstance.patch(`/api/users/${id}`, data);
    }
        
    //Packages API
    getPackages() {
        return plainInstance.get("/api/packages");
    }

    getPackage(id) {
        return plainInstance.get(`/api/packages/${id}`);
    }
    
    //Booking API
    getBookings(){
        return plainInstance.get("/api/bookings");
    }

    createBooking(payload){
        return plainInstance.post("/api/bookings", payload, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
    }

    updateBooking(id, payload) {
        return plainInstance.patch(`/api/bookings/${id}`, payload)
    }

    //Payment API
    getPayments() {
        return plainInstance.get("/api/payments");
    }

    //Contacts API
    createInquiry(payload) {
        return plainInstance.post("/api/inquiries", payload);
    }
}