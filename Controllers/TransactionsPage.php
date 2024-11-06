<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Coin;
use App\Models\Transaction;

class TransactionsPageController extends BaseController {
    public static function transactions() {
        $userModel = new User();
        $transactionModel = new Transaction();

        $userId = $_SESSION['user']['user_id'] ?? 0;

        $user = $userModel->findById($userId);

        $notifications = $user->getNotifications();

        $transactions = $transactionModel->all();

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
        $userModel = new User();
        $coinModel = new Coin();
        $transactionModel = new Transaction();

        $userId = $_SESSION['user']['user_id'] ?? 0;

        $user = $userModel->findById($userId);
        $notifications = $user->getNotifications();
        
        $transaction = $transactionModel->findById($id);

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
