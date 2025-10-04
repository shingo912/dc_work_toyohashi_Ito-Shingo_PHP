<?php
// 保存用ファイル（投稿データを保存するテキストファイル名）
$filename = 'keijiban.txt';

// アップロード先ディレクトリ
$uploadDir = 'img/';

// エラーメッセージ初期化
$error = '';
$success = ''; // 成功メッセージ用

// ============================
// フォーム送信時の処理
// ============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    // $_SERVER['REQUEST_METHOD'] → 現在のリクエストが POST かどうか確認（フォーム送信チェック）

    // trim() → 文字列の前後の空白や改行を削除
    // $_POST['title'] ?? '' → title が未定義なら空文字を代入（null合体演算子）
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $imageName = '';

    // 入力チェック
    // === '' → 空文字かどうかチェック
    // !isset($_FILES['image']) → 画像が送信されていない場合
    // $_FILES['image']['error'] !== UPLOAD_ERR_OK → アップロードエラーがある場合
    if ($title === '' || $content === '' || !isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = '入力情報が不足しています';
    } else {
        // $_FILES['image']['tmp_name'] → 一時的に保存されたアップロードファイルの場所
        $tmpName = $_FILES['image']['tmp_name'];

        // basename() → ファイル名部分だけを取り出す（ディレクトリを除去）
        $origName = basename($_FILES['image']['name']);

        // pathinfo( , PATHINFO_EXTENSION) → 拡張子を取得
        // strtolower() → 拡張子を小文字に変換（JPG と jpg を区別しないようにするため）
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

        // in_array() → 配列に特定の値が含まれているか確認
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $allowed, true)) {
            $error = 'アップロードできるのは JPG, PNG, GIF のみです';
        } else {
            // uniqid() → 現在時刻をベースにしたユニークIDを生成
            // uniqid('img_', true) → "img_" で始まる一意の文字列を生成（true でより精密）
            $imageName = uniqid('img_', true) . '.' . $ext;

            // 保存先パスを組み立てる（img/ + ユニークファイル名）
            $destPath = $uploadDir . $imageName;

            // is_dir() → 指定のディレクトリが存在するか確認
            // mkdir() → ディレクトリを作成（0777 権限、true で親ディレクトリもまとめて作成可能）
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // move_uploaded_file() → 一時ファイルを保存先に移動（アップロードファイル専用の安全な関数）
            if (!move_uploaded_file($tmpName, $destPath)) {
                $error = '画像のアップロードに失敗しました';
            }
        }

        // エラーがなければ保存
        if ($error === '') {
            // 投稿データを 文字列 "タイトル：内容：画像ファイル名" の形式にする
            $line = $title . '：' . $content . '：' . $imageName;

            // file_exists() → ファイルが存在するか確認
            // file() → ファイルを1行ごとの配列に読み込む
            // FILE_IGNORE_NEW_LINES → 各行の改行を取り除く
            // FILE_SKIP_EMPTY_LINES → 空行を読み飛ばす
            $existing = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

            // array_unshift() → 配列の先頭に新しい投稿を追加
            array_unshift($existing, $line);

            // implode() → 配列を文字列に結合（区切り文字に改行を指定）
            // file_put_contents() → ファイルに書き込む（第二引数が文字列なら上書き保存）
            file_put_contents($filename, implode(PHP_EOL, $existing));

            // header("Location: ...") → リダイレクト（コメントアウト中）
            // exit; → 処理をここで終了（コメントアウト中）

            $success = 'アップロード成功しました。';
        }
    }
}

// file_exists() → ファイルが存在するか確認
// file() → ファイルを配列として読み込み（既存の投稿データ取得）
$posts = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>work20</title>
</head>
<body>
<h2>簡易掲示板（画像付き）</h2>

<?php if ($error): ?>
<p style="color:red;"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
<?php endif; ?>

<?php if ($success): ?>
<p style="color:green;"><?php echo htmlspecialchars($success, ENT_QUOTES); ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <!-- enctype="multipart/form-data" → ファイルアップロード時に必須 -->
    <label>タイトル：<input type="text" name="title"></label><br><br>
    <label>書き込み内容：<input type="text" name="content"></label><br><br>
    <label>画像アップロード：<input type="file" name="image" accept="image/*"></label><br><br>
    <input type="submit" value="送信">
</form>

<h3>投稿一覧</h3>
<?php if ($posts): ?>
    <ul>
    <?php foreach ($posts as $post): ?>
        <?php
            // explode() → 区切り文字で文字列を分割して配列化
            $parts = explode('：', $post);

            // 配列要素を安全に代入（存在しなければ空文字）
            $ptitle = $parts[0] ?? '';
            $pcontent = $parts[1] ?? '';
            $pimage = $parts[2] ?? '';
        ?>
        <li>
            <!-- htmlspecialchars() → HTMLエスケープ（XSS対策） -->
            <strong><?php echo htmlspecialchars($ptitle, ENT_QUOTES); ?></strong>：
            <?php echo htmlspecialchars($pcontent, ENT_QUOTES); ?>
            <?php if ($pimage): ?>
                <br>
                <img src="img/<?php echo htmlspecialchars($pimage, ENT_QUOTES); ?>" alt="投稿画像" style="max-width:200px;">
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>まだ投稿はありません。</p>
<?php endif; ?>

</body>
</html>