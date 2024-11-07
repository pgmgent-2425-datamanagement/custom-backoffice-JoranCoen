<?php

namespace App\Controllers;

use App\Models\User;
class ProfileController extends BaseController {
    public static function profile() {
        $userModel = new User();

        $userId = $_SESSION['user']['user_id'] ?? 0;

        $user = $userModel->findById($userId);

        if (!$user) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'User not found.'
            ]);
            return;
        }

        $notifications = $user->getNotifications();

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
