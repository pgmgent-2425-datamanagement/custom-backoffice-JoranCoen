<?php

namespace App\Controllers;

use App\Models\User;

class FileManagerPageController extends BaseController {
    public static function fileManager () {
        $userModel = new User();

        $userId = $_SESSION['user']['user_id'] ?? 0;

        $user = $userModel->findById($userId);
        $notifications = $user->getNotifications();

        self::loadView('/file-manager', [
            'title' => 'File Manager',
            'notifications' => $notifications
        ]);
    }
}
