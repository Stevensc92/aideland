<?php
/*
astuce/mod/add.php

Ajout d'astuce
*/
if(!isset($_SESSION['membre_id'])) // Si le membre n'est pas connecté, on l'exclu
{
	$informations = array(
					true,
					'Accès restreint',
					'Vous devez être connecter pour avoir accès.',
					' - <a href="'.ROOTPATH.'/?page=connexion">Se connecter</a>',
					ROOTPATH,
					5,
					'Accès restreint');
	require_once('../information.php');
	exit();
}
else
{
	/* Titre de la page */
	$titre = 'Ajout d\'astuce -';
	/********************/
	
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Ajout d\'astuce -';
	/******************************************************/

	if(isset($_GET['etape']) && !intval($_GET['etape'])) //Si $_get['etape'] existe et qu'il n'est pas un chiffre, on arrête la personne 
	{
		$titre .= ' Erreur';
		$titre2 .= ' Erreur';
		// on inclu le haut du corps, et on fait arrêter tout autre script
		/* Haut de la page, contient le doctype, charset, etc... */
		include('../includes/haut.php');
		/*********************************************************/
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Interface des astuce').' '.fil_ariane(1, 'astuce/?mod=add', 'Ajout d\'astuce').' '.fil_ariane(1, 'astuce/?mod=add', 'Étape n°1 : Vérification & confirmation de l\'existence du jeu dans la <acronym title="Base de Donnée">BDD</acronym>').' '.fil_ariane(2, 'astuce/?mod=add&amp;a=new', 'Erreur'); ?>
					</div>
					<?php
					quit('<div id="erreur">Le lien est corrompu.</div>');
	}
	else
	{
		if(isset($_GET['etape']))
		{
			if(isset($_GET['a']) && $_GET['a'] == 'new')
			{
				$etape = intval($_GET['etape']);
				// On modifie les titres pour mettre le numéro de l'étape
				$titre .= ' Étape n°'.$etape.'';
				$titre2 .= ' Étape n°'.$etape.'';
				// Et on inclus enfin le haut du corps
				/* Haut de la page, contient le doctype, charset, etc... */
				include('../includes/haut.php');
				/*********************************************************/
				if(isset($_POST['add']))
				{
					if(empty($_POST['console']) || empty($_POST['jeu']) || empty($_POST['type']) || empty($_POST['textarea']))
					{
						$erreur = 'Au moins un des champs obligatoire n\'est pas remplies.';
					}
					else
					{
						$console = mysql_real_escape_string($_POST['console']);
						$jeu = mysql_real_escape_string($_POST['jeu']);
						$titre = mysql_real_escape_string($_POST['titre']);
						$sous_titre = mysql_real_escape_string($_POST['sous_titre']);
						$type = mysql_real_escape_string($_POST['type']);
						$text = mysql_real_escape_string($_POST['textarea']);
						// On ajoute les informations dans la base de donnée.
						/*
						$sql = mysql_query("INSERT INTO site_astuce
									VALUES('', '".$_SESSION['membre_pseudo']."',
									'".$console."', '".$jeu."', '".$titre."',
									'".$sous_titre."', '".$type."', '".$text."',
									".time().", '".$jeu.'_'.$console."', '', '', '')")
									or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
						*/
						$sql2 = mysql_query("SELECT membre_mail
											FROM site_membres
											WHERE membre_id = '".$_SESSION['membre_id']."'")
											or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
						$req2 = mysql_fetch_assoc($sql2);
						print_r(correction_mail($_SESSION['membre_pseudo'], $req2['membre_mail'], 'astuce', $console, $jeu, $titre, $sous_titre, $type, $text, $jeu.'_'.$console));
						$fichierChemin = "/astuce/correc/page";
						$fichierNom = $jeu.'_'.$console;
						$fichierExtension = "php";
						$fichierContenu = "Cette astuce a été envoyé par ".$_SESSION['membre_pseudo']." le ".date('d/m/Y à H:i:s')."
						".$text."";
						$droit = "0777";
						/*
						$t_infoCreation = creerFichier($fichierChemin, $fichierNom, $fichierExtension, $fichierContenu, $droit);
						if($t_infoCreation && $sql)
						{
							echo '<div id="information">L\'astuce a bien été envoyé. Nous vous conseillons d\'attendre le temps de la validation de votre astuce.</div>';
						}
						else
						{
							echo '<div id="erreur">L\'astuce n\'a pas été envoyé. Réessayer. Si l\'erreur persiste, veuillez contacter le Webmaster.</div>';
						}
						*/
					}
				}
				?>
				<div class="content"><!-- Début centre -->	 
					<div class="nh"></div> <!-- News -->
						<div class="nf">
				<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Interface des astuce').' '.fil_ariane(1, 'astuce/?mod=add', 'Ajout d\'astuce').' '.fil_ariane(1, 'astuce/?mod=add', 'Étape n°1 : Recherche du jeu').' '.fil_ariane(1, 'astuce/?mod=add&amp;a=new&amp;etape=2', 'Étape n°2 : Un peu de paperasse').' '.fil_ariane(2, '', 'Remplissage du formulaire'); ?>
				</div>
				<?php
				if(isset($erreur))
				{
					echo '<div id="erreur">'.$erreur.'</div>';
				}
				?>
				<h1>Création d'astuce</h1>
				<div id="p">Veuillez remplir le formulaire ci-dessous puis l'envoyer pour pouvoir continuer.</div>
				<form method="post">
					<table style="margin:auto;">
						<tr>
							<td align="center"><label for="console">Console : *</label></td>
						</tr>
						<tr>
							<td align="center"><input type="text" name="console" value="<?php if(!empty($_POST['console'])) { echo $_POST['console']; } ?>" /></td>
						</tr>
						<tr>
							<td align="center"><label for="jeu">Jeu : *</label></td>
						</tr>
						<tr>
							<td align="center"><input type="text" name="jeu" value="<?php if(!empty($_POST['jeu'])) { echo $_POST['jeu']; } ?>" /></td>
						</tr>
						<tr>
							<td align="center"><label for="titre">Titre de l'astuce :</label></td>
						</tr>
						<tr>
							<td align="center"><input type="text" name="titre" value="<?php if(!empty($_POST['titre'])) { echo $_POST['titre']; } ?>" /></td>
						</tr>
						<tr>
							<td align="center"><label for="sous_titre">Sous titre :</label></td>
						</tr>
						<tr>
							<td align="center"><input type="text" name="sous_titre" value="<?php if(!empty($_POST['sous_titre'])) { echo $_POST['sous_titre']; } ?>" /></td>
						</tr>
						<tr>
							<td align="center"><label for="type">Type : *</label></td>
						</tr>
						<tr>
							<td align="center"><input type="text" name="type" value="<?php if(!empty($_POST['type'])) { echo $_POST['type']; } ?>" /></td>
						</tr>
						<tr>
							<td align="center"><label for="textarea">Astuce : *</label></td>
						</tr>
						<tr>
							<td align="center">
								<?php include('../includes/haut_bbcode.php'); ?>
								<textarea id="textarea" name="textarea" rows="25" cols="150"><?php if(!empty($_POST['textarea'])) { echo $_POST['textarea']; } ?></textarea>
								<?php
								$f = 'f';
								include('../includes/bas_bbcode.php'); ?>
							</td>
						</tr>
						<tr>
							<td align="center"><input type="submit" name="add" value="Envoyer !" /></td>
						</tr>
					</table>
				</form>
				<div id="p"><p>Les champs noter d'une * sont obligatoire.</p></p></div>
				<?php
			}
			elseif(isset($_GET['a']) && $_GET['a'] == 'add')
			{
				$etape = intval($_GET['etape']);
				// On modifie les titres pour mettre le numéro de l'étape
				$titre .= ' Étape n°'.$etape.'';
				$titre2 .= ' Étape n°'.$etape.'';
				// Et on inclus enfin le haut du corps
				/* Haut de la page, contient le doctype, charset, etc... */
				include('../includes/haut.php');
				/*********************************************************/
				?>
				<div class="content"><!-- Début centre -->	 
					<div class="nh"></div> <!-- News -->
						<div class="nf">
				<h1>Ajout d'astuce</h1>
				<?php
			}
			else
			{
				$titre .= ' Erreur';
				$titre2 .= ' Erreur';
				// on inclu le haut du corps, et on fait arrêter tout autre script
				/* Haut de la page, contient le doctype, charset, etc... */
				include('../includes/haut.php');
				/*********************************************************/
				quit('<div id="erreur">Le lien est corrompu.</div>');
			}
		}
		else
		{
			// On modifie les titres pour mettre le numéro de l'étape
			$titre .= ' Début - étape n°1';
			$titre2 .= ' Début - étape n°1';
			// Et on inclus enfin le haut du corps
			/* Haut de la page, contient le doctype, charset, etc... */
			include('../includes/haut.php');
			/*********************************************************/
			if(isset($_POST['search']))
			{
				?>
				<div class="content"><!-- Début centre -->	 
					<div class="nh"></div> <!-- News -->
						<div class="nf">
							<div id="fil_ariane">
								<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Interface des astuce').' '.fil_ariane(1, 'astuce/?mod=add', 'Ajout d\'astuce').' '.fil_ariane(1, 'astuce/?mod=add', 'Étape n°1 : Recherche du jeu').' '.fil_ariane(2, '', 'Résultat de la recherche'); ?>
							</div>
							<?php
							if(empty($_POST['q']))
							{
								$erreur = 'Vous n\'avez pas précisé de jeu.';
							}
							else
							{
								$q = mysql_real_escape_string($_POST['q']);
								$q = explode(' ', $q);
								$sql = mysql_query("SELECT *
													FROM site_astuce
													WHERE console LIKE '%".$q[0]."%' AND jeu LIKE '%".$q[1]."%'")
													or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
								$req = mysql_num_rows($sql);
								$donnees = mysql_fetch_assoc($sql);
								if($req == 0)
								{
									echo '<div id="p">Le jeu <strong>'.$q[1].'</strong> sur <strong>'.$q[0].'</strong> n\'existe pas.<br/> <a href="'.ROOTPATH.'/astuce/?mod=add&amp;a=new&amp;etape=2">Voulez-vous crée des astuces pour ce jeu ?</a> - <a href="'.ROOTPATH.'/astuce/?mod=add">Ou revenir en arrière ?</a></div>';
								}
								else
								{
									echo '<div id="p">Le jeu <strong>'.$donnees['jeu'].'</strong> sur <strong>'.$donnees['console'].'</strong> existe dans notre base de donnée.<br/>
									<a href="'.ROOTPATH.'/astuce/?mod=add&amp;a=add&amp;etape=2">Voulez-vous ajouter des astuces pour ce jeu ?</a> - <a href="'.ROOTPATH.'/astuce/?mod=add">Ou revenir en arrière ?</a></div>';
								}
							}
							if(isset($erreur))
							{
								echo '<span class="erreur">'.$erreur.'</span>';
							}
							?>
						</div>
					<div class="nb"></div> <!-- Fin news -->
				</div><!-- Fin centre -->
				<?php
			}
			if(!isset($_POST['search']))
			{
			?>
				<div class="content"><!-- Début centre -->	 
					<div class="nh"></div> <!-- News -->
						<div class="nf">
							<div id="fil_ariane">
								<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Interface des astuce').' '.fil_ariane(1, 'astuce/?mod=add', 'Ajout d\'astuce').' '.fil_ariane(2, '', 'Étape 1 : Recherche du jeu'); ?>
							</div>
							<p>Bonjour, pour pouvoir continuer au programme d'ajout d'astuce,
							il vous faut d'abord rechercher si le jeu existe.
							Indiquez simplement la console et le jeu en entier comme dans cet exemple : (Xbox360 Haloreach).<br/>
							NB : Cette recherche est obligatoire pour pouvoir continuer.</p>
						<?php
						}
						?>
							<form method="post">
								<table align="center">
									<tr>
										<td><input type="text" name="q" id="q" value="<?php if(!empty($_POST['q'])) { echo $_POST['q']; } ?>" /></td>
										<td><input type="submit" value="Rechercher" name="search" /></td>
									</tr>
								</table>
							</form>
						</div>
					<div class="nb"></div> <!-- Fin news -->
				</div><!-- Fin centre -->
			<?php
		}
	}
}
?>