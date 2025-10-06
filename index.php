<?php


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>まなびの森 - 学年選択</title>
    <!-- Google Fonts 丸ゴシック -->
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
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
            <p><ruby>学年<rt>がくねん</rt></ruby>を<ruby>選<rt>え</rt></ruby>らんでスタート！</p>     
            <div class="grades">
                <a href="grade.php?grade=1" class="grade-btn">
                    <ruby>一年生<rt>いちねんせい</rt></ruby>
                </a>
                <a href="grade.php?grade=2" class="grade-btn">
                    <ruby>二年生<rt>にねんせい</rt></ruby>
                </a>
                <a href="grade.php?grade=3" class="grade-btn">
                    <ruby>三年生<rt>さんねんせい</rt></ruby>
                </a>
            </div>
        </div>
    </main>
    <footer></footer>
</body>
</html>
