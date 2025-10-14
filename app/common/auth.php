<?php


// セッションがまだ開始されていなければ開始
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * ログインチェック関数
 * - 未ログインならログインページにリダイレクト
 */
function checkLogin() {
    if (empty($_SESSION['user'])) {
        header('Location: /studyapp-1/public/login.php');
        exit;
    }
}

/**
 * 現在ログイン中のユーザー情報を返す
 * - 未ログインの場合は null
 */
function currentUser() {
    return $_SESSION['user'] ?? null;
}
