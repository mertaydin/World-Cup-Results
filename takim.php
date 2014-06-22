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
$fifa_codes_url = "http://worldcup.sfg.io/matches/country?fifa_code="; //Matches for any country, by entering their FIFA Code. 
$group_results_url = "http://worldcup.sfg.io/group_results";
//You can append ?by_date=desc to any query to sort the matches by future to past. ?by_date=asc does past to future. 
//http://worldcup.sfg.io/matches/today/?by_date=DESC




?>

<?php $matches = json_decode(file_get_contents($fifa_codes_url.$_GET['code'])); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>2014 Dünya Kupası <?php echo strval($_GET['code']) ?> İstatistikleri - www.kodteyner.com</title>
 

</head>
<body>

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
#activity { text-align: left; margin:0; padding: 0; }
</style>

<a href="/world_cup"> << Geri Dön<a>
<br><br>

<table class="tg">
  <tr>
    <th class="tg-031e">ID</th>
    <th class="tg-031e">Lokasyon</th>
    <th class="tg-031e">Tarih</th>
    <th class="tg-031e">Durum</th>
    <th class="tg-031e">Ev Sahibi</th>
    <th class="tg-031e">Misafir</th>
    <th class="tg-031e">Kazanan</th>
    <th class="tg-031e">Ev Sahibi Aktifivite</th>
    <th class="tg-031e">Misafir Aktivite</th>
  </tr>
  <?php foreach ($matches as $match) { 

  	  		$status="";
  		if($match->status=="future")
  			$status="Başlayacak";
  		else if ($match->status=="in progress")
  			$status="Maç oynanıyor";
  		else if($match->status=="completed")
  			$status="Maç bitti";
  		?>

	  <tr>
	    <th class="tg-031e"><?php echo $match->match_number ?></th>
	    <th class="tg-031e"><?php echo $match->location ?></th>
	    <th class="tg-031e"><?php echo date("d-m-Y H:i", strtotime($match->datetime)) ?></th>
	    <th class="tg-031e"><?php echo $status ?></th>
	    <th class="tg-031e"><?php echo $match->home_team->country ?></th>
	    <th class="tg-031e"><?php echo $match->away_team->country  ?></th>
	    <th class="tg-031e"><?php echo isset($match->winner) ? $match->winner : 'Maç Bitmedi' ?></th>
	    <th class="tg-031e">
	    <?php
	    	if(!empty($match->home_team_events)) {	    		
	    ?>
	    	<ul>
				<?php foreach($match->home_team_events as $event) { ?>
					<li id="activity">Olay : <?php echo $event->type_of_event ?> | Player : <?php echo $event->player ?> | Dakika : <?php echo $event->time ?> </li>
				<?php } ?>
			</ul>
			<?php 
			} else { 
				echo "Maç başlamadı";
			}			
			?>
	    </th>
	    <th class="tg-031e">
	    <?php
	    	if(!empty($match->home_team_events)) {	    		
	    ?>	    
	    	<ul>
				<?php foreach($match->away_team_events as $event) { ?>
					<li id="activity">Olay : <?php echo $event->type_of_event ?> | Player : <?php echo $event->player ?> | Dakika : <?php echo $event->time ?> </li>
				<?php } ?>
			</ul>
			<?php 
			} else { 
				echo "Maç başlamadı";
			}			
			?>			
	    </th>
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