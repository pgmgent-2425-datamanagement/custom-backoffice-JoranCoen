<?php

namespace App\Controllers;

class LoginController extends BaseController {
    public static function login() {
            self::loadView('/login', [
            'title' => 'Login Now!',
            'error' => $_SESSION['error'] ?? null,
        ]);
        unset($_SESSION['error']); 
    }
}