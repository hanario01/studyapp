<?php
require_once __DIR__ . '/../common/auth.php';

// ログインしていなければリダイレクト
checkLogin();

// 現在のユーザー情報を取得
$user = currentUser();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>マイページ - まなびの森</title>
<link rel="stylesheet" href="../css/style.css">
<style>
body {
    font-family: "Yu Gothic", sans-serif;
    background-color: #f3f7ff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.mypage {
    background: #fff;
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    width: 450px;
    text-align: center;
    position: relative;
}
.fade {
    font-size: 20px;
    color: #3b82f6;
    opacity: 0;
    animation: fadeInOut 4s ease forwards;
}
@keyframes fadeInOut {
    0% {opacity: 0;}
    20% {opacity: 1;}
    80% {opacity: 1;}
    100% {opacity: 0;}
}
.menu {
    margin-top: 30px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.menu a {
    display: block;
    background: #3b82f6;
    color: white;
    text-decoration: none;
    padding: 12px;
    border-radius: 8px;
    transition: 0.3s;
}
.menu a:hover {
    background: #2563eb;
}
</style>
</head>
<body>
<div class="mypage">
    <div class="fade">ようこそ、<?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?> さん！</div>

    <div class="menu">
        <a href="/studyapp-1/public/profile_edit.php">プロフィール編集</a>
        <a href="/studyapp-1/public/history.php">学習履歴・分析</a>
        <a href="/studyapp-1/public/quiz.php">問題ページへ</a>
        <a href="/studyapp-1/public/logout.php" style="background:#ef4444;">ログアウト</a>
    </div>
</div>
</body>
</html>
