<?php
class UserModel {
    private $pdo;

    // コンストラクタ：PDOオブジェクトを受け取って保持する
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // -----------------------
    // ユーザーを新規作成して登録したユーザー情報を返す
    // -----------------------
    public function createUser($username, $email, $hashedPassword) {
        try {
            // INSERT
            $stmt = $this->pdo->prepare("
                INSERT INTO users (username,email,password)
                VALUES(?,?,?)
            ");
            $stmt->execute([$username, $email, $hashedPassword]);

            // 登録したユーザーIDを取得
            $id = $this->pdo->lastInsertId();

            // DBからそのユーザーの完全情報を取得して返す
            $stmt2 = $this->pdo->prepare("SELECT id, username, email, icon FROM users WHERE id = ?");
            $stmt2->execute([$id]);
            return $stmt2->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // 重複エラーならfalseを返す
            if ($e->getCode() == 23000) {
                return false;
            }
            throw $e; // その他は例外を再スロー
        }
    }

    // -----------------------
    // メールアドレスからユーザー情報を取得
    // -----------------------
    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // -----------------------
    // ユーザー名からユーザー情報を取得
    // -----------------------
    public function getUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // -----------------------
    // メールアドレスの重複チェック
    // -----------------------
    public function isEmailExists($email){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    // -----------------------
    // ユーザー名の重複チェック
    // -----------------------
    public function isUsernameExists($username){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    // -----------------------
    // プロフィール更新
    // -----------------------
    public function updateUser($userId, $username, $email, $iconPath = '') {
        if (empty($userId) || empty($username) || empty($email)) {
            throw new Exception('ユーザー情報が不完全です。');
        }

        // 基本SQL
        $sql = "UPDATE users SET username = :username, email = :email";
        $params = [
            ':username' => $username,
            ':email'    => $email,
            ':id'       => $userId
        ];

        // アイコンがある場合のみ追加
        if (!empty($iconPath)) {
            $sql .= ", icon = :icon";
            $params[':icon'] = $iconPath;
        }

        $sql .= " WHERE id = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("ユーザー情報更新エラー: " . $e->getMessage());
            return false;
        }
    }
}
