 <?php

session_start();

include('include.php');

/*入力内容に不備がないかの確認*/    
    if(!isset($_POST['search_term']) || $_POST['search_term'] == "" || 
       !isset($_POST['book_name']) || $_POST['book_name'] == ""){
    
        print '未入力の項目があります';
        exit;
        
    }

/*検索キーワードを代入*/
$book_search_key = '%'.$_POST['book_name'].'%';


/*入力された駅名を代入*/
$station_name = $_POST['search_term'];

        
/*DB接続*/    
require_once('db_connect.php');
    

/*SQL*/           
     try{
         
         $sql2 = 
             
         "SELECT 
         
         station_name,book_store.latitude AS lat, stock.book_title, stock.author, stock.price, stock.publisher, stock.publish_date, stock.page, stock.status, stock.stock, stock.img, stock.update_time, book_store.store_name, book_store.address, book_store.tel, ROUND((6371 * acos(cos(radians(book_store.latitude)) * cos(radians(lat)) * cos(radians(lon) - radians(book_store.longitude)) + sin(radians(book_store.latitude)) * sin(radians(lat)))),1) AS distance
         
         FROM station
         INNER JOIN book_store
         ON station.join_id = book_store.join_id
         INNER JOIN stock
         ON book_store.id = stock.store_id
         WHERE station_name = :station_name AND stock.book_title LIKE :book_title OR stock.author LIKE :author
         ORDER BY distance";
         

        
            $stmt = $pdo->prepare($sql2);
            $stmt->bindValue(':book_title', $book_search_key, PDO::PARAM_STR);
            $stmt->bindValue(':author', $book_search_key, PDO::PARAM_STR);
            $stmt->bindValue(':station_name', $station_name, PDO::PARAM_STR);
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
    <link rel="stylesheet" href="search_result.css">
    <link rel="stylesheet" href="reset.css">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>
 
   <?php
      
      if($_SESSION){
   ?>
     <header>
       <?= e($_SESSION['general_user_name']) ?>さん（ログイン中）
       
       <a href="general_user_logout.php"><button>ログアウト</button></a>
       
     </header>
       
    <?php
          
      }else{
          
    ?>
    
    <header>
      <a href="general_user_login.php"><button>ログイン</button></a>
      <a href="email_register.php"><button>会員登録</button></a>  
        
    </header>
    
    <?php
          
      }
    
    ?>


   
  
   
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
                           <a href="store.php?store_name=<?= e($row['store_name']) ?>">
                               <?= e($row['store_name']) ?>
                           </a>
                       </li>
                       <li><img src="/doc/<?= e($row['img']) ?>" width="160" height="160"></li>
                       <li>住所: <?= e($row['address']) ?></li>
                       <li>TEL: <?= e($row['tel']) ?></li>
                       <li><?= e($row['station_name']) ?>駅からの距離: <?= e($row['distance']) ?> km</li>

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
                      <li>状態:   <?= e($row['status']) ?></li>
                      <li>在庫数:  <?= e($row['stock']) ?> （最新更新日:<?= e($row['update_time']) ?>）</li>
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
