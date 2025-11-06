<?php
require_once 'model.php';

// ==============================
// トップページビュー
// ==============================
function TOP_Page($user,) {
?>
    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>EC SITE login</title>
        <style>
            body { font-family: sans-serif; }
            .delete { background-color: #808080; opacity: 0.6; }
            button { margin: 10px 0; padding: 5px 10px; border: none; border-radius: 6px; cursor: pointer; background-color: #007BFF; color: white; }
            div[style*="display:flex"] > div { transition: transform 0.2s; }
            div[style*="display:flex"] > div:hover { transform: scale(1.05); }
        </style>
    </head>
    <body>

      <form action="home.php" method="post">
          <label for="user_id">ユーザーID：</label>
          <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>"><br><br>

          <label for="password">パスワード：</label>
          <input type="password" id="password" name="password"><br><br>
      </form>

      <a href="work39_gallery.php">
          <button type="button">新規登録ページへ</button>
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


