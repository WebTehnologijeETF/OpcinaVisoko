<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="stil.css">
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<title>Općina Visoko</title>
	</head>
	<body>
		<div id="okvir">
			<div id="zaglavlje">
				<div id="link_kuci">
					<a href="index.html"></a>
				</div>
			</div>
			<div id="ispod_zaglavlja">
				<p>
					<b>Zvanične web stranice Općine Visoko</b>
					<br>
					<i>The Official Website of the Municipality of Visoko</i>
				</p>
			</div>
			<div id="meni">
				<a href="index.html"><div id="naslovna">Vijesti</div></a>
				<a href="tel-brojevi.html"><div id="tel-brojevi">Tel. brojevi</div></a>
				<a href="linkovi.html"><div id="linkovi">Linkovi</div></a>
				<a href="kontakt.php"><div id="kontakt">Kontakt</div></a>
			</div>
			<div id="naslov_stranice">Kontakt</div>
			<div id="sadrzaj">
				
				
				<form id="forma" name="forma" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onsubmit="return validacijaForme();">
					<p id="obavezno">* - Polje obavezno</p>
						
					<?php
						$one = $two = $three = $four = true;
						$ip = $email = $email_p = $telefon = $kom = "";
						if (isset($_REQUEST['posalji'])) {
							$ip = $_REQUEST['imeiprezime'];
							$email = $_REQUEST['email'];
							$email_p = $_REQUEST['email_potvrda'];
							$telefon = $_REQUEST['telefon'];
							$kom = $_REQUEST['komentar'];
							$emailRegEx = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';
							if (strlen($ip) < 5 || strlen($ip) > 50) {
								$one = false;
							}
							if (!preg_match($emailRegEx, $email)) {
								$two = false;
							}
							if ($email_p != $email) {
								$three = false;
							}
							if (strlen($kom) == 0) {
								$four = false;
							}
					?>
							<div id="provjera_forme">
					<?php
							if ($one == true && $two == true && $three == true && $four == true) {
								echo '<h3>Provjerite da li ste ispravno popunili kontakt formu:</h3>';
								echo '<b>Ime i prezime:</b> '.$_REQUEST['imeiprezime'].'<br>';
								echo '<b>Email:</b> '.$_REQUEST['email'].'<br>';
								echo '<b>Telefon:</b> '.$_REQUEST['telefon'].'<br>';
								echo '<b>Komentar:</b><br><textarea readonly rows="10" cols="40">'.$_REQUEST['komentar'].'</textarea><br>';
					?>
								<div id="dalistesigurni"><h4>Da li ste sigurni da želite poslati ove podatke?</h4></div>
								<form action="<?php echo '.$_SERVER["PHP_SELF"].'?>" method="post"><input type="submit"" name="siguransam" value="Siguran sam"></form>
					<?php
								echo '<h3>Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke:</h3>';
								
							}
					?>
							</div>
					<?php
						}
						if (isset($_REQUEST['siguransam'])) {
							?>
							<div id="zahvala">
								<?php
									echo '<h2>Zahvaljujemo se što ste nas kontaktirali.</h2>';
								?>
							</div>
							<?php
							/*$to = 'asabanovic3@gmail.com';
							$subject = 'Podaci sa kontakt forme - Opcina Visoko';
							$message = 'Podaci.';
							$headers = 'Reply-To: saban@live.com'."\r\n".
									   'X-Mailer: PHP/'.phpversion();
							mail($to, $subject, $message, $headers);*/
						}
					?>
					
					
					<div id="stavka_forme">
						<label for="imeiprezime">Ime i prezime: <label class="obavezno">*</label></label><br>
						<input type="text" id="imeiprezime" name="imeiprezime" size="30" value="<?php 
				          if (isset($_REQUEST['imeiprezime'])) 
				            print htmlentities($_REQUEST['imeiprezime'], ENT_QUOTES) ?>" onblur="provjeriImeIPrezime()">
						<label for="imeiprezime" id="greska1" class="greska">
							<?php 
								if ($one == false) {
									echo '<img src="warning-icon.png" alt="Upozorenje!"> Ime i prezime nije validno!';
								} 
							?></label>
					</div>
					
					
					<div id="stavka_forme">
						<label for="email">Email: <label class="obavezno">*</label></label><br>
						<input type="text" id="email" name="email" size="30" value="<?php 
				          if (isset($_REQUEST['email'])) 
				            print htmlentities($_REQUEST['email'], ENT_QUOTES) ?>" onblur="provjeriEmail()">
						<label for="email" id="greska2" class="greska">
							<?php 
								if ($two == false) {
									echo '<img src="warning-icon.png" alt="Upozorenje!"> Email nije validan!';
								} 
							?></label>
					</div>
					
					
					<div id="stavka_forme">
						<label for="email_potvrda">Potvrdi email: <label class="obavezno">*</label></label><br>
						<input type="text" id="email_potvrda" name="email_potvrda" size="30" value="<?php 
				          if (isset($_REQUEST['email_potvrda'])) 
				            print htmlentities($_REQUEST['email_potvrda'], ENT_QUOTES) ?>" onblur="crossValidirajEmail()">
						<label for="email_potvrda" id="greska4" class="greska">
							<?php 
								if ($three == false) {
									echo '<img src="warning-icon.png" alt="Upozorenje!"> Email adrese se ne slažu!';
								} 
							?>
						</label>
					</div>
					
					
					<div id="stavka_forme">
						<label for="telefon">Telefon:</label><br>
						<input type="text" id="telefon" name="telefon" value="<?php 
          				  	if (isset($_REQUEST['telefon'])) 
            					print htmlentities($_REQUEST['telefon'], ENT_QUOTES) ?>" size="30">
					</div>
					
					
					<div id="stavka_forme">
						<label for="komentar">Komentar: <label class="obavezno">*</label></label><br>
						<textarea id="komentar" name="komentar" rows="10" cols="40" onblur="provjeriKomentar()"><?php if (isset($_REQUEST['komentar'])) print htmlentities($_REQUEST['komentar'], ENT_QUOTES) ?></textarea>
						<label for="email" id="greska3" class="greska">
							<?php 
								if ($four == false) {
									echo '<img src="warning-icon.png" alt="Upozorenje!"> Polje za komentar je prazno!';
								} 
							?>
						</label>
					</div>
					
					
					<input type="submit" id="posalji" name="posalji" value="Pošalji">
				
				
				</form>
				
				
				<script src="validacijaForme.js"></script>
			</div>
			<div id="dno">© 2015 Općina Visoko. Sva prava pridržana.</div>
		</div>
	</body>

</html>