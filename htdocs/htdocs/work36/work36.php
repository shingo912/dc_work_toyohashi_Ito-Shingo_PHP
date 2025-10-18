<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>work36</title>
        <style>
            body { font-family: sans-serif; }
            .delete { background-color: #808080; opacity: 0.6; }
            div[style*="display:flex"] > div { transition: transform 0.2s; }
            div[style*="display:flex"] > div:hover { transform: scale(1.05); }
            button { margin: 10px 0; padding: 5px 10px; border: none; border-radius: 6px; cursor: pointer; background-color: #007BFF; color: white; }
        </style>
    </head>
    <body>

        <!-- 投稿ページへのリンク -->
        <a href="work36_gallery.php">
            <button type="button">画像投稿ページへ</button>
        </a>

        <?php
            $images = getImages(true); // 公開中の画像のみ取得
            if (empty($images)) {
                echo "<p>公開中の画像はありません。</p>";
            } else {
                displayImages($images);
            }
        ?>

    </body>
</html>