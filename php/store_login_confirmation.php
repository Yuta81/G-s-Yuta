<?php

session_start();

/*DB接続*/
require_once('db_connect.php');
    


try{
        $sql = "SELECT * FROM store_user WHERE login_id = :login_id";
        
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':login_id', $_POST['login_id'], PDO::PARAM_INT);
        $stmh->execute();
        
}catch(PDOException $r){
    
    exit ('error'.$r->getMessage());
}

//３．抽出データ数を取得
$row = $stmh->fetch(); //1レコードだけ取得する方法

$login_flg = password_verify($_POST['login_pass'], $row['login_pass']);

if(!$login_flg){
    print 'パスワードが間違っています。';
    exit;
}

//４. 該当レコードがあればSESSIONに値を代入
if( $row["login_id"] != "" ){
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["store_user_name"] = $row['store_user_name'];
  $_SESSION["login_id"] = $row['login_id'];
  header("Location: pre_load_data_infile.php");
}else{
  //logout処理を経由して全画面へ
  header("Location: store_logout.php");
}

exit();

?>