<?php
// ゲームの結果メッセージを受け取る
if (isset($_POST['result_message'])) {
    $alertContent = $_POST['result_message']; // アラートの内容をここに代入

    // ファイル名と初期値
    $csvFile = 'scoreb.csv';
    $wins = 0;
    $losses = 0;
    $draws = 0;

    // ファイルが存在する場合、データを読み込む
    if (file_exists($csvFile)) {
        $data = str_getcsv(file_get_contents($csvFile));
        $wins = (int)$data[0];
        $losses = (int)$data[1];
        $draws = (int)$data[2];
    }

    // ゲームの結果に応じて勝利、敗北、引き分けの回数を更新
    if (strpos($alertContent, 'Black Win!') !== false) {
        // "Black Win!"の場合、勝利数(wins)を増やす
        $wins++;
    } elseif (strpos($alertContent, 'White Win!') !== false) {
        // "White Win!"の場合、敗北数(losses)を増やす
        $losses++;
    } else {
        // 上記以外の場合、引き分け数(draws)を増やす
        $draws++;
    }

    // 更新されたデータをファイルに書き込む
    $newData = "$wins,$losses,$draws\n";
    file_put_contents($csvFile, $newData);
} else {
    // "result_message"がPOSTされなかった場合のエラーハンドリングなどを追加できます
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>オセロゲーム</title>
    <link rel="stylesheet" type="text/css" href="./css/stylesss.css">
</head>
<body>
    <h1>オセロゲーム</h1>
    
    <p>手番：<span id="turn">---</span></p>
    <p> スコア（Black）<span id="score">---</span>(White)</p>
    <div id="ui_board"></div>
    <script src="src/boardb.js"></script>
    <script src="src/playerb.js"></script>
    <script src="src/gameb.js"></script>
    <script src="src/uib.js"></script>
    <script src="src/mainb.js"></script>

</body>


<p><a href="index.php">タイトルに戻る</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="oserom.php">オセロメニューに戻る</a></p>
<p><button onclick="location.reload();">リセット</button>
</p>
</html>
