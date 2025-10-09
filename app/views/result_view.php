<?php
function h($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
$score = $_SESSION['score'] ?? 0;
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>まなびの森 - 結果</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <a href="../public/index.php"><h1>まなびの森</h1></a>
</header>

<main>
    <div class="container-result">
        <h2>あなたのスコア：<?= h($score) ?>点</h2>
        <a href="../public/index.php" class="grade-btn backtop">トップへ戻る</a>
    </div>
</main>
</body>
</html>
