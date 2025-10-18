<?php
    require_once 'functions.php';

    // ========== 投稿処理・切り替え処理 ==========
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['toggle_id'])) {
            // 公開フラグ切り替え
            $message = togglePublicFlag((int)$_POST['toggle_id'], (int)$_POST['current_flg']);
        } else {
            // 画像投稿
            $message = insertImage($_POST['title'] ?? '', $_FILES['image'] ?? []);
        }
    }

    // ========== 画像一覧取得 ==========
    $images = getImages();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>work36_gallery - 管理ページ</title>
        <style>
            body { font-family: sans-serif; }
            .delete { background-color: #808080; opacity: 0.6; }
            button { margin-top: 5px; padding: 5px 10px; border: none; border-radius: 6px; cursor: pointer; }
            .btn-toggle { background-color: #007BFF; color: white; }
            div[style*="display:flex"] > div { transition: transform 0.2s; }
            div[style*="display:flex"] > div:hover { transform: scale(1.05); }
        </style>
    </head>
<body>

    <!-- アップロードフォーム -->
    <form method="post" enctype="multipart/form-data">
        <label>画像タイトル：<input type="text" name="title"></label><br><br>
        <label>画像：<input type="file" name="image" accept="image/*"></label><br><br>
        <input type="submit" value="画像投稿">
    </form>

    <!-- 一覧ページへのリンク -->
    <a href="work36.php">
        <button type="button">公開画像一覧ページへ</button>
    </a>

    <?php
        displayMessage($message, (strpos($message, 'エラー') !== false) ? 'red' : 'green');
        displayImages($images, true); // トグルボタンあり
    ?>
</body>
</html>