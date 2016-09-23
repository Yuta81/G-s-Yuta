<?php

    $db_user = 'root';
    $db_pass = 'yuta81bb';
    $db_host = 'localhost';
    $db_name = 'stokin_db';
    $db_type = 'mysql';
    
    $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";
    
    try{
        $pdo = new PDO($dsn, $db_user, $db_pass);
        
    }catch(PDOException $r){
        
        print 'error'.$r->getMessage();
    }

?>