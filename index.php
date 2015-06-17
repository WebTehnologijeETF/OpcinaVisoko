<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="stil.css">
		<!--<link href="favicon.ico" rel="shortcut icon" type="image/x-icon"/>-->
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<title>Općina Visoko</title>
		<script src="otvoriDetaljnije.js"></script>
	</head>
	<body>
		<div id="okvir">
			<div id="zaglavlje">
				<div id="link_kuci">
					<a href="index.php"></a>
				</div>
			</div>
			<div id="ispod_zaglavlja">
				<p>
					<b>Općina Visoko</b><br>
					<i>The Municipality of Visoko</i>
				</p>
			</div>
			<div id="meni">
				<a href="index.php">Vijesti</a>
				<a href="tel-brojevi.php">Tel. brojevi</a>
				<a href="linkovi.php">Linkovi</a>
				<a href="kontakt.php">Kontakt</a>
			</div>
			<div id="naslov_stranice">Vijesti</div>
			<div id="sadrzaj">
			
			
				
				<?php
					$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
			    	$connection->exec("set names utf8");
			    	$query = $connection->query("SELECT id, naslov, autor, datum, tekst, detaljnije, slika FROM vijesti ORDER BY datum DESC");
			    	if (!$query) {
			        	$error = $connection->errorInfo();
			        	print "SQL greška: ".$error[2];
			        	exit();
			    	}
					foreach ($query as $news) {
						$commentscount = $connection->query("SELECT COUNT(*) FROM komentari WHERE vijest=".$news['id']."");
						$count = $commentscount->fetchColumn();
						echo '<div class="novost">
									<div class="news-text">
										<small class="datum_vrijeme_novosti">
											<b>'.date("d.m.Y. h:i:s", strtotime($news['datum'])).'</b>, Autor: '.$news['autor'].'
										</small>
							  			<h2 class="naslov_novosti">'.$news['naslov'].'</h2>
										<a href="#" class="broj-komentara-x" onclick="otvoriDetaljnije('.$news['id'].')" id="link-na-komentare">Komentari ('.$count.')</a>
							  			<p class="tekst-novosti">'.$news['tekst'].' ';
						if ($news['detaljnije'] != "") {
							echo '<a href="#" onclick="otvoriDetaljnije('.$news['id'].')">Detaljnije...</a>
										</p>
										<p class="detaljnije" hidden>'.$news['detaljnije'].'</p>';
						}
						echo '</div>';
						if ($news['slika'] != "") {
							echo '<img src="'.$news['slika'].'" class="news-image">';
						}
						echo '</div>';
					}
					/*
					// Insert news items into array
					$ctr = 0;
					$news = array();
					foreach (glob('novosti/*.txt') as $datoteka) {
						$lines = explode("\n", file_get_contents($datoteka));
						$file = fopen($datoteka, "r");
						$news[$ctr]['date'] = $lines[0];
						fgets($file);
						$news[$ctr]['author'] = $lines[1];
						fgets($file);
						$news[$ctr]['title'] = $lines[2];
						fgets($file);
						$news[$ctr]['image'] = $lines[3];
						fgets($file);
						$news[$ctr]['text'] = '';
						$i = 4;
						while (!feof($file) && $i < count($lines) && (strlen($lines[$i]) > 3 && strpos($lines[$i], "--") !== 0)) {
							$news[$ctr]['text'] .= $lines[$i];
							fgets($file);
							$i++;
						}
						$i++;
						$news[$ctr]['detailed'] = '';
						while (!feof($file)) {
							if ($i < count($lines)) {
								$news[$ctr]['detailed'] .= $lines[$i];
							}
							fgets($file);
							$i++;
						}
						$ctr++;
					}
					
					// Sort news by date
					for ($i = 0; $i < count($news); $i++) {
						$news[$i]['title'] = ucfirst(strtolower($news[$i]['title']));
						$news[$i]['date'] = substr($news[$i]['date'], 3, 20);
						$news[$i]['timestamp'] = strtotime($news[$i]['date']);
					}
					$timestamp = array();
					foreach ($news as $key => $row) {
    					$timestamp[$key] = $row['timestamp'];
					}
					array_multisort($timestamp, SORT_DESC, $news);
					
					// Display news
					for ($i = 0; $i < count($news); $i++) {
						if (strlen($news[$i]['detailed']) > 0) {
							echo '<div class="novost">
									<div class="news-text">
										<small class="datum_vrijeme_novosti">
											<b>'.$news[$i]['date'].'</b>, Autor: '.$news[$i]['author'].'
										</small>
							  			<h2 class="naslov_novosti">'.$news[$i]['title'].'</h2>
							  			<p class="tekst-novosti">'.$news[$i]['text'].'
											<a href="index.php">Detaljnije...</a>
										</p>
										<p class="detaljnije" hidden>'.$news[$i]['detailed'].'</p>
									</div>	
									<img src="'.$news[$i]['image'].'" class="news-image">
							  	  </div>';
						}
						else {
							echo '<div class="novost">
									<div class="news-text">
										<small class="datum_vrijeme_novosti">
											<b>'.$news[$i]['date'].'</b>, Autor: '.$news[$i]['author'].'
										</small>
							  			<h2 class="naslov_novosti">'.$news[$i]['title'].'</h2>
							  			<p class="tekst-novosti">'.$news[$i]['text'].'</p>
									</div>
									<img src="'.$news[$i]['image'].'" class="news-image">
							  	  </div>';
						}
					}
					*/
			 	?>
			
			
			
			</div>
			<div id="dno">© 2015 Općina Visoko. Sva prava pridržana.</div>
		</div>
	</body>
</html>