<?php

session_cache_limiter('private_no_expire');
session_start();

require_once('general_user_log_status.php');
    

/*現在地の緯度経度情報を代入*/
$lat = $_GET['lat'];
$lon = $_GET['lon'];

/*本のタイトルを代入*/
$book_title = $_GET['book_title'];

        
/*DB接続*/    
require_once('db_connect.php');

/*SQL*/           
     try{
         
         $sql =
         
        "SELECT 
         
         book_title, author, price, publisher, publish_date, page, stock, isbn_13, img, update_time, store_id, K.store_name AS store_name, K.address AS address, K.tel AS tel, K.store_email AS store_email, ROUND((6371 * acos(cos(radians(:latitude)) * cos(radians(K.latitude)) * cos(radians(K.longitude) - radians(:longitude)) + sin(radians(:latitude)) * sin(radians(K.latitude)))),1) AS distance
         
         FROM stock
         JOIN book_store AS K
         ON stock.store_id = K.id
         WHERE book_title = :book_title
         ORDER BY distance
         
         LIMIT 6"; 
        
         $stmt = $pdo->prepare($sql);
         $stmt->bindValue(':book_title', $book_title, PDO::PARAM_STR);
         $stmt->bindValue(':latitude', $lat);
         $stmt->bindValue(':longitude', $lon);
         $stmt->execute();
         $count = $stmt->rowCount();
         print '検索結果は'.$count.'件です。';
         
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC434MBbhe6MuEUVmTwJsCnp-jwL7grBYI&callback=initMap" async defer></script>
    
    <script>
        $(document).ready(function(){
            
    /*SELECT BOXのためのコード*/          
            
  // プルダウン変更時に遷移
          $('select[name=pulldown1]').change(function() {
            if ($(this).val() != '') {
              window.location.href = $(this).val();
            }
          });
            
            
        });
    </script>
    
</head>
<body>

    
    <select name="pulldown1">
        <option value="">並べ替え</option>
        <option value="geo2.distance.php?book_title=<?= $book_title ?>&lat=<?= $lat ?>&lon=<?= $lon ?>&author=<?= $_GET['author'] ?>&price=<?= $_GET['price'] ?>&publish_date=<?= $_GET['publish_date'] ?>&img=<?= $_GET['img'] ?>">距離が近い順</option>
        <option value="geo2.stock.php?book_title=<?= $book_title ?>&lat=<?= $lat ?>&lon=<?= $lon ?>&author=<?= $_GET['author'] ?>&price=<?= $_GET['price'] ?>&publish_date=<?= $_GET['publish_date'] ?>&img=<?= $_GET['img'] ?>">在庫がある本屋のみ</option>
        
    </select>

   <div id="list_wrap">
              
               <div id="left">
                   <ul>

                       <li><img src="/doc/<?= e($_GET['img']) ?>" width="160" height="160"></li>
                    
                   </ul>
               </div>
               
               <div id="right">
                  <ul>
                      <li>タイトル: <?= e($book_title) ?></li>
                      <li>著者:   <a href="author.php?author=<?= e($_GET['author']) ?>"><?= e($_GET['author']) ?></a></li>
                      <li>価格:   <?= e($_GET['price']) ?> 円（税込）</li>
                      <li>発売日:  <?= e($_GET['publish_date']) ?></li>
                      
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
                       <li>現在地からの距離: 約 <?= e($row['distance']) ?> km</li>
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
                      
                      
                    <?php
                      }
                     ?>

                   
           
               </div>  
           </td>

       </tr>

       
       
   </table>
   
<?php
                
        }
    
?>
    
</body>
</html>    
