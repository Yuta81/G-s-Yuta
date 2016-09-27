<?php

include("include.php");


if($_GET['store_name']){
    
    $store_name = $_GET['store_name'];
    
}


/* データベース接続設定 */
require_once("db_connect.php");

try{
    
    $sql = "SELECT *
    
            FROM book_store
            
            WHERE store_name = :store_name";
    
$stmh = $pdo->prepare($sql);
$stmh->bindValue(':store_name', $store_name, PDO::PARAM_STR);
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
    <link rel="stylesheet" href="/css/search_result.css">
    <link rel="stylesheet" href="/css/reset.css">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>

  <table border="1">

<?php
        
    $row = $stmh->fetch(PDO::FETCH_ASSOC);         
           var_dump($row['address']);
?>

  <tr>
      <th>店名</th>
      <td><?= e($row['store_name']) ?></td>
  </tr>
  
  <tr>
      
      <th>住所</th>
      <td><?= e($row['address']) ?></td>
      
  </tr>
          
  <tr>
      <th>TEL</th>
      <td><?= e($row['tel']) ?></td>
  </tr>
          
 <tr>
     <th>営業時間</th>
     <td><?= e($row['operation_time']) ?></td>
 </tr>
          
 <tr>
     <th>定休日</th>
     <td><?= e($row['operation_day']) ?></td>
 </tr>
          
 <tr>
     <th>お支払い方法</th>
     <td><?= e($row['payment']) ?></td>
 </tr>
          
 <tr>
     <th>アクセス</th>
     <td><?= e($row['access']) ?></td>
 </tr>
          
 <tr>
     <th>地図</th>
     <td>
        <iframe
            width="315"
            height="315"
            frameborder="0" style="border:0"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyC434MBbhe6MuEUVmTwJsCnp-jwL7grBYI
            &q=<?= e($row['address']) ?>" allowfullscreen>
        </iframe>
     </td>
 </tr>
           
 </table>
</body>
</html>
