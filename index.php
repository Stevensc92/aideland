<?php
/*
Index.php

Index du site.
*/

session_start();
header('Content-type: text/html; charset=utf-8');

/* Config du site et fonctions */
include('config/config.php');
include('includes/fonctions.php');


/********Actualisation de la session...**********/

connexionbdd();
actualiser_session();

/********Fin actualisation de session...**********/

/******************/

/* Vérification des méthod GET utilisé */
$keys = array_keys($_GET);
if(count($keys) > 0 && ($keys[0] == "page" || $keys[0] == "mod" || $keys[0] == "oh" || $keys[0] == "astuce" || $keys[0] == "tutoriel" || $keys[0] == "2fight"))
{
    if(file_exists($keys[0].'/'.$_GET[$keys[0]].'.php'))
    {
        require($keys[0].'/'.$_GET[$keys[0]].'.php');
    }
    else
    {
        require('error.php');
    }
}
/***************************************/
else
{
/* Titre de la page */
$titre = '';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = '';
/******************************************************/

/* Haut de la page, contient le doctype, charset, etc... */
include('includes/haut.php');
/*********************************************************/
?>
<!-- DÉBUT CONTNEU DE LA PAGE -->
<div class="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php
				echo fil_ariane(2, '', 'Accueil');
			?>
			</div>
			<br/>
			<h1>À la une :</h1>
			<br/>
			<hr/>
			<?php
			$sql = mysql_query("SELECT *
								FROM site_news
								ORDER BY news_id DESC")
			or ErrorSQL(__FILE__,__LINE__);
			$req = mysql_fetch_assoc($sql);
			
			$sql_id = mysql_query("SELECT id
								   FROM site_membres
								   WHERE pseudo = '".$req['news_auteur']."'")
			or ErrorSQL(__FILE__,__LINE__);
			$req_id = mysql_fetch_assoc($sql_id);
			
			$sql_nb_com = mysql_query("SELECT COUNT(*) AS nbr 
								 FROM site_commentaire_news 
								 WHERE commentaire_news_id = '".$req['news_id']."'")
			or ErrorSQL(__FILE__,__LINE__);
			$nb_com = mysql_fetch_array($sql_nb_com);
			
			if($nb_com['nbr'] == 0)
			{
				$lien = '';
				$lien2 = '';
			}
			else
			{
				$lien = '<a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=view">';
				$lien2 = '</a>';
			}
			
			echo '<h2 class="titre_news"><a href="'.ROOTPATH.'/?page=new&amp;news='.$req['news_id'].'">'.stripslashes($req['news_titre']).'</a></h2>';
			echo '<span class="news_info">'.mepd($req['news_date']).'</span>';
			echo parseZCode($req['news_texte']);
			echo '<span class="news_info">Par : <a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_id['id'].'">'.$req['news_auteur'].'</a></span>';
			echo '<span class="news_info">Dans : <a href="'.ROOTPATH.'/?page=new&amp;category='.$req['news_category_id'].'">'.$req['news_category'].'</a></span>';
			echo $lien.'Voir les commentaire('.$nb_com['nbr'].')'.$lien2.' - <a href="'.ROOTPATH.'/?page=comment&amp;new='.$req['news_id'].'&amp;a=add">Ajouter un commentaire</a>';
			?>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->
<!-- FIN CONTENU DE LA PAGE -->
<?php
}
/* Fermeture des balises html body et autre */
include('includes/bas.php');
/********************************************/
?>