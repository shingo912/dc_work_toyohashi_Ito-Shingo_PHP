<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work03</title>
</head>
<body>
<?php
    $int = 1;		
    $string = "1"; 		
    $boolean = true;		
    $NULL = null;
    $empty = '';
    //boolean型は表示される際、trueなら1、falseなら0となる
    print $int . $string . $boolean . $NULL . $empty;
    $boolean = false;
    echo $int, $string, $boolean, $NULL, $empty;
    printf("%d %s %d %s %s", $int, $string, $boolean, $NULL, $empty);
?>

</body>
</html>

