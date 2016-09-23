<?php

include('include.php');

$station_name = '%'.$_POST['station_name'].'%';

/*DB接続*/
require_once('db_connect.php');

/*SQL*/ 
try{
    
    $sql = "SELECT * 
        FROM station
        WHERE station_name LIKE :station_name";

$stmh = $pdo->prepare($sql);
$stmh->bindValue(':station_name', $station_name, PDO::PARAM_STR);
$stmh->execute();
    
}catch(PDOException $r){
        print "エラー".$r->getMessage();
    }


?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
   
   <table border='1'>
       
      
<?php
        
    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){            
           
?>
       
       <tr>
           <td><?= e($row['id']) ?></td>
           <td><?= e($row['post']) ?></td>
           <td><?= e($row['station_name']) ?></td>
        
       </tr>
       
<?php
               
    }
       
?>
    
    </table>
    

    
</body>
</html>