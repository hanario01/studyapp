<?php
class UserModel {
    private $pdo;

    // コンストラクタ：PDOオブジェクトを受け取って保持する
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // ユーザーを新規作成する
    public function createUser($username, $email, $hashedPassword) {
        /*
        ここでやること：
        1. INSERT文を準備する（プレースホルダ使用）
        2. 引数の $username, $email, $hashedPassword をバインド
        3. execute() でデータベースに登録
        4. 成功すれば true、失敗すれば false を返す
        */
        $stmt = $this -> $pdo -> prepare("
            INSERT INTO users (username, email, password)
            VALUES (?,?,?)
        ");
    }

    // メールアドレスからユーザー情報を取得
    public function getUserByEmail($email) {
        /*
        ここでやること：
        1. SELECT文を準備（WHERE email = ?）
        2. $email をバインド
        3. fetch() でユーザー情報を取得
        4. 見つかれば配列で返す、なければ false
        */
        $stmt = $pdo -> prepare("SELECT email FROM user WHERE email=?");
        $stmt -> execute([$email]);
        $stmt -> fetch();
    }

    // ユーザー名からユーザー情報を取得
    public function getUserByUsername($username) {
        /*
        ここでやること：
        1. SELECT文を準備（WHERE username = ?）
        2. $username をバインド
        3. fetch() でユーザー情報を取得
        4. 見つかれば配列で返す、なければ false
        */
    }

    // 必要に応じて、メールアドレスやユーザー名の重複チェック関数も作れる
    // public function isEmailExists($email) { ... }
    // public function isUsernameExists($username) { ... }
}
