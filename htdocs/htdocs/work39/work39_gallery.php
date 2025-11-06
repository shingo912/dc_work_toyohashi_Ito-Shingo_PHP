<?php
require_once 'work39_model.php';
require_once 'work39_view.php';

// ===== コントローラ処理 =====
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle_id'])) {
        // 公開・非公開の切替
        $message = togglePublicFlag((int)$_POST['toggle_id'], (int)$_POST['current_flg']);
    } else {
        // 新規投稿
        $message = insertImage($_POST['title'] ?? '', $_FILES['image'] ?? []);
    }
}

// 全件取得
$images = getImages();

// ===== ビューに描画を任せる =====
renderGalleryPage($images, $message);