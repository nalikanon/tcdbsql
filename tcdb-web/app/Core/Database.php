<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $envPath = __DIR__ . '/../../.env';
        $env = [];
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if (strpos($line, '#') === 0 || empty($line)) continue;
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value, '"\''); // Remove quotes
                    $env[$key] = $value;
                }
            }
        }

        if (empty($env)) {
            die("Error: The .env file is missing or empty.");
        }

        if (empty($env['DB_HOST'])) {
            die("Error: DB_HOST is not set in the .env file.");
        }
        $server = $env['DB_HOST'];
        
        $port = $env['DB_PORT'] ?? '';
        if (!empty($port)) {
            $server .= ',' . $port;
        }
        
        if (empty($env['DB_DATABASE'])) {
            die("Error: DB_DATABASE is not set in the .env file.");
        }
        $database = $env['DB_DATABASE'];
        
        $username = $env['DB_USERNAME'] ?? '';
        $password = $env['DB_PASSWORD'] ?? '';

        try {
            $this->conn = new PDO("sqlsrv:Server=$server;Database=$database", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
