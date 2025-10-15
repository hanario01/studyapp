<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #6fb1fc, #4364f7, #3f51b5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            padding: 40px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            animation: fadeIn 0.7s ease-in-out;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #555;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #45a049;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>登録が完了しました 🎉</h1>
        <p>ご登録ありがとうございます。<br>下のボタンからマイページへ移動して学習を始めよう！</p>
        <a href="mypage_view.php">マイページ</a>
    </div>
</body>
</html>
