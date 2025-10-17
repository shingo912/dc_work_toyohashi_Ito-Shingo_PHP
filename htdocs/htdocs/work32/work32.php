<?php 
    $dsn = 'mysql:host=localhost;dbname=xb513874_n9opa';
    $login_user = 'xb513874_n6viv'; 
    $password = '851d112dd0';    
 ?>
<!DOCTYPE  html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>work32</title>
    </head>
    <body>
        <?php 
        try{
            // データベースへ接続
            $db=new PDO($dsn,$login_user,$password);
            //PDOのエラー時にPDOExceptionが発生するように設定
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $db->beginTransaction();	// トランザクション開始

            $sql = "UPDATE product SET price = 170 WHERE product_id = 1";
            $result = $db->query($sql);
            echo $result->rowCount() . '件更新しました。<br>';

            // ここでわざと例外を投げる
            throw new Exception('強制エラー発生！');

            $db->commit(); // ここには到達しない
            } catch (Exception $e) {
            echo "エラー発生：" . $e->getMessage() . "<br>";
            $db->rollBack();
        }
        ?>
    </body>
</html>