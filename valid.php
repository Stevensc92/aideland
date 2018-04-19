<?php
/*
Validation des comptes

Valid.php
*/

session_start();
header('Content-type: text/html; charset=utf-8');

/* Config du site et fonctions */
include('config/config.php');
include('includes/fonctions.php');

/********Actualisation de la session...**********/

connexionbdd();
actualiser_session();

/********Fin actualisation de session...**********/

/* Titre de la page */
$titre = 'Validation';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Validation ';
/******************************************************/



if(isset($_GET['pseudo']) AND isset($_GET['mdp']))
{
	$_GET['pseudo'] = htmlspecialchars($_GET['pseudo']);
	$_GET['mdp'] = htmlspecialchars($_GET['mdp']);
	$reponse = mysql_query("SELECT * 
							FROM site_membres 
							WHERE pseudo = '".$_GET['pseudo']."'") 
	or ErrorSQL(__FILE__,__LINE__);
	$donnees = mysql_fetch_assoc($reponse);
	
	$update = mysql_query("UPDATE site_membres 
							SET valider = '1', groupe = 'Membre' 
							WHERE pseudo = '".$_GET['pseudo']."'")
	or ErrorSQL(__FILE__,__LINE__);
	
	if($_GET['mdp'] != $donnees['mdp'])
    {
        $informations = array(
                        true,
                        'Validation échoué',
                        'Validation échoué, le mot de passe indiqué dans le lien est faux.',
                        ' - <a href="'.ROOTPATH.'/">Index</a>',
                        ROOTPATH,
                        5
                        );
        require_once('information.php');
        exit();
    }
	if($donnees['valider'] == '1')
	{
		$informations = array( /* Validation échoué - Déjà faite */
						true,
						'Validation échoué',
						'Votre compte est déjà validé. Vous pouvez déjà vous connecter avec vos identifiants.',
						' - <a href="'.ROOTPATH.'/?page=connexion">Se connecter</a>',
						ROOTPATH.'/?page=connexion',
						5
						);
		require_once('information.php');
		exit();
	}
	if($update)
	{
		$informations = array( /* Validation réussi */
						false,
						'Validation réussie',
						'Votre compte à bien été valider. Vous pouvez dès maintenant vous connecter avec vos identifiants.',
						' - <a href="'.ROOTPATH.'/?page=connexion">Se connecter</a>',
						ROOTPATH.'/?page=connexion',
						5
						);
		require_once('information.php');
		exit();
	}
	else
	{
		$informations = array( /* Validation échoué */
						true,
						'Validation échoué',
						'Validation échoué. Contacter le Webmaster du site pour plus d\'information.',
						' - <a href="'.ROOTPATH.'/?page=contact">Contacter le Webmaster</a>',
						ROOTPATH.'/?page=contact',
						5
						);
		require_once('information.php');
		exit();
	}
}
else
{
	$informations = array( /* Validation échoué */
					true,
					'Validation échoué',
					'Validation échoué. Contacter le Webmaster du site pour plus d\'information.',
					' - <a href="'.ROOTPATH.'/?page=contact">Contacter le Webmaster</a>',
					ROOTPATH.'/?page=contact',
					5
					);
	require_once('information.php');
	exit();
}
?>