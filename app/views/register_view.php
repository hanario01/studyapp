<?php
// register_view.php
// エラーメッセージがある場合は $error 配列に格納されている前提
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録</title>
  <link rel="stylesheet" href="../assets/css/style.css">

  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background: linear-gradient(135deg, #6bb8ff, #b6eaff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .register-container {
      background: white;
      padding: 2.5rem;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 380px;
      text-align: center;
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h1 {
      margin-bottom: 1.5rem;
      font-size: 1.6rem;
      color: #333;
    }

    input {
      width: 100%;
      padding: 0.75rem;
      margin: 0.5rem 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }

    button {
      width: 100%;
      padding: 0.75rem;
      background: #007bff;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 1rem;
      transition: background 0.3s;
    }

    button:hover {
      background: #0056b3;
    }

    .error-message {
      color: red;
      text-align: left;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    .link {
      margin-top: 1rem;
      font-size: 0.9rem;
    }

    .link a {
      color: #007bff;
      text-decoration: none;
    }

    .link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h1>新規登録</h1>

    <?php if (!empty($error)): ?>
      <div class="error-message">
        <ul>
          <?php foreach ($error as $e): ?>
            <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="?action=register" method="POST">
      <input type="text" name="username" placeholder="ユーザー名" required>
      <input type="email" name="email" placeholder="メールアドレス" required>
      <input type="password" name="password" placeholder="パスワード" required>
      <input type="password" name="password_confirm" placeholder="パスワード（確認）" required>
      <button type="submit">登録する</button>
    </form>

    <div class="link">
      <p>すでにアカウントをお持ちですか？ <a href="?action=login">ログインはこちら</a></p>
    </div>
  </div>
</body>
</html>
