<?php

include('include.php');

$author = $_GET['author'];

/*DB接続*/
require_once('db_connect.php');

/*SQL*/
try{
    
    $sql = "SELECT
    
            book_title, price, author, img, publish_date
            
            FROM book
            
            WHERE author = :author";
    
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':author', $author, PDO::PARAM_STR);
    $stmh->execute();
    $count = $stmh->rowCount();
    print $author.'の作品は'.$count.'件です。';
    
    
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
    
    <form action="author_select.php" method="post">
     <select name="author_select">
         <option value="keyword">キーワード関連順</option>
         <option value="publish_date_new">発売日が新しい順</option>
         <option value="publish_date_old">発売日が古い順</option>
         <option value="price_cheap">価格が安い順</option>
         <option value="price_high">価格が高い順</option>
         <input type="hidden" name="author" value="<?= e($row['author']) ?>">
         <input type="submit" value="並べ替える">
     </select>
       
   </form>
    
    <table>
    
<?php
        
    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){            
           
?>
       
       <tr>
       
           <td>
           
            <div id="list_wrap">
                  <div id="left">
                      <ul>

                       <li><img src="/doc/<?= e($row['img']) ?>" width="160" height="160"></li>

                      </ul>
                  </div>
                  
                  <div id="right">
                  <ul>
                      <li>タイトル: <?= e($row['book_title']) ?></li>
                      <li>著者:   <?= e($row['author']) ?></li>
                      <li>価格:   <?= e($row['price']) ?> 円（税込）</li>
                      <li>発行日:  <?= e($row['publish_date']) ?></li>
                      <li>
                          <form action="geo2.php" method="post">
                              <input type="submit" value="現在地から距離順で書店を検索">
                              <input type="hidden" name="book_title" value="<?= e($row['book_title']) ?>">
                              <input type="hidden" name="lat" id="lat">
                              <input type="hidden" name="lon" id="lon">
                          </form>
                      </li> 
                      <li></li>
                      <li></li>
                      <li>
                          <form action="sta2.php" method="post">
                              <input type="text" name="station_name" id="station_name">
                              <input type="submit" value="駅名から検索" placeholder="駅名を入力">
                              <input type="hidden" name="book_title" value="<?= e($row['book_title']) ?>">
                          </form>
                      </li>
                      
                  </ul>
                   
               </div>
            </div>
           </td>
      </tr>  
</table>
      
<?php
               
    }

?>
    
</body>
</html>