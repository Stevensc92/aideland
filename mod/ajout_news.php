<?php
/*
mod/ajout_news.php

Ajoutation de news
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
            /* Titre de la page */
            $titre = 'Ajouter une news';
            /********************/

            /* Définition du TITRE du CADRE du contenu de la page */
            $titre2 = $titre;
            /******************************************************/

            /* Haut de la page, contient le doctype, charset, etc... */
            include('includes/haut.php');
            /*********************************************************/
            if(isset($_POST['add_news']))
            {
                if(empty($_POST['titre']))
                {
                    $erreur = 'Vous n\'avez pas préciser de titre pour la news.';
                }
                elseif(empty($_POST['texte']))
                {
                    $erreur = 'Vous n\'avez pas préciser de texte pour la news.';
                }
                else
                {
                    $_POST['titre'] = add_SQL($_POST['titre']);
					$category = array('1' => 'Catégorie par défaut', '2' => 'Nouveauté','3' => 'Mise à Jour', '4' => 'Astuce', '5' => 'Tutoriel', '6' => 'Bannis');
					$_POST['category'] = add_SQL($_POST['category']);
                    $_POST['texte'] = add_SQL($_POST['texte']);
                    $_POST['texte'] = nl2br($_POST['texte']);
                    $add = mysql_query("INSERT INTO site_news 
										VALUES('', '".$_SESSION['membre_pseudo']."', '".$_POST['titre']."', '".$_POST['texte']."', ".time().", '".$_POST['category']."', '".$category[$_POST['category']]."')") 
					or ErrorSQL(__FILE__,__LINE__);
                    $add2 = mysql_query("UPDATE site_category_news 
										SET category_nb_news = category_nb_news +1 
										WHERE category_id = '".$_POST['category']."'") 
					or ErrorSQL(__FILE__,__LINE__);
					if($add)
                    {
                        $add_n = '<div id="information">La news a bien été ajouté.</div>';
						if($add2)
						{
							$up = '<div id="information">La catégorie "'.$category[$_POST['category']].'" a bien été incrémenter.</div>';
						}
						else
						{
							$up = '<div id="erreur">La catégorie "'.$category[$_POST['category']].'" n\'a pas été incrémenter.</div>';
						}
                    }
                    else
                    {
                        $add_n = '<div id="erreur">La news n\'a pas été ajouté.</div>';
                    }
                }
            }
            ?>
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
						<div id="fil_ariane">
						<?php
							echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?mod=ajout_news', 'Ajout d\'une news');
						?>
						</div>
						<br/>
						<h1><?php echo $titre2; ?></h1>
						<br/>
						<?php
						if(isset($erreur))
						{
							echo '<span class="erreur">'.$erreur.'</span>';
						}
						if(isset($add) || isset($up))
						{
							echo $add_n;
							echo $up;
						}
						?>
						<br/><br/>
						<form method="post">
							<table style="margin:auto;">
								<tr>
									<td align="center"><label for="titre"><span class="donnees">Titre de la news :</span></label></td>
								</tr>
								<tr>
									<td align="center"><input type="text" name="titre" id="titre" value="<?php if(!empty($_POST['titre'])) {echo $_POST['titre'];} ?>" /></td>
								</tr>
								<tr>
									<td align="center"><label for="category"><span class="donnees">Catégorie :</span></label></td>
								</tr>
								<tr>
									<td align="center">
										<select name="category" id="category">
											<?php
												$category = array('1' => 'Catégorie par défaut', '2' => 'Nouveauté','3' => 'Mise à Jour', '4' => 'Astuce', '5' => 'Tutoriel', '6' => 'Bannis');
												foreach($category as $key => $value)
												{
													echo '<option value="'.$key.'">';
													echo $value;
													echo '</option>';
												}
												
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td align="center"><label for="texte"><span class="donnees">Texte de la news :</span></label></td>
								</tr>
								<tr>
									<td align="center">
										<?php include('includes/haut_bbcode.php'); ?>
										<textarea name="texte" id="textarea" cols="70" rows="10" ><?php if(!empty($_POST['texte'])) {echo $_POST['texte'];}?></textarea>
										<?php include('includes/bas_bbcode.php'); ?>
									</td>
								</tr>
								<tr>
									<td align="center"><input type="submit" value="Ajouter une news" name="add_news" /></td>
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