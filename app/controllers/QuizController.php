<?php
session_start();
require_once __DIR__ . '/../models/Quiz_Model.php';
require_once __DIR__ . '/../common/auth.php';

class QuizController {
    private $model;

    public function __construct($pdo) {
        $this->model = new QuizModel($pdo);
    }

    // クイズページ表示・回答処理
    public function handleRequest() {
        checkLogin(); // ログイン必須

        $grade = $_GET['grade'] ?? 1;
        $subject = $_GET['subject'] ?? 'kanji';
        $total = 10;

        // 初期化
        if (!isset($_SESSION['questions']) || $_SESSION['grade'] != $grade || $_SESSION['subject'] != $subject) {
            $_SESSION['questions'] = $this->model->getRandomQuestions($grade, $subject, $total);
            $_SESSION['grade'] = $grade;
            $_SESSION['subject'] = $subject;
            $_SESSION['index'] = 0;
            $_SESSION['answers'] = []; // 回答履歴
        }

        $index = $_SESSION['index'];
        $questions = $_SESSION['questions'];

        // 範囲外ならリザルトへ
        if (!isset($questions[$index])) {
            header('Location: result.php');
            exit;
        }

        $question = $this->model->getQuestionById($questions[$index]);

        // POST処理（回答送信時）
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selected = $_POST['answer'] ?? 0;
            $correct = $question['correct_option'];

            $isCorrect = ($selected == $correct) ? 1 : 0;

            // 回答をセッションに記録
            $_SESSION['answers'][] = [
                'question_id' => $question['id'],
                'user_answer' => $selected,
                'correct_answer' => $correct,
                'is_correct' => $isCorrect
            ];

            $_SESSION['index']++;

            // 全問終了時 → 結果ページへ
            if ($_SESSION['index'] >= $total) {
                $this->saveResultToDB(); // DBにもまとめて保存
                header('Location: result.php');
                exit;
            } else {
                header("Location: quiz.php?grade={$grade}&subject={$subject}");
                exit;
            }
        }

        include __DIR__ . '/../views/quiz_view.php';
    }

    // 回答結果をまとめてDBに保存
    private function saveResultToDB() {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId || empty($_SESSION['answers'])) return;

        $subject = $_SESSION['subject'];
        foreach ($_SESSION['answers'] as $a) {
            $this->model->saveHistory($userId, $subject, $a['question_id'], $a['is_correct']);
        }
    }
}
