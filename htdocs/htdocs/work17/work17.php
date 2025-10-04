<!DOCTYPE  html>

<?php
    $text = '';
    if (isset($_POST['text'])) {
        $text = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
    }

    $checks = isset($_POST['check']) && is_array($_POST['check']) ? $_POST['check'] : [];
?>

<html lang="ja">
    <head>
    <meta charset="UTF-8">
    <title>work17</title>
    </head>
    <body>
        <div>入力内容の取得</div>
        <form method="post">
            <input type="text" name="text" value="<?= $text ?>"><br>
            <input type="checkbox" name="check[]" value="選択肢01" 
            <?= in_array("選択肢01", $checks) ? 'checked' : '' ?>> 選択肢01<br>

            <input type="checkbox" name="check[]" value="選択肢02" 
            <?= in_array("選択肢02", $checks) ? 'checked' : '' ?>> 選択肢02<br>

            <input type="checkbox" name="check[]" value="選択肢03" 
            <?= in_array("選択肢03", $checks) ? 'checked' : '' ?>> 選択肢03<br>
            
            <input type="submit" value="送信">
        </form>
    </body>
</html>

