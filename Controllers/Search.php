<?php

namespace App\Controllers;

use App\Models\BaseModel;

class SearchController extends BaseController {
    public function search() {
        $searchModel = new BaseModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $search = $_POST['search'] ?? '';

            $results = $searchModel->searchAllTables($search);

            error_log(print_r($results, true));

            if (!empty($results)) {
                foreach ($results as $table => $rows) {
                    if (!empty($rows)) {
                        switch ($table) {
                            case 'users':
                                header('Location: /user/' . $rows[0]['user_id']);
                                exit();
                            case 'wallets':
                                header('Location: /wallets/' . $rows[0]['wallet_id']);
                                exit();
                            case 'transactions':
                                header('Location: /transactions/' . $rows[0]['transaction_id']);
                                exit();
                            case 'coins':
                                header('Location: /#coins');
                                exit();
                            default:
                                self::loadView('/error', [
                                    'title' => 'Error',
                                    'message' => 'Nothing found.'
                                ]);
                                exit();
                        }
                    }
                }
            }

            self::loadView('/error', [
                'title' => 'Error',
                'message' => 'Nothing found.'
            ]);
            exit();
        }
    }
}
