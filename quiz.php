<?php
// セッションを開始する
session_start();
// DB接続を行う
require_once 'db.php';
// 学年・科目をGETパラメータから取得する
$grade = $_GET['grade'] ?? 1;
$subject = $_GET['subject'] ?? 'kanji';
// 出題数を設定する
$totalQuestions = 10;

// 初回アクセスまたは科目変更時の処理
if (!isset($_SESSION['questions']) || $_SESSION['grade'] != $grade || $_SESSION['subject'] != $subject) {
    $stmt = $pdo -> prepare("SELECT id FROM questions WHERE grade = ? AND subject = ? ORDER BY RAND() LIMIT ?");
    $stmt -> execute([$grade,$subject,$totalQuestions]);
    $_SESSION['questions'] = $stmt -> fetchAll(PDO::FETCH_COLUMN);
    $_SESSION['grade'] = $grade;
    $_SESSION['subject'] = $subject;
    $_SESSION['question_index'] = 0;
    $_SESSION['score'] = 0;
}
// 現在の問題IDをセッションから取得する
$index = $_SESSION['question_index'];
$questionId = $_SESSION['questions'][$index];
// DBから現在の問題情報を取得する
$stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
$stmt -> execute([$questionId]);
$questions = $stmt -> fetch();
$feedback = '';

// 回答処理
// - フォームがPOST送信されたか確認
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // - 選択された答えを取得
    $selected = $_POST['answer'] ?? 0;
    $correct = $questions['correct_option'];
    $correct_char = $questions['option'.$correct];
    
    // - 正誤判定を行う
    if($selected == $correct){
        $_SESSION['score'] += 10;
        $feedback = "正解です！よくできました";   
    } else {
        $feedback = "不正解！答えは".h($correct)."の".h($correct_char)."でした！";
    }
    $_SESSION['question_index']++;


    if($index >= $totalQuestions){
        header("Location: result.php?grade=$grade&subject=$subject");
        exit; 
    }else {
        header("Location: quiz.php?grade=$grade&subject=$subject");
        exit;
    }    
    // - 正解ならスコアを加算
    // - フィードバックメッセージを作成
    // - 次の問題番号に進める
    // - 最後の問題なら結果ページにリダイレクト
    // - まだ問題が残っていればPRGパターンで同じページへリダイレクト
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問題ページ</title>
    <!-- CSSを読み込む -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <!-- サイトのタイトル・リンク -->
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
    <div class="question-text">
        <!-- 低学年ならふりがな付き問題文、高学年なら普通の問題文を表示 -->
        <p class="question-text">
            <?php if($grade > 2 && $subject = 'kanji') :?>
                <?= h($questions['question_text']); ?>
            <?php else :?>
                <?= h($questions['question_furigana']); ?>
            <?php endif; ?>
        </p>
    </div>

    <!-- 回答前ならフォームを表示 -->
    <?php if(!$feedback) :?>
    <form method="post">
        <!-- 4択ボタンをループで表示 -->
        <?php for($i = 1;$i <= 4;$i++) :?>
        <!-- ボタンには選択肢のテキストを表示 -->
        <button type="submit" name="answer" value ="<?=$i?>" class="grade-btn">
            <?= h($questions['option' . $i]); ?>
        </button>

        <?php endfor; ?>
    </form>
    <?php else: ?>
    <p class="feedback"><?=$feedback?></p>
    <a href="quiz.php?grade=<?= $grade ?>&subject=<?= $subject ?>" class="grade-btn">つぎの問題へ</a>
    <!-- 回答後はフィードバックを表示 -->
    <!-- 正解・不正解のメッセージ -->
    <!-- 次の問題へ進むボタン -->
    <?php endif; ?>
</div>
</main>
</body>
</html>
