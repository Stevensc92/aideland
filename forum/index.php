<?php
/*
/forum/index.php

Index du forum.
*/
session_start();
header('Content-type: text/html; charset=utf-8');

/* Config du site et fonctions */
include('../config/config.php');
include('../includes/fonctions.php');

/********Actualisation de la session...**********/

connexionbdd();
actualiser_session();

/********Fin actualisation de session...**********/

/******************/

/* Vérification des méthod GET utilisé */
$keys = array_keys($_GET);
if(count($keys) > 0 && ($keys[0] == "view" || $keys[0] == "poster" || $keys[0] == "admin"))
{
    if(file_exists($keys[0].'/'.$_GET[$keys[0]].'.php'))
    {
        require($keys[0].'/'.$_GET[$keys[0]].'.php');
    }
    else
    {
        require('../error.php');
    }
}
/***************************************/
else
{

	if(isset($_SESSION['membre_id'])) 
	{
		//Premièrement, sélection des champs
		$add1 = ',tv_id, tv_post_id, tv_poste'; 
		//Deuxièmement, jointure
		$add2 = 'LEFT JOIN forum_topic_view 
				ON forum_topic.forum_id = forum_topic_view.tv_forum_id AND forum_topic_view.tv_id = '.intval($_SESSION['membre_id']);
	}
	else
	{
		$add1 = '';
		$add2 = '';
	}
	/* Titre de la page */
	$titre = 'Forum';
	/********************/
	
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Accueil';
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
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, 'forum/', 'Forum');
				?>
				</div>
				<h1>Forum Help World</h1>
				<?php
				//Initialisation de deux variables
				$totaldesmessages = 0;
				$categorie = NULL;
				//Déterminons le niveau d'accès du visiteur
				$level = (isset($_SESSION['level']))?intval($_SESSION['level']):1;
				//Cette requete permet d'obtenir tout sur le forum
				$requete2 = mysql_query('SELECT cat_id, cat_nom,
										forum_forum.forum_id, forum_name, forum_desc, forum_last_post_id, forum_post, forum_topic, auth_view,
										forum_topic.topic_id, forum_topic.topic_post, topic_last_post,
										post_id, post_time, post_createur,
										pseudo, id
										'. $add1 .'
										FROM forum_categorie
										LEFT JOIN forum_forum ON forum_categorie.cat_id = forum_forum.forum_cat_id
										LEFT JOIN forum_post ON forum_post.post_id = forum_forum.forum_last_post_id
										LEFT JOIN forum_topic ON forum_topic.topic_id = forum_post.topic_id
										LEFT JOIN site_membres ON site_membres.id = forum_post.post_createur
										'. $add2 .'
										WHERE auth_view < '.$level.' 
										GROUP BY forum_id
										ORDER BY cat_ordre, forum_ordre DESC')
				or ErrorSQL(__FILE__,__LINE__);
				//Dans un premier temps, on vérifie s'il y a des forums à lister
				if(mysql_num_rows($requete2) < 1)
				{
						echo parseZCode('Il n\'y a pas de forum :o');
				}
				else
				{
					?>
					<table class="liste_membre">
					<?php
					//Début de la boucle
					while($data2 = mysql_fetch_assoc($requete2))
					{
						if(isset($_SESSION['membre_id'])) // Si le membre est connecté
						{
							$nb_topic_lu = mysql_query('SELECT * 
														FROM forum_topic_view
														WHERE tv_id='.intval($_SESSION['membre_id']).'
														AND tv_post_id='.intval($data2['topic_last_post'])) 
							or ErrorSQL(__FILE__,__LINE__);
							if(mysql_num_rows($nb_topic_lu) != 0)
							{
								$ico_mess = 'no_news.png';
								$alt = 'alt="Pas de nouveaux messages" title="Pas de nouveaux messages"';
							}
							else
							{
								$ico_mess = 'news.png'; //S'il y a un nouveau message
								$alt = 'alt="Nouveaux messages" title="Nouveaux messages"';
							}
						} //S'il n'est pas connecté
						else
						{
							$ico_mess = 'no_news.png';
							$alt = 'alt="Vous n\'êtes pas connecté, messages marqués comme lus" title="Vous n\'êtes pas connecté, messages marqués comme lus"';
						}
						if($data2['forum_topic'] == 0)
						{
							$ico_mess = 'no_news.png';
							$alt = 'alt="Il n\'y a encore aucun messages dans ce forum" title="Il n\'y a encore aucun messages dans ce forum"';
						}
						//On affiche chaque catégorie
						if( $categorie != $data2['cat_id'] )
						{
							//Si c'est une nouvelle catégorie on l'affiche		   
							$categorie = $data2['cat_id'];
							?>
							<tr>
								<th class="liste_membre" ></th>
								<th class="liste_membre" width="61%"><strong><?php echo stripslashes(htmlspecialchars($data2['cat_nom'])); ?></strong></th>             
								<th class="liste_membre" width="2%"><strong>Sujets</strong></th>       
								<th class="liste_membre" width="2%"><strong>Messages</strong></th>       
								<th class="liste_membre" width="18%"><strong>Dernier message</strong></th>   
							</tr>
							<?php
						}
						if(verif_auth($data2['auth_view']))
						{
							 // Ce super echo de la mort affiche tous
							 // les forums en détail : description, nombre de réponses etc...
							?>
								<tr>
									<td class="liste_membre">
									<?php
									$requete = mysql_query("SELECT forum_locked
															FROM forum_forum 
															WHERE forum_id = '".$data2['forum_id']."'")
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
									?>
									<td class="liste_membre">
										<a href="<?php echo ROOTPATH; ?>/forum/?view=forum&amp;f=<?php echo $data2['forum_id']; ?>">
											<h2 class="titre_news"><?php echo stripslashes(htmlspecialchars($data2['forum_name'])); ?></h2>
										</a>
										<br/>
										<?php echo parseZCode($data2['forum_desc']); ?>
									</td>
									<td class="liste_membre"><?php echo $data2['forum_topic']; ?></td>
									<td class="liste_membre"><?php echo $data2['forum_post']; ?></td>
							<?php
						}
							// Deux cas possibles :
							// Soit il y a un nouveau message, soit le forum est vide
							if(!empty($data2['forum_post']))
							{
								//Selection dernier message
								$nombreDeMessagesParPage = 15;
								$nbr_post = $data2['topic_post'] +1;
								$page = ceil($nbr_post / $nombreDeMessagesParPage);
							?>
									<td class="liste_membre">
										<?php echo mepd($data2['post_time']); ?><br />
										<a href="<?php echo ROOTPATH;?>/?page=membre&amp;id=<?php echo stripslashes(htmlspecialchars($data2['id'])); ?>"><?php echo $data2['pseudo']; ?></a>
										<a href="<?php echo ROOTPATH;?>/forum/?view=topic&amp;t=<?php echo $data2['topic_id']; ?>&amp;page=<?php echo $page; ?>#p_<?php echo $data2['post_id']; ?>">
										<img src="<?php echo ROOTPATH;?>/forum/design/last_post.gif" alt="go" /></a>
									</td>
								</tr>
							<?php
							}
							else
							{
								echo '<td class="liste_membre">Pas de message</td></tr>';
							}


						//Cette variable stock le nombre de message, on la met à jour
						$totaldesmessages += $data2['forum_post'];

						//On ferme notre boucle et nos balises
					} //fin de la boucle
			?>
			</table>
			<?php

				} //fin du else
			echo '<hr/><br/><div><h2 class="titre_news">Qui est en ligne ?</h2><br/>';
			$requete3 = mysql_query("SELECT id 
									 FROM site_membres")
			or ErrorSQL(__FILE__,__LINE__);
			$TotalDesMembres = mysql_num_rows($requete3);

			$requete4 = mysql_query("SELECT pseudo, id 
									FROM site_membres 
									ORDER BY id 
									DESC LIMIT 0, 1")
			or ErrorSQL(__FILE__,__LINE__);
			$data4 = mysql_fetch_assoc($requete4);
			$derniermembre = stripslashes(htmlspecialchars($data4['pseudo']));

			echo '<p>Les membres ont postés un total de <strong>'.$totaldesmessages.'</strong> messages.<br />';
			echo 'Le site comporte <strong>'.$TotalDesMembres.'</strong> membres.<br />';
			echo 'Le dernier membre inscrit est <a href="'.ROOTPATH.'/?page=membre&amp;id='.$data4['id'].'">'.$derniermembre.'</a>.</p>';
			if(isset($_SESSION['membre_id']))
			{
				$sql = mysql_query("SELECT rang 
									FROM site_membres 
									WHERE id = '".$_SESSION['membre_id']."'")
				or ErrorSQL(__FILE__,__LINE__);
				$req = mysql_fetch_assoc($sql);
				if($req['rang'] >= 90)
				{
					echo '<a href="'.ROOTPATH.'/forum/?admin=index">Accèder à l\'administration du forum.</a>';
				}
			}
			?>
			<br/><br/>
			<hr/>
			<h2 class="titre_news">Légende</h2><br/>
			<div id="legend_fofo">
				<img src="<?php echo ROOTPATH; ?>/forum/design/news.png" alt="Nouveaux messages" /><strong>Nouveaux messages</strong> <img src="<?php echo ROOTPATH; ?>/forum/design/no_news.png" alt="Pas de nouveaux messages" /><strong>Pas de nouveaux message</strong> <img src="<?php echo ROOTPATH; ?>/forum/design/lock.png" alt="Forum vérouillé" /><strong>Forum vérouillé</strong>
			</div>
			</div>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
<?php
}
/* Fermeture des balises html body et autre */
include('../includes/bas.php');
/********************************************/
?>