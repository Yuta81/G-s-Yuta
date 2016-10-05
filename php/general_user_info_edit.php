<?php

session_start();

include('include.php');


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ユーザー情報の更新</title>
</head>
<body>



<form action="general_user_info_edit_confirm.php" method="post">

<table border="1">
     <tr>
         <td>現在のユーザー名</td>
         <td><?= e($_SESSION['general_user_name'])?></td>
     </tr>
     
     <tr>
         <td>新しいユーザー名</td>
         <td><input type="text" name="user_name" value="<?= e($_SESSION['general_user_name'])?>" size="30" required></td>
     </tr>
     
     <tr>
         <td>現在の住所</td>
         <td><?= e($_SESSION['address'])?></td>
     </tr>
     
     <tr>
         <td>新しい住所</td>
         <td>
           <select name="address" required>
            <option value="" checked>選択して下さい</option>
            <option value="北海道">北海道</option>
            <option value="青森県">青森県</option>
            <option value="岩手県">岩手県</option>
            <option value="宮城県">宮城県</option>
            <option value="秋田県">秋田県</option>
            <option value="山形県">山形県</option>
            <option value="福島県">福島県</option>
            <option value="東京都">東京都</option>
            <option value="神奈川県">神奈川県</option>
            <option value="埼玉県">埼玉県</option>
            <option value="千葉県">千葉県</option>
            <option value="茨城県">茨城県</option>
            <option value="栃木県">栃木県</option>
            <option value="群馬県">群馬県</option>
            <option value="山梨県">山梨県</option>
            <option value="新潟県">新潟県</option>
            <option value="長野県">長野県</option>
            <option value="富山県">富山県</option>
            <option value="石川県">石川県</option>
            <option value="福井県">福井県</option>
            <option value="愛知県">愛知県</option>
            <option value="岐阜県">岐阜県</option>
            <option value="静岡県">静岡県</option>
            <option value="三重県">三重県</option>
            <option value="大阪府">大阪府</option>
            <option value="兵庫県">兵庫県</option>
            <option value="京都府">京都府</option>
            <option value="滋賀県">滋賀県</option>
            <option value="奈良県">奈良県</option>
            <option value="和歌山県">和歌山県</option>
            <option value="鳥取県">鳥取県</option>
            <option value="島根県">島根県</option>
            <option value="岡山県">岡山県</option>
            <option value="広島県">広島県</option>
            <option value="山口県">山口県</option>
            <option value="徳島県">徳島県</option>
            <option value="香川県">香川県</option>
            <option value="愛媛県">愛媛県</option>
            <option value="高知県">高知県</option>
            <option value="福岡県">福岡県</option>
            <option value="佐賀県">佐賀県</option>
            <option value="長崎県">長崎県</option>
            <option value="熊本県">熊本県</option>
            <option value="大分県">大分県</option>
            <option value="宮崎県">宮崎県</option>
            <option value="鹿児島県">鹿児島県</option>
            <option value="沖縄県">沖縄県</option>
       </select>
       </td>
     </tr>
     
     <tr>
         <td>メールアドレス</td>
         <td><?= e($_SESSION['user_email'])?></td>
     </tr>
     
     <tr>
         <td>新しいメールアドレス</td>
         <td><input type="email" name="email" value="<?= e($_SESSION['user_email'])?>" required></td>
     </tr>
     
      
      <tr>
          <td>現在のパスワード</td>
          <td><input type="password" name="present_password"> </td>
      </tr>
      
      <tr>
          <td>新しいパスワード(6文字以上16文字以下)</td>
          <td><input type="password" name="new_password"></td>
      </tr>
      
      <tr>
          <td>新しいパスワード（確認用再入力）</td>
          <td><input type="password" name="new_password_confirm"></td>
      </tr>
      
       
   </table>
   <br>
   <p>※パスワードの変更が必要ない場合は、「新しいパスワード」に現在のパスワードを入力下さい</p>
   <input type="submit" value="確認する">
    
 </form>
   <br>
    
    <a href="password_reminder.php">現在のパスワードを忘れた場合はこちら</a>

    
</body>
</html>