export interface DisasterNotificationPayload {
    booking_id: number;
    new_travel_date?: string;
    reason?: string;
}

export interface DisasterNotificationResponse {
    success: boolean;
    message: string;
    notification_id?: number;
}

export interface DisasterDateChangeNotification {
    id: number;
    user_id: number;
    booking_id: number;
    type: 'disaster_date_change';
    title: string;
    message: string;
    is_read: boolean;
    read_at: string | null;
    created_at: string;
    updated_at: string;
}