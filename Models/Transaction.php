<?php

namespace App\Models;

class Transaction extends BaseModel {
    protected $table = 'transactions';  
    protected $pk = 'transaction_id';

    public function getUser() {
        $userModel = new User(); 
        return $userModel->find($this->user_id); 
    }

    public function getCoin() {
        $coinModel = new Coin(); 
        return $coinModel->find($this->coin_id); 
    }
}
