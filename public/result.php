<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/common/function.php';
require_once __DIR__ . '/../app/common/auth.php';

checkLogin();

// モード判定（通常 or 復習）
$mode = $_SESSION['review_answers'] ?? false ? 'review' : 'normal';

// 回答データを取得
$answers = $mode === 'review' ? $_SESSION['review_answers'] : ($_SESSION['answers'] ?? []);
$total = count($answers);
$correct = count(array_filter($answers, fn($a) => $a['is_correct']));
$rate = $total > 0 ? round($correct / $total * 100, 2) : 0;

// 復習モードならセッションをクリア
if ($mode === 'review') {
    unset($_SESSION['review_questions'], $_SESSION['review_index'], $_SESSION['review_answers']);
} else {
    // 間違えた問題IDを抽出して復習用に保存
    $_SESSION['review_questions'] = array_column(
        array_filter($answers, fn($a) => !($a['is_correct'] ?? false)),
        'question_id'
    );
}


// ビューに渡す
require_once __DIR__ . '/../app/views/result_view.php';
