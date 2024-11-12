<?php

namespace App\Models;

class User extends BaseModel {
    protected $table = 'users';  
    protected $pk = 'user_id';

    public function getWallets() {
        $walletModel = new Wallet(); 
        return $walletModel->findByColumn('user_id', $this->{$this->pk}, false); 
    }

    public function getNotifications() {
        $notificationModel = new Notification();
        return $notificationModel->findByColumn('user_id', $this->{$this->pk}, false);
    }
}
