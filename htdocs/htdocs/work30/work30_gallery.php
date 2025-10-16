<?php 
    // --- DB接続情報 ---
    $host = 'localhost'; 
    $login_user = 'xb513874_n6viv'; 
    $password = '851d112dd0';   
    $database = 'xb513874_n9opa';   
    $uploadDir = 'images/';

    // --- 変数初期化 ---
    $error_msg = [];
    $images = [];
    $error = '';
    $imageName = '';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work30_gallery</title>
    <style>
        .delete {
            background-color: #808080;
            opacity: 0.6;
        }
        body {
            font-family: sans-serif;
        }
        div[style*="display:flex"] > div {
            transition: transform 0.2s;
        }
        div[style*="display:flex"] > div:hover {
            transform: scale(1.05);
        }
        button {
            margin-top: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-toggle {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <!-- 画像投稿フォーム -->
    <form method="post" enctype="multipart/form-data">
        <label>画像タイトル：<input type="text" name="title"></label><br><br>
        <label>画像：<input type="file" name="image" accept="image/*"></label><br><br>
        <input type="submit" value="画像投稿">
    </form>

    <?php 
        // --- 外部リンクボタン ---
        echo "<a href='https://portfolio02.dc-itex.com/toyohashi/0006/work30/work30.php' target='_blank'>";
        echo "<button type='button'>画像一覧ページへ</button>";
        echo "</a>";
        // --- DB接続 ---
        $db = new mysqli($host, $login_user, $password, $database);
        if ($db->connect_error) {
            echo "接続エラー：" . htmlspecialchars($db->connect_error);
            exit();
        }
        $db->set_charset("utf8");

        // --- 公開/非公開切り替え処理 ---
        if (isset($_POST['toggle_id'])) {
            $toggle_id = (int)$_POST['toggle_id'];
            $current_flg = (int)$_POST['current_flg'];
            $new_flg = ($current_flg === 1) ? 0 : 1; // 反転

            $update = "UPDATE image SET public_flg = $new_flg WHERE image_id = $toggle_id";
            if ($db->query($update)) {
                echo "<p style='color:green;'>表示状態を更新しました。</p>";
            } else {
                $error_msg[] = 'UPDATE実行エラー: ' . $db->error;
            }
        }

        // --- 画像投稿処理 ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['toggle_id'])) { 
            $title = trim($_POST['title'] ?? '');
            $ext = ''; // 初期化しておく

            if ($title === '' || !isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $error = '入力情報が不足しています';
            } else {
                $tmpName = $_FILES['image']['tmp_name'];
                $origName = basename($_FILES['image']['name']);
                $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                $allowed = ['jpeg', 'jpg', 'png'];

                if (!in_array($ext, $allowed, true)) {
                    $error = 'アップロードできるのは JPEG, PNG のみです';
                } else {
                    $imageName = uniqid('img_', true) . '.' . $ext;
                    $destPath = $uploadDir . $imageName;

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    if (!move_uploaded_file($tmpName, $destPath)) {
                        $error = '画像のアップロードに失敗しました';
                    } else {
                        $date = date("Y-m-d");
                        $insert = "
                            INSERT INTO image (
                                title,
                                file_name,
                                public_flg,
                                create_date,
                                update_date
                            ) VALUES (
                                '" . $db->real_escape_string($title) . "',
                                '" . $db->real_escape_string($imageName) . "',
                                '1',
                                '$date',
                                '$date'
                            )
                        ";
                        if ($db->query($insert)) {
                            echo "<p style='color:green;'>画像を登録しました。</p>";
                        } else {
                            $error_msg[] = 'INSERT実行エラー: ' . $db->error;
                        }
                    }
                }
            }

            if ($error !== '') {
                echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
            }
        }

        // --- 一覧取得 ---
        $sql = "SELECT image_id, title, file_name, public_flg FROM image;";
        $result = $db->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
            $result->free();
        } else {
            $error_msg[] = 'SELECT実行エラー: ' . $db->error;
        }

        $db->close();

        // --- 結果の表示 ---
        if (!empty($error_msg)) {
            echo '<p style="color:red;">エラーが発生しました：' . htmlspecialchars(implode(', ', $error_msg)) . '</p>';
        } else {
            echo "<h2>画像一覧</h2>";
            echo "<div style='display:flex; flex-wrap:wrap; gap:15px;'>";

            foreach ($images as $img) {
                $file_path = "images/" . htmlspecialchars($img['file_name']);
                if (!file_exists($file_path)) {
                    echo "<div style='color:gray;'>ファイルが見つかりません: " . htmlspecialchars($img['file_name']) . "</div>";
                    continue;
                }

                $divClass = ($img['public_flg'] == 1) ? "" : " class='delete'";

                echo "<div{$divClass} style='padding:10px; text-align:center; border:1px solid #ccc; border-radius:8px;'>";
                echo "<img src='{$file_path}' alt='' width='150' style='display:block; margin:auto;'><br>";
                echo htmlspecialchars($img['title']) . "<br>";

                // --- 表示/非表示切替ボタン ---
                echo "<form method='post' style='margin-top:5px;'>";
                echo "<input type='hidden' name='toggle_id' value='" . htmlspecialchars($img['image_id']) . "'>";
                echo "<input type='hidden' name='current_flg' value='" . htmlspecialchars($img['public_flg']) . "'>";
                if ($img['public_flg'] == 1) {
                    echo "<button type='submit' class='btn-toggle'>非表示にする</button>";
                } else {
                    echo "<button type='submit' class='btn-toggle'>表示する</button>";
                }
                echo "</form>";

                echo "</div>";
            }

            echo "</div>";
        }
    ?>
</body>
</html>