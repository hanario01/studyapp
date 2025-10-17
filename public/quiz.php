<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/controllers/QuizController.php';

if (isset($_GET['start']) && $_GET['start'] === 'new') {
    unset($_SESSION['questions']);
    unset($_SESSION['grade']);
    unset($_SESSION['subject']);
    unset($_SESSION['index']);
    unset($_SESSION['answers']);
}

// コントローラ生成
$controller = new QuizController($pdo);
$controller->handleRequest();

// 問題のセッションを初期化


