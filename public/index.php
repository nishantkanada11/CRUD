<?php

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

//db connection
$database = new Database();
$db = $database->getConnection();

// Pass DB connection to controller
$controller = new UserController($db);

// which action to run
$action = $_GET['action'] ?? 'index'; // default action is 'index'

//method exists in the controlle show it
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "404: Action not found.";
}