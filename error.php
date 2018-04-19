<?php
/*
error.php

Page d'erreur en cas de require echoué.
*/

/* Titre de la page */
$titre = 'Erreur';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Erreur';
/******************************************************/

/* Haut de la page, contient le doctype, charset, etc... */
include('includes/haut.php');
/*********************************************************/
?>
<!-- DÉBUT CONTNEU DE LA PAGE -->
<div id="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php
				echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '', 'Erreur : page inexistante');
			?>
			</div>
			<h1>Erreur</h1>
			<p align="center">La page demandée n'existe pas. Vous avez tapé une url fausse ou incorrecte.</p>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre --> 
<div class="clear"></div><!-- NE PAS SUPPRIMER -->
<!-- FIN CONTENU DE LA PAGE -->
