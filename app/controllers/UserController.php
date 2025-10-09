<?php
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../models/User_Model.php';

class UserController {
    private $model;

    public function __construct($pdo) {
        $this->model = new UserModel($pdo);
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'login';
        $errors = [];

        // -----------------------------
        // 新規登録処理
        // -----------------------------
        if ($action === 'register') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                $password_confirm = $_POST['password_confirm'];

                // ユーザ名チェック
                if ($username === '') {
                    $errors[] = 'ユーザ名を入力してください'; 
                } elseif (mb_strlen($username) < 5 || mb_strlen($username) > 20) {
                    $errors[] = '5文字以上、20文字以下で入力してください';
                } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
                    $errors[] = 'ユーザー名に使用できない文字が含まれています';
                } else {
                    $stmt = $this->model->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
                    $stmt->execute([$username]);
                    if ($stmt->fetchColumn() > 0) {
                        $errors[] = '既に使用されているユーザー名です';
                    }
                }

                // メールチェック
                if ($email === '') {
                    $errors[] = 'メールアドレスを入力してください';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = '正しいメール形式で入力してください';
                } else {
                    $stmt = $this->model->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetchColumn() > 0) {
                        $errors[] = '入力されたメールアドレスはすでに登録されています';
                    }
                }

                // パスワードチェック
                if ($password === '') {
                    $errors[] = 'パスワードを入力してください';
                } elseif (strlen($password) < 8 || strlen($password) > 20) {
                    $errors[] = '8文字以上、20文字以下で入力してください';
                } elseif (!preg_match('/[A-Z]/', $password) || 
                          !preg_match('/[a-z]/', $password) || 
                          !preg_match('/[0-9]/', $password)) {
                    $errors[] = 'パスワードは英大文字・英小文字・数字を含めてください';
                }

                // 確認用パスワードチェック
                if ($password !== $password_confirm) {
                    $errors[] = 'パスワードが一致しません';
                }

                if (empty($errors)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $this->model->createUser($username, $email, $hashedPassword);
                    header('Location: ../public/login.php');
                    exit;
                } else {
                    include __DIR__ . '/../views/register_view.php';
                    exit;
                }
            } else {
                include __DIR__ . '/../views/register_view.php';
                exit;
            }
        }

        // -----------------------------
        // ログイン処理
        // -----------------------------
        if ($action === 'login') {
            // ✅ GETアクセス時（フォーム表示だけしたい場合）
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                include __DIR__ . '/../views/login_view.php';
                exit;
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $login_input = trim($_POST['login_input']);
                $password = $_POST['password'];

                if (filter_var($login_input, FILTER_VALIDATE_EMAIL)) {
                    $user = $this->model->getUserByEmail($login_input);
                } else {
                    $user = $this->model->getUserByUsername($login_input);
                }

                if ($user && password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email']
                    ];
                    header('Location: ../public/index.php');
                    exit;
                } else {
                    $error = 'ユーザー名またはメールアドレス、もしくはパスワードが違います';
                    include __DIR__ . '/../views/login_view.php';
                    exit;
                }
            } else {
                include __DIR__ . '/../views/login_view.php';
                exit;
            }
        }

        // -----------------------------
        // ログアウト処理
        // -----------------------------
        if ($action === 'logout') {
            session_destroy();
            header('Location: ../public/index.php');
            exit;
        }
    }
}
?>
