<?php

session_start();

include('include.php');

$email = $_POST['email'];
$password = $_POST['password'];


/*DB接続*/
require_once('db_connect.php');

try{
    
    $sql = "SELECT *
            FROM general_user
            WHERE email = :email";
    
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':email', $email, PDO::PARAM_STR);
    $stmh->execute();

    
}catch(PDOException $r){
    
    exit ('error'.$r->getMessage());
}

/*SQLで取得したデータを配列に格納*/
$row = $stmh->fetch();

$password_match = password_verify($password, $row['password']);

/*メールアドレスおよびパスワードが一致しているかを確認*/
if($row['email'] !== $email){
    
    print 'メールアドレスが違います';
    exit;
    
}else if(!$password_match){
    
    print 'パスワードが違います';
    exit;
    
/*確認OKならSESSIONに値を代入*/    
}else{

  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["user_id"] = $row['id'];
  $_SESSION["general_user_name"] = $row['general_user_name'];
  $_SESSION["address"] = $row['address'];
  $_SESSION["user_email"] = $row['email'];
  $_SESSION["gender"] = $row['gender'];
  $_SESSION["password"] = $row['password'];
  $_SESSION["age"] = $row['age'];
    
  header("Location: /index.php");
    
}

?>
