<?php
    require_once __DIR__ . '/../app/controllers/UserController.php';
    require_once __DIR__ . '/../config/db.php';



    $controller = new UserController($pdo);
    $controller->handleRequest();

?>
