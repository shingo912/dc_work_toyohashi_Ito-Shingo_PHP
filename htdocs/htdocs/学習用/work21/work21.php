<?php
    $content ='';		// 初期化
    $tele_num ='';		// 初期化
    if(isset($_POST['content'])){
        $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
    }
    if(isset($_POST['tele_num'])){
        $tele_num = htmlspecialchars($_POST['tele_num'], ENT_QUOTES, 'UTF-8');
    }
    $_POST['content'];
    $_POST['tele_num'];
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>work21</title>
</head>
    <body>
        <form method="post" enctype="multipart/form-data">
            <div>半角アルファベットの大文字と小文字のみで入力を行ってください。</div>
            <label>入力フォーム：<input type="text" name="content"></label><br><br>
            <div>携帯電話番号の形式(○○○-○○○○-○○○○)で入力を行ってください。</div>
            <label>携帯電話番号：<input type="text" name="tele_num"></label><br><br>
            <input type="submit" value="送信">
        </form>

        <?php
            if (!preg_match("/^[a-zA-Z]+$/", $content) && $content !== '') {
                echo "正しい入力形式ではありません";
                ?>
                <br>
                <?php
            } 
            
            if (preg_match('/dc/', $content) && preg_match('/end$/', $content) && $content !== '') {
                echo 'ディーキャリアが含まれています';
                ?>
                <br>
                <?php
                echo '終了です！';
                ?>
                <br>
                <?php
            }
            elseif (preg_match('/dc/', $content) &&$content !== '') {
                echo 'ディーキャリアが含まれています';
                ?>
                <br>
                <?php
            }
            elseif (preg_match('/end$/', $content) && $content !== ''){
                echo '終了です！';
                ?>
                <br>
                <?php
            }
        ?>

        <?php
            if (!preg_match('/^(090|080|070)-\d{4}-\d{4}$/', $tele_num) && $tele_num !== '') {
                echo "<div>携帯電話番号の形式で入力を行ってください。</div>";
                ?>
                <br>
                <?php
            }
        ?>
    </body>
</html>