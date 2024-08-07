<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function getPendingNotifications($recipientId)
    {
        return $this->notificationModel
                    ->where('recipient', $recipientId)
                    ->where('status', 'pending')
                    ->findAll();
    }

    public function markAsRead($notificationId)
    {
        return $this->notificationModel->update($notificationId, ['status' => 'read']);
    }

    public function viewNotifications($recipientId)
    {
        $notifications = $this->getPendingNotifications($recipientId);
        return view('notifications/view', ['notifications' => $notifications]);
    }

    public function markNotificationAsRead($notificationId)
    {
        if ($this->markAsRead($notificationId)) {
            return redirect()->back()->with('success', 'Notification marked as read.');
        } else {
            return redirect()->back()->with('error', 'Failed to mark notification as read.');
        }
    }
}
