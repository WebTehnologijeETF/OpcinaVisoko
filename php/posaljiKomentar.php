<?php
	if ((isset($_POST['ime']) && isset($_POST['email']) && isset($_POST['komentar']) && isset($_POST['vijest'])) && ($_POST['ime'] != '' && $_POST['komentar'] != '')) {
		$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
		$newcomment = $connection->prepare("INSERT INTO komentari SET ime=?, email=?, komentar=?, vrijeme=?, vijest=?;");
		$newcomment->execute(array(htmlEntities($_POST['ime'], ENT_QUOTES), htmlEntities($_POST['email'], ENT_QUOTES), htmlEntities($_POST['komentar'], ENT_QUOTES), date("Y-m-d H:i:s", time()), htmlEntities($_POST['vijest'], ENT_QUOTES)));
	};
	header('Location: index.php');
	exit;
?>