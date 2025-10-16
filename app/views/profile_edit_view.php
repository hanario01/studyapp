<?php
require_once __DIR__ . '/../common/function.php';

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>プロフィール編集 | まなびの森</title>
<style>
    body {
        font-family: "Yu Gothic", sans-serif;
        background: #f3f7ff;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
    }

    .container {
        background: #fff;
        width: 480px;
        margin-top: 80px;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        text-align: center;
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(15px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        color: #333;
        margin-bottom: 25px;
    }

    .profile-icon-edit {
        display: flex;
        flex-direction: column; /* 縦並び */
        align-items: center;   /* 中央寄せ */
        justify-content: center;
        margin-bottom: 20px;
    }

    .profile-icon {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #3b82f6;
        object-fit: cover;
        margin-bottom: 15px;
        box-shadow: 0 0 10px rgba(59,130,246,0.3);
        transition: transform 0.3s ease;
    }
    .profile-icon:hover { transform: scale(1.05); }

    input[type="file"] { display: none; }

    .custom-file-label {
        background-color: #3b82f6;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-block;
        margin-bottom: 20px;
        transition: background 0.3s;
    }
    .custom-file-label:hover { background-color: #2563eb; }

    input[type="text"], input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        margin-top: 10px;
        margin-bottom: 20px;
        transition: border-color 0.3s;
    }
    input:focus { border-color: #3b82f6; outline: none; }

    button {
        width: 100%;
        background: #3b82f6;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s;
    }
    button:hover { background: #2563eb; }

    .message { margin-bottom: 15px; padding: 10px; border-radius: 8px; }
    .message.success { background-color: #d1fae5; color: #065f46; }
    .message.error { background-color: #fee2e2; color: #b91c1c; }
</style>
</head>
<body>

<div class="container">
    <h2>プロフィール編集</h2>

    <?php if (!empty($message)): ?>
        <div class="message success"><?= h($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="message error"><?= h(implode('<br>', $error), ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="/studystep/studyapp-1/public/profile_edit.php">
        <div class="profile-icon-edit">
            <!-- プロフィール画像 -->
            <img id="preview"
                src="<?= !empty($user['icon'])
                        ? h($user['icon'], ENT_QUOTES, 'UTF-8')
                        : '/studystep/studyapp-1/public/uploads/icons/default.png' ?>"
                alt="プロフィール画像"
                class="profile-icon">

            <label for="icon" class="custom-file-label">画像を選択</label>
            <input type="file" name="icon" id="icon" accept="image/*" onchange="previewImage(event)">
            </div>

        <!-- ユーザー名 -->
        <input type="text" name="username" value="<?= h($user['username'], ENT_QUOTES, 'UTF-8') ?>" placeholder="ユーザー名" required>

        <!-- メール -->
        <input type="email" name="email" value="<?= h($user['email'], ENT_QUOTES, 'UTF-8') ?>" placeholder="メールアドレス" required>
        <!-- 既存アイコン名を保持 -->
        <input type="hidden" name="current_icon" value="<?= h($user['icon'], ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit">保存</button>
    </form>

    <div style="margin-top:20px;">
        <a href="/studystep/studyapp-1/public/mypage.php" style="color:#3b82f6;text-decoration:none;">マイページに戻る</a>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>
