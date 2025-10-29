<?php
session_start();

// ✅ ログアウト処理（GETでlogout=1が来たらセッション破棄）
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: work38.php');
    exit();
}

// ✅ すでにログイン中なら home.php にリダイレクト
if (isset($_SESSION['login_user'])) {
    header('Location: home.php');
    exit();
}

// ✅ Cookieに保存された情報を利用
$cookie_confirmation = isset($_COOKIE['cookie_confirmation']) ? "checked" : "";
$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : '';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログインページ</title>
</head>
<body>
    <h2>ログインフォーム</h2>
    <form action="home.php" method="post">
        <label for="user_id">ユーザーID：</label>
        <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>"><br><br>

        <label for="password">パスワード：</label>
        <input type="password" id="password" name="password"><br><br>

        <input type="checkbox" name="cookie_confirmation" value="checked" <?php echo $cookie_confirmation; ?>>
        次回からログインIDを省略<br><br>

        <input type="submit" value="ログイン">
    </form>
</body>
</html>