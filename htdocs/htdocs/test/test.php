<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>顧客一覧</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        a { margin: 0 5px; text-decoration: none; }
    </style>
</head>
<body>
    <?php
        define('MAX', 3); // 1ページの表示数

        $customers = array(
            array('name' => '佐藤', 'age' => '10'),
            array('name' => '鈴木', 'age' => '15'),
            array('name' => '高橋', 'age' => '20'),
            array('name' => '田中', 'age' => '25'),
            array('name' => '伊藤', 'age' => '30'),
            array('name' => '渡辺', 'age' => '35'),
            array('name' => '山本', 'age' => '40'),
        );

        $customers_num = count($customers); // 総件数
        $max_page = ceil($customers_num / MAX); // 総ページ数

        // 現在ページの取得（デフォルトは1ページ目）
        $now = isset($_GET['page_id']) ? (int)$_GET['page_id'] : 1;
        $now = max(1, min($now, $max_page)); // 範囲制限

        $start_no = ($now - 1) * MAX;
        $disp_data = array_slice($customers, $start_no, MAX);

        // テーブル表示
        echo '<table>';
        echo '<tr><th>名前</th><th>年齢</th></tr>';
        foreach($disp_data as $customer){
            echo '<tr>';
            echo '<td>' . htmlspecialchars($customer['name'], ENT_QUOTES) . '</td>';
            echo '<td>' . htmlspecialchars($customer['age'], ENT_QUOTES) . '</td>';
            echo '</tr>';
        }
        echo '</table>';

        // ページネーション
        echo '<div style="margin-top:10px;">';

        // 前へリンク
        if($now > 1){
            echo '<a href="?page_id=' . ($now - 1) . '">前へ</a>';
        } else {
            echo '前へ';
        }

        // ページ番号リンク
        for($i = 1; $i <= $max_page; $i++){
            if($i == $now){
                echo ' ' . $i . ' ';
            } else {
                echo ' <a href="?page_id=' . $i . '">' . $i . '</a> ';
            }
        }

        // 次へリンク
        if($now < $max_page){
            echo '<a href="?page_id=' . ($now + 1) . '">次へ</a>';
        } else {
            echo '次へ';
        }

        echo '</div>';
    ?>
</body>
</html>

