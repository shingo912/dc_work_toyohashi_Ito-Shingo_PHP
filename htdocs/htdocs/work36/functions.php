<?php
    // ==============================
    // 定数定義（環境に合わせて変更）
    // ==============================
    define('DSN', 'mysql:host=localhost;dbname=xb513874_n9opa;charset=utf8');
    define('DB_USER', 'xb513874_n6viv');
    define('DB_PASS', '851d112dd0');
    define('UPLOAD_DIR', 'images/');
    define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png']);

    // ==============================
    // DB接続
    // ==============================
    function connectDB() {
        try {
            $pdo = new PDO(DSN, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return $pdo;
        } catch (PDOException $e) {
            exit("データベース接続エラー: " . htmlspecialchars($e->getMessage()));
        }
    }

    // ==============================
    // 画像取得（全件 or 公開のみ）
    // ==============================
    function getImages($publicOnly = false) {
        $pdo = connectDB();
        $sql = "SELECT image_id, title, file_name, public_flg FROM image";
        if ($publicOnly) {
            $sql .= " WHERE public_flg = 1";
        }
        $sql .= " ORDER BY update_date DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    // ==============================
    // メッセージ表示
    // ==============================
    function displayMessage($msg, $color = 'black') {
        if ($msg !== '') {
            echo "<p style='color:{$color};'>" . htmlspecialchars($msg) . "</p>";
        }
    }

    // ==============================
    // 画像一覧出力
    // ==============================
    function displayImages($images, $showToggle = false) {
        echo "<h2>画像一覧</h2>";
        echo "<div style='display:flex; flex-wrap:wrap; gap:15px;'>";

        foreach ($images as $img) {
            $filePath = UPLOAD_DIR . htmlspecialchars($img['file_name']);
            if (!file_exists($filePath)) {
                echo "<div style='color:gray;'>ファイルが見つかりません: " . htmlspecialchars($img['file_name']) . "</div>";
                continue;
            }

            $divClass = ($img['public_flg'] == 1) ? "" : " class='delete'";
            echo "<div{$divClass} style='padding:10px; text-align:center; border:1px solid #ccc; border-radius:8px;'>";
            echo "<img src='{$filePath}' alt='' width='150' style='display:block; margin:auto;'><br>";
            echo htmlspecialchars($img['title']) . "<br>";

            // 管理ページの場合のみトグルボタンを表示
            if ($showToggle) {
                echo "<form method='post' style='margin-top:5px;'>";
                echo "<input type='hidden' name='toggle_id' value='" . htmlspecialchars($img['image_id']) . "'>";
                echo "<input type='hidden' name='current_flg' value='" . htmlspecialchars($img['public_flg']) . "'>";
                $btnText = ($img['public_flg'] == 1) ? "非表示にする" : "表示する";
                echo "<button type='submit' class='btn-toggle'>{$btnText}</button>";
                echo "</form>";
            }

            echo "</div>";
        }

        echo "</div>";
    }

    // ==============================
    // 公開フラグ切替処理
    // ==============================
    function togglePublicFlag($id, $currentFlg) {
        $pdo = connectDB();
        $pdo->beginTransaction();
        try {
            $newFlg = ($currentFlg == 1) ? 0 : 1;
            $sql = "UPDATE image SET public_flg = :new_flg, update_date = :update_date WHERE image_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':new_flg', $newFlg, PDO::PARAM_INT);
            $stmt->bindValue(':update_date', date("Y-m-d"));
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $pdo->commit();
            return "表示状態を更新しました。";
        } catch (PDOException $e) {
            $pdo->rollBack();
            return "UPDATEエラー: " . htmlspecialchars($e->getMessage());
        }
    }

    // ==============================
    // 画像投稿（INSERT）処理
    // ==============================
    function insertImage($title, $file) {
        $error = validateImageUpload($title, $file);
        if ($error !== '') return $error;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $imageName = uniqid('img_', true) . '.' . $ext;
        $destPath = UPLOAD_DIR . $imageName;

        if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0777, true);

        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            return "画像のアップロードに失敗しました。";
        }

        $pdo = connectDB();
        $pdo->beginTransaction();
        try {
            $sql = "INSERT INTO image (title, file_name, public_flg, create_date, update_date)
                    VALUES (:title, :file_name, 1, :create_date, :update_date)";
            $stmt = $pdo->prepare($sql);
            $date = date("Y-m-d");
            $stmt->execute([
                ':title' => $title,
                ':file_name' => $imageName,
                ':create_date' => $date,
                ':update_date' => $date
            ]);
            $pdo->commit();
            return "画像を登録しました。";
        } catch (PDOException $e) {
            $pdo->rollBack();
            return "INSERTエラー: " . htmlspecialchars($e->getMessage());
        }
    }

    // ==============================
    // 画像アップロードバリデーション
    // ==============================
    function validateImageUpload($title, $file) {
        if (trim($title) === '') {
            return "タイトルを入力してください。";
        }
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return "画像を選択してください。";
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ALLOWED_EXTENSIONS, true)) {
            return "アップロードできるのは JPG, JPEG, PNG のみです。";
        }

        return ''; // エラーなし
    }
?>