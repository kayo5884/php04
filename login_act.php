<?php
//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値
$lid =$_POST['lid'];
$lpw =$_POST['lpw'];


//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//2. データ登録SQL作成
//暗号化されたパスワードを確認する機能はないので削除
$stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE lid=:lid');
//成功すればTRUE,失敗すればFALSEで帰ってくる
$stmt->bindValue(':lid',$lid, PDO::PARAM_STR);
//$stmt->bindValue(':lpw',$lpw, PDO::PARAM_STR); //* Hash化する場合はコメントする
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得する方法
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()

//5. 該当レコードがあればSESSIONに値を代入
//* if(password_verify($lpw, $val["lpw"])){
  //空っぽじゃなければ!!返す、$val['id']!=""
  //$val['lpw']がHASH化されたps
if( password_verify($lpw, $val['lpw'])){
  //Login成功時
  //ログイン処理とログインチェックは異なる！！これはログイン処理
  $_SESSION['chk_ssid']  = session_id();//SESSION変数にidを保存、クッキーに保存されているidが同じであれば接続
  $_SESSION['kanri_flg'] = $val['kanri_flg'];//SESSION変数に管理者権限のflagを保存
  $_SESSION['name']      = $val['name'];//SESSION変数にnameを保存
  redirect('select.php');
}else{
  //Login失敗時(Logout経由)、存在しないユーザーや間違っている人
  redirect('login.php');
}

exit();


