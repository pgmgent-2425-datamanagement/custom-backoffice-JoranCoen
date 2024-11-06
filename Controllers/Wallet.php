<?php

namespace App\Controllers;

use App\Models\Wallet;

class WalletController extends BaseController {
    public static function update() {
        $walletModel = new Wallet();
        $wallet_id = $_POST['wallet_id'] ?? null;

        $wallet = $walletModel->findById($wallet_id);

        if (!$wallet) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Wallet not found.'
            ]);
            exit();
        }

        $wallet_address = $_POST['wallet_address'] ?? null;
        $balance = $_POST['balance'] ?? null;
        $status = $_POST['status'] ?? null;
        $notes = $_POST['notes'] ?? null;

        if (!$wallet_address || !$status) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Invalid input data.'
            ]);
            exit();
        }

        $walletModel->update($wallet_id, [
            'wallet_address' => htmlspecialchars($wallet_address),
            'balance' => htmlspecialchars($balance),
            'status' => htmlspecialchars($status),
            'notes' => htmlspecialchars($notes),
        ]);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
