<?php

namespace App\Controllers;

use App\Models\Coin;
use App\Models\Transaction;
use App\Models\Notification;

class TransactionsPageController extends BaseController {
    public static function transactions() {
        $transactionModel = new Transaction();
        $notificationModel = new Notification();

        $transactions = $transactionModel->all();

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);

        foreach ($transactions as $transaction) {
            $transaction->coin = $transaction->getCoin();
            $transaction->user = $transaction->getUser();
        }

        self::loadView('/transactions', [
            'title' => 'Transactions',
            'transactions' => $transactions,
            'notifications' => $notifications
        ]);
    }

    public static function detail($id) {
        $transactionModel = new Transaction();
        $coinModel = new Coin();
        $notificationModel = new Notification();
    
        $transaction = $transactionModel->findById($id);

        $userId = $_SESSION['user']['user_id'] ?? 0;
        $notifications = $notificationModel->findByUserId($userId);
        

        if ($transaction) {
            if (isset($transaction->coin_id)) {
                $transaction->coin = $transaction->getCoin();
            }
            if (isset($transaction->user_id)) {
                $transaction->user = $transaction->getUser();
            }

            self::loadView('/transactionDetail', [
                'title' => 'Transaction',
                'coins' => $coinModel->all(),
                'transaction' => $transaction,
                'notifications' => $notifications
            ]);
        } else {
            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Transaction not found.'
            ]);
        }
    }
}
