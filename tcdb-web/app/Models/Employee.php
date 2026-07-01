<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Employee {
    public static function all() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM Employee");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        
        // คำนวณหา ID ล่าสุดแล้ว + 1
        $stmtId = $db->query("SELECT MAX(Employee) as max_id FROM Employee");
        $row = $stmtId->fetch(PDO::FETCH_ASSOC);
        $nextId = ($row['max_id'] ?? 0) + 1;

        $sql = "INSERT INTO Employee (Employee, FIRSTNAME, LASTNAME, Email, Job, Salary) VALUES (:id, :first_name, :last_name, :email, :job, :salary)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':id' => $nextId,
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':job' => $data['job'],
            ':salary' => $data['salary']
        ]);
    }

    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $sql = "DELETE FROM Employee WHERE Employee = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
