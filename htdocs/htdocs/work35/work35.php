
<!DOCTYPE  html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>work35</title>
    </head>
    <body>
        <?php 
            $function_num = multiplication_num(rand(1,10));
            echo $function_num;
            function multiplication_num ($num) {
                if (($num % 2) == 0):
                    return $num * 10;
                else:
                    return $num * 100;
                endif;    
            }
        ?>
    </body>
</html>