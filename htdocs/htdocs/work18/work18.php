<!DOCTYPE  html>
<html lang="ja">
    <head>
    <meta charset="UTF-8">
    <title>work18</title>
    <style>
        table { border-collapse: collapse; width: 30%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        a { margin: 0 5px; text-decoration: none; }
    </style>
    </head>
    <body>
        <?php
            define('MAX','3'); // 1ページの表示数
            
            $customers = array( // 表示データの配列
                    array('name' => '佐藤', 'age' => '10'),
                    array('name' => '鈴木', 'age' => '15'),
                    array('name' => '高橋', 'age' => '20'),
                    array('name' => '田中', 'age' => '25'),
                    array('name' => '伊藤', 'age' => '30'),
                    array('name' => '渡辺', 'age' => '35'),
                    array('name' => '山本', 'age' => '40'),
                        );
                        
            $customers_num = count($customers); // トータルデータ件数
            
            $max_page = ceil($customers_num / MAX); // トータルページ数

            // データ表示、ページネーションを実装

            $now_page = isset($_GET['page_id']) ? (int)$_GET['page_id'] : 1;
            $now_page = max(1, min($now_page, $max_page));

            $start_no = ($now_page - 1) * MAX;
            $disp_data = array_slice($customers, $start_no, MAX);

            echo '<table>';
            echo '<tr><th>名前</th><th>年齢</th></tr>';
            foreach($disp_data as $customer){
                echo '<tr>';
                echo '<td>' . htmlspecialchars($customer['name'], ENT_QUOTES) . '</td>';
                echo '<td>' . htmlspecialchars($customer['age'], ENT_QUOTES) . '</td>';
                echo '</tr>';
            }
            echo '</table>';

            if($now_page > 1){
                echo '<a href="?page_id=' . ($now_page - 1) . '">前へ</a>';
            } else {
                echo '前へ';
            }

            for($i = 1; $i <= $max_page; $i++){
                if($i == $now_page){
                    echo ' ' . $i . ' ';
                } else {
                    echo ' <a href="?page_id=' . $i . '">' . $i . '</a> ';
                }
            }

            if($now_page < $max_page){
                echo '<a href="?page_id=' . ($now_page + 1) . '">次へ</a>';
            } else {
                echo '次へ';
            }

            echo '</div>';
        ?>
    </body>
</html>

