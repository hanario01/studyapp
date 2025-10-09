<?php
function h($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>まなびの森 - クイズ</title>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<header>
    <a href="../index.php"><h1>まなびの森</h1></a>
</header>

<main>
    <div class="container">
        <p class="question-text">
            <?= h($question['question_furigana'] ?: h($question['question_text'])) ?>                    
        </p>

        <form method="post">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <button type="submit" name="answer" value="<?= $i ?>" class="grade-btn">
                    <?= h($question['option' . $i]); ?>
                </button>
            <?php endfor; ?>
        </form>
    </div>
</main>
</body>
</html>
