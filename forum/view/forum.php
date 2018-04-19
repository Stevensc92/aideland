<?php
/*
forum/view/forum.php

Lecture des forums.
*/

//On récupère la valeur de f
$forum = (int) $_GET['f'];

//A partir d'ici, on va compter le nombre de messages
//pour n'afficher que les 25 premiers
$requete1 = mysql_query("SELECT forum_name, forum_topic, auth_view, auth_topic 
						FROM forum_forum 
						WHERE forum_id = '".$forum."'") 
or ErrorSQL(__FILE__,__LINE__);
$data1 = mysql_fetch_assoc($requete1);
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

$toto_mess = $data1['forum_topic'] + 1;
$nb_mess_page = 15;
$nb_page = ceil($toto_mess / $nb_mess_page);


/* Titre de la page */
$titre = 'Forum - '.$data1['forum_name'].'';
/********************/
	
/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Forum - '.$data1['forum_name'].'';
/******************************************************/

/* Haut de la page, contient le doctype, charset, etc... */
include('../includes/haut.php');
/*********************************************************/
?>
<div id="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php
				echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(2, 'forum/?view=forum&f='.$forum.'', 'Forum - '.$data1['forum_name']);
			?>
			</div>
			<?php
			//Le titre du forum
			echo '<h2 class="titre_news">'.stripslashes(htmlspecialchars($data1['forum_name'])).'</h2><br/><br/>';
			// Bouton pour poster
			if(verif_auth($data1['auth_topic']))
			{
				$requete = mysql_query("SELECT forum_locked 
										FROM forum_forum 
										WHERE forum_id = '".$forum."'") 
				or ErrorSQL(__FILE__,__LINE__);
				$data = mysql_fetch_assoc($requete);
				
				if($data['forum_locked'] != 0)
				{
					echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=topic&amp;f='.$forum.'"><img src="'.ROOTPATH.'/forum/design/topic_lock2.png" alt="vérouiller" title="Ce forum est vérouiller" /></a>';
				}
				else
				{
					echo '<a href="'.ROOTPATH.'/forum/?poster=post&amp;action=topic&amp;f='.$forum.'"><img src="'.ROOTPATH.'/forum/design/nouveau.png" alt="Nouveau topic" title="Poster un nouveau topic" /></a>';
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
				echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=forum&amp;f='.$forum.'&amp;page='.$i.'">Précédente</a></span> ';
			}
			echo 'Page : |';
			//On affiche les pages 1-2-3, etc.
			for ($i = 1 ; $i <= $nb_page ; $i++)
			{
				if($i == $page) //On ne met pas de lien sur la page actuelle
				{
					echo ' <span class="page_a">'.$i.'</span> |';
				}
				else
				{
					echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=forum&amp;f='.$forum.'&amp;page='.$i.'">'.$i.'</a></span> |';
				}
			}
			if($nb_page != 1)
			{
				if(!isset($_GET['page']))
				{
					$i = +2;
					echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=forum&amp;f='.$forum.'&amp;page='.$i.'">Suivante</a></span>';
				}
				elseif(isset($_GET['page']) && $_GET['page'] != $nb_page)
				{
					$i = $_GET['page'] + 1;
					echo ' <span class="p_lien"><a href="'.ROOTPATH.'/forum/?view=forum&amp;f='.$forum.'&amp;page='.$i.'">Suivante</a></span>';
				}
			}
			echo '</span>';

			$first_mess = ($page - 1) * $nb_mess_page;

			if(isset($_SESSION['membre_id'])) 
			{
				//Premièrement, sélection des champs
				$add1 = ',tv_id, tv_post_id, tv_poste'; 
				//Deuxièmement, jointure
				$add2 = 'LEFT JOIN forum_topic_view 
				ON forum_topic.topic_id = forum_topic_view.tv_topic_id AND forum_topic_view.tv_id = '.intval($_SESSION['membre_id']);
			}
			else
			{
				$add1 = '';
				$add2 = '';
			}

			$requete3 = mysql_query('SELECT forum_topic.topic_id, topic_titre, topic_createur, topic_vu, topic_post, topic_time, topic_last_post, topic_locked,
									 Mb.pseudo AS membre_pseudo_createur, post_id, post_createur, post_time, Ma.pseudo AS membre_pseudo_last_posteur 
									 '.$add1.' 
									 FROM forum_topic
									 LEFT JOIN site_membres Mb ON Mb.id = forum_topic.topic_createur
									 LEFT JOIN forum_post ON forum_topic.topic_last_post = forum_post.post_id
									 LEFT JOIN site_membres Ma ON Ma.id = forum_post.post_createur  
									 '.$add2.'
									 WHERE topic_genre = "Annonce" AND forum_topic.forum_id = "'.$forum.'"
									 ORDER BY topic_last_post DESC')
			or ErrorSQL(__FILE__,__LINE__);						
			//On lance notre tableau seulement s'il y a des requêtes !
			if (mysql_num_rows($requete3) > 0)
			{
				?>
				<table class="liste_membre">  
					<tr>
						<th class="liste_membre" width="15%"><img src="./images/annonce.png" alt="Annonce" /></th>
						<th class="liste_membre" width="15%"><strong>Titre</strong></th>             
						<th class="liste_membre" width="2%"><strong>Réponses</strong></th>
						<th class="liste_membre" width="2%"><strong>Vus</strong></th>
						<th class="liste_membre" width="15%"><strong>Auteur</strong></th>                       
						<th class="liste_membre" width="15%"><strong>Dernier message</strong></th>
					</tr>
					<?php
					//On commence la boucle
					while ($data3 = mysql_fetch_assoc($requete3))
					{
						if (isset($_SESSION['membre_id'])) // Si le membre est connecté
						{
							if($data3['tv_id'] == $_SESSION['membre_id']) //S'il a lu le topic
							{
								if($data3['tv_poste'] == '0') // S'il n'a pas posté
								{
									if ($data3['tv_post_id'] == $data3['topic_last_post']) //S'il n'y a pas de nouveau message
									{
										$ico_mess = 'no_news.png';
									}
									else
									{
										$ico_mess = 'news.png'; //S'il y a un nouveau message
									}
								}
								else // S'il a posté
								{
									if ($data3['tv_post_id'] == $data3['topic_last_post']) //S'il n'y a pas de nouveau message
									{
										$ico_mess = 'no_news.png';
									}
									else //S'il y a un nouveau message
									{
										$ico_mess = 'news.png';
									}
								}
							}
							else //S'il n'a pas lu le topic
							{
								$ico_mess = 'news.png';
							}
						} //S'il n'est pas connecté
						else
						{
							$ico_mess = 'no_news.png';
						}
						//Pour chaque topic :
						//Si le topic est une annonce on l'affiche en haut
						//mega echo de bourrain pour tout remplir
						
						?>
						<tr>
							<td class="liste_membre"><img src="<?php echo ROOTPATH; ?>/forum/design/<?php echo $ico_mess; ?>" alt="Annonce" /></td>
							<td class="liste_membre"><strong>Annonce : </strong>
							<strong><a href="<?php echo ROOTPATH; ?>/forum/?view=topic&amp;t=<?php echo $data3['topic_id'];?>" title="Topic commencé à <?php echo mepd($data3['topic_time']); ?>">
							<?php echo stripslashes(htmlspecialchars($data3['topic_titre'])); ?></a></strong>
							<?php
							$nb_mess_page = 15;
							$nbr_post = $data3['topic_post'] +1;
							$nb_page = ceil($nbr_post / $nb_mess_page);
							?>
							</td>
							<td class="liste_membre"><?php echo $data3['topic_post']; ?></td>
							<td class="liste_membre"><?php echo $data3['topic_vu']; ?></td>
							<td class="liste_membre"><a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data3['topic_createur']; ?>">
							<?php echo stripslashes(htmlspecialchars($data3['membre_pseudo_createur'])); ?></a></td>
						<?php
						//Selection dernier message
						$nb_mess_page = 15;
						$nbr_post = $data3['topic_post'] +1;
						$page = ceil($nbr_post / $nb_mess_page);
						?>
							<td class="liste_membre">Par <a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data3['post_createur'];?>">
							<?php echo stripslashes(htmlspecialchars($data3['membre_pseudo_last_posteur'])); ?></a><br/>
								<a href="<?php echo ROOTPATH; ?>/forum/?vieux=topic?t=<?php echo $data3['topic_id']; ?>&amp;page=<?php echo $page; ?>#p_<?php echo $data3['post_id']; ?>"><?php echo mepd($data3['post_time']); ?></a>
							</td>
						</tr>
						<?php
					}
					?>
					</table>
					<?php
			}
			//On prend tout ce qu'on a sur les topics normaux du forum


			$requete3 = mysql_query('SELECT forum_topic.topic_id, topic_titre, topic_createur, topic_vu, topic_post, topic_time, topic_last_post,
									 Mb.pseudo AS membre_pseudo_createur, post_id, post_createur, post_time, Ma.pseudo AS membre_pseudo_last_posteur
									 '.$add1.'
									 FROM forum_topic
									 LEFT JOIN site_membres Mb ON Mb.id = forum_topic.topic_createur
									 LEFT JOIN forum_post ON forum_topic.topic_last_post = forum_post.post_id
									 LEFT JOIN site_membres Ma ON Ma.id = forum_post.post_createur   
									 '.$add2.'
									 WHERE topic_genre <> "Annonce" AND forum_topic.forum_id = "'.$forum.'"
									 ORDER BY topic_last_post DESC
									 LIMIT ' .$first_mess. ', ' . $nb_mess_page .'')
			or ErrorSQL(__FILE__,__LINE__);
			if (mysql_num_rows($requete3) > 0)
			{
			?>
				<table class="liste_membre">
					<tr>
						<th class="liste_membre" width="15%">Message</th>
						<th class="liste_membre" width="15%"><strong>Titre</strong></th>             
						<th class="liste_membre" width="2%"><strong>Réponses</strong></th>
						<th class="liste_membre" width="2%"><strong>Vus</strong></th>
						<th class="liste_membre" width="15%"><strong>Auteur</strong></th>                       
						<th class="liste_membre" width="15%"><strong>Dernier message</strong></th>
					</tr>
					<?php
					//On lance la boucle
				   
					while ($data3 = mysql_fetch_assoc($requete3))
					{
						if(isset($_SESSION['membre_id'])) // Si le membre est connecté
						{
							if ($data3['tv_id'] == $_SESSION['membre_id']) //S'il a lu le topic
							{
								if($data3['tv_poste'] == '0') // S'il n'a pas posté
								{	
									if($data3['tv_post_id'] == $data3['topic_last_post']) //S'il n'y a pas de nouveau message
									{
										$ico_mess = 'no_news.png';
									}
									else
									{
										$ico_mess = 'news.png'; //S'il y a un nouveau message
									}
								}
								else // S'il a  posté
								{
									if ($data3['tv_post_id'] == $data3['topic_last_post']) //S'il n'y a pas de nouveau message
									{
										$ico_mess = 'no_news.png';
									}
									else //S'il y a un nouveau message
									{
										if($data3['tv_id'] == $_SESSION['membre_id'])
										{
											$ico_mess = 'no_news.png';
										}
										else
										{
											$ico_mess = 'news.png';
										}
									}
								}
							}
							else //S'il n'a pas lu le topic
							{
								$ico_mess = 'news.png';
							}
						} //S'il n'est pas connecté
						else
						{
							$ico_mess = 'no_news.png';
						}
						//Ah bah tiens... re vla l'echo de fou
					?>
						<tr>
							<td class="liste_membre">
									<?php
									$requete = mysql_query("SELECT forum_locked 
															FROM forum_forum 
															WHERE forum_id = '".$forum."'") 
									or ErrorSQL(__FILE__,__LINE__);
									$data = mysql_fetch_assoc($requete);
									if($data['forum_locked'] != 0)
									{
										?>
										<img src="<?php echo ROOTPATH; ?>/forum/design/lock.png" alt="vérouiller" /></td>
										<?php
									}
									else
									{
										?>
										<img src="<?php echo ROOTPATH;?>/forum/design/<?php echo $ico_mess; ?>" alt="message" /></td>
										<?php
									}
									?></td>
							<td class="liste_membre">
								<strong><a href="<?php echo ROOTPATH; ?>/forum/?view=topic&amp;t=<?php echo $data3['topic_id']; ?>" title="Topic commencé à <?php echo mepd($data3['topic_time']); ?>">
								<?php echo stripslashes(htmlspecialchars($data3['topic_titre'])); ?></a></strong>
								<?php
							$nb_mess_page = 15;
							$nbr_post = $data3['topic_post'] +1;
							$nb_page = ceil($nbr_post / $nb_mess_page);
							?>
							</td>
							<td class="liste_membre"><?php echo $data3['topic_post']; ?></td>
							<td class="liste_membre"><?php echo $data3['topic_vu']; ?></td>
							<td class="liste_membre"><a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data3['topic_createur']; ?>">
								<?php echo stripslashes(htmlspecialchars($data3['membre_pseudo_createur'])); ?></a>
							</td>
					<?php	
						//Selection dernier message
						$nb_mess_page = 15;
						$nbr_post = $data3['topic_post'] +1;
						$page = ceil($nbr_post / $nb_mess_page);
					?>
							<td class="liste_membre">Par <a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data3['post_createur']; ?>">
							<?php echo stripslashes(htmlspecialchars($data3['membre_pseudo_last_posteur'])); ?></a><br/>
							<a href="<?php echo ROOTPATH; ?>/forum/?view=topic&amp;t=<?php echo $data3['topic_id']; ?>&amp;page=<?php echo $page; ?>#p_<?php echo $data3['post_id']; ?>"><?php echo mepd($data3['post_time']); ?></a>
							</td>
						</tr>
					<?php
					}
					?>
					</table>
					<?php
			}
			else //S'il n'y a pas de message
			{
					echo'<p>Ce forum ne contient aucun sujet actuellement</p>';
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
					$req10 = mysql_query("SELECT forum_locked 
										  FROM forum_forum 
										  WHERE forum_id = '".$forum."'") 
					or ErrorSQL(__FILE__,__LINE__);
					$donnees10 = mysql_fetch_assoc($req10);
					
					if($donnees10['forum_locked'] == 1) // Si le forum est vérouillé
					{
						?>
						<div id="lock">
							<a href="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=unlock_forum&amp;f=<?php echo $forum; ?>">
								<img src="<?php echo ROOTPATH; ?>/forum/design/topic_unlock.png" alt="deverrouiller" title="Déverrouiller ce forum" />
							</a>
						</div>
						<?php
					}
					else //Sinon le forum est déverrouillé !
					{
						?>
						<div id="lock">
							<a href="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=lock_forum&amp;f=<?php echo $forum; ?>">
								<img src="<?php echo ROOTPATH; ?>/forum/design/topic_lock.png" alt="verrouiller" title="Verrouiller ce forum" />
							</a>
						</div>
						<?php
					}
				}
			}
			?>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->