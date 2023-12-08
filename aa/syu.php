<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* 画像コンテナのスタイルを追加 */
        .image-container {
            display: none;
            position: absolute;  
            top: 33%;
            left: 27%;
        }
    </style>

    <title>シューティング</title>
    <link rel="stylesheet" type="text/css" href="./css/styleo.css">
</head>
<body>
    <h1>シューティングゲーム</h1>

    <br><a href="index.php">タイトルへ</a>

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
    </script>

</body>
</html>

