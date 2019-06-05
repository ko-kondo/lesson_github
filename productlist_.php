<?php
    // PostgreSQLサーバー接続に必要な値を変数に代入
    $username = 'helloworld';
    $password = 'helloworld';
    
    // PDO のインスタンスを生成して、PostgreSQLサーバーに接続
    $database = new PDO('pgsql:host=localhost;dbname=postgres;', $username, $password);
    
    // 実行するSQLを作成
    $sql = 'SELECT * FROM movies ORDER BY created_at DESC';
    // SQLを実行する
    $statement = $database->query($sql);
    // 結果レコード（ステートメントオブジェクト）を配列に変換する
    $records = $statement->fetchAll();
    
    // ステートメントを破棄する
    $statement = null;
    // PostgreSQLを使った処理が終わると、接続は不要なので切断する
    $database = null;
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ProductList</title>
    </head>
    <body>
<?php
    // フォームデータ送受信確認用コード（本番では削除）
    print '<div style="background-color: skyblue;">';
    print '<p>動作確認用：</p>';
    print_r($_POST);
    print '</div>';
?>
        <h1>ProductList</h1>
        <h2>動画の登録フォーム</h2>
        <form action="productlist.php" method="POST">
            <input type="text" name="product_title" placeholder="動画タイトルを入力" required>
            <input type="submit" name="submit_add_product" value="登録">
        </form>
        <h2>登録された動画一覧</h2>
        <ul>
<?php
    print_r = $records;

    if ($records) {
        foreach ($records as $record) {
        $product_title = $record['product_title'];
?>
            <li><?php print $product_title; ?></li>
            <?php
        }
    }
    ?>
        </ul>
    </body>
</html>