<?php
/*
page/mp.php

Système de message privé
*/
$balises = true;
if(!isset($_SESSION['membre_id']))
{
	$info_commande = array('true', 'acces_not_connect');
	require_once('information.php');
	exit();
}
?>
<?php
if(isset($_GET['action']))
{
	$action = isset($_GET['action'])?htmlspecialchars($_GET['action']):''; //On récupère la valeur de la variable $action
	 
	switch($action)
	{
		case "consulter": //1er cas : on veut lire un mp
		//Ici on a besoin de la valeur de l'id du mp que l'on veut lire
		$id_mess = (int) $_GET['id']; //On récupère la valeur de l'id
		
		/* Titre de la page */
		$titre = 'Lecture d\'un message privé';
		/********************/
		
		/* Titre de la page */
		$titre2 = $titre;
		/********************/
		
		include('includes/haut.php');
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Acueil').' '.fil_ariane(1, '?page=mp', 'Boîte de messagerie').' '.fil_ariane(2, '?page=mp&amp;action=consulter&amp;id='.$id_mess.'', 'Lecture d\'un MP'); ?>
					</div>
					<br/>
					<h1><?php echo $titre2; ?></h1>
					<br/>
					<?php
						//La requête nous permet d'obtenir les infos sur ce message :
						$requete  = mysql_query("SELECT mp_expediteur, mp_receveur, mp_titre,               
												 mp_time, mp_text, mp_lu, mp_id, id, pseudo, avatar,
												 localisation, inscription, nb_post, signature
												 FROM site_mp
												 LEFT JOIN site_membres ON id = mp_expediteur
												 WHERE mp_id = '".$id_mess."'")
						or ErrorSQL(__FILE__,__LINE__);
						$data = mysql_fetch_assoc($requete);

						// Attention ! Seul le receveur du mp peut le lire !
						if($_SESSION['membre_id'] != $data['mp_receveur'])
						{
							quit('Vous n\'avez pas le droit d\'être ici.');
						}
							   
						//bouton de réponse
						?>
						<a href="<?php echo ROOTPATH; ?>/?page=mp&amp;action=repondre&amp;dest=<?php echo $data['mp_expediteur']; ?>&amp;mp_id=<?php echo $data['mp_id']; ?>">
							<img src="<?php echo ROOTPATH; ?>/forum/design/repondre.png" alt="Répondre"	title="Répondre à ce message" />
						</a>
						<table class="liste_membre">     
							<tr>
								<th class="vt_auteur liste_membre"><strong>Auteur</strong></th>             
								<th class="vt_mess liste_membre"><strong>Message</strong></th>       
							</tr>
							<tr>
								<td class="liste_membre">
									<strong>
										<a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data['id']; ?>">
											<?php echo stripslashes(htmlspecialchars($data['pseudo'])); ?>
										</a>
									</strong>
								</td>
							   <td class="liste_membre">Posté <?php echo mepd($data['mp_time']); ?></td>
							</tr>
							<tr>
								<td class="liste_membre">
									<img src="<?php echo $data['avatar']; ?>" alt="Avatar de <?php echo $data['pseudo']; ?>" />
									<br/>
									<br/>Membre inscrit <?php echo mepd($data['inscription']); ?>
									<br/>Messages : <?php $data['nb_post']; ?>
									<br/>Localisation : <?php echo stripslashes(htmlspecialchars($data['localisation'])); ?></p>
								</td>
								<td class="liste_membre">
									<?php 
										echo parseZCode($data['mp_text']);
									?>
									<div id="vt_mess_sign">
									<?php
										if(!empty($data['signature']))
										{
											echo '<hr/>'.parseZCode($data['signature']); 
										}
									?>
									</div>
								</td>
							</tr>
						</table>
						<?php
						if($data['mp_lu'] == 0) //Si le message n'a jamais été lu
						{
							mysql_query("UPDATE site_mp 
										 SET mp_lu = '1' 
										 WHERE mp_id= ".$id_mess."")
							or ErrorSQL(__FILE__,__LINE__);
						}
						?>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
		break;
		 
		case "nouveau": //2eme cas : on veut poster un nouveau mp
		//Ici on a besoin de la valeur d'aucune variable
		/* Titre de la page */
		$titre = 'Nouveau message privé';
		/********************/
		
		/* Titre de la page */
		$titre2 = $titre;
		/********************/
		
		include('includes/haut.php');
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Acueil').' '.fil_ariane(1, '?page=mp', 'Boîte de messagerie').' '.fil_ariane(2, '?page=mp&amp;action=nouveau', 'Envoie d\'un MP'); ?>
					</div>
					<br/>
					<h1><?php echo $titre2; ?></h1>
					<br/>
					<form method="post" action="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=nouveaump" name="formulaire">
						<table style="margin:auto;">
							<tr>
								<td align="center">
									<label for="to">Envoyer à :</label>
									<input type="text" name="to" id="to" value="
									<?php
									if(isset($_GET['id']))
									{
										$sql5 = mysql_query("SELECT pseudo 
															 FROM site_membres 
															 WHERE id = '".$_GET['id']."'")
										or ErrorSQL(__FILE__,__LINE__);
										$req5 = mysql_fetch_assoc($sql5);
										echo $req5['pseudo'];
									}
									?>
									" />
								</td>
							</tr>
							<tr>
								<td align="center">
									<label for="titre">Titre :</label>
									<input type="text" name="titre" id="titre" />
								</td>
							</tr>
							<tr>
								<td align="center" colspan="2">
									<?php include('includes/haut_bbcode.php'); ?>
									<label for="textarea">Votre message :</label><br/>
									<textarea name="textarea" id="textarea" cols="70" rows="15" ><?php if(!empty($_POST['textarea'])) { echo $_POST['textarea']; } ?></textarea>
									<?php include('includes/bas_bbcode.php'); ?>
								</td>
							</tr>
							<tr>
								<td align="center">
									<input type="submit" name="envoyer" id="envoyer" value="Envoyer" /> <input type="reset" id="effacer" name="effacer" value="Effacer" onclick="return confirm('Ête vous sûr de vouloir effacer le message que vous venez d\'écrire ?');" />
								</td>
							</tr>
						</table>
					</form>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
		break;
		 
		case "repondre": //3eme cas : on veut répondre à un mp reçu
		//Ici on a besoin de la valeur de l'id du membre qui nous a posté un mp
		$dest = (int) $_GET['dest'];
		$mp_id = intval($_GET['mp_id']);
		$mp_titre_req = mysql_query("SELECT mp_titre, mp_receveur
								 FROM site_mp
								 WHERE mp_id = '".$mp_id."'")
		or ErrorSQL(__FILE__,__LINE__);
		$mp_titre = mysql_fetch_assoc($mp_titre_req);
		$sql = mysql_query("SELECT pseudo
							FROM site_membres
							WHERE id = ".$dest)
		or ErrorSQL(__FILE__,__LINE__);
		$req = mysql_fetch_assoc($sql);
		
		/* Titre de la page */
		$titre = 'Répondre à un message privé';
		/********************/
		
		/* Titre de la page */
		$titre2 = 'Répondre au message privé de '.$req['pseudo'];
		/********************/
		
		include('includes/haut.php');
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Acueil').' '.fil_ariane(1, '/?page=mp', 'Boîte de messagerie').' '.fil_ariane(2, '?page=mp&amp;action=repondre&amp;dest='.$dest.'&amp;mp_id='.$mp_id.'', 'Répondre au MP de '.$req['pseudo'].''); ?>
					</div>
					
					<br/>
					<h1><?php echo $titre2; ?></h1>
					<br/>
					
					<form method="post" action="<?php echo ROOTPATH; ?>/forum/?poster=postk&amp;action=repondremp&amp;dest=<?php echo $dest; ?>&amp;mp_id=<?php echo $mp_id; ?>" name="formulaire">
						<table style="margin:auto;">
							<tr>
								<td align="center">
									<label for="titre">Titre :</label>
									<input type="text" name="titre" id="titre" value="
									<?php 
									if($_SESSION['membre_id'] == $mp_titre['mp_receveur'])
									{
										echo 'Re : '.$mp_titre['mp_titre'];
									}										
									?>" />
								</td>
							</tr>
							<tr>
							</tr>
							<tr>
								<td align="center" colspan="2">
									<?php include('includes/haut_bbcode.php'); ?>
									<label for="textarea">Votre message :</label><br/>
									<textarea name="textarea" id="textarea" cols="70" rows="15" ><?php if(!empty($_POST['textarea'])) { echo $_POST['textarea']; } ?></textarea>
									<?php include('includes/bas_bbcode.php'); ?>
								</td>
							</tr>
							<tr>
								<td align="center">
									<input type="submit" name="envoyer" id="envoyer" value="Envoyer" /> <input type="reset" id="effacer" name="effacer" value="Effacer" onclick="return confirm('Ête vous sûr de vouloir effacer le message que vous venez d\'écrire ?');" />
								</td>
							</tr>
						</table>
					</form>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php

		break;
		 
		case "supprimer": //4eme cas : on veut supprimer un mp reçu
		//Ici on a besoin de la valeur de l'id du mp à supprimer
		
		//On récupère la valeur de l'id
		$id_mess = (int) $_GET['id'];
		
		/* Titre de la page */
		$titre = 'Suppresion d\'un MP';
		/********************/
		
		/* Titre de la page */
		$titre2 = 'Suppresion du MP n°'.$id_mess;
		/********************/
		
		include('includes/haut.php');
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Acueil').' '.fil_ariane(1, '?page=mp', 'Boîte de messagerie').' '.fil_ariane(2, '?page=mp&amp;action=supprimer&amp;id='.$id_mess.'&amp;sur=0', 'Suppression d\'un MP'); ?>
					</div>
					<br/>
					<h1><?php echo $titre2; ?></h1>
					<br/>
					<?php
					//Il faut vérifier que le membre est bien celui qui a reçu le message
					$requete = mysql_query("SELECT mp_receveur
											FROM site_mp 
											WHERE mp_id = '".$id_mess."'")
					or ErrorSQL(__FILE__,__LINE__);
					$data = mysql_fetch_assoc($requete);
					//Sinon la sanction est terrible :p
					if($_SESSION['membre_id'] != $data['mp_receveur'])
					{
						quit('Vous n\'avez pas le droit d\'être ici.');
					}
				   
					//2 cas pour cette partie : on est sûr de supprimer ou alors on ne l'est pas
					$sur = (int) $_GET['sur'];
					//Pas encore certain
					if($sur == 0)
					{
						echo '<p>Etes-vous certain de vouloir supprimer ce message ?<br />
						<a href="'.ROOTPATH.'/?page=mp&amp;action=supprimer&amp;id='.$id_mess.'&amp;sur=1">
						Oui</a> - <a href="'.ROOTPATH.'/?page=mp">Non</a></p>';
					}
					//Certain
					else
					{
						mysql_query("DELETE FROM site_mp WHERE mp_id = '".$id_mess."'")
						or ErrorSQL(__FILE__,__LINE__);
						echo '<div id="information">Le message a bien été supprimé.<br />
							Cliquez <a href="'.ROOTPATH.'/?page=mp">ici</a> pour revenir à la boite de messagerie.</div>';
					}
					?>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
		break;
		 
		default; //Si rien n'est demandé ou s'il y a une erreur dans l'url, on affiche la boite de mp.
		
		/* Titre de la page */
		$titre = 'Boîte de messagerie';
		/********************/
		
		/* Titre de la page */
		$titre2 = $titre;
		/********************/
		
		include('includes/haut.php');
			
		$requete = mysql_query('SELECT mp_lu, mp_id, mp_expediteur, mp_titre, mp_time, id, pseudo
								FROM site_mp
								LEFT JOIN site_membres 
								ON site_mp.mp_expediteur = site_membres.id
								WHERE mp_receveur = '.intval($_SESSION['membre_id']).' 
								ORDER BY mp_id DESC')
		or ErrorSQL(__FILE__,__LINE__);
		?>	
		
		<div id="fil_ariane">
			<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '', 'Boîte de messagerie'); ?>
		</div>
		<br/>
		<h1><?php echo $titre2; ?></h1>
		<br/>
			<a href="<?php echo ROOTPATH; ?>/?page=mp&amp;action=nouveau">
				<img src="<?php echo ROOTPATH; ?>/forum/design/nouveau.png" alt="Nouveau" title="Nouveau message" />
			</a>
		<?php
			if(mysql_num_rows($requete) > 0)
			{
			?>
			<table class="liste_membre">
				<tr>
					<th class="mp_statut liste_membre"></th>
					<th class="mp_titre liste_membre"><strong>Titre</strong></th>
					<th class="mp_expediteur liste_membre"><strong>Expéditeur</strong></th>
					<th class="mp_time liste_membre"><strong>Date</strong></th>
					<th class="mp_action liste_membre"><strong>Action</strong></th>
				</tr>

		<?php
				//On boucle et on remplit le tableau
				while ($data = mysql_fetch_assoc($requete))
				{
				?>
				<tr>
				<?php
				//Mp jamais lu, on affiche l'icone en question
				if($data['mp_lu'] == 0)
				{
					?>
					<td class="liste_membre"><img src="<?php echo ROOTPATH; ?>/forum/design/news.png" alt="Non lu" /></td>
					<?php
				}
				else //sinon une autre icone
				{
					?>
					<td class="liste_membre"><img src="<?php echo ROOTPATH; ?>/forum/design/no_news.png" alt="Déja lu" /></td>
					<?php
				}
					?>
					<td class="mp_titre liste_membre">
						<a href="<?php echo ROOTPATH; ?>/?page=mp&amp;action=consulter&amp;id=<?php echo $data['mp_id']; ?>">
							<?php echo stripslashes(htmlspecialchars($data['mp_titre'])); ?>
						</a>
					</td>
					<td class="mp_expediteur liste_membre">
						<a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data['membre_id']; ?>">
							<?php echo stripslashes(htmlspecialchars($data['membre_pseudo'])); ?>
						</a>
					</td>
					<td class="mp_time liste_membre">
						<?php echo mepd($data['mp_time']); ?>
					</td>
					<td class="liste_membre">
						<a href="<?php echo ROOTPATH; ?>/?page=mp&amp;action=supprimer&amp;id=<?php echo $data['mp_id']; ?>&amp;sur=0">supprimer</a>
					</td>
				</tr>
					<?php
				}
				?>
			</table>
			<?php
			} //Fin de la boucle
			else
			{
				?>
				<p align="center">
					Vous n'avez aucun message privé pour l'instant, cliquez <a href="<?php echo ROOTPATH; ?>">ici</a> pour revenir à l'accueil
				</p>
				<?php
			}
	} //fin du switch
}
else
{
	/* Titre de la page */
	$titre = 'Boîte de messagerie';
	/********************/
		
	/* Titre de la page */
	$titre2 = $titre;
	/********************/

	include('includes/haut.php');
	$requete = mysql_query('SELECT mp_lu, mp_id, mp_expediteur, mp_titre, mp_time, id, pseudo
							FROM site_mp
							LEFT JOIN site_membres 
							ON site_mp.mp_expediteur = site_membres.id
							WHERE mp_receveur = '.intval($_SESSION['membre_id']).' 
							ORDER BY mp_id DESC')
	or ErrorSQL(__FILE__,__LINE__);
	?>
	
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?page=mp', 'Boîte de messagerie'); ?>
				</div>
				<br/>
				<h1><?php echo $titre2; ?></h1>
				<br/>
				<a href="<?php echo ROOTPATH; ?>/?page=mp&amp;action=nouveau">
					<img src="<?php echo ROOTPATH; ?>/forum/design/nouveau.png" alt="Nouveau" title="Nouveau message" />
				</a>
				<?php
				if(mysql_num_rows($requete) > 0)
				{
				?>
					<table class="liste_membre">
						<tr>
							<th class="mp_statut liste_membre"></th>
							<th class="mp_titre liste_membre"><strong>Titre</strong></th>
							<th class="mp_expediteur liste_membre"><strong>Expéditeur</strong></th>
							<th class="mp_time liste_membre"><strong>Date</strong></th>
							<th class="mp_action liste_membre"><strong>Action</strong></th>
						</tr>

				<?php
					//On boucle et on remplit le tableau
					while ($data = mysql_fetch_assoc($requete))
					{
					?>
						<tr>
					<?php
					//Mp jamais lu, on affiche l'icone en question
					if($data['mp_lu'] == 0)
					{
						?>
							<td class="liste_membre"><img src="<?php echo ROOTPATH; ?>/forum/design/news.png" alt="Non lu" /></td>
						<?php
					}
					else //sinon une autre icone
					{
						?>
							<td class="liste_membre"><img src="<?php echo ROOTPATH; ?>/forum/design/no_news.png" alt="Déja lu" /></td>
						<?php
					}
						?>
							<td class="mp_titre liste_membre">
								<a href="<?php echo ROOTPATH; ?>/?page=mp&amp;action=consulter&amp;id=<?php echo $data['mp_id']; ?>">
									<?php echo stripslashes(htmlspecialchars($data['mp_titre'])); ?>
								</a>
							</td>
							<td class="mp_expediteur liste_membre">
								<a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data['id']; ?>">
									<?php echo stripslashes(htmlspecialchars($data['pseudo'])); ?>
								</a>
							</td>
							<td class="mp_time liste_membre">
								<?php echo mepd($data['mp_time']); ?>
							</td>
							<td class="liste_membre">
								<a href="<?php echo ROOTPATH; ?>/?page=mp&amp;action=supprimer&amp;id=<?php echo $data['mp_id']; ?>&amp;sur=0">Supprimer</a>
							</td>
						</tr>
						<?php
					}
						?>
					</table>
					<?php
				} //Fin de la boucle
				else
				{
				?>
					<p align="center">
						Vous n'avez aucun message privé pour l'instant, cliquez <a href="<?php echo ROOTPATH; ?>">ici</a> pour revenir à l'accueil.
					</p>
				<?php
				}
				?>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
}
?>