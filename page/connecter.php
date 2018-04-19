<?php
/*
page/connecter.php

Liste des connecter/visiteurs du site.
*/

/* Titre de la page */
$titre = 'Liste des connectés';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = $titre;
/******************************************************/

/* Haut de la page, contient le doctype, charset, etc... */
include('includes/haut.php');
/*********************************************************/
?>
<div id="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php
				echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?page=connecter', 'Liste des connectés');
			?>
			</div>
			<br/>
			<h1><?php echo $titre2; ?></h1>
			<br/>
			<?php
			if($_GET['a'] && $_GET['a'] == 1)
			{
				$id = '';
			}
			elseif($_GET['a'] && $_GET['a'] == 2)
			{
				$id = ' AND connectes_id = -1';
			}
			else
			{
				$id = ' AND connectes_id <> -1';
			}
			$sql = mysql_query("SELECT id, pseudo, connectes_actualisation
									  FROM site_connectes
									  LEFT JOIN site_membres ON id = connectes_id 
									  WHERE connectes_actualisation > ".(time()-300).$id."
									  ORDER BY connectes_actualisation DESC") 
									  or ErrorSQL(__FILE__,__LINE__);
									  
			if($_GET['a'] == 1 || $_GET['a'] == 2)
			{
				echo '<a href="'.ROOTPATH.'?page=connecter">Voir seulement les membres connectés</a>';
				$avt = 1;
			}
			if($_GET['a'] != 2)
			{
				if($avt == 1) echo ' - ';
				echo '<a href="'.ROOTPATH.'?page=connecter&amp;a=2">Voir seulement les invités connectés</a>';
				$avt = 1;
			}
			if($_GET['a'] != 1)
			{
				if($avt == 1) echo ' - ';
				echo '<a href="'.ROOTPATH.'?page=connecter&amp;a=1">Voir les membres et les invités connectés</a>';
			}
			?>
			<table class="liste_membre">
				<thead>
					<tr>
						<th class="liste_membre">Pseudo</th>
						<th class="liste_membre">Dernière visite</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					while($req = mysql_fetch_array($sql))
					{
						if($req['id'] != '')
						{
							$lien = '<a href="'.ROOTPATH.'/?page=membre&amp;id='.$req['id'].'">';
							$lien2 = '</a>';
						}
						else
						{
							$lien = '';
							$lien2 = '';
						}
						if($req['id'] == '') //un invité n'a pas de lien, ni d'id.
						{
							$req['id'] = 'Non renseigné'; //
							$req['pseudo'] = 'Anonyme';
						}
						echo '<tr class="ligne_'.($i%2).'">
							  <td class="liste_membre" width="150">'.$lien.''.$req['pseudo'].''.$lien2.'</td>
							  <td class="liste_membre" width="150">'.mepd($req['connectes_actualisation']).'</td>
							  </tr>';
							  $i++;
					}		
					if($i==0)
					{
						echo '<tr class="ligne_'.($i%2).'">
							  <td colspan="2" width="150" class="liste_membre">Aucun résultats trouvé</td>
							  </tr>';
					}
					?>
				</tbody>
			</table>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->