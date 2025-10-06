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
    <header>
        <a href="index.php"><h1>まなびの森</h1></a>
        <nav class="user-nav">
            <ul class="auth-links">
                <li><a href="login.php">ログイン</a></li>
                <li><a href="register.php">新規登録</a></li>
            </ul>
        </nav>
    </header>
    <main>
    <div class="container">
        <div class="subject-title">
            <h2><?=$grade ?><ruby>年生<rt>ねんせい</rt></ruby>の<ruby>問題<rt>もんだい</rt></ruby></h2>
            <p>かもくをえらんでね！</p>
        </div>       
        <div class="grades">
            <ul class="grades-Subject">
                <li><a href="quiz.php?grade=<?=$grade?>&subject=kanji" class="grade-btn">こくご</a></li>
                <li><a href="quiz.php?grade=<?=$grade?>&subject=math" class="grade-btn">さんすう</a></li>
                <li><a href="quiz.php?grade=<?=$grade?>&subject=science" class="grade-btn">りか</a></li>
                <li><a href="quiz.php?grade=<?=$grade?>&subject=social" class="grade-btn">しゃかい</a></li>                   
            </ul>
        </div>
    </div>   
    </main>
    <footer></footer>
    
</body>
</html>