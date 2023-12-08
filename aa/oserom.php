<?php
$scorebFile = 'scoreb.csv'; // 黒石用のファイル
$scorewFile = 'scorew.csv'; // 白石用のファイル

$bwins = 0; // 黒石の勝利回数を格納する変数
$blosses = 0; // 黒石の敗北回数を格納する変数
$bdraws = 0; // 黒石の引き分け回数を格納する変数

$wwins = 0; // 白石の勝利回数を格納する変数
$wlosses = 0; // 白石の敗北回数を格納する変数
$wdraws = 0; // 白石の引き分け回数を格納する変数

if (file_exists($scorebFile)) {
    $bdata = str_getcsv(file_get_contents($scorebFile));
    $bwins = (int)$bdata[0];
    $blosses = (int)$bdata[1];
    $bdraws = (int)$bdata[2];
}

if (file_exists($scorewFile)) {
    $wdata = str_getcsv(file_get_contents($scorewFile));
    $wwins = (int)$wdata[0];
    $wlosses = (int)$wdata[1];
    $wdraws = (int)$wdata[2];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>オセロメニュー</title>
    <link rel="stylesheet" type="text/css" href="./css/styleoo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2{
            color: black;
        }

        h3 {
            color: white;
        }


        p {
            margin: 5px 0;
        }

        a {
            text-decoration: none;
            color: #0066cc;
            font-weight: bold;
        }

        .menu-container {
            display: flex;
            justify-content: space-between;
            max-width: 800px; /* 調整が必要かもしれません */
            margin: auto;
        }

        .menu-item {
            width: 48%; /* 調整が必要かもしれません */
        }

        .back-link {
            margin-top: 20px;
            display: block;
        }
    </style>
</head>
<body>
    <h1>オセロメニュー</h1>
    <div class="menu-container">

        <div class="menu-item">
            <h2>先行（黒石）</h2>
            <a href="oserob.php">スタート</a>
            <?php
            $totalMatcheb = $bwins + $blosses + $bdraws;
            echo "<p>対戦数：{$totalMatcheb}回</p>";
            ?>
            <p><?php echo $bwins; ?>勝：<?php echo $blosses; ?>負：引分：<?php echo $bdraws; ?>回</p>
            
            <!-- <a href="oserob.php">先行（黒石）でスタート</a> -->
        </div>

        <div class="menu-item">
            <h3>後行（白石）</h3>
            <a href="oserow.php">スタート</a>
            <p>
            <?php
            $totalMatchew = $wwins + $wlosses + $wdraws;
            echo "<p>対戦数：{$totalMatchew}回</p>";
            ?>
            <p><?php echo $wwins; ?>勝：<?php echo $wlosses; ?>負：引分：<?php echo $wdraws; ?>回</p>
            
            <!-- <a href="oserow.php">後行（白石）でスタート</a> -->
        </div>
    </div>

    <h1 class="back-link"><a href="index.php">戻る</a></h1>
</body>
</html>
