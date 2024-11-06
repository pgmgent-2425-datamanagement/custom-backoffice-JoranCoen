<?php

namespace App\Controllers;

use App\Models\Notification;

class SettingsPageController extends BaseController {
    public static function settings () {
        $notificationModel = new Notification();

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);

        self::loadView('/settings', [
            'title' => 'Settings',
            'notifications' => $notifications
        ]);
    }
}
