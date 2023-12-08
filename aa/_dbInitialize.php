<?php
// *****************************************************************************
// データベース初期化
// データベースに必要なテーブルを作成し、初期データを読み込む
// *****************************************************************************
    // DB検索
    require_once("./dbConfig.php");

    // 定数展開用の関数
    $_ = function($s){return $s;};
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データベース初期化</title>
</head>
<body>
    <h1>データベースを初期化します</h1>
<?php
    // データベースサーバに接続
    $link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, null);
    if ($link == null)  die("データベースの接続に失敗しました：" . mysqli_connect_error());

    // データベースの削除と再作成
    echo "<p>データベース {$_(DB_NAME)}を作成中 ... </p>";
    $sql = "DROP DATABASE IF EXISTS {$_(DB_NAME)}";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<p>データベース {$_(DB_NAME)}を削除しました</p>";

    $sql = "CREATE DATABASE {$_(DB_NAME)} COLLATE utf8mb4_general_ci";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<p>データベース {$_(DB_NAME)}を作成しました</p>";

    // データベースの切り替え
    mysqli_select_db($link, DB_NAME);
    // テーブルの作成
    echo "<p>questions を初期化中 ... </p>";
    $sql = "DROP TABLE IF EXISTS questions";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $sql = "CREATE TABLE questions ("
            . " id INT PRIMARY KEY,"
            . " question TEXT NOT NULL,"
            . " selection1 TEXT NOT NULL,"
            . " selection2 TEXT NOT NULL,"
            . " selection3 TEXT NOT NULL,"
            . " selection4 TEXT NOT NULL,"
            . " answer INT NOT NULL,"
            . " commentary TEXT"
            . ")";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // データの挿入
    $sql = "INSERT INTO questions "
         . " (id, question, selection1, selection2, selection3, selection4, answer, commentary)"
         . " VALUES"
         . " (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);

    $file = new SplFileObject("questions.csv", "r"); 
    $file->setFlags(SplFileObject::READ_CSV); 
    foreach ($file as $line) {
        if ($line[0] == "id")  continue;
        if (!isset($line[1]))  break;

        echo "line[0]=". $line[0] ."line[1]=". $line[1] ."line[2]=". $line[2] ."<br>";
        mysqli_stmt_bind_param($stmt, "isssssis",
                    $line[0],
                    $line[1],
                    $line[2],
                    $line[3],
                    $line[4],
                    $line[5],
                    $line[6],
                    $line[7]);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

    mysqli_close($link);
?>
    <p>データベースの初期化が完了しました。</p>
</body>
</html>
