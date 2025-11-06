<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work06</title>
</head>
<body>
    <?php 
        $seisuu = rand(1,100);		
        if (($seisuu)%3  == 0 && ($seisuu)%6  == 0 ):
            print '<p>3と6の倍数です</p>';
        elseif (($seisuu)%3  == 0):
            print '<p>3の倍数で、6の倍数ではありません</p>';
        else:
            print '<p>倍数ではありません</p>';
        endif;

        $random01 = rand(1,10);
        $random02 = rand(1,10);
        if ($random01>$random02):
            if (($random01)%3  == 0 && ($random02)%3  == 0 ):
                print 'random01 = '.$random01.', random02 = '.$random02.' です。 random01の方が大きいです。2つの数字の中には3の倍数が2つ含まれています。';
            elseif (($random01)%3  != 0 && ($random02)%3  != 0 ):
                print 'random01 = '.$random01.', random02 = '.$random02.' です。 random01の方が大きいです。2つの数字の中に3の倍数が含まれていません。';
            else:
                print 'random01 = '.$random01.', random02 = '.$random02.' です。 random01の方が大きいです。2つの数字の中には3の倍数が1つ含まれています。';
            endif;
        elseif ($random01<$random02):
            if (($random01)%3  == 0 && ($random02)%3  == 0 ):
                print 'random01 = '.$random01.', random02 = '.$random02.' です。 random02の方が大きいです。2つの数字の中には3の倍数が2つ含まれています。';
            elseif (($random01)%3  != 0 && ($random02)%3  != 0 ):
                print 'random01 = '.$random01.', random02 = '.$random02.' です。 random02の方が大きいです。2つの数字の中に3の倍数が含まれていません。';
            else:
                print 'random01 = '.$random01.', random02 = '.$random02.' です。 random02の方が大きいです。2つの数字の中には3の倍数が1つ含まれています。';
            endif;
        else:
            if (($random01)%3  == 0 && ($random02)%3  == 0 ):
                print 'random01 = '.$random01.', random02 = '.$random02.' です。  2つは同じ数です。2つの数字の中には3の倍数が2つ含まれています。';
            else:
                print 'random01 = '.$random01.', random02 = '.$random02.' です。  2つは同じ数です。2つの数字の中に3の倍数が含まれていません';
            endif;
        endif;

    ?>
</body>
</html>
