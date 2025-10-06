<?php
$grade = $_GET['grade'] ?? 1;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>まなびの森 選択科目</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <a href="index.php"><h1>まなびの森</h1></a>
            <nav class="user-nav">
                <ul class="auth-links">
                    <li><a href="login.php">ログイン</a></li>
                    <li><a href="register.php">新規登録</a></li>
                </ul>
            </nav>
        </header>
        <main></main>
        <footer></footer>
    </div>
</body>
</html>