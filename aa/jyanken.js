const choices = document.querySelectorAll('.choice');
const result = document.getElementById('result');
let computerChoice;

const setComputerChoice = () => {
    const randomNumber = Math.floor(Math.random() * 3);
    const computerChoices = ['rock', 'paper', 'scissors'];
    computerChoice = computerChoices[randomNumber];
};

const getComputerChoice = () => {
    return computerChoice;
};

const getUserChoice = (userChoice) => {
    computerChoice = getComputerChoice();
    switch (userChoice + computerChoice) {
        case 'rockscissors':
        case 'paperrock':
        case 'scissorspaper':
            return '勝ち';
        case 'rockpaper':
        case 'paperscissors':
        case 'scissorsrock':
            return '負け';
        default:
            return '引き分け';
    }
};

const playGame = (userChoice) => {
    setComputerChoice();
    const computerChoice = getComputerChoice();
    const gameResult = getUserChoice(userChoice);

    u_img = document.getElementById('u_hand');
    c_img = document.getElementById('c_hand');

    // 選んだ手のイメージに変更する
    // u_img.setAttribute('src', 'paper.png');
    switch (userChoice) {
        case 'rock':
            // グーのとき
            u_hand_file = 'rock.png';
            break;
        case 'paper':
            // パーのとき
            u_hand_file = 'paper.png';
            break;
        case 'scissors':
            // チョキのとき
            u_hand_file = 'scissors.png';
            break;
        }
    switch (computerChoice) {
        case 'rock':
                // グーのとき
                c_hand_file = 'rock.png';
                break;
        case 'paper':
                // パーのとき
                c_hand_file = 'paper.png';
                break;
        case 'scissors':
                // チョキのとき
                c_hand_file = 'scissors.png';
                break;
            }
 
    u_img.setAttribute('src', u_hand_file);
    c_img.setAttribute('src', c_hand_file);

    // 手を大きく表示
    u_img.style.display = 'inline';
    c_img.style.display = 'inline';
    
    result.textContent = `コンピューターは${computerChoice}を選びました。`;

    if (gameResult === '勝ち') {
        result.style.color = 'green';
        result.textContent += ' あなたの勝ちです！';
    } else if (gameResult === '負け') {
        result.style.color = 'red';
        result.textContent += ' あなたの負けです。';
    } else {
        result.style.color = 'blue';
        result.textContent += ' 引き分けです。';
    }
};

choices.forEach(choice => {
    choice.addEventListener('click', () => {
        playGame(choice.id);
    });
});
