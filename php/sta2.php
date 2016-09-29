 <?php

session_start();

// mb_language("Japanese");
// mb_internal_encoding("UTF-8");
// mb_http_output("UTF-8");

include('include.php');


/*本のタイトルを代入*/
$book_title = $_POST['book_title'];


/*入力された駅名を代入*/
$station_name = $_POST['station_name'];

        
/*DB接続*/    
require_once('db_connect.php');
    

/*SQL*/           
     try{
         
         $sql2 = 
             
         "SELECT 
         
         station_name,book_store.store_email AS store_email, book_store.latitude AS lat, stock.book_title AS book_title, stock.isbn_13 AS isbn_13, stock.store_id AS store_id, stock.author AS author, stock.price AS price, stock.publisher AS publisher, stock.publish_date AS publish_date, stock.page AS page, stock.stock AS stock, stock.img AS img, stock.update_time AS update_time, book_store.store_name AS store_name, book_store.address AS address, book_store.tel AS tel, ROUND((6371 * acos(cos(radians(book_store.latitude)) * cos(radians(lat)) * cos(radians(lon) - radians(book_store.longitude)) + sin(radians(book_store.latitude)) * sin(radians(lat)))),1) AS distance
         
         FROM station
         INNER JOIN book_store
         ON station.join_id = book_store.join_id
         INNER JOIN stock
         ON book_store.id = stock.store_id
         WHERE station_name = :station_name AND book_title LIKE :book_title
         ORDER BY distance";
         

        
            $stmt = $pdo->prepare($sql2);
            $stmt->bindValue(':book_title', $book_title, PDO::PARAM_STR);
            $stmt->bindValue(':station_name', $station_name, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $count2 = $count - 1;
            print '検索結果は'.$count2.'件です。';
        
         
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

   <?php
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

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
                      <li>出版社:  <?= e($row['publisher']) ?></li>
                      <li>発行日:  <?= e($row['publish_date']) ?></li>
                      <li>ページ数:  <?= e($row['page']) ?></li>
                  </ul>
                   
               </div>
               
    </div>         
 
   
   <table>
       
      
<?php
        
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){            
           
?>
       
       <tr>
       
           <td>
           
            <div id="list_wrap">
                  <div id="left">
                      <ul>

                       <li>店名: 
                           <a href="each_store.php?store_name=<?= urlencode(e($row['store_name'])) ?>">
                               <?= e($row['store_name']) ?>
                           </a>
                       </li>
                       <li>住所: <?= e($row['address']) ?></li>
                       <li>TEL: <?= e($row['tel']) ?></li>
                       <li><?= e($row['station_name']) ?>駅からの距離: <?= e($row['distance']) ?> km</li>
                       <li>在庫数:  <?= e($row['stock']) ?> （最新更新日:<?= e($row['update_time']) ?>）</li>
                       
                      </ul>
                  </div>
                   
                  <div id="right">
                      <iframe
                          width="315"
                          height="93"
                          frameborder="0" style="border:0"
                          src="https://www.google.com/maps/embed/v1/place?key=AIzaSyC434MBbhe6MuEUVmTwJsCnp-jwL7grBYI
                            &q=<?= e($row['address']) ?>" allowfullscreen>
                      </iframe>
                  </div>
                   
                    <?php
                      
                      if($row['stock'] < 1){
                    ?>
                      <li>
                          <form action="notice.php" method="post">
                              <input type="hidden" name="store_email" value="<?= e($row['store_email']) ?>">
                              <input type="hidden" name="store_name" value="<?= e($row['store_name']) ?>">
                              <input type="hidden" name="stock" value="<?= e($row['stock']) ?>">
                              <input type="hidden" name="book_title" value="<?= e($row['book_title']) ?>">
                              <input type="hidden" name="isbn_13" value="<?= e($row['isbn_13']) ?>">
                              <input type="hidden" name="author" value="<?= e($row['author']) ?>">
                              <input type="hidden" name="store_id" value="<?= e($row['store_id']) ?>">
                              <input type="hidden" name="update_time" value="<?= e($row['update_time']) ?>">
                              <input type="hidden" name="price" value="<?= e($row['price']) ?>">
                              <input type="submit" value="在庫を入荷したらメールでの通知を希望する">
                          </form>
                      </li>
                      
                    <?php
                      }
                     ?>

                   </ul>
           
               </div>  
           </td>

       </tr>

       
       
   </table>
   
<?php
                
        }
    
?>
    
</body>
</html>
