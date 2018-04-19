<?php
/*
forum/view/topic.php

Lecture des topics.
*/

// On récupère la valeur de t
$topic = (int) $_GET['t'];
 
//A partir d'ici, on va compter le nombre de messages pour n'afficher que les 15 premiers
$requete1 = mysql_query("SELECT topic_titre, topic_post, forum_topic.forum_id, topic_last_post,
						 forum_name, auth_view, auth_topic, auth_post 
						 FROM forum_topic 
						 LEFT JOIN forum_forum ON forum_topic.forum_id = forum_forum.forum_id 
						 WHERE topic_id = '".$topic."'")
or ErrorSQL(__FILE__,__LINE__);
$data1 = mysql_fetch_assoc($requete1);
if(!verif_auth($data1['auth_view']))
{
	$informations = Array( /* Membre qui n'a rien à faire ici */
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
//Topic déjà consulté ?
if(isset($_SESSION['membre_id']))
{
	$nbr_vu = mysql_result(mysql_query("SELECT COUNT(*) FROM forum_topic_view
							WHERE tv_topic_id = '".$topic."' AND tv_id = '".intval($_SESSION['membre_id'])."'"), 0);

	if ($nbr_vu == 0) //Si c'est la première fois on insère une ligne entière
	{
		mysql_query('INSERT INTO forum_topic_view 
		(tv_id, tv_topic_id, tv_forum_id, tv_post_id)
		VALUES ('.intval($_SESSION['membre_id']).', '.$topic.', '.$data1['forum_id'].', '.$data1['topic_last_post'].')')
		or ErrorSQL(__FILE__,__LINE__);
	}
	else //Sinon, on met simplement à jour
	{
		mysql_query('UPDATE forum_topic_view SET tv_post_id = 
		'.$data1['topic_last_post'].' WHERE tv_topic_id = '.$topic.' 
		AND tv_id = '.intval($_SESSION['membre_id']))
		or ErrorSQL(__FILE__,__LINE__);
	}
}
 
$toto_mess = $data1['topic_post'] + 1;
$nb_mess_page = 15;
$nb_page = ceil($toto_mess / $nb_mess_page);


/* Titre de la page */
$titre = 'Forum : '.$data1['forum_name'].' - Topic : '.$data1['topic_titre'].' ';
/********************/
	
/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Forum : '.$data1['forum_name'].' - Topic : '.$data1['topic_titre'].' ';
/******************************************************/

/* Haut de la page, contient le doctype, charset, etc... */
include('../includes/haut.php');
/*********************************************************/
?>
<div class="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php
				echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'forum', 'Forum').' '.fil_ariane(1, 'forum/?view=forum&amp;f='.$data1['forum_id'], 'Forum - '.$data1['forum_name']).' '.fil_ariane(1, 'forum/?view=topic&amp;t='.$topic.'', 'Topic - '.$data1['topic_titre']).' '.fil_ariane(2, 'forum/?view=topic&amp;t='.$topic.'', 'Lecture du topic');
			?>
			</div>
			<br/>
			<?php
			//On affiche le titre :
			echo '<h1>'.stripslashes(htmlspecialchars($data1['topic_titre'])).'</h1><br/>';

			if(verif_auth($data1['auth_post']))
			{
				$req = mysql_query("SELECT forum_locked 
									FROM forum_forum 
									WHERE forum_id = '".$data1['forum_id']."'") 
				or ErrorSQL(__FILE__,__LINE__);
				$donnees = mysql_fetch_assoc($req);
				if($donnees['forum_locked'] != 0)
				{
					echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=topic&amp;f='.$data1['forum_id'].'"><img src="'.ROOTPATH.'/forum/design/topic_lock2.png" alt="vérouiller" title="Ce forum est vérouiller" /></a>';
				}
				else
				{
					//On affiche l'image nouveau topic
					if(verif_auth($data1['auth_post']))
					{
						echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=topic&amp;f='.$data1['forum_id'].'"><img src="'.ROOTPATH.'/forum/design/nouveau.png" alt="Nouveau topic" title="Poster un nouveau topic" /></a>';
					}// Sinon on affiche l'image répondre
					if(verif_auth($data1['auth_post']))
					{	
						$requete9 = mysql_query("SELECT topic_locked 
												 FROM forum_topic 
												 WHERE topic_id = '".$topic."'")
						or ErrorSQL(__FILE__,__LINE__);
						$data9 = mysql_fetch_assoc($requete9);
						if($data9['topic_locked'] != 0) // Si le topic est vérouiller, on affiche l'image vérouiller
						{
							echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=repondre&amp;t='.$topic.'"><img src="'.ROOTPATH.'/forum/design/topic_lock2.png" alt="vérouiller" title="Ce sujet est vérouillé" /></a>';
						}
						else
						{
							echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=repondre&amp;t='.$topic.'"><img src="'.ROOTPATH.'/forum/design/repondre.png" alt="Répondre" title="Répondre à ce topic" /></a>';
						}
					}
				}
			}
			echo '<span class="p">';
			if(isset($_GET['page']))
			{
				$page = intval($_GET['page']);
			}
			else
			{
				$page = 1;
			}
			if(isset($_GET['page']) && $_GET['page'] != 1)
			{
				$i = $_GET['page'] - 1;
				echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$i.'">Précédente</a></span> ';
			}
			//On affiche les pages 1-2-3, etc.
			echo 'Page : |';
			for ($i = 1 ; $i <= $nb_page ; $i++)
			{
				if($i == $page) //On ne met pas de lien sur la page actuelle
				{
					echo ' <span class="page_a">'.$i.'</span> |';
				}
				else
				{
					echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$i.'">'.$i.'</a></span> |';
				}
			}
			if($nb_page != 1)
			{
				if(!isset($_GET['page']))
				{
					$i = +2;
					echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$i.'">Suivante</a></span>';
				}
				elseif(isset($_GET['page']) && $_GET['page'] != $nb_page)
				{
					$i = $_GET['page'] + 1;
					echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$i.'">Suivante</a></span>';
				}
			}
			echo '</span>';
			 
			$first_mess = ($page - 1) * $nb_mess_page;

			//Enfin on commence la boucle !
			$requete2 = mysql_query('SELECT post_id , post_createur , post_texte , post_time ,
									 id, pseudo, inscription, avatar, localisation, nb_post, signature, rang
									 FROM forum_post
									 LEFT JOIN site_membres ON site_membres.id = forum_post.post_createur
									 WHERE topic_id ="'.$topic.'"
									 ORDER BY post_id
									 LIMIT ' . $first_mess . ', ' . $nb_mess_page . '')
			or ErrorSQL(__FILE__,__LINE__);
			//On vérifie que la requête a bien retourné des messages
			if (mysql_num_rows($requete2) < 1)
			{
					echo '<p>Il n\'y a aucun post sur ce topic, vérifiez l\'url et réessayez</p>';
			}
			else
			{
					//Si tout roule on affiche notre tableau puis on remplit avec une boucle
					?>
					<table class="liste_membre">
						<tr>
							<th width="30%" class="thliste_membre"><strong>Auteurs</strong></th>             
							<th width="70%" class="thliste_membre"><strong>Messages</strong></th>       
						</tr>
					<?php
					while ($data2 = mysql_fetch_assoc($requete2))
					{
						//On commence à afficher le pseudo du créateur du message :
						//On vérifie les droits du membre
						//(partie du code commentée plus tard)
						?>
						<tr>
							<td class="liste_membreth">
								<strong><a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data2['id']; ?>">
											<?php echo stripslashes(htmlspecialchars($data2['pseudo'])); ?>
										</a>
								</strong>
							</td>
						<?php           
						/* Si on est l'auteur du message, on affiche des liens pour
						Modérer celui-ci.
						Les modérateurs pourront aussi le faire, il faudra donc revenir sur
						ce code un peu plus tard ! */     
						
						// On récupère le rang du membre pour savoir s'il peut édité ou non
						if(isset($_SESSION['membre_id']))
						{
							$lvl = mysql_query("SELECT level, rang
												FROM site_membres
												WHERE id = '".$_SESSION['membre_id']."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_lvl = mysql_fetch_assoc($lvl);
							if($_SESSION['membre_id'] == $data2['post_createur'] || $req_lvl['level'] > 2 || $req_lvl['rang'] == '10' || $req_lvl['rang'] == '15')
							{
							?>
								<td class="liste_membreth" id="p_<?php echo $data2['post_id']; ?>">
									<span class="news_inf">Posté <?php echo mepd($data2['post_time']); ?></span>
									<a href="<?php echo ROOTPATH; ?>/forum/?poster=post&amp;p=<?php echo $data2['post_id']; ?>&amp;action=delete">
										<img src="<?php echo ROOTPATH; ?>/forum/design/delete.png" alt="Supprimer" title="Supprimer ce message" />
									</a>   
									<a href="<?php echo ROOTPATH; ?>/forum/?poster=post&amp;p=<?php echo $data2['post_id']; ?>&amp;action=edit">
										<img src="<?php echo ROOTPATH; ?>/forum/design/edit.png" alt="Editer" title="Editer ce message" />
									</a>
								</td>
							</tr>
							<?php
							}
						}
						else
						{
						 ?>
							<td class="liste_membreth" id="p_<?php echo $data2['post_id']; ?>"><span class="news_info">Posté <?php echo mepd($data2['post_time']); ?></span></td>
						</tr>
						<?php
						}
						
				   
					 //Détails sur le membre qui a posté
					 ?>
						<tr>
							<td class="liste_membre">
								<span class="forum_avatar"><img src="<?php echo $data2['avatar']; ?>" alt="Avatar de <?php echo $data2['pseudo']; ?>" /></span>
								<br/>Membre inscrit <?php echo mepd($data2['inscription']); ?>
								<br/>Messages : <strong><?php echo $data2['nb_post']; ?></strong><br />
									<?php if(trim($data2['localisation']) != '') { echo 'Localisation : '.stripslashes(htmlspecialchars($data2['localisation'])).'<br/>'; } ?>
								<br/>
								<?php
								if(isset($_SESSION['membre_id']))
								{
								?>
									<span class="forum_mp">
										<a href="<?php echo ROOTPATH; ?>/?page=mp&amp;action=nouveau&amp;id=<?php echo $data2['id']; ?>">Lui envoyer un message privé</a>
									</span>
								<?php
								}
								?>
							</td>
					<?php               
					 //Message
					?>
							<td>
								<div id="forum_mess">
									<?php echo parseZCode($data2['post_texte']);
										echo '<br/><br/><br/>';
										$sql = mysql_query("SELECT post_edit, post_edit_time, post_edit_pseudo, post_edit_affich, post_edit_raison
															FROM forum_post 
															WHERE post_id = '".$data2['post_id']."'") 
										or ErrorSQL(__FILE__,__LINE__);
										$req = mysql_fetch_assoc($sql);
										if(isset($req['post_edit']) && $req['post_edit'] == 1 && $req['post_edit_affich'] == 1)
										{
											if($req['post_edit_raison'] != '')
											{
												$raison = 'Raison : <strong>'.htmlspecialchars($req['post_edit_raison']).'</strong>';
											}
											$sql2 = mysql_query("SELECT pseudo 
																 FROM site_membres 
																 WHERE id = '".$req['post_edit_pseudo']."'") 
											or ErrorSQL(__FILE__,__LINE__);
											$req2 = mysql_fetch_assoc($sql2);
											echo '<span class="post_edit">Édité par <a href="'.ROOTPATH.'/?page=membre&amp;id='.$req['post_edit_pseudo'].'">'.$req2['pseudo'].'</a> '.mepd($req['post_edit_time']).' '.$raison.'</span>';								
										}
										?>
								</div>
								<div id="vt_mess_sign">
									<?php
									if(!empty($data2['signature']))
									{
										echo '<hr/>'.parseZCode($data2['signature']); 
									}
									?>
								</div>
							</td>
						</tr>
					<?php
					}
					//Fin de la boucle ! \o/
					?>
				</table>
				<br/>
				<?php
				echo '<span class="p">';
				if(isset($_GET['page']))
				{
					$page = intval($_GET['page']);
				}
				else
				{
					$page = 1;
				}
				if(isset($_GET['page']) && $_GET['page'] != 1)
				{
					$i = $_GET['page'] - 1;
					echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$i.'">Précédente</a></span> ';
				}
				//On affiche les pages 1-2-3, etc.
				echo 'Page : |';
				for ($i = 1 ; $i <= $nb_page ; $i++)
				{
					if($i == $page) //On ne met pas de lien sur la page actuelle
					{
						echo ' <span class="page_a">'.$i.'</span> |';
					}
					else
					{
						echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$i.'">'.$i.'</a></span> |';
					}
				}
				if($nb_page != 1)
				{
					if(!isset($_GET['page']))
					{
						$i = +2;
						echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$i.'">Suivante</a></span>';
					}
					elseif(isset($_GET['page']) && $_GET['page'] != $nb_page)
					{
						$i = $_GET['page'] + 1;
						echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$i.'">Suivante</a></span>';
					}
				}
				echo '</span>';
				//On affiche l'image nouveau topic
				if(verif_auth($data1['auth_post']))
				{
					$req = mysql_query("SELECT forum_locked 
										FROM forum_forum 
										WHERE forum_id = '".$data1['forum_id']."'") 
					or ErrorSQL(__FILE__,__LINE__);
					$donnees = mysql_fetch_assoc($req);
					
					if($donnees['forum_locked'] != 0)
					{
						echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=topic&amp;f='.$data1['forum_id'].'"><img src="'.ROOTPATH.'/forum/design/topic_lock2.png" alt="vérouiller" title="Ce forum est vérouiller" /></a>';
					}
					else
					{
						//On affiche l'image nouveau topic
						if(verif_auth($data1['auth_post']))
						{
							echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=topic&amp;f='.$data1['forum_id'].'"><img src="'.ROOTPATH.'/forum/design/nouveau.png" alt="Nouveau topic" title="Poster un nouveau topic" /></a>';
						}// Sinon on affiche l'image répondre
						if(verif_auth($data1['auth_post']))
						{	
							$requete9 = mysql_query("SELECT topic_locked 
													 FROM forum_topic 
													 WHERE topic_id = '".$topic."'") 
							or ErrorSQL(__FILE__,__LINE__);
							$data9 = mysql_fetch_assoc($requete9);
							if($data9['topic_locked'] != 0) // Si le topic est vérouiller, on affiche l'image vérouiller
							{
								echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=repondre&amp;t='.$topic.'"><img src="'.ROOTPATH.'/forum/design/topic_lock2.png" alt="vérouiller" title="Ce sujet est vérouillé" /></a>';
							}
							else
							{
								echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=repondre&amp;t='.$topic.'"><img src="'.ROOTPATH.'/forum/design/repondre.png" alt="Répondre" title="Répondre à ce topic" /></a>';
							}
						}
					}
				}
				if(isset($_SESSION['membre_id']))
				{
					$req9 = mysql_query("SELECT level 
										 FROM site_membres 
										 WHERE id = '".$_SESSION['membre_id']."'") 
					or ErrorSQL(__FILE__,__LINE__);
					$donnees9 = mysql_fetch_assoc($req9);
					
					if($donnees9['level'] >= 2)
					{
						$req = mysql_query("SELECT forum_locked 
											FROM forum_forum 
											WHERE forum_id = '".$data1['forum_id']."'") 
						or ErrorSQL(__FILE__,__LINE__);					
						$donnees = mysql_fetch_assoc($req);
						
						if($donnees['forum_locked'] != 0)
						{
							?>
							<div id="lock">
								<div id="erreur">Impossible de vérouiller / dévérouiller ce topic</div>
							</div>
							<?php
						}
						else
						{
							$requete3 = mysql_query('SELECT topic_locked 
													 FROM forum_topic 
													 WHERE topic_id = '.$topic) 
							or ErrorSQL(__FILE__,__LINE__);
							$data3 = mysql_fetch_assoc($requete3);
							
							if($data3['topic_locked'] == 1) // Topic verrouillé !
							{
								?>
								<div id="lock">
									<a href="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=unlock&amp;t=<?php echo $topic; ?>">
										<img src="<?php echo ROOTPATH; ?>/forum/design/topic_unlock.png" alt="deverrouiller" title="Déverrouiller ce sujet" />
									</a>
								</div>
								<?php
							}
							else //Sinon le topic est déverrouillé !
							{
								?>
								<div id="lock">
									<a href="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=lock&amp;t=<?php echo $topic; ?>">
										<img src="<?php echo ROOTPATH; ?>/forum/design/topic_lock.png" alt="verrouiller" title="Verrouiller ce sujet" />
									</a>
									<?php
									$requete = mysql_query('SELECT forum_id, forum_name 
															FROM forum_forum 
															WHERE forum_id <> '.$data1['forum_id'].'') 
									or ErrorSQL(__FILE__,__LINE__);
									//Data 1 a été définie tout en haut de la page !
									?>
									<form method="post" action="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=deplacer&amp;t=<?php echo $topic; ?>">
										<table align="right">
											<tr>
												<td align="center">Déplacer vers :</td>
												<td align="center">
													<select name="dest">
													<?php
														while($data = mysql_fetch_assoc($requete))
														{
															?>
															<option value="<?php echo $data['forum_id']; ?>" id="<?php echo $data['forum_id']; ?>" > <?php echo $data['forum_name']; ?></option>
															<?php
														}
													?>
													</select>
												</td>
												<td align="center">
													<input type="hidden" name="from" value="<?php echo $data1['forum_id']; ?>">
													<input type="submit" name="submit" value="Envoyer" />
												</td>
											</tr>							
										</table>
									</form>
								</div>
								<br/>
								<?php
							}
						}
					}
				}
				//On ajoute 1 au nombre de visites de ce topic
				mysql_query('UPDATE forum_topic 
							 SET topic_vu = topic_vu + 1 
							 WHERE topic_id = '.$topic.'') 
				or ErrorSQL(__FILE__,__LINE__);

			} //Fin du if qui vérifiait si le topic contenait au moins un message
			?>
			<br/>
			<h1>Réponse rapide</h1>
			<br/>
			<form method="post" action="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=repondre&amp;t=<?php echo $topic; ?>" name="formulaire">
				<table style="margin:auto;">
					<tr>
						<td align="center"><label for="textarea">Votre message :</td>
					</tr>
					<tr>
						<td align="center"><textarea name="textarea" id="textarea" cols="70" rows="10"></textarea></td>
					</tr>
					<tr>
						<td align="center"><input type="submit" value="Envoyer" name="rep" id="rep" /> <input type="reset" value="Effacer" name="del" /></td>
					</tr>
				</table>
			</form>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->