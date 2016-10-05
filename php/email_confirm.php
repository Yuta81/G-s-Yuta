<?php


//入力されたメールアドレスの情報を取得
$email = $_POST['email'];



/* メールアドレス入力チェック */
if($email == "") { 
    
    print 'メールアドレスを入力してください';
    
} else {
 //仮ユーザーIDの生成
 $pre_user_id = uniqid(rand(100,999));




//DB接続
require_once('db_connect.php');
    


//SQL文

try{
        
    $sql = "INSERT INTO pre_general_user(pre_user_id, email, regist_date)
            VALUES(:pre_user_id, :email, sysdate())";

    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':pre_user_id', $pre_user_id, PDO::PARAM_STR);
    $stmh->bindValue(':email', $email, PDO::PARAM_STR);
    $result = $stmh->execute();
    
/* データベース登録チェック */
    if($result == true){
        
        /* 取得したメールアドレス宛にメールを送信 */
//         mb_language("japanese");
//         mb_internal_encoding("utf-8");

        $to = $email;
        $subject = "会員登録URL送信メール";
        $message = "以下のURLより会員登録してください。\n".
        "https://jaiko.herokuapp.com/php/general_user_regist_form.php?pre_user_id=$pre_user_id";
        $header = "From:skepticalman2005@yahoo.co.jp";
        
        $send = mb_send_mail($to, $subject, $message, $header);
        
        print 'メール送信成功しました。<br>';
        print 'メール送信先：'. $email;
 
    }else if(!$send) {  
        
        print "メールが送信できませんでした。";
        
    }
    
    
}catch(PDOException $e){
    
    print 'error' . $e->getMessage();
}

}
    
?>   
