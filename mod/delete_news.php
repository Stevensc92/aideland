<?php
/*
mod/delete_news.php

Suppression de news
*/
if(isset($_SESSION['membre_id']))
{
	$id = $_SESSION['membre_id'];
    $sql = mysql_query("SELECT pseudo, rang 
						FROM site_membres 
						WHERE id= '".$id."'") 
	or ErrorSQL(__FILE__,__LINE__);
	
	if($sql)
	{
		$data = mysql_fetch_assoc($sql);
		if($data['rang'] >= 90)
		{
			if(isset($_GET['supprimer']))
			{
				/* Titre de la page */
				$titre = 'Supprimer une news';
				/********************/

				/* Définition du TITRE du CADRE du contenu de la page */
				$titre2 = 'Supprimer une news';
				/******************************************************/

				/* Haut de la page, contient le doctype, charset, etc... */
				include('includes/haut.php');
				/*********************************************************/
				$id = intval($_GET['supprimer']);
				?>
				<div class="content"><!-- Début centre -->	 
					<div class="nh"></div> <!-- News -->
						<div class="nf">
							<div id="fil_ariane">
							<?php
								echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?mod=delete_news', 'Modération des news').' '.fil_ariane(2, '', 'Supprimer une news');
							?>
							</div>
							<?php
							echo '<h1>Supprimer la news n°'.$id.'</h1>';
							echo '<a href="'.ROOTPATH.'/?mod=delete_news"><span class="news_info">Retour ...</span></a><br/>';
							$id = intval($_GET['supprimer']);
							$sql = mysql_query("SELECT * 
												FROM site_news 
												WHERE news_id = '".$id."'") 
												or ErrorSQL(__FILE__,__LINE__);
							$req = mysql_fetch_array($sql);
							$sql2 = mysql_query("UPDATE site_category_news 
												SET category_nb_news = category_nb_news-1 
												WHERE category_tittle = '".$req['news_category']."'") 
												or ErrorSQL(__FILE__,__LINE__);
							if($sql2)
							{
								echo '<div id="information">La catégorie "'.$req['news_category'].'" a bien été décrémenter.</div>';
								$sql3 = mysql_query("DELETE FROM site_news WHERE news_id = '".$id."'") or ErrorSQL(__FILE__,__LINE__);
								if($sql3)
								{
									echo '<div id="information">La news n°'.$id.' a bien été supprimer.</div>';
								}
								else
								{
									echo '<div id="erreur">La news n°'.$id.' n\'a pas été supprimer.</div>';
								}
							}
							else
							{
								echo '<div id="erreur">La catégorie "'.$req['news_category'].'" n\'a pas été décrémenter.</div>';
							}
							?>
						</div>
					<div class="nb"></div> <!-- Fin news -->
				</div><!-- Fin centre -->
			<?php
			}
			elseif(isset($_GET['modifier']))
			{
				/* Titre de la page */
				$titre = 'Modifier une news';
				/********************/

				/* Définition du TITRE du CADRE du contenu de la page */
				$titre2 = 'Modifier une news';
				/******************************************************/

				/* Haut de la page, contient le doctype, charset, etc... */
				include('includes/haut.php');
				/*********************************************************/
				if(isset($_POST['modif_news']))
				{
					$id = intval($_GET['modifier']);
					$titre = add_SQL($_POST['titre']);
					$texte = add_SQL($_POST['texte']);
					$update = mysql_query("UPDATE site_news
											SET news_titre = '".$titre."', news_texte = '".$texte."' 
											WHERE  news_id = '".$id."'") 
											or ErrorSQL(__FILE__,__LINE__);
					if($update)
					{
						$up = '<div id="information">La news a bien été modifier.</div>';
					}
					else
					{
						$up = '<div id="erreur">La news n\'a pas été modifier.</div>';
					}
				}
				$id = intval($_GET['modifier']);
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
								echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?mod=delete_news', 'Modération des news').' '.fil_ariane(2, '?mod=delete_news', 'Modifier une news');
							?>
							</div>
							<br/>
							<?php
								echo '<h1>Modifier la news n°'.$id.'</h1>';	
							?>
							<br/>
							<?php
							if(isset($up))
							{
								echo $up;
							}
							?>
							<br/><br/>
							<form method="post">
								<table style="margin:auto;">
									<tr>
										<td align="center"><label for="titre"><span class="donnees">Titre :</span></label></td>
									</tr>
									<tr>
										<td align="center"><input type="texte" name="titre" id="titre" value="<?php echo stripslashes($req['news_titre']); ?>" /></td>
									</tr>
									<tr>
										<td align="center"><label for="texte"><span class="donnees">Texte :</span></label></td>
									</tr>
									<tr>
										<td align="center">
											<?php include('includes/haut_bbcode.php'); ?>
											<textarea name="texte" id="textarea" cols="70" rows="10" ><?php echo stripslashes($req['news_texte']); ?></textarea>
											<?php include('includes/bas_bbcode.php'); ?>
										</td>
									</tr>
									<tr>
										<td align="center"><input type="submit" name="modif_news" value="Modifier la news" /></td>
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
				/* Titre de la page */
				$titre = 'Modération de news';
				/********************/

				/* Définition du TITRE du CADRE du contenu de la page */
				$titre2 = 'Modération de news';
				/******************************************************/

				/* Haut de la page, contient le doctype, charset, etc... */
				include('includes/haut.php');
				/*********************************************************/
				?>
				<div class="content"><!-- Début centre -->	 
					<div class="nh"></div> <!-- News -->
						<div class="nf">
							<div id="fil_ariane">
							<?php
								echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?mod=delete_news', 'Modération des news');
							?>
							</div>
							<?php
							echo '<h1>Liste des news</h1>';
							$sql = mysql_query("SELECT * 
												FROM site_news 
												ORDER BY news_id 
												DESC") 
												or ErrorSQL(__FILE__,__LINE__);
							echo '<table class="liste_membre">';
							echo '<tr>';
								echo '<th class="liste_membre">N°</th>';
								echo '<th class="liste_membre">Titre</th>';
								echo '<th class="liste_membre">Texte</th>';
								echo '<th class="liste_membre">Catégorie</th>';
								echo '<th class="liste_membre">Supprimer</th>';
								echo '<th class="liste_membre">Modifier</th>';
							echo '</tr>';
							$i = 0;
							while($req = mysql_fetch_array($sql))
							{
								echo '<tr class="ligne_'.($i%2).'">';
									echo '<td class="liste_membre" width="150">'.$req['news_id'].'</td>';
									echo '<td class="liste_membre" width="150">'.stripslashes($req['news_titre']).'</td>';
									echo '<td class="liste_membre" width="150">'.substr(parseZCode($req['news_texte']), 0, 100).' <a href="'.ROOTPATH.'/?page=new&amp;news='.$req['news_id'].'"><em>(Lire la suite)</em></a></td>';
									echo '<td class="liste_membre" width="150"><a href="'.ROOTPATH.'/?page=new&amp;category='.$req['news_category_id'].'">'.$req['news_category'].'</a></td>';
									echo '<td class="liste_membre" width="150"><a href="'.ROOTPATH.'/?mod=delete_news&amp;supprimer='.$req['news_id'].'" onclick="return confirm(\'Ête vous sûr de vouloir supprimer la news n°'.$req['news_id'].'?\')">Supprimer</a></td>';
									echo '<td class="liste_membre" width="150"><a href="'.ROOTPATH.'/?mod=delete_news&amp;modifier='.$req['news_id'].'">Modifier</a></td>';
								echo '</tr>';
								$i++;
							}
							echo '</table>';
							?>
						</div>
					<div class="nb"></div> <!-- Fin news -->
				</div><!-- Fin centre -->
			<?php
			}
		}
		else
		{
			$informations = array( /*Accès non autorisé */
							true,
							'Accès refusé',
							'Vous ne pouvez accèder à cette page.',
							'',
							ROOTPATH,
							5,
							'Accès refusé'
							);
			require_once('information.php');
			exit();
		}
	}
	else
	{
		$informations = array( /*Accès non autorisé */
                        true,
                        'Erreur',
                        'Une erreur s\'est produite.',
                        ' - <a href="'.ROOTPATH.'">Index</a>',
                        ROOTPATH,
                        5,
                        'Erreur'
                        );
        require_once('information.php');
        exit();
	}
}
else
{
	$informations = array( /*Accès non autorisé */
                    true,
                    'Accès refusé',
                    'Vous devez être connecter pour pouvoir accèder à cette page.',
                    ' - <a href="'.ROOTPATH.'/?page=connexion">Se connecter</a>',
                    ROOTPATH.'/?page=connexion',
                    5,
                    'Accès refusé'
                    );
    require_once('information.php');
    exit();
}
?>