<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Notification;

class ProfileController extends BaseController {
    public static function profile() {
        $userModel = new User();
        $notificationModel = new Notification();
    
        $userId = $_SESSION['user']['user_id'] ?? 0;
    
        $userArray = $userModel->findByUserId($userId);
        $user = is_array($userArray) ? reset($userArray) : $userArray;

        $notifications = $notificationModel->findByUserId($userId);

        $user->wallets = $user->getWallets();

        foreach ($user->wallets as $wallet) {
            $wallet->coin = $wallet->getCoin(); 
        }
    
        self::loadView('/profile', [
            'title' => 'Profile',
            'user' => $user,
            'notifications' => $notifications
        ]);
    }    
}