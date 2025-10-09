<?php
require_once __DIR__ . '/../app/controllers/QuizController.php';

$controller = new QuizController($pdo);
$controller->handleRequest();
