<?php

namespace App\Controllers;

use App\Models\Transaction;

class TransactionsController extends BaseController {
    public static function transactions() {
        $transactionModel = new Transaction();

        $transactions = $transactionModel->all();

        foreach ($transactions as $transaction) {
            $transaction->coin = $transaction->getCoin();
        }

        foreach ($transactions as $transaction) {
            $transaction->user = $transaction->getUser();
        }

        self::loadView('/transactions', [
            'title' => 'Transactions',
            'transactions' => $transactions
        ]);
    }
}
