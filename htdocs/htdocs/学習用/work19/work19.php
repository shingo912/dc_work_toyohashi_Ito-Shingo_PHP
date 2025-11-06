<?php
// 保存用ファイル
$filename = 'keijiban.txt';

// エラーメッセージ初期化
$error = '';

// フォーム送信時の処理
// フォームからPOSTでリクエストが来ているのか、それてともURLを直接指定して表示されているのかで判別
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $error = '入力情報が不足しています';
    } else {
        // 保存する形式: タイトル：内容
        $line = $title . '：' . $content;

        // 既存データを読み込み
        $existing = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

        // 新しい投稿を先頭に追加
        array_unshift($existing, $line);

        // 改行区切りで保存（余分な空行を作らない）
        file_put_contents($filename, implode(PHP_EOL, $existing));

        // 二重送信防止のためリダイレクト
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// ファイルから既存データを取得（空行はスキップ）
$posts = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>work19</title>
</head>
<body>
<h2>簡易掲示板</h2>

<?php if ($error): ?>
<p style="color:red;"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
<?php endif; ?>

<form method="post">
    <label>タイトル：<input type="text" name="title"></label><br><br>
    <label>書き込み内容：<input type="text" name="content"></label><br><br>
    <input type="submit" value="送信">
</form>

<h3>投稿一覧</h3>
<?php if ($posts): ?>
    <ul>
    <?php foreach ($posts as $post): ?>
        <li><?php echo htmlspecialchars($post, ENT_QUOTES); ?></li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>まだ投稿はありません。</p>
<?php endif; ?>

</body>
</html>

