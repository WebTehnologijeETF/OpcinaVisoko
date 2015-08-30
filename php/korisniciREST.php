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
			$usersquery = $connection->prepare("SELECT * FROM korisnici WHERE id=?");
			$usersquery->execute(array($data['id']));
			$users = $usersquery->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($users);
		}
		else {
			$usersquery = $connection->prepare("SELECT * FROM korisnici");
			$usersquery->execute();
			$users = $usersquery->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($users);
		}
	}
	function rest_post($request, $data) {
		$connection = new PDO("mysql:dbname=opcinavisoko;host=opcinavisoko-wt2014.rhcloud.com;charset=utf8", "admin2qTw1WZ", "j__QSRtgvbDR");
		$newuser = $connection->prepare("INSERT INTO korisnici SET korisnik=?, admin=?, lozinka=?, email=?, imeprezime=?");
		$newuser->execute(array($data['korisnik'], $data['admin'], md5($data['lozinka']), $data['email'], $data['imeiprezime']));
	}
	function rest_delete($request, $data) {
		$connection = new PDO("mysql:dbname=opcinavisoko;host=opcinavisoko-wt2014.rhcloud.com;charset=utf8", "admin2qTw1WZ", "j__QSRtgvbDR");
		$userquery = $connection->prepare("SELECT admin FROM korisnici WHERE id=?");
		$userquery->execute(array($data['id']));
		$result = $userquery->fetchColumn();
		if ($result == 0) {
			$deleteduser = $connection->prepare("DELETE FROM korisnici WHERE id=?");
			$deleteduser->execute(array($data['id']));
		}
		else if ($result == 1) {
			$query = $connection->prepare("SELECT COUNT(korisnik) FROM korisnici WHERE admin=1");
			$query->execute();
			$number = $query->fetchColumn();
			if ($number >= 2) {
				$deleteduser = $connection->prepare("DELETE FROM korisnici WHERE id=?");
				$deleteduser->execute(array($data['id']));
			}
		}
	}
	function rest_put($request, $data) {
		$connection = new PDO("mysql:dbname=opcinavisoko;host=opcinavisoko-wt2014.rhcloud.com;charset=utf8", "admin2qTw1WZ", "j__QSRtgvbDR");
		$updateduser = $connection->prepare("UPDATE korisnici SET admin=?, korisnik=?, lozinka=?, email=?, imeprezime=? WHERE id=?");
		$updateduser->execute(array($data['admin'], $data['korisnik'], md5($data['lozinka']), $data['email'], $data['imeiprezime'], $data['id']));
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
			zag(); $data = $_GET; rest_delete($request, $data); break;
		default:
			header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
			rest_error($request); break;
	}
?>