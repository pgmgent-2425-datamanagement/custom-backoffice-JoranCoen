<?php

namespace App\Controllers;

use App\Models\Notification;

class FileManagerPageController extends BaseController {
    public static function fileManager () {
        $notificationModel = new Notification();

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);

        self::loadView('/file-manager', [
            'title' => 'File Manager',
            'notifications' => $notifications
        ]);
    }
}
