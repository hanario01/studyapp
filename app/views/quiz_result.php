<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/models/QuizModel.php';

if (empty($_SESSION['quiz_questions']) || empty($_SESSION['answers'])) {
    header('Location: quiz.php');
    exit;
}

$model = new QuizModel($pdo);
$questions = $_SESSION['quiz_questions'];
$answers = $_SESSION['answers'];
$userId = $_SESSION['user']['id'] ?? null;

$correctCount = 0;
$total = count($questions);
$wrongQuestions = [];

foreach ($questions as $index => $q) {
    $correct = $q['correct_option'];
    if ($answers[$index] == $correct) {
        $correctCount++;
    } else {
        $wrongQuestions[] = $q;
    }
}

$accuracy = round(($correctCount / $total) * 100, 1);

// 結果をDBに保存
if ($userId) {
    $model->saveQuizResult($userId, $correctCount, $total, $accuracy);
}

// セッション初期化（結果画面だけ残す）
unset($_SESSION['quiz_questions'], $_SESSION['answers'], $_SESSION['current_index']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>結果</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>結果発表 🎉</h2>
    <p>正解数：<?= $correctCount ?>/<?= $total ?></p>
    <p>正答率：<?= $accuracy ?>%</p>

    <?php if (!empty($wrongQuestions)): ?>
        <h3>復習問題</h3>
        <ul>
            <?php foreach ($wrongQuestions as $w): ?>
                <li><?= htmlspecialchars($w['question_text'], ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="/studystep/studyapp-1/public/history.php">学習履歴へ</a>
</body>
</html>
