<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Coin;
use App\Models\Notification;

class DashboardController extends BaseController {
    public static function dashboard() {
        $userModel = new User();
        $coinModel = new Coin();
        
        $coins = $coinModel->all();

        foreach ($coins as $coin) {
            $coin->prices = $coin->getPrices();
        }
        $notificationModel = new Notification();

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);

        self::loadView('/dashboard', [
            'title' => 'Dashboard',
            'users' => $userModel->all(),
            'notifications' => $notifications,
            'coins' => $coins
        ]);
    }
}
