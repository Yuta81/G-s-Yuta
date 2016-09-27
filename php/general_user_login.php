<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログインページ</title>
</head>
<body>
   
   <form action="general_user_login_act.php" method="post">
       
       ID(登録済メールアドレス):<input type="text" name="email" required>
       パスワード:<input type="password" name="password" required>
         
      <input type="submit" value="ログイン">
       
   </form>
   
   <p>会員登録がまだの方はコチラ</p>
   <a href="email_register.php"><button>会員登録</button></a>
    
</body>
</html>