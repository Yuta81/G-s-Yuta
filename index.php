

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type='text/javascript'></script>
    
    <script>
        $(document).ready(function(){
            
/*現在地から本を検索のためのオートコンプリート*/
          $("#book_name").keyup(function(e){
            e.preventDefault();
            var search_val = $("#book_name").val();
            $.post("autocomp_for_book.php", {book_name : search_val}, function(data){
              if(data.length>0){
                $("#book_name").autocomplete({
                  source: data
                });
              }
            })
          });
        });
    </script>

</head>
<body>
  
  <?php
    
    require_once('general_user_log_status.php');
    
 ?>
   
   <form action="book_select.php" method="post">
       
       <p>本の検索</p> 
       
       <input type="text" name="book_name" id="book_name">
       <input type="submit" value="検索">
       
       
       
   </form>
  
    
</body>
</html>
