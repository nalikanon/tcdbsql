<?php

namespace App\Controllers;

use App\Models\Employee;

class ScanController {
    public function index() {
        require_once __DIR__ . '/../../resources/views/scan/index.php';
    }

    public function check() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? '';
            
            if (empty($id)) {
                echo json_encode(['status' => 'hold']);
                exit;
            }

            $employee = Employee::find($id);

            if ($employee) {
                echo json_encode(['status' => 'pass']);
            } else {
                echo json_encode(['status' => 'hold']);
            }
            exit;
        }
    }
}
