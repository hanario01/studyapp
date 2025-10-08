<?php
session_start();
require_once 'db.php';

// 学年・科目の取得
$grade = $_GET['grade'] ?? 1;
$subject = $_GET['subject'] ?? 'kanji';
$totalQuestions = 10; // 出題数

// セッションが存在しても、gradeやsubjectが前回と違う場合はリセット
if (!isset($_SESSION['questions']) || $_SESSION['grade'] != $grade || $_SESSION['subject'] != $subject) {
    $stmt = $pdo->prepare("SELECT id FROM questions WHERE grade = ? AND subject = ? ORDER BY RAND() LIMIT ?");
    $stmt->execute([$grade, $subject, $totalQuestions]);
    $_SESSION['questions'] = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $_SESSION['question_index'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['grade'] = $grade;
    $_SESSION['subject'] = $subject;
}

// 現在の問題
$index = $_SESSION['question_index'];
$questionId = $_SESSION['questions'][$index];

// 問題情報を取得
$stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->execute([$questionId]);
$question = $stmt->fetch();

$feedback = '';
$disableButtons = false;

// POST送信された場合（回答処理）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['answer'] ?? 0;
    $correct = $question['correct_option'];
    $correct_char = $question['option' . $correct];

    if ($selected == $correct) {
        $_SESSION['score'] += 10; // 1問10点
        $feedback = '正解！よくできました';
    } else {
        $feedback = '不正解。正解は '.$correct_char.' でした！';
    }

    $disableButtons = true; // 回答後はボタンを無効にする
    $_SESSION['question_index']++;

    // 最後の問題なら結果ページへ
    if ($_SESSION['question_index'] >= $totalQuestions) {
        header("Location: result.php?grade=$grade&subject=$subject");
        exit;
    } else {
        // PRGパターンで次の問題へ
        header("Location: quiz.php?grade=$grade&subject=$subject");
        exit;
    }
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>問題ページ</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <a href="index.php"><h1>まなびの森</h1></a>
</header>

<main>
<div class="container">
    <div class="question-text">
        <p class="quiz-title">
            問題：<?= h($question['question_text']); ?>
        </p>
    </div>

    <form method="post">
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="grades">
                <button type="submit" name="answer" value="<?= $i ?>" class="grade-btn" <?= $disableButtons ? 'disabled' : '' ?>>
                    <?= h($question['option' . $i]); ?>
                </button>
            </div>
        <?php endfor; ?>
    </form>

    <?php if ($feedback): ?>
        <p class="feedback"><?= $feedback ?></p>
    <?php endif; ?>
</div>
</main>
</body>
</html>
