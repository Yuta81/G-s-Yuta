<?php

/* 入力フォームからパラメータを取得 */
$general_user_name = $_POST['general_user_name'];
$address = $_POST['address'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$email = $_POST['email'];

 
/* データベース接続設定 */
require_once('db_connect.php');


/* 重複登録のチェック */
$sql = "SELECT email
        FROM general_user
        WHERE email = :email";

$stmh = $pdo->prepare($sql);
$stmh->bindValue(':email', $email, PDO::PARAM_STR);
$stmh->execute();
$result = $stmh->rowCount();


if($result > 0){
/*同一のメールアドレスがあった場合*/
    print '既に会員登録済みです';
    exit;
   
}else{/*同一のメールアドレスがなかった場合*/
    
    try{
        
    $pdo->beginTransaction();

    
        
    $sql2 = "INSERT INTO general_user(general_user_name, address, age, gender, password, email, regist_date) 
             VALUES(:general_user_name, :address, :age, :gender, :password, :email, sysdate())";
    
    $stmt = $pdo->prepare($sql2);
    $stmt->bindValue(':general_user_name', $general_user_name, PDO::PARAM_STR);
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':age', $age, PDO::PARAM_INT);
    $stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $result2 = $stmt->execute();
    
    $pdo->commit();
    
    if($result2 == true){
        
        print '登録完了完了しました！　<a href="index.php">ホームページ</a>';
        
    }else{
        
        print 'データ登録に失敗しました';
        exit;
     }
        
    }catch(PDOException $e){
     
        $pdo->rollback();
        print 'error!'.$e->getMessage();
  }
        
}
    
  
?>


<form action="password_reminder.php" method="post">
    <input type="hidden" name="email" value="<?= e($email) ?>">
</form>
