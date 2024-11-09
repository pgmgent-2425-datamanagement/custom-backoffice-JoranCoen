<?php

namespace App\Controllers;

use App\Models\Transaction;
use App\Models\Coin;

class TransactionController extends BaseController {
    public static function update() {
        $transactionModel = new Transaction();
        $transaction_id = $_POST['transaction_id'] ?? null;

        $transaction = $transactionModel->findById($transaction_id);

        if (!$transaction) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Transaction not found.'
            ]);
            exit();
        }

        $amount = $_POST['amount'] ?? null;
        $coin_id = $_POST['coin_id'] ?? null;
        $transaction_type = $_POST['transaction_type'] ?? null;
        $status = $_POST['status'] ?? null;
        $ref = $_POST['ref'] ?? null; 
        $fee = $_POST['fee'] ?? null;
        $notes = $_POST['notes'] ?? null;
        $date = $_POST['date'] ?? null;

        if (empty($amount) || empty($coin_id) || empty($transaction_type) || empty($status) || empty($ref) || empty($fee) || empty($notes) || empty($date)) {
            self::loadView('/error', [
            'title' => 'Error',
            'message' => 'Invalid input data.'
            ]);
            exit();
        }

        $amount = floatval($amount);
        $fee = floatval($fee);

        $coinModel = new Coin();
        $coin = $coinModel->findById($coin_id);

        if (!$coin) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Coin not found.'
            ]);
            exit();
        }

        $transactionModel->update($transaction_id, [
            'amount' => htmlspecialchars($amount),
            'coin_id' => htmlspecialchars($coin_id),
            'transaction_type' => htmlspecialchars($transaction_type),
            'reference_id' => htmlspecialchars($ref),
            'status' => htmlspecialchars($status),
            'fee' => htmlspecialchars($fee),
            'notes' => htmlspecialchars($notes),
            'transaction_date' => htmlspecialchars($date)
        ]);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public static function delete() {
        $transactionModel = new Transaction();
        $transaction_id = $_POST['transaction_id'] ?? null;

        $transaction = $transactionModel->findById($transaction_id);

        if (!$transaction) {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Transaction not found.'
            ]);
            exit();
        }

        $transactionModel->deleteById($transaction_id);

        header('Location: /transactions');
        exit();
    }

    public static function post() {
        $transactionModel = new Transaction();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            $walletId = $_POST['wallet_id'] ?? null;
            $coinId = $_POST['coin_id'] ?? null;
            $amount = $_POST['amount'] ?? null;
            $transactionType = $_POST['transaction_type'] ?? null;
            $status = $_POST['status'] ?? 'pending';
            $fee = $_POST['fee'] ?? 0.0;
            $notes = $_POST['notes'] ?? '';
    
            if (empty($userId) || empty($walletId) || empty($coinId) || empty($amount) || empty($transactionType) || empty($fee) || empty($notes)) {
                self::loadView('/error', [
                    'title' => 'Error',
                    'message' => 'Please fill in all required fields.'
                ]);
                exit();
            }

            $referenceId = 'REF' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $transactionDate = date('Y-m-d H:i:s');

            $data = [
                'user_id' => $userId,
                'wallet_id' => $walletId,
                'coin_id' => $coinId,
                'amount' => $amount,
                'transaction_type' => $transactionType,
                'transaction_date' => $transactionDate,
                'status' => $status,
                'fee' => $fee,
                'reference_id' => $referenceId,
                'notes' => $notes,
            ];
    
            $transactionModel->create($data);
    
            header('Location: /transactions');
            exit();
        }
    }
}
