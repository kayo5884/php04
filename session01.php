<?php
// SESSIONスタート
session_start();

// SESSIONのidを取得
$sid = session_id();
echo $sid;

//session変数
// SESSION変数にデータを登録
$_SESSION["name"] = "小林";
$_SESSION["age"] = '27';
$_SESSION["from"] = 'kyoto';

?>