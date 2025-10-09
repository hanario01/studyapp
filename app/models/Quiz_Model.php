<?php
class QuizModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // ランダムに問題を取得
    public function getRandomQuestions($grade, $subject, $limit = 10) {
    $limit = (int)$limit; // 念のため数値化（SQLインジェクション防止）

    $stmt = $this->pdo->prepare("
        SELECT id FROM questions 
        WHERE grade = ? AND subject = ? 
        ORDER BY RAND() LIMIT $limit
    ");
    $stmt->execute([$grade, $subject]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


    // 問題IDから問題詳細を取得
    public function getQuestionById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
