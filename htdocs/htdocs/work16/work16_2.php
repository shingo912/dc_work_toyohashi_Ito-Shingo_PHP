<!DOCTYPE  html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work16_2</title>
</head>
<body>
    <div>入力内容の取得</div>

    <?php
        // 入力内容を表示
        if (isset($_GET['display_text']) && $_GET['display_text'] != "") {
            echo '<p>入力した内容： ' . htmlspecialchars($_GET['display_text'], ENT_QUOTES, 'UTF-8') . '</p>';
        } else {
            echo '<p>入力されていません</p>';
        }

        // チェックボックスの値を保持
        $options = isset($_GET['options']) && is_array($_GET['options']) ? $_GET['options'] : [];
    ?>

    <form method="get" action="work16_2.php">
        <input type="text" name="display_text" 
               value="<?php echo isset($_GET['display_text']) ? htmlspecialchars($_GET['display_text'], ENT_QUOTES, 'UTF-8') : ''; ?>"><br>

        <input type="checkbox" name="options[]" value="選択肢01" 
            <?php echo in_array("選択肢01", $options) ? 'checked' : ''; ?>> 選択肢01<br>

        <input type="checkbox" name="options[]" value="選択肢02" 
            <?php echo in_array("選択肢02", $options) ? 'checked' : ''; ?>> 選択肢02<br>

        <input type="checkbox" name="options[]" value="選択肢03" 
            <?php echo in_array("選択肢03", $options) ? 'checked' : ''; ?>> 選択肢03<br>

        <input type="submit" value="再送信">
    </form>
</body>
</html>