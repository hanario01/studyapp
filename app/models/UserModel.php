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
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username,email,password)
            VALUES(?,?,?)
        ");
        return $stmt-> execute([$username,$email,$hashedPassword]);
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
        $stmt = $this->pdo->prepare("
            SELECT * FROM users 
            WHERE email = ?
        ");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $stmt = $this->pdo->prepare("
            SELECT * FROM users 
            WHERE username = ?
        ");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //メールアドレスがすでに登録されているかチェック
    public function isEmailExists($email){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt -> execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    //ユーザ名がすでに登録されているかチェック
    public function isUsernameExists($username){
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM users WHERE username = ?
        ");
        $stmt -> execute([$username]);
        return $stmt->fetchColumn() > 0;
    }


}
