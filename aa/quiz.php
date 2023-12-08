<!-- quiz.php -->

<!DOCTYPE html>
<html>
<head>
    <title>4択クイズ</title>
    <style>
        footer {
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
    <h1>クイズ</h1>

    <?php
    session_start();
    
    if (isset($_SESSION['questionsAttempted'])) {
        $_SESSION['questionsAttempted'] += 1;
    } else { $_SESSION['questionsAttempted'] = 1; }
    
    // $question_no = $_SESSION['question_no'];
    // if (!isset($_SESSION['correct_no']))
    //  { $_SESSION['correct_no'] = 0;
    // }
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

    // URLパラメータのクエリ文字列を取得
    $queryString = $_SERVER['QUERY_STRING'];

    // 現在の問題番号を取得
    $questionNumber = isset($_GET["q"]) ? (int)$_GET["q"] : 0;

    // 出題済みの問題IDをセッション変数に保存
    if (!isset($_SESSION["askedQuestions"])) {
        $_SESSION["askedQuestions"] = array();
    }

    // ランダムに問題を選択
    $remainingQuestions = array_diff(range(0, count($quizData) - 1), $_SESSION["askedQuestions"]);
    $remainingQuestions = array_values($remainingQuestions);
    if (empty($remainingQuestions)) {
        echo "<p>すべての問題が出題されました。</p>";
        // セッション変数をリセット
        $_SESSION["askedQuestions"] = array();
    } else {
        shuffle($remainingQuestions);
        $questionNumber = $remainingQuestions[0];
        // 出題済みの問題としてセッションに記録
        $_SESSION["askedQuestions"][] = $questionNumber;
    }

    $currentQuestion = $quizData[$questionNumber];

    // 選択肢の値を取得
    $userChoice = isset($_POST["choice"]) ? $_POST["choice"] : null;

    // 問題が送信された場合は、出題数を更新
    if (isset($_POST["questionNumber"])) {
        $questionsAttempted = isset($_POST["questionsAttempted"]) ? (int)$_POST["questionsAttempted"] : 1;
    } else {
        $questionsAttempted = isset($_SESSION["questionsAttempted"]) ? $_SESSION["questionsAttempted"] : 1; // 出題数の初期値を1に設定
    }

    // 正解数を取得
    $correctAnswers = isset($_SESSION["correctAnswers"]) ? (int)$_SESSION["correctAnswers"] : 0;

    // 連続正解数をセッションから取得
    $consecutiveCorrectAnswers = isset($_SESSION["consecutiveCorrectAnswers"]) ? (int)$_SESSION["consecutiveCorrectAnswers"] : 0;

    // 前回の回答が正解だったかをチェック
    $lastAnswerIsCorrect = $userChoice === $currentQuestion["answer"];
    if ($lastAnswerIsCorrect) {
        // 正解の場合は連続正解数をインクリメント
        $consecutiveCorrectAnswers++;
    } else {
        // 不正解の場合は連続正解数をリセット
        $consecutiveCorrectAnswers = 0;
    }

    // 連続正解数をセッションに保存
    $_SESSION["consecutiveCorrectAnswers"] = $consecutiveCorrectAnswers;

    // 連続正解数の最大値を取得
    $max_consecutiveCorrectAnswers = isset($_SESSION["max_consecutiveCorrectAnswers"]) ? (int)$_SESSION["max_consecutiveCorrectAnswers"] : 0;
    if ($consecutiveCorrectAnswers > $max_consecutiveCorrectAnswers) {
        $max_consecutiveCorrectAnswers = $consecutiveCorrectAnswers;
        $_SESSION["max_consecutiveCorrectAnswers"] = $max_consecutiveCorrectAnswers;
    }

    // 選択肢の連想配列を作成
    $choices = array(
        array('content' => $currentQuestion["selection1"], 'value' => '1'),
        array('content' => $currentQuestion["selection2"], 'value' => '2'),
        array('content' => $currentQuestion["selection3"], 'value' => '3'),
        array('content' => $currentQuestion["selection4"], 'value' => '4')
    );


// 選択肢をシャッフル
shuffle($choices);

// 問題と選択肢を表示
echo "<h2>第". $questionsAttempted ."問. ".$currentQuestion["question"]."</h2>";
echo "<form method='post' action='result.php'>";
echo "<ul>";

foreach ($choices as $choice) {
    echo "<li><label><input type='radio' name='choice' value='".$choice['value']."'>".$choice['content']."</label></li>";
}

echo "</ul>";
echo "<input type='hidden' name='questionNumber' value='".$questionNumber."'>";
echo "<input type='hidden' name='questionsAttempted' value='".$questionsAttempted."'>";
echo "<input type='submit' value='送信'>";
echo "</form>";

// 結果を表示
echo "<footer>";
echo "<span style='font-weight: bold;'>出題数：</span>" . $questionsAttempted . "問<br>";
echo "<span style='font-weight: bold;'>正解数：</span>" . $correctAnswers . "問<br>";
echo "<span style='font-weight: bold;'>現在連続正解数：</span>" . $consecutiveCorrectAnswers . "回<br>";
echo "<span style='font-weight: bold;'>最大連続正解数：</span>" . $max_consecutiveCorrectAnswers . "回<br>";
echo "</footer>";

?>
</body>
<a href="questions.php">問題一覧</a>

</html>
