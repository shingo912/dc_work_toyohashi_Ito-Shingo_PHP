<?php 
    $dsn = 'mysql:host=localhost;dbname=xb513874_n9opa';
    $login_user = 'xb513874_n6viv'; 
    $password = '851d112dd0';   
 ?>
<!DOCTYPE  html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>work34</title>
    </head>
    <body>
        <?php 
        try{
            // データベースへ接続
            $db=new PDO($dsn,$login_user,$password);
            //PDOのエラー時にPDOExceptionが発生するように設定
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $db->beginTransaction();	// トランザクション開始

            //クエリを生成する
            $sql = "SELECT product_name FROM product WHERE product_id = ?";

            //prepareメソッドによるクエリの実行準備をする
            $stmt = $db -> prepare($sql);

            //値をバインドする
            $stmt -> bindValue(1, 1);

            //クエリの実行
            $stmt->execute();
             
            // 結果を取得
                $row = $stmt->fetch(PDO::FETCH_ASSOC); // 1件だけ取得

                if ($row) {
                    echo "商品名：" . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . "<br>";
                } else {
                    echo "該当データがありません。";
                }
        
        } catch (PDOException $e){
            echo $e->getMessage();
            $db->rollBack();  		// エラーが起きたらロールバック
        }
        ?>
    </body>
</html>