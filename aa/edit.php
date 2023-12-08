<!-- edit.php -->

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
        select[type="submit"] {
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
    <h1>問題編集</h1>
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

        // CSVに存在するIDの範囲内に制限する
        $existingIds = range(1, $lastId); // 1から最後のIDまでの範囲を配列にする
        $nextId = in_array($nextId, $existingIds) ? $lastId  : $nextId;
        ?>
        <!-- <label for="answer">正解の選択肢番号 (数字のみ, 1から4の範囲):</label>
        <input type="number" name="answer" id="answer" min="1" max=""<?php $lastId; ?> required><br> -->
        <label for="id">ID:</label>
        <select name="id" id="id" required><br>
            <?php foreach ($existingIds as $id) { ?>
                <option value="<?php echo $id; ?>"><?php echo $id; ?></option>
            <?php } ?>
        </select><br>
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
        <input type="submit" value="問題を編集">
    </form>
    <p><a class="button" href="questions.php">戻る</a></p>
</body>
</html>
