<?php
require_once 'work39_model.php';
require_once 'work39_view.php';

// Controllerの責務：処理の分岐・データ取得のみ
$images = getImages(true);

// Viewを呼び出してレンダリング
renderPublicPage($images);