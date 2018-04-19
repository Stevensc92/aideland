<?php
if(!isset($_SESSION['membre_id']))
{
	$info_commande = array('true', 'acces_denied');
	require_once('information.php');
	exit();
}
else
{
	$pseudo = array('Stevens', 'Arkana', 'Kylia');
	if(!in_array($_SESSION['membre_pseudo'], $pseudo))
	{
		$info_commande = array('true', 'acces_denied');
		require_once('information.php');
		exit();
	}
	else
	{
		$titre = 'Cahier des charges';
		$titre2 = $titre;
		include('includes/haut.php');
		
		if(isset($_POST['cdc']))
		{
			$password = htmlspecialchars($_POST['password']);
			$good_mdp = 'sunkistus99';
			if($password == $good_mdp)
			{
				echo '<div class="content">';
					echo '<div class="nh"></div>';
					echo '<div class="nf">';
						echo '<div id="fil_ariane">';
							echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?mod=cdc', $titre2);
						echo '</div>';
						echo '<br/><h1>'.$titre2.'</h1><br/>';
						echo '<p>';
							echo 'Le cahier des charges, représentera les diverses tâches/étapes à réaliser ';
							echo 'sur l\'ensemble des modules.<br/>';
							echo 'Un ordre est prescrit, et il doit être suivi. Chaque module aura plusieurs ';
							echo 'étapes différentes, qui elle aussi, seront à suivre dans l\'ordre écrit.<br/>';
							echo 'Il ne faut pas oublier que lors du codage, chaques étapes, doivent être ';
							echo 'détaillée le plus possible. Des commentaires seront exigès à certain ';
							echo 'endroit, pour faciliter toutes manipulations à l\'utilisateur.';							
							echo '<br/><br/>';
						echo '</p>';
						echo '<div id="cdc">';
							echo '<h2 class="titre_news">Sommaire</h2>';
							echo '<ol>';
								echo '<li>Codage en Mysql_*</li>';
								echo '<ol class="chiffre_romain">';
									echo '<li>Réalisation des fonctions principales.</li>';
									echo '<ol class="lettre_minuscule">';
										echo '<li>Création d\'une fonction à la connexion de la bdd</li>';
										echo '<li>Création d\'une fonction d\'actualisation de session</li>';
										echo '<li>Création d\'une fonction d\'update des connexions</li>';
										echo '<li>Création d\'une fonction calculant le temps écoulé depuis une certaine date</li>';
										echo '<li>Création d\'une fonction vidant les cookies et la session</li>';
										echo '<li>Création d\'une fonction</li>';
									echo '</ol>';
								echo '</ol>';
								echo '<li>Codage en PDO</li>';
							echo '</ol>';
							echo '<ol>'; // CDD des modifications à faire sur le site 
								// Pour rajouter une ligne, c'est simple tu fais echo '<li>texte</li>';
							echo '</ol>';
						echo '<br/></div>';
					echo '</div>';
					echo '<div class="nb"></div>';
				echo '</div>';
			}
			else
			{
				echo '<div class="content">';
					echo '<div class="nh"></div>';
					echo '<div class="nf">';
						echo '<div id="fil_ariane">';
							echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?mod=cdc', $titre2);
						echo '</div>';
						echo '<br/><h1>'.$titre2.'</h1><br/>';
						echo '<p>';
							echo 'Bonjour, pour pouvoir accèder au contenu de cette page, vous devez ';
							echo 'entrer le mot de passe que aviez reçu.';
						echo '</p>';
						echo '<form method="post" action="#">';
							echo '<input type="password" name="password" /><br/>';
							echo '<input type="submit" value="Voir le contenu" name="cdc" />';
						echo '</form>';
					echo '</div>';
					echo '<div class="nb"></div>';
				echo '</div>';
			}
		}
		else
		{
			echo '<div class="content">';
				echo '<div class="nh"></div>';
				echo '<div class="nf">';
					echo '<div id="fil_ariane">';
						echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?mod=cdc', $titre2);
					echo '</div>';
					echo '<br/><h1>'.$titre2.'</h1><br/>';
					echo '<p>';
						echo 'Bonjour, pour pouvoir accèder au contenu de cette page, vous devez ';
						echo 'entrer le mot de passe que aviez reçu.';
					echo '</p>';
					echo '<form method="post" action="#">';
						echo '<input type="password" name="password" /><br/>';
						echo '<input type="submit" value="Voir le contenu" name="cdc" />';
					echo '</form>';
					echo '<div id="photo_web"/></div>';
				echo '</div>';
				echo '<div class="nb"></div>';
			echo '</div>';
		}
	}
}
?>