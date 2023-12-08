// オセロ盤を定義
let board = new Array(8).fill(null).map(() => new Array(8).fill(' '));
board[3][3] = '○';
board[3][4] = '●';
board[4][3] = '●';
board[4][4] = '○';

// プレイヤーを定義
let player = '●';
let CPU = '○';

// 移動が有効かどうかを確認する関数
function isValidMove(board, player, row, col) {
    if (board[row][col] !== ' ') {
        return false;
    }
    const directions = [
        [0, 1], [1, 0], [0, -1], [-1, 0],
        [1, 1], [1, -1], [-1, 1], [-1, -1]
    ];
    for (const [xdir, ydir] of directions) {
        let r = row + xdir;
        let c = col + ydir;
        if (r < 0 || r >= 8 || c < 0 || c >= 8) {
            continue;
        }
        if (board[r][c] === ' ' || board[r][c] === player) {
            continue;
        }
        r += xdir;
        c += ydir;
        while (r >= 0 && r < 8 && c >= 0 && c < 8) {
            if (board[r][c] === ' ') {
                break;
            }
            if (board[r][c] === player) {
                return true;
            }
            r += xdir;
            c += ydir;
        }
    }
    return false;
}

// 移動を行う関数
function makeMove(board, player, row, col) {
    if (!isValidMove(board, player, row, col)) {
        return false;
    }
    board[row][col] = player;
    const directions = [
        [0, 1], [1, 0], [0, -1], [-1, 0],
        [1, 1], [1, -1], [-1, 1], [-1, -1]
    ];
    for (const [xdir, ydir] of directions) {
        let r = row + xdir;
        let c = col + ydir;
        if (r < 0 || r >= 8 || c < 0 || c >= 8) {
            continue;
        }
        if (board[r][c] === ' ' || board[r][c] === player) {
            continue;
        }
        r += xdir;
        c += ydir;
        while (r >= 0 && r < 8 && c >= 0 && c < 8) {
            if (board[r][c] === ' ') {
                break;
            }
            if (board[r][c] === player) {
                while (true) {
                    r -= xdir;
                    c -= ydir;
                    if (r === row && c === col) {
                        break;
                    }
                    board[r][c] = player;
                }
                break;
            }
            r += xdir;
            c += ydir;
        }
    }
    return true;
}

// セルをクリックしたときの処理
function handleCellClick(row, col) {
    if (isValidMove(board, player, row, col)) {
        makeMove(board, player, row, col);
        // 他の処理を実行する
    }
}

// セルをクリックしたときのイベントリスナーを追加
for (let row = 0; row < 8; row++) {
    for (let col = 0; col < 8; col++) {
        const cell = document.querySelector(`[data-row="${row}"][data-col="${col}"]`);
        cell.addEventListener('click', () => handleCellClick(row, col));
    }
}


// プレイヤーが有効な移動を持っているか確認する関数
function hasValidMoves(board, player) {
    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
            if (isValidMove(board, player, row, col)) {
                return true;
            }
        }
    }
    return false;
}

// CPUの移動を取得する関数
function getCPUMove(board, CPU) {
    const validMoves = [];
    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
            if (isValidMove(board, CPU, row, col)) {
                validMoves.push([row, col]);
            }
        }
    }
    if (validMoves.length === 0) {
        return null; // CPUに有効な移動がない場合
    }
    // CPUにランダムに有効な移動を選択
    const randomIndex = Math.floor(Math.random() * validMoves.length);
    return validMoves[randomIndex];
}

// ゲームが終了したかどうかを確認する関数
function isGameOver(board, player, CPU) {
    return !hasValidMoves(board, player) && !hasValidMoves(board, CPU);
}

// メインのゲームループ
function main() {
    console.log('オセロゲーム！！');
    while (true) {
        // プレイヤーのターン
        console.log('Playerのターン');
        console.logBoard(board);
        const playerValidMoves = new Array(8).fill(null).map(() => new Array(8).fill(false));
        for (let row = 0; row < 8; row++) {
            for (let col = 0; col < 8; col++) {
                playerValidMoves[row][col] = isValidMove(board, player, row, col);
            }
        }
        if (playerValidMoves.flat().some(move => move)) {
            const [row, col] = getMove(board, player);
            makeMove(board, player, row, col);
            console.logBoard(board);
            const blackCount = board.flat().filter(piece => piece === '●').length;
            const whiteCount = board.flat().filter(piece => piece === '○').length;
            console.log('Playerのスコア: ', blackCount);
            console.log('CPUのスコア: ', whiteCount);
        } else {
            console.log('Player パス.');
        }

        // ゲームが終了したかどうかを確認
        if (isGameOver(board, player, CPU)) {
            console.log('ゲーム終了！！');
            console.log('最終スコア！！');

            const blackCount = board.flat().filter(piece => piece === '●').length;
            const whiteCount = board.flat().filter(piece => piece === '○').length;
            console.log('Playerの最終スコア！！', blackCount);
            console.log('CPUの最終スコア！！', whiteCount);
            if (blackCount > whiteCount) {
                console.log('Playerの勝利！！');
            } else if (whiteCount > blackCount) {
                console.log('CPUの勝利！！');
            } else {
                console.log('引き分け！！');
            }
            break;
        }

        // CPUのターン
        console.log('CPUのターン');
        const cpuMove = getCPUMove(board, CPU);
        if (cpuMove !== null) {
            const [row, col] = cpuMove;
            makeMove(board, CPU, row, col);
            console.logBoard(board);
            const blackCount = board.flat().filter(piece => piece === '●').length;
            const whiteCount = board.flat().filter(piece => piece === '○').length;
            console.log('Playerのスコア: ', blackCount);
            console.log('CPUのスコア: ', whiteCount);
        } else {
            console.log('CPU パス.');
        }

        // ゲームが終了したかどうかを確認
        if (isGameOver(board, player, CPU)) {
            console.log('ゲーム終了！！');
            console.log('最終スコア！！');

            const blackCount = board.flat().filter(piece => piece === '●').length;
            const whiteCount = board.flat().filter(piece => piece === '○').length;
            console.log('Playerの最終スコア！！', blackCount);
            console.log('CPUの最終スコア！！', whiteCount);
            if (blackCount > whiteCount) {
                console.log('Playerの勝利！！');
            } else if (whiteCount > blackCount) {
                console.log('CPUの勝利！！');
            } else {
                console.log('引き分け！！');
            }
            break;
        }
    }
}

// ウェブページが読み込まれたときに main 関数を実行する
window.addEventListener('load', main);