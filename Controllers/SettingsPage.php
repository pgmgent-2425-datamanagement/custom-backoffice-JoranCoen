<?php

namespace App\Controllers;

use App\Models\User;

class SettingsPageController extends BaseController {
    public static function settings () {
        $userModel = new User();

        $userId = $_SESSION['user']['user_id'] ?? 0;

        $user = $userModel->findById($userId);
        $notifications = $user->getNotifications();

        self::loadView('/settings', [
            'title' => 'Settings',
            'notifications' => $notifications
        ]);
    }
}
