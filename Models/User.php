<?php

namespace App\Models;

class User extends BaseModel {
    protected $table = 'users';  
    protected $pk = 'user_id';

    public function getWallets() {
        $walletModel = new Wallet(); 
        return $walletModel->getAllWalletsByUserId($this->user_id); 
    }    
}
