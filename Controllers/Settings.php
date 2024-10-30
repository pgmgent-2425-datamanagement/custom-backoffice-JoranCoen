<?php

namespace App\Controllers;

class SettingsController extends BaseController {
    public static function settings () {
        self::loadView('/settings', [
            'title' => 'SettingsPage'
        ]);
    }
}
