<?php
session_start();
require('connect.php');
$d = array();

if(!isset($_SESSION['pseudo']) || empty($_SESSION['pseudo']) || !isset($_POST['action'])) {
	$d['erreur'] = 'Vous devez être connecté pour utiliser le tchat.';
}
else {
	extract($_POST);
	$pseudo = mysql_real_escape_string($_SESSION['pseudo']);
	
	/**
	 * Action : addMessage
	 * Permet l'ajout d'un message
	 * */
	if($_POST['action'] == 'addMessage'){
		$message = mysql_real_escape_string($_POST['message']);
		$sql = "INSERT INTO message(pseudo,message,date) VALUES('".$pseudo."', '".$message."', ".time().")";
		mysql_query($sql) or die(mysql_error());
		$d['erreur'] = 'ok';
	}
	
	/**
	 * Action : getMessages
	 * Permet l'affichage des derniers messages
	 * */
	if($_POST['action'] == 'getMessages'){
		$lastid = floor($lastid);
		$sql = "SELECT * FROM message WHERE id > $lastid ORDER BY date ASC";
		$req = mysql_query($sql) or die(mysql_error());
		$d['result'] = '';
		$d['lastid'] = $lastid;
		while($data = mysql_fetch_assoc($req)){
			$d['result'] .= '<div id="newPost"><p><em>('.@mepd($data['date']).')</em> <strong>'.$data['pseudo'].'</strong> : '.htmlspecialchars(stripslashes($data['message'])).'</p></div>';
			$d['lastid'] = $data['id'];
		}
		$d['erreur'] = 'ok';
	}

}

echo json_encode($d);
?>