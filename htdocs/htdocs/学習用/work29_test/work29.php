<?php 
    $host = 'localhost'; 
    $login_user = 'xb513874_n6viv'; 
    $password = '851d112dd0';   
    $database = 'xb513874_n9opa';   
    $error_msg = [];
    $insert;
    $delete;
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work29</title>
</head>
<body>
    <?php 
        // データベースへ接続
        $db = new mysqli($host, $login_user, $password, $database);
        if ($db->connect_error) {
            echo $db->connect_error;
            exit();
        } else {
            $db->set_charset("utf8");
        }

        // フォームが送信されたとき
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db->begin_transaction(); // トランザクション開始

            if (isset($_POST['insert'])) {
                // INSERT文の実行
                $insert = "INSERT INTO product (
                            product_id,
                            product_code,
                            product_name,
                            price,
                            category_id
                        ) VALUES (
                            21,
                            1021,
                            'エシャロット',
                            200,
                            1
                        );";
                if ($db->query($insert)) {
                    echo "データを挿入しました。<br>";
                } else {
                    $error_msg[] = 'INSERT実行エラー [実行SQL] ' . $insert;
                }

            } elseif (isset($_POST['delete'])) {
                    $delete = "DELETE FROM product WHERE product_id = 21;";
                    if ($db->query($delete)) {
                        echo "データを削除しました。<br>";
                        // あえてエラーを発生させる
                        $error_msg[] = "テストのためロールバックします";
                    } else {
                        $error_msg[] = 'DELETE実行エラー [実行SQL] ' . $delete;
                    }
                }

                // トランザクション処理
                if (count($error_msg) == 0) {
                    $db->commit(); // 正常ならコミット
                    echo "コミットしました。";
                } else {
                    echo '更新が失敗しました。ロールバックします。'; 
                    $db->rollback(); // エラー発生でロールバック
                }
        }
        $db->close(); // 接続を閉じる
    ?>
    <form method="post">
        <input type="submit" name="insert" value="挿入">
        <input type="submit" name="delete" value="削除">
    </form>
</body>
</html>