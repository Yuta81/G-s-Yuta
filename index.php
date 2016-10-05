

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
            $.post("php/autocomp_for_book.php", {book_name : search_val}, function(data){
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
if($_SESSION){
    
?>

 <p><a href="php/general_user_info.php?user=<?= e($_SESSION['general_user_name']) ?>"><?= e($_SESSION['general_user_name']) ?></a>さん（ログイン中）<a href="general_user_logout.php"><button>ログアウト</button></a></p>
 

<?php
        
}else{
    
?>
   
   <a href="php/general_user_login.php"><button>ログイン</button></a>
   <a href="php/email_register.php"><button>会員登録</button></a>
   
<?php
   
   }
    
?>
   
   <form action="php/book_select.php" method="post">
       
       <p>本の検索</p> 
       
       <input type="text" name="book_name" id="book_name">
       <input type="submit" value="検索">
       
       
       
   </form>
  
    
</body>
</html>
