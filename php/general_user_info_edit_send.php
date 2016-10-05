<?php

session_start();

include('include.php');

$id = $_SESSION['user_id'];
$user_name = $_POST['user_name'];
$address = $_POST['address'];
$email = $_POST['email'];
$password = $_POST['password'];

if($_POST['email']){
    
     /* 取得したメールアドレス宛にメールを送信 */
        mb_language("japanese");
        mb_internal_encoding("utf-8");

        $to = $_POST['email'];
        $subject = "ユーザー情報更新確認メール";
        $message = "以下のURLをクリックし、ユーザー情報更新を完了して下さい。\n".
        "http://localhost/stockin/php/general_user_info_edit_final.php?id=$id&user_name=$user_name&address=$address&email=$email&password=$password";
    
        $header = "From:skepticalman2005@yahoo.co.jp";
        
        $send = mb_send_mail($to, $subject, $message, $header);
    if($send){
        
        print '下記送信先に確認用のメールを送信しましたのでご確認下さい。<br>';
        print 'メール送信先：'. e($_POST['email']);
        
             
    }else{
        
        exit('メールが送信できませんでした。');
    }
        
 
    }



?>