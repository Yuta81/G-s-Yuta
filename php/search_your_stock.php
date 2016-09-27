<?php

session_start();


//DB接続

try{
    $search_key = '%'.$_POST['search_key'].'%';
    
    $db_user = 'root';
    $db_pass = 'yuta81bb';
    $db_host = 'localhost';
    $db_name = 'stokin_db';
    $db_type = 'mysql';
    
    $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";
    $pdo = new PDO($dsn, $db_user, $db_pass);
     
    $sql = "SELECT book_title, author, publisher, publish_date, price, stock, update_time 
            FROM stock 
            WHERE store_id = :store_id AND (book_title LIKE :book_title OR author LIKE :author)";

    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':store_id', $_SESSION['login_id'], PDO::PARAM_INT);
    $stmh->bindValue(':book_title', $search_key, PDO::PARAM_STR);
    $stmh->bindValue(':author', $search_key, PDO::PARAM_STR);

    $stmh->execute();
    
      
}catch(PDOException $e){
    
    print 'error'.$e->getMessage();
    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/your_stock.css">
</head>
<body>
   <h1><?=htmlspecialchars($_SESSION['user_name'])?>の在庫状況</h1>
   <form action="your_stock.php" method="post">
       <input type="text" name="search_key">
       <input type="submit" value="検索"　>
   </form>
   <br>
   <form action="your_stock.php">
       <input type="submit" value="在庫全表示に戻る">
   </form>
   <br>
   <form action="store_logout.php" method="post">
      
       <input type="submit" value="ログアウト">
       
  </form>
   <br><br>
   
   <table>
      <tr>
       
         <th>本のタイトル</th>
         <th>著者</th>
         <th>出版社</th>
         <th>出版日</th>
         <th>価格（税込）</th>
         <th>在庫</th>
         <th>最終更新日</th>
         
       </tr>
       
      
<?php
        while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
?>
      
      
       
       <tr>
           <td><?=htmlspecialchars($row['book_title'])?></td>
           <td><?=htmlspecialchars($row['author'])?></td>
           <td><?=htmlspecialchars($row['publisher'])?></td>
           <td><?=htmlspecialchars($row['publish_date'])?></td>
           <td class="left"><?=htmlspecialchars($row['price'])?>円</td>
           <td class="left"><?=htmlspecialchars($row['stock'])?></td>
           <td><?=htmlspecialchars($row['update_time'])?></td>
       </tr>
<?php
        }
?>
       
       
   </table>
   

    
</body>
</html>
