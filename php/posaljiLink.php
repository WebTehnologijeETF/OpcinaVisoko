<?php
	session_start();
	if (isset($_POST['korisnik'])) {
		$connection = new PDO("mysql:dbname=opcinavisoko;host=opcinavisoko-wt2014.rhcloud.com;charset=utf8", "admin2qTw1WZ", "j__QSRtgvbDR");
		$connection->exec("set names utf8");
		$usersquery = $connection->prepare("SELECT id FROM korisnici WHERE korisnik=?");
		$usersquery->execute(array($_POST['korisnik']));
		$userid = $usersquery->fetchColumn();
		$emailquery = $connection->prepare("SELECT email FROM korisnici WHERE korisnik=?");
		$emailquery->execute(array($_POST['korisnik']));
		$email = $emailquery->fetchColumn();
		$encrypt = md5($userid);
		require("phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->Username = "wtopcinavisoko@gmail.com";
		$mail->Password = "wtopcinavisoko123"; 
		$mail->AddAddress($email);
		$mail->FromName = "WT Opcina Visoko";
		$mail->Subject = "Link potvrde za resetovanje lozinke";
		$mail->Body = html_entity_decode("Klik na link: http://localhost/wt-opcinavisoko/reset.php?encrypt=".$encrypt."&action=reset", ENT_NOQUOTES, 'UTF-8');
		$mail->CharSet = "UTF-8";
		$mail->Host = "ssl://smtp.gmail.com";
		$mail->Port = 465;
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->From = $mail->Username;
		if (!$mail->Send()) {
			echo "Greška pri slanju emaila: ".$mail->ErrorInfo;
		}
	}
?>