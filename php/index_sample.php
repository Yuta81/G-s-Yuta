<?php

/* 登録処理（終了を知らせる値）によって読み込むファイルを変える */ 
$mode = $_POST["mode"];
 
/* パラメーターに　preuser_idがあれば登録フォームを表示 */
if($_GET['pre_user_id'] !="") {
  $mode = "regist_form";
}

    
 
/* 振り分け処理 */
switch($mode) {
  // メールアドレスの登録と仮ID送信
  case"email_regist":
  $module = "email_confirm.php";
  break;
 
  //会員登録フォーム
  case"regist_form":
  $module = "general_user_regist_form.php";
  break;

  //登録内容確認
  case"regist_confirm":
  $module = "general_user_regist_confirm.php";
  break;
   
  //会員登録
  case"user_regist":
  $module = "general_user_regist_final.php";
  break;
   
  //メールアドレス登録（初期画面）
  default:
  $module = "email_register.php";
  break;
}
?>


<!DOCTYPE html>
<html land="ja">
<head>
<meta charset="utf8">
<link rel="stylesheet" href="/stockin/css/general_user_register.css">
<link rel="stylesheet" href="/stockin/css/reset.css">
<title>会員登録フォーム</title>
</head>
<body>
<?php
  // コンテンツ（表示ページ）読み込み
  require_once($module);
?>
</body>
</html>

