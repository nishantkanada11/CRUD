<?php

// Load core files
require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

// Create DB connection
$database = new Database();
$db = $database->getConnection();

// Pass DB connection to controller
$controller = new UserController($db);  

// Decide which action to run based on URL
$action = $_GET['action'] ?? 'index'; // default action is 'index'

// If that method exists in the controller, call it
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "404: Action not found.";
}