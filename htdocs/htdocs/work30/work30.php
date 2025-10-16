<?php 
    $host = 'localhost'; 
    $login_user = 'xb513874_n6viv'; 
    $password = '851d112dd0';   
    $database = 'xb513874_n9opa';   

    $error_msg = [];
    $images = [];

    $sql;
    $result;
    $img;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work30</title>
</head>
<body>
    <?php 
        // --- 外部リンクボタン ---
        echo "<a href='https://portfolio02.dc-itex.com/toyohashi/0006/work30/work30_gallery.php' target='_blank'>";
        echo "<button type='button'>画像投稿ページへ</button>";
        echo "</a>";
        // --- データベース接続 ---
        $db = new mysqli($host, $login_user, $password, $database);
        if ($db->connect_error) {
            echo "接続エラー：" . $db->connect_error;
            exit();
        }
        $db->set_charset("utf8");

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
            echo "<div style='display:flex; flex-wrap:wrap; gap:10px;'>";

            foreach ($images as $img) {
                // 公開フラグが1のものだけ表示
                if ($img['public_flg'] == 1) {
                    $file_path = "images/" . htmlspecialchars($img['file_name']); // 画像フォルダのパス
                    // ファイルが存在するか確認
                    if (file_exists($file_path)) {
                        echo "<div>";
                        echo "<img src='{$file_path}' alt='' width='150'><br>";
                        echo htmlspecialchars($img['title']);
                        echo "</div>";
                    } else {
                        echo "<div style='color:gray;'>ファイルが見つかりません: " . htmlspecialchars($img['file_name']) . "</div>";
                    }
                }
            }

            echo "</div>";
        }
    ?>
</body>
</html>