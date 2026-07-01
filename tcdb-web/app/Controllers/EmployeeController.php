<?php

namespace App\Controllers;

use App\Models\Employee;

class EmployeeController {
    public function index() {
        // 1. Fetch data from Model
        $employees = Employee::all();
        
        // 2. Load View and pass data
        require_once __DIR__ . '/../../resources/views/employees/index.php';
    }

    public function create() {
        require_once __DIR__ . '/../../resources/views/employees/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'job' => $_POST['job'] ?? '',
                'salary' => $_POST['salary'] ?? 0
            ];
            
            try {
                Employee::create($data);
                // Redirect back to index
                header('Location: /');
                exit;
            } catch (\PDOException $e) {
                $error = "เกิดข้อผิดพลาดในการบันทึกข้อมูล: ข้อมูลอาจจะยาวเกินกว่าที่ฐานข้อมูลรับได้ (เช่น Email) รายละเอียด: " . $e->getMessage();
                require_once __DIR__ . '/../../resources/views/employees/create.php';
            }
        }
    }

    public function destroy() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                Employee::delete($id);
            }
            // Redirect back to index
            header('Location: /');
            exit;
        }
    }
}
