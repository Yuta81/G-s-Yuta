<?php

    $db_user = 'b60ae5b716dd01';
    $db_pass = 'd3e554b7';
    $db_host = 'us-cdbr-iron-east-04.cleardb.net';
    $db_name = 'heroku_43b33c2f7cca19e';
    $db_type = 'mysql';
    
    $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";
    
    try{
        $pdo = new PDO($dsn, $db_user, $db_pass);
        
    }catch(PDOException $r){
        
        print 'error'.$r->getMessage();
    }

?>
