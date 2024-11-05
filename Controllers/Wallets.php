<?php

namespace App\Controllers;

use App\Models\Wallet;
use App\Models\Notification;

class WalletsController extends BaseController {
    public static function wallets() {
        $walletModel = new Wallet();
        $notificationModel = new Notification();

        $wallets = $walletModel->all();

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);

        foreach ($wallets as $wallet) {
            if (isset($wallet->coin_id)) {
                $wallet->coin = $wallet->getCoin();
            }
            if (isset($wallet->user_id)) {
                $wallet->user = $wallet->getUser();
            }
        }

        self::loadView('/wallets', [
            'title' => 'Wallets',
            'wallets' => $wallets,
            'notifications' => $notifications
        ]);
    }

    public static function detail($id) {
        $walletModel = new Wallet();
        $notificationModel = new Notification();

        $wallet = $walletModel->findById($id);

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);

        if ($wallet) {
            if (isset($wallet->coin_id)) {
                $wallet->coin = $wallet->getCoin();
            }
            if (isset($wallet->user_id)) {
                $wallet->user = $wallet->getUser();
            }

            self::loadView('/walletDetail', [
                'title' => 'Wallet',
                'wallet' => $wallet,
                'notifications' => $notifications
            ]);
        } else {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Wallet not found.'
            ]);
        }
    }
}
