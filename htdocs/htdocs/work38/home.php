<?php
define('DSN', 'mysql:host=localhost;dbname=xb513874_n9opa;charset=utf8');
define('DB_USER', 'xb513874_n6viv');
define('DB_PASS', '851d112dd0');
session_start();

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

// ✅ POSTでログイン試行時
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $cookie_confirmation = $_POST['cookie_confirmation'] ?? '';

    $pdo = connectDB();
    $sql = "SELECT * FROM user_table WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $result = $stmt->fetch();

    if ($result && $result['password'] === $password) {
        // ✅ セッションにログイン情報を保存
        $_SESSION['login_user'] = [
            'id' => $result['user_id'],
            'name' => $result['user_name']
        ];

        // ✅ Cookie設定（ID保存のみ）
        $cookie_expiration = time() + 60 * 60 * 24 * 30; // 30日
        if ($cookie_confirmation === 'checked') {
            setcookie('cookie_confirmation', 'checked', $cookie_expiration);
            setcookie('user_id', $user_id, $cookie_expiration);
        } else {
            setcookie('cookie_confirmation', '', time() - 3600);
            setcookie('user_id', '', time() - 3600);
        }

        // ✅ POST再送防止
        header('Location: home.php');
        exit();
    } else {
        echo "<p style='color:red;'>ユーザーIDまたはパスワードが違います。</p>";
        echo "<a href='work38.php'>戻る</a>";
        exit();
    }
}

// ✅ セッションにログイン情報がなければ、work38.phpへリダイレクト
if (!isset($_SESSION['login_user'])) {
    header('Location: work38.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム</title>
</head>
<body>
    <p><?php echo htmlspecialchars($_SESSION['login_user']['name']); ?>さん：ログイン中です。</p>
    <a href="work38.php?logout=1">ログアウトする</a>
</body>
</html>