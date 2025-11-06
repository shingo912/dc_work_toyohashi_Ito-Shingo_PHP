<?php
require_once 'work39_model.php';

// ==============================
// 公開ページビュー
// ==============================
function renderPublicPage($images) {
?>
    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>work39 - 公開ページ</title>
        <style>
            body { font-family: sans-serif; }
            .delete { background-color: #808080; opacity: 0.6; }
            button { margin: 10px 0; padding: 5px 10px; border: none; border-radius: 6px; cursor: pointer; background-color: #007BFF; color: white; }
            div[style*="display:flex"] > div { transition: transform 0.2s; }
            div[style*="display:flex"] > div:hover { transform: scale(1.05); }
        </style>
    </head>
    <body>

    <a href="work39_gallery.php">
        <button type="button">画像投稿ページへ</button>
    </a>

    <?php if (empty($images)): ?>
        <p>公開中の画像はありません。</p>
    <?php else: ?>
        <h2>画像一覧</h2>
        <div style="display:flex; flex-wrap:wrap; gap:15px;">
            <?php foreach ($images as $img): ?>
                <?php $filePath = UPLOAD_DIR . htmlspecialchars($img['file_name']); ?>
                <div style="padding:10px; text-align:center; border:1px solid #ccc; border-radius:8px;">
                    <img src="<?= $filePath ?>" alt="" width="150"><br>
                    <?= htmlspecialchars($img['title']) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    </body>
    </html>
<?php
}

// ==============================
// 管理ページビュー
// ==============================
function renderGalleryPage($images, $message) {
?>
    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>work39_gallery - 管理ページ</title>
        <style>
            body { font-family: sans-serif; }
            .delete { background-color: #808080; opacity: 0.6; }
            .btn-toggle { background-color: #007BFF; color: white; }
            button { margin-top: 5px; padding: 5px 10px; border: none; border-radius: 6px; cursor: pointer; }
            div[style*="display:flex"] > div { transition: transform 0.2s; }
            div[style*="display:flex"] > div:hover { transform: scale(1.05); }
        </style>
    </head>
    <body>

    <!-- 投稿フォーム -->
    <form method="post" enctype="multipart/form-data">
        <label>画像タイトル：<input type="text" name="title"></label><br><br>
        <label>画像：<input type="file" name="image" accept="image/*"></label><br><br>
        <input type="submit" value="画像投稿">
    </form>

    <!-- 公開ページへのリンク -->
    <a href="work39.php">
        <button type="button">公開画像一覧ページへ</button>
    </a>

    <!-- メッセージ表示 -->
    <?php if ($message !== ''): ?>
        <p style="color:<?= (strpos($message, 'エラー') !== false) ? 'red' : 'green'; ?>;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <!-- 画像一覧 -->
    <h2>画像一覧</h2>
    <div style="display:flex; flex-wrap:wrap; gap:15px;">
        <?php foreach ($images as $img): ?>
            <?php 
                $filePath = UPLOAD_DIR . htmlspecialchars($img['file_name']); 
                $divClass = ($img['public_flg'] == 1) ? "" : " class='delete'";
            ?>
            <div<?= $divClass ?> style="padding:10px; text-align:center; border:1px solid #ccc; border-radius:8px;">
                <?php if (file_exists($filePath)): ?>
                    <img src="<?= $filePath ?>" alt="" width="150" style="display:block; margin:auto;"><br>
                <?php else: ?>
                    <div style="color:gray;">ファイルが見つかりません: <?= htmlspecialchars($img['file_name']) ?></div>
                <?php endif; ?>

                <?= htmlspecialchars($img['title']) ?><br>

                <form method="post" style="margin-top:5px;">
                    <input type="hidden" name="toggle_id" value="<?= htmlspecialchars($img['image_id']) ?>">
                    <input type="hidden" name="current_flg" value="<?= htmlspecialchars($img['public_flg']) ?>">
                    <button type="submit" class="btn-toggle">
                        <?= ($img['public_flg'] == 1) ? "非表示にする" : "表示する" ?>
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    </body>
    </html>
<?php
}
?>