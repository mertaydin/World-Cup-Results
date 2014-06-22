<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$cachedosyasi = "cache/".md5($_SERVER['REQUEST_URI']).".mrt";
if (file_exists($cachedosyasi) && (time() - 180 < filemtime($cachedosyasi))) {
include($cachedosyasi);
exit;
}
ob_start();

date_default_timezone_set('Europe/Istanbul');

$all_matches_url = "http://worldcup.sfg.io/matches";
$today_matches_url = "http://worldcup.sfg.io/matches/today";
$current_matches_url = "http://worldcup.sfg.io/matches/current";
$fifa_codes_url = "http://worldcup.sfg.io/matches/country?fifa_code=USA"; //Matches for any country, by entering their FIFA Code. 
$group_results_url = "http://worldcup.sfg.io/group_results";

$new_group_results = "http://worldcup.sfg.io/teams/group_results";
//You can append ?by_date=desc to any query to sort the matches by future to past. ?by_date=asc does past to future. 
//http://worldcup.sfg.io/matches/today/?by_date=DESC




?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>2014 Dünya Kupası Gruplar - www.kodteyner.com</title>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.box {width: 250px; height: 250px; background: #BDBCBC; text-align: center; display:table-cell; vertical-align: middle;}
.box-container {display:table; margin-bottom: 20px;}
.seperator{height:1px; background:#717171;border-bottom:1px solid #313030;}
</style>

</head>
<body>

<a href="/world_cup"> << Geri Dön<a>

<h1>GRUPLAR</h1>
<?php $group_results = json_decode(file_get_contents($new_group_results)); ?>  
<?php
  
  $group_letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
  $groups = array();

  foreach ($group_results as $index => $group) {
  	foreach ($group as $_index => $team) {
  		foreach ($team->teams as $__index => $row) {
  			$groups[$index][$__index]['country'] = $row->team->country;
  		}
  	}
  }
  ?>


<div id="groups">

    <table class="tg" style="float: left; margin: 15px;">
      <tr>
        <th class="tg-031e" style="width:20px;">Group ID</th>
        <th class="tg-031e">Ülke</th>
        <th class="tg-031e">FIFA Kodu</th>
        <th class="tg-031e">G</th>
        <th class="tg-031e">B</th>
        <th class="tg-031e">M</th>
        <th class="tg-031e">AG</th>
        <th class="tg-031e">YG</th>
        <th class="tg-031e">Knocked Out</th>
        <th class="tg-031e">Güncelleme</th>
      </tr>      
      </table>

</div>

</body>
</html>

