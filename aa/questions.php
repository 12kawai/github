<!-- questions.php -->

<!DOCTYPE html>
<html>
<head>
<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->

    <title>問題一覧</title>
    <style>
        hr {
            border: none;
            border-top: 1px double #000;
        }
        .question-number {
            font-weight: bold;
            font-size: 18px;
        }
        .question {
            font-weight: bold;
            font-size: 20px;
            color: #008000; /* Green color for the question */
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <h1>問題一覧</h1>
    <?php
    session_start();

    // CSVデータを読み込む関数
    function readCSV($csvFile)
    {
        $data = [];
        if (($handle = fopen($csvFile, 'r')) !== false) {
            // ヘッダー行を読み飛ばす
            fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                $data[] = [
                    'id' => $row[0],
                    'question' => $row[1],
                    'selection1' => $row[2],
                    'selection2' => $row[3],
                    'selection3' => $row[4],
                    'selection4' => $row[5],
                    'answer' => $row[6],
                    'commentary' => $row[7],
                ];
            }
            fclose($handle);
        }
        return $data;
    }

    // CSVファイルのパス
    $csvFile = 'questions.csv';

    // CSVデータを配列として取得
    $quizData = readCSV($csvFile);
    ?>

    <?php foreach ($quizData as $question) : ?>
        <p>
            <span class="question-number">問題番号: <?php echo $question['id']; ?></span><br>
            <span class="question">問題: <?php echo $question['question']; ?></span><br>
            選択肢1: <?php echo $question['selection1']; ?><br>
            選択肢2: <?php echo $question['selection2']; ?><br>
            選択肢3: <?php echo $question['selection3']; ?><br>
            選択肢4: <?php echo $question['selection4']; ?><br>
            <hr>
            正解: <?php echo $question['answer']; ?><br>
            解説: <?php echo $question['commentary']; ?><br>
            <hr>
            <a href="index.php">タイトルへ</a>
            <a href="make.php">問題作成</a>
            <a href="edit.php">問題編集</a>
        </p>
    <?php endforeach; ?>
</body>
</html>


