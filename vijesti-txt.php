<?php
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
							echo '<div class="novost">
									<div class="news-text">
										<small class="datum_vrijeme_novosti">
											'.$news[$i]['date'].', Autor: '.$news[$i]['author'].'
										</small>
							  			<h2 class="naslov_novosti">'.$news[$i]['title'].'</h2>
							  			<p class="tekst-novosti">'.$news[$i]['text'];
						if (strlen($news[$i]['detailed']) > 0) {
							echo '<a href="index.php" onclick="otvoriDetaljnije('.json_encode($news[$i]).')">Detaljnije...</a>';
						}
						echo '</p><p class="detaljnije" hidden>'.$news[$i]['detailed'].'</p></div>';
						if (strlen($news[$i]['image']) > 3) {
							echo '<div class="news-image"><img src="'.$news[$i]['image'].'"></div>';
						}
						echo '</div>';
					}
?>