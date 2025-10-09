<?php
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../models/Quiz_Model.php';

class QuizController {
    private $model;

    public function __construct($pdo) {
        $this->model = new QuizModel($pdo);
    }

    public function handleRequest() {
        $grade = $_GET['grade'] ?? 1;
        $subject = $_GET['subject'] ?? 'kanji';
        $total = 10;

        // 初期化処理
        if (!isset($_SESSION['questions']) || $_SESSION['grade'] != $grade || $_SESSION['subject'] != $subject) {
            $_SESSION['questions'] = $this->model->getRandomQuestions($grade, $subject, $total);
            $_SESSION['grade'] = $grade;
            $_SESSION['subject'] = $subject;
            $_SESSION['index'] = 0;
            $_SESSION['score'] = 0;
        }

        $index = $_SESSION['index'];
        $questionId = $_SESSION['questions'][$index];
        $question = $this->model->getQuestionById($questionId);

        // POST処理（回答時）
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selected = $_POST['answer'] ?? 0;
            $correct = $question['correct_option'];

            if ($selected == $correct) {
                $_SESSION['score'] += 10;
            }

            $_SESSION['index']++;

            if ($_SESSION['index'] >= $total) {
                header('Location: result.php');
                exit;
            } else {
                header("Location: quiz.php?grade={$grade}&subject={$subject}");
                exit;
            }
        }

        // ビュー呼び出し
        include __DIR__ . '/../views/quiz_view.php';
    }
}
