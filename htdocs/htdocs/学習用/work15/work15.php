<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work15</title>
</head>
<body>
    <?php 
        $class01 = [['tokugawa','oda','toyotomi','takeda'],[rand(1,100),rand(1,100),rand(1,100),rand(1,100)]];
        $class02 = [['minamoto','taira','sugawara','fujiwara'],[rand(1,100),rand(1,100),rand(1,100),rand(1,100)]];
        $school = array($class01, $class02);
        if ($school[0][1][1] > $school[1][2][2]):
            print 'odaさんの点数は'.$school[0][1][1].'点,sugawaraさんの点数は'.$school[1][1][2].' です。 odaさんの点数の方が高いです。';
        elseif($school[0][1][1] < $school[1][2][2]):
            print 'odaさんの点数は'.$school[0][1][1].'点,sugawaraさんの点数は'.$school[1][1][2].' です。 sugawaraさんの点数の方が高いです。';
        else:
            print 'odaさんの点数は'.$school[0][1][1].'点,sugawaraさんの点数は'.$school[1][1][2].' です。 どちらも同じ点数です。';
        endif;

        function getAverage($classArr) {
            $scores = $classArr[1]; // 点数の配列
            $sum = array_sum($scores);
            return round($sum / count($scores), 2);
        }

        $avgClass01 = getAverage($school[0]);
        $avgClass02 = getAverage($school[1]);

        print 'class1の平均点は'.$avgClass01.'点,class2の平均点は'.$avgClass02.' です。';
    ?>
</body>
</html>

