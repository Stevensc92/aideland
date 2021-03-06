<?php
/*
astuce/a/index.php

Page d'affichage des astuces
*/

session_start();
header('Content-type: text/html; charset=utf-8');

include('../../config/config.php');
include('../../includes/fonctions.php');

connexionbdd();
actualiser_session();

if(isset($_GET['c']) && isset($_GET['i']) && isset($_GET['id']) && $_GET['c'] != '' && $_GET['i'] != '' && $_GET['id'] != '')
{
	$console = htmlspecialchars($_GET['c']);
	$console_2 = $console;
	$console_2 = str_replace('-', ' ', $console_2);
	$initiale = htmlspecialchars($_GET['i']);
	$id = intval($_GET['id']);
	
	$sql_astuce = mysql_query("
				SELECT id, auteur, console, jeu, jeu_first_letter, type,
				text, time, last_update,
				valid, correction_by_id, correction_time
				FROM site_astuce
				WHERE id = '".$id."' && jeu_first_letter = '".$initiale."' && console = '".$console."' && valid = '1'")
	or ErrorSQL(__FILE__,__LINE__);
	$req_astuce = mysql_fetch_assoc($sql_astuce);
	
	$sql_membre_id = mysql_query("
					SELECT id
					FROM site_membres
					WHERE pseudo = '".$req_astuce['auteur']."'")
	or ErrorSQL(__FILE__,__LINE__);
	$req_membre_id = mysql_fetch_assoc($sql_membre_id);
	
	$titre = 'Affichage de l\'astuce n°'.$id.' de '.$req_astuce['auteur'].' sur '.$req_astuce['jeu'];
	$titre2 = $titre;
	
	include('../../includes/haut.php');
	if(mysql_num_rows($sql_astuce) > 0)
	{
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php echo fil_ariane(1, '', 'Accueil').'
				'.fil_ariane(1, 'astuce/', 'Interface des astuces').'
				'.fil_ariane(1, 'astuce/?mod=search', 'Module simplifié de recherche d\'astuce').'
				'.fil_ariane(1, 'astuce/?mod=search&amp;c='.$console, 'Recherche pour les jeux de '.$console_2).'
				'.fil_ariane(1, 'astuce/?mod=search&amp;c='.$console.'&amp;i='.$initiale, 'Recherche pour les jeux commençant par '.$initiale).'
				'.fil_ariane(1, 'astuce/a/?c='.$console.'&amp;i='.$initiale.'&amp;id='.$id.'', 'Astuce n°'.$id.' de '.$req_astuce['auteur'].' sur '.$req_astuce['jeu'].'').'
				'.fil_ariane(2, 'astuce/a/?c='.$console.'&amp;i='.$initiale.'&amp;id='.$id.'', 'Affichage de l\'astuce');
			
			?>
			</div>
			
			<br/>
			<h2 class="titre_news"><?php echo $titre2; ?></h2>
			<br/>
			
			<fieldset>
				<legend><?php echo $titre2; ?></legend>
				
				<div id="right"><!-- Colonne Droite --> 
					<div class="mh">Informations</div> <!-- Menu -->
					<div class="mf"><!-- Contenu menu -->
						<ul class="menu">
							<li>Auteur : <a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $req_membre_id['id']; ?>"><?php echo $req_astuce['auteur']; ?></a></li>
							<li>Ajouté le : <?php echo date('d/m/Y à H:i:s', $req_astuce['time']); ?></li>
							<li>Dernière modification le : <?php echo date('d/m/Y à H:i:s', $req_astuce['last_update']); ?></li>
						</ul>
					</div>
					<div class="mb"></div><!-- Fin Menu -->
				</div>
				
				<?php
				echo parseZCode($req_astuce['text']);
				?>
			</fieldset>
		</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
	}
	else
	{
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php echo fil_ariane(1, '', 'Accueil').'
				'.fil_ariane(1, 'astuce/', 'Interface des astuces').'
				'.fil_ariane(1, 'astuce/?mod=search', 'Module simplifié de recherche d\'astuce').'
				'.fil_ariane(1, 'astuce/?mod=search&amp;c='.$console, 'Recherche pour les jeux de '.$console_2).'
				'.fil_ariane(1, 'astuce/?mod=search&amp;c='.$console.'&amp;i='.$initiale, 'Recherche pour les jeux commençant par '.$initiale).'
				'.fil_ariane(2, 'astuce/a/?c='.$console.'&amp;i='.$initiale.'&amp;id='.$id.'', 'Erreur');			
			?>
			</div>
			
			<br/>
			<h1>Erreur</h1>
			<br/>			
			<?php
			quit('Erreur dans la recherche d\'astuce');
	}
	include('../../includes/bas.php');
}
else
{
	$info_commande = array('true', 'acces_down');
	require_once('../../information.php');
	exit();
}
?>