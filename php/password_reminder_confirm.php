<?php

include("include.php");

$email = $_POST['email'];


/*DB接続*/    
require_once('db_connect.php');

/*SQL*/ 

try{
    
    $sql = "SELECT email, password
    
            FROM general_user
            
            WHHERE email = :email";
    
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':email', $email, PDO::PARAM_STR);
    $stmh->execute();
    
    $row = $stmh->fetch();
    $password = $row['password'];
    
    if($stmh == true){
        
        mb_language("japanese");
        mb_internal_encoding("utf-8");

        $to = $email;
        $subject = "パスワードの通知";
        $message = "下記があなたのパスワードになります。\n".
        
            $password;
    
        $header = "From:skepticalman2005@yahoo.co.jp";
        
        $send = mb_send_mail($to, $subject, $message, $header);
    
    }
    
    if($send){
        
        print '下記アドレスにパスワード通知のメールを送信しましたのでご確認下さい。<br>';
        print 'メール送信先：'. $email;
        
             
    }else{
        
        exit('メールが送信できませんでした。');
    }
        
    
    
}catch(PDOException $r){
        print "エラー".$r->getMessage();
    }

?>