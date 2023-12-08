<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        p {
            font-size: 2rem;
        }

        a:visited {
            color: #cae03a;
        }

        a:hover {
            color: #FFFFFF;
            background: #0000DD;
        }

        a:active {
            color: #FF0000;
        }

        body {
            text-align: center;
            color: #7f08e1;
            background-color: #303030;
            font-weight: bold;
            background-color: #FFD700;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: rgb(247, 247, 14);
            font-size: 4rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-bottom: 5px; /* 望む余白のサイズに調整 */

        }

        p {
            margin: 1px 0;
            font-size: 1.5rem;
            margin-bottom: 1px; /* 望む余白のサイズに調整 */

        }

        a {
            color: #dae80f;
            text-decoration: none;
            color: #FF1493;
            font-weight: bold;
        }

        a:hover {
            color: #FF4500;
        }

        body {
            background-color: rgb(171, 201, 23);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(5, 80px);
            grid-template-rows: repeat(5, 80px);
            gap: 10px;
        }

        h1, .game-info, #startButton, #resetButton {
            text-align: center;
        }

        .hole {
            width: 80px;
            height: 80px;
            background-color: rgb(171, 201, 23);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .mole {
            width: 80px;
            height: 80px;
            background-image: url('mogura.png');
            background-size: cover;
            background-repeat: no-repeat;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
            display: none;
        }
    </style>
</head>
<body>
    <h1>もぐらたたきゲーム</h1>
    <form id="score-form" method="post">
        <input type="text" id="player-name" name="playerName" placeholder="名前">
        <input type="hidden" id="score" name="score" value="0">
        <input type="submit" value="スコアを保存">
    </form>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $playerName = $_POST["playerName"];
        $score = $_POST["score"];
        $date = date('Y/m/d H:i'); // 日時を指定のフォーマットに整形

        // 書き込むデータをフォーマット
        $data = "$playerName - スコア: $score - 日時: $date\n";

        // CSVファイルにデータを追加
        file_put_contents("mogscore.csv", $data, FILE_APPEND);

        // 成功応答を送信
        echo "スコアが保存されました";
    }
    ?>

    
    <div class="game-info">
        <p>タイム: <span id="timer">60</span>秒</p>
        <p>スコア: <span id="score">0</span>点</p>
        <p>CPUのスコア: <span id="cpuScore">0</span>点</p>
    </div>

    <button id="startButton">START</button>
    <button id="resetButton" style="display: none;">RESET</button>

    <div class="container" id="game-container">
        <div class="hole"><div class="mole"></div></div>
        <div class="hole"><div class="mole"></div></div>
        <div class="hole"><div class="mole"></div></div>
        <div class="hole"><div class="mole"></div></div>
        <div class="hole"><div class="mole"></div></div>
        <div class="hole"><div class="mole"></div></div>
        <div class="hole"><div class="mole"></div></div>
    </div>

    <script>
        const container = document.getElementById("game-container");
        const timerDisplay = document.getElementById("timer");
        const scoreDisplay = document.getElementById("score");
        const cpuScoreDisplay = document.getElementById("cpuScore");

        const holeCount = 5 * 6;
        let score = 0;
        let timer = 60;
        let gameInterval;
        let countdownInterval;
        let gameStarted = false;
        let highestScore = 0;
        let cpuScore = 0;

        function initializeGame() {
            container.innerHTML = "";
            score = 0;
            scoreDisplay.innerText = score;
            timer = 8;
            timerDisplay.innerText = timer;
            cpuScore = 0;
            cpuScoreDisplay.innerText = cpuScore;

            for (let i = 0; i < holeCount; i++) {
                const hole = document.createElement("div");
                hole.classList.add("hole");
                hole.addEventListener("click", () => {
                    if (!gameStarted || hole.querySelector(".mole").style.display !== "block") return;
                    hole.querySelector(".mole").style.display = "none";
                    score++;
                    scoreDisplay.innerText = score;
                    if (score > highestScore) {
                        highestScore = score;
                    }
                });

                const mole = document.createElement("div");
                mole.classList.add("mole");
                hole.appendChild(mole);

                container.appendChild(hole);
            }
        }

        function increaseCPUScore() {
            cpuScore++;
            cpuScoreDisplay.innerText = cpuScore;
            // if (cpuScore > highestScore) {
            //     highestScore = cpuScore;
            // }
        }

        function startGame() {
            if (gameStarted) return;
            gameStarted = true;
            initializeGame();
            clearInterval(gameInterval);
            clearInterval(countdownInterval);

            gameInterval = setInterval(() => {
                const holes = document.querySelectorAll(".hole");
                const holesToShow = [];
                while (holesToShow.length < 3) {
                    const randomHoleIndex = Math.floor(Math.random() * holeCount);
                    if (!holesToShow.includes(randomHoleIndex)) {
                        holesToShow.push(randomHoleIndex);
                    }
                }

                holes.forEach(hole => hole.querySelector(".mole").style.display = "none");
                holesToShow.forEach(index => {
                    const mole = holes[index].querySelector(".mole");
                    mole.style.display = "block";
                    // CPUがたたく穴の背景色を変更
                    // holes[index].style.backgroundColor = "#FF0000"; // 例: 赤色
                    // setTimeout(() => {
                    //     0.5秒後に背景色を元に戻す
                    //     holes[index].style.backgroundColor = "rgb(171, 201, 23)";
                    //     increaseCPUScore();
                    // }, 1000);
                });
                increaseCPUScore();
            }, 1500);
            startCPU(1500);　//強さ

            countdownInterval = setInterval(() => {
                timer--;
                timerDisplay.innerText = timer;
                if (timer <= 0) {
                    clearInterval(gameInterval);
                    clearInterval(countdownInterval);
                    timerDisplay.innerText = "0";

                    setTimeout(() => {
                        
                        if (score > cpuScore) {
                        alert("おめでとうございます！あなたの勝ちです。\nPlayerスコア: " + score + "点  最高(Player)スコア: " + highestScore + "点　\nCPUスコア: " + cpuScore + "点");
                        } else if (cpuScore > score) {
                        alert("残念！CPUの勝ちです。\nPlayerスコア: " + score + "点  最高(Player)スコア: " + highestScore + "点　\nCPUスコア: " + cpuScore + "点");
                        } else {
                        alert("引き分けです。\nPlayerスコア: " + score + "点  最高(Player)スコア: " + highestScore + "点　\nCPUスコア: " + cpuScore + "点");
                            }
                        

                        initializeGame();
                        cpuScore = 0; // CPUのスコアをリセット
                        cpuScoreDisplay.innerText = cpuScore; // CPUのスコア表示をリセット
                        gameStarted = false;
                        document.getElementById("resetButton").style.display = "none";
                        document.getElementById("startButton").style.display = "block";
                    }, 300);
                }
            }, 1000);

            document.getElementById("resetButton").style.display = "block";
            document.getElementById("startButton").style.display = "none";
        }

        function startCPU(cpuInterval) {
            const cpuIntervalId = setInterval(() => {
                if (gameStarted) {
                    simulateCPUMoleClick();
                } else {
                    clearInterval(cpuIntervalId);
                }
            }, cpuInterval);
        }

        function simulateCPUMoleClick() {
            const holes = document.querySelectorAll(".hole");
            const randomHoleIndex = Math.floor(Math.random() * holeCount);
            const randomHole = holes[randomHoleIndex];

            if (gameStarted && randomHole.querySelector(".mole").style.display === "block") {
                randomHole.querySelector(".mole").style.display = "none";
                cpuScore++;
                cpuScoreDisplay.innerText = cpuScore;
                // if (cpuScore > highestScore) {
                //     highestScore = cpuScore;
                // }
            }
        }

        function resetGame() {
            clearInterval(gameInterval);
            clearInterval(countdownInterval);
            initializeGame();
            cpuScore = 0; // CPUのスコアをリセット
            cpuScoreDisplay.innerText = cpuScore; // CPUのスコア表示をリセット
            gameStarted = false;
            document.getElementById("resetButton").style.display = "none";
            document.getElementById("startButton").style.display = "block";
        }

        const startButton = document.getElementById("startButton");
        startButton.addEventListener("click", startGame);

        const resetButton = document.getElementById("resetButton");
        resetButton.addEventListener("click", resetGame);

        initializeGame();

    </script>
</body>
<a href="index.php">タイトルへ</a>
<?php
$score = array_map('str_getcsv', file('mogscore.csv'));
usort($score, function ($a, $b) {
    return $b[1] - $a[1]; // スコアで降順にソート
});

echo "<h2>トップ5のスコア</h2>";
echo "<h3><ol>";
for ($i = 0; $i < min(count($score), 5); $i++) {
    echo "<li>{$score[$i][0]} - スコア: {$score[$i][1]} - 日時: {$lines[$i][2]}</li>";
}
echo "</ol></h3>";
?>

</html>
