// main.js
'use strict';

document.addEventListener('DOMContentLoaded', () => {
  // Cardクラス作成
  class Card {
    constructor(suit, num) {
      // カードのスート(s:スペード、d:ダイヤ...)
      this.suit = suit;
      // カードの数字(1,2,...13)
      this.num = num;
      // カードの画像
      this.front = `${suit}${num < 10 ? '0' : ''}${num}.gif`;
    }
  }

  // カード配列作成
  const cards = [];
  // カードスーツ配列
  const suits = ['s', 'd', 'h', 'c'];
  // 2重forで52枚のカードを作成
  for (let i = 0; i < suits.length; i++) {
    for (let j = 1; j <= 13; j++) {
      // カードインスタンス生成(s1,s2....c13)
      let card = new Card(suits[i], j);
      // 配列の末尾に追加
      cards.push(card);
    }
  }
  let firstCard = null; // 1枚目のカードを保持(引いてない場合はnull)
  let secondCard = null; // 2枚目のカードを保持(引いてない場合はnull)
  let currentPlayer = 'player'; // 現在のプレイヤーを保持（'player'または'AI'）

  // クリックした際の関数を定義
  const flip = (eve) => {
    // クリックされた要素を特定
    let div = eve.target;

    // toggle(ついていたら外れ、外れていたら付く)
    if (!div.classList.contains('back') || secondCard !== null || currentPlayer === 'AI') {
      return;
    }

    // 表面のカードや3枚目のカードをクリックしても何も起こらない。
    if (!div.classList.contains('back') || secondCard !== null || currentPlayer === 'AI') {
      return;
    }

    // 表面にする
    div.classList.remove('back');

    // もしそれが1枚目だったらfirstCardに代入
    if (firstCard === null) {
      firstCard = div;
    } else {
      // 2枚目だったらsecondCardに代入
      secondCard = div;
      // 2枚のカードの数字が同じかチェック
      checkMatch();
    }
  };

  // カードが一致したかどうかをチェックする関数
  const checkMatch = () => {
    if (firstCard && secondCard) {
      if (firstCard.num === secondCard.num) {
        // 一致した場合
        firstCard.classList.add('fadeout');
        secondCard.classList.add('fadeout');
        [firstCard, secondCard] = [null, null];
        setTimeout(() => {
          // 同じプレイヤーのターンを続ける
          if (currentPlayer === 'player') {
            // プレイヤーのターン
            return;
          } else {
            // AIのターン
            playAITurn();
          }
        }, 1000); // カードが消えるまでの待ち時間（1秒）
      } else {
        // 一致しない場合
        setTimeout(() => {
          firstCard.classList.add('back');
          secondCard.classList.add('back');
          [firstCard, secondCard] = [null, null];
          // プレイヤーとAIを交代
          togglePlayer();
          if (currentPlayer === 'AI') {
            // AIのターン
            playAITurn();
          }
        }, 1200); // カードを裏返すまでの待ち時間（1.2秒）
      }
    }
  };

  // cardgridのDOM取得
  const cardgrid = document.getElementById('cardgrid');

  // gridを初期化する処理
  const initgrid = () => {
    // cardgridに入っている要素をすべて削除
    cardgrid.textContent = null;
    for (let i = 0; i < suits.length; i++) {
      for (let j = 0; j < 13; j++) {
        // １枚毎のトランプとなるdiv要素作成
        let div = document.createElement('div');
        // 配列からcardを取り出す
        let card = cards[i * 13 + j];
        // 背景画像に画像を設定
        div.style.backgroundImage = `url(images/${card.front})`;
        // divにcardクラスとbackクラス追加
        div.classList.add('card', 'back');
        // 要素をクリックした際の挙動を登録
        div.onclick = flip;
        // divにnumプロパティを定義して、そこに数字を保存
        div.num = card.num;
        // cardgrid要素に追加
        cardgrid.append(div);
      }
    }
  };

  // カードシャッフル関数(Fisher–Yates shuffle)
  const shuffle = () => {
    let i = cards.length;
    while (i) {
      let index = Math.floor(Math.random() * i--);
      [cards[index], cards[i]] = [cards[i], cards[index]];
    }
  };

  // プレイヤーのターンかAIのターンかを切り替える関数
  const togglePlayer = () => {
    currentPlayer = currentPlayer === 'player' ? 'AI' : 'player';
  };

  // AIのターンを実行する関数
  const playAITurn = () => {
    // AIはランダムにカードを選び、未選択の裏返しカードをクリックする
    const backCards = Array.from(document.querySelectorAll('.b ack'));
    const randomIndex = Math.floor(Math.random() * backCards.length);
    const aiCard = backCards[randomIndex];
    
    // カードを自動的にめくる（タイマーを使用して一時停止を追加）
    setTimeout(() => {
      flip({ target: aiCard });
    }, 1000); // 1秒後にカードをめくる（適切な遅延時間を設定）
  };

  // ボタンのDOM取得
  const startBt = document.getElementById('startBt');

  // ボタンを押したときの処理
  startBt.addEventListener('click', () => {
    shuffle();
    initgrid();
    currentPlayer = 'player'; // 最初はプレイヤーから始まる
    [firstCard, secondCard] = [null, null];
    // AIの最初のターン
    playAITurn();
  });
});
