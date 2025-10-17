<?php
require_once __DIR__ . '/../common/auth.php';
require_once __DIR__ . '/../common/function.php';
require_once __DIR__ . '/../models/HistoryModel.php';

class HistoryController {
    private $model;

    public function __construct($pdo) {
        $this->model = new HistoryModel($pdo);
    }

    public function showHistory() {
        checkLogin();
        $user = currentUser();
        $userId = $user['id'];

        // 履歴取得と集計（モデルに委譲）
        $history = $this->model->getUserHistory($userId);
        [$dailyStats, $subjectStats] = $this->model->aggregateStats($history);

        require __DIR__ . '/../views/history_view.php';
    }
}
