 <?php

if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error'])) {

    

        /* ファイルアップロードエラーチェック */
        switch ($_FILES['upfile']['error']) {
            case UPLOAD_ERR_OK:
                // エラー無し
                break;
            case UPLOAD_ERR_NO_FILE:
                // ファイル未選択
                throw new RuntimeException('File is not selected');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                // 許可サイズを超過
                throw new RuntimeException('File is too large');
            default:
                throw new RuntimeException('Unknown error');
        }

        $tmp_name = $_FILES['upfile']['tmp_name'];
        $detect_order = 'ASCII,JIS,UTF-8,CP51932,SJIS-win';
        setlocale(LC_ALL, 'ja_JP.UTF-8');

        /* 文字コードを変換してファイルを置換 */
        $buffer = file_get_contents($tmp_name);
        if (!$encoding = mb_detect_encoding($buffer, $detect_order, true)) {
            // 文字コードの自動判定に失敗
            unset($buffer);
            throw new RuntimeException('Character set detection failed');
        }
        file_put_contents($tmp_name, mb_convert_encoding($buffer, 'UTF-8', $encoding));
        unset($buffer);
    }
    
        
//DB接続
require_once('db_connect.php');

$file = $_FILES['upfile']['name'];


try{
    
   $sql = "LOAD DATA INFILE '$file' INTO TABLE pref_cd
           FIELDS TERMINATED BY ','";
    
    $stmh = $pdo->prepare($sql);
    $result = $stmh->execute();
    
      
}catch(PDOException $e){
    
    print 'error'.$e->getMessage();
    
}


 if($result==false){
     
     $error = $stmh->errorInfo();
      exit("QueryError:".$error[2]);
        
}else{
     
     print 'アップロード完了しました！';
         
 }

?>