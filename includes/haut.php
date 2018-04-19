<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
	<?php
        $timezone   = date_default_timezone_set('Europe/Paris');
	if(isset($titre) && trim($titre) != '') // On v&eacute;rifie si la variable $titre existe et trim retire les espaces en d&eacute;but et fin de chaîne
	{
		$titre = TITRESITE.' : '.$titre; 
	}
	else
	{
		$titre = TITRESITE;
	}
	
	if(isset($_SESSION['membre_pseudo']))
	{
		$reponse = mysql_query("SELECT rang, pseudo 
								FROM site_membres 
								WHERE id=".$_SESSION['membre_id']."") 
								or ErrorSQL(__FILE__,__LINE__);
		$donnees = mysql_fetch_array($reponse);
		$sql5 = mysql_query("SELECT * 
							 FROM site_mp 
							 WHERE mp_receveur = '".$_SESSION['membre_id']."' AND mp_lu = '0'") 
							 or ErrorSQL(__FILE__,__LINE__);
		$req5 = mysql_num_rows($sql5);
		if($req5 <= 0)
		{
			$new_mp = '0 Nouveau message';
		}
		elseif($req5 == 1)
		{
			$new_mp = '<span class="new_mp">'.$req5.' nouveau message</span>';
		}
		else
		{
			$new_mp = '<span class="new_mp">'.$req5.' Nouveaux messages</span>';
		}
	}
	?>
		<title><?php echo $titre; ?></title>
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
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo ROOTPATH; ?>/design/icon.png" />
		<!-- Auteur de la page -->
		<meta name="author" content="Stevens Costa" />
		<!-- Description de la page -->
		<meta name="description" content="Accueil du site Help World" />
		<!-- Mots-cl&eacute;s de la page -->
		<meta name="keywords" content="help world, aide land, help, world, aide, land, astuces, tutoriels, astuce, tutoriel" />
		<!-- Adresse de contact -->
		<meta name="reply-to" content="webmaster@aide-land.fr" />
		<!-- BBcode.js -->
		<script type="text/javascript" src="../includes/bbcode.js"></script>
		<!-- Librairie Jquery -->
		<script type="text/javascript" src="../includes/jquery.js"></script>
		<!-- Divers JS -->
		<script type="text/javascript" src="../includes/js.js"></script>
	</head>
	<body>
		<div id="conteneur"><!-- Global -->
			<div id="header"> <!-- Header -->
				<ul class="slogan">
					<li class="slogan">Help World c'est de l'aide et de la convivialit&eacute;</li><!-- Slogan -->
					<li class="slogan" id="vert">De l'help pour tout le world</li><!-- Slogan --> 
					<li class="slogan">Impossible n'est pas Help World</li><!-- Slogan -->
				</ul> 
			</div> <!-- Fin Header -->
		
			<div id="left"><!-- Colonne Gauche -->
				<?php
				if(isset($_SESSION['membre_id']))
				{
					$pseudo_false = array('Vegeta21', 'Stevens', 'Darky');
					if($donnees['rang'] >=10 || $_SESSION['membre_pseudo'] == 'Vegeta21' || $_SESSION['membre_pseudo'] == 'Darky')
					{
					?>
					<div class="mh">Administration</div> <!-- Menu -->
						<div class="mf"><!-- Contenu menu -->
							<ul class="menu">
							<?php
								if($donnees['rang'] >= 90)
								{
								?>
								<li><a href="<?php echo ROOTPATH; ?>/?mod=modif_membre" class="lien_MV">Modifier un membre</a></li>
								<li><a href="<?php echo ROOTPATH; ?>/?mod=ajout_news" class="lien_MV">Ajouter une news</a></li>
								<li><a href="<?php echo ROOTPATH; ?>/?mod=delete_news" class="lien_MV">Supprimer une news</a></li>
								<li><a href="<?php echo ROOTPATH; ?>/?mod=sondage" class="lien_MV">G&eacute;rer les sondages</a></li>
								<?php
								}
								if($donnees['rang'] == 10 || $donnees['rang'] == 15 || $donnees['rang'] == 90 || $donnees['rang'] == 100)
								{
								?>
								<li><a href="<?php echo ROOTPATH; ?>/astuce/?correc=correc" class="lien_MV">Interface des corrections</a></li>
								<?php
								}
								if($_SESSION['membre_pseudo'] == 'Vegeta21' || $_SESSION['membre_pseudo'] == 'Stevens' || $_SESSION['membre_pseudo'] == 'slidox')
								{
								?>
								<li><a href="<?php echo ROOTPATH; ?>/?2fight=classe" class="lien_MV">2Fight : Classes</a></li>
								<?php
								}
								if(in_array($_SESSION['membre_pseudo'], $pseudo_false))
								{
								?>
								<li><a href="<?php echo ROOTPATH; ?>/?2fight=tournois" class="lien_MV">2Fight : Tournois DA</a></li>
								<?php
								}
								?>
							</ul>
						</div> <!-- Fin contenu menu -->
					<div class="mb"></div> <!-- Fin menu -->
					<?php
					}
				}
				?>
				<div class="mh">Menu</div> <!-- Menu -->
					<div class="mf"><!-- Contenu menu -->
						<ul class="menu">
							<li><a href="<?php echo ROOTPATH; ?>/">Accueil</a></li>
							<li><a href="<?php echo ROOTPATH; ?>/?page=contact">Contact</a></li>
							<li><a href="<?php echo ROOTPATH; ?>/?page=livreor">Livre d'Or</a></li>
							<li><a href="<?php echo ROOTPATH; ?>/?page=new">News</a></li>
							<?php
							if(isset($_SESSION['membre_id']))
							{
								$pseudo = array('Stevens', 'Arkana', 'Kylia');
								if(in_array($_SESSION['membre_pseudo'], $pseudo))
								{
							?>
								<li><a href="<?php echo ROOTPATH; ?>/?mod=cdc">Cahier des charges</a></li>
							<?php
								}
							?>
								<li><a href="<?php echo ROOTPATH; ?>/astuce/">Astuces</a></li>
								<li><a href="<?php echo ROOTPATH; ?>/tutoriel/">Tutoriels</a></li>
							<?php
							}
							?>
							<li><a href="<?php echo ROOTPATH; ?>/forum/">Forum</a></li>
							<?php
							if(isset($_SESSION['membre_id']))
							{
							?>
								<li><a href="<?php echo ROOTPATH; ?>/?page=deconnexion">Se d&eacute;connecter</a></li>
							<?php
							}
							else
							{
							?>
								<li><a href="<?php echo ROOTPATH; ?>/?page=inscription">S'inscrire</a></li>
								<li><a href="<?php echo ROOTPATH; ?>/?page=connexion">Se connecter</a></li>
							<?php
							}
							?>
						</ul>	     
					</div><!-- Fin contenu menu -->
				<div class="mb"></div><!-- Fin Menu -->
				
				<div class="mh">Statistiques</div> <!-- Menu -->
					<div class="mf"> <!-- Contenu menu -->
						<ul class="menu">
							<li>0 Visite</li>
							<li><a href="<?php echo ROOTPATH; ?>/?page=membre"><?php echo $num1 = get('nb_membres'); if($num1 <= 1) echo ' Membre inscrit'; else echo ' Membres inscrits'; ?></a></li>
							<li><a href="<?php echo ROOTPATH; ?>/?page=connecter"><?php echo $num2 = get('connectes'); if($num2 <= 1) echo ' Visiteur'; else echo ' Visiteurs' ?></a></li>
						</ul>
					</div> <!-- Fin contenu menu -->
				<div class="mb"></div> <!-- Fin Menu -->			
			</div><!-- Fin Colonne Gauche -->
			
			<div id="right"><!-- Colonne Droite --> 
				<div class="mh">Zone membre</div> <!-- Menu -->
					<div class="mf"><!-- Contenu menu -->
					<?php
					if(!isset($_SESSION['membre_id'])) {
					// Si le membre n'est pas connect&eacute;, on affiche le formulaire de connexion
					?>
						<form method="post" action="<?php echo ROOTPATH; ?>/?page=connexion">
							<div>
								<input type="text" name="pseudo" id="pseudo" value="Pseudo" size="16" onfocus="if(this.value=='Pseudo')this.value='';" onblur="if(!this.value)this.value='Pseudo';" /><br/>
								<input type="password" name="password" id="mdp" value="password" size="16" onfocus="if(this.value=='password')this.value='';" onblur="if(!this.value)this.value='password';" /><br/>
								<input type="checkbox" name="cookie" value="cookie" id="cookie"/> <label for="cookie">Connexion automatique</label>
								<input type="submit" value="Connexion" name="connexion" />
							</div>
						</form>
						<ul class="menu">
							<li><a href="<?php echo ROOTPATH; ?>/?page=inscription">Pas encore inscrit ?</a></li>
							<li><a href="<?php echo ROOTPATH; ?>/?page=mon_compte&amp;mod=reset">Mot de passe oubli&eacute;?</a></li>
						</ul>
					<?php
					}
					else {
					// Si le membre est connect&eacute;, on affiche quelque info
						if(date("H") >= 17 OR date("H") <= 7) {
							echo 'Bonsoir';
						}
						else {
							echo 'Bonjour';
						}
						echo ' <a href="'.ROOTPATH.'/?page=membre&amp;id='.$_SESSION['membre_id'].'">'.$_SESSION['membre_pseudo'].'</a>';
						?>
						<ul class="menu">
							<li><a href="<?php echo ROOTPATH; ?>/?page=mon_compte&amp;mod=modif">Modifier mon compte</a></li>
							<li><a href="<?php echo ROOTPATH; ?>/?page=mp">Voir mes messages (<?php echo $new_mp; ?>)</a></li>
							<li><a href="<?php echo ROOTPATH; ?>/?page=friends">Voir mes amis</a></li>
							<li><a href="<?php echo ROOTPATH; ?>/?page=deconnexion">Me d&eacute;connecter</a></li>
						</ul>
						<?php
					}
					?>
					</div> <!-- Fin contenu menu -->
				<div class="mb"></div><!-- Fin Menu -->

				<div class="mh">Rechercher</div> <!-- Menu -->
					<div class="mf"><!-- Contenu menu -->
						<form method="post" action="rechercher.php" id="search"> 
							<div>
								<input name="search" type="text" value="rechercher" size="16" onfocus="if(this.value=='rechercher')this.value='';" onblur="if(!this.value)this.value='rechercher';"/><br />
								<input name="submit" type="submit" class="Button" value="D&eacute;sactiver" alt="Lancer la recherche!" disabled="disabled"/>
							</div>
						</form> 
					</div> <!-- Fin contenu menu -->
				<div class="mb"></div><!-- Fin Menu -->

				<div class="mh">Newsletter</div> <!-- Menu -->
					<div class="mf"><!-- Contenu menu -->
						<form method="post" action="mail.php" id="mail">
							<div>
								<input name="search" type="text" value="Email" size="16" onfocus="if(this.value=='Email')this.value='';" onblur="if(!this.value)this.value='Email';"/><br/>
								<input type="radio" name="register_nl" id="register_nl" checked="checked" />S'inscrire<br/>
								<input type="radio" name="delete_nl" id="delete_nl" />Se d&eacute;sinscrire
								<input name="submit" type="submit" class="Button" value="D&eacute;sactiver" alt="Lancer la recherche!" disabled="disabled"/>	
							</div>
						</form>	 
					</div> <!-- Fin contenu menu -->
				<div class="mb"></div><!-- Fin Menu -->				
			</div><!-- Fin Colonne Droite -->
			
			<div class="content"><!-- D&eacute;but centre -->	 
				<div class="nh"></div> <!-- News -->
				<div class="nf">
					<p class="down">
						Cette version est vou&eacute;e &agrave; l'abandon, je vous souhaite d'aller sur celle-ci : <a href="http://help-land.com">Help Land</a>.
					</p>
				</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre code pin : 45848230 -->