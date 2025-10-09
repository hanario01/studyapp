<?php
// session_start() は不要（ビューなので）
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>まなびの森 - 新規登録</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <h1>まなびの森 - 新規登録</h1>
</header>

<main>
    <div class="container">
        <!-- フォーム開始 -->
        <form method="post" action="register.php">
            
            <!-- ユーザー名入力欄 -->
            <input type="text" name="username" placeholder="ユーザー名" required>

            <!-- メールアドレス入力欄 -->
            <input type="email" name="email" placeholder="メールアドレス" required>

            <!-- パスワード入力欄 -->
            <input type="password" name="password" placeholder="パスワード" required>

            <!-- 確認用パスワード（任意） -->
            <input type="password" name="password_confirm" placeholder="パスワード確認" required>

            <!-- 登録ボタン -->
            <button type="submit" class="grade-btn">登録</button>
        </form>
        <!-- フォーム終了 -->

        <!-- ログインページへのリンク -->
        <a href="login.php">すでにアカウントを持っている場合はこちら</a>
    </div>
</main>
</body>
</html>
