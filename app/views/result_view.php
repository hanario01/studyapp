<?php
require_once '../app/common/function.php';

$user = $_SESSION['user'] ?? null;
$mode = $_SESSION['review_answers'] ?? false ? 'review' : 'normal';
$answers = $mode === 'review' ? ($_SESSION['review_answers'] ?? []) : ($_SESSION['answers'] ?? []);

$totalQuestions = count($answers);
$correctCount = array_sum(array_column($answers, 'is_correct'));
$correctRate = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
$isPerfect = ($correctCount === $totalQuestions) && $totalQuestions > 0;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $mode === 'review' ? '復習結果' : 'クイズ結果' ?> | まなびの森</title>
<style>
body {
    font-family: "Yu Gothic", sans-serif;
    background: #f3f7ff;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
}

.container {
    background: #fff;
    width: 480px;
    margin-top: 80px;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    text-align: center;
    animation: fadeIn 0.6s ease;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(15px);}
    to {opacity: 1; transform: translateY(0);}
}

h2 {
    color: #333;
    margin-bottom: 25px;
}

.user-info {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
}

.user-info img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid #3b82f6;
    object-fit: cover;
    margin-right: 15px;
}

.stats {
    margin-bottom: 20px;
}

.stats p {
    font-size: 18px;
    margin: 8px 0;
}

.success-message {
    background-color: #d1fae5;
    color: #065f46;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-weight: bold;
}

.review-btn {
    background-color: #3b82f6;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    text-decoration: none;
    display: inline-block;
}

.review-btn:hover {
    background-color: #2563eb;
}
</style>
</head>
<body>
<div class="container">
    <h2><?= $mode === 'review' ? '復習クイズ結果' : 'クイズ結果' ?></h2>

    <?php if ($user): ?>
        <div class="user-info">
            <img src="<?= !empty($user['icon']) ? h($user['icon']) : '/studystep/studyapp-1/public/uploads/icons/default.png' ?>" alt="ユーザーアイコン">
            <div>
                <p><?= h($user['username']) ?> さん</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="stats">
        <p>正答数: <?= h($correctCount) ?> / <?= h($totalQuestions) ?></p>
        <p>正答率: <?= h($correctRate) ?>%</p>
    </div>

    <?php if ($isPerfect): ?>
        <div class="success-message">🎉 全問正解おめでとう！ 🎉</div>
    <?php endif; ?>

    <?php if ($mode === 'normal' && $totalQuestions > 0): ?>
        <form action="review.php" method="post">
            <button type="submit" class="review-btn">間違えた問題を復習する</button>
        </form>
    <?php endif; ?>

    <div style="margin-top:20px;">
        <a href="/studystep/studyapp-1/public/mypage.php" class="review-btn" style="background:#f97316;">マイページに戻る</a>
    </div>
</div>
</body>
</html>
