<?php

require_once __DIR__ . '/../app/models/Quiz_Model.php';
require_once __DIR__ . '/../app/common/auth.php';
require_once __DIR__ . '/../config/db.php';

// checkLogin();
$user = currentUser();
$model = new QuizModel($pdo);

// 復習対象の問題IDを取得
$reviewIds = $_SESSION['review_questions'] ?? [];

if (empty($reviewIds)) {
    echo "復習対象の問題がありません。";
    exit;
}

// 初期化
if (!isset($_SESSION['review_index'])) {
    $_SESSION['review_index'] = 0;
    $_SESSION['review_answers'] = [];
}

$index = $_SESSION['review_index'];
$questionId = $reviewIds[$index] ?? null;

if (!$questionId) {
    header('Location: review_result.php');
    exit;
}

$question = $model->getQuestionById($questionId);

// 回答処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['answer'] ?? 0;
    $correct = $question['correct_option'];
    $isCorrect = ($selected == $correct) ? 1 : 0;

    $_SESSION['review_answers'][] = [
        'question_id' => $question['id'],
        'user_answer' => $selected,
        'correct_answer' => $correct,
        'is_correct' => $isCorrect
    ];

    $_SESSION['review_index']++;

    header("Location: review.php");
    exit;
}

include __DIR__ . '/../app/views/review_view.php';
