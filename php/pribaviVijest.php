<?php
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
		$connection->exec("set names utf8");
		$newsquery = $connection->prepare("SELECT id, datum, autor, naslov, tekst, detaljnije, slika FROM vijesti WHERE id=?");
		$newsquery->execute(array($id));
		$news = $newsquery->fetch(PDO::FETCH_ASSOC);
		echo json_encode($news);
	}
?>