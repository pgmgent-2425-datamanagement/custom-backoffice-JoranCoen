<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Coin;

class DashboardController extends BaseController {
    public static function dashboard() {
        $userModel = new User();
        $coinModel = new Coin();

        $users = $userModel->all();
        $coins = $coinModel->all();

        foreach ($coins as $coin) {
            $coin->prices = $coin->getPrices();
        }

        $userId = $_SESSION['user']['user_id'] ?? 0;

        $user = $userModel->findById($userId);

        $notifications = $user->getNotifications();

        self::loadView('/dashboard', [
            'title' => 'Dashboard',
            'users' => $users,
            'coins' => $coins,
            'notifications' => $notifications
        ]);
    }

    public static function userDetail($id) {
        $userModel = new User();

        $user = $userModel->findById($id);

        if ($user) {
            $user->wallets = $user->getWallets();

            foreach ($user->wallets as $wallet) {
                $wallet->coin = $wallet->getCoin();
            }

            $notifications = $user->getNotifications();

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