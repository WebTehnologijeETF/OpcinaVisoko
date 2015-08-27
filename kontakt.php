<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="stil.css">
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<title>Općina Visoko</title>
		<script src="CRUD.js" type="text/javascript"></script>
		<script src="dropDownMenu.js" type="text/javascript"></script>
		<script src="otvoriDetaljnije.js" type="text/javascript"></script>
		<script src="SPANavigation.js" type="text/javascript"></script>
		<script src="validacijaForme.js" type="text/javascript"></script>
		<script src="zamgerProizvodi.js" type="text/javascript"></script>
	</head>
	<body onload="hideDropDownMenu(); hideLoginForm();" onhashchange="replaceContent()">
		
		
		<?php
			session_start();
			$prijava = '<div id="prijava">
							<input type="button" id="dugmePrijava" value="PRIJAVA" onclick="showLoginForm()">
							<input type="button" id="dugmeRegistracija" value="REGISTRACIJA" onclick="showRegistrationForm()"><br><hr>
							<form method="POST" action="index.php" id="prijavaforma">
								<label for="korisnickoime">KORISNIČKO IME: </label><input type="text" id="korisnickoime" name="korisnickoime">
								<label for="korisnickoime">LOZINKA: </label><input type="text" id="lozinka" name="lozinka">
								<input type="submit" value="PRIJAVI SE">
							</form>
						</div>';
			$panellink = '<div id="panel-link"><a href="#panel" onclick="showPanel(); return false;">Prikaži administratorski panel</a></div>';
			$panel = '<div id="panel">
							<h3>ADMINISTRATORSKI PANEL</h3>
							<div id="panel-opcije">
								<input type="button" onclick="izlistajVijesti()" value="VIJESTI">
								<input type="button" onclick="izlistajKomentare()" value="KOMENTARI">
								<input type="button" onclick="izlistajKorisnike()" value="KORISNICI">
							</div>
							<div id="panel-lista"></div>
							<div id="panel-forma"></div>
						</div>';
			if (isset($_REQUEST['odjava'])) {
				session_unset();
			}
			if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
				echo '<div id="prijava">
							<form method="POST" action="index.php" id="odjavaforma">
								Prijavljeni ste kao: <b>'.$_SESSION['username'].'</b>
								<input type="submit" name="odjava" value="ODJAVI SE">
							</form>
					  </div>';
				echo $panel;
			}
			else if (isset($_REQUEST['korisnickoime']) && isset($_REQUEST['lozinka'])) {
				$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
			    $query = $connection->prepare("SELECT korisnik, lozinka FROM korisnici WHERE korisnik=?");
			   	$query->execute(array($_REQUEST['korisnickoime']));
			    $match = $query->fetch(PDO::FETCH_ASSOC);
			    if (!$match || (md5($_REQUEST['lozinka']) != $match['lozinka'])) {
			    	echo '<div id="greskaprijava"><b>Greška:</b> Korisnički podaci nevalidni!</div>';
					echo $prijava;
			    }
			    else {
					$_SESSION['username'] = $_REQUEST['korisnickoime'];
				    $_SESSION['password'] = $_REQUEST['lozinka'];
					echo '<div id="prijava">
								<form method="POST" action="index.php" id="odjavaforma">
									Prijavljeni ste kao: <b>'.$_SESSION['username'].'</b>
									<input type="submit" name="odjava" value="ODJAVI SE">
								</form>
					  		</div>';
					echo $panel;
				}
			}
			else {
				echo $prijava;
			}
		?>
		
		
		<div id="zaglavlje">
			<div id="logo"><a href="index.php"><img id="grb" src="slike/visoko-grb.png" alt="Općina Visoko"></a></div>
			<div id="logotip">OPĆINA VISOKO</div>
		</div>
		<nav id="meni">
			<div class="meni-stavka">
				<ul>
					<li><a href="#vijesti" onclick="return changeHash('#vijesti'); return false;"><p>VIJESTI (db)</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>
					<li><a href="#vijesti-txt" onclick="return changeHash('#vijesti-txt'); return false;"><p>VIJESTI (txt)</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>
					<li><a href="#gradovi-pobratimi" onclick="return changeHash('#gradovi-pobratimi'); return false;"><p>GRADOVI POBRATIMI</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>
					<li><a href="#telefonski-brojevi" onclick="return changeHash('#telefonski-brojevi'); return false;"><p>TELEFONSKI BROJEVI</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>					
					<li><a href="_blank" onclick="toggleDropDownMenu(); return false;"><p>LINKOVI ￬</p></a></li>
				</ul>
			</div>
			<div id="podmeni">
				<div class="podmeni-stavka">
					<ul>
						<li><a href="#vlada-federacije-bih" onclick="return changeHash('#vlada-federacije-bih'); return false;"><p>Vlada Federacije BiH</p></a></li>
					</ul>
				</div>
				<div class="podmeni-stavka">
					<ul>
						<li><a href="#predsjednistvo-bih" onclick="return changeHash('#predsjednistvo-bih'); return false;"><p>Predsjedništvo BiH</p></a></li>
					</ul>
				</div>
				<div class="podmeni-stavka">
					<ul>
						<li><a href="#visoko-co-ba" onclick="return changeHash('#visoko-co-ba'); return false;"><p>Visoko.co.ba</p></a></li>
					</ul>
				</div>
			</div>
			<div class="meni-stavka">
				<ul>
					<li><a href="#kontakt" onclick="return changeHash('#kontakt'); return false;"><p>KONTAKT (js)</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>
					<li><a href="kontakt.php"><p>KONTAKT (php)</p></a></li>
				</ul>
			</div>
		</nav>
		<div id="sadrzaj">

