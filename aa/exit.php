<!-- exit.php -->

<!DOCTYPE html>
<html>
<head>
    <title>クイズ終了</title>
    <style>
    
        body {
            text-align: center;
        }
        h1 {
            margin-bottom: 30px;
        }
        p {
            font-size: 30px;
            margin-bottom: 25px;
            font-weight: bold;
            color: red;

        }
        a {
            display: inline-block;
            padding: 50px 40px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>クイズ終了</h1>

    <?php
    // Get the final results from count.php using PHP sessions
    session_start();
    $questionsAttempted = isset($_SESSION["questionsAttempted"]) ? $_SESSION["questionsAttempted"] : 0;
    $correctAnswers = isset($_SESSION["correctAnswers"]) ? $_SESSION["correctAnswers"] : 0;
    $consecutiveCorrectAnswers = isset($_SESSION["consecutiveCorrectAnswers"]) ? $_SESSION["consecutiveCorrectAnswers"] : 0;
    $max_consecutiveCorrectAnswers = isset($_SESSION["max_consecutiveCorrectAnswers"]) ? $_SESSION["max_consecutiveCorrectAnswers"] : 0;

    // Clear the session data
    session_unset();
    session_destroy();

// CSVファイルのパス
$csvFile = 'questions.csv';

// CSVファイルを1行ずつ読み込みながら行数を数える
$numberOfRows = 0;
if (($handle = fopen($csvFile, 'r')) !== false) {
    while (fgets($handle) !== false) {
        $numberOfRows++;
    }
    fclose($handle);
}
?>

    <p>出題数 <?php echo "" .$numberOfRows; ?>問中：<?php echo $questionsAttempted; ?>問</p>
    <p>正解数 <?php echo $questionsAttempted; ?>問中：<?php echo $correctAnswers; ?>問</p>
    <p>現在連続正解数：<?php echo $consecutiveCorrectAnswers; ?>回</p>
    <p>最高連続正解数：<?php echo $max_consecutiveCorrectAnswers; ?>回</p>
    <a href="index.php">タイトルへ</a>
</body>
</html>
