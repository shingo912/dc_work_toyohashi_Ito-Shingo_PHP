<?php 
    $host = 'localhost'; 
    $login_user = 'xb513874_n6viv'; 
    $password = '851d112dd0';   
    $database = 'xb513874_n9opa';   
    $uploadDir = 'images/';

    $error_msg = [];
    $images = [];
    $error = '';

    $sql;
    $result;
    $img;
    $insert;
    $date;
    $imageName = '';

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work30_gallery</title>
</head>
<body>
    <style>
        .delete {
            background-color: #808080;
            opacity: 0.6;
        }

        /* オプション：画像をカードのようにきれいに並べたい場合 */
        body {
            font-family: sans-serif;
        }
        div[style*="display:flex"] > div {
            transition: transform 0.2s;
        }
        div[style*="display:flex"] > div:hover {
            transform: scale(1.05);
        }
    </style>
    <form method="post" enctype="multipart/form-data">
        <!-- enctype="multipart/form-data" → ファイルアップロード時に必須 -->
        <label>画像タイトル：<input type="text" name="title"></label><br><br>
        <label>画像：<input type="file" name="image" accept="image/*"></label><br><br>
        <input type="submit" value="画像投稿">
    </form>
    <?php 
        // --- データベース接続 ---
        $db = new mysqli($host, $login_user, $password, $database);
        if ($db->connect_error) {
            echo "接続エラー：" . $db->connect_error;
            exit();
        }
        $db->set_charset("utf8");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $title = trim($_POST['title'] ?? '');
            if ($title === ''  || !isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $error = '入力情報が不足しています';
            } else {
                $tmpName = $_FILES['image']['tmp_name'];
                $origName = basename($_FILES['image']['name']);
                $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                $allowed = ['jpeg', 'png'];
            }
            if (!in_array($ext, $allowed, true)) {
                $error = 'アップロードできるのは JPEG, PNG のみです';
            } else {
                $imageName = uniqid('img_', true) . '.' . $ext;
                $destPath = $uploadDir . $imageName;
            }

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (!move_uploaded_file($tmpName, $destPath)) {
                $error = '画像のアップロードに失敗しました';
            }
            // --- トランザクション開始 ---
            $db->begin_transaction();

            $date = date("Y-m-d");
            $insert = "INSERT INTO image (
                            title,
                            file_name,
                            public_flg,
                            create_date,
                            update_date
                        ) VALUES (
                            '$title',
                            '$imageName',
                            '1',
                            '$date',
                            '$date'
                        )";


            if ($db->query($insert)) {
                $db->commit(); // 正常終了
            } else {
                $error_msg[] = 'SELECT実行エラー: ' . $db->error;
                $db->rollback();
            }

            $db->close();
        }

        // --- トランザクション開始 ---
        $db->begin_transaction();

        $sql = "SELECT title , file_name, public_flg FROM image;";
        $result = $db->query($sql);

        if ($result) {
            // --- データを配列に格納 ---
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
            $result->free();

            $db->commit(); // 正常終了
        } else {
            $error_msg[] = 'SELECT実行エラー: ' . $db->error;
            $db->rollback();
        }

        $db->close();

        // --- 結果の表示 ---
        if (!empty($error_msg)) {
            echo '<p style="color:red;">エラーが発生しました：' . htmlspecialchars(implode(', ', $error_msg)) . '</p>';
        } else {
            echo "<h2>画像一覧</h2>";
            echo "<div style='display:flex; flex-wrap:wrap; gap:15px;'>";

            foreach ($images as $img) {
                $file_path = "images/" . htmlspecialchars($img['file_name']); // 画像フォルダのパス
                if (!file_exists($file_path)) {
                    echo "<div style='color:gray;'>ファイルが見つかりません: " . htmlspecialchars($img['file_name']) . "</div>";
                    continue;
                }
                // 公開フラグに応じてクラスを切り替え
                $divClass = ($img['public_flg'] == 1) ? "" : " class='delete'";

                echo "<div{$divClass} style='padding:10px; text-align:center; border:1px solid #ccc; border-radius:8px;'>";
                echo "<img src='{$file_path}' alt='' width='150' style='display:block; margin:auto;'><br>";
                echo htmlspecialchars($img['title']);
                echo "</div>";
            }

            echo "</div>";
        }
    ?>
</body>
</html>