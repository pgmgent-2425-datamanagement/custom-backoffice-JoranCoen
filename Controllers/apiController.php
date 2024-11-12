<?php

namespace App\Controllers;

use App\Models\Coin; 

class ApiController {
    public function apiGetAll() {
        $searchTerm = $_GET['search'] ?? null; 

        $model = new Coin();

        $response = $model->apiGetAll($searchTerm);

        header('Content-Type: application/json');

        echo json_encode($response);
    }
    public function apiCreate() {
        $data = json_decode(file_get_contents('php://input'), true);

        $model = new Coin();

        $response = $model->apiCreate($data);

        header('Content-Type: application/json');

        echo json_encode($response);
    }
}
