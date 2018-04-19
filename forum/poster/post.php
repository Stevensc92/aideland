<?php
/*
forum/poster/post.php

Post de topic ou une réponse
*/
	/* Titre de la page */
	$titre = 'Forum';
	/********************/
		
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Forum';
	/******************************************************/

	if(isset($_GET['f']))
	{
		$forum = (int) $_GET['f'];
		$requete1 = mysql_query('SELECT forum_name, auth_view, auth_post, auth_topic, auth_annonce, auth_modo
								 FROM forum_forum
								 WHERE forum_id ="'.$forum.'"')
		or ErrorSQL(__FILE__,__LINE__);
		
		$data1 = mysql_fetch_array($requete1);
		$titre  .= ' - '.stripslashes(htmlspecialchars($data1['forum_name'])).' : Nouveau topic';
		$titre2 .= ' - '.stripslashes(htmlspecialchars($data1['forum_name'])).' : Nouveau topic';
	}
	elseif(isset($_GET['t']))
	{
		$topic = (int) $_GET['t'];
		$requete1 = mysql_query('SELECT topic_titre, forum_topic.forum_id,
								 forum_name, auth_view, auth_post, auth_topic, auth_annonce, auth_modo
								 FROM forum_topic
								 LEFT JOIN forum_forum ON forum_forum.forum_id = forum_topic.forum_id
								 WHERE topic_id ="'.$topic.'"')
		or ErrorSQL(__FILE__,__LINE__);
		
		$data1 = mysql_fetch_array($requete1);
		$forum = $data1['forum_id'];
		$titre  .= ' - '.stripslashes(htmlspecialchars($data1['forum_name'])).' - Topic : '.stripslashes(htmlspecialchars($data1['topic_titre'])).' - Répondre';
		$titre2 .= ' - '.stripslashes(htmlspecialchars($data1['forum_name'])).' - Topic : '.stripslashes(htmlspecialchars($data1['topic_titre'])).' - Répondre';
	}
	elseif(isset($_GET['p']))
	{
		$post = (int) $_GET['p'];
		$requete1 = mysql_query('SELECT post_createur, forum_post.topic_id, topic_titre, forum_topic.forum_id,
								 forum_name, auth_view, auth_post, auth_topic, auth_annonce, auth_modo
								 FROM forum_post
								 LEFT JOIN forum_topic ON forum_topic.topic_id = forum_post.topic_id
								 LEFT JOIN forum_forum ON forum_forum.forum_id = forum_topic.forum_id
								 WHERE forum_post.post_id ="'.$post.'"')
		or ErrorSQL(__FILE__,__LINE__);
		
		$data1 = mysql_fetch_array($requete1);
		$topic = $data1['topic_id'];
		$forum = $data1['forum_id'];
	}
	if(!verif_auth($data1['auth_view']))
	{
		$informations = array( /* Membre qui n'a rien à faire ici */
						true,
						'Erreur',
						'Vous ne possèdez pas les droits pour être ici.',
						'',
						ROOTPATH.'/forum',
						3
						);
		require_once('../information.php');
		exit();
	}

	/* Haut de la page, contient le doctype, charset, etc... */
	include('../includes/haut.php');
	/*********************************************************/
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<?php
				//Qu'est ce qu'on veut faire ? poster, répondre ou éditer ?
				$action = htmlspecialchars($_GET['action']);
				 
				//Si on veut poster un nouveau topic, la variable f se trouve dans l'url,
				//On récupère certaines valeurs
				if(isset($_GET['f']))
				{
					$forum = (int) $_GET['f'];
					$requete1 = mysql_query('SELECT forum_name, auth_view, auth_post, auth_topic, auth_annonce, auth_modo
											 FROM forum_forum
											 WHERE forum_id ="'.$forum.'"') 
					or ErrorSQL(__FILE__,__LINE__);
					$data1 = mysql_fetch_array($requete1);
					
					?>
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?view=forum&amp;f='.$forum, 'Forum - '.stripslashes(htmlspecialchars($data1['forum_name']))).' '.fil_ariane(2, 'forum/?poster=post&amp;action=topic&amp;f='.$forum.'', 'Créer un nouveau topic'); ?>
					</div>	 
					<?php
				}
				//Sinon c'est un nouveau message, on a la variable t et
				//On récupère f grâce à une requête
				elseif(isset($_GET['t']))
				{
					$topic = (int) $_GET['t'];
					$requete1 = mysql_query('SELECT topic_titre, forum_topic.forum_id,
											 forum_name, auth_view, auth_post, auth_topic, auth_annonce, auth_modo
											 FROM forum_topic
											 LEFT JOIN forum_forum ON forum_forum.forum_id = forum_topic.forum_id
											 WHERE topic_id ="'.$topic.'"')
					or ErrorSQL(__FILE__,__LINE__);
					$data1 = mysql_fetch_array($requete1);
					
					$forum = $data1['forum_id'];
					?>
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?view=forum&amp;f='.$forum, 'Forum -  '.stripslashes(htmlspecialchars($data1['forum_name']))).' '.fil_ariane(1, 'forum/?view=topic&amp;t='.$topic, 'Topic - '.stripslashes(htmlspecialchars($data1['topic_titre']))).' '.fil_ariane(2, 'forum/?poster=post&amp;action=repondre&amp;t='.$topic.'', 'Répondre au topic : '.stripslashes(htmlspecialchars($data1['topic_titre']))); ?>
					</div>
					<?php
				}
				//Enfin sinon c'est au sujet de la modération(on verra plus tard en détail)
				//On ne connait que le post, il faut chercher le reste
				elseif(isset($_GET['p']))
				{
					$post = (int) $_GET['p'];
					$requete1 = mysql_query('SELECT post_createur, forum_post.topic_id, topic_titre, forum_topic.forum_id,
											 forum_name, auth_view, auth_post, auth_topic, auth_annonce, auth_modo
											 FROM forum_post
											 LEFT JOIN forum_topic ON forum_topic.topic_id = forum_post.topic_id
											 LEFT JOIN forum_forum ON forum_forum.forum_id = forum_topic.forum_id
											 WHERE forum_post.post_id ="'.$post.'"')
					or ErrorSQL(__FILE__,__LINE__);
					$data1 = mysql_fetch_array($requete1);
					
					$sql = mysql_query("SELECT pseudo
										FROM site_membres
										WHERE id = '".$data1['post_createur']."'")
					or ErrorSQL(__FILE__,__LINE__);
					$req = mysql_fetch_assoc($sql);
					
					$topic = $data1['topic_id'];
					$forum = $data1['forum_id'];
					?>
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'forum', 'Forum').' '.fil_ariane(1, 'forum/?view=forum&amp;f='.$forum, 'Forum - '.stripslashes(htmlspecialchars($data1['forum_name']))).' '.fil_ariane(1, 'forum/?view=topic&amp;t='.$topic, 'Topic - '.stripslashes(htmlspecialchars($data1['topic_titre']))).' '.fil_ariane(2, 'forum/?poster=post&amp;p='.$post.'&amp;action=edit', 'Modifier le message n°'.$post.' de '.$req['pseudo']); ?>
					</div>
				<?php
				}
				switch($action)
				{
					case "repondre": //Premier cas : on souhaite répondre
					//Ici, on affiche le formulaire de réponse
					$requete = mysql_query("SELECT topic_locked 
											FROM forum_topic 
											WHERE topic_id = '".$topic."'") 
					or ErrorSQL(__FILE__,__LINE__);
					$data = mysql_fetch_assoc($requete);
					if($data['topic_locked'] >= 0)
					{
						if(verif_auth($data1['auth_post']))
						{
							?>
							<form method="post" action="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=repondre&amp;t=<?php echo $topic ?>" name="formulaire">
								<br/>
								<h1>Poster une réponse</h1>
								<br/>
								<table style="margin:auto;">
									<tr>
										<td align="center">
											<label for="textarea">Votre message :</label><br/><br/>
											<?php include('../includes/haut_bbcode.php'); ?>
											<br/>
											<textarea name="textarea" id="textarea" cols="70" rows="15" ><?php if(!empty($_POST['textarea'])) { echo $_POST['textarea']; } ?></textarea>
											<?php $f = ''; include('../includes/bas_bbcode.php'); ?>
										</td>
									</tr>
									<tr>
										<td align="center"><input type="submit" id="rep" name="rep" value="Répondre" /> <input type="reset" id="del" name="del" value="Effacer" onclick="return confirm('Ête vous sûr de vouloir effacer le message que vous venez d\'écrire ?');" /></td>
									</tr>
								</table>
							</form>
							<?php
						}
						else
						{
							quit('<div id="erreur">Le topic est verrouillé ! Cliquez <a href="'.ROOTPATH.'/forum/">ici</a> 
							pour revenir à l\'index du forum.<br/>
							Cliquez <a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'">ici</a> 
							pour retourner au topic.</div>');
						}
					}
					break;
					 
					case "topic": //Deuxième cas : on souhaite créer un nouveau topic
					//Ici, on affiche le formulaire de nouveau topic
					$requete = mysql_query("SELECT forum_locked 
											FROM forum_forum 
											WHERE forum_id = '".$forum."'") 
					or ErrorSQL(__FILE__,__LINE__);
					$data = mysql_fetch_assoc($requete);
					if($data['forum_locked'] >= 0)
					{
						if(verif_auth($data1['auth_topic']))
						{
						?>
						<form method="post" action="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=topic&amp;f=<?php echo $forum ?>" name="formulaire">
							<br/>
							<h1>Créer un nouveau topic</h1>
							<br/>
							<table style="margin:auto;">
								<tr>
									<td align="center"><label for="titre">Titre :</label></td>
								</tr>
								<tr>
									<td align="center"><input type="text" id="titre" name="titre" value="<?php if(!empty($_POST['titre'])) { echo $_POST['titre']; } ?>" /><br/><br/></td>
								</tr>
								<tr>
									<td align="center">
										<label for="textarea">Votre message :</label><br/>
										<?php include('../includes/haut_bbcode.php'); ?>
										<textarea name="textarea" id="textarea" cols="70" rows="15" ><?php if(!empty($_POST['textarea'])) { echo $_POST['textarea']; } ?></textarea>
										<?php $f = ''; include('../includes/bas_bbcode.php'); ?>
										<?php
										if(verif_auth($data1['auth_annonce']))
										{
										?>
											<label><input type="radio" name="mess" value="Annonce" />Annonce</label>
											<label><input type="radio" name="mess" value="Message" checked="checked" />Topic</label>
										<?php
										}
										?>
									</td>
								</tr>
								<tr>
									<td align="center"><input type="submit" id="topic" name="topic" value="Envoyer" />  <input type="reset" id="del" name="del" value="Effacer" onclick="return confirm('Ête vous sûr de vouloir effacer le message que vous venez d\'écrire ?');" /></td>
								</tr>
							</table>
						</form>
						<?php
						}
						else
						{
							quit('<div id="erreur">Le topic est verrouillé ! Cliquez <a href="'.ROOTPATH.'/forum/">ici</a> 
							pour revenir à l\'index du forum.<br/>
							Cliquez <a href="'.ROOTPATH.'/forum/?view=forum&amp;f='.$forum.'">ici</a> 
							pour retourner au forum.</div>');
						}
					}
					break;
					
					case "edit": // Si on veut éditer
						$post = (int) $_GET['p'];
						echo '<br/><h1>Edition</h1><br/>';
						// On lance la requête pour récupéré le message
						$requete2 = mysql_query('SELECT post_createur, post_texte, post_edit_raison, post_edit_affich, auth_modo
												 FROM forum_post
												 LEFT JOIN forum_forum ON forum_post.post_forum_id = forum_forum.forum_id
												 WHERE post_id='.$post.'')
						or ErrorSQL(__FILE__,__LINE__);
						$data2 = mysql_fetch_assoc($requete2);
						
						$text_edit = $data2['post_texte'];
						
						//Ensuite on vérifie que le membre a le droit d'être ici (soit le créateur soit un modo/admin) 
						if(!verif_auth($data2['auth_modo']) && $data2['post_createur'] != $_SESSION['membre_id'] )
						{
							// Si cette condition n'est pas remplie ça va barder :o
							quit('<p>Vous n\'avez aucun droit d\'être ici</p>');
						}
						else
						{
						?>
							<form method="post" action="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=edit&amp;p=<?php echo $post; ?>" name="formulaire">
								<table style="margin:auto;">
									<tr>
										<td align="center">
											<?php
												include('../includes/haut_bbcode.php');
											?>
											<label for="textarea">Votre message :</label><br/>
											<textarea name="textarea" id="textarea" cols="70" rows="15" ><?php echo stripslashes($text_edit); ?></textarea>
											<?php
												$f = ''; include('../includes/bas_bbcode.php');
											?>
										</td>
									</tr>
									<tr>
										<td>
											<input type="checkbox" name="affich_edit" id="affich_edit" <?php if($data2['post_edit_affich'] == 1){ echo 'checked="checked"'; }?> /><label for="affich_edit">Cocher cette case pour afficher <strong>"Édit par (Pseudo) le (Date) (Raison : XXX)</strong></label>
										</td>
									</tr>
									<tr>
										<td>
											<label for="edit_raison">Raison de l'édition :</label>
											<input type="text" name="raison" id="raison" value="<?php echo $data2['post_edit_raison']; ?>"/><em>(Laissez vide pour ne pas mettre de raison)</em>
										</td>
									</tr>
									<tr>
										<td align="center"><input type="submit" name="submit" value="Éditer" /></td>
									</tr>
								</table>
							</form>
						<?php
						}

					break;
					case "delete": // Si on veut supprimer
					// On récupère la valeur de p
					$post = (int) $_GET['p'];
					//Ensuite on vérifie que le membre a le droit d'être ici
					echo '<br/><h1>Suppression</h1><br/>';
					$requete2 = mysql_query('SELECT post_createur, auth_modo
											 FROM forum_post
											 LEFT JOIN forum_forum ON forum_post.post_forum_id = forum_forum.forum_id
											 WHERE post_id='.$post.'')
					or ErrorSQL(__FILE__,__LINE__);
					$data2 = mysql_fetch_assoc($requete2);
					 
					if(!verif_auth($data2['auth_modo']) && $data2['post_createur'] != $_SESSION['membre_id'])
					{
						// Si cette condition n'est pas remplie ça va barder :o
						quit('<div id="erreur">Vous n\'avez aucun droit d\'être ici</div>');
					}
					else //Sinon ça roule et on affiche la suite
					{
						echo '<div id="information">Êtes vous certains de vouloir supprimer ce post ?</div>';
						echo '<p><a href="'.ROOTPATH.'/forum/?poster=postk&amp;action=delete&amp;p='.$post.'">Oui</a> - <a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'">Non</a></p>';		
					}
					break;
					
					default: //Si jamais c'est aucun de ceux-là, c'est qu'il y a eu un problème :o
					echo '<h2>Cette action est impossible</h2>';	 
				} //Fin du switch
			?>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->