<?php
require_once __DIR__ . '/../config/db.php'; 
require_once __DIR__ . '/../app/controllers/HistoryController.php';

$controller = new HistoryController($pdo);
$controller->showHistory();
