<?php

session_start();

include('include.php');

/*ログインしているかどうかの確認（未ログインの場合、ログインページに遷移）*/
if(!$_SESSION['general_user_name']){
    
    header('Location: general_user_login.php');
}

/*POSTされてきたデータの確認(不備があればEXIT)*/
if(!isset($_POST['store_email']) || $_POST['store_email']=="" ||
   !isset($_POST['store_name']) || $_POST['store_name']=="" ||
   !isset($_POST['stock']) || $_POST['stock']=="" ||
   !isset($_POST['book_title']) || $_POST['book_title']=="" ||
   !isset($_POST['isbn_13']) || $_POST['isbn_13']=="" ||
   !isset($_POST['author']) || $_POST['author']=="" ||
   !isset($_POST['store_id']) || $_POST['store_id']=="" ||
   !isset($_POST['price']) || $_POST['price']=="" ||
   !isset($_POST['update_time']) || $_POST['update_time']==""){
    
    exit('error!');
    
}
    
/*POSTされてきたデータの代入*/
$store_email =   $_POST['store_email'];
$store_name =    $_POST['store_name'];
$stock =         $_POST['stock'];
$book_title =    $_POST['book_title'];
$isbn_13 =       $_POST['isbn_13'];
$author =        $_POST['author'];
$store_id =      $_POST['store_id'];
$price =         $_POST['price'];
$update_time =   $_POST['update_time'];


/*DB接続*/
require_once('db_connect.php');


/*SQL*/
try{
    
  
$sql = "DELETE FROM notice WHERE user_id = :user_id AND isbn_13 = :isbn_13 AND store_id = :store_id;

       INSERT INTO notice

       (user_id, user_email, isbn_13, store_id, stock)
       
       VALUES
       
       (:user_id, :user_email, :isbn_13, :store_id, :stock)";

$stmh = $pdo->prepare($sql);
$stmh->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmh->bindValue(':user_email', $_SESSION['user_email'], PDO::PARAM_STR);
$stmh->bindValue(':isbn_13', $isbn_13, PDO::PARAM_STR);
$stmh->bindValue(':store_id', $store_id, PDO::PARAM_INT);
$stmh->bindValue(':stock', $stock, PDO::PARAM_INT);
$result = $stmh->execute();
    
}catch(PDOException $e){
    
    print "error". $e->getMessage();
}

/*リクエスト情報をDBに挿入できたら*/
if($result == true){
    
    header("Location: stock_search.php");
    
}


/*お店に在庫リクエストをメールで知らせる*/
if($store_email && $isbn_13){
        
        /* 取得したメールアドレス宛にメールを送信 */
        mb_language("japanese");
        mb_internal_encoding("utf-8");

        $to = $store_email;
        $subject = "在庫通知リクエスト(To:". $store_name.")";
        $message = "下記ユーザーより在庫通知リクエストがありました。\n\n".
            "■■ユーザー情報■■\n".
            "ユーザー名：". $_SESSION['user_name']."\n".
            "住所：". $_SESSION['address']. "\n".
            "性別：". $_SESSION['gender']. "\n".
            "年齢：". $_SESSION['age']. "\n".
            "\n".
            
            "■■在庫リクエスト■■\n".
            "本のタイトル：". $book_title. "\n".
            "著者：". $author ."\n".
            "ISBN-13：". $isbn_13. "\n".
            "在庫：". $stock. "\n".
            "前回在庫情報更新日時：". $update_time. "\n";
        $header = "From:skepticalman2005@yahoo.co.jp";
        
        $send = mb_send_mail($to, $subject, $message, $header);
        
 
    }else if(!$send) {  
        
        exit("リクエストが送信できませんでした。");
        
    }


    
?>