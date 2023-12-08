<!-- result.php -->

<!DOCTYPE html>
<html>
<head>
    <title>クイズ結果</title>
    <style>
        footer {
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
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

    // ユーザーの選択した回答を取得
    if (isset($_POST['choice'])) {
        $userChoice = $_POST['choice'];
    } else {
        $userChoice = ''; // 回答が未選択の場合は空文字にする
    }

    // 現在の問題番号を取得
    $questionNumber = isset($_POST['questionNumber']) ? (int)$_POST['questionNumber'] : 0;
    $currentQuestion = $quizData[$questionNumber];

    // 正解を取得
    $correctAnswer = $currentQuestion['answer'];

    // 解説を取得
    $commentary = $currentQuestion['commentary'];

    // 回答が正解かどうかを判定
    $isCorrect = $userChoice === $correctAnswer;

    // 正解数をセッションから取得
    $correctAnswers = isset($_SESSION["correctAnswers"]) ? (int)$_SESSION["correctAnswers"] : 0;

    // 前回の回答が正解だったかをチェック
    $lastAnswerIsCorrect = $userChoice === $currentQuestion["answer"];
    if ($lastAnswerIsCorrect) {
        // 正解の場合は正解数をインクリメント
        $correctAnswers++;
    }

     // 連続正解数をセッションから取得
     $consecutiveCorrectAnswers = isset($_SESSION["consecutiveCorrectAnswers"]) ? (int)$_SESSION["consecutiveCorrectAnswers"] : 0;
     if ($lastAnswerIsCorrect) {
         // 正解の場合は連続正解数をインクリメント
         $consecutiveCorrectAnswers++;
     } else {
         // 不正解の場合は連続正解数をリセット
         $consecutiveCorrectAnswers = 0;
     }
 
     // 連続正解数の最大値を取得
     $max_consecutiveCorrectAnswers = isset($_SESSION["max_consecutiveCorrectAnswers"]) ? (int)$_SESSION["max_consecutiveCorrectAnswers"] : 0;
     if ($consecutiveCorrectAnswers > $max_consecutiveCorrectAnswers) {
         $max_consecutiveCorrectAnswers = $consecutiveCorrectAnswers;
         $_SESSION["max_consecutiveCorrectAnswers"] = $max_consecutiveCorrectAnswers;
     }
 
     // 出題数をセッションから取得
     $questionsAttempted = isset($_SESSION["questionsAttempted"]) ? (int)$_SESSION["questionsAttempted"] : 0;
    //  $questionsAttempted++;
 
    // 結果を表示
    echo "<h1>クイズ結果</h1>";
    echo "<h2>第". $questionsAttempted ."問. " . $currentQuestion['question'] . "</h2>";
    echo "<ol>";
foreach ($quizData[$questionNumber] as $key => $value) {
    // 'selection'というキーを持つデータが選択肢として格納されていると仮定しています
    if (strpos($key, 'selection') !== false) {
        echo "<li>" . $value . "</li>";
    }
}
echo "</ol>";
    echo "<p>あなたの回答: " . $userChoice . "</p>";

    if ($isCorrect) {
        echo "<h3>正解です！</h3>";
    } else {
        echo "<h3>不正解です！</h3>";
    }

    echo "<p>正解: " . $correctAnswer . "</p>";
    echo "<p>解説: " . $commentary . "</p>";

    // 次の問題へのリンクを表示
    $nextQuestionNumber = $questionNumber;
    if ($nextQuestionNumber < count($quizData)) {
        // セッションに結果を保存
        $_SESSION["correctAnswers"] = $correctAnswers;
        $_SESSION["consecutiveCorrectAnswers"] = $consecutiveCorrectAnswers;
        $_SESSION["questionsAttempted"] = $questionsAttempted;

        // 次の問題へのURLを生成
        $nextQuestionURL = 'quiz.php?q=' . $nextQuestionNumber;
        echo "<a href='" . $nextQuestionURL . "'>次の問題へ</a>";
    } else {
        // クイズが終了した場合はセッションをリセット
        session_unset();
        session_destroy();
        echo "<p>1周しました</p>";
    }


    // フッターに結果を表示
    echo "<footer>";
    echo "<span style='font-weight: bold;'>出題数：</span>" . $questionsAttempted . "問<br>";
    echo "<span style='font-weight: bold;'>正解数：</span>" . $correctAnswers . "問<br>";
    echo "<span style='font-weight: bold;'>現在連続正解数：</span>" . $consecutiveCorrectAnswers . "回<br>";
    echo "<span style='font-weight: bold;'>最大連続正解数：</span>" . $max_consecutiveCorrectAnswers . "回<br>";   
    echo "</footer>";

    echo "<a href='exit.php?'>終了</a>";
    ?>
</body>
</html>
