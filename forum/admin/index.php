<?php
/*
/forum/admin/index.php

Partie d'administration

*/

if(isset($_SESSION['membre_id']))
{
	$sql = mysql_query("SELECT level 
						FROM site_membres 
						WHERE id = '".$_SESSION['membre_id']."'")
	or ErrorSQL(__FILE__,__LINE__);
	$req = mysql_fetch_assoc($sql);
	if($req['level'] != 4 || !isset($_SESSION['membre_id']))
	{
		$informations = array( /* Accès refusé */
						true,
						'Accès refusé',
						'Vous n\'avez pas les droits pour être ici.',
						'',
						ROOTPATH.'/forum',
						3,
						);
		require_once('../information.php');
		exit();
	}
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
					//ici configuration
					?>
					<div id="fil_ariane">
						<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(2, '', 'Configuration du Forum'); ?>
					</div>
					<h1>Configuration du forum</h1>
					<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=config">		
					<?php
					//Le tableau associatif
					$config_name = array(
					"avatar_maxsize" => "Taille maximale de l'avatar",
					"avatar_maxh" => "Hauteur maximale de l'avatar",
					"avatar_maxl" => "Largeur maximale de l'avatar",
					"sign_maxl" => "Taille maximale de la signature",
					"auth_bbcode_sign" => "Autoriser le bbcode dans la signature",
					"pseudo_maxsize" => "Taille maximale du pseudo",
					"pseudo_minsize" => "Taille minimale du pseudo",
					"topic_par_page" => "Nombre de topics par page",
					"post_par_page" => "Nombre de posts par page"
					);
					$requete_config= mysql_query('SELECT config_nom, config_valeur FROM forum_config');
					?>
						<table style="margin:auto;">
							<?php
							while($data_config = mysql_fetch_assoc($requete_config))
							{
								?>
								<tr>
									<td align="center">
										<label for="<?php echo $data_config['config_nom']; ?>"><?php echo $config_name[$data_config['config_nom']]; ?> :</label>
									</td>
								</tr>
								<tr>
									<td align="center">
										<input type="text" id="<?php echo $data_config['config_nom']; ?>" value="<?php echo $data_config['config_valeur']; ?>" name="<?php echo $data_config['config_nom']; ?>">
									</td>
								</tr>
								<?php
							}
							?>
								<tr>
									<td align="center">
										<input type="submit" value="Envoyer" />
									</td>
						</table>
					</form>
					<?php
				break;
				 
				case "forum":
					//Ici forum
					$action = isset($_GET['action'])?htmlspecialchars($_GET['action']):''; //On récupère la valeur de action
					switch($action) //2eme switch
					{
						case "creer":
							//Création d'un forum
							//1er cas : pas de variable c
							if(empty($_GET['c']))
							{
									?>
									<div id="fil_ariane">
										<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(2, '', 'Choix création'); ?>
									</div>
									<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=creer&amp;c=f">Créer un forum</a> -
									<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=creer&amp;c=c">Créer une catégorie</a></br>
									<?php
							}

							//2ème cas : on cherche à créer un forum (c=f)
							elseif($_GET['c'] == "f")
							{
									$requete = mysql_query('SELECT cat_id, cat_nom FROM forum_categorie 
									ORDER BY cat_ordre DESC');
									?>
									<div id="fil_ariane">
										<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=creer', 'Choix création').' '.fil_ariane(2, '', 'Création d\'un forum'); ?>
									</div>
									<h1>Création d'un forum</h1>
									<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=forum&amp;action=creer&amp;c=f">
										<table style="margin:auto;">
											<tr>
												<td align="center"><label>Nom :</label></td>
												<td align="center"><input type="text" id="nom" name="nom"/></td>
											</tr>
											<tr>
												<td align="center"><label>Description :</label></td>
												<td align="center">
													<textarea cols="40" rows="4" name="desc" name="desc"></textarea>
												</td>
											</tr>
											<tr>
												<td align="center"><label>Catégorie : </label></td>
												<td align="center">
													<select name="cat">
													<?php
													while($data = mysql_fetch_assoc($requete))
													{
														echo '<option value="'.$data['cat_id'].'">'.$data['cat_nom'].'</option>';
													}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td align="center" colspan="2">
													<input type="submit" value="Envoyer">
												</td>
											</tr>
										</table>
									</form>
									<?php
							}
						   
							//3ème cas : on cherche à créer une catégorie (c=c)
							elseif($_GET['c'] == "c")
							{
									?>
									<div id="fil_ariane">
										<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=creer', 'Choix création').' '.fil_ariane(2, '', 'Création d\'une catégorie'); ?>
									</div>
									<h1>Création d'une catégorie</h1>
										<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=forum&amp;action=creer&amp;c=c">
											<table style="margin:auto;">
												<tr>
													<td align="center"><label>Indiquez le nom de la catégorie :</label></td>
													<td align="center"><input type="text" id="nom" name="nom" /></td>
												</tr>
												<tr>
													<td align="center" colspan="2"><input type="submit" value="Envoyer"></td>
												</tr>
											</table>
										</form>
									<?php
							}

						break;
							
						case "edit":
							//Edition d'un forum				
							if(!isset($_GET['e']))
							{
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(2, '', 'Modification'); ?>
								</div>
								<h1>Édition d'un forum</h1>
								<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editf">Éditer un forum</a><br/>
								<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editc">Éditer une catégorie</a><br/>
								<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=ordref">Changer l'ordre des forums</a><br/>
								<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=ordrec">Changer l'ordre des catégories</a><br/>
								<?php
							}
							elseif($_GET['e'] == "editf")
							{
								//On affiche dans un premier temps la liste des forums
								if(!isset($_POST['forum']))
								{
									$requete = mysql_query('SELECT forum_id, forum_name
									FROM forum_forum ORDER BY forum_ordre DESC');
									
									?>
									<div id="fil_ariane">
										<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(2, '', 'Édition d\'un forum'); ?>
									</div>
									<h1>Édition d'un forum</h1>
									<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editf">
										<table style="margin:auto;">
											<tr>
												<td align="center"><label for="forum">Choisir un forum :</label></td>
											</tr>
											<tr>
												<td align="center">
													<select name="forum">
													<?php
													while($data = mysql_fetch_assoc($requete))
													{
														?>
														<option value="<?php echo $data['forum_id']; ?>"><?php echo stripslashes(htmlspecialchars($data['forum_name'])); ?></option>
														<?php
													}
									?>
													</select>
												</td>
											</tr>
											<tr>
												<td align="center"><input type="submit" value="Envoyer"></td>
											</tr>
										</table>
									</form>
									<?php
								}
							   
								//Ensuite, on affiche les renseignements sur le forum choisi
								else
								{
									$requete1 = mysql_query('SELECT forum_id, forum_name, forum_desc, 
									forum_cat_id
									FROM forum_forum
									WHERE forum_id = "'.$_POST['forum'].'"');
									$data1 = mysql_fetch_assoc($requete1);

									?>
									<div id="fil_ariane">
										<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editf', 'Édition d\'un forum').' '.fil_ariane(2, '', 'Édition du forum '.$data1['forum_name'].''); ?>
									</div>
									<h1>Édition du forum <strong><?php echo stripslashes(htmlspecialchars($data1['forum_name'])); ?></strong></h1>
									<form method="post"	action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=forum&amp;action=edit&amp;e=editf">
										<table style="margin:auto;">
											<tr>
												<td align="center"><label>Nom du forum : </label></td>
											</tr>
											<tr>
												<td align="center"><input type="text" id="nom" name="nom" value="<?php echo stripslashes($data1['forum_name']); ?>" /></td>
											</tr>
											<tr>
												<td align="center"><label>Description :</label></td>
											</tr>
											<tr>
												<td align="center"><textarea cols="40" rows="4" name="desc" id="desc"><?php echo $data1['forum_desc']; ?></textarea></td>
											</tr>
									<?php
									//A partir d'ici, on boucle toutes les catégories, 
									//On affichera en premier celle du forum

									$requete2 = mysql_query('SELECT cat_id, cat_nom 
									FROM forum_categorie ORDER BY cat_ordre DESC');

									?>
											<tr>
												<td align="center"><label>Déplacer le forum vers : </label></td>
											</tr>
											<tr>
												<td align="center">
													<select name="depl">
													<?php
													while($data2 = mysql_fetch_assoc($requete2))
													{
														if($data2['cat_id'] == $data1['forum_cat_id']) 
														{
															?>
															<option value="<?php echo $data2['cat_id']; ?>" selected="selected"><?php echo stripslashes(htmlspecialchars($data2['cat_nom'])); ?></option>
															<?php
														}
														else 
														{
															?>
															<option value="<?php echo $data2['cat_id']; ?>"><?php echo $data2['cat_nom']; ?></option>
															<?php
														}
													}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td align="center"><input type="hidden" name="forum_id" value="<?php echo $data1['forum_id']; ?>"> <input type="submit" value="Envoyer"></td>
											</tr>
										</table>
									</form>
								<?php
								}
							}
							elseif($_GET['e'] == "editc")
							{
								//On commence par afficher la liste des catégories
								if(!isset($_POST['cat']))
								{
									$requete = mysql_query('SELECT cat_id, cat_nom
									FROM forum_categorie ORDER BY cat_ordre DESC');
									?>
									<div id="fil_ariane">
										<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(2, '', 'Édition d\'une catégorie'); ?>
									</div>
									<h1>Édition d'une catégorie</h1>
									<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editc">
										<table style="margin:auto;">
											<tr>
												<td><label for="cat">Choisir une catégorie :</label>
												<td>
													<select name="cat">
														<?php
														while($data = mysql_fetch_assoc($requete))
														{
															?>
															<option value="<?php echo $data['cat_id']; ?>"><?php echo $data['cat_nom']; ?></option>
															<?php
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td colspan="2" align="center"><input type="submit" value="Envoyer"></td>
											</tr>
										</table>
									</form>
									<?php
								}
						  
								//Puis le formulaire
								else
								{
									$requete = mysql_query('SELECT cat_nom FROM forum_categorie
									WHERE cat_id = "'.$_POST['cat'].'"');
									$data = mysql_fetch_assoc($requete);
									?>
									<div id="fil_ariane">
										<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit&amp;e=editc', 'Édition d\'une catégorie').' '.fil_ariane(2, '', 'Édition de la catégorie '.$data['cat_nom'].''); ?>
									</div>
									<h1>Édition de la catégorie <?php echo $data['cat_nom']; ?></h1>
									<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=forum&amp;action=edit&amp;e=editc">
										<table style="margin:auto;">
											<tr>
												<td><label for="nom"> Indiquez le nom de la catégorie :</label></td>
												<td><input type="text" id="nom" name="nom" 	value="<?php echo stripslashes(htmlspecialchars($data['cat_nom'])); ?>" /></td>
											</tr>
											<tr>
												<td colspan="2"><input type="hidden" name="cat" value="<?php echo $_POST['cat']; ?>" /></td>
											<tr>
												<td colspan="2" align="center"><input type="submit" value="Envoyer" /></td>
											</tr>
										</table>
									</form>
									<?php
									}
							}
							elseif($_GET['e'] == "ordref")
							{
								$categorie="";
								$requete = mysql_query('SELECT forum_id, forum_name, forum_ordre, 
								forum_cat_id, cat_id, cat_nom
								FROM forum_categorie
								LEFT JOIN forum_forum ON cat_id = forum_cat_id
								ORDER BY cat_ordre DESC');
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(2, '', 'Modification de l\'ordre des forum'); ?>
								</div>
								<h1>Modifier l'ordre des forum</h1>
								<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=forum&amp;action=edit&amp;e=ordref">
									<table style="margin:auto;">
									<?php
									while($data = mysql_fetch_assoc($requete))
									{
										if($categorie != $data['cat_id'] )
										{
											$categorie = $data['cat_id'];
											?>
											<tr>      
												<th><strong><?php echo stripslashes(htmlspecialchars($data['cat_nom'])); ?></strong></th>
												<th><strong>Ordre</strong></th>
											</tr>
											<?php
										}
										?>
											<tr>
												<td>
													<a href="<?php echo ROOTPATH; ?>/forum/?view=forum&amp;f=<?php echo $data['forum_id']; ?>">
														<?php echo $data['forum_name']; ?>
													</a>
												</td>
												<td>
													<input type="text" value="<?php echo $data['forum_ordre']; ?>" name="<?php echo $data['forum_id']; ?>" />
												</td>
											</tr>
											<?php
									}
									?>
											<tr>
												<td colspan="2" align="center"><input type="submit" value="Envoyer" /></td>
											</tr>
									</table>
								</form>
								<?php
							}
							elseif($_GET['e'] == "ordrec")
							{
								$requete = mysql_query('SELECT cat_id, cat_nom, cat_ordre 
								FROM forum_categorie
								ORDER BY cat_ordre DESC');
				 
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=edit', 'Modification').' '.fil_ariane(2, '', 'Modification de l\'ordre des catégories'); ?>
								</div>
								<h1>Modifier l'ordre des catégroeis</h1>
								<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=forum&amp;action=edit&amp;e=ordrec">
									<table style="margin:auto;">
									<?php
									while($data = mysql_fetch_assoc($requete))
									{
										?>
										<tr>
											<td><label for="<?php echo $data['cat_id']; ?>"><?php echo stripslashes(htmlspecialchars($data['cat_nom'])); ?> :</label></td>
											<td><input type="text" value="<?php echo $data['cat_ordre']; ?>" name="<?php echo $data['cat_id']; ?>" />
										</tr>
										<?php
									}
									?>
										<tr>
											<td align="center" colspan="2"><input type="submit" value="Envoyer" /></td>
										</tr>
									</table>
								</form>
								<?php
							}

						break;
							
						case "droits":
							//Gestion des droits
							if(!isset($_POST['forum']))
							{
								$requete = mysql_query('SELECT forum_id, forum_name
								FROM forum_forum ORDER BY forum_ordre DESC');
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(2, '', 'Modification des droits de forum'); ?>
								</div>
								<h1>Édition des droits de forum</h1>
								<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&action=droits">
									<table style="margin:auto;">
										<tr>
											<td align="center"><label for="forum">Choisir un forum :</label></td>
										</tr>
										<tr>
											<td align="center">
												<select name="forum">
												<?php
												while($data = mysql_fetch_assoc($requete))
												{
													?>
													<option value="<?php echo $data['forum_id']; ?>"><?php echo stripslashes(htmlspecialchars($data['forum_name'])); ?></option>
													<?php
												}
												?>
												</select>
											</td>
										</tr>
										<tr>
											<td align="center"><input type="submit" value="Envoyer"></td>
										</tr>
									</table>
								</form>
								<?php
							}
							else
							{
								$requete = mysql_query('SELECT forum_id, forum_name, auth_view,
								auth_post, auth_topic, auth_annonce, auth_modo 
								FROM forum_forum WHERE forum_id = '.$_POST['forum'].'');
								$data = mysql_fetch_assoc($requete);
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum', 'Administration des forums').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=forum&amp;action=droits', 'Modification des droits de forum').' '.fil_ariane(2, '', 'Modification des droits du forum '.$data['forum_name'].''); ?>
								</div>
								<h1>Édition des droits du forum <?php echo $data['forum_name']; ?></h1>
								<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=forum&action=droits">
									<table style="margin:auto;">
										<tr>
											<th>Lire</th>
											<th>Répondre</th>
											<th>Poster</th>
											<th>Annonce</th>
											<th>Modérer</th>
										</tr>
										<?php
									//Ces deux tableaux vont permettre d'afficher les résultats
									$rang = array("Visiteur", "Membre", "Modérateur","Administrateur");
									$list_champ = array("auth_view", "auth_post", "auth_topic",
									"auth_annonce", "auth_modo");
							  
									//On boucle
									foreach($list_champ as $champ)
									{
										?>
											<td>
												<select name="<?php echo $champ; ?>">
												<?php
												for($i=0;$i<4;$i++)
												{
													if($i == $data[$champ])
													{
														?>
														<option value="<?php echo $i; ?>" selected="selected"><?php echo $rang[$i]; ?></option>
														<?php
													}
													else
													{
														?>
														<option value="<?php echo $i; ?>"><?php echo $rang[$i]; ?></option>
														<?php
													}
												}
										?>
												</select>
											</td>
										<?php
									}
										?>
										<tr>
											<td><input type="hidden" name="forum_id" value="<?php echo $data['forum_id']; ?>" /></td>
										</tr>
										<tr>
											<td colspan="5" align="center"><input type="submit" value="Envoyer"></td>
										</tr>
									</table>
								</form>
								<?php
							}
						break;
							
						default; //action n'est pas remplie, on affiche le menu
							?>
							<div id="fil_ariane">
								<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(2, '', 'Administration des forums'); ?>
							</div>
							<h1>Administration des forums</h1>
							<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=creer">Créer un forum</a>
							<br/>
							<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=edit">Modifier un forum</a>
							<br/>
							<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum&amp;action=droits">Modifier les droits d'un forum</a>
							<?php
						break;
					}
				break;
				 
				case "membres":
					//Ici membres
					$action = isset($_GET['action'])?htmlspecialchars($_GET['action']):''; //On récupère la valeur de action
					switch($action) //2eme switch
					{
						case "edit":
							//Edition d'un membre
							if(!isset($_POST['membre'])) //Si la variable $_POST['membre'] n'existe pas
							{
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres', 'Administration des membres').' '.fil_ariane(2, '', 'Éditer le profil d\'un membre'); ?>
								</div>
								<h1>Édition du profil d'un membre</h1>
								<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&amp;action=edit">
									<table style="margin:auto;">
										<tr>
											<td><label for="membre">Inscrivez le pseudo : </label></td>
											<td><input type="text" id="membre" name="membre"></td>
										<tr>
										<tr>
											<td colspan="2" align="center"><input type="submit" name="Chercher"></td>
										</tr>
									</table>
								</form>
								<?php
							}
							else //sinon
							{
								$pseudo_d = mysql_real_escape_string($_POST['membre']);

								//Requête qui ramène des info sur le membre à 
								//Partir de son pseudo
								$requete_select = mysql_query('SELECT id, 
																pseudo, mail,
																siteweb, signature, 
																msn, localisation, avatar
																FROM site_membres WHERE pseudo="'.$pseudo_d.'"')
								or ErrorSQL(__FILE__,__LINE__);
								 
								//Si la requête retourne un truc, le membre existe
								if($data_select = mysql_fetch_assoc($requete_select)) 
								{
								?>
									<div id="fil_ariane">
										<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres', 'Administration des membres').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres&amp;action=edit', 'Éditer le profil d\'un membre').' '.fil_ariane(2, '', 'Édition du profil de '.$data_select['pseudo'].''); ?>
									</div>
									<h1>Édition du profil de <?php echo $data_select['pseudo']; ?></h1>
									<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=membres&amp;action=edit" enctype="multipart/form-data">
										<fieldset>
											<legend>Identifiants</legend>
											<label for="pseudo">Pseudo :</label>
											<input type="text" name="pseudo" id="pseudo" value="<?php echo stripslashes(htmlspecialchars($data_select['pseudo'])); ?>" /><br/>
										</fieldset>

										<fieldset>
											<legend>Contacts</legend>
											<label for="email">Adresse E_Mail :</label>
											<input type = "text" name="email" id="email" value="<?php echo stripslashes(htmlspecialchars($data_select['mail'])); ?>" /><br />

											<label for="msn">Adresse MSN :</label>
											<input type = "text" name="msn" id="msn" value="<?php echo stripslashes(htmlspecialchars($data_select['msn'])); ?>" /><br />

											<label for="website">Site web :</label>
											<input type = "text" name="website" id="website" value="<?php echo stripslashes(htmlspecialchars($data_select['siteweb'])); ?>"/><br />
										</fieldset>

										<fieldset>
											<legend>Informations supplémentaire</legend>
											<label for="localisation">Localisation :</label>
											<input type = "text" name="localisation" id="localisation" value="<?php echo stripslashes(htmlspecialchars($data_select['localisation'])); ?>" />
											<br />
										</fieldset>
									   
										<fieldset>
											<legend>Profil sur le forum</legend>
											<label for="avatar">Changer l'avatar :</label>
											<input type="file" name="avatar" id="avatar" />
											<br/>
											<label><input type="checkbox" name="delete" value="Delete" />Supprimer l'avatar actuel : </label>
											<img src="<?php echo $data_select['avatar']; ?>"	alt="Pas d'avatar" />				 
											<br /><br />
											<label for="signature">Signature :</label><br/>
											<textarea cols=40 rows=4 name="signature" id="signature"><?php echo $data_select['signature'] ?></textarea>
										</fieldset>
											<input type="hidden" value="<?php echo stripslashes($data_select['pseudo']); ?>" name="pseudo">
											<input type="submit" value="Modifier le profil" />
									</form>
									<?php
								}
								else
								{
									?>
									<p>Erreur : Ce membre n'existe pas, cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&amp;action=edit">ici</a> pour réessayez</p>
									<?php
								}
							}
						break;
							
						case "droits":
							//Droits d'un membre (rang)
							if(!isset($_POST['membre']))
							{
								?>
								<div id="fil_ariane">
									<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres', 'Administration des membres').' '.fil_ariane(2, '', 'Modifier les droit d\'un membre'); ?>
								</div>
								<h1>Modifier les droits d'un membre</h1>
								<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&action=droits">
									<table style="margin:auto;">
										<tr>
											<td><label for="membre">Inscrivez le pseudo : </label></td>
											<td><input type="text" id="membre" name="membre"></td>
										</tr>
										<tr>
											<td colspan="2" align="center"><input type="submit" value="Chercher"></td>
										</tr>
									</table>
								</form>
								<?php
							}
							else
							{
								$pseudo = mysql_real_escape_string($_POST['membre']);
								$requete_membre = mysql_query('SELECT pseudo, level
																FROM site_membres WHERE pseudo = "'.$pseudo.'"')
								or ErrorSQL(__FILE__,__LINE__);
								if($data = mysql_fetch_assoc($requete_membre))
								{
								?>
									<div id="fil_ariane">
										<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres', 'Administration des membres').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres&amp;action=droits', 'Modifier les droits d\'un membre').' '.fil_ariane(2, '', 'Modifier les droits du membre '.$data['pseudo'].''); ?>
									</div>
									<h1>Modifier les droits du membre <?php echo $data['pseudo']; ?></h1>
									<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=membres&amp;action=droits" />
									<?php
									$rang = array(0 => "Bannis",
													1 => "Visiteur", 
													2 => "Membre", 
													3 => "Modérateur", 
													4 => "Administrateur"); //Ce tableau associe numéro de droit et nom
									
									?>
										<table style="margin:auto;">
											<tr>
												<td align=center><input type="text" name="pseudo" value="<?php echo $data['pseudo']; ?>" disabled="disabled" /></td>
											</tr>
											<tr>
												<td align=center><input type="hidden" name="pseudo" value="<?php echo $data['pseudo']; ?>" /></td>
											</tr>
											<tr>
												<td align="center">
													<select name="droits">
													<?php
													for($i=0;$i<5;$i++)
													{
														if ($i == $data['level'])
														{
															?>
															<option value="<?php echo $i; ?>" selected="selected"><?php echo $rang[$i]; ?></option>
															<?php
														}
														else
														{
															?>
															<option value="<?php echo $i; ?>"><?php echo $rang[$i]; ?></option>
															<?php
														}
													}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td align="center"><input type="submit" value="Envoyer" /></td>
											</tr>
										</table>
									</form>
								<?php
								}
								else
								{
									?>
									<p>Erreur : Ce membre n'existe pas, cliquez <a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&amp;action=droits">ici</a> pour réessayez</p>
									<?php
								}
							}

						break;
							
						case "ban":
							//Bannissement
							?>
							<div id="fil_ariane">
								<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(1, 'forum/?admin=index&amp;cat=membres', 'Administration des membres').' '.fil_ariane(2, '', 'Banissement d\'un membre'); ?>
							</div>
							<h1>Banissement d'un membre</h1>
							<?php
							//Zone de texte pour bannir le membre
							?>
							<form method="post" action="<?php echo ROOTPATH; ?>/forum/?admin=adminok&amp;cat=membres&amp;action=ban">
								<table style="margin:auto;">
									<tr>
										<td align="center">
											<label for="membre">Membre à bannir : </label>
										</td>
									</tr>
									<tr>
										<td align="center">
											<input type="text" id="membre" name="membre">
										</td>
									</tr>
									<?php
							//Ici, on boucle : pour chaque membre banni, on affiche une checkbox
							//Qui propose de le débannir
							$requete_bannissement = mysql_query('SELECT id, pseudo 
																FROM site_membres 
																WHERE rang = 0')
							or ErrorSQL(__FILE__,__LINE__);
							
							//Bien sur, on ne lance la suite que s'il y a des membres bannis !
							if(mysql_num_rows($requete_bannissement) > 0)
							{
								while($data = mysql_fetch_assoc($requete_bannissement))
								{
									?>
									<tr>
										<td align="center">
											<label for="<?php echo $data['id']; ?>">
												<a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data['id']; ?>">
													<?php echo stripslashes(htmlspecialchars($data['pseudo'])); ?>
												</a>
											</label>
											<input type="checkbox" name="<?php echo $data['id']; ?>" /> Débannir
										</td>
									</tr>
									<?php
								}
									?>
									<tr>
										<td align="center">
											<input type="submit" value="Go !" />
										</td>
									</tr>
							</form>
							<?php
							}
							else
							{
							?>
									<tr>
										<td align="center">Aucun membre n'est banni pour le moment</td>
									</tr>
							<?php
							}
							?>
								</table>
							<?php
						break;
							
						default; //action n'est pas remplie, on affiche le menu 
							?>
							<div id="fil_ariane">
								<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?admin=index', 'Administration').' '.fil_ariane(2, '', 'Administration des membres'); ?>
							</div>
							<h1>Administration des membres</h1>
							<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&amp;action=edit">Editer le profil d'un membre</a><br/>
							<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&amp;action=droits">Modifier les droits d'un membre</a><br/>
							<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres&amp;action=ban">Bannir / Débannir un membre</a><br/>
							<?php
						break;
					}
				break;
				
				default; //cat n'est pas remplie, on affiche le menu général
					?>		
					<div id="fil_ariane">
						<?php echo fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(2, '', 'Administration'); ?>
					</div>
					<h1>Index de l'administration</h1>
					<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=config">Configuration du forum</a><br/>
					<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=forum">Administration des forums</a><br/>
					<a href="<?php echo ROOTPATH; ?>/forum/?admin=index&amp;cat=membres">Administration des membres</a><br/>
					<?php
				break;
			}
			?>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->