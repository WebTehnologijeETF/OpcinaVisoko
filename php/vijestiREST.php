<?php
	function zag() {
		header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
		header('ContentType: text/html');
		header('AccessControlAllowOrigin: *');
	}
	function rest_get($request, $data) {
		$connection = new PDO("mysql:dbname=opcinavisoko;host=opcinavisoko-wt2014.rhcloud.com;charset=utf8", "admin2qTw1WZ", "j__QSRtgvbDR");
		$connection->exec("set names utf8");
		if (isset($data['id'])) {
			$articlequery = $connection->prepare("SELECT * FROM vijesti WHERE id=?");
			$articlequery->execute(array($data['id']));
			$article = $articlequery->fetch(PDO::FETCH_ASSOC);
			echo json_encode($article);
		}
		else {
			$articlesquery = $connection->prepare("SELECT * FROM vijesti");
			$articlesquery->execute();
			$articles = $articlesquery->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($articles);
		}
	}
	function rest_post($request, $data) {
		$connection = new PDO("mysql:dbname=opcinavisoko;host=opcinavisoko-wt2014.rhcloud.com;charset=utf8", "admin2qTw1WZ", "j__QSRtgvbDR");
		$newarticle = $connection->prepare("INSERT INTO vijesti SET naslov=?, autor=?, datum=?, tekst=?, detaljnije=?, slika=?;");
		$newarticle->execute(array($data['naslov'], $data['autor'], date('Y-m-d H:i:s'), $data['tekst'], $data['detaljnije'], $data['slika']));
	}
	function rest_delete($request, $data) {
		$connection = new PDO("mysql:dbname=opcinavisoko;host=opcinavisoko-wt2014.rhcloud.com;charset=utf8", "admin2qTw1WZ", "j__QSRtgvbDR");
		$deletedcomments = $connection->prepare("DELETE FROM komentari WHERE vijest=?");
		$deletedcomments->execute(array($data['id']));
		$deletedarticle = $connection->prepare("DELETE FROM vijesti WHERE id=?");
		$deletedarticle->execute(array($data['id']));
	}
	function rest_put($request, $data) {
		$connection = new PDO("mysql:dbname=opcinavisoko;host=opcinavisoko-wt2014.rhcloud.com;charset=utf8", "admin2qTw1WZ", "j__QSRtgvbDR");
		$updatedarticle = $connection->prepare("UPDATE vijesti SET naslov=?, autor=?, tekst=?, detaljnije=?, slika=? WHERE id=?");
		$updatedarticle->execute(array($data['naslov'], $data['autor'], $data['tekst'], $data['detaljnije'], $data['slika'], $data['id']));
	}
	function rest_error($request) {}
	$method = $_SERVER['REQUEST_METHOD'];
	$request = $_SERVER['REQUEST_URI'];
	switch ($method) {
		case 'PUT':
			parse_str(file_get_contents('php://input'), $put_vars);
			zag(); $data = $put_vars; rest_put($request, $data); break;
		case 'POST':
			zag(); $data = $_POST; rest_post($request, $data); break;
		case 'GET':
			zag(); $data = $_GET; rest_get($request, $data); break;
		case 'DELETE':
			zag(); $_data = $_GET; rest_delete($request, $data); break;
		default:
			header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
			rest_error($request); break;
	}
?>