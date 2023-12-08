
// スコアの初期化
let score = 0;

// ボタンの要素を取得
const clickButton = document.getElementById('clickButton');
const resetButton = document.getElementById('resetButton'); // リセットボタンを追加

// スコア表示の要素を取得
const scoreDisplay = document.getElementById('score');

// ボタンがクリックされたときの処理
clickButton.addEventListener('click', () => {
    // スコアを増やす
    score++;
    // スコアを表示する
    scoreDisplay.textContent = score;
});

// リセットボタンがクリックされたときの処理
resetButton.addEventListener('click', () => {
    // スコアをリセット
    score = 0;
    // スコアを表示を更新
    scoreDisplay.textContent = score;
});

