<?php
	session_start();
	session_set_cookie_params(3600);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="stil.css">
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<title>Općina Visoko</title>
		<script src="javascript/dropDownMenu.js" type="text/javascript"></script>
		<script src="javascript/SPA.js" type="text/javascript"></script>
		<script src="javascript/validacijaForme.js" type="text/javascript"></script>
		<script src="javascript/zamgerProizvodi.js" type="text/javascript"></script>
		<script src="javascript/CRUD.js" type="text/javascript"></script>
	</head>
	<body>

<?php
	if (isset($_GET['encrypt'])) {
		echo '<form action="reset.php" id="passwordreset" method="post" onsubmit="resetujLozinku(); return false;">
				<input type="password" id="passwordproposal">
				<input type="hidden" id="encrypt" value="'.htmlspecialchars($_GET['encrypt'], ENT_QUOTES, 'UTF-8').'">
				<input type="submit" value="Resetuj">
			</form>';
	}
?>

	</body>
</html>
