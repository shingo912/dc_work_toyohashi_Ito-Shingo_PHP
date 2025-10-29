<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>work37</title>
</head>
    <body>
        <?php 
                //cookieに値がある場合、変数に格納する
                if (isset($_COOKIE['cookie_confirmation']) === TRUE) {
                    $cookie_confirmation = "checked";
                } else {
                    $cookie_confirmation = "";
                }
                if (isset($_COOKIE['user_id']) === TRUE) {
                    $user_id = $_COOKIE['user_id'];
                } else {
                    $user_id = '';
                }
                if (isset($_COOKIE['password']) === TRUE) {
                    $password = $_COOKIE['password'];
                } else {
                    $password = '';
                }
            ?>
            <form action="home.php" method="post">
                <label for="user_id">ユーザーID</label><input type="text" id="user_id" name="user_id" value="<?php echo $user_id; ?>"><br>
                <label for="password">ログインID</label><input type="text" id="password" name="password" value="<?php echo $password; ?>"><br>
                <input type="checkbox" name="cookie_confirmation" value="checked" <?php print $cookie_confirmation;?>>次回からログインIDの入力を省略する<br>
                <input type="submit" value="ログイン">
            </form>
    </body>
</html>