<?php 
    $dsn = 'mysql:host=localhost;dbname=xb513874_n9opa';
    $login_user = 'xb513874_n6viv'; 
    $password = '851d112dd0';   
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work33</title>
</head>
    <body>
        <?php 
            try {
                // データベース接続
                $db = new PDO($dsn, $login_user, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $db->beginTransaction(); // トランザクション開始

                // クエリ準備
                $sql = "SELECT product_name FROM product WHERE product_id = :id";
                $stmt = $db->prepare($sql);

                // 値をバインド PDO::PARAM_INT : 整数型（integer）としてバインドする 
                $stmt->bindValue(':id', 1, PDO::PARAM_INT);

                // 実行
                $stmt->execute();

                // 結果を取得
                $row = $stmt->fetch(PDO::FETCH_ASSOC); // 1件だけ取得

                if ($row) {
                    echo "商品名：" . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . "<br>";
                } else {
                    echo "該当データがありません。";
                }

                $db->commit(); // コミット
            } catch (PDOException $e) {
                echo "エラー発生：" . $e->getMessage();
                $db->rollBack();
            }
        ?>
    </body>
</html>