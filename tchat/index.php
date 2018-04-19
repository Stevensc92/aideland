<?php
if(!empty($_POST) && isset($_POST['pseudo']) && !empty($_POST['pseudo'])) {
	session_start();
	$_SESSION['pseudo'] = $_POST['pseudo'];
	header('location:tchat.php');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>Mon tchat</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- Page css du site -->
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="style.css" />
		<!-- Langue du site -->
		<meta http-equiv="content-language" content="fr" />
	</head>
	<body>
		<div id="conteneur">
			<h1>Mon tchat</h1>
			<form action="index.php" method="post">
				<label for="pseudo">Pseudo :</label> <input type="text" name="pseudo" /><br/>
				<input type="submit" value="Tchatter" />
			</form>	
		</div>
	</body>
</html>