<?php

namespace App\Controllers;

class TransactionsController extends BaseController {
    public static function transactions () {
        self::loadView('/transactions', [
            'title' => 'TransactionsPage'
        ]);
    }
}
