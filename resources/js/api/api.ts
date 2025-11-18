import { plainInstance } from './axios-api'

export class api {
    //User API
    getUsers() {
        return plainInstance.get("/api/users");
    }

    createUser(data) {
        return plainInstance.post("/api/users", data);
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

    updateSeasonalPricing(id: number, payload: object) {
        return plainInstance.put(`/api/packages/${id}/seasonal-pricing`, payload);
    }
    
    deactivateSeasonalPricing(id: number, payload: object) {
        return plainInstance.put(`/api/packages/${id}/deactivate-seasonal`, payload);
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

    getAboutUs() {
        return plainInstance.get("/api/about-us");
    }

    updateAboutUs(payload: object) {
        return plainInstance.patch(`/api/about-us`, payload);
    }

    uploadAboutUsImage(file: File) {
        const formData = new FormData();
        formData.append('image', file);
        
        return plainInstance.post(`/api/about-us/upload-image`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
    }

    getOurStory() {
        return plainInstance.get("/api/our-story");
    }

    updateOurStory(payload: object) {
        return plainInstance.patch(`/api/our-story`, payload);
    }

    uploadOurStoryImage(file: File) {
        const formData = new FormData();
        formData.append('image', file);
        
        return plainInstance.post(`/api/our-story/upload-image`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
    }

    getAccreditations() {
        return plainInstance.get("/api/accreditations");
    }

    uploadAccreditation(file: File) {
        const formData = new FormData();
        formData.append('image', file);
        
        return plainInstance.post(`/api/accreditations`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
    }

    deleteAccreditation(id: number) {
        return plainInstance.delete(`/api/accreditations/${id}`);
    }

    // Notifications API
    getNotifications(userId: number) {
        return plainInstance.get("/api/notifications", {
            params: { user_id: userId }
        });
    }

    getUnreadNotifications(userId: number) {
        return plainInstance.get("/api/notifications/unread", {
            params: { user_id: userId }
        });
    }

    getUnreadNotificationCount(userId: number) {
        return plainInstance.get("/api/notifications/unread-count", {
            params: { user_id: userId }
        });
    }

    markNotificationAsRead(id: number) {
        return plainInstance.patch(`/api/notifications/${id}/read`);
    }

    markAllNotificationsAsRead(userId: number) {
        return plainInstance.post("/api/notifications/mark-all-read", null, {
            params: { user_id: userId }
        });
    }

    deleteNotification(id: number) {
        return plainInstance.delete(`/api/notifications/${id}`);
    }

    sendDisasterNotification(payload: {
        booking_id: number;
        new_travel_date?: string;
        reason?: string;
    }) {
        return plainInstance.post("/api/disaster-notifications", payload);
    }

    fetchAnalyticsData(period) {
        console.log("Sending period:", period);
        return plainInstance.get(`/api/analytics/`, { params: { period } });
    
    }
}