<?php
$height = 17; 		//変数$heightを定義し、値を代入
const $weight= 6;	//定数WEIGHTを定義し、値を代入
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work02</title>
</head>
<body>
<?php
    $height;		//変数$heightを定義
    $height = 170; 		//変数$heightに値を代入
    $weight = 60;		//変数$weightを定義し、値を代入
    
    print '変更前：身長'.$height.'cm 体重'.$weight.'kg '; 
    
    $height = 155; 		//変数$heightに値を代入
    $weight = 50;		//変数$weightに値を代入
    
    print '変更後：身長'.$height.'cm 体重'.$weight.'kg ';
?>

</body>
</html>

