<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work14</title>
</head>
<body>
    <?php 
        $num = array();
        for ($i = 0; $i <= 4; $i++){
            array_push($num, rand(1,100));
        } 
        for ($i = 0; $i <= 4; $i++){
            if(($num[$i]) % 2 == 0 ):
                ?>
                <p><?php echo $num[$i] ?>(偶数)</p>
            <?php else: ?>
                <p><?php echo $num[$i] ?>(奇数)</p>
            <?php endif;
        }
    ?>
</body>
</html>