<?php
						$one = $two = $three = $four = true;
						
						if (isset($_REQUEST['siguransam'])) {
							require("phpmailer/class.phpmailer.php");
						    $mail = new PHPMailer();
						    $mail->Username = "wtopcinavisoko@gmail.com";
						    $mail->Password = "wtopcinavisoko123"; 
						    $mail->AddAddress("asabanovic3@gmail.com");
							$mail->AddReplyTo(htmlentities($_REQUEST['reply-to'], ENT_QUOTES));
							//$mail->AddCC('vljubovic@etf.unsa.ba', 'Vedran Ljubović');
						    $mail->FromName = "WT Opcina Visoko";
						    $mail->Subject = "Podaci sa kontakt forme - Općina Visoko";
						    $mail->Body = html_entity_decode($_REQUEST['message-hidden'], ENT_NOQUOTES, 'UTF-8');
							$mail->CharSet = "UTF-8";
						    $mail->Host = "ssl://smtp.gmail.com";
						    $mail->Port = 465;
						    $mail->IsSMTP();
						    $mail->SMTPAuth = true;
						    $mail->From = $mail->Username;
						    if (!$mail->Send())
						        echo "Greška pri slanju emaila: ".$mail->ErrorInfo;
						    else {
								echo "<div id='zahvala'><h2>Zahvaljujemo se što ste nas kontaktirali.</h2></div>";
							}
						}
						
						else {
							$ip = $email = $email_p = $telefon = $kom = "";
							if (isset($_REQUEST['posalji'])) {
								$ip = htmlentities($_REQUEST['imeiprezime'], ENT_QUOTES);
								$email = htmlentities($_REQUEST['email'], ENT_QUOTES);
								$emailRegEx = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';
								$email_p = htmlentities($_REQUEST['email_potvrda'], ENT_QUOTES);
								$telefon = htmlentities($_REQUEST['telefon'], ENT_QUOTES);
								$kom = htmlentities($_REQUEST['komentar'], ENT_QUOTES);
								
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
									echo '<b>Ime i prezime:</b> '.$ip.'<br>';
									echo '<b>Email:</b> '.$email.'<br>';
									echo '<b>Telefon:</b> '.$telefon.'<br>';
									echo '<b>Komentar:</b><br><textarea readonly rows="10" cols="40">'.$kom.'</textarea><br>';
									echo '<br>Da li ste sigurni da želite poslati ove podatke?';
?>
									<form action="kontakt.php" method="post">
										<input type="hidden" id="message-hidden" name="message-hidden" value="<?=
											'IME I PREZIME: '.$ip.'; EMAIL: '.$email.'; TELEFON: '.$telefon.'; KOMENTAR: '.$kom
										?>">
										<input type="hidden" id="reply-to" name="reply-to" value="<?= $email ?>">
										<input type="submit"" name="siguransam" value="Siguran sam">
									</form>
<?php
								}
?>
								</div>
<?php
								echo '<hr><h3>Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke:</h3>';
							}
						}
