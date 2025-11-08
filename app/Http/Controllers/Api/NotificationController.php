<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get all notifications for a user
     */
    public function index(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['message' => 'Missing user_id parameter'], 400);
        }

        $notifications = $this->notificationService->getAllNotifications($userId);

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    /**
     * Get unread notifications
     */
    public function unread(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['message' => 'Missing user_id parameter'], 400);
        }

        $notifications = $this->notificationService->getUnreadNotifications($userId);

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'count' => $notifications->count()
        ]);
    }

    /**
     * Get unread count
     */
    public function unreadCount(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['message' => 'Missing user_id parameter'], 400);
        }

        $count = $this->notificationService->getUnreadCount($userId);

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $success = $this->notificationService->markAsRead($id);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notification marked as read' : 'Notification not found'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['message' => 'Missing user_id parameter'], 400);
        }

        $count = $this->notificationService->markAllAsRead($userId);

        return response()->json([
            'success' => true,
            'message' => "{$count} notifications marked as read",
            'count' => $count
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }
}