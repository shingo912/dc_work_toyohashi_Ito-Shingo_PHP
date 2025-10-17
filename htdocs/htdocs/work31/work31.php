<?php 
    $dsn = 'mysql:host=localhost;dbname=xb513874_n9opa';
    $login_user = 'xb513874_n6viv'; 
    $password = '851d112dd0';    
 ?>
<!DOCTYPE  html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>work31</title>
    </head>
    <body>
        <?php 
        try{
            // データベースへ接続
            $db=new PDO($dsn,$login_user,$password);
        } catch (PDOException $e){
            echo $e->getMessage();
            exit();
        }
        //SELECT文の実行
        $sql = "SELECT category_name FROM category WHERE category_id = '1';";
        if ($result = $db->query($sql)) {
            // 連想配列を取得
            while ($row = $result->fetch()) {
                echo $row["category_name"] . "<br>";
            }
        }
        ?>
    </body>
</html>

