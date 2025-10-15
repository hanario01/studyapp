<?php
<?php
// 画像アップロード先のディレクトリ
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/icons/');

// 画像の表示用URL
define('UPLOAD_URL', '/studystep/studyapp-1/public/uploads/icons/');


$dsn = 'mysql:host=localhost;dbname=studyapp;charset=utf8';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit('データベース接続に失敗しました。');
}
