<?php
if(isset($_SESSION['membre_id']))
{
	$info_commande = array('true', 'acces_denied');
	echo $info_commande[0].'<br/>';
	echo $info_commande[1];
}
else
{
	$info_commande = array('true', 'acces_not_connect');
	require_once('information.php');
	exit();
}
?>