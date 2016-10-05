<?php


include('include.php');

$id = $_GET['id'];

/*DB接続*/    
require_once('db_connect.php');

/*SQL(ユーザー情報の更新を実行)*/

try{
    
    $sql = "UPDATE general_user
            SET general_user_name = :general_user_name, address = :address, email = :email, password = :password
            
            WHERE id = :id";
    
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':id', $id, PDO::PARAM_INT);
    $stmh->bindValue(':general_user_name', $_GET['user_name'], PDO::PARAM_STR);
    $stmh->bindValue(':address', $_GET['address'], PDO::PARAM_STR);
    $stmh->bindValue(':email', $_GET['email'], PDO::PARAM_STR);
    $stmh->bindValue(':password', password_hash($_GET['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmh->execute();
    
    if($stmh == true){
        
        mb_language("japanese");
        mb_internal_encoding("utf-8");

        $to = $_GET['email'];
        $subject = "ユーザー情報更新完了のお知らせ";
        $message = "ユーザー情報更新完了しました！\n\n".
            
        "新しいユーザー名：".$_GET['user_name']."\n".
        "新しい住所：".$_GET['address']."\n".
        "新しいメールアドレス：".$_GET['email']."\n".
        "新しいパスワード：".$_GET['password']."\n".
        "トップページ http://localhost/stockin/php/index.php";
    
        $header = "From:skepticalman2005@yahoo.co.jp";
        
        $send = mb_send_mail($to, $subject, $message, $header);
        
    }
        
    if($send){
        
        print '下記送信先に確認用のメールを送信しましたのでご確認下さい。<br>';
        print 'メール送信先：'. e($_GET['email']);
        header("Location: general_user_logout.php");
    }
    
}catch(PDOException $r){
        print "エラー".$r->getMessage();
    }

?>