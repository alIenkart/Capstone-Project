export interface Notification {
    id: number;
    user_id: number;
    booking_id: number;
    type: string;
    title: string;
    message: string;
    is_read: boolean;
    read_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface NotificationResponse {
    success: boolean;
    data: Notification[];
    count?: number;
}

export interface NotificationCountResponse {
    success: boolean;
    count: number;
}