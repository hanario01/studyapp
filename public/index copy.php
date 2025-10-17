<?php
session_start();
require_once '../config/db.php';

// 学年・科目のデフォルト値
$grade = 1;
$subjects = [
    'kanji'   => '国語',
    'math'    => '算数',
    'science' => '理科',
    'social'  => '社会'
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>まなびの森 - トップページ</title>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<header>
    <h1>まなびの森</h1>
    <nav class="user-nav">
        <ul class="auth-links">
            <li><a href="../app/views/login_view.php">ログイン</a></li>
            <li><a href="../app/views/register_view.php">新規登録</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="container">
        <h2>学年を選んでスタート</h2>
        <div class="grades">
            <form action="quiz.php" method="get">
                <label for="grade">学年:</label>
                <select name="grade" id="grade">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?>年生</option>
                    <?php endfor; ?>
                </select>

                <div class="subjects">
                    <?php foreach ($subjects as $key => $label): ?>
                        <button type="submit" name="subject" value="<?= $key ?>" class="grade-btn">
                            <?= $label ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>
