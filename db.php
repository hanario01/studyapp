<?php
// db.php
require_once 'config.php';

//config.phpに定義してあるDB_HOSTなどを使って$dsnを定義
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // エラーを例外で取得
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // 配列で取得
        PDO::ATTR_EMULATE_PREPARES => false, // 本物のプリペアドステートメントを使用
    ]);
} catch (PDOException $e) {
    // 本番では詳細を出さずログに記録
    error_log($e->getMessage());
    exit('DB接続エラーが発生しました。');
}
