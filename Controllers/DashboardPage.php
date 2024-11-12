<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Coin;

class DashboardController extends BaseController {
    public static function dashboard() {
        $userModel = new User();
        $roleModel = new Role();
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
            'roles' => $roleModel->all(),
            'users' => $users,
            'coins' => $coins,
            'notifications' => $notifications
        ]);
    }

    public static function userDetail($id) {
        $userModel = new User();
        $roleModel = new Role();

        $user = $userModel->findById($id);

        if ($user) {
            $user->wallets = $user->getWallets();

            if (!empty($user->wallets)) {
                foreach ($user->wallets as $wallet) {
                    $wallet->coin = $wallet->getCoin();
                }
    
            }

            $notifications = $user->getNotifications();

            $roles = $roleModel->all();

            self::loadView('/userDetail', [
                'title' => 'User',
                'roles' => $roles,
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