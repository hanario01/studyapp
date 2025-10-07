<?php
require_once 'db.php';

// 学年・科目の取得（GET）
$grade = $_GET['grade'] ?? 1;
$subject = $_GET['subject'] ?? 'kanji';


if ($grade === null || $subject === null) {
    header("Location: index.php");
    exit;
}

// ランダムで1問取得
$stmt = $pdo->prepare("SELECT * FROM questions WHERE grade = ? AND subject = ? ORDER BY RAND() LIMIT 1");
$stmt->execute([$grade, $subject]);
$question = $stmt->fetch();

$feedback = '';
$correct = $question['correct_option'];
$correct_char = $question['option' . $correct];

// POST送信された場合（回答処理）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['answer'] ?? 0;

    // 正誤判定
    $result = ($selected == $correct) ? 'correct' : 'wrong';

    // POST→GETリダイレクト（PRGパターン）
    header("Location: quiz.php?grade=$grade&subject=$subject&result=$result&answer=$selected");
    exit;
}

// GETでresultがある場合（リダイレクト後）
if (isset($_GET['result'])) {
    if ($_GET['result'] === 'correct') {
        $feedback = '正解！よくできました';
    } else {
        $feedback = '不正解。正解は ' . h($correct_char) . ' でした！';
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
    <nav>
        <ul class="auth-links">
            <li><a href="login.php">ログイン</a></li>
            <li><a href="register.php">新規登録</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="container">
        <div class="question-text">
            <p class="quiz-title">
                問題：<?= $question['question_furigana'] ?: h($question['question_text']); ?>
            </p>
        </div>

        <?php if (!$feedback): // 回答前 ?>
            <form method="post">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="grades">
                        <button type="submit" name="answer" value="<?= $i ?>" class="grade-btn">
                            <?= h($question['option' . $i]); ?>
                        </button>
                    </div>
                <?php endfor; ?>
            </form>
        <?php else: // 回答後 ?>
            <p class="feedback margin-feedback"><?= $feedback ?></p>
            <a href="quiz.php?grade=<?= $grade ?>&subject=<?= $subject ?>" class="grade-btn">つぎの問題へ</a>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
