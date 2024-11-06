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
    public static function userDetail($id) {
        $userModel = new User();
        $notificationModel = new Notification();
    
        $user = $userModel->findById($id);
        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);
    
        if ($user) {

            $user->wallets = $user->getWallets();
    

            foreach ($user->wallets as $wallet) {
                $wallet->coin = $wallet->getCoin(); 
            }
    
            self::loadView('/userDetail', [
                'title' => 'User',
                'user' => $user,
                'notifications' => $notifications
            ]);
        } else {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'User not found.'
            ]);
        }
    }
    
}