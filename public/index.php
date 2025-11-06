<?php

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

//db connection
$database = new Database();
$db = $database->getConnection();
$controller = new UserController($db);

$action = $_GET['action'] ?? 'index'; // default action is 'index'

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "404: Action not found.";
}