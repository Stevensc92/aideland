<?php
session_start();
if(!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo'])) {
	header('location:index.php');
}
include('connect.php');
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
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="tchat.js"></script>
		<script type="text/javascript" src="refresh.js"></script>
		<script type="text/javascript">
			<?php
				$sql = "SELECT id FROM message ORDER BY id DESC LIMIT 1";
				$req = mysql_query($sql) or die(mysql_error());
				$data = mysql_fetch_assoc($req);
			?>
			var lastid = <?php echo $data['id']; ?>
		</script>
	</head>
	<body>
		<div id="conteneur" style="width:100%; margin-bottom:20px;">
			<h1>Mon tchat, connecté en tant que <?php echo htmlspecialchars($_SESSION['pseudo']); ?></h1>
			<div id="tchatFormRefresh">
				<form method="post" action="#">
					<input type="submit" name="refresh" value="Rafraîchir" />
				</form>
			</div>
			<div id="tchat" style="margin-top:50px;>
				<div id="lastPost">
					<?php
						$sql = "SELECT * FROM message ORDER BY date DESC LIMIT 15";
						$req = mysql_query($sql) or die(mysql_error());
						while($data = mysql_fetch_assoc($req)) {
							$d[] = $data;
						}
						for($i=count($d)-1;$i>=0;$i--) {
						?>
							<p><em>(<?php echo @mepd($d[$i]['date']); ?>)</em> <strong><?php echo $d[$i]['pseudo'];?></strong> : <?php echo htmlspecialchars(stripslashes($d[$i]['message'])); ?></p>
						<?php
						}
					?>
				</div>
			</div>
		</div>
		
		<div id="tchatForm" style="position:fixed;bottom:0;width:50%">
			<form method="post" action="#">
				<div style="bottom:20px; margin-bottom:10px;">
					<input type="text" name="message" style="width:750px; height:35px;" />
				</div>
				<div style="position:absolute; bottom:2px; margin-bottom:20px; left:800px;">
					<input type="submit" value="Envoyer" />
				</div>
			</form>
		</div>
	</body>
</html>