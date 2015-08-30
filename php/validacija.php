<?php
	$ime = $_POST['ime'];
	$email = $_POST['email'];
	$emailRegEx = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';
	$emailp = $_POST['emailp'];
	$komentar = $_POST['komentar'];
	$greske = array(
		"greska1" => "0",
		"greska2" => "0",
		"greska3" => "0",
		"greska4" => "0",
	);
	if (strlen($ime) < 5 || strlen($ime) > 50) {
		$greske["greska1"] = "1";
	}
	if (!preg_match($emailRegEx, $email)) {
		$greske["greska2"] = "1";
	}
	if ($emailp != $email) {
		$greske["greska3"] = "1";
	}
	if (strlen($komentar) == 0) {
		$greske["greska4"] = "1";
	}
	echo json_encode($greske);
?>