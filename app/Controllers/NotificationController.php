<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    public $notificationModel;
    public $session;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->session = session();
    }

    public function index(){
        $userId = $this->session->get('id');
        $notifications = $this->notificationModel->where('recipient', $userId)
                                                                                ->orderBy('created_at', 'DESC')
                                                                                ->findAll();
        $data = [
            'notifications' => $notifications
        ];

        return view('dashboard/notifications', $data);
    }

    public function markAsRead($id)
    {
        $notification = $this->notificationModel->find($id);

        if ($notification) {
            $notification['status'] = 'read';
            $this->notificationModel->save($notification);
        }

        return redirect()->to('/notifications');
    }
}
