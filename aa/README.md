# 4択クイズを作ろう (プログラミング演習(PHP)特別課題, 提出期限：7月31日(月))

課題の詳細はGoogle Classroomの資料を参照すること。

## 事前準備
課題に取り組む前に、以下の準備が必要です。

1. quizデータベースの作成

### quizデータベースの作成手順
1. http://localhost/quiz/_dbInitialize.php にアクセスする。
1. データベースの初期化に成功したらあらためて http://localhost/quiz にアクセスする。<br>メニュー画面が表示されることを確認する。

## 注意事項
スクリプトの動作確認は Live Serverを使わないこと。PHPスクリプトの場合、中途半場にでき上がった状態で保存(Ctrl+S)すると、リロードでスクリプトが実行されてしまい意図しない結果を生じる場合がある。

デバッグ中は Apacheと MariaDB(MySQL)を起動しておき、http://localhost/quiz/index.php にアクセスする。スクリプトを直したら<b>手動で</b>リロードすること。

## ファイル構成
- _check.html (ジャンクション設定確認用ページ)
- _dbInitialize.php (データベース初期化ページ)
- dbConfig.php (データベース設定ファイル)
- questions.csv (データベースのシードファイル)
- README.md (プロジェクトの説明ファイル(このファイル))
- index.php (アプリケーションのトップページ(要修正))
- cssフォルダ (CSSの格納用)
- jsフォルダ (JavaScriptの格納用)

これ以外のファイル、フォルダの作成は任意です。