<?php
if (isset($_POST["result"])) {
    $result = $_POST["result"];
    $csvFile = 'scoreb.csv';
    $wins = 0;
    $losses = 0;
    $draws = 0;

    if (file_exists($csvFile)) {
        $data = str_getcsv(file_get_contents($csvFile));
        $wins = (int)$data[0];
        $losses = (int)$data[1];
        $draws = (int)$data[2];
    }

    if (strpos($result, 'Black Win!') !== false) {
        // "Black Win!"の場合、勝利数(wins)を増やす
        $wins++;
    } elseif (strpos($result, 'White Win!') !== false) {
        // "White Win!"の場合、敗北数(losses)を増やす
        $losses++;
    } else {
        // 上記以外の場合、引き分け数(draws)を増やす
        $draws++;
    }

    $newData = "$wins,$losses,$draws\n";
    file_put_contents($csvFile, $newData);
}
?>
