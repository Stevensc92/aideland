<?php
/*
page/comment.php

Lire / ajouter des / un commentaire(s).
*/
if(isset($_GET['a']) && $_GET['a'] == 'supprimer' && isset($_GET['mess']) && isset($_GET['new']))
{
	$id = intval($_GET['mess']);
	$id_news = intval($_GET['new']);
	$sql = mysql_query("SELECT commentaire_auteur
						FROM site_commentaire_news
						WHERE commentaire_id = '".$id."'")
	or ErrorSQL(__FILE__,__LINE__);
	$req = mysql_fetch_assoc($sql);
	
	$sql2 = mysql_query("SELECT news_titre
						 FROM site_news
						 WHERE news_id = '".$id_news."'")
	or ErrorSQL(__FILE__,__LINE__);
	$req2 = mysql_fetch_assoc($sql2);
	
	/* Titre de la page */
	$titre = 'Commentaires de la news n°'.$id.' (suppression)';
	/********************/

	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = $titre;
	/******************************************************/

	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php');
	/*********************************************************/
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=new', 'Liste des news').' '.fil_ariane(1, '?page=new&amp;news='.$id_news.'', 'News : '.$req2['news_titre'].'').' '.fil_ariane(1, '?page=comment&amp;new='.$id_news.'&amp;a=view', 'Lecture des commentaire').' '.fil_ariane(2, '?page=comment&amp;new='.$id_news.'&amp;a=view', 'Suppression d\'un commentaire'); ?>
				</div>
				<br/>
				<h1><?php echo $titre2; ?></h1>
				<br/>
				<?php
				$delete = mysql_query("DELETE FROM site_commentaire_news
									   WHERE commentaire_id = '".$id."'") 
				or ErrorSQL(__FILE__,__LINE__);
				if($delete)
				{
					echo '<div id="information">Le commentaire de '.$req['commentaire_auteur'].' de la news "'.$req2['news_titre'].'" a bien été supprimer.</div>';
				}
				else
				{
					echo '<div id="erreur">Le commentaire de '.$req['commentaire_auteur'].' de la news "'.$req2['news_titre'].'" n\'a pas été supprimer.</div>';
				}
				?>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
}
elseif(isset($_GET['new']) && isset($_GET['a']) && $_GET['a'] == 'view')
{
	$id = isset($_GET['new'])?intval($_GET['new']):'';
	$nb_comment_sql = mysql_query("SELECT COUNT(*) AS nb_comment 
							FROM site_commentaire_news 
							WHERE commentaire_news_id = '".$id."'") 
	or ErrorSQL(__FILE__,__LINE__);
	$donnees = mysql_fetch_array($nb_comment_sql);
	$nb_comment = $donnees['nb_comment'];
	if($nb_comment > 1)
	{
		$s = 's';
	}
	else
	{
		$s = '';
	}
	/* Titre de la page */
	$titre = 'Commentaire'.$s.' de la news n°'.$id.'';
	/********************/

	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = $titre;
	/******************************************************/

	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php');
	/*********************************************************/
	$sql = mysql_query("SELECT * 
						FROM site_news 
						WHERE news_id = '".$id."'") 
	or ErrorSQL(__FILE__,__LINE__);
	$req = mysql_fetch_array($sql);
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=new', 'Liste des news').' '.fil_ariane(1, '?page=new&amp;news='.$id.'', 'News : '.$req['news_titre'].'').' '.fil_ariane(2, '?page=comment&amp;new='.$id.'&amp;a=view', 'Lecture des commentaires');
				?>
				</div>
				<br/>
				<h1><?php echo $titre2; ?></h1>
				<br/>
				<?php
				
				echo '<fieldset>';
					echo '<legend>New n°'.$id.'</legend>';
					echo '<h2 class="titre_news">'.stripslashes($req['news_titre']).'</h2>';
					echo '<span class="news_info">'.mepd($req['news_date']).'</span><br/>';
					echo '<div class="solo">';
						echo parseZCode($req['news_texte']);
					echo '</div>';
					echo '<p><span class="news_info">Par '.$req['news_auteur'].' </span></p> <span class="news_info">Dans : <a href="'.ROOTPATH.'/?page=new&amp;category='.$req['news_category'].'">'.$req['news_category'].'</a></span>';
					echo '<a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=add">Ajouter un commentaire</a>';
				echo '</fieldset><br/>';
				$nb_comment_page = 20;
				$retour = mysql_query("SELECT COUNT(*) AS nb_comment 
									   FROM site_commentaire_news 
									   WHERE commentaire_news_id = '".$_GET['new']."'") 
				or ErrorSQL(__FILE__,__LINE__);
				$donnees = mysql_fetch_array($retour);
				$toto_comment = $donnees['nb_comment'];
				$nb_page = ceil($toto_comment / $nb_comment_page);
				$_GET['p'] = isset($_GET['p']) ? $_GET['p'] : 1;
				if (isset($_GET['p']))
				{
					$page = intval($_GET['p']); 
				}
				else 
				{
					$page = 1; 
				}
				if($nb_page != 0)
				{
					echo '<span class="p">';
					if(isset($_GET['p']) && $_GET['p'] != 1)
					{
						$i = $_GET['p'] - 1;
						echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=comment&amp;new='.$id.'&amp;a=view&amp;p='.$i.'">Précédente</a></span> ';
					}
					echo ' Page : |';
					for ($i = 1 ; $i <= $nb_page ; $i++)
					{
						if($i == $page)
						{
							echo ' <span class="page_a"> '.$i.'</span> |';
						}
						else
						{
							echo '<span class="p_lien"><a href="'.ROOTPATH.'/?page=comment&amp;new='.$id.'&amp;a=view&amp;p='.$i.'"> '.$i.'</a></span> |';
						}
					}
					if($nb_page != 1)
					{
						if(!isset($_GET['p']))
						{
							$i = +2;
							echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=comment&amp;new='.$id.'&amp;a=view&amp;p='.$i.'">Suivante</a></span>';
						}
						elseif(isset($_GET['p']) && $_GET['p'] != $nb_page)
						{
							$i = $_GET['p'] + 1;
							echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=comment&amp;new='.$id.'&amp;a=view&amp;p='.$i.'">Suivante</a></span>';
						}
					}
					echo '</span>';
				}
				$first_comment = ($page - 1) * $nb_comment_page;
				echo '<fieldset><br/>';
					echo '<legend>Commentaire de la new n°'.$id.'</legend>';
				$sql2 = mysql_query("SELECT * 
									 FROM site_commentaire_news 
									 WHERE commentaire_news_id = '".$id."' 
									 ORDER BY commentaire_id DESC LIMIT ".$first_comment.", ".$nb_comment_page."") 
				or ErrorSQL(__FILE__,__LINE__);
				if(mysql_num_rows($sql2) < 1)
				{
					echo 'Pas de commentaire pour cette new.';
				}
				else
				{
					while($req2 = mysql_fetch_array($sql2))
					{
						$sql3 = mysql_query("SELECT id
											FROM site_membres
											WHERE pseudo = '".$req2['commentaire_auteur']."'")
						or ErrorSQL(__FILE__,__LINE__);
						$req3 = mysql_fetch_assoc($sql3);
						if(isset($_SESSION['membre_pseudo']))
						{
							$reponse = mysql_query("SELECT rang, pseudo 
													FROM site_membres 
													WHERE id = ".$_SESSION['membre_id']."") 
							or ErrorSQL(__FILE__,__LINE__);
							$donnees = mysql_fetch_assoc($reponse);
						}
						if(isset($donnees['rang']) && $donnees['rang'] >= 90)
						{
							$supprimer = '(<a href="'.ROOTPATH.'/?page=comment&amp;a=supprimer&amp;mess='.$req2['commentaire_id'].'&amp;new='.$id.'" onclick="return confirm(\'Ête vous sûr de vouloir supprimer le commentaire de '.$req2['commentaire_auteur'].' ? \')">Supprimer</a>)';
							$update = '(<a href="#" onclick="ChangeAttrUp(commentMess, '.$req2['commentaire_id'].')" >Modifier</a>)';
						}
						else
						{
							$supprimer = '';
							$update = '';
						}
						echo '<fieldset>';
							echo '<legend>Commentaire de <a href="'.ROOTPATH.'/?page=membre&amp;id='.$req3['id'].'">'.stripslashes($req2['commentaire_auteur']).'</a> : <span class="news_inf">'.mepd($req2['commentaire_time']).'</span> '.$supprimer.' '.$update.'</legend>';
							echo '<div class="comment_mess">'.parseZCode($req2['commentaire_message']).'</div>';
						echo '</fieldset><br/>';
					}
				}
				echo '</fieldset>';
				?>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
}
elseif(isset($_GET['a']) && isset($_GET['new']) && $_GET['a'] == 'add')
{
	/* Titre de la page */
	$titre = 'Ajouter un commentaire';
	/********************/
	
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Ajouter un commentaire';
	/******************************************************/

	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php');
	/*********************************************************/
	if(isset($_SESSION['membre_id']))
	{
		$id = intval($_GET['new']);
		$sql = mysql_query("SELECT news_titre
							FROM site_news
							WHERE news_id = '".$id."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req = mysql_fetch_assoc($sql);
		
		if(isset($_POST['comment']))
		{
			if(isset($_POST['captcha'])) $_POST['captcha'] = strtoupper($_POST['captcha']);
			if(empty($_POST['texte']))
			{
				$erreur = 'Vous n\'avez pas entrez de message.';
			}
			elseif(empty($_POST['captcha']))
			{
				$erreur = "Vous n'avez pas recopier le code.";
			}
			elseif($_POST['captcha'] != $_SESSION['aleat_nbr'])
			{
				$erreur = "Le code recopier, ne correspond pas à l'image, veuillez recommencer.";
			}
			else
			{
				$texte = mysql_real_escape_string($_POST['texte']);
				$add = mysql_query("INSERT INTO site_commentaire_news VALUES('', '".$id."', '".$_SESSION['membre_pseudo']."', '".$texte."', ".time().")") or ErrorSQL(__FILE__,__LINE__);
				if($add)
				{
					$add_c = '<div id="information">Le commentaire a bien été ajouté à la new n°'.$id.'.</div>';
				}
				else
				{
					$add_c = '<div id="erreur">Le commentaire n\'a pas été ajouté.</div>';
				}
			}
		}
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
					<?php
						echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=new', 'Liste des news').' '.fil_ariane(1, '?page=new&amp;news='.$id.'', 'News : '.$req['news_titre'].'').' '.fil_ariane(2, '?page=comment&amp;new='.$id.'&amp;a=add', 'Ajouter un commentaire');
					?>
					</div>
					<br/>
					<h1>Ajouter un commentaire sur la new n°<?php echo $id; ?></h1>
					<br/>
					<?php
					if(isset($erreur))
					{
						echo '<span class="erreur">'.$erreur.'</span>';
					}
					if(isset($add_c))
					{
						echo $add_c;
					}
					?>
					<br/>
					<form method="post">
						<table style="margin:auto;">
							<tr>
								<td align="center"><input type="hidden" name="time" id="time" value="<?php echo time(); ?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="textarea">Votre message :</label></td>
							</tr>
							<tr>
								<td align="center">
									<?php include('includes/haut_bbcode.php'); ?>
									<textarea name="texte" id="textarea" cols="70" rows="10" ><?php if(!empty($_POST['texte'])) {echo $_POST['texte'];}?></textarea>
									<?php include('includes/bas_bbcode.php'); ?>
								</td>
							</tr>
							<tr>
								<td align="center"><label for="captcha">Recopier le code :</label></td>
							</tr>
							<tr>
								<td align="center">
									<input type="text" name="captcha" id="captcha"><img src="page/captcha.php" alt="Captcha anti-bot" />
									<span id="refreshCaptcha">
										<form method="post" action="#">
											<input type="submit" value=" " id="refresh" title="Rafraîchir" />
										</form>
									</span>
								</td>
							</tr>
							<tr>
								<td align="center"><input type="submit" name="comment" id="comment" value="Envoyer" /></td>
							</tr>
						</table>
					</form>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
	<?php
	}
	else
	{
		$id = intval($_GET['new']);
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
					<?php
						echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=new', 'Liste des news').' '.fil_ariane(2, '?page=comment&amp;new='.$id.'&amp;a=add', 'Ajouter un commentaire');
					?>
					</div>
					<br/>
					<h1><?php echo $titre2; ?> sur la news n°<?php echo $id; ?></h1>
					<br/>
					<?php
					echo '<div id="erreur">Vous devez être connecter pour pouvoir poster un commentaire.</div>';
					?>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
	<?php
	}
}
else
{
	/* Titre de la page */
	$titre = 'Erreur';
	/********************/
	
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = $titre;
	/******************************************************/

	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php');
	/*********************************************************/
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=new', 'Liste des news').' '.fil_ariane(2, '?page=new', 'Erreur'); ?>
				</div>
				<br/>
				<h1><?php echo $titre2; ?></h1>
				<br/>
				<?php
				echo '<div id="erreur">Argument d\'action non-renseigné ou eronné.</div>';
				?>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
}
?>