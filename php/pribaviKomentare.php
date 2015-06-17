<?php
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
		$connection->exec("set names utf8");
		$commentsquery = $connection->prepare("SELECT id, ime, email, komentar, vrijeme FROM komentari WHERE vijest=?");
		$commentsquery->execute(array($id));
		$comments = $commentsquery->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($comments);
	}
?>