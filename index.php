<?php

date_default_timezone_set('Europe/Istanbul');

$all_matches_url = "http://worldcup.sfg.io/matches";
$today_matches_url = "http://worldcup.sfg.io/matches/today";
$current_matches_url = "http://worldcup.sfg.io/matches/current";
$fifa_codes_url = "http://worldcup.sfg.io/matches/country?fifa_code=USA"; //Matches for any country, by entering their FIFA Code. 
$group_results_url = "http://worldcup.sfg.io/group_results";
//You can append ?by_date=desc to any query to sort the matches by future to past. ?by_date=asc does past to future. 
//http://worldcup.sfg.io/matches/today/?by_date=DESC




?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>2014 Dünya Kupası Sayfası - www.kodteyner.com</title>
</head>
<body>


<style type="text/css">
.box {width: 250px; height: 250px; background: #BDBCBC; text-align: center; display:table-cell; vertical-align: middle;}
.box-container {display:table; position: absolute; z-index: 15; top: 45%; left: 45%; margin: -100px 0 0 -150px; }
.seperator{height:1px; background:#717171;border-bottom:1px solid #313030;}
</style>

<div class="box-container">
    <div class="box">
      <a href="today_matches.php" target="_blank">
        GÜNÜN MAÇLARI
      </a>
    </div>

  <div class="seperator"></div>

    <div class="box">
      <a href="groups.php" target="_blank">
        GRUPLAR
      </a>
    </div>
</div>

</body>
</html>