<?php 
    $dsn = 'mysql:host=localhost;dbname=xb513874_n9opa';
    $login_user = 'xb513874_n6viv'; 
    $password = '851d112dd0';   
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work37</title>
</head>
    <body>
        <?php 
                // データベース接続
                $db = new PDO($dsn, $login_user, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        ?>
    </body>
</html>