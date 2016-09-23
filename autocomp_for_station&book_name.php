<?php
    $db_user = 'root';
    $db_pass = 'yuta81bb';
    $db_host = 'localhost';
    $db_name = 'stokin_db';
    $db_type = 'mysql';

$connect = mysqli_connect($db_host,$db_user,$db_pass) or die('Could not connect to mysql server.' );
mysqli_select_db($connect,$db_name) or die('Could not select database.');
mysqli_set_charset($connect, "utf8");

$term = strip_tags(substr($_POST['book_name'],0, 100));
$term = mysqli_real_escape_string($connect,$term);

$sql = "SELECT book_title FROM stock WHERE book_title LIKE '%$term%' ";
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