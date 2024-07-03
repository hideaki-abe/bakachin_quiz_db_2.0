<?php
require 'db.php'; // データベース接続
session_start();

// ログイン処理
if ($_POST['action'] == 'login' && !empty($_POST['email']) && !empty($_POST['password'])) {
    // ユーザー情報をデータベースから取得
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();

    // パスワードの検証
    if ($user && password_verify($_POST['password'], $user['password'])) {
        // ログイン成功時、セッションにユーザー情報を保存
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        echo "<script>window.location = 'quiz.php';</script>";
    } else {
        echo "ログイン失敗：無効なユーザー名またはパスワード。";
    }
}