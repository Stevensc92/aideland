<?php
/*
forum/poster/postk.php

Validation des nouveaux message
*/	
if(!isset($_SESSION['membre_id']))
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
	
	$action = htmlspecialchars($_GET['action']);
	switch($action)
	{
		//Premier cas : répondre
		case "repondre":
		
		//On passe le message dans une série de fonction
		$message = add_SQL($_POST['textarea']);
		//ici seulement, maintenant qu'on est sur qu'elle existe, on récupère la valeur de la variable t
		$topic = (int) $_GET['t'];
		
		$sql = mysql_query("SELECT forum_id, topic_titre
							FROM forum_topic
							WHERE topic_id = '".$topic."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req = mysql_fetch_assoc($sql);
		
		$sql2 = mysql_query("SELECT forum_name
							 FROM forum_forum
							 WHERE forum_id = '".$req['forum_id']."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req2 = mysql_fetch_assoc($sql2);
		
		/* Titre de la page */
		$titre = 'Répondre à un topic';
		/********************/

		/* Titre de la page */
		$titre2 = 'Répondre au topic '.$req['topic_titre'];
		/******************************************************/

		/* Haut de la page, contient le doctype, charset, etc... */
		include('../includes/haut.php');
		/*********************************************************/
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?view=forum&amp;f='.$req['forum_id'].'', 'Forum - '.$req2['forum_name'].'').' '.fil_ariane(1, 'forum/?view=topic&amp;t='.$topic.'', 'Topic - '.$req['topic_titre'].'').' '.fil_ariane(2, 'forum/?poster=post&amp;action=repondre&amp;t='.$topic.'', 'Répondre au topic - '.$req['topic_titre'].''); ?>
					</div>
					<br/>
					<h1><?php echo $titre2; ?></h1>
					<br/>
				<?php					
					$requete = mysql_query("SELECT topic_locked 
											FROM forum_topic 
											WHERE topic_id = '".$topic."'") 
					or ErrorSQL(__FILE__,__LINE__);
					$data = mysql_fetch_assoc($requete);
					
					if($data['topic_locked'] != 0)
					{
						quit('<div id="erreur">Le topic est verrouillé ! Cliquez <a href="'.ROOTPATH.'/forum/">ici</a> 
						pour revenir à l\'index du forum.<br/>
						Cliquez <a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'">ici</a> 
						pour retourner au topic.</div>');
					}
					$temps = time();

					if(empty($message))
					{
						echo '<div id="erreur">Votre message est vide, cliquez <a href="'.ROOTPATH.'/forum/?poster=post&amp;action=repondre&amp;t='.$topic.'">ici</a> pour recommencer</div>';
					}
					else //Sinon, si le message n'est pas vide
					{
						//On récupère l'id du forum
						$requete2 = mysql_query('SELECT forum_id, topic_post
												 FROM forum_topic
												 WHERE topic_id = "'.$topic.'"')
						or ErrorSQL(__FILE__,__LINE__);

						$data2= mysql_fetch_assoc($requete2);
						$forum = $data2['forum_id'];

						//Puis on entre le message
						mysql_query("INSERT INTO forum_post
									(post_id, post_createur, post_texte, post_time, topic_id, post_forum_id)
									VALUES(',' ,'".intval($_SESSION['membre_id'])."', '".$message."', '".$temps."', '".$topic."', '".$forum."')")
						or ErrorSQL(__FILE__,__LINE__);

						$nouveaupost = mysql_insert_id();

						//On change un peu la table forum_topic
						mysql_query("UPDATE forum_topic
									 SET topic_post = topic_post + 1,
									 topic_last_post = '".$nouveaupost."'
									 WHERE topic_id ='".$topic."'")
						or ErrorSQL(__FILE__,__LINE__);

						//Puis même combat sur les 2 autres tables
						mysql_query("UPDATE forum_forum
									 SET forum_post = forum_post + 1 ,
									 forum_last_post_id = '".$nouveaupost."'
									 WHERE forum_id = '".$forum."'")
						or ErrorSQL(__FILE__,__LINE__);

						mysql_query("UPDATE site_membres
									 SET nb_post = nb_post + 1
									 WHERE id = '".intval($_SESSION['membre_id'])."'")
						or ErrorSQL(__FILE__,__LINE__);
						
						//On update la table forum_topic_view
						mysql_query('UPDATE forum_topic_view 
									 SET tv_post_id = '.$nouveaupost.', tv_poste = "1"
									 WHERE tv_id = '.intval($_SESSION['membre_id']).' AND tv_topic_id = '.$topic.'')
						or ErrorSQL(__FILE__,__LINE__);

						//Et un petit message
						$nombreDeMessagesParPage = 15;
						$nbr_post = $data2['topic_post']+1;
						$page = ceil($nbr_post / $nombreDeMessagesParPage);
						echo'<div id="information" align="center">Votre message a bien été ajouté!<br />
						Cliquez <a href="'.ROOTPATH.'/forum/">ici</a> pour revenir à l\'index du forum<br />
						Cliquez <a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$page.'#p_'.$nouveaupost.'">ici</a> pour le voir</div>';
					}
				?>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
		break;
		
		//Deuxième cas : nouveau topic
		case "topic":
		
		//On passe le message dans une série de fonction
		$message = add_SQL($_POST['textarea']);
		$mess = add_SQL($_POST['mess']);

		//Pareil pour le titre
		$titre_t = add_SQL($_POST['titre']);

		//ici seulement, maintenant qu'on est sur qu'elle existe, on récupère la valeur de la variable f
		$forum = (int) $_GET['f'];
		$temps = time();
				
		$sql2 = mysql_query("SELECT forum_name
							 FROM forum_forum
							 WHERE forum_id = '".$forum."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req2 = mysql_fetch_assoc($sql2);
		
		/* Titre de la page */
		$titre = 'créer un nouveau topic';
		/********************/

		/* Titre de la page */
		$titre2 = 'Créer un nouveau topic';
		/******************************************************/

		/* Haut de la page, contient le doctype, charset, etc... */
		include('../includes/haut.php');
		/*********************************************************/
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?view=forum&amp;f='.$forum.'', 'Forum - '.$req2['forum_name'].'').' '.fil_ariane(2, 'forum/?poster=post&amp;action=topic&amp;f='.$forum.'', 'Créer un nouveau topic'); ?>
					</div>
					<br/>
					<h1><?php echo $titre2; ?></h1>
					<br/>
					<?php					
					$reponse1 = mysql_query("SELECT auth_annonce
											FROM forum_forum
											WHERE forum_id = '".$forum."'")
					or ErrorSQL(__FILE__,__LINE__);
					$data1 = mysql_fetch_assoc($reponse1);
					
					if(!verif_auth($data1['auth_annonce']) && isset($_POST['mess']))
					{
						quit();
					}
					if(empty($titre_t) || empty($message))
					{
						echo '<div id="erreur">Votre message ou votre titre est vide, cliquez <a href="'.ROOTPATH.'/forum/?poster=post&amp;action=topic&amp;f='.$forum.'">ici</a> pour recommencer</div>';
					}
					else
					{
						mysql_query("INSERT INTO forum_topic
						(forum_id, topic_titre, topic_createur, topic_vu, topic_time, topic_genre, topic_last_post, topic_post)
						VALUES('".$forum."', '".$titre_t."', '".intval($_SESSION['membre_id'])."', '1', '".$temps."','".$mess."', '0', '0'  )")
						or ErrorSQL(__FILE__,__LINE__);

						$nouveautopic = mysql_insert_id();

						//Puis on entre le message
						mysql_query("INSERT INTO forum_post
						(post_id, post_createur, post_texte, post_time, topic_id, post_forum_id)
						VALUES(',' ,'".intval($_SESSION['membre_id'])."', '".$message."', '".$temps."', '".$nouveautopic."', '".$forum."')")
						or ErrorSQL(__FILE__,__LINE__);

						$nouveaupost = mysql_insert_id();

						//Ici on update comme prévu la valeur de topic_last_post et de topic_first_post
						mysql_query("UPDATE forum_topic
						SET topic_last_post = '".$nouveaupost."',
						topic_first_post = '".$nouveaupost."'
						WHERE topic_id = '".$nouveautopic."'")
						or ErrorSQL(__FILE__,__LINE__);


						//Enfin on met à jour les tables forum_forum et forum_membres
						mysql_query("UPDATE forum_forum
						SET forum_post = forum_post + 1 ,
						forum_topic = forum_topic + 1,
						forum_last_post_id = '".$nouveaupost."'
						WHERE forum_id = '".$forum."'")
						or ErrorSQL(__FILE__,__LINE__);

						mysql_query("UPDATE site_membres
						SET nb_post = nb_post + 1
						WHERE id = '".intval($_SESSION['membre_id'])."'")
						or ErrorSQL(__FILE__,__LINE__);
						
						//On ajoute une ligne dans la table forum_topic_view
						mysql_query('INSERT INTO forum_topic_view 
						(tv_id, tv_topic_id, tv_forum_id, tv_post_id, tv_poste) 
						VALUES('.intval($_SESSION['membre_id']).', '.$nouveautopic.', '.$forum.', '.$nouveaupost.', "1")')
						or ErrorSQL(__FILE__,__LINE__);
						
						echo '<div id="information">Votre message a bien été ajouté!<br/>Cliquez <a href="'.ROOTPATH.'/forum/">ici</a> pour revenir à l\'index du forum<br/>Cliquez <a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$nouveautopic.'">ici</a> pour le voir.</div>';
					}
					?>
					</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
		break;
		
		case "repondremp": //Si on veut répondre
		
			//On passe le message et le titre dans une série de fonction
			$message_mp = add_SQL($_POST['textarea']);
			$titre_mp = add_SQL($_POST['titre']);
			$temps = time();

			//On récupère la valeur de l'id du destinataire
			$dest = (int) $_GET['dest'];
			$mp_id = (int) $_GET['mp_id'];
						
			$sql = mysql_query("SELECT pseudo 
								FROM site_membres
								WHERE id = '".$dest."'")
			or ErrorSQL(__FILE__,__LINE__);
			$req = mysql_fetch_assoc($sql);
			
			/* Titre de la page */
			$titre = 'Répondre à un message privé';
			/********************/
				
			/* Titre de la page */
			$titre2 = 'Répondre au MP de '.$req['pseudo'];
			/******************************************************/
			
			/* Haut de la page, contient le doctype, charset, etc... */
			include('../includes/haut.php');
			/*********************************************************/
			?>
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
					<?php
						//Enfin on peut envoyer le message
						if(!empty($message_mp) && !empty($titre_mp))
						{
							mysql_query("INSERT INTO site_mp
										(mp_id, mp_expediteur, mp_receveur, mp_titre, mp_text, mp_time, mp_lu)
										VALUES (',', '".intval($_SESSION['membre_id'])."' , '".$dest."', '".$titre_mp."',
										'".$message_mp."', '".$temps."', '0')")
							or ErrorSQL(__FILE__,__LINE__);
						?>
							<div id="fil_ariane">
							<?php 
								echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=mp', 'Boîte de messagerie').' 
									'.fil_ariane(2, '?page=mp&amp;action=repondre&amp;dest='.$dest.'&amp;mp_id='.$mp_id.'', 'Réussi : Répondre au MP de '.$req['pseudo'].''); 
							?>
							</div>
							<br/>
							<h1><?php echo $titre2; ?></h1>
							<br/>
						<?php
							echo '<div id="information">Votre message a bien été envoyé!
							<br/>Cliquez <a href="'.ROOTPATH.'">ici</a> pour revenir à l\'index du site
							<br/>Cliquez <a href="'.ROOTPATH.'/?page=mp">ici</a> pour retourner à la boite messagerie</div>';
						}
						else
						{
						?>
							<div id="fil_ariane">
							<?php
								echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=mp', 'Boîte de messagerie').' 
									'.fil_ariane(2, '?page=mp&amp;action=repondre&amp;dest='.$dest.'&amp;mp_id='.$mp_id.'', 'Erreur : Répondre au MP de '.$req['pseudo'].''); 
							?>
							</div>
							<br/>
							<h1><?php echo $titre2; ?></h1>
							<br/>
							<div id="erreur"><strong>Le titre ou le message du MP est vide, veuillez réessayer.</strong></div>
						<?php
						}
					?>
					</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre -->
			<?php
		break;
		
		case "nouveaump": //On envoie un nouveau mp

			/* Titre de la page */
			$titre = 'Nouveau message privé';
			/********************/
				
			/* Titre de la page */
			$titre2 = $titre;
			/******************************************************/
			
			/* Haut de la page, contient le doctype, charset, etc... */
			include('../includes/haut.php');
			/*********************************************************/
			?>
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
						<?php
						//On passe le message et le titre dans une série de fonction
						$message = add_SQL($_POST['textarea']);
						$titre = add_SQL($_POST['titre']);
						$temps = time();
						$dest = add_SQL($_POST['to']);

						//On récupère la valeur de l'id du destinataire
						if(empty($_POST['to']) || empty($_POST['titre']) || empty($_POST['textarea']))
						{
						?>
							<div id="fil_ariane">
							<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=mp', 'Boîte de messagerie').' '.fil_ariane(2, '?page=mp&amp;action=nouveau', 'Erreur : Nouveau message privé'); ?>
							</div>
							<br/>
							<h1><?php echo $titre2; ?></h1>
							<br/>
							<div id="erreur"><strong>Le destinataire ou votre titre ou votre message est vide, veuillez réessayer.</strong></div>
						<?php
						}
						else
						{
						//Il faut déja vérifier le nom

							$requete = mysql_query("SELECT id 
													FROM site_membres
													WHERE pseudo = '".$dest."'")
							or ErrorSQL(__FILE__,__LINE__);
							if($data = mysql_fetch_assoc($requete))
							{
							?>
								<div id="fil_ariane">
								<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=mp', 'Boîte de messagerie').' '.fil_ariane(2, '?page=mp&amp;action=nouveau', 'Réussie : Nouveau message privé'); ?>
								</div>
								<br/>
								<h1><?php echo $titre2; ?></h1>
								<br/>
							<?php
								//Enfin on peut envoyer le message
								mysql_query("INSERT INTO site_mp
											(mp_id, mp_expediteur, mp_receveur, mp_titre, mp_text, mp_time, mp_lu)
											VALUES (',', '".intval($_SESSION['membre_id'])."' , '".$data['id']."',
											'".$titre."', '".$message."', '".$temps."', '0')")
								or ErrorSQL(__FILE__,__LINE__);

								echo '<div id="information">Votre message a bien été envoyé!
								<br/>Cliquez <a href="'.ROOTPATH.'">ici</a> pour revenir à l\'index du site.
								<br/>Cliquez <a href="'.ROOTPATH.'/?page=mp">ici</a> pour retourner à la boite messagerie</div>';
							}
							//Sinon l'utilisateur n'existe pas !
							else
							{
							?>
								<div id="fil_ariane">
								<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=mp', 'Boîte de messagerie').' '.fil_ariane(2, '?page=mp&amp;action=nouveau', 'Erreur : Nouveau message privé'); ?>
								</div>
								<br/>
								<h1><?php echo $titre2; ?></h1>
								<br/>
								<div id="erreur"><strong>Désolé ce membre n'existe pas, veuillez vérifier et
								réessayez à nouveau.</strong></div>
							<?php
							}
						}
						?>
					</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre -->
			<?php
		break;
		
		case "edit":
		$post = (int) $_GET['p'];		 
		//On check le message
		$message = add_SQL($_POST['textarea']);
		$sql = mysql_query("SELECT post_createur
							FROM forum_post
							WHERE post_id = '".$post."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req = mysql_fetch_assoc($sql);
		
		$sql2 = mysql_query("SELECT pseudo
							 FROM site_membres
							 WHERE id = '".$req['post_createur']."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req2 = mysql_fetch_assoc($sql2);
		
		$sql3 = mysql_query("SELECT post_forum_id, topic_id
							 FROM forum_post
							 WHERE post_id = '".$post."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req3 = mysql_fetch_assoc($sql3);
		
		$sql4 = mysql_query("SELECT forum_name
							 FROM forum_forum
							 WHERE forum_id = '".$req3['post_forum_id']."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req4 = mysql_fetch_assoc($sql4);
		
		$sql6 = mysql_query("SELECT topic_titre
							 FROM forum_topic
							 WHERE topic_id = '".$req3['topic_id']."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req6 = mysql_fetch_assoc($sql6);
		
		/* Titre de la page */
		$titre = 'édition du message de '.$req2['pseudo'];
		/********************/
				
		/* Titre de la page */
		$titre2 = 'Édition du message de '.$req2['pseudo'];
		/******************************************************/
			
		/* Haut de la page, contient le doctype, charset, etc... */
		include('../includes/haut.php');
		/*********************************************************/
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?view=forum&amp;f='.$req3['post_forum_id'].'', 'Forum - '.$req4['forum_name'].'').' '.fil_ariane(1, 'forum/?view=topic&amp;t='.$req3['topic_id'].'', 'Topic - '.$req6['topic_titre'].'').' '.fil_ariane(2, 'forum/?poster=post&amp;p='.$post.'&amp;action=edit', 'Modifier le message n°'.$post.' de '.$req2['pseudo'].''); ?>
					</div>
					<br/>
					<h1><?php echo $titre2; ?></h1>
					<br/>
					<?php		
					//Ensuite on vérifie que le membre a le droit d'être ici (soit le créateur soit un modo/admin)
					$requete2 = mysql_query('SELECT post_createur, post_texte, post_time, topic_id, auth_modo
											 FROM forum_post
											 LEFT JOIN forum_forum ON forum_post.post_forum_id = forum_forum.forum_id
											 WHERE post_id='.$post.'')
					or ErrorSQL(__FILE__,__LINE__);
					$data2 = mysql_fetch_assoc($requete2);
					
					$topic = $data2['topic_id'];
						
					//On récupère la place du message dans le topic (pour le lien)
					$requete3 = mysql_query('SELECT COUNT(*) AS nbr 
											 FROM forum_post 
											 WHERE topic_id = '.$topic.' AND post_time < '.$data2['post_time'])
					or ErrorSQL(__FILE__,__LINE__);
					$data3 = mysql_fetch_assoc($requete3);
						
					if (!verif_auth($data2['auth_modo'])&& $data2['post_createur'] != $_SESSION['id'])
					{
						// Si cette condition n'est pas remplie ça va barder :o
						echo quit('<p>Vous n\'avez aucun droit d\'être ici</p>');
					}
					else
					{
						if(!empty($_POST['affich_edit']))
						{
							$affich_edit = ", post_edit_affich = '1'";
						}
						else
						{
							$affich_edit = ", post_edit_affich = '0'";
						}
						if(!empty($_POST['raison']))
						{
							$raison = ", post_edit_raison = '".add_SQL($_POST['raison'])."'";
						}
						else
						{
							$raison = ", post_edit_raison = ''";
						}
						mysql_query("UPDATE forum_post SET post_texte =  '".$message."' WHERE post_id = '".$post."'") or ErrorSQL(__FILE__,__LINE__);
						mysql_query("UPDATE forum_post SET post_edit = '1', post_edit_time = ".time().", post_edit_pseudo = '".$_SESSION['membre_id']."'".$affich_edit.$raison." WHERE post_id = '".$post."'") or ErrorSQL(__FILE__,__LINE__);
						$nombreDeMessagesParPage = 15;
						$nbr_post = $data3['nbr']+1;
						$page = ceil($nbr_post / $nombreDeMessagesParPage);
						echo '<div id="information">Votre message a bien été édité!<br />
						Cliquez <a href="'.ROOTPATH.'/forum/">ici</a> pour revenir à l\'index du forum<br/>
						Cliquez <a href="'.ROOTPATH.'/forum/?view=topic&amp;t='.$topic.'&amp;page='.$page.'#p_'.$post.'">ici</a> pour le voir</div>';
					}
					?>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php					
		break;
		case "delete":
			//On récupère la valeur de p
			$post = (int) $_GET['p'];
			$requete1 = mysql_query('SELECT post_createur, post_texte, forum_id, topic_id, auth_modo
									 FROM forum_post
									 LEFT JOIN forum_forum ON forum_post.post_forum_id = forum_forum.forum_id
									 WHERE post_id='.$post.'')
			or ErrorSQL(__FILE__,__LINE__);
			$data1 = mysql_fetch_assoc($requete1);
			
			$sql = mysql_query("SELECT pseudo
								FROM site_membres
								WHERE id = '".$data1['post_createur']."'")
			or ErrorSQL(__FILE__,__LINE__);
			$req = mysql_fetch_assoc($sql);
			
			$sql2 = mysql_query("SELECT post_forum_id, topic_id
								 FROM forum_post
								 WHERE post_id = '".$post."'")
			or ErrorSQL(__FILE__,__LINE__);
			$req2 = mysql_fetch_assoc($sql2);
			
			$sql3 = mysql_query("SELECT forum_name
								 FROM forum_forum
								 WHERE forum_id = '".$req2['post_forum_id']."'")
			or ErrorSQL(__FILE__,__LINE__);
			$req3 = mysql_fetch_assoc($sql3);
			
			$sql4 = mysql_query("SELECT topic_titre
								 FROM forum_topic
								 WHERE topic_id = '".$req2['topic_id']."'")
			or ErrorSQL(__FILE__,__LINE__);
			$req4 = mysql_fetch_assoc($sql4);
			
			$topic = $data1['topic_id'];
			$forum = $data1['forum_id'];
			
			/* Titre de la page */
			$titre = 'supprimer le message de '.$req['pseudo'];
			/********************/
				
			/* Titre de la page */
			$titre2 = 'Supprimer le message de '.$req['pseudo'];
			/******************************************************/
			
			/* Haut de la page, contient le doctype, charset, etc... */
			include('../includes/haut.php');
			/*********************************************************/
			?>
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
						<div id="fil_ariane">
							<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'forum/', 'Forum').' '.fil_ariane(1, 'forum/?view=forum&amp;f='.$req2['post_forum_id'].'', 'Forum - '.$req3['forum_name'].'').' '.fil_ariane(1, 'forum/?view=topic&amp;t='.$req2['topic_id'].'', 'Topic - '.$req4['topic_titre'].'').' '.fil_ariane(2, 'forum/?view=topic&amp;t='.$req2['topic_id'].'', 'Supprimer le message n°'.$post.' de '.$req['pseudo'].''); ?>
						</div>
						<br/>
						<h1><?php echo $titre2; ?></h1>
						<br/>
						<?php
						//Ensuite on vérifie que le membre a le droit d'être ici 
						//(soit le créateur soit un modo/admin)
						if(!verif_auth($data1['auth_modo']))
						{
							// Si cette condition n'est pas remplie ça va barder :o
							quit('<div id="erreur">Vous n\'avez aucun droit d\'être ici</div>');
						}
						else //Sinon ça roule et on continue
						{
							//Ici on vérifie plusieurs choses :
							//est-ce un premier post ? Dernier post ou post classique ?

							$requete_first_post = mysql_query("SELECT COUNT(*)
															   AS first_post
															   FROM forum_topic
															   WHERE topic_first_post = ".$post."")
							or ErrorSQL(__FILE__,__LINE__);
							 
							$requete_last_post = mysql_query("SELECT COUNT(*)
															  AS last_post
															  FROM forum_topic
															  WHERE topic_last_post = ".$post."")
							or ErrorSQL(__FILE__,__LINE__);
										   
							$first_post = mysql_fetch_assoc($requete_first_post);
							$last_post = mysql_fetch_assoc($requete_last_post);
							//On distingue maintenant les cas
							if($first_post['first_post'] != 0) 
							//Si le message est le premier
							{
								//Les autorisations ont changé !
								if(!verif_auth($data1['auth_modo']))
								{
									quit('<div id="erreur">Vous n\'avez aucun droit d\'être ici.</div>');
								}
								//Il faut s'assurer que ce n'est pas une erreur
								?>
								<div id="information">Vous avez choisi de supprimer un post. Cependant ce post est le premier du topic. Voulez vous supprimer le topic ?<br/>
								<a href="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=delete_topic&amp;t=<?php echo $topic; ?>">Oui</a> 
								- 
								<a href="<?php echo ROOTPATH; ?>/forum/?view=topic&amp?t=<?php echo $topic; ?>">non</a></div>
									<?php
							}
							elseif($last_post['last_post'] != 0)
							//Si le message est le dernier
							{
								//On supprime le post
								mysql_query("DELETE FROM forum_post
											 WHERE post_id = '".$post."'")
								or ErrorSQL(__FILE__,__LINE__);
											
								//On modifie la valeur de topic_last_post pour cela on
								//récupère l'id du plus récent  message de ce topic
								$requete4 = mysql_query('SELECT post_id
														 FROM forum_post
														 WHERE topic_id = '.$topic.'
														 ORDER BY post_id DESC
														 LIMIT 0,1')
								or ErrorSQL(__FILE__,__LINE__);
								$data4 = mysql_fetch_assoc($requete4);
											
								//On fait de même pour forum_last_post_id
								$requete5 = mysql_query('SELECT post_id
														 FROM forum_post
														 WHERE post_forum_id = '.$forum.'
														 ORDER BY post_id DESC
														 LIMIT 0,1')
								or ErrorSQL(__FILE__,__LINE__);
								$data5 = mysql_fetch_assoc($requete5);
												   
								//On met à jour la valeur de topic_last_post
								mysql_query("UPDATE forum_topic
											 SET topic_last_post = '".$data4['post_id']."'
											 WHERE topic_last_post = '".$post."'")
								or ErrorSQL(__FILE__,__LINE__);
							 
								//On enlève 1 au nombre de messages du forum et on met à       
								//jour forum_last_post
								mysql_query("UPDATE forum_forum
											 SET forum_post = forum_post - 1,
											 forum_last_post_id = '".$data5['post_id']."'
											 WHERE forum_id = '".$forum."'")
								or ErrorSQL(__FILE__,__LINE__);
							 
								//On enlève 1 au nombre de messages du topic
								mysql_query("UPDATE forum_topic
											 SET  topic_post = topic_post - 1
											 WHERE topic_id = '".$topic."'")
								or ErrorSQL(__FILE__,__LINE__);
								   
								//On enlève 1 au nombre de messages du membre
								mysql_query("UPDATE site_membres
											 SET  nb_post = nb_post - 1
											 WHERE id = '".$data1['post_createur']."'")
								or ErrorSQL(__FILE__,__LINE__);

								//Enfin le message
								?>
								<div id="information">Le message a bien été supprimé !<br/>
								Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?view=topic&amp;t=<?php echo $topic;?>">ici</a> pour retourner au topic<br/>
								Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum</div>
								<?php
							}
							elseif($last_post['last_post'] == 0 && $first_post['first_post'] == 0) // Si c'est un post classique
							{
								//On supprime le post
								mysql_query("DELETE FROM forum_post
											 WHERE post_id = '".$post."'")
											 or ErrorSQL(__FILE__,__LINE__);
												   
								//On enlève 1 au nombre de messages du forum
								mysql_query("UPDATE forum_forum
											 SET  forum_post = forum_post - 1
											 WHERE forum_id = '".$forum."'")
								or ErrorSQL(__FILE__,__LINE__);
												   
								//On enlève 1 au nombre de messages du topic
								mysql_query("UPDATE forum_topic
											 SET  topic_post = topic_post - 1
											 WHERE topic_id = '".$topic."'")
								or ErrorSQL(__FILE__,__LINE__);
												   
								//On enlève 1 au nombre de messages du membre
								mysql_query("UPDATE site_membres
											 SET  nb_post = nb_post - 1
											 WHERE id = '".$data1['post_createur']."'")
								or ErrorSQL(__FILE__,__LINE__);
												   
								//Enfin le message
								?>
								<div id="information">Le message a bien été supprimé !<br/>
								Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?view=topic&amp;t=<?php echo $topic;?>">ici</a> pour retourner au topic<br/>
								Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum</div>
								<?php
							}
						}
						?>
					</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
		break;
		
		case "delete_topic":
		
		$topic = (int) $_GET['t'];
		$requete1 = mysql_query('
		SELECT forum_topic.forum_id, auth_modo
		FROM forum_topic
		LEFT JOIN forum_forum ON forum_topic.forum_id = forum_forum.forum_id
		WHERE topic_id='.$topic.'')
		or ErrorSQL(__FILE__,__LINE__);
		$data1 = mysql_fetch_assoc($requete1);
		$forum = $data1['forum_id'];
		
		//Ensuite on vérifie que le membre a le droit d'être ici 
        //c'est-à-dire si c'est un modo / admin 
        if(!verif_auth($data1['auth_modo']))
        {
                // Si cette condition n'est pas remplie ça va barder :o
				quit('<div id="erreur">Vous n\'avez aucun droit d\'être ici.</div>');
        }
		else
		{
			//On compte le nombre de post du topic
			$requete_count_post = mysql_query("SELECT COUNT(*)
			AS nombre_post
			FROM forum_post
			WHERE topic_id = '".$topic."'")
			or ErrorSQL(__FILE__,__LINE__);
		   
			$data_nombrepost = mysql_fetch_assoc($requete_count_post);
			$nombrepost = $data_nombrepost['nombre_post'];
	 
			//On supprime le topic
			mysql_query("DELETE FROM forum_topic
			WHERE topic_id = '".$topic."'")
			or ErrorSQL(__FILE__,__LINE__);
		   
			//On enlève le nombre de post posté par chaque membre dans le topic
			$requete_postparmembre = mysql_query('SELECT post_createur,
			COUNT(*) AS nombre_mess
			FROM forum_post
			WHERE topic_id = '.$topic.'
			GROUP BY post_createur')
			or ErrorSQL(__FILE__,__LINE__);
			
			while($data_postparmembre = mysql_fetch_assoc($requete_postparmembre))
			{
				mysql_query('UPDATE site_membres
				SET nb_post = nb_post - '.$data_postparmembre['nombre_mess'].'
				WHERE id = '.$data_postparmembre['post_createur'])
				or ErrorSQL(__FILE__,__LINE__);
			}
			//Et on supprime les posts !
			mysql_query("DELETE FROM forum_post
			WHERE topic_id = '".$topic."'")
			or ErrorSQL(__FILE__,__LINE__);
		   
			//Dernière chose, on récupère le dernier post du forum
			$requete_forum = mysql_query('SELECT post_id
			FROM forum_post
			WHERE post_forum_id = '.$forum.'
			ORDER BY post_id DESC
			LIMIT 0,1')
			or ErrorSQL(__FILE__,__LINE__);
			$data_forum = mysql_fetch_assoc($requete_forum);
	 
			//Ensuite on modifie certaines valeurs :
			mysql_query("UPDATE forum_forum
			SET forum_topic = forum_topic - 1,
			forum_post = forum_post - '".$nombrepost."',
			forum_last_post_id = '".$data_forum['post_id']."'
			WHERE forum_id = '".$forum."'")
			or ErrorSQL(__FILE__,__LINE__);
			
			//Enfin le message
			include('../includes/haut.php');
			?>
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="information">Le topic a bien été supprimé !<br/>
					Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum</div>
				</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre -->
			<?php
		}

		break;
		
		case "lock": //Si on veut verrouiller le topic
		//On récupère la valeur de t
		$topic = (int) $_GET['t'];
		$requete1 = mysql_query('
		SELECT forum_topic.forum_id, auth_modo
		FROM forum_topic
		LEFT JOIN forum_forum ON forum_forum.forum_id = forum_topic.forum_id
		WHERE topic_id = '.$topic)
		or ErrorSQL(__FILE__,__LINE__);
		$data1 = mysql_fetch_assoc($requete1);
		//Ensuite on vérifie que le membre a le droit d'être ici
		if(!verif_auth($data1['auth_modo']))
		{
			// Si cette condition n'est pas remplie ça va barder :o
			quit('<div id="erreur">Vous n\'avez aucun droit d\'être ici.</div>');
		}
		else //Sinon ça roule et on continue
		{
			//On met à jour la valeur de topic_locked
			mysql_query("UPDATE forum_topic
			SET topic_locked = '1'
			WHERE topic_id = '".$topic."'")
			or ErrorSQL(__FILE__,__LINE__);
			
			?>
			<div id="information">
				<p>Le topic a bien été verrouillé !<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?view=topic&amp;t=<?php echo $topic; ?>">ici</a> pour retourner au topic.<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.</p>
			</div>
			<?php
		}
		break;
		 
		case "unlock": //Si on veut déverrouiller le topic
		//On récupère la valeur de t
		$topic = (int) $_GET['t'];
		$requete1 = mysql_query('
		SELECT forum_topic.forum_id, auth_modo
		FROM forum_topic
		LEFT JOIN forum_forum ON forum_forum.forum_id = forum_topic.forum_id
		WHERE topic_id = '.$topic.'')
		or ErrorSQL(__FILE__,__LINE__);
		$data1 = mysql_fetch_assoc($requete1);
		 
		//Ensuite on vérifie que le membre a le droit d'être ici
		if(!verif_auth($data1['auth_modo']))
		{
			// Si cette condition n'est pas remplie ça va barder :o
			quit('<div id="erreur">Vous n\'avez aucun droit d\'être ici</div>');
		}
		else //Sinon ça roule et on continue
		{
			//On met à jour la valeur de topic_locked
			mysql_query("UPDATE forum_topic
			SET topic_locked = '0'
			WHERE topic_id = '".$topic."'")
			or ErrorSQL(__FILE__,__LINE__);
			 
			?>
			<div id="information">
				<p>Le topic a bien été déverrouillé !<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?view=topic&amp;t=<?php echo $topic; ?>">ici</a> pour retourner au topic.<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.</p>
			</div>
			<?php
		}
		break;
		
		case "lock_forum":
		$forum = (int) $_GET['f'];
		$requete1 = mysql_query('
		SELECT forum_id, auth_modo
		FROM forum_forum
		WHERE forum_id = '.$forum)
		or ErrorSQL(__FILE__,__LINE__);
		$data1 = mysql_fetch_assoc($requete1);
		// On vérifie si le membre à le droit d'être ici
		if(!verif_auth($data1['auth_modo']))
		{
			// Si cette condition n'est pas remplie ça va barder :o
			quit('<div id="erreur">Vous n\'avez aucun droit d\'être ici.</div>');
		}
		else // Sinon ça roule
		{
			// On vérouille le forum !
			mysql_query("UPDATE forum_forum
			SET forum_locked = '1' 
			WHERE forum_id = '".$forum."'")
			or ErrorSQL(__FILE__,__LINE__);
			
			// Ensuite on mets à jours les topics qui sont dans le forum qu'on vérouille
			mysql_query("UPDATE forum_topic
			SET topic_locked = '1'
			WHERE forum_id = '".$forum."'")
			or ErrorSQL(__FILE__,__LINE__);
			
			?>
			<div id="information">
				<p>Le forum et tous les topic contenus dans le forum ont bien été vérrouillé !<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?view=forum&amp;f=<?php echo $forum; ?>">ici</a> pour retourner au forum.<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.</p>
			</div>
			<?php
		}
		
		break;
		
		case "unlock_forum":
		$forum = (int) $_GET['f'];
		$requete1 = mysql_query('
		SELECT forum_id, auth_modo
		FROM forum_forum
		WHERE forum_id = '.$forum)
		or ErrorSQL(__FILE__,__LINE__);
		$data1 = mysql_fetch_assoc($requete1);
		// On vérifie si le membre à le droit d'être ici
		if(!verif_auth($data1['auth_modo']))
		{
			// Si cette condition n'est pas remplie ça va barder :o
			quit('<div id="erreur">Vous n\'avez aucun droit d\'être ici.</div>');
		}
		else // Sinon ça roule
		{
			// On vérouille le forum !
			mysql_query("UPDATE forum_forum
			SET forum_locked = '0' 
			WHERE forum_id = '".$forum."'")
			or ErrorSQL(__FILE__,__LINE__);
			
			// Ensuite on mets à jours les topics qui sont dans le forum qu'on vérouille
			mysql_query("UPDATE forum_topic
			SET topic_locked = '0'
			WHERE forum_id = '".$forum."'")
			or ErrorSQL(__FILE__,__LINE__);
			
			?>
			<div id="information">
				<p>Le forum et tous les topic contenus dans le forum ont bien été dévérrouillé !<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?view=forum&amp;f=<?php echo $forum; ?>">ici</a> pour retourner au forum.<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.</p>
			</div>
			<?php
		}
		
		break;
		
		case "deplacer":
		$topic = (int) $_GET['t'];
		$requete1 = mysql_query('
		SELECT forum_topic.forum_id, auth_modo
		FROM forum_topic
		LEFT JOIN forum_forum 
			ON forum_forum.forum_id = forum_topic.forum_id
		WHERE topic_id = '.$topic.'')
		or ErrorSQL(__FILE__,__LINE__);
		$data1 = mysql_fetch_assoc($requete1);
        if (!verif_auth($data1['auth_modo']))
        {
                // Si cette condition n'est pas remplie ça va barder :o
                quit('<p>Vous n\'avez aucun droit d\'être ici.</div>');
        }
        else //Sinon ça roule et on continue
        {
			$destination = (int) $_POST['dest'];
			$origine = (int ) $_POST['from'];
               
			//On déplace le topic
			mysql_query("UPDATE forum_topic
			SET forum_id = '".$destination."'
			WHERE topic_id = '".$topic."'")
			or ErrorSQL(__FILE__,__LINE__);
			
			//On déplace les posts
			mysql_query("UPDATE forum_post
			SET post_forum_id = '".$destination."'
			WHERE topic_id = '".$topic."'")
			or ErrorSQL(__FILE__,__LINE__);
               
			//On s'occupe d'ajouter / enlever les nombres de post / topic aux
			//forum d'origine et de destination
			//Pour cela on compte le nombre de post déplacé
               
			$post_number_requete = mysql_query("SELECT COUNT(*)
			AS nombre_post
			FROM forum_post
			WHERE topic_id = '".$topic."'")
			or ErrorSQL(__FILE__,__LINE__);
 
			$data_post_number = mysql_fetch_assoc($post_number_requete);
			$nombrepost = $data_post_number['nombre_post'];
			
			//Il faut également vérifier qu'on a pas déplacé un post qui été
			//l'ancien premier post du forum (champ forum_last_post_id)
			
			$requete1 = mysql_query('SELECT post_id
			FROM forum_post
			WHERE post_forum_id = '.$origine.'
			ORDER BY post_id DESC
			LIMIT 0,1')
			or ErrorSQL(__FILE__,__LINE__);
 
			$data1 = mysql_fetch_assoc($requete1);
			
			//Puis on met à jour le forum d'origine
			mysql_query("UPDATE forum_forum
			SET forum_post = forum_post - '".$nombrepost."',
			forum_topic = forum_topic - 1,
			forum_last_post_id = '".$data1['post_id']."'
			WHERE forum_id = '".$origine."'")
			or ErrorSQL(__FILE__,__LINE__);
 
			//Avant de mettre à jour le forum de destination il faut
			//vérifier la valeur de forum_last_post_id
			$requete2 = mysql_query('SELECT post_id
			FROM forum_post WHERE post_forum_id = '.$destination.'
			ORDER BY post_id DESC
			LIMIT 0,1')
			or ErrorSQL(__FILE__,__LINE__);
 
			$data2 = mysql_fetch_assoc($requete2);
			
			//Et on met à jour enfin !
			mysql_query("UPDATE forum_forum
			SET forum_post = forum_post + '".$nombrepost."',
			forum_topic = forum_topic + 1,
			forum_last_post_id = '".$data2['post_id']."'
			WHERE forum_id = '".$destination."'")
			or ErrorSQL(__FILE__,__LINE__);
 
			//C'est gagné ! On affiche le message
			?>
			<div id="information">
				Le topic a bien été déplacé.<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/?view=topic&amp;t=<?php echo $topic;?>">ici</a> pour revenir au topic.<br/>
				Cliquez <a href="<?php echo ROOTPATH; ?>/forum/">ici</a> pour revenir à l'index du forum.
			</div>
			<?php
        }
		
		break;
		default;
			echo '<div id="erreur">Cette action est impossible</div>';
	}
?>