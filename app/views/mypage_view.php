<?php
    require_once __DIR__ . '/../common/auth.php'; 
    require_once __DIR__ . '/../common/function.php'; 
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
.icon{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    margin-bottom:1rem;
}
.profile-icon {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #3b82f6;
        object-fit: cover;
        margin: 0
        margin-bottom: 15px;
        box-shadow: 0 0 10px rgba(59,130,246,0.3);
        transition: transform 0.3s ease;
    }
.menu .btn-style {
    display: inline-block;
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
.menu .btn-logout{    
    background: #ef4444;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    margin:0 auto;
    border:none;
    transition: 0.3s;
    
}
.menu .btn-logout:hover{
    background: #ee1515ff;
}

</style>
</head>
<body>
<div class="mypage">
    <div class="fade">ようこそ、<?= h($user['username'], ENT_QUOTES, 'UTF-8') ?> さん！</div>

    <div class="menu">
        <div class="icon">
        <img id="preview"
            src="<?= !empty($user['icon']) 
                    ? h($user['icon'], ENT_QUOTES, 'UTF-8') 
                    : '/studystep/studyapp-1/public/uploads/icons/default.png' ?>"
            alt="プロフィール画像"
            class="profile-icon">
        </div>
        <a href="/studystep/studyapp-1/public/profile_edit.php" class="btn-style">プロフィール編集</a>
        <a href="/studystep/studyapp-1/public/history.php" class="btn-style">学習履歴・分析</a>
        <a href="/studystep/studyapp-1/public/index.php?start=new" class="btn-style" >問題ページへ</a>
        <form method="POST" action="/studystep/studyapp-1/public/logout.php">
            <input type="hidden" name="action" value="logout">
            <button type="/studystep/studyapp-1/public/logout.php" class="btn-logout">ログアウト</button>
        </form>
        
    </div>
</div>
</body>
</html>
