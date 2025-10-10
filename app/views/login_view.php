<?php
// セッション開始（エラーメッセージなどを扱う場合に必要）
function h($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }

// エラーメッセージを一時的に表示する（例：ログイン失敗時など）
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>まなびの森 - ログイン</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    /* ======== 基本レイアウト ======== */
    body {
        background-color: #f3f7ff;
        font-family: "Yu Gothic", sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
    }

    header h1 {
        font-size: 28px;
        color: #3b82f6;
        text-shadow: 1px 1px 2px #ccc;
    }

    .login-container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 40px 50px;
        width: 350px;
        text-align: center;
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        margin-bottom: 25px;
        color: #333;
        font-size: 22px;
    }

    label {
        display: block;
        text-align: left;
        font-weight: bold;
        color: #555;
        margin-top: 15px;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    input:focus {
        border-color: #3b82f6;
        outline: none;
    }

    .login-btn {
        margin-top: 25px;
        width: 100%;
        padding: 12px;
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .login-btn:hover {
        
    }

    .error-message {
        color: #e11d48;
        background-color: #fee2e2;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .link {
        margin-top: 15px;
        font-size: 14px;
    }

    .link a {
        color: #3b82f6;
        text-decoration: none;
    }

    .link a:hover {
        
    }
    </style>
</head>
<body>
    <header>
    <h1>まなびの森</h1>
</header>

    <div class="login-container">
    <h2>ログイン</h2>

    <!-- エラーメッセージ表示 -->
    <?php if ($error): ?>
        <div class="error-message"><?= h($error) ?></div>
    <?php endif; ?>

    <!-- ログインフォーム -->
   <form method="post" action="/studyapp-1/public/login.php">
    <input type="hidden" name="action" value="login">
    <label for="login_input">ユーザー名またはメールアドレス</label>
    <input type="text" id="login_input" name="login_input" required>
    
    <label for="password">パスワード</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="login-btn">ログイン</button>
</form>

        <div class="link">
            <p>アカウントをお持ちでない方は <a href="register_view.php">新規登録</a></p>
        </div>
    </div>
</body>
</html>
