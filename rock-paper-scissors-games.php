<?php
echo "じゃんけんを作成しよう！".PHP_EOL;
// *じゃんけん用の定数を準備
const STONE = 0;
const SCISSORS = 1;
const PAPER = 2;
const YES = "はい";
const NO = "いいえ";
// *じゃんけんの手を配列に格納
const HAND_TYPE = array(
    STONE => 'グー',
    SCISSORS => 'チョキ',
    PAPER => 'パー',
);
// *じゃんけんの結果を配列に格納
const RESULT = array("引き分け","あなたの負け","あなたの勝ち");
// *じゃんけん処理スタート
main();

// *じゃんけんの処理をするmain関数を追加
function main(){
    // じゃんけんの手を入力するように出力
    echo "じゃんけんをします！".PHP_EOL;
    echo "グー、チョキ、パーのいずれかを入力してください。".PHP_EOL;
    // ユーザーのじゃんけんの値を受け取る
    $user_rock_paper_scissors = getValue("game");
    // コンピュータのじゃんけんの値を受け取る
    $comp_rock_paper_scissors = compGetValue();
    // 受け取ったじゃんけんの手を元にゲーム開始して結果を代入
    $result = judge($user_rock_paper_scissors,$comp_rock_paper_scissors);
    // *それぞれの値をshow関数に渡して結果を出力
    show($user_rock_paper_scissors,$comp_rock_paper_scissors,$result);
    // *引き分けならもう一回じゃんけんを行うように処理を追加
    if($result === 0){
        echo "もう一回！".PHP_EOL;
        return main();
    }
    // *終了後に、再度ゲームをやるかを確認し、その応答に応じて追加でゲームを行う
    return confirm();
}

// *じゃんけんの結果を出力するshow関数を追加
function show($user_rock_paper_scissors,$comp_rock_paper_scissors,$result){
    echo "あなたの手：".HAND_TYPE[$user_rock_paper_scissors].PHP_EOL;
    echo "コンピュータの手：".HAND_TYPE[$comp_rock_paper_scissors].PHP_EOL;
    echo "勝負の結果：".RESULT[$result].PHP_EOL;
}

// もう一度ゲームをやるか確認する関数を追加
function confirm(){
    echo "もう一度じゃんけんをしますか？".PHP_EOL;
    echo "はい、いいえのいずれかを入力してください。".PHP_EOL;
    // ユーザーの入力値を受け取る
    $answer = getValue("more");
    if($answer === YES){
        // もし「はい」を選んだらもう一度main処理を開始する
        return main();
    }
    return;
}

// じゃんけんの値を受け取るgetValue関数
function getValue($type){
    // 入力値を$inputに代入
    $input = input();

    // *じゃんけんの入力で問題なければ該当のキーをreturn
    if($type === "game"){
        // 入力値のバリデーションチェックをして問題なければ受け取った値を返す
        if(handsCheck($input) === false){
            // *問題があれば再帰
            return getValue($type);
        }

        return array_search($input, HAND_TYPE);
    }
    // *じゃんけんの入力で問題なければ該当の値をreturn
    if($type === "more"){
        // 入力値のバリデーションチェックをして問題なければ受け取った値を返す
        if(moreCheck($input) === false){
            // *問題があれば再帰
            return getValue($type);
        }

        return $input;
    }
}


// 入力用input関数
function input(){
    return trim(fgets(STDIN));
}

// バリデーション用check関数
function handsCheck($input){
    if (empty($input)) {
        // 値がnullだった場合エラーメッセージを出力しfalseをreturn
        echo "値が空です。".PHP_EOL;
        return false;
    }

    // *if文の条件を定数を使う形に変更
    if (!in_array($input, HAND_TYPE)) {
        // 値がじゃんけんの値ではない場合エラーメッセージを出力しfalseをreturn
        echo "入力できる値はグー、チョキ、パーです。".PHP_EOL;
        return false;
    }

    // チェックに問題なければtrueを返す
    return true;
}

function moreCheck($input){
    if (empty($input)) {
        // 値がnullだった場合エラーメッセージを出力しfalseをreturn
        echo "値が空です。".PHP_EOL;
        return false;
    }

    // *もう一度ゲームをするかの確認用
    if (!($input === YES || $input === NO)) {
        // 値がはい、いいえではない場合エラーメッセージを出力しfalseをreturn
        echo "入力できる値ははいまたはいいえです。".PHP_EOL;
        return false;
        }

    // チェックに問題なければtrueを返す
    return true;
}

// じゃんけん勝負をするjudge関数(*名前および処理の中身を変更)
function judge($user_rock_paper_scissors,$comp_rock_paper_scissors){
    // じゃんけん勝負を実施
    return ($user_rock_paper_scissors - $comp_rock_paper_scissors + 3) % 3;
}

// コンピュータのじゃんけんの値を決めるcompGetValue関数
function compGetValue(){
    // *じゃんけんの値をランダムで取り出してreturn
    return array_rand(HAND_TYPE, 1);;
}
?>
