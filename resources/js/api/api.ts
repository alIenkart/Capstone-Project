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

    //Feedbacks
    getFeedbacks() {
        return plainInstance.get("/api/feedbacks");
    }

    updateFeedback(id, data) {
        return plainInstance.patch(`/api/feedbacks/${id}`, data);
    }

    deleteFeedback(id) {
        return plainInstance.delete(`/api/feedbacks/${id}`);
    }

    // Content API
    getContents() {
        return plainInstance.get("/api/contents");
    }

    getContent(id: number) {
        return plainInstance.get(`/api/contents/${id}`);
    }

    createContent(payload: FormData) {
        return plainInstance.post("/api/contents", payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
    }

    updateContent(id: number, payload: object) {
        return plainInstance.patch(`/api/contents/${id}`, payload);
    }

    uploadContentImage(id: number, file: File) {
        const formData = new FormData();
        formData.append('image', file);
        
        return plainInstance.post(`/api/contents/${id}/upload-image`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
    }

    deleteContent(id: number) {
        return plainInstance.delete(`/api/contents/${id}`);
    }

    // Travel Blogs API
    getTravelBlogs() {
        return plainInstance.get("/api/travel-blogs");
    }

    getTravelBlog(id: number) {
        return plainInstance.get(`/api/travel-blogs/${id}`);
    }

    createTravelBlog(payload: FormData) {
        return plainInstance.post("/api/travel-blogs", payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
    }

    updateTravelBlog(id: number, payload: object) {
        return plainInstance.patch(`/api/travel-blogs/${id}`, payload);
    }

    uploadTravelBlogImage(id: number, file: File) {
        const formData = new FormData();
        formData.append('image', file);
        
        return plainInstance.post(`/api/travel-blogs/${id}/upload-image`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
    }

    deleteTravelBlog(id: number) {
        return plainInstance.delete(`/api/travel-blogs/${id}`);
    }
}
