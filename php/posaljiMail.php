<?php
	session_start();
	require("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->Username = "wtopcinavisoko@gmail.com";
	$mail->Password = "wtopcinavisoko123"; 
	$mail->AddAddress("asabanovic3@gmail.com");
	$mail->AddReplyTo(htmlentities($_POST['replyto'], ENT_QUOTES));
	//$mail->AddCC('vljubovic@etf.unsa.ba', 'Vedran Ljubović');
	$mail->FromName = "WT Opcina Visoko";
	$mail->Subject = "Podaci sa kontakt forme - Općina Visoko";
	$mail->Body = html_entity_decode($_POST['messagehidden'], ENT_NOQUOTES, 'UTF-8');
	$mail->CharSet = "UTF-8";
	$mail->Host = "ssl://smtp.gmail.com";
	$mail->Port = 465;
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->From = $mail->Username;
	if (!$mail->Send()) {
		echo "Greška pri slanju emaila: ".$mail->ErrorInfo;
	}
?>