<?php

    mb_language("Japanese");
    mb_internal_encoding("UTF-8");
    mb_http_output("UTF-8");

    $db_user = 'b60ae5b716dd01';
    $db_pass = 'd3e554b7';
    $db_host = 'us-cdbr-iron-east-04.cleardb.net';
    $db_name = 'heroku_43b33c2f7cca19e';
    $db_type = 'mysql';

$connect = mysqli_connect($db_host,$db_user,$db_pass) or die('Could not connect to mysql server.' );
mysqli_select_db($connect,$db_name) or die('Could not select database.');
mysqli_set_charset($connect, "utf8");

$term = strip_tags(substr($_POST['book_name'],0, 100));
$term = mysqli_real_escape_string($connect,$term);

$sql = "SELECT book_title FROM book WHERE book_title LIKE '%$term%' ";
$result = mysqli_query($connect,$sql);

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
    $string[] = $row['book_title'];
  }
}

$words = array();
foreach($string as $word){
  if(mb_stripos($word, $term) !== FALSE){
    $words[] = $word;
  }
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode($words);

?>
