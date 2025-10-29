<?php 
    define('DSN', 'mysql:host=localhost;dbname=xb513874_n9opa;charset=utf8');
    define('DB_USER', 'xb513874_n6viv');
    define('DB_PASS', '851d112dd0');
 ?>
<?php
    // データベース接続
    function connectDB() {
        try {
                $pdo = new PDO(DSN, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return $pdo;
        } catch (PDOException $e) {
            exit("データベース接続エラー: " . htmlspecialchars($e->getMessage()));
        }
    }

    session_start(); // セッション開始（ログイン管理用）

    // POSTデータを取得
    $user_id = $_POST['user_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $cookie_confirmation = $_POST['cookie_confirmation'] ?? '';

    $pdo = connectDB();
    $sql = "SELECT * FROM user_table WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $result = $stmt->fetch();
    //Cookieの保存期間
    define('EXPIRATION_PERIOD', 30);
    $cookie_expiration = time() + EXPIRATION_PERIOD * 60 * 24 * 365;
    if ($result && $result['password'] === $password) {
        //POSTされたフォームの値を変数に格納する
        if (isset($_POST['cookie_confirmation']) === TRUE) {
            $cookie_confirmation = $_POST['cookie_confirmation'];
        } else {
            $cookie_confirmation = '';
        }
        if (isset($_POST['user_id']) === TRUE) {
            $user_id = $_POST['user_id'];
        } else {
            $user_id = '';
        }

        // ログインIDの入力省略にチェックがされている場合はCookieを保存
        if ($cookie_confirmation === 'checked') {
            setcookie('cookie_confirmation', $cookie_confirmation, $cookie_expiration);
            setcookie('user_id', $user_id, $cookie_expiration);
            setcookie('password', $password, $cookie_expiration);
        } else {
            // チェックされていない場合はCookieを削除する
            setcookie('cookie_confirmation', '', time() - 30);
            setcookie('user_id', '', time() - 30);
            setcookie('password', '', time() - 30);
        }

        echo "<p>ログイン成功！ようこそ、" . htmlspecialchars($result['user_name']) . "さん。</p>";
        echo "<a href='work37.php'>ログアウトする</a>";
    }else{
        echo "<p style='color:red;'>ユーザーIDまたはパスワードが違います。</p>";
        echo "<a href='work37.php'>戻る</a>";
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>work37</title>
</head>
<body>
</body>
</html>