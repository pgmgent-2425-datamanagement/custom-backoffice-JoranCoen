<?php

namespace App\Models;

class Notification extends BaseModel {
    protected $table = 'notifications';  
    protected $pk = 'notification_id';

    public function getUser() {
        $userModel = new User(); 
        return $userModel->find($this->user_id); 
    }
}
