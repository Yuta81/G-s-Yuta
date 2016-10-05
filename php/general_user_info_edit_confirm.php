<?php

session_start();

include('include.php');

/*DB接続*/    
require_once('db_connect.php');

/*SQL(現在のパスワードが一致しているかの確認のため)*/

try{
    
    $sql = "SELECT *
            FROM general_user
            WHERE id = :id";
    
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmh->execute();
    
    $row = $stmh->fetch();

    $password_match = password_verify($_POST['present_password'], $row['password']);
    
    if(!$password_match){
        
        exit("現在のパスワードが間違っています");
        
    }else if($_POST['user_name'] == $row['general_user_name'] && $_POST['address'] == $row['address'] && $_POST['email'] == $row['email']){
        
        exit('変更箇所がございません');
    }
    
    
    
}catch(PDOException $r){
        print "エラー".$r->getMessage();
    }


/*新しいパスワードと確認用パスワードの一致を確認*/
if($_POST['new_password'] !== $_POST['new_password_confirm']){
    
    exit('確認用に入力したパスワードが一致しません');
}


/* 新しいパスワードの文字数をチェック*/
if(strlen($_POST['new_password']) < 6 || strlen($_POST['new_password']) > 16){
    
    exit("パスワードは6文字以上16文字以内でお願いします。");

}



/*確認事項OKの場合、新しいメールアドレスに仮更新確認メールを送信する*/


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー情報更新（確認画面）</title>
</head>
<body>
   
   <form action="general_user_info_edit_send.php" method="post">
       
       <table border="1">
           <tr>
               <td>新しいユーザー名：</td>
               <td><?= e($_POST['user_name'])?></td>
               <input type="hidden" name="user_name" value=
               "<?= e($_POST['user_name'])?>">
           </tr>
           
           <tr>
               <td>新しい住所：</td>
               <td><?= e($_POST['address'])?></td>
               <input type="hidden" name="address" value=
               "<?= e($_POST['address'])?>">
           </tr>
           
           <tr>
               <td>新しいメールアドレス</td>
               <td><?= e($_POST['email'])?></td>
               <input type="hidden" name="email" value=
               "<?= e($_POST['email'])?>">
           </tr>
           
           <tr>
               <td>新しいパスワード</td>
               <td><?= e($_POST['new_password'])?></td>
               <input type="hidden" name="password" value=
               "<?= e($_POST['new_password'])?>">
           </tr>
       </table>
       <br>
    
       
       <p>以上の内容でよろしいですか？</p>
       <input type="submit" value="はい">      
       
   </form>
   <br>
   
    <form action="general_user_info_edit_correct.php">
           <input type="submit" value="戻る">
       </form>
    
</body>
</html>
