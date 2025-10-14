<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

// ユーザーがログインしていない場合はリダイレクト
if (empty($_SESSION['user'])) {
    header('Location: /studyapp-1/public/login.php');
    exit;
}

// コントローラ経由でマイページを表示
$controller = new UserController($pdo);
$controller->showMypage();
