<!-- make.php -->

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">

    <title>問題作成</title>
    <style>
        body {
            text-align: center;
        }
        form {
            display: inline-block;
            text-align: left;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        input[type="submit"] {
            margin-top: 10px;
        }
        /* リンクをボタンに見せるためのスタイル */
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        /* フィールドを表示専用にするスタイル */
        .readonly-field {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1>問題作成</h1>
    <form action="record.php" method="post">
        <?php
        // 最後のidを取得して1を加える
        $lastId = 0;
        if (($handle = fopen('questions.csv', 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                $lastId = max($lastId, (int)$row[0]);
            }
            fclose($handle);
        }
        $nextId = $lastId + 1;
        ?>
        <label for="id">ID:</label>
        <input type="number" name="id" id="id" value="<?php echo $nextId; ?>" readonly class="readonly-field" required><br>
        <!-- <label for="id">ID:</label>
        <input type="number" name="id" id="id" required><br> -->
        <label for="question">問題:</label>
        <input type="text" name="question" id="question" required><br>
        <label for="selection1">選択肢1:</label>
        <input type="text" name="selection1" id="selection1" required><br>
        <label for="selection2">選択肢2:</label>
        <input type="text" name="selection2" id="selection2" required><br>
        <label for="selection3">選択肢3:</label>
        <input type="text" name="selection3" id="selection3" required><br>
        <label for="selection4">選択肢4:</label>
        <input type="text" name="selection4" id="selection4" required><br>
        <label for="answer">正解の選択肢番号 (数字1~4のみ):</label>
        <input type="number" name="answer" id="answer" min="1" max="4" required><br>
        <label for="commentary">解説:</label>
        <input type="text" name="commentary" id="commentary" required><br>
        <input type="submit" value="問題を作成">
    </form>
    <p><a class="button" href="questions.php">戻る</a></p>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // POSTデータを取得
    $id = $_POST["id"];
    $question = $_POST["question"];
    $selection1 = $_POST["selection1"];
    $selection2 = $_POST["selection2"];
    $selection3 = $_POST["selection3"];
    $selection4 = $_POST["selection4"];
    $answer = $_POST["answer"];
    $commentary = $_POST["commentary"];

    // 既存データと重複しているかチェック
    $isDuplicate = false;
    if (($handle = fopen('questions.csv', 'r')) !== false) {
        while (($row = fgetcsv($handle)) !== false) {
            if ($row[0] == $id) {
                $isDuplicate = true;
                break;
            }
        }
        fclose($handle);
    }

    if ($isDuplicate) {
        // 重複している場合はメッセージを表示
        echo "<h2>IDが既存データと重複しています。</h2>";
        echo "<p><a href='make.php'>戻る</a></p>";
    } else {
        // questions.csvファイルに新しい質問を追加
        $newQuestion = "$id,$question,$selection1,$selection2,$selection3,$selection4,$answer,$commentary" . PHP_EOL;
        file_put_contents('questions.csv', $newQuestion, FILE_APPEND);

        // 成功メッセージを表示
        echo "<h2>問題の作成が完了しました。</h2>";
        echo "<p><a class='button' href='questions.php'>完了</a></p>";
    }
}
?>
