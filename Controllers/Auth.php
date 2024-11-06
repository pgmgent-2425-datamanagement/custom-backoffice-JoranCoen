<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Notification;

class AuthController extends BaseController {
    public function login() {
        $userModel = new User();
        $notificationModel = new Notification();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
    
            $user = $userModel->authenticate($username, $password);

            if ($user) {
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                ];
            
                header('Location: /'); 
                exit();
            } else {
                $_SESSION['error'] = 'Invalid username or password'; 
                header('Location: login'); 
                exit();
            }

        }
    }    

    public function logout() {
        $_SESSION = [];
        session_destroy(); 
        header('Location: login'); 
        exit();
    }
}