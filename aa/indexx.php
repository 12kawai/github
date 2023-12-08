<!-- index.php -->

<?php
// CSVファイルのパス
$csvFilePath = 'access.csv';

// CSVファイルが存在しない場合は作成する
if (!file_exists($csvFilePath)) {
    $csvHeader = "Timestamp,Access Count\n";
    file_put_contents($csvFilePath, $csvHeader);
}

// CSVから現在のアクセスカウントを読み込む
$accessData = file_get_contents($csvFilePath);
list($header, $count) = explode(',', $accessData);

// アクセスカウントを増やす
$count = intval($count) + 1;

// 新しいアクセスカウントでCSVを更新する
$newAccessData = date('Y-m-d H:i:s') . ",$count\n";
file_put_contents($csvFilePath, $newAccessData);

?>

<!DOCTYPE html>
<html>
<head>
    <title>いろいろなミニゲーム</title>
    <link rel="stylesheet" type="text/css" href="./css/styleo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* 画像コンテナのスタイルを追加 */
        .image-container {
            display: none;
            /* position: absolute;   */
            /* top: 42%;
            left: 30%; */
        }
    </style>
</head>
<body>
<?php
    // アクセス数を表示する
    echo "<h1>色々なミニゲーム（閲覧数：$count ）</h1>";
    ?>
    
    <!-- <h1>じゃんけんゲーム</h1><h1>4択クイズ</h1><h1>テトリス風</h1><h1>オセロ</h1><h1>７色オセロ</h1><h1>三目並べ</h1><h1>シューティングゲーム</h1><h1>ブロック崩し</h1><h1>神経衰弱</h1><h1>モグラたたき</h1><h1>スロットゲーム</h1> -->
    <!-- <a href="quiz.php?q=0">クイズを始める</a> -->
    <a href="http://localhost/tetris/tetriss.php" onmouseover="showImage('gazo1.png')" onmouseout="hideImage()">テトリス風を始める</a>  
    <a href="http://localhost/suik/pac.php" onmouseover="showImage('gazo15.png')" onmouseout="hideImage()">パックマン風ゲームを始める</a>
    <a href="http://localhost/osero/index.php" onmouseover="showImage('gazo3.png')" onmouseout="hideImage()">７色オセロを始める</a>
    <a href="oserom.php" onmouseover="showImage('gazo2.png')" onmouseout="hideImage()">オセロを始める</a>
    <a href="http://localhost/o/index.html" onmouseover="showImage('gazo10.png')" onmouseout="hideImage()">スイカゲームを始める</a>
    <a href="http://localhost/suik/taru.html" onmouseover="showImage('gazo16.png')" onmouseout="hideImage()">樽避けゲームを始める</a>
    <a href="http://localhost/sin/card.html" onmouseover="showImage('gazo7.png')" onmouseout="hideImage()">神経衰弱を始める</a>
    <a href="blackjack.html" onmouseover="showImage('gazo9.png')" onmouseout="hideImage()">ブラックジャックを始める</a>
    <!-- <a href="syu.php" onmouseover="showImage('gazo4.png')" onmouseout="hideImage()">シューティングゲームを始める</a> -->
    <a href="kuzusi.html" onmouseover="showImage('gazo6.png')" onmouseout="hideImage()">ブロック崩しを始める</a>
    <a href="mogura.html" onmouseover="showImage('gazo8.png')" onmouseout="hideImage()">モグラたたきを始める</a>
    <a href="http://localhost/sannmoku/index.html" onmouseover="showImage('gazo5.png')" onmouseout="hideImage()">三目並べを始める</a>
    <a href="http://localhost/ty/index.html" onmouseover="showImage('gazo12.png')" onmouseout="hideImage()">タイピングゲームを始める</a>
    <a href="http://localhost/su/dan.php" onmouseover="showImage('gazo14.png')" onmouseout="hideImage()">弾幕ゲーム</a>
    <a href="utu.html" onmouseover="showImage('gazo13.png')" onmouseout="hideImage()">インベーダーゲーム</a>
    <a href="jyanken.html" onmouseover="showImage('gazo11.png')" onmouseout="hideImage()">じゃんけんゲームを始める</a>
    <a href="#" onclick="openRandomLink()" onmouseover="showImage('gazo177.png')" onmouseout="hideImage()">ランダム</a>
    <div class="image-container" id="imageContainer">
    <img src="gazo15.png" >
    <!-- <img src="gazo3.png" >
    <img src="gazo1.png" >    
    <img src="gazo2.png" >
    <img src="gazo7.png" >
    <img src="gazo10.png" >
    <img src="gazo9.png" >
    <img src="gazo16.png" >
    <img src="gazo177.png" >
    <img src="gazo6.png" >
    <img src="gazo8.png" >
    <img src="gazo5.png" >
    <img src="gazo12.png" >
    <img src="gazo14.png" >
    <img src="gazo13.png" >
    <img src="gazo11.png" > -->

    </div>
    <script>
        // マウスオーバー時に画像を表示するJavaScript関数
        function showImage(imageName) {
            var imageContainer = document.getElementById("imageContainer");
            imageContainer.style.display = "block";
            imageContainer.getElementsByTagName("img")[0].src = imageName;
        }

        // マウスアウト時に画像を非表示にするJavaScript関数
        function hideImage() {
            var imageContainer = document.getElementById("imageContainer");
            imageContainer.style.display = "none";
        }

        function openRandomLink() {
            // リンクのリスト
            var links = [
                "http://localhost/tetris/tetriss.php",
                "http://localhost/suik/pac.php",
                "http://localhost/osero/index.php",
                "oserom.php",
                "http://localhost/o/index.html",
                "http://localhost/suik/taru.html",
                "http://localhost/sin/card.html",
                "blackjack.html",
                "kuzusi.html",
                "mogura.html",
                "http://localhost/sannmoku/index.html",
                "http://localhost/ty/index.html",
                "http://localhost/su/dan.php",
                "utu.html",
                "jyanken.html",
                
                // 必要に応じてリンクを追加してください
            ];

            // ランダムなインデックスを取得
            var randomIndex = Math.floor(Math.random() * links.length);

            // ランダムなリンクを開く
            window.location.href = links[randomIndex];
        }
 
    </script>

</body>
</html>