?>
			<form id="forma" name="forma" action="kontakt.php" method="post">
					
					
					<div class="stavka_forme">
						<label for="imeiprezime">Ime i prezime: <label class="obavezno">*</label></label><br>
						<input type="text" id="imeiprezime" name="imeiprezime" size="30" value="<?php 
				          if (isset($_REQUEST['imeiprezime'])) 
				            print htmlentities($_REQUEST['imeiprezime'], ENT_QUOTES) ?>" onblur="provjeriImeIPrezime()">
						<label for="imeiprezime" id="greska1" class="greska">
							<?php 
								if ($one == false) {
									echo '<img src="slike/error-icon.png" alt="Upozorenje!"> Ime i prezime nije validno!';
								}
							?></label>
					</div>
					
					
					<div class="stavka_forme">
						<label for="email">Email: <label class="obavezno">*</label></label><br>
						<input type="text" id="email" name="email" size="30" value="<?php 
				          if (isset($_REQUEST['email'])) 
				            print htmlentities($_REQUEST['email'], ENT_QUOTES) ?>" onblur="provjeriEmail()">
						<label for="email" id="greska2" class="greska">
							<?php 
								if ($two == false) {
									echo '<img src="slike/error-icon.png" alt="Upozorenje!"> Email nije validan!';
								}
							?></label>
					</div>
					
					
					<div class="stavka_forme">
						<label for="email_potvrda">Potvrdi email: <label class="obavezno">*</label></label><br>
						<input type="text" id="email_potvrda" name="email_potvrda" size="30" value="<?php 
				          if (isset($_REQUEST['email_potvrda'])) 
				            print htmlentities($_REQUEST['email_potvrda'], ENT_QUOTES) ?>" onblur="crossValidirajEmail()">
						<label for="email_potvrda" id="greska4" class="greska">
							<?php 
								if ($three == false) {
									echo '<img src="slike/error-icon.png" alt="Upozorenje!"> Email adrese se ne slažu!';
								}
							?>
						</label>
					</div>
					
					<!-- ===== MJESTO INPUT ===== -->
					<div class="stavka_forme">
						<label for="mjesto">Mjesto: <label class="obavezno">*</label></label><br>
						<input type="text" id="mjesto" name="mjesto" size="30" value="<?php 
				          if (isset($_REQUEST['mjesto'])) 
				            print htmlentities($_REQUEST['mjesto'], ENT_QUOTES) ?>" onblur="validacijaMjestoOpcina()">
						<label for="mjesto" id="greska5" class="greska"></label>
					</div>
					
					<!-- ===== OPCINA INPUT ===== -->
					<div class="stavka_forme">
						<label for="opcina">Općina: <label class="obavezno">*</label></label><br>
						<input type="text" id="opcina" name="opcina" size="30" value="<?php 
				          if (isset($_REQUEST['opcina'])) 
				            print htmlentities($_REQUEST['opcina'], ENT_QUOTES) ?>" onblur="validacijaMjestoOpcina()">
						<label for="opcina" id="greska6" class="greska"></label>
					</div>
					
					
					<div class="stavka_forme">
						<label for="telefon">Telefon:</label><br>
						<input type="text" id="telefon" name="telefon" value="<?php 
          				  	if (isset($_REQUEST['telefon'])) 
            					print htmlentities($_REQUEST['telefon'], ENT_QUOTES) ?>" size="30">
					</div>
					
					
					<div class="stavka_forme">
						<label for="komentar">Komentar: <label class="obavezno">*</label></label><br>
						<textarea id="komentar" name="komentar" rows="10" cols="40" onblur="provjeriKomentar()"><?php if (isset($_REQUEST['komentar'])) print htmlentities($_REQUEST['komentar'], ENT_QUOTES) ?></textarea>
						<label for="email" id="greska3" class="greska">
							<?php 
								if ($four == false) {
									echo '<img src="slike/error-icon.png" alt="Upozorenje!"> Polje za komentar je prazno!';
								}
							?>
						</label>
					</div>
					
					
					<input type="submit" id="posalji" name="posalji" value="Pošalji">
			</form>

</div>
			<div id="dno">© 2015 Općina Visoko. Sva prava pridržana.</div>
	</body>
</html>