<?php

session_start();

if(!isset($_SESSION['store_user_name']) || $_SESSION['store_user_name'] == ""){
    header("Location: store_login.php");
    
}

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CSV to MySQL importation test</title>
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>


<body>
<h1>在庫情報管理画面</h1>
<p>こんにちは！<?=h($_SESSION['store_user_name'])?>さん。</p>

<!--
<?php if (isset($msg)): ?>
  <fieldset>
    <legend>Result</legend>
    <span style="color:<?=h($msg[0])?>;"><?=h($msg[1])?></span>
  </fieldset>
<?php endif; ?>
-->
  <form enctype="multipart/form-data" method="post" action="load_data_infile.php">
<!--
    <fieldset>
      <legend>Select File</legend>
      Filename(CSV is only supported): 
-->
      
    
      <input type="file" name="upfile" value="ファイルを選択"><br><br>
    
      <input type="submit" value="アップロード"> ※在庫状況を更新します
　　</form>
      
<!--    </fieldset>-->
 <br><br>
  <form action="your_stock.php"　method="post">
      
      <input type="submit" value="登録されている在庫情報の確認">
  </form> 
 
  
  
  <br><br>
  <form action="store_logout.php" method="post">
      
       <input type="submit" value="ログアウト">
       
  </form>
  
</body>
</html>