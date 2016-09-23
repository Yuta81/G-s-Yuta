<?php

include("include.php");

if($_GET['pre_user_id']) {
    
    $pre_user_id = $_GET['pre_user_id'];
  
}else{
    
    print 'エラー発生。メールアドレスの登録からやり直して下さい';
}


 
/* データベース接続設定 */
require_once("db_connect.php");


/* 取得したユニークIDをキーに登録されたメールアドレスを取得 */

try{
    
    $sql = "SELECT email, pre_user_id
            FROM pre_general_user
            WHERE pre_user_id = :pre_user_id";

    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':pre_user_id', $pre_user_id, PDO::PARAM_STR);
    $stmh->execute();
    $count = $stmh->rowCount();

    if($count > 0){
    
      $data = $stmh->fetch(PDO::FETCH_ASSOC);

    }

        
 }catch(PDOException $e){
    
    print 'error' . $e->getMessage();
 }




?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー情報登録フォーム</title>
</head>
<body>
   
　<form method="post" action="general_user_regist_confirm.php">
   
    <h1>会員情報登録フォーム</h1>
    
    ユーザー名(*)：<input type="text" size="30" name="general_user_name" required>
    <br><br>
    
    都道府県：<select name="address" required>
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
       <br><br>
       
    年齢：<input type="text" name="age" required>
         <br><br>
         
    性別：男性<input type="radio" name="gender" value="男性" required>
         女性<input type="radio" name="gender" value="女性">
         <br><br>
    
    パスワード(*)：<input type="password" size="30" name="password" required>* 6文字以上16文字以下
    <br><br>
    
    パスワード(確認のため再入力下さい)：<input type="password" size="30" name="password_confirm" required>
    <br><br>
    
    E-mail：<?= e($data['email']) ?><input type="hidden" name="email" value="<?= e($data['email']) ?>">
    <br><br>
    
    <input type="submit" value=" 送信 ">
    
  </form>
    
</body>
</html>



