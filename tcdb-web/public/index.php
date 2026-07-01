<?php

// Simple Custom Autoloader
spl_autoload_register(function ($class) {
    // Expected prefix: App\
    $prefix = 'App\\';
    
    // Check if the class uses our prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; // Move to next registered autoloader
    }
    
    // Get the relative class name (e.g., Controllers\EmployeeController)
    $relative_class = substr($class, $len);
    
    // Replace namespace separators with directory separators, append .php
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', $relative_class) . '.php';
    
    // If file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Controllers\EmployeeController;

// Simple Router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$controller = new EmployeeController();

if ($uri === '/' || $uri === '/employees') {
    if ($method === 'POST') {
        $controller->store();
    } else {
        $controller->index();
    }
} elseif ($uri === '/employees/create' && $method === 'GET') {
    $controller->create();
} elseif ($uri === '/employees/delete' && $method === 'POST') {
    $controller->destroy();
} else {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
}
