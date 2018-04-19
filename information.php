<?php
/*
Information des erreurs et autre

information.php

*/

if(!isset($info_commande))
{
	$informations = array(/*Erreur*/
					true,
					'Erreur interne',
					'Une erreur interne est survenue...',
					'',
					ROOTPATH.'/index.php',
					3
					);
}
else
{
	switch($info_commande[0]) // On switch l'information importante, erreur ou information
	{
		case "true": // Information d'erreur
			switch($info_commande[1]) // Puis on switch les diverses erreurs
			{
				case "acces_denied": // Accès refusé (rang insuffisant)
					$informations = array(
									true,
									'Accès refusé',
									'L\'accès vous est refusé car vous n\'avez pas les droits d\'être ici.',
									'',
									ROOTPATH,
									3
									);
				break;
				
				case "acces_down": // Lien corrompu
					$informations = array(
									true,
									'Accès refusé',
									'L\'accès vous est refusé car le lien est corrompu.',
									'',
									ROOTPATH,
									3
									);
				break;
				
				case "acces_register_connect": // Si la personne accède à la page pour s'inscrire alors qu'il est déconnecte, on arrête.
					$informations = array(
									true,
									'Impossible de s\'inscrire en étant connecté.',
									'Vous ne pouvez vous inscrire pour la simple raison que vous ête actuellement connecté.',
									'',
									ROOTPATH,
									3
									);
				break;
				
				case "acces_not_connect": // Membre non connecté
					$informations = array( 
									true,
									'Accès impossible',
									'Vous devez être connecter pour pouvoir accèder à cette page.',
									'',
									ROOTPATH,
									3
									);
				break;
				
				case "connect_faillure_pseudo": // Connexion echoué, pseudo inexistant
					$informations = array(
									true,
									'Connexion échoué - Pseudo inexistant',
									'Le pseudo <strong>'.htmlspecialchars($info_commande[2]).'</strong> n\'existe pas. Veuillez réessayer.',
									' - <a href="'.ROOTPATH.'">Index</a>',
									ROOTPATH.'/?page=connexion',
									3
									);
				break;
				
				case "connect_faillure_password": // Connexion échoué, mot de passe incorrect
					$informations = array(
									true,
									'Connexion échoué - Mot de passe incorrect',
									'Vous avez fourni un mot de passe incorrecte.',
									' - <a href="'.ROOTPATH.'">Index</a>',
									ROOTPATH.'/?page=connexion',
									3
									);
				break;
				
				case "connect_faillure_membre_ban": // Connexion échoué, membre bannis
					$informations = array(
									true,
									'Connexion échoué - Vous avez été bannis',
									'Vous avez été bannis de '.TITRESITE.', en voilà la raison :
									<br/><br/><p><em><strong>'.htmlspecialchars($info_commande[2]).'</strong></em></p>',
									' - <a href="'.ROOTPATH.'/?page=contact">Contacter le Webmaster</a>',
									ROOTPATH,
									3
									);
				break;
				
				case "connect_faillure_membre_not_valid": // Connexion échoué, membre non validé
					$informations = array(
									true,
									'Connexion echoué - Compte non validé',
									'Vous n\'avez pas validé votre compte ! Contact le Webmaster pour plus d\'information.',
									' - <a href="'.ROOTPATH.'/?page=contact">Contacter le Webmaster</a>',
									ROOTPATH,
									3
									);
				break;
				
				case "connect_exists": // Membre déjà connecté
					$informations = array( 
									true,
									'Connexion impossible',
									'La connexion est impossible car vous êtes déjà connecté sous le pseudo <strong>'.$_SESSION['membre_pseudo'].'</strong>',
									' - <a href="'.ROOTPATH.'">Index</a>',
									'',
									3,
									);
				break;
				
				case "regist_faillure":
					$informations = array(
									true,
									'Erreur lors de l\'inscription',
									'Une erreur s\'est produite pendant l\'inscription. Veuillez réessayer.
									Si cette erreur persiste, veuillez contact le Webmaster.',
									' - <a href="'.ROOTPATH.'/?page=contact">Contacter le Webmaster</a>',
									ROOTPATH,
									3
									);
				break;
			}
		break;
		
		case "false": // Information réussie
			switch($info_commande[1]) // Puis on switch les diverses informations bonnes
			{
				case "connect_success": // Connexion réussie
					$informations = array(
									false,
									'Connexion réussie',
									'Vous êtes bien connecter sous le pseudo <strong>'.$_SESSION['membre_pseudo'].'</strong>.',
									'',
									ROOTPATH,
									3
									);
				break;
				
				case "regist_success": // Inscription réussie
					$informations = array(
									false,
									'Inscription réussie',
									'L\'inscription s\'est bien déroulée. '.$info_commande[2],
									' - <a href="'.ROOTPATH.'/?page=connexion">Se connecter</a>',
									ROOTPATH,
									3
									);
				break;
			}
		break;
	}
}

if($informations[0] === true) $type = 'erreur';
else $type = 'information';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<!-- Titre du site -->
		<title><?php echo $informations[1]; ?> : <?php echo TITRESITE; ?></title>
		<!-- Encodage du site -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- Page css du site -->
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="<?php echo ROOTPATH; ?>/design/style.css" />
		<!-- Langue du site -->
		<meta http-equiv="content-language" content="fr" />
		<!-- Page d'accueil du site -->
		<link rel="start" title="Index" href="index.php" />
		<!-- Page d'aide du site -->
		<link rel="help" title="Wiki" href="wiki.html" />
		<!-- Flux RSS du site -->
		<link rel="alternate" type="application/rss+xml" title="Flux RSS des news" href="news.xml" />
		<!-- Icône du site (favicon) -->
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
		<!-- Auteur de la page -->
		<meta name="author" content="Stevens Costa" />
		<!-- Description de la page -->
		<meta name="description" content="Accueil du site Help World" />
		<!-- Mots-clés de la page -->
		<meta name="keywords" content="help world, aide land, help, world, aide, land, astuces, tutoriels, astuce, tutoriel" />
		<!-- Adresse de contact -->
		<meta name="reply-to" content="webmaster@aide-land.fr" />
		<!-- Rafraîchissement vers ... -->
		<meta http-equiv="Refresh" content="<?php echo $informations[5]; ?>;url=<?php echo $informations[4]; ?>">
		<!-- Mini icône du site -->
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo ROOTPATH; ?>/design/icon.png" />
		<!-- BBcode.js -->
		<script type="text/javascript" src="../includes/bbcode.js"></script>
	</head>	
	
	<body>
		<div id="conteneur"><!-- Global -->
			<div id="header"> <!-- Header -->
				<ul class="slogan">
					<li class="slogan">Help World c'est de l'aide et de la convivialité</li><!-- Slogan -->
					<li class="slogan" id="vert">De l'help pour tout le world</li><!-- Slogan --> 
					<li class="slogan">Impossible n'est pas Help World</li><!-- Slogan -->
				</ul> 
			</div> <!-- Fin Header -->
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
						<div id="<?php echo $type; ?>"><h1><?php echo $informations[1]; ?></h1><br/><?php echo $informations[2]; ?><br/><br/><span style="color:black"><em>Redirection en cours...</em></span></div><br/>
						<div id="info"><a href="<?php echo $informations[4]; ?>">Cliquez ici si vous ne voulez pas attendre...</a><?php echo $informations[3]; ?></div>
					</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre --> 
		</div>
	</body>
</html>
<?php
unset($informations);
