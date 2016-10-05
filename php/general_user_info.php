<?php

session_start();

include('include.php');


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <title>ユーザー情報</title>
    
    <script>
        $(document).ready(function(){
            
            $('#delete').click(function(){
              if(!confirm('本当に退会されますか？')){
                  /* キャンセルの時の処理 */
                  return false;
            }else{
                 /*　OKの時の処理 */
                 location.href = 'general_user_info_delete.php';
    }
});
            
            
            });
    </script>
            
            
</head>
<body>
   
   <table border="1">
    
    
     <tr>
         <th>ユーザー名</th>
         <td><?= e($_SESSION['general_user_name'])?></td>
     </tr>
  
     
   
     <tr>
         <th>住所</th>
         <td><?= e($_SESSION['address'])?></td>
     </tr>
    
     
    
     <tr>
         <th>メールアドレス</th>
         <td><?= e($_SESSION['user_email'])?></td>
     </tr>
    
     
   
     <tr>
         <th>性別</th>
         <td><?= e($_SESSION['gender'])?></td>
     </tr>
   
     
   
     <tr>
         <th>年齢</th>
         <td><?= e($_SESSION['age'])?></td>
     </tr>
      
      
      <tr>
          <th>パスワード</th>
          <td></td>
      </tr>
       
   </table>
   <br>
   <br>
   
   
   <a href="general_user_info_edit.php"><button>編集する</button></a>
   <br>
   <br>
   <br>
   <br>
   
   <a href="general_user_info_delete.php" id="delete"><button>退会する</button></a>
   
    
    
</body>
</html>