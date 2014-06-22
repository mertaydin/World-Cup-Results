<?php
$cachedosyasi = "cache/".md5($_SERVER['REQUEST_URI']).".mrt";
if (file_exists($cachedosyasi) && (time() - 180 < filemtime($cachedosyasi))) {
include($cachedosyasi);
exit;
}
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
<?php $group_results = json_decode(file_get_contents($group_results_url)); ?>  

<?php $group_results_with_points = json_decode(file_get_contents($new_group_results)); ?>  
<?php
  
  $group_letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
  $groups_with_points = array();

  foreach ($group_results_with_points as $index => $group) {
    foreach ($group as $_index => $team) {
      foreach ($team->teams as $__index => $row) {
        $groups_with_points[$index+1][$row->team->fifa_code]['points'] = (String)$row->team->points;
        $groups_with_points[$index+1][$row->team->fifa_code]['country'] = $row->team->country;
        $groups_with_points[$index+1][$row->team->fifa_code]['fifa_code'] = $row->team->fifa_code;
        $groups_with_points[$index+1][$row->team->fifa_code]['goal_differential'] = $row->team->goal_differential;
        $groups_with_points[$index+1][$row->team->fifa_code]['order'] = $__index+1;
      }
    }
  }

  ?>

<?php
  
  $group_letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
  $groups = array();
  $j=1;
  $group_count = count($group_results);
  for($i=1; $i<=$group_count; $i++)
  {
  	  $order = (String)$groups_with_points[$j][$group_results[$i-1]->fifa_code]['order'];

      $groups[$j][$order-1]['country'] = $group_results[$i-1]->country;
      $groups[$j][$order-1]['alternate_name'] = $group_results[$i-1]->alternate_name;
      $groups[$j][$order-1]['fifa_code'] = $group_results[$i-1]->fifa_code;
      $groups[$j][$order-1]['group_id'] = $group_results[$i-1]->group_id;
      $groups[$j][$order-1]['wins'] = $group_results[$i-1]->wins;
      $groups[$j][$order-1]['draws'] = $group_results[$i-1]->draws;
      $groups[$j][$order-1]['losses'] = $group_results[$i-1]->losses;
      $groups[$j][$order-1]['goals_for'] = $group_results[$i-1]->goals_for;
      $groups[$j][$order-1]['goals_against'] = $group_results[$i-1]->goals_against;
      $groups[$j][$order-1]['knocked_out'] = $group_results[$i-1]->knocked_out;
      $groups[$j][$order-1]['updated_at'] = date("d-m-Y H:i", strtotime($group_results[$i-1]->updated_at));
      $groups[$j][$order-1]['points'] = (String)$groups_with_points[$j][$group_results[$i-1]->fifa_code]['points'];
      $groups[$j][$order-1]['order'] = (int)$groups_with_points[$j][$group_results[$i-1]->fifa_code]['order'];
      if($i % 4 == 0)
        $j++;
  }


$size = count($groups);
for($i=1; $i<=$size; $i++)
{
  $array = $groups[$i];
  $array_size = count($array);

  for($j=0; $j<$array_size; $j++)
  {
    $_group[$i][$j] = $array[$j];   
  } 
}

$groups = $_group;

?>

<div id="groups">
  <?php

    foreach ($groups as $index => $group) { ?>
    <table class="tg" style="float: left; margin: 15px;">
      <tr>
        <th class="tg-031e" style="width:20px;">Group ID</th>
        <th class="tg-031e">Ülke</th>
        <!--<th class="tg-031e">FIFA Kodu</th>-->
        <th class="tg-031e">G</th>
        <th class="tg-031e">B</th>
        <th class="tg-031e">M</th>
        <th class="tg-031e">AG</th>
        <th class="tg-031e">YG</th>
        <th class="tg-031e">P</th>
        <!-- <th class="tg-031e">Knocked Out</th> -->
        <!--<th class="tg-031e">Güncelleme</th>-->
      </tr>      
      <?php foreach ($group as $_index => $team) {     ?>
          <tr>
        <th class="tg-031e"><?php echo $group_letters[$team['group_id']-1] ?></th>
        <th class="tg-031e"><?php echo '<a href="team.php?code='. $team['fifa_code'] .'" target="_blank">' . $team['country'] . '</a>' ?></th>
        <!--<th class="tg-031e"><?php echo $team['fifa_code'] ?></th>-->
        <th class="tg-031e"><?php echo $team['wins'] ?></th>
        <th class="tg-031e"><?php echo $team['draws'] ?></th>
        <th class="tg-031e"><?php echo $team['losses'] ?></th>
        <th class="tg-031e"><?php echo $team['goals_for'] ?></th>
        <th class="tg-031e"><?php echo $team['goals_against'] ?></th>
        <th class="tg-031e"><?php echo $team['points'] ?></th>
        <!-- <th class="tg-031e"><?php echo $team['knocked_out'] ?></th> -->
        <!--<th class="tg-031e"><?php echo date("d-m-Y H:i", strtotime($team['updated_at'])) ?></th>-->
          </tr>
      <?php }
      echo "</table>";
    }

  ?>
</div>

</body>
</html>

<?php
$ch = fopen($cachedosyasi, 'w');
fwrite($ch, ob_get_contents());
fclose($ch);
ob_end_flush();
?>

