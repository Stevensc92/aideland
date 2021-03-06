<?php
/*
astuce/index.php

Index de la partie des astuce
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

$keys = array_keys($_GET);
if(count($keys) > 0 && ($keys[0] == "astuces" || $keys[0] == "mod" || $keys[0] == "correc"))
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
else
{
	/* Titre de la page */
	$titre = 'Interface des astuces';
	/********************/
	
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Interface des astuces';
	/******************************************************/

	/* Haut de la page, contient le doctype, charset, etc... */
	include('../includes/haut.php');
	/*********************************************************/
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, 'astuce/', 'Interface des astuce'); ?>
				</div>
				
				<br/>
				<h1><?php echo $titre2; ?></h1>
				<br/>
				
				<p align="center"><a href="<?php echo ROOTPATH; ?>/astuce/?mod=search">Commencer à rechercher votre astuce</a></p>
				
				<br/>
				<h2 class="titre_news">Contribuer au site</h2>
				<br/>
				<?php
				if(isset($_SESSION['membre_id']))
				{
				?>
					<p align="center"><a href="<?php echo ROOTPATH; ?>/astuce/?mod=add"><ins>Ajouter vos propres astuces</ins></a></p>
				<?php
				}
				else
				{
				?>
					<p align="center"><a href="<?php echo ROOTPATH; ?>/?page=connexion"><ins>Connecter vous pour pouvoir ajouter vos propres astuces</ins></a></p>
				<?php
				}
				?>
				<ul>
					<li><span class="list"></span>&nbsp;<a href="<?php echo ROOTPATH; ?>/astuce/?astuces=2fight">2 Fight</a></li>
				</ul>
				<?php
				if(isset($_SESSION['membre_id']))
				{
					?>
					<br/>
					<h2 class="titre_news">Vos astuce ajoutées</h2>
					<br/>
					
					<?php
					$sql_listing_add_astuce = mysql_query("
												SELECT site_astuce.id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time, site_membres.pseudo
												FROM site_astuce
												LEFT JOIN site_membres ON site_astuce.correction_by_id = site_membres.id
												WHERE auteur = '".$_SESSION['membre_pseudo']."' ORDER BY site_astuce.id DESC")
					or ErrorSQL(__FILE__,__LINE__);
					if(mysql_num_rows($sql_listing_add_astuce) == 0)
					{
						echo '<p align="center">Vous n\'avez ajouté aucune astuce.<br/>
								<a href="'.ROOTPATH.'/astuce/?mod=add">En ajouter une maintenant.</a>';
					}
					else
					{
						?>
						<p align="center">Voici une liste de vos astuces ajoutées et leur état.</p>
						<table class="liste_membre" width="100%">
							<tr>
								<th class="liste_membre"><strong>ID</strong></th>
								<th class="liste_membre"><strong>Ajouté le</strong></th>
								<th class="liste_membre"><strong>Jeu</strong></th>
								<th class="liste_membre"><strong>Console</strong></th>
								<th class="liste_membre"><strong>Pris en charge par</strong></th>
								<th class="liste_membre"><strong>Dernière modification</strong></th>
								<th class="liste_membre"><strong>État</strong></th>
							</tr>
						<?php
						while($req_listing_add_astuce = mysql_fetch_array($sql_listing_add_astuce))
						{
							echo '<tr>
									<td class="liste_membre">'.htmlspecialchars($req_listing_add_astuce['id']).'</td>
									<td class="liste_membre">'.mepd($req_listing_add_astuce['time']).'</td>
									<td class="liste_membre">'.htmlspecialchars($req_listing_add_astuce['jeu']).'</td>
									<td class="liste_membre">'.htmlspecialchars($req_listing_add_astuce['console']).'</td>';
							if($req_listing_add_astuce['correction_by_id'] == '0')
							{
								echo '<td class="liste_membre">Personne</td>';
							}
							else
							{
								echo '<td class="liste_membre"><a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_listing_add_astuce['correction_by_id'].'">'.$req_listing_add_astuce['pseudo'].'</a></td>';
							}
							if($req_listing_add_astuce['correction_time'] == '0')
							{
								echo '<td class="liste_membre">Jamais</td>';
							}
							else
							{
								echo '<td class="liste_membre">'.mepd($req_listing_add_astuce['correction_time']).'</td>';
							}
							if($req_listing_add_astuce['valid'] == 1)
							{
								echo '<td class="liste_membre"><span style="color:green;">Validé !</span></td>';
							}
							else
							{
								echo '<td class="liste_membre"><span style="color:red;">En attente</span></td>';
							}
							echo '</tr>';
						}
						?>
						</table>
						<?php
					}
				}
				?>
				<br/>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
}
/* Fermeture des balises html body et autre */
include('../includes/bas.php');
/********************************************/
?>