<?php

namespace App\Controllers;

use App\Models\Notification;

class ProfileController extends BaseController {
    public static function profile() {
        $notificationModel = new Notification();

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);

        self::loadView('/profile', [
            'title' => 'Profile',
            'notifications' => $notifications
        ]);
    }
}