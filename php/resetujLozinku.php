<?php
	session_start();
	if (isset($_POST['password']) && isset($_POST['encrypt'])) {
		$info["password"] = $_POST['password'];
		$info["encrypt"] = $_POST['encrypt'];
		$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
		$connection->exec("set names utf8");
		$query = $connection->prepare("SELECT id FROM korisnici WHERE md5(id)=?");
		$query->execute(array($_POST['encrypt']));
		$id = $query->fetchColumn();
		$info["user"] = $id;
		$resetquery = $connection->prepare("UPDATE korisnici SET lozinka=? WHERE id=?");
		$resetquery->execute(array(md5($_POST['password']), $id));
	}
?>