<?php

namespace App\Controllers;

use App\Models\Wallet;

class WalletsController extends BaseController {
    public static function wallets () {
        $walletModel = new Wallet();

        $wallets = $walletModel->all();

        foreach ($wallets as $wallet) {
            $wallet->coin = $wallet->getCoin();
        }

        foreach ($wallets as $wallet) {
            $wallet->user = $wallet->getUser();
        }

        self::loadView('/wallets', [
            'title' => 'Wallets',
            'wallets' => $wallets
        ]);
    }
}
