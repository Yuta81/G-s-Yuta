<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC434MBbhe6MuEUVmTwJsCnp-jwL7grBYI&callback=initMap" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type='text/javascript'></script>
    
    <script>
        $(document).ready(function(){
            
/*現在地から本を検索のためのオートコンプリート*/
          $("#search_term").keyup(function(e){
            e.preventDefault();
            var search_val = $("#search_term").val();
            $.post("autocomp_for_geolocation.php", {search_term : search_val}, function(data){
              if(data.length>0){
                $("#search_term").autocomplete({
                  source: data
                });
              }
            })
          });

    
/*駅名を入力して検索のためのオートコンプリート*/   
          $("#book_name").keyup(function(e){
            e.preventDefault();
            var search_val = $("#book_name").val();
            $.post("autocomp_for_station.php", {book_name : search_val}, function(data){
              if(data.length>0){
                $("#book_name").autocomplete({
                  source: data
                });
              }
            })
          });
    
    
        
/*駅名入力後の本検索のためのオートコンプリート*/        
          $("#book_name2").keyup(function(e){
            e.preventDefault();
            var search_val = $("#book_name2").val();
            $.post("autocomp_for_station&book_name.php", {book_name : search_val}, function(data){
              if(data.length>0){
                $("#book_name2").autocomplete({
                  source: data
                });
              }
            })
          });

    });


/*以下、GeoLocation APIにて現在地情報を取得*/
//1．位置情報の取得に成功した時の処理
function mapsInit(position) {
  try {
    //lat=緯度、lon=経度 を取得
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
//    alert("位置情報取得完了！");
    $('#lat').val(lat);
    $('#lon').val(lon);
      

  } catch (error) {
    console.log("getGeolocation: " + error);
  }
};
       
       

//2． 位置情報の取得に失敗した場合の処理
function mapsError(error) {
  var e = "";
  if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
    e = "位置情報が許可されてません";
  }
  if (error.code == 2) { //2＝現在地を特定できない
    e = "現在位置を特定できません";
  }
  if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
    e = "位置情報を取得する前にタイムアウトになりました";
  }
  alert("エラー：" + e);
};

//3.位置情報取得オプション
var set ={
  enableHighAccuracy: true, //より高精度な位置を求める
  maximumAge: 20000,        //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
  timeout: 10000            //10秒以内に現在地情報を取得できなければ、処理を終了
};

//Main:位置情報を取得する処理 //getCurrentPosition :or: watchPosition
function initMap(){

  navigator.geolocation.getCurrentPosition(mapsInit, mapsError, set);
}

</script>
</head>

<body>
   
<!--  現在地から本を検索するためのフォーム-->
     <form action="geolocation_search_result.php" method="post">
       
       <p>本の検索</p> 
       
       <input type="text" name="book_name" id="book_name">
       <input type="submit" value="検索">
       <input type="hidden" name="lat" id="lat">
       <input type="hidden" name="lon" id="lon">
       
       
   </form>

   <br>
   <br>
 
<!--   駅を指定して本を検索するためのフォーム  -->
    <form action="station_search_result.php" method="post">

    駅名：<input type="text" name="search_term" id="search_term">
    本：<input type="text" name="book_name" id="book_name2">
    <input type="submit" value="検索">

    
   </form>
   
</body>
</html>