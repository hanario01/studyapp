<?php
class QuizModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * ランダムに問題IDリストを取得
     * @param int $grade 学年
     * @param string $subject 科目
     * @param int $limit 取得件数
     * @return array 問題IDの配列
     */
    public function getRandomQuestions($grade, $subject, $limit = 10) {
        $limit = (int)$limit; // 念のため整数化
        $stmt = $this->pdo->prepare("
            SELECT id FROM questions 
            WHERE grade = ? AND subject = ? 
            ORDER BY RAND() 
            LIMIT $limit
        ");
        $stmt->execute([$grade, $subject]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * 問題IDから詳細を取得
     * @param int $id 問題ID
     * @return array|null 問題データ
     */
    public function getQuestionById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 学習履歴を保存
     * @param int $userId
     * @param string $subject
     * @param int $questionId
     * @param bool|int $isCorrect 1=正解, 0=不正解
     */
    public function saveHistory($userId, $subject, $questionId, $isCorrect) {
        $sql = "
        INSERT INTO learning_history (user_id, subject, question_id, is_correct, created_at)
        VALUES (:user_id, :subject, :question_id, :is_correct, NOW())
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindValue(':question_id', $questionId, PDO::PARAM_INT);
        $stmt->bindValue(':is_correct', $isCorrect ? 1 : 0, PDO::PARAM_INT);
        $stmt->execute();
    }
}
