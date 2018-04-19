<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
	<?php
	if(isset($titre) && trim($titre) != '') // On vérifie si la variable $titre existe et trim retire les espaces en début et fin de chaîne
	{
		$titre = TITRESITE.' : '.$titre; 
	}
	else
	{
		$titre = TITRESITE;
	}
	
	if(isset($_SESSION['membre_pseudo']))
	{
		$reponse = mysql_query("SELECT membre_rang, membre_pseudo FROM membres WHERE membre_id=".$_SESSION['membre_id']."");
		$donnees = mysql_fetch_array($reponse);
	}
	?>
		<title><?php echo $titre; ?></title>
		<meta name="language" content="fr" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>/design/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>/forum/design/forum_design.css" type="text/css" media="screen" />
		<link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>/tutoriel/design/tutoriel_design.css" type="text/css" media="screen" />
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo ROOTPATH; ?>/design/icon.png" />
		<script type="text/javascript" src="<?php echo ROOTPATH; ?>/includes/bbcode.js"></script>
	</head>
	<body>
		<div id="global">
		<!-- Menu Horizontal indépendant du statut du visiteur. -->
			<div class="MH">
				<ul class="structure_MH">
					<li class="bouton_MH"><a href="<?php echo ROOTPATH; ?>" class="lien_MH">Accueil</a></li>
					<li class="bouton_MH"><a href="<?php echo ROOTPATH; ?>/?page=contact" class="lien_MH">Contact</a></li>
					<li class="bouton_MH"><a href="<?php echo ROOTPATH; ?>/forum/index.php" class="lien_MH">Forum</a></li>
				</ul>
			</div>
		<!-- Fin -->
		
		<!-- Banniere -->
			<a href="<?php echo ROOTPATH; ?>"><div id="banniere"></div></a>
		<!-- Fin -->
		
		<!-- "Bordure" -->
			<div class="CHG"></div><div class="BH"></div><div class="CHD"></div>
			<div class="BG"><div class="taille_minimale_bordure_gauche"></div></div>
		<!-- Fin -->
		
		<!-- Corps de la page -->
			<div id="corps">
			
			<!-- Menu Dépendant du Statut du visiteur -->
				<!-- Statut En Ligne -->
				<?php
				if(isset($_SESSION['membre_pseudo']))
				{
				?>
				<div class="MV">
				
					<!-- Menu dépendant du Rang du visiteur -->
					<?php
					if($donnees['membre_rang'] >=20)
					{
					?>
					<div class="entete_MV">Administration</div>
					<?php
					if($donnees['membre_rang'] == 100)
					{
					?>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?mod=modif_membre" class="lien_MV">Modifier un membre</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?mod=ajout_news" class="lien_MV">Ajouter une news</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?mod=delete_news" class="lien_MV">Supprimer une news</a></div>
					<?php
					}
					?>
					<div class="bas_MV"></div>
					<!-- Fin -->
					<?php
					}
					$sql5 = mysql_query("SELECT * FROM forum_mp WHERE mp_receveur = '".$_SESSION['membre_id']."' AND mp_lu = '0'");
					$req5 = mysql_num_rows($sql5);
					if($req5 <= 0)
					{
						$new_mp = '0 Nouveau message';
					}
					else
					{
						$new_mp = '<span class="new_mp">'.$req5.' Nouveaux message</span>';
					}
					?>
					
					<div class="entete_MV">Mon compte</div>
                    <div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=mon_compte" class="lien_MV">Voir mon profil</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=mon_compte&amp;mod=modif" class="lien_MV">Modifier mon profil</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=mp" class="lien_MV">MP (<?php echo $new_mp; ?>)</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=friends" class="lien_MV">Mes amis</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=deconnexion" class="lien_MV">Se déconnecter</a></div>
					<div class="bas_MV"></div>
					
					<div class="entete_MV">Menu</div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/" class="lien_MV">Accueil</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=livreor" class="lien_MV">Livre d'Or</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=new" class="lien_MV">News</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/forum/" class="lien_MV">Forum</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/astuce/" class="lien_MV">Astuces</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/tutoriel" class="lien_MV">Tutoriels</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=membre" class="lien_MV"><?php echo $num1 = get('nb_membres'); if($num1 <= 1) echo ' Membre inscrit'; else echo ' Membres inscrits'; ?></a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=connecter" class="lien_MV"><?php echo $num2 = get('connectes'); if($num2 <= 1) echo ' Visiteur'; else echo ' Visiteurs' ?></a></div>
					<div class="bas_MV"></div>
				</div>
				<?php
				}
				// Fin //
				// Statut Hors Ligne //
				else
				{
				?>
				<div class="MV">
					<div class="entete_MV">Menu</div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/" class="lien_MV">Accueil</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=livreor" class="lien_MV">Livre d'Or</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=new" class="lien_MV">News</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/forum/" class="lien_MV">Forum</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=membre" class="lien_MV"><?php echo $num1 = get('nb_membres'); if($num1 <= 1) echo ' Membre inscrit'; else echo ' Membres inscrits'; ?></a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=connecter" class="lien_MV"><?php echo $num2 = get('connectes'); if($num2 <= 1) echo ' Visiteur'; else echo ' Visiteurs' ?></a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=inscription" class="lien_MV">S'inscrire</a></div>
					<div class="bouton_MV"><a href="<?php echo ROOTPATH; ?>/?page=connexion" class="lien_MV">Se connecter</a></div>
					<div class="bas_MV"></div>
				</div>
				<?php
				}
				// Fin //
				?>
				
			<!-- Fin -->
			
			<!-- Texte de la Page -->
				<div class="texte">
					<div class="cadre">
						<div class="titre">
						<?php
							if(isset($titre2))
							{
								echo $titre2;
							}
							else
							{
								echo 'Erreur';
							}
						?>
						</div>
						<div style="padding:10px; background-color:#cceeff; -moz-border-radius:0px 0px 20px 20px;">