<?php
	/*$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
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
						'.date("d.m.Y. h:i:s", strtotime($news['datum'])).' / Autor: '.$news['autor'].' / 
							<a href="#clanak'.$news['id'].'" onclick="return changeHash("#clanak'.$news['id'].'"); return false;" id="link-na-komentare">Komentari ('.$count.')</a>
						</small>
					<h2 class="naslov_novosti">'.$news['naslov'].'</h2>
				<p class="tekst-novosti">'.$news['tekst'].' ';
		if ($news['detaljnije'] != "") {
			echo '<a href="#clanak'.$news['id'].'" onclick="return changeHash("#clanak'.$news['id'].'"); return false;">Detaljnije...</a>
				</p>
				<p class="detaljnije" hidden>'.$news['detaljnije'].'</p>';
		}
		echo '</div>';
		if ($news['slika'] != "") {
			echo '<img src="'.$news['slika'].'" class="news-image">';
		}
		echo '</div>';
	}*/
?>				 