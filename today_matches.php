<?php
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
//You can append ?by_date=desc to any query to sort the matches by future to past. ?by_date=asc does past to future. 
//http://worldcup.sfg.io/matches/today/?by_date=DESC




?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>2014 Dünya Kupası Günün Maçları Sayfası - www.kodteyner.com</title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
          setInterval(function(){ $(".continue").fadeTo(100, 0.1).fadeTo(200, 1.0) }, 3000);
        });     
    </script>   

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
<br><br>
<table class="tg">
<?php $all_matches = json_decode(file_get_contents($today_matches_url)); ?>   
  <tr>
  <th class="tg-031e" colspan="8">BUGÜNÜN MAÇLARI</th>
  </tr>
  <tr>
    <th class="tg-031e">Maç ID</th>
    <th class="tg-031e">Konum</th>
    <th class="tg-031e">Tarih</th>
    <th class="tg-031e">Durum</th>
    <th class="tg-031e">Ev Sahibi Takım</th>
    <th class="tg-031e">Misafir Takım</th>
    <th class="tg-031e">Kazanan</th>
    <th class="tg-031e">SKOR</th>
  </tr>
  
<?php foreach($all_matches as $match) { ?>
  <tr <?php echo $match->status=='in progress' ? 'class="continue"' : "" ?>>
  <?php
  		$status="";
  		if($match->status=="future")
  			$status="Başlayacak";
  		else if ($match->status=="in progress")
  			$status="Maç oynanıyor";
  		else if($match->status=="completed")
  			$status="Maç bitti";

  		$winner="";
  		if($match->winner=="Draw")
  			$winner = "Berabere";
  		else
  			$winner = $match->winner;

  		if(!isset($match->winner))
  			$winner = "Maç bitmedi";
  ?>

    <th class="tg-031e"><?php echo $match->match_number ?></th>
    <th class="tg-031e"><?php echo $match->location ?></th>
    <th class="tg-031e"><?php echo date("d-m-Y H:i", strtotime($match->datetime)) ?></th>
    <th class="tg-031e"><?php echo $status ?></th>
    <th class="tg-031e"><?php echo '<a href="team.php?code='. $match->home_team->code .'">'.$match->home_team->country.'</a>' ?></th>
    <th class="tg-031e"><?php echo '<a href="team.php?code='. $match->away_team->code .'">'.$match->away_team->country.'</a>' ?></th>
    <th class="tg-031e"><?php echo $winner ?></th>
    <th class="tg-031e"><?php echo $match->status!="future" ? $match->home_team->goals . ' - ' . $match->away_team->goals : 'Maç Başlamadı.' ?></th>
  </tr> 
<?php } ?>
</table>
</body>
</html>
<?php
$ch = fopen($cachedosyasi, 'w');
fwrite($ch, ob_get_contents());
fclose($ch);
ob_end_flush();
?>