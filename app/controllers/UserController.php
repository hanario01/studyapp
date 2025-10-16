<?php
require_once __DIR__ . '/../common/auth.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $model;

    public function __construct($pdo) {
        $this->model = new UserModel($pdo);
    }

    // リクエスト処理
    public function handleRequest() {
        $action = $_POST['action'] ?? $_GET['action'] ?? '';
        // var_dump($action);
        // exit;

        switch ($action) {
            case 'register':
                $this->register();
                break;
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
        }
    }

    // -----------------------
    // 新規登録処理
    // -----------------------
    private function register() {
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            // ユーザ名バリデーション
            if ($username === '') {
                $error[] = 'ユーザ名を入力してください';
            } elseif (mb_strlen($username) < 5 || mb_strlen($username) > 20) {
                $error[] = 'ユーザ名は5文字以上、20文字以下で入力してください';
            } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
                $error[] = 'ユーザー名に使用できない文字が含まれています';
            } elseif ($this->model->isUsernameExists($username)) {
                $error[] = '既に使用されているユーザー名です';
            }

            // メールバリデーション
            if ($email === '') {
                $error[] = 'メールアドレスを入力してください';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error[] = '正しいメール形式で入力してください';
            } elseif ($this->model->isEmailExists($email)) {
                $error[] = '既に使用されているメールアドレスです';
            }

            // パスワードバリデーション
            if ($password === '') {
                $error[] = 'パスワードを入力してください';
            } elseif (strlen($password) < 8 || strlen($password) > 20) {
                $error[] = 'パスワードは8文字以上、20文字以下で入力してください';
            } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
                $error[] = 'パスワードは英大文字・英小文字・数字を含めてください';
            }

            if ($password !== $password_confirm) {
                $error[] = 'パスワードが一致しません';
            }

            if (empty($error)) {
                //パスワードハッシュ化
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                //  セッションに保存してログイン状態にする
                $newUser = $this->model->createUser($username, $email, $hashed);
                session_regenerate_id(true);
                $_SESSION['user'] = $newUser;
                header('Location: http://localhost/studystep/studyapp-1/app/views/register_success.php');
                exit;
            } else {
                $error[] = '登録に失敗しました';
            }
            
        }

        require __DIR__ . '/../views/register_view.php';
    }

    // -----------------------
    // ログイン処理
    // -----------------------
    private function login() {
        $error = [];

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
                $_SESSION['user'] = $user;
                header('Location: http://localhost/studystep/studyapp-1/app/views/mypage_view.php');
                exit;
            } else {
                $error[] = 'ユーザー名またはパスワードが間違っています';
            }
        }

        require __DIR__ . '/../views/login_view.php';
    }

    // -----------------------
    // ログアウト
    // -----------------------
    private function logout() {
        session_destroy();
        header('Location: http://localhost/studystep/studyapp-1/public/index.php');
        exit;
    }

    // -----------------------
    // マイページ表示
    // -----------------------
    public function showMypage() {
        if (empty($_SESSION['user'])) {
            header('Location: http://localhost/studystep/studyapp-1/public/login.php');
            exit;
        }
        $user = $_SESSION['user'];
        require __DIR__ . '/../views/mypage_view.php';
    }

    // -----------------------
    // プロフィール編集
    // -----------------------
    public function editProfile() {
        if (empty($_SESSION['user'])) {
            header('Location: http://localhost/studystep/studyapp-1/public/login.php');
            exit;
        }

        $user = $_SESSION['user'];
        $message = '';
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $icon = $_FILES['icon']['name'] ?? '';

            if ($username === '' || $email === '') {
                $error[] = 'ユーザー名とメールアドレスを入力してください';
            } else {
                // アイコンアップロードは別メソッドで安全に処理
                $iconPath = '';
                if (!empty($_FILES['icon']['tmp_name'])) {
                    $iconPath = $this->uploadIcon($_FILES['icon'], $user['id']);
                    $_SESSION['user']['icon'] = $iconPath; // ← セッションも更新
                }

                $this->model->updateUser($user['id'], $username, $email, $iconPath);
                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['email'] = $email;
                $message = 'プロフィールを更新しました';
            }
        }
        $user = $_SESSION['user']; // 再取得して最新をビューに渡す
        require __DIR__ . '/../views/profile_edit_view.php';
    }

    // -----------------------
    // アイコンアップロード
    // -----------------------
    private function uploadIcon($file, $userId) {
        $uploadDir = __DIR__ . '/../../public/uploads/icons/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'user_' . $userId . '.' . $ext;
        $target = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            return '/studystep/studyapp-1/public/uploads/icons/' . $filename;
        }
        return '';
    }
}
