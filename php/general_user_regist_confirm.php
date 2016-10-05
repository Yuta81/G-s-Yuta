<?php

include ('include.php');

/* 入力フォームからパラメータを取得 */
$general_user_name = $_POST['general_user_name'];
$address = $_POST['address'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$email = $_POST['email'];


/*パスワードと確認用パスワードの一致を確認*/
if($password !== $password_confirm){
    print '確認用に入力したパスワードが一致しません';
    exit;
}


/* パスワードの文字数をチェック*/
if(strlen($password) < 6 || strlen($password) > 16){
    
    print "パスワードは6文字以上16文字以内でお願いします。";
    exit;
}

/*年齢が120歳を超えて入力された場合のエラーチェック*/
if($age > 120){
    
    print '適切な年齢を入力下さい';
    exit;
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録情報確認ページ</title>
</head>
<body>
   
  <form method="post" action="general_user_regist_final.php">
  
    <h1>入力情報確認ページ</h1>
    
      ユーザー名：<?= e($general_user_name) ?><input type="hidden" name="general_user_name" value="<?= e($general_user_name) ?>">
      <br><br>
      
      
      都道府県：<?= e($address) ?><input type="hidden" name="address" value="<?= e($address) ?>">
      <br><br>
      
      年齢：<?= e($age) ?><input type="hidden" name="age" value="<?= e($age) ?>">
      <br><br>
      
      性別：<?= e($gender) ?><input type="hidden" name="gender" value="<?= e($gender) ?>">
      <br><br>
    
      パスワード：<?= e($password) ?><input type="hidden" name="password" value="<?= e($password) ?>">
      <br><br>
      
      パスワード(確認用)：<?= e($password_confirm) ?><input type="hidden" name="password_confirm" value="<?= e($password_confirm) ?>">
      <br><br>

      E-mail：<?= e($email) ?><input type="hidden" name="email" value="<?= e($email) ?>">
      <br><br>
      
      <input type="submit" value="登録">
  
  </form>
  <br>
   
  <form action="general_user_regist_form_correct.php" method="post">
      
      <input type="hidden" name="general_user_name" value="<?= e($general_user_name) ?>">
      
      <input type="hidden" name="age" value="<?= e($age) ?>">
      
      <input type="hidden" name="email" value="<?= e($email) ?>">
      
      <input type="submit" value="修正">
      
  </form>
    
</body>
</html>
 
 





