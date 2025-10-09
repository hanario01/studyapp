<?php
session_start()
// require_once で db.php を読み込む
// require_once で UserModel.php を読み込む
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../models/User_Model.php';

class UserController {
    private $model;

    // コンストラクタで UserModel を初期化
    public function __construct($pdo) {
        $this->model = new UserModel($pdo);
    }

    public function handleRequest() {
        /*
        1. $_GET['action'] で処理を分岐
            - action = 'register' → 新規登録処理
            - action = 'login'    → ログイン処理
            - action = 'logout'   → ログアウト処理
        */
        $action = $_GET['action'] ?? 'login';
        //  -----------------------------
        //  新規登録処理
       
        // /*
        // // 1. POST送信か判定
        // //    - POSTならフォームデータを取得
        // //    - GETなら register_view.php を include
        if($action == 'register'){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                $password_confirm = $_POST['password_confirm'];
                
                $error = [];

                //--------ユーザ名バリデーション
                //--------------------------
                if($username === ''){
                    $error[] = 'ユーザ名を入力してください'; 
                }elseif(mb_strlen($username) < 5 || mb_strlen($username) > 20){
                    $error[] = '5文字以上、20文字以下で入力してください';
                }elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
                    $errors['username'] = 'ユーザー名に使用できない文字が含まれています';
                }else {
                     // 重複チェック
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
                    $stmt->execute([$username]);
                    if ($stmt->fetchColumn() > 0) {
                        $errors['username'] = '既に使用されているユーザー名です';
                    }                                   
                }

                //--------emailバリデーション
                //--------------------------
                if($email === ''){
                    $error[] = 'ユーザ名を入力してください';
                }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error[] = '正しいメール形式で入力してください';
                }else {
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                    $stmt -> execute([$email]);
                    if($stmt ->fetchColumn > 0){
                        $error[] = '入力されたメールアドレスはすでに登録されています';
                    }
                }
                
                //----------パスワードバリデーション
                //--------------------------------
                if($email === ''){
                    $error[] = 'パスワードを入力してください';
                }elseif (strlen($password) < 8 || strlen($password) > 20){
                    $error[] = '8文字以上、20文字以下で入力してください';
                }elseif(!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
                    $errors[] = 'パスワードは英大文字・英小文字・数字を含めてください';
                }

                if($password !== $password_confirm){
                    $error[] = 'パスワードが一致しません'
                }

                if(empty($error)){
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $this->model->createUser($username, $email, $hashedPassword);

                    // 登録成功 → ログインページにリダイレクト
                    header('Location: login.php');
                    exit;
                }else {
                    // エラーがある場合 → フォームに戻してエラー表示
                    include __DIR__ . '/../views/register_view.php';
                    exit;
                }
            }else {
                // GETの場合 → フォーム表示
                include __DIR__ . '/../views/register_view.php';
                exit;
                
            }
        }

        // // -----------------------------
        // // ログイン処理
        // // -----------------------------
        
        if($action = 'login'){
           // 1. フォームから送信された値を取得
            $login_input = trim($_POST['login_input']); // メール or ユーザー名
            $password = $_POST['password'];

            // 2. 入力がメールかユーザ名かを判定
            if (filter_var($login_input, FILTER_VALIDATE_EMAIL)) {
                // メール形式の場合
                $user = $this->model->getUserByEmail($login_input);
            } else {
                // メール形式でない場合はユーザー名として検索
                $user = $this->model->getUserByUsername($login_input);
            }

            // 3. ユーザー存在チェックとパスワード照合
            if ($user && password_verify($password, $user['password'])) {
                // ログイン成功 → セッションにユーザー情報を保存
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email']
                ];
                header('Location: index.php');
                exit;
            } else {
                // ログイン失敗 → エラーメッセージ
                $error = 'ユーザー名またはメールアドレス、もしくはパスワードが違います';
                include __DIR__ . '/../views/login_view.php';
                exit;
            }
        }

        
    }
}
?>
