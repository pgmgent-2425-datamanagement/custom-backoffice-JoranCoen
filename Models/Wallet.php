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
}