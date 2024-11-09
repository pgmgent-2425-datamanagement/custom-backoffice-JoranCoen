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
        $coinId = $_POST['coin_id'] ?? null;
        $status = $_POST['status'] ?? null;
        $notes = $_POST['notes'] ?? null;

        if ( empty($wallet_address) || empty($balance) || empty($coinId) || empty($status) || empty($notes) ) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Invalid input data.'
            ]);
            exit();
        }

        $walletModel->update($wallet_id, [
            'wallet_address' => htmlspecialchars($wallet_address),
            'balance' => htmlspecialchars($balance),
            'coin_id' => htmlspecialchars($coinId),
            'status' => htmlspecialchars($status),
            'notes' => htmlspecialchars($notes),
        ]);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public static function delete() {
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

        $walletModel->deleteById($wallet_id);

        header('Location: /wallets');
        exit();
    }

    public static function post() {
        $walletModel = new Wallet();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            $coinId = $_POST['coin_id'] ?? null;
            $balance = $_POST['balance'] ?? null;
            $status = $_POST['status'] ?? null;
            $notes = $_POST['notes'] ?? '';
    
            if (empty($userId) || empty($coinId) || empty($balance) || empty($status) || empty($notes)) {
                self::loadView('/error', [
                    'title' => 'Error',
                    'message' => 'Please fill in all required fields.'
                ]);
                exit();
            }

            $walletAddress = 'wallet' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $walletDate = date('Y-m-d H:i:s');

            $data = [
                'user_id' => $userId,
                'coin_id' => $coinId,
                'balance' => $balance,
                'created_at' => $walletDate,
                'wallet_address' => $walletAddress,
                'status' => $status,
                'notes' => $notes,
            ];
    
            $walletModel->create($data);
    
            header('Location: /wallets');
            exit();
        }
    }
}
