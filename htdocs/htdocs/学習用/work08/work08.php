<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work08</title>
</head>
<body>
        <?php $seisuu = rand(1,100);
        switch (true):
            case ($seisuu % 6 == 0):  // 6の倍数は必ず3の倍数
            ?>
                <p>3と6の倍数です</p>
                break;
            case ($seisuu % 3 == 0):
                print '<p>3の倍数で、6の倍数ではありません</p>';
                break;
            default:
                print '<p>倍数ではありません</p>';
                break;
        }

        $random01 = rand(1,10);
        $random02 = rand(1,10);

        switch (true) {
            // random01 > random02
            case ($random01 > $random02):
                switch (true) {
                    case ($random01 % 3 == 0 && $random02 % 3 == 0):
                        print "random01 = $random01, random02 = $random02 です。 random01の方が大きいです。2つの数字の中には3の倍数が2つ含まれています。";
                        break;
                    case ($random01 % 3 != 0 && $random02 % 3 != 0):
                        print "random01 = $random01, random02 = $random02 です。 random01の方が大きいです。2つの数字の中に3の倍数が含まれていません。";
                        break;
                    default:
                        print "random01 = $random01, random02 = $random02 です。 random01の方が大きいです。2つの数字の中には3の倍数が1つ含まれています。";
                        break;
                }
                break;

            // random01 < random02
            case ($random01 < $random02):
                switch (true) {
                    case ($random01 % 3 == 0 && $random02 % 3 == 0):
                        print "random01 = $random01, random02 = $random02 です。 random02の方が大きいです。2つの数字の中には3の倍数が2つ含まれています。";
                        break;
                    case ($random01 % 3 != 0 && $random02 % 3 != 0):
                        print "random01 = $random01, random02 = $random02 です。 random02の方が大きいです。2つの数字の中に3の倍数が含まれていません。";
                        break;
                    default:
                        print "random01 = $random01, random02 = $random02 です。 random02の方が大きいです。2つの数字の中には3の倍数が1つ含まれています。";
                        break;
                }
                break;

            // random01 == random02
            default:
                switch (true) {
                    case ($random01 % 3 == 0 && $random02 % 3 == 0):
                        print "random01 = $random01, random02 = $random02 です。2つは同じ数です。2つの数字の中には3の倍数が2つ含まれています。";
                        break;
                    default:
                        print "random01 = $random01, random02 = $random02 です。2つは同じ数です。2つの数字の中に3の倍数が含まれていません。";
                        break;
                }
                break;
        }
</body>
</html>

