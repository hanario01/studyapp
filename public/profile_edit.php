<?php

require_once __DIR__ . '/../app/common/auth.php';
checkLogin();  

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

$controller = new UserController($pdo);
$controller->editProfile();  
