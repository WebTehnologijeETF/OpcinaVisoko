<?php
	session_start();
	session_set_cookie_params(3600);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="stil.css">
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<title>Općina Visoko</title>
		<script src="javascript/otvoriDetaljnije.js" type="text/javascript"></script>
		<script src="javascript/dropDownMenu.js" type="text/javascript"></script>
		<script src="javascript/SPA.js" type="text/javascript"></script>
		<script src="javascript/validacijaForme.js" type="text/javascript"></script>
		<script src="javascript/zamgerProizvodi.js" type="text/javascript"></script>
		<script src="javascript/CRUD.js" type="text/javascript"></script>
	</head>
	<body onload="replaceContent(); hideDropDownMenu(); hideLoginForm(); hideRegisterForm();" onhashchange="replaceContent()">
		
		
<?php
			$prijava = '<div id="prijava">
							<input type="button" id="dugmePrijava" value="PRIJAVA" onclick="showLoginForm()">
							<input type="button" id="dugmeRegistracija" value="REGISTRACIJA" onclick="showRegisterForm()"><br><hr>
							<form method="POST" action="index.php" id="prijavaforma">
								<label for="korisnickoime">KORISNIČKO IME: </label><input type="text" id="korisnickoime" name="korisnickoime">
								<label for="lozinka">LOZINKA: </label><input type="password" id="lozinka" name="lozinka">
								<input type="submit" value="PRIJAVI SE">
							</form>
							<form method="POST" action="index.php" id="regforma">
								<label for="korisnickoimereg">KORISNIČKO IME: </label><input type="text" id="korisnickoimereg" name="korisnickoimereg"><br>
								<label for="lozinkareg">LOZINKA: </label><input type="password" id="lozinkareg" name="lozinkareg"><br>
								<label for="imeiprezimereg">IME I PREZIME: </label><input type="text" id="imeiprezimereg" name="imeiprezimereg"><br>
								<label for="emailreg">EMAIL: </label><input type="text" id="emailreg" name="emailreg"><br>
								<input type="submit" value="REGISTRUJ SE">
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
			/*if (isset($_POST['komentar-komentatora']) && isset($_POST['id-vijesti'])) {
				$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
				if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
					$query = $connection->prepare("SELECT * FROM korisnici WHERE korisnik=?");
			   		$query->execute(array($_SESSION['username']));
					$user = $query->fetch(PDO::FETCH_ASSOC);
					$newcomment = $connection->prepare("INSERT INTO komentari SET ime=?, email=?, komentar=?, vrijeme=?, vijest=?, korisnik=?");
					$newcomment->execute(array($user['korisnik'], $user['email'], $_POST['komentar-komentatora'], date("Y-m-d H:i:s"), $_POST['id-vijesti'], $user['id']));
				}
				else {
					$newcomment = $connection->prepare("INSERT INTO komentari SET komentar=?, vijest=?");
					$newcomment->execute(array($_POST['komentar-komentatora'], $_POST['id-vijesti']));
				}
			}*/
			if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
				echo '<div id="prijava">
							<form method="POST" action="index.php" id="odjavaforma">
								Prijavljeni ste kao: <b>'.$_SESSION['username'].'</b>
								<input type="submit" name="odjava" value="ODJAVI SE">
							</form>
					  </div>';
				$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
			    $query = $connection->prepare("SELECT admin FROM korisnici WHERE korisnik=?");
			   	$query->execute(array($_SESSION['username']));
			    $result = $query->fetchColumn();
				if ($result == 1) {
					echo $panel;
				}
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
					$query = $connection->prepare("SELECT admin FROM korisnici WHERE korisnik=?");
					$query->execute(array($_SESSION['username']));
					$result = $query->fetchColumn();
					if ($result == 1) {
						echo $panel;
					}
				}
			}
			else if (isset($_REQUEST['korisnickoimereg']) && isset($_REQUEST['lozinkareg']) && isset($_REQUEST['imeiprezimereg']) && isset($_REQUEST['emailreg'])) {
				$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
			    $query = $connection->prepare("SELECT COUNT(korisnik) FROM korisnici WHERE korisnik=?");
				$query->execute(array($_REQUEST['korisnickoimereg']));
				$result = $query->fetchColumn();
				if ($result == 1) {
					echo '<div id="greskaprijava"><b>Greška:</b> Korisnik sa takvim imenom već postoji!</div>';
					echo $prijava;
				}
				else {
					$newuser = $connection->prepare("INSERT INTO korisnici SET korisnik=?, admin=?, lozinka=?, email=?, imeprezime=?");
					$newuser->execute(array($_REQUEST['korisnickoimereg'], '0', md5($_REQUEST['lozinkareg']), $_REQUEST['emailreg'], $_REQUEST['imeiprezimereg']));
					echo '<div id="uspjesnaprijava"><b>Uspjeh:</b> Prijavite se sa registrovanim podacima.</div>';
					echo $prijava;
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
		<div id="sadrzaj"></div>
		<div id="dno">© 2015 Općina Visoko. Sva prava pridržana.</div>
	</body>
</html>