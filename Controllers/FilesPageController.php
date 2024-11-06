<?php

namespace App\Controllers;

use App\Models\Notification;

class FilesPageController extends BaseController {
    public static function files () {
        $notificationModel = new Notification();

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);

        self::loadView('/files', [
            'title' => 'Files',
            'notifications' => $notifications
        ]);
    }
}
