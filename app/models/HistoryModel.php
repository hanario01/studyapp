<?php
class HistoryModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function saveHistory($userId, $subject, $questionId, $isCorrect) {
        $stmt = $this->pdo->prepare("
            INSERT INTO learning_history (user_id, subject, question_id, is_correct, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$userId, $subject, $questionId, $isCorrect]);
    }

    public function getUserHistory($userId) {
        $sql = "SELECT subject, is_correct, created_at, question_id
                FROM learning_history
                WHERE user_id = ?
                ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function aggregateStats($history) {
        $dailyStats = [];
        $subjectStats = [];

        foreach ($history as $row) {
            $date = date('Y-m-d', strtotime($row['created_at']));
            $subject = $row['subject'];
            $isCorrect = $row['is_correct'];

            if (!isset($dailyStats[$date])) {
                $dailyStats[$date] = [];
            }
            if (!isset($dailyStats[$date][$subject])) {
                $dailyStats[$date][$subject] = ['correct' => 0, 'wrong' => 0, 'quizzes' => []];
            }
            if ($isCorrect) {
                $dailyStats[$date][$subject]['correct']++;
            } else {
                $dailyStats[$date][$subject]['wrong']++;
                $dailyStats[$date][$subject]['quizzes'][] = $row;
            }

            if (!isset($subjectStats[$subject])) {
                $subjectStats[$subject] = ['correct' => 0, 'total' => 0];
            }
            $subjectStats[$subject]['total']++;
            if ($isCorrect) $subjectStats[$subject]['correct']++;
        }

        return [$dailyStats, $subjectStats];
    }
}
