<?php
/*
page/deconnexion.php

Permet de se déconnecter au site.
*/
if(isset($_SESSION['membre_id']))
{
	mysql_query("DELETE FROM site_connectes 
				WHERE connectes_id = ".$_SESSION['membre_id']) 
				or ErrorSQL(__FILE__,__LINE__);

	vider_cookie();
	session_destroy();

	$informations = Array(/*Déconnexion*/
					false,
					'Déconnexion',
					'Vous êtes à présent déconnecté.',
					' - <a href="'.ROOTPATH.'/?page=connexion">Se connecter</a>',
					ROOTPATH,
					3,
					'Déconnexion'
					);

	require_once('information.php');
	exit();
}
else
{
	header("Location: http://localhost/");
	exit;
}
?>