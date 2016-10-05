<?php

session_start();

include('include.php');

/*DB接続*/    
require_once('db_connect.php');

/*SQL(ユーザー情報の削除を実行)*/

try{
    
    $sql = "DELETE 
    
            FROM general_user
            
            WHERE id = :id";
    
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmh->execute();
    
    if($stmh == true){
        
        header("Location:general_user_logout.php");
    }
    
    
}catch(PDOException $r){
        print "エラー".$r->getMessage();
}
    
?>