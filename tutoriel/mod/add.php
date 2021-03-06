<?php
if(isset($_SESSION['membre_id']))
{
	/* Titre de la page */
	$titre = 'Ajout de tutoriel -';
	/********************/
	
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Ajout de tutoriel -';
	/******************************************************/
	if(!isset($_GET['etape']))
	{
		$titre .= ' étape n°1'; // étape 1
		$titre2 .= ' étape n°1'; // idem
		include('../includes/haut.php'); // on inclut le haut de la page
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').' 
							'.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').' 
							'.fil_ariane(1, 'tutoriel/?mod=add', 'Ajouter un tutoriel').' 
							'.fil_ariane(2, 'tutoriel/?mod=add', 'Étape n°1 : Vérification & confirmation de l\'existence du jeu dans la <acronym title="Base de donnée">BDD</acronym>'); ?>
				</div>
				<br/>
				<h2 class="titre_news">Étape n°1 : Vérification & confirmation de l'existence du jeu dans la <acronym title="Base de donnée">BDD</acronym></h2> 
				<br/>
				<p>
				Vous voulez faire part de vos tutoriels ? C'est très simple, vous avez une série d'étape (courte),<br/>
				pour pouvoir nous proposer vos tutoriels.
				Vous pouvez suivre votre progression en suivant le fil d'ariane et en regardant le titre général de la page.<br/><br/>
				</p>
				<?php
				if(!isset($_GET['jeu_first_letter']))
				{
				?>
				<p>
				La première partie de la première étape, et de vérifier si le jeu au quel vous voulez ajouter votre tutoriel existe ou non dans la base de donnée.
				Il vous suffit simplement de préciser la première lettre du jeu.
				</p>
				<form method="get" action="?mod=add">
					<table style="margin:auto;">
						<tr>
							<td><input type="hidden" name="mod" value="add" /></td>
						</tr>
						<tr>
							<td><label for="jeu_first_letter">Première lettre du Jeu :</label></td>
						</tr>
						<tr>
							<td><input type="text" name="jeu_first_letter" /></td>
						</tr>
						<tr>
							<td><input type="submit" value="Vérifier et Confirmer !" /></td>
						</tr>
					</table>
				</form>
				<?php
				}
				else
				{
					$jeu_first_letter = isset($_GET['jeu_first_letter'])?htmlspecialchars($_GET['jeu_first_letter']):'';
					if($jeu_first_letter != '')
					{
						$tutoriel_exists_sql = mysql_query("SELECT COUNT(*) AS tutoriel_exists
											FROM site_tutoriel 
											WHERE jeu_first_letter = '$jeu_first_letter'")
						or ErrorSQL(__FILE__,__LINE__);
						$tutoriel_exists_req = mysql_fetch_array($tutoriel_exists_sql);						
						$tutoriel_exists = $tutoriel_exists_req['tutoriel_exists'];
						
						if($tutoriel_exists >= 1)
						{
							$sql = mysql_query("SELECT *
												FROM site_tutoriel
												WHERE jeu_first_letter = '$jeu_first_letter'")
							or ErrorSQL(__FILE__,__LINE__);
							
							echo 'La recherche a trouvé un ou plusieurs résultats, si vous trouvez votre jeu, merci de le cocher, sinon passer cette étape.<br/><br/>';
							echo '<form method="post" action="?mod=add&amp;etape=2">';
							while($req = mysql_fetch_array($sql))
							{
								echo '<input type="radio" name="'.$req['jeu'].'-'.$req['console'].'" id="'.$req['jeu'].'-'.$req['console'].'" /><label for="'.$req['jeu'].'-'.$req['console'].'">'.$req['jeu'].' - '.$req['console'].'</label><br/>';
							}
							echo '<input type="submit" value="Continuer vers la seconde étape" name="next_etape" />';
							echo '</form>';
						}
						else
						{
							echo '<p>Il n\'y a aucun jeu possédant cette première lettre.
							Vous pouvez donc passer à la seconde étape.</p>';
							echo '<form method="post" action="?mod=add&amp;etape=2">
								<input type="submit" value="Passer à la seconde étape" style="display:block; margin:auto;" name="next_etape"/>
								</form>';
						}
					}
					else
					{
						quit('Lien corrompu');
					}					
				}
				?>
			</div>
			<div class="nb"></div> <!-- Fin news Stevens.|BNPP easy; Stevens.|BNJP pro; -->
		</div><!-- Fin centre -->
		<?php
	}
	else
	{
		if(isset($_GET['etape']) && $_GET['etape'] != '1')
		{
			$titre .= ' étape n°'; // étape x
			$titre2 .= ' étape n°'; // idem
			
			$etape = isset($_GET['etape'])?intval($_GET['etape']):'';
			switch($etape)
			{
				case "2":
					if(isset($_POST['next_etape']))
					{
						$titre .= $etape; // étape 1
						$titre2 .= $etape; // idem
						include('../includes/haut.php'); // on inclut le haut de la page
						?>
						<div class="content"><!-- Début centre -->	 
							<div class="nh"></div> <!-- News -->
							<div class="nf">
								<div id="fil_ariane">
									<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').' 
										'.fil_ariane(1, 'tutoriel/?mod=add', 'Ajouter un tutoriel').' 
										'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°1 : Vérification & confirmation de l\'existence du jeu dans la <acronym title="Base de donnée">BDD</acronym>').'
										'.fil_ariane(2, 'tutoriel/?mod=add', 'Étape n°2 : Un peu de paperasse'); 
									?>
								</div>
								<br/>
								<h2 class="titre_news">Étape n°2 : Un peu de paperasse !</h2>
								<br/>
								<p>
								Nous voici à la grande partie d'ajout de tutoriels qui est l'étape n°2. Vous allez donc devoir remplir tout ce qu'il faut remplir.
								Du BBCode spécialisé et sécurisé sera mis à votre disposition pour faire certaines choses.
								</p>
								<form method="post" action="?mod=add&amp;etape=3">
									<table style="margin:auto;">
										<tr>
											<td align="center"><label for="jeu">Jeu :</label> <input type="text" name="jeu" id="jeu" /></td>
										</tr>
										<tr>
											<td align="center"><label for="console">Console :</label> <input type="text" name="console" id="console" /></td>
										</tr>
										<tr>
											<td align="center">
												<?php
													include('../includes/haut_bbcode.php');
												?>
												<label for="textarea">Votre tutoriel en intégralité :</label><br/>
												<textarea name="textarea" id="textarea" cols="70" rows="15" ></textarea>
												<?php
													$f = ''; include('../includes/bas_bbcode.php');
												?>
											</td>
										</tr>
										<tr>
											<td><input type="submit" value="Envoyer votre tutoriel" name="submit_tutoriel" /> 
												<input type="reset" value="Recommencer ..." 
												onclick="return confirm('Ête vous sûr de vouloir tout refaire ? Aucun retour en arrière n\'est possible.');" />
											</td>
										</tr>
									</table>
								</form>
							</div>
							<div class="nb"></div> <!-- Fin news Stevens.|BNPP easy; Stevens.|BNJP pro; -->
						</div><!-- Fin centre -->
						<?php
					}
					else
					{
						$titre = 'Ajout de tutoriel - Erreur';
						include('../includes/haut.php');
						?>
						<div class="content"><!-- Début centre -->	 
							<div class="nh"></div> <!-- News -->
							<div class="nf">
								<div id="fil_ariane">
								<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').' 
									'.fil_ariane(1, 'tutoriel/?mod=add', 'Ajouter un tutoriel').' 
									'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°1 : Vérification & confirmation de l\'existence du jeu dans la <acronym title="Base de donnée">BDD</acronym>').'
									'.fil_ariane(2, 'tutoriel/?mod=add', 'Erreur');
								?>
								</div>
								<?php
						quit('Il y a une erreur à l\'étape n°1, merci de réessayer.');
					}
				break;
				
				case "3":
					if(isset($_POST['submit_tutoriel']))
					{
						$titre .= $etape; // étape 1
						$titre2 .= $etape; // idem
						include('../includes/haut.php'); // on inclut le haut de la page
						if(empty($_POST['jeu']) || empty($_POST['console']) || empty($_POST['textarea']))
						{
							$titre = 'Ajout de tutoriel - Erreur';
							?>
							<div class="content"><!-- Début centre -->	 
								<div class="nh"></div> <!-- News -->
								<div class="nf">
									<div id="fil_ariane">
									<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').' 
										'.fil_ariane(1, 'tutoriel/?mod=add', 'Ajouter un tutoriel').' 
										'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°1 : Vérification & confirmation de l\'existence du jeu dans la <acronym title="Base de donnée">BDD</acronym>').'
										'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°2 : Un peu de paperasse').'
										'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°3 : Envoie des données').'
										'.fil_ariane(2, 'tutoriel/?mod=add', 'Erreur');
									?>
									</div>
									<?php
							quit('En passant à l\'étape n°3, envoie des données, il y a une erreur. Nous sommes désolés pour le problème. Vous devez recommencer.');
						}
						else
						{
							?>
							<div class="content"><!-- Début centre -->	 
								<div class="nh"></div> <!-- News -->
								<div class="nf">
									<div id="fil_ariane">
									<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').' 
										'.fil_ariane(1, 'tutoriel/?mod=add', 'Ajouter un tutoriel').' 
										'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°1 : Vérification & confirmation de l\'existence du jeu dans la <acronym title="Base de donnée">BDD</acronym>').'
										'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°2 : Un peu de paperasse').'
										'.fil_ariane(2, 'tutoriel/?mod=add', 'Dernier étape : Envoie des données');
									?>
									</div>
								<?php
							$jeu = isset($_POST['jeu'])?add_SQL($_POST['jeu']):'';
							$first_letter = add_SQL(strtoupper($jeu[0]));
							if(intval($first_letter))
							{
								$first_letter = '0-9';
							}
							else
							{
								$first_letter = $first_letter;
							}
							$console = isset($_POST['console'])?add_SQL($_POST['console']):'';
							$texte = add_SQL($_POST['textarea']);
							
							$info = array('membre_id' => $_SESSION['membre_id'],
											'membre_pseudo' => $_SESSION['membre_pseudo'],
											'tut_jeu' => $jeu,
											'tut_jeu_first_letter' => $first_letter,
											'tut_console' => $console,
											'tut_texte' => $texte,
											'time' => time());
							$add_tutoriel = mysql_query("INSERT INTO site_tutoriel(auteur, console, jeu, jeu_first_letter, text, time) VALUES(
													'".$info['membre_pseudo']."', '".$info['tut_console']."',
													'".$info['tut_jeu']."', '".$info['tut_jeu_first_letter']."',
													'".$info['tut_texte']."', ".time().")")
							or ErrorSQL(__FILE__,__LINE__);
							$id_new_tutoriel = mysql_insert_id();
							if($add_tutoriel)
							{
								echo '<br/><br/><div id="information">Le tutoriel à bien été ajouté.</div><br/><br/>';
								/*
								 *
								 * On commence le traitement de l'envoie du mail
								 *
								 * */
								$sql2 = mysql_query("SELECT mail
											FROM site_membres
											WHERE id = '".$_SESSION['membre_id']."'")
								or ErrorSQL(__FILE__,__LINE__);
								$req2 = mysql_fetch_assoc($sql2);
								
								if(correction_mail($info['membre_pseudo'], $req2['mail'], 'tutoriel', $info['tut_console'], $info['tut_jeu'], '', '', 't', $info['tut_texte'], '', $info['time'], $id_new_tutoriel))
								{
									echo ' <div id="information">L\'équipe a bien été avertis de l\'envoie de votre tutoriel. Nous faisons le plus vite possible pour prendre en compte votre tutoriel.<br/>
											Merci pour votre confiance à Help World.</div>';
								}
								else
								{
									echo '<div id="erreur">Il y a eu une erreur lors de l\'envoie d\'un mail.</div>';
								}
								?>
								</div>
								<div class="nb"></div> <!-- Fin news Stevens.|BNPP easy; Stevens.|BNJP pro; -->
							</div><!-- Fin centre -->
							<?php
							}
							else
							{
								quit('Il y a eu une erreur lors de l\'insertion du tutoriel, veuillez réessayer.');
							}
						}
					}
					else
					{
						$titre = 'Ajout de tutoriel - Erreur';
						include('../includes/haut.php');
						?>
						<div class="content"><!-- Début centre -->	 
							<div class="nh"></div> <!-- News -->
							<div class="nf">
								<div id="fil_ariane">
								<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'tutoriel/', 'Interface des tutoriels').' 
									'.fil_ariane(1, 'tutoriel/?mod=add', 'Ajouter un tutoriel').' 
									'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°1 : Vérification & confirmation de l\'existence du jeu dans la <acronym title="Base de donnée">BDD</acronym>').'
									'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°2 : Un peu de paperasse').'
									'.fil_ariane(2, 'tutoriel/?mod=add', 'Erreur');
								?>
								</div>
								<?php
						quit('Il y a une erreur à l\'étape n°2, merci de réessayer.');
					}
				break;
			}
		}
		else
		{
			$titre = 'Ajout de turoeil - Erreur';
			include('../includes/haut.php');
			?>
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'tutoriel/', 'Interface des tutoriel').' 
						'.fil_ariane(1, 'tutoriel/?mod=add', 'Ajouter un tutoriel').' 
						'.fil_ariane(1, 'tutoriel/?mod=add', 'Étape n°1 : Vérification & confirmation de l\'existence du jeu dans la <acronym title="Base de donnée">BDD</acronym>').'
						'.fil_ariane(2, 'tutoriel/?mod=add', 'Erreur');
					?>
					</div>
					<?php
			quit('Lien corrompu.');
		}
	}	
}
else
{
	$info_commande = array('true', 'acces_not_connect');
	require_once('../information.php');
	exit();
}
?>