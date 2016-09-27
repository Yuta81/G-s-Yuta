<?php


if(!isset($_POST['login_id']) || $_POST['login_id'] == "" ||
   !isset($_POST['login_pass']) || $_POST['login_pass'] == "" ||
   !isset($_POST['login_pass_confirmation']) || $_POST['login_pass_confirmation'] == ""){
    
    exit('未入力の項目があります!');
}else if($_POST['login_pass'] <> $_POST['login_pass_confirmation']){
    exit('ログインPASSが確認用と一致しません!');
}



$db_user = 'root';
$db_pass = 'yuta81bb';
$db_host = 'localhost';
$db_name = 'stokin_db';
$db_type = 'mysql';

$dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";

try{
    $pdo = new PDO($dsn, $db_user, $db_pass);
}catch(PDOException $e){
    print 'db_connection error!'.$e->getMessage();
}


try{
    $sql = "INSERT INTO user(login_id, login_pass) VALUES(:login_id, :login_pass)";
    
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':login_id', $_POST['login_id'], PDO::PARAM_INT);
    $stmh->bindValue(':login_pass', password_hash($_POST['login_pass'], PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmh->execute();
    print '登録完了!';
}catch(PDOException $e){
    print 'error!'.$e->getMessage();
}


?>