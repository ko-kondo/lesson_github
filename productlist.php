<?php
//$_POST['product_title'] = "おるか";

// PostgreSQLサーバ接続に必要な値を変数に代入
$username = 'helloworld';
$password = 'helloworld';

// PDO のインスタンスを生成して、PostgreSQLサーバに接続
$database = new PDO('pgsql:host=localhost;dbname=postgres;', $username, $password);

// フォームから動画タイトルが送信されていればデータベースに保存する
if ($_POST['product_title']) {
    // 実行するSQLを作成
    $sql = 'INSERT INTO movies (product_title) VALUES (:product_title)';
    // ユーザ入力に依存するSQLを実行するので、セキュリティ対策をする
    $statement = $database->prepare($sql);
    // ユーザ入力データ($_POST['product_title'])をVALUES(?)の?の部分に代入する
    $statement->bindParam(':product_title', $_POST['product_title']);
    // SQL文を実行する
    $statement->execute();
    // ステートメントを破棄する
    $statement = null;
}

// 実行するSQLを作成
$sql = 'SELECT * FROM movies ORDER BY created_at DESC';
// SQL を実行する直前のステートメントを取得する
$statement = $database->query($sql);
// ステートメントから SQL を実行し、レコードを取得する
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
        // フォームデータ送受信確認用コード
        print '<div style="background-color: skyblue;">';
        print '<p>動作確認用:</p>';
        print_r($_POST);
        print '</div>';
?>
        <h1>ProductList</h1>
        <h2>動画の登録フォーム</h2>
        <form action="productlist.php" method="post">
            <input type="text" name="product_title" placeholder="動画タイトルを入力" required>
            <input type="submit" name="submit_add_product" value="登録">
        </form>
        <h2>登録された動画一覧</h2>
<ul>
    <?php
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