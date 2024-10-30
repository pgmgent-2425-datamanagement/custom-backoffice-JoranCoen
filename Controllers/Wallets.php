<?php

namespace App\Controllers;

class WalletsController extends BaseController {
    public static function wallets () {
        self::loadView('/wallets', [
            'title' => 'WalletsPage'
        ]);
    }
}
