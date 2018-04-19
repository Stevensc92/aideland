<?php
/*
tutoriel/mod/search.php

Module simplifié de recherche de tutoriel
*/

$titre = 'Recherche';
$titre2 = $titre;
include('../includes/haut.php');
?>
<div class="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
	<div class="nf">
		<?php
		if(!isset($_GET['c']))
		{
		?>
			<div id="fil_ariane">
			<?php
			echo fil_ariane(1, '', 'Accueil').'
				'.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').'
				'.fil_ariane(2, 'tutoriel/?mod=search', 'Module simplifié de recherche de tutoriel');
			?>
			</div>
			
			<br/>
			<h1><?php echo $titre2; ?></h1>
			<br/>
			
			<p align="center">
				Choississez la console.
			</p>
			<br/>
			
			<?php
			$listing_console = array(
			'Dreamcast' => 'dreamcast',	'DS' => 'ds','Gameboy' => 'gameboy',
			'Gameboy Advance' => 'gameboy-advance',	'Gameboy Color' => 'gameboy-color',
			'GameCube' => 'gamecube', 'Nintendo 64' => 'nintendo-64', 'PC' => 'pc',
			'Playstation' => 'playstation', 'PS2' => 'ps2', 'PS3' => 'ps3',
			'PSP' => 'psp', 'Sega Master System' => 'sega-master-system',
			'Sega Megadrive' => 'sega-megadrive', 'Super NES' => 'super-nes',
			'Wii' => 'wii', 'Xbox' => 'xbox', 'Xbox 360' => 'xbox-360');
			foreach($listing_console as $key => $value)
			{
				echo '<a href="'.ROOTPATH.'/tutoriel/?mod=search&c='.$value.'">'.$key.'</a><br/>';
			}
		}
		else
		{
			if(!isset($_GET['i']))
			{
				if($_GET['c'] != '')
				{
					$console = isset($_GET['c'])?htmlspecialchars($_GET['c']):'';
					$console_2 = $console;
					$console_2 = str_replace('-', ' ', $console_2);
					?>
					<div id="fil_ariane">
					<?php
					echo fil_ariane(1, '', 'Accueil').'
					'.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').'
					'.fil_ariane(1, 'tutoriel/?mod=search', 'Module simplifié de recherche de tutoriel').'
					'.fil_ariane(2, 'tutoriel/?mod=search&amp;console='.$console, 'Recherche pour les jeux de '.$console_2);
					?>
					</div>
					
					<br/>
					<h1><?php echo $titre2; ?></h1>
					<br/>
					
					<p align="center">
					<?php
					$listing_initiale = array('0-9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
					foreach($listing_initiale as $key)
					{
						echo '<a href="'.ROOTPATH.'/tutoriel/?mod=search&amp;c='.$console.'&amp;i='.$key.'">'.$key.'</a> | ';
					}
					?>
					</p>
					<?php
				}
				else
				{
					?>
					<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').'
						'.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').'
						'.fil_ariane(1, 'tutoriel/?mod=search', 'Module simplifié de recherche de tutoriel').'
						'.fil_ariane(2, 'tutoriel/?mod=search', 'Erreur -> Lien corrompu');
					?>
					</div>
					<?php
					quit('Lien corrompu');
				}
			}
			else
			{
				if($_GET['i'] != '')
				{
					$console = isset($_GET['c'])?htmlspecialchars($_GET['c']):'';
					$console_2 = $console;
					$console_2 = str_replace('-', ' ', $console_2);
					$initiale = isset($_GET['i'])?htmlspecialchars($_GET['i']):'';
					?>
					<div id="fil_ariane">
					<?php
					echo fil_ariane(1, '', 'Accueil').'
					'.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').'
					'.fil_ariane(1, 'tutoriel/?mod=search', 'Module simplifié de recherche de tutoriel').'
					'.fil_ariane(1, 'tutoriel/?mod=search&amp;c='.$console, 'Recherche pour les jeux de '.$console_2).'
					'.fil_ariane(2, 'tutoriel/?mod=search&amp;c='.$console.'&amp;i='.$initiale, 'Recherche pour les jeux commençant par '.$initiale);
					?>
					</div>
					
					<br/>
					<h1><?php echo $titre2; ?></h1>
					<br/>
					
					<p align="center">
					<?php
					$listing_initiale = array('0-9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
					foreach($listing_initiale as $key)
					{
						echo '<a href="'.ROOTPATH.'/tutoriel/?mod=search&amp;c='.$console.'&amp;i='.$key.'">'.$key.'</a> | ';
					}
					?>
					<hr/>
					</p>
					<?php
					$sql_listing_jeu_tutoriel = mysql_query("
												SELECT id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time
												FROM site_tutoriel
												WHERE console = '".$console_2."' && jeu_first_letter = '".$initiale."' && valid = '1'")
					or ErrorSQL(__FILE__,__LINE__);
					if(mysql_num_rows($sql_listing_jeu_tutoriel) > 0)
					{
						echo '<br/>';
						echo '<p align="left">';
						while($req_listing_jeu_tutoriel = mysql_fetch_array($sql_listing_jeu_tutoriel))
						{
							$sql_id_membre_auteur = mysql_query("SELECT id FROM site_membres WHERE pseudo = '".$req_listing_jeu_tutoriel['auteur']."'") or ErrorSQL(__FILE__,__LINE__);
							$req_id_membre_auteur = mysql_fetch_array($sql_id_membre_auteur);
							echo '&nbsp;<a href="'.ROOTPATH.'/tutoriel/a/?c='.$console.'&amp;i='.$initiale.'&amp;id='.$req_listing_jeu_tutoriel['id'].'">'.$req_listing_jeu_tutoriel['jeu'].'</a> par <a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_id_membre_auteur['id'].'">'.$req_listing_jeu_tutoriel['auteur'].'</a> le <strong>'.date('d/m/Y à H:i:s', $req_listing_jeu_tutoriel['time']).'</strong><br/>';
						}
						echo '</p>';
						echo '<br/>';
					}
					else
					{
						echo '<p align="center">Il n\'y a aucun tutoriel présent pour la lettre '.$initiale.' sur '.$console_2.'</p>';
					}
				}
				else
				{
					?>
					<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').'
						'.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').'
						'.fil_ariane(1, 'tutoriel/?mod=search', 'Module simplifié de recherche de tutoriel').'
						'.fil_ariane(2, 'tutoriel/?mod=search', 'Erreur -> Lien corrompu');
					?>
					</div>
					<?php
					quit('Lien corrompu');
				}
			}
		}
		?>
	</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->