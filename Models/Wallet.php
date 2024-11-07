<?php

namespace App\Models;

class Wallet extends BaseModel {
    protected $table = 'wallets';  
    protected $pk = 'wallet_id';

    public function getCoin() {
        $coinModel = new Coin(); 
        return $coinModel->find($this->coin_id); 
    }

    public function getUser() {
        $userModel = new User(); 
        return $userModel->find($this->user_id); 
    }

    public function getTransactions() {
        $transactionModel = new Transaction();
        $transactions = $transactionModel->findByColumn('wallet_id', $this->wallet_id, false);
        
        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                $transaction->coin = $transaction->getCoin();
            }
        }
    
        return $transactions;
    }
    
}
