<?php
	session_start();
	function zag() {
		header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
		header('ContentType: text/html');
		header('AccessControlAllowOrigin: *');
	}
	function rest_get($request, $data) {
		$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
		$connection->exec("set names utf8");
		if (isset($data['id'])) {
			$commentsquery = $connection->prepare("SELECT * FROM komentari WHERE vijest=?");
			$commentsquery->execute(array($data['id']));
			$comments = $commentsquery->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($comments);
		}
		else {
			$commentsquery = $connection->prepare("SELECT * FROM komentari");
			$commentsquery->execute();
			$comments = $commentsquery->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($comments);
		}
	}
	function rest_post($request, $data) {
		if (isset($_POST['komentar']) && isset($_POST['vijest'])) {
			$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
			if (isset($_SESSION['username'])) {
				$query = $connection->prepare("SELECT * FROM korisnici WHERE korisnik=?");
			   	$query->execute(array($_SESSION['username']));
				$user = $query->fetch(PDO::FETCH_ASSOC);
				$newcomment = $connection->prepare("INSERT INTO komentari SET ime=?, email=?, komentar=?, vrijeme=?, vijest=?, korisnik=?");
				$newcomment->execute(array($user['korisnik'], $user['email'], $_POST['komentar'], date("Y-m-d H:i:s"), $_POST['vijest'], $user['id']));
			}
			else {
				$newcomment = $connection->prepare("INSERT INTO komentari SET komentar=?, vijest=?");
				$newcomment->execute(array($_POST['komentar'], $_POST['vijest']));
			}
		}
	}
	function rest_delete($request, $data) {
		if (isset($data['id'])) {
			$connection = new PDO("mysql:dbname=wt-opcinavisoko;host=localhost;charset=utf8", "opcina", "pass");
			$deletedcomment = $connection->prepare("DELETE FROM komentari WHERE id=?");
			$deletedcomment->execute(array($data['id']));
		}
	}
	function rest_put($request, $data) {}
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
			zag(); $data = $_GET; rest_delete($request, $data); break;
		default:
			header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
			rest_error($request); break;
	}
?>