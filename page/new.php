<?php
/*
page/new.php

Les news du site
*/
if(isset($_GET['news'])) // Lecture d'une news
{
	$id = intval($_GET['news']);
	/* Titre de la page */
	$titre = 'News n°'.$id.'';
	/********************/

	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'News n°'.$id.'';
	/******************************************************/	
	
	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php'); 
	/*********************************************************/
	$sql2 = mysql_query("SELECT news_titre
						 FROM site_news
						 WHERE news_id = '".$id."'")
	or ErrorSQL(__FILE__,__LINE__);
	$req2 = mysql_fetch_assoc($sql2);
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=new', 'Liste des news').' '.fil_ariane(2, '?page=new&amp;news='.$id.'', 'News : '.stripslashes($req2['news_titre']).'');
				?>
				</div>
				<?php	
				$sql = mysql_query("SELECT * 
									FROM site_news 
									WHERE news_id = '".$id."'") 
				or ErrorSQL(__FILE__,__LINE__);
				if($sql)
				{
					if(mysql_num_rows($sql) > 0)
					{
						$req = mysql_fetch_array($sql);
						$sql2 = mysql_query("SELECT COUNT(*) AS nbr 
											 FROM site_commentaire_news 
											 WHERE commentaire_news_id = '".$id."'")
											 or ErrorSQL(__FILE__,__LINE__);
						$req2 = mysql_fetch_array($sql2);
						if($req2['nbr'] == 0)
						{
							$lien = '';
							$lien2 = '';
						}
						else
						{
							$lien = '<a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=view">';
							$lien2 = '</a>';
						}
						echo '<h2 class="titre_news">'.stripslashes($req['news_titre']).'</h2> 
							  <span class="news_info">'.mepd($req['news_date']).'</span>
								<div class="solo">
									'.parseZCode($req['news_texte']).'
								</div>
								<p><span class="news_info">Par '.$req['news_auteur'].' </span></p> <span class="category"><span class="news_info">Dans : <a href="'.ROOTPATH.'/?page=new&amp;category='.$req['news_category_id'].'">'.$req['news_category'].'</a></span></span>
								'.$lien.'Voir les commentaires ('.$req2['nbr'].')'.$lien2.' - <a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=add">Ajouter un commentaire</a>
							 ';
					}
					else
					{
						echo '<h1>News introuvable</h1><br/>';
						echo '<p>Vous avez rentrez une nouveauté fausse.</p>';
					}
				}
				?>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre --> 
	<?php
}
elseif(isset($_GET['category'])) // Listage des news par categorie
{
	$category_id = intval($_GET['category']);
	$verif = mysql_query("SELECT * 
						  FROM site_news 
						  WHERE news_category_id = '".$category_id."'") 
						  or ErrorSQL(__FILE__,__LINE__);
	$sql_tittle_category = mysql_query("SELECT category_tittle
									   FROM site_category_news
									   WHERE category_id = '".$category_id."'")
									   or ErrorSQL(__FILE__,__LINE__);
	$req_tittle_category = mysql_fetch_assoc($sql_tittle_category);
	$category = $req_tittle_category['category_tittle'];
	if(mysql_num_rows($verif) > 0) // Catégorie comportant au moins une news
	{
		$category = htmlspecialchars($category);
		/* Titre de la page */
		$titre = 'Catégorie : '.$category;
		/********************/

		/* Définition du TITRE du CADRE du contenu de la page */
		$titre2 = 'Catégorie : '.$category;
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
						echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=new', 'Liste des news').' '.fil_ariane(2, '?page=new&amp;category='.$category_id.'', 'Catégorie : '.$category.'');
					?>
					</div>
					<?php
					echo '<h1>Liste des news</h1>';
					$nb_news_page = 5; // Essayez de changer ce nombre pour voir :o)
					// On récupère le nombre total de messages
					$retour = mysql_query("SELECT COUNT(*) AS nb_messages 
										   FROM site_news 
										   WHERE news_category = '".$category."'") 
										   or ErrorSQL(__FILE__,__LINE__);
					$donnees = mysql_fetch_array($retour);
					$toto_news = $donnees['nb_messages'];
					// On calcule le nombre de pages à créer
					$nb_page  = ceil($toto_news / $nb_news_page);
					// Puis on fait une boucle pour écrire les liens vers chacune des pages
					echo '<span class="p">';
					if (isset($_GET['p']))
					{
						$page = intval($_GET['p']); 
					}
					else 
					{
						$page = 1; 
					}
					if(isset($_GET['p']) && $_GET['p'] != 1)
					{
						$i = $_GET['p'] - 1;
						echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=new&amp;category='.$category_id.'&amp;p='.$i.'">Précédente</a></span> ';
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
							echo '<span class="p_lien"><a href="'.ROOTPATH.'/?page=new&amp;category='.$category_id.'&amp;p='.$i.'"> '.$i.'</a></span> |';
						}
					}
					if($nb_page != 1)
					{
						if(!isset($_GET['p']))
						{
							$i = +2;
							echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=new&amp;category='.$category_id.'&amp;p='.$i.'">Suivante</a></span>';
						}
						elseif(isset($_GET['p']) && $_GET['p'] != $nb_page)
						{
							$i = $_GET['p'] + 1;
							echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=new&amp;category='.$category_id.'&amp;p='.$i.'">Suivante</a></span>';
						}
					}
					echo '</span>';
					?>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre --> 
		<?php
		$first_mess_afficher = ($page - 1) * $nb_news_page;
		$sql = mysql_query("SELECT * 
							FROM site_news 
							WHERE news_category = '".$category."' 
							ORDER BY news_id 
							DESC LIMIT ".$first_mess_afficher.",".$nb_news_page)
							or ErrorSQL(__FILE__,__LINE__);
		if($sql)
		{
			while($req = mysql_fetch_array($sql))
			{
				$sql2 = mysql_query("SELECT COUNT(*) AS nbr 
									 FROM site_commentaire_news 
									 WHERE commentaire_news_id = '".$req['news_id']."'") 
									 or ErrorSQL(__FILE__,__LINE__);
				$req2 = mysql_fetch_array($sql2);
				if($req2['nbr'] == 0)
				{
					$lien = '';
					$lien2 = '';
				}
				else
				{
					$lien = '<a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=view">';
					$lien2 = '</a>';
				}
				?>
				<div class="content"><!-- Début centre -->	 
					<div class="nh"></div> <!-- News -->
						<div class="nf">
							<?php
							echo '<h2 class="titre_news"><a href="'.ROOTPATH.'/?page=new&amp;news='.$req['news_id'].'">'.stripslashes($req['news_titre']).'</a></h2>';
							?>
							<span class="news_info"><?php echo mepd($req['news_date']); ?></span>
							<div class="news_texte solo">
								<?php echo parseZCode($req['news_texte']); ?>
							</div>
							<span class="news_info">Par <?php echo $req['news_auteur']; ?></span> 
							<?php 
							echo '<span class="news_info">Dans : 
								  <a href="'.ROOTPATH.'/?page=new&amp;category='.$req['news_category'].'">'.$req['news_category'].'</a>
								  </span>
							'.$lien.'Voir les commentaires ('.$req2['nbr'].')'.$lien2.' - 
							<a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=add">Ajouter un commentaire</a>';
							?>
						</div>
					<div class="nb"></div> <!-- Fin news -->
				</div><!-- Fin centre -->
				<?php
			}
		}
	}
	else // Catégorie inexistante ou vide
	{
		$category = htmlspecialchars($category);
		/* Titre de la page */
		$titre = 'Catégorie : '.$category;
		/********************/

		/* Définition du TITRE du CADRE du contenu de la page */
		$titre2 = 'Catégorie : '.$category;
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
							echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=new', 'Liste des news').' '.fil_ariane(2, '?page=new', 'Catégorie introuvable');
						?>
						</div>
						<br />
						<?php
						echo '<h1>Catégorie introuvable et/ou catégorie vide</h1><br/>
							  <p>Cette catégorie n\'existe pas et/ou ne contient pas de news.</p>';
						?>
					</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre --> 
		<?php
	}
}
else // Listage des news
{
	/* Titre de la page */
	$titre = 'Liste des news';
	/********************/

	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Liste des news';
	/******************************************************/	
	
	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php'); 
	/*********************************************************/
	if(isset($_GET['q'])) // Recherche réalisé
	{
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=new', 'Liste des news').' '.fil_ariane(2, '?page=new&amp;q='.$_GET['q'].'', 'Résultats de la recherche'); ?>
				</div>
				<?php
				if(empty($_GET['q']))
				{
					echo '<br/><div id="erreur"><strong>La variable q est vide.</strong></div>';
					echo '<br/><div id="p">Veuillez réessayer.</div>';
					?>
					<form method="get" action ="<?php echo ROOTPATH; ?>/">
						<table class="search">
							<tr>
								<td><input type="hidden" name="page" value="new" /></td>
								<td><input type="text" name="q" id="q" /></td>
								<td><input type="submit" value="Rechercher" /></td>
							</tr>
						</table>
					</form>
					<?php
				}
				else
				{
					$q = $_GET['q'];
					$q = str_replace('-', ' ', $q);
					$s = explode(' ', $q);
					$recherche = "SELECT * FROM site_news";
					$i = 0;
					foreach($s as $mot)
					{
						if(strlen($mot) > 3)
						{
							if($i == 0)
							{
								$recherche .= " WHERE ";
							}
							else
							{
								$recherche .= " OR ";
							}
							$recherche .= "news_texte LIKE '%$mot%'";
							$i++;
						}
					}
					$recherche .= " ORDER BY news_id DESC";
					$sql = mysql_query($recherche) or ErrorSQL(__FILE__,__LINE__);
					if($sql)
					{
						if(mysql_num_rows($sql) != 0)
						{
							if(mysql_num_rows($sql) == 1)
							{
								$s = '';
							}
							else
							{
								$s = 's';
							}
							echo '<div id="information">La recherche s\'est bien déroulée,<br/>nous avons trouvé'.$s.' '.mysql_num_rows($sql).' résultat'.$s.'.</div>';
							while($req = mysql_fetch_array($sql))
							{				
								$sql2 = mysql_query("SELECT COUNT(*) AS nbr FROM site_commentaire_news WHERE commentaire_news_id = '".$req['news_id']."'") or ErrorSQL(__FILE__,__LINE__);
								$req2 = mysql_fetch_array($sql2);
								if($req2['nbr'] == 0)
								{
									$lien = '';
									$lien2 = '';
								}
								else
								{
									$lien = '<a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=view">';
									$lien2 = '</a>';
								}
								echo '<div class="titre"><a href="'.ROOTPATH.'/?page=new&amp;news='.$req['news_id'].'">'.stripslashes($req['news_titre']).'</a></div> <span class="news_info">'.mepd($req['news_date']).'</span>
									<div class="news_texte solo">
										'.parseZCode($req['news_texte']).'
									</div>
									Par<span class="news_info"> '.$req['news_auteur'].'</span> <span class="category">Dans : <span class="news_info"><a href="'.ROOTPATH.'/?page=new&amp;category='.$req['news_category'].'">'.$req['news_category'].'</a></span></span>';
								echo $lien.'Voir les commentaires ('.$req2['nbr'].')'.$lien2.' - <a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=add">Ajouter un commentaire</a>';
							}
						}
						else
						{
							echo '<br/><div id="erreur"><strong>Nous avons trouvé 0 résultat.</strong></div>';
						}
					}
				}
				?>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
	}
	else // Recherche non réalisé 
	{
	?>
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
						<div id="fil_ariane">
							<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?page=new', 'Liste des news'); ?>
						</div>
							<form method="get" action ="<?php echo ROOTPATH; ?>/">
								<table class="search">
									<tr>
										<td><input type="hidden" name="page" value="new" /></td>
										<td><input type="text" name="q" id="q" /></td>
										<td><input type="submit" value="Rechercher" /></td>
									</tr>
								</table>
							</form>
							<br/><br/>
							<?php
							echo '<h1>Liste des catégories</h1>';
							$sql2 = mysql_query("SELECT COUNT(*) AS nb_category FROM site_category_news") or ErrorSQL(__FILE__,__LINE__);
							$req2 = mysql_fetch_array($sql2);
							echo 'Il y a '.$req2['nb_category'].' catégories :<br/><br/>';
							$sql3 = mysql_query("SELECT * FROM site_category_news") or ErrorSQL(__FILE__,__LINE__);
							while($req3 = mysql_fetch_array($sql3))
							{
								if($req3['category_nb_news'] == 0)
								{
									$req3['category_nb_news'] = 'Il n\'y a pas de news pour cette catégorie.';
								}
								elseif($req3['category_nb_news'] == 1)
								{
									$req3['category_nb_news'] = '1 new.';
								}
								elseif($req3['category_nb_news'] > 1)
								{
									$req3['category_nb_news'] = $req3['category_nb_news'].' news.';
								}
								echo '<a href="'.ROOTPATH.'/?page=new&amp;category='.$req3['category_id'].'">'.$req3['category_tittle'].'</a> : '.$req3['category_nb_news'].'<br/>';
							}
							?>
					</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre -->
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
						<?php
						echo '<h1>Liste des news</h1>';
						$nb_news_page = 5;
						$retour = mysql_query('SELECT COUNT(*) AS nb_messages FROM site_news') 
												or ErrorSQL(__FILE__,__LINE__);
						$donnees = mysql_fetch_array($retour);
						$toto_news = $donnees['nb_messages'];
						$nb_page  = ceil($toto_news / $nb_news_page);
						echo '<span class="p">';
						if (isset($_GET['p']))
						{
							$page = intval($_GET['p']); 
						}
						else 
						{
							$page = 1; 
						}
						if(isset($_GET['p']) && $_GET['p'] != 1)
						{
							$i = $_GET['p'] - 1;
							echo ' Page :  <span class="p_lien"><a href="'.ROOTPATH.'/?page=new&amp;p='.$i.'">Précédente</a></span> |';
						}
						else
						{
							echo ' Page : |';
						}
						for ($i = 1 ; $i <= $nb_page ; $i++)
						{
							if($i == $page)
							{
								echo ' <span class="page_a"> '.$i.'</span> |';
							}
							else
							{
								echo '<span class="p_lien"><a href="'.ROOTPATH.'/?page=new&amp;p='.$i.'"> '.$i.'</a></span> |';
							}
						}
						if($nb_page != 1)
						{
							if(!isset($_GET['p']))
							{
								$i = +2;
								echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=new&amp;p='.$i.'">Suivante</a></span>';
							}
							elseif(isset($_GET['p']) && $_GET['p'] != $nb_page)
							{
								$i = $_GET['p'] + 1;
								echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=new&amp;p='.$i.'">Suivante</a></span>';
							}
						}
						echo '</span>';
						?>
					</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre -->
		<?php
		$first_mess_afficher = ($page - 1) * $nb_news_page;
		$sql = mysql_query("SELECT * 
							FROM site_news 
							ORDER BY news_id 
							DESC LIMIT ".$first_mess_afficher.", ".$nb_news_page) 
							or ErrorSQL(__FILE__,__LINE__);
		if($sql)
		{
			while($req = mysql_fetch_array($sql))
			{
				$sql2 = mysql_query("SELECT COUNT(*) AS nbr 
									 FROM site_commentaire_news 
									 WHERE commentaire_news_id = '".$req['news_id']."'") 
									 or ErrorSQL(__FILE__,__LINE__);
				$req2 = mysql_fetch_array($sql2);
				if($req2['nbr'] == 0)
				{
					$lien = '';
					$lien2 = '';
				}
				else
				{
					$lien = '<a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=view">';
					$lien2 = '</a>';
				}
				?>
				<div class="content"><!-- Début centre -->	 
					<div class="nh"></div> <!-- News -->
						<div class="nf">
							<?php
								echo '<h2 class="titre_news"><a href="'.ROOTPATH.'/?page=new&amp;news='.$req['news_id'].'">'.stripslashes($req['news_titre']).'</a></h2> 
								<span class="news_info">'.mepd($req['news_date']).'</span>';
							?>
							<div class="news_texte solo">
								<?php echo parseZCode($req['news_texte']); ?>
							</div>
							<?php
								echo '<span class="news_info">Par '.$req['news_auteur'].'</span> <span class="news_info">Dans : <a href="'.ROOTPATH.'/?page=new&amp;category='.$req['news_category'].'">'.$req['news_category'].'</a></span>';
								echo $lien.'Voir les commentaires ('.$req2['nbr'].')'.$lien2.' - <a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=add">Ajouter un commentaire</a>';
							?>
						</div>
					<div class="nb"></div> <!-- Fin news -->
				</div><!-- Fin centre -->
				<?php
			}
		}
	}
}
?>