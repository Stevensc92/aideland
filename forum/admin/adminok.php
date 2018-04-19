<?php
/*
/forum/admin/adminok.php

Partie vérification d'administration

*/
if(isset($_SESSION['membre_id']))
{
	$sql = mysql_query("SELECT level 
						FROM site_membres 
						WHERE id = '".$_SESSION['membre_id']."'")
	or ErrorSQL(__FILE__,__LINE__);
	$req = mysql_fetch_assoc($sql);
}
if($req['level'] != 4 || !isset($_SESSION['membre_id']))
{
	$informations = array( /* Accès refusé */
					true,
					'Accès refusé',
					'Vous n\'avez pas les droits pour être ici.',
					'',
					ROOTPATH.'/forum',
					5,
					'Accès refusé'
					);
	require_once('../information.php');
	exit();
}
/* Titre de la page */
$titre = 'Administration du forum';
/********************/
	
/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Administration du forum';
/******************************************************/

/* Haut de la page, contient le doctype, charset, etc... */
include('../includes/haut.php');
/*********************************************************/

$cat = isset($_GET['cat'])?htmlspecialchars($_GET['cat']):''; //on récupère dans l'url la variable cat
?>
<div id="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<?php
			switch($cat) //1er switch
			{
				case "config":
					?>
					<div id="fil_ariane">
						<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=config', 'Configuration du Forum').' '.fil_ariane(2, '', 'Configuration du Forum'); ?>
					</div>
					<h1>Configuration du forum</h1>
					<?php
					//On récupère les valeurs et le nom de chaque entrée de la table
					$requete_config= mysql_query('SELECT config_nom, config_valeur FROM forum_config');
					//Avec cette boucle, on va pouvoir contrôler le résultat pour voir s'il a changé
					while($data_config = mysql_fetch_assoc($requete_config))
					{
						if($data_config['config_valeur'] != $_POST[$data_config['config_nom']])
						{
							//On met ensuite à jour
							$valeur = htmlspecialchars($_POST[$data_config['config_nom']]);
							mysql_query("UPDATE forum_config SET config_valeur = '".$valeur."'
							WHERE config_nom = '".$data_config['config_nom']."'") or die(mysql_error());
						}
					}
					?>
					<div id="information">
						Les nouvelles configurations ont été mises à jour !<br/>
						Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=config">ici</a> pour revenir à la configuration du forum.
					</div>
					<?php
				break;
				
				case "forum":
					//Ici forum
					$action = htmlspecialchars($_GET['action']); //On récupère la valeur de action
					switch($action) //2ème switch
					{
						case "creer":
							//On commence par les forums
							if($_GET['c'] == "f")
							{
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=creer&amp;c=f', 'Création d\'un forum').' '.fil_ariane(2, '', 'Création d\'un forum'); ?>
								</div>
								<h1>Création d'un forum</h1>
								<?php
								$titre = mysql_real_escape_string($_POST['nom']);
								$desc = mysql_real_escape_string($_POST['desc']);
								$cat = (int) $_POST['cat'];
								
								mysql_query("INSERT INTO forum_forum 
								(forum_cat_id, forum_name, forum_desc) 
								VALUES ('".$cat."', '".$titre."', '".$desc."')");
								?>
								<div id="information">
									Le forum a été créé !<br/>
									Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=creer&amp;c=f">ici</a> pour revenir à la création de forum.<br/>
									Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
								</div>
								<?php
							}
							//Puis par les catégories
							elseif ($_GET['c'] == "c")
							{
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=creer&amp;c=c', 'Création d\'une catégorie').' '.fil_ariane(2, '', 'Création d\'une catégorie'); ?>
								</div>
								<h1>Création d'une catégorie</h1>
								<?php
								$titre = mysql_real_escape_string($_POST['nom']);				
								mysql_query("INSERT INTO forum_categorie VALUES ('', '".$titre."', '')") 
								or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());					
								?>
								<div id="information">
									La catégorie a été créée !<br/>
									Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=creer&amp;c=c">ici</a> pour revenir à la création de catégorie.<br/>
									Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
								</div>
								<?php
							}			
						break;
						
						case "edit":
						
							if($_GET['e'] == "editf")
							{
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editf', 'Édition d\'un forum').' '.fil_ariane(2, '', 'Édition d\'un forum'); ?>
								</div>
								<h1>Édition d'un forum</h1>
								<?php
								//Récupération d'informations

								$titre = mysql_real_escape_string($_POST['nom']);
								$desc = mysql_real_escape_string($_POST['desc']);
								$cat = (int) $_POST['depl'];        

								//Vérification
								$forum_existe = mysql_result(mysql_query("SELECT COUNT(*) 
								FROM forum_forum WHERE forum_id = '".$_POST['forum_id']."'"),0);
								if($forum_existe == 0)
								{
									quit('<div id="erreur"Le forum n\'existe pas</div>');
								}
								else
								{
									//Mise à jour
									mysql_query("UPDATE forum_forum 
									SET forum_cat_id = '".$cat."', forum_name = '".$titre."',
									forum_desc = '".$desc."' 
									WHERE forum_id = '".(int) $_POST['forum_id']."'");
							 
									//Message
									?>
									<div id="information">
										Le forum a été modifié !<br/>
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editf">ici</a> pour revenir à la modification de forum.<br/>
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
									</div>
									<?php
								}
							}
							elseif($_GET['e'] == "editc")
							{
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editc', 'Édition d\'une catégorie').' '.fil_ariane(2, '', 'Édition d\'une catégorie'); ?>
								</div>
								<h1>Édition d'une catégorie</h1>
								<?php
								//Récupération d'informations
								$titre = mysql_real_escape_string($_POST['nom']);

								//Vérification
								$cat_existe = mysql_result(mysql_query("SELECT COUNT(*) 
								FROM forum_categorie WHERE cat_id = '".(int) $_POST['cat']."'"),0);
								if ($cat_existe == 0)
								{
									quit('<div id="erreur">La catégorie n\'existe pas.</div>');
								}
								else
								{
									//Mise à jour
									mysql_query("UPDATE forum_categorie
									SET cat_nom = '".$titre."' 
									WHERE cat_id = '".(int) $_POST['cat']."'");
									
									//Message
									?>
									<div id="information">
										<p>La catégorie a été modifiée !<br/>
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editc">ici</a> pour revenir à la modification de catégorie.<br/>
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.						
									</div>
									<?php
								}
							}
							elseif($_GET['e'] == "ordref")
							{
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=ordref', 'Modification de l\'ordre des forum').' '.fil_ariane(2, '', 'Modification de l\'ordre des forum'); ?>
								</div>
								<h1>Modification de l'ordre des forum</h1>
								<?php
								//On récupère les id et l'ordre de tous les forums
								$requete_forum = mysql_query('SELECT forum_id, forum_ordre 
								FROM forum_forum');
						 
								//On boucle les résultats
								while($data= mysql_fetch_assoc($requete_forum))
								{
									$ordre = (int) $_POST[$data['forum_id']]; 
									
									//Si et seulement si l'ordre est différent de l'ancien, on le met à jour
									if ($data['forum_ordre'] != $ordre)
									{
										mysql_query("UPDATE forum_forum SET forum_ordre = '".$ordre."'
										WHERE forum_id = '".$data['forum_id']."'");
									}
								}			 
								//Message
								?>
								<div id="information">
									L'ordre a été modifié !<br/>
									Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=ordref">ici</a> pour revenir à la modification d'ordre des forums.<br/>
									Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
								</div>
								<?php
							}
							elseif($_GET['e'] == "ordrec")
							{
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=ordrec', 'Modification de l\'ordre des catégories').' '.fil_ariane(2, '', 'Modification de l\'ordre des catégories'); ?>
								</div>
								<h1>Modification de l'ordre des catégories</h1>
								<?php
								
								//On récupère les id et les ordres de toutes les catégories
								$requete_cat = mysql_query('SELECT cat_id, cat_ordre 
								FROM forum_categorie');
								
								//On boucle le tout
								while($data = mysql_fetch_assoc($requete_cat))
								{
									$ordre = (int) $_POST[$data['cat_id']]; 
									
									//On met à jour si l'ordre a changé
									if($data['cat_ordre'] != $ordre)
									{
										mysql_query("UPDATE forum_categorie SET cat_ordre = '".$ordre."'
										WHERE cat_id = '".$data['cat_id']."'");
									}
								}
								?>
								<div id="information">
									L'ordre a été modifié !<br/>
									Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=ordrec">ici</a> pour revenir à la modification d'ordre des catégories.<br/>
									Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
								</div>
								<?php
							}
						break;
						
						case "droits":  
							?>
							<div id="fil_ariane">
								<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=droits', 'Modification des droits').' '.fil_ariane(2, '', 'Modification des droits'); ?>
							</div>
							<h1>Modification des droits de forum</h1>
							<?php
							//Récupération d'informations
							$auth_view = (int) $_POST['auth_view'];
							$auth_post = (int) $_POST['auth_post'];
							$auth_topic = (int) $_POST['auth_topic'];
							$auth_annonce = (int) $_POST['auth_annonce'];
							$auth_modo = (int) $_POST['auth_modo'];
							
							//Mise à jour
							mysql_query("UPDATE forum_forum
							SET auth_view = '".$auth_view."', 
							auth_post = '".$auth_post."', auth_topic = '".$auth_topic."',
							auth_annonce = '".$auth_annonce."', auth_modo = '".$auth_modo."'
							WHERE forum_id = '".(int) $_POST['forum_id']."'");

							//Message
							?>
							<div id="information">
								Les droits ont été modifiés !<br/>
								Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=droits">ici</a> pour revenir à la modification des droits de forum.<br/>
								Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
							</div>
							<?php
						break;
					}
				break;
				case "membres":
					$action = htmlspecialchars($_GET['action']); //On récupère la valeur de action
					switch ($action)
					{
						case "edit":
							?>
							<div id="fil_ariane">
								<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres', 'Administration des membres').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres&amp;action=edit', 'Éditer le profil d\'un membre').' '.fil_ariane(2, '', 'Éditer le profil d\'un membre'); ?>
							</div>
							<h1>Modification du profil d'un membre</h1>
							<?php
							quit('<div id="erreur">Désolé mais cette partie n\'est pas encore coder, merci de revenir plus tard.</div>');
						break;
						
						case "droits":
							?>
							<div id="fil_ariane">
								<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres', 'Administration des membres').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres&amp;action=droits', 'Modifier les droits d\'un membre').' '.fil_ariane(2, '', 'Modifier les droits d\'un membre'); ?>
							</div>
							<h1>Modification du niveau d'un membre</h1>
							<?php
							$membre = mysql_real_escape_string($_POST['pseudo']);
							$rang = (int) $_POST['droits'];
							mysql_query("UPDATE site_membres 
										SET level = '".$rang."' 
										WHERE pseudo = '".$membre."'")
							or ErrorSQL(__FILE__,__LINE__);
							?>
							<div id="information">
								Le niveau du membre a été modifié !<br/>
								Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&amp;action=droits">ici</a> pour revenir à la modification des droits d'un membre.<br/>
								Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
							</div>
							<?php
						break;
						
						case "ban":
							?>
							<div id="fil_ariane">
								<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres', 'Administration des membres').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres&amp;action=ban', 'Banissement d\'un membre').' '.fil_ariane(2, '', 'Banissement d\'un membre'); ?>
							</div>
							<h1>Banissement d'un membre</h1>
							<?php
							//Bannissement dans un premier temps
							//Si jamais on n'a pas laissé vide le champ pour le pseudo
							if(isset($_POST['membre']) AND !empty($_POST['membre']))
							{
								$pseudo = mysql_real_escape_string($_POST['membre']);
								$requete_membre = mysql_query('SELECT id 
																FROM site_membres 
																WHERE pseudo = "'.$pseudo.'"')
								or ErrorSQL(__FILE__);
								//Si le membre existe
								if ($data_membre = mysql_fetch_assoc($requete_membre))
								{
									//On le bannit
									mysql_query("UPDATE site_membres SET rang = 0, level = 0, groupe = 'Bannis'
									WHERE id = '".$data_membre['id']."'");
									?>
									<div id="information">
										Le membre <?php echo stripslashes(htmlspecialchars($pseudo)); ?> a bien été banni !
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&amp;action=ban">ici</a> pour revenir au banissement.<br/>
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
									</div>
									<?php
								}
								else 
								{
									?>
									<div id="erreur">
										Désolé, le membre <?php echo stripslashes(htmlspecialchars($pseudo)); ?> n'existe pas !<br/>
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&action=ban">ici</a> pour réessayer.<br/>
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
									</div>
									<?php
								}
							}
							//Debannissement ici        
							$requete_deban = mysql_query('SELECT id FROM site_membres 
							WHERE rang = 0');
							//Si on veut débannir au moins un membre
							if (mysql_num_rows($requete_deban) > 0)
							{
								$i=0;
								while($data_deban = mysql_fetch_assoc($requete_deban))
								{
									if(isset($_POST[$data_deban['id']]))
									{
										$i++;
										//On remet son rang à 2
										mysql_query("UPDATE site_membres SET rang = 1, level = 2, groupe = 'Membre'
										WHERE id = '".$data_deban['id']."'");
									}
								}
								if($i!=0)
								{
									?>
									<div id="information">
										Les membres ont été débannis.<br/>
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&amp;ban">ici</a> pour retourner au banissement des membres.<br/>
										Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour retourner à l'index du forum.
									</div>
									<?php
								}
							}
						break;


					}
				break;
			}
			?>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->