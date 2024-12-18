<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Coin;
use App\Models\Wallet;

class WalletsPageController extends BaseController {
    public static function wallets() {
        $userModel = new User();
        $coinModel = new Coin();
        $walletModel = new Wallet();

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $user = $userModel->findById($userId);
        $notifications = $user->getNotifications();

        $wallets = $walletModel->all();
        foreach ($wallets as &$wallet) {
            if (isset($wallet->coin_id)) {
                $wallet->coin = $wallet->getCoin();
            }
            if (isset($wallet->user_id)) {
                $wallet->user = $wallet->getUser();
            }
        }

        self::loadView('/wallets', [
            'title' => 'Wallets',
            'coins' => $coinModel->all(),
            'users' => $userModel->all(),
            'wallets' => $wallets,
            'notifications' => $notifications
        ]);
    }

    public static function detail($id) {
        $userModel = new User();
        $coinModel = new Coin();
        $walletModel = new Wallet();
    
        $userId = $_SESSION['user']['user_id'] ?? 0;
    
        $user = $userModel->findById($userId);
        $notifications = $user->getNotifications();
    
        $wallet = $walletModel->findById($id);
    
        if ($wallet) {
            if (isset($wallet->coin_id)) {
                $wallet->coin = $wallet->getCoin();
            }
            if (isset($wallet->user_id)) {
                $wallet->user = $wallet->getUser();
            }
    
            $wallet->transactions = $wallet->getTransactions();
    
            self::loadView('/walletDetail', [
                'title' => 'Wallet',
                'wallet' => $wallet,
                'coins' => $coinModel->all(),
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