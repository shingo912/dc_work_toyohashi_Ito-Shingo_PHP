<?php
    // ==============================
    // 定数定義（環境に合わせて変更）
    // ==============================
    define('DSN', 'mysql:host=localhost;dbname=xb513874_n9opa;charset=utf8');
    define('DB_USER', 'xb513874_n6viv');
    define('DB_PASS', '851d112dd0');
    define('UPLOAD_DIR', 'images/');
    define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png']);

    // --- DB接続 ---
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

    // --- 画像一覧取得 ---
    function getImages($publicOnly = false) {
        $pdo = connectDB();
        $sql = "SELECT image_id, title, file_name, public_flg FROM image";
        if ($publicOnly) $sql .= " WHERE public_flg = 1";
        $sql .= " ORDER BY update_date DESC";
        return $pdo->query($sql)->fetchAll();
    }

    // --- 公開フラグ切り替え ---
    function togglePublicFlag($id, $currentFlg) {
        $pdo = connectDB();
        $pdo->beginTransaction();
        try {
            $newFlg = ($currentFlg == 1) ? 0 : 1;
            $sql = "UPDATE image SET public_flg = :new_flg, update_date = :update_date WHERE image_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':new_flg' => $newFlg,
                ':update_date' => date("Y-m-d"),
                ':id' => $id
            ]);
            $pdo->commit();
            return "表示状態を更新しました。";
        } catch (PDOException $e) {
            $pdo->rollBack();
            return "UPDATEエラー: " . htmlspecialchars($e->getMessage());
        }
    }

    // --- 画像投稿処理 ---
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

    // --- バリデーション ---
    function validateImageUpload($title, $file) {
        if (trim($title) === '') return "タイトルを入力してください。";
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) return "画像を選択してください。";

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ALLOWED_EXTENSIONS, true)) {
            return "アップロードできるのは JPG, JPEG, PNG のみです。";
        }
        return '';
    }
?>