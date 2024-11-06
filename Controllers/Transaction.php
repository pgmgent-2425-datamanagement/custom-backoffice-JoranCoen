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
        $fee = $_POST['fee'] ?? null;
        $notes = $_POST['notes'] ?? null;
        $date = $_POST['date'] ?? null;

        if (!$amount || !$coin_id || !$transaction_type || !$status || !$fee) {
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
            'status' => htmlspecialchars($status),
            'fee' => htmlspecialchars($fee),
            'notes' => htmlspecialchars($notes),
            'transaction_date' => htmlspecialchars($date)
        ]);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
