<?php

include('include.php');

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
   
<?php

if($_SESSION){
    
?>

 <p><a href="general_user_info.php?user=<?= e($_SESSION['general_user_name']) ?>"><?= e($_SESSION['general_user_name']) ?></a>さん（ログイン中）<a href="general_user_logout.php"><button>ログアウト</button></a></p>
 

<?php
        
}else{
    
?>
   
   <a href="general_user_login.php"><button>ログイン</button></a>
   <a href="email_register.php"><button>会員登録</button></a>
   
<?php
   
   }
    
?>
    
</body>
</html>


