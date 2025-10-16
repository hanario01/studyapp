<?php
require_once __DIR__ . '/../common/function.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>まなびの森 - 新規登録</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* =========================== 共通スタイル =========================== */
        body {
            font-family: 'Segoe UI', 'Hiragino Sans', 'Meiryo', sans-serif;
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            width: 100%;
            background-color: #4a90e2;
            color: white;
            text-align: center;
            padding: 15px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }

        header h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 40px 50px;
            width: 90%;
            max-width: 400px;
            animation: fadeIn 0.7s ease-in-out;
        }

        /* =========================== フォーム =========================== */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            font-size: 0.95rem;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 5px rgba(74,144,226,0.3);
            outline: none;
        }

        button.grade-btn {
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button.grade-btn:hover {
            background-color: #357ABD;
            transform: translateY(-2px);
        }

        a {
            color: #4a90e2;
            text-decoration: none;
            font-size: 0.9rem;
        }

        a:hover {
            text-decoration: underline;
        }

        /* =========================== エラー表示 =========================== */
        .error-box {
            background-color: #ffe3e3;
            border-left: 5px solid #ff6b6b;
            padding: 10px 15px;
            border-radius: 5px;
            color: #c0392b;
            margin-bottom: 20px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<header>
    <h1>まなびの森 - 新規登録</h1>
</header>

<main>
    <div class="container">

        <!-- 🔹 エラー表示エリア -->
        <?php if (!empty($error)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($error as $e): ?>
                        <li><?= h($e, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- フォーム開始 -->
        <form method="post" action="http://localhost/studystep/studyapp-1/public/register.php">
            
            <div class="form-group">
                <label for="username">ユーザー名</label>
                <input type="text" id="username" name="username" placeholder="例：manabi_taro" required>
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" placeholder="例：example@mail.com" required>
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" placeholder="8文字以上の英数字" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">パスワード確認</label>
                <input type="password" id="password_confirm" name="password_confirm" placeholder="もう一度入力" required>
            </div>
            <input type="hidden" name=action value="register">
            <button type="submit" class="grade-btn">登録</button>
        </form>
        <!-- フォーム終了 -->
                    
        <a href="/studystep/studyapp-1/app/views/login_view.php">すでにアカウントを持っている場合はこちら</a>
    </div>
</body>
</html>
