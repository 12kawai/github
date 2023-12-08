<!DOCTYPE html>
<html>
<head>
    <title>問題編集</title>
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

        // CSVファイルを配列として取得
        $csvFile = 'questions.csv';
        $data = [];
        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }

        // 質問のIDを探して編集
        foreach ($data as $index => $row) {
            if ($row[0] === $id) {
                $data[$index] = [$id, $question, $selection1, $selection2, $selection3, $selection4, $answer, $commentary];
                break;
            }
        }

        // 編集したデータをCSVファイルに書き込む
        if (($handle = fopen($csvFile, 'w')) !== false) {
            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }

        // 成功メッセージを表示
        echo "<h2>問題の作成が完了しました。</h2>";
        echo "<p><a class='button' href='questions.php'>完了</a></p>";
    } else {
        // GETパラメータから質問のIDを取得
        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            // CSVファイルから指定されたIDの質問を取得
            $csvFile = 'questions.csv';
            $questionData = null;
            if (($handle = fopen($csvFile, 'r')) !== false) {
                while (($row = fgetcsv($handle)) !== false) {
                    if ($row[0] === $id) {
                        $questionData = $row;
                        break;
                    }
                }
                fclose($handle);
            }

            // 質問が見つかった場合は編集用フォームを表示
            if ($questionData) {
                $question = $questionData[1];
                $selection1 = $questionData[2];
                $selection2 = $questionData[3];
                $selection3 = $questionData[4];
                $selection4 = $questionData[5];
                $answer = $questionData[6];
                $commentary = $questionData[7];
        ?>
                <h1>質問を編集</h1>
                <form action="record.php" method="post">
                    <label for="id">ID:</label>
                    <input type="number" name="id" id="id" value="<?php echo $id; ?>" readonly class="readonly-field" required><br>
                    <label for="question">問題:</label>
                    <input type="text" name="question" id="question" value="<?php echo $question; ?>" required><br>
                    <label for="selection1">選択肢1:</label>
                    <input type="text" name="selection1" id="selection1" value="<?php echo $selection1; ?>" required><br>
                    <label for="selection2">選択肢2:</label>
                    <input type="text" name="selection2" id="selection2" value="<?php echo $selection2; ?>" required><br>
                    <label for="selection3">選択肢3:</label>
                    <input type="text" name="selection3" id="selection3" value="<?php echo $selection3; ?>" required><br>
                    <label for="selection4">選択肢4:</label>
                    <input type="text" name="selection4" id="selection4" value="<?php echo $selection4; ?>" required><br>
                    <label for="answer">正解の選択肢番号 (数字のみ):</label>
                    <input type="number" name="answer" id="answer" value="<?php echo $answer; ?>" required><br>
                    <label for="commentary">解説:</label>
                    <textarea name="commentary" id="commentary" required><?php echo $commentary; ?></textarea><br>
                    <input type="submit" value="質問を編集">
                </form>
                <p><a class="button" href="questions.php">完了</a></p>
    <?php
            } else {
                // 質問が見つからなかった場合はエラーメッセージを表示
                echo "<h2>指定されたIDの質問は見つかりませんでした。</h2>";
                echo "<p><a class='button' href='questions.php'>完了</a></p>";
            }
        } else {
            // IDが指定されていない場合はエラーメッセージを表示
            echo "<h2>質問のIDが指定されていません。</h2>";
            echo "<p><a class='button' href='questions.php'>完了</a></p>";
        }
    }
    ?>    
    
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
    } else {
        // questions.csvファイルに新しい質問を追加
        $newQuestion = "$id,$question,$selection1,$selection2,$selection3,$selection4,$answer,$commentary" . PHP_EOL;
        file_put_contents('questions.csv', $newQuestion, FILE_APPEND);

    }
}
?>

</body>
</html>
