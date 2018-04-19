<?php
if(isset($_SESSION['membre_id']))
{
	$sql_verif_auth = mysql_query("
						SELECT rang
						FROM site_membres
						WHERE id = '".$_SESSION['membre_id']."'")
	or ErrorSQl(__FILE__,__LINE__);
	$req_verif_auth = mysql_fetch_assoc($sql_verif_auth);
	
	$rang = array('10', '15', '90', '100');
	
	if(!in_array($req_verif_auth['rang'], $rang))
	{
		$info_commande = array('true', 'acces_denied');
		require_once('../information.php');
		exit();
	}
}


$time = isset($_GET['time'])?intval($_GET['time']):'';
$action = isset($_GET['a'])?htmlspecialchars($_GET['a']):'';
$titre = 'Correction des astuce';
$titre2 = $titre;
switch($action)
{
	case "select":
		$titre .= ' - choisir une astuce / un tutoriel';
		$titre2 .= ' - choisir une astuce / un tutoriel';
		include('../includes/haut.php');
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Interface des astuce').'
					'.fil_ariane(1, 'astuce/?correc=correc', 'Interface des corrections').'
					'.fil_ariane(2, 'astuce/?correc=correc&amp;a=select', 'Astuce & Tutoriel en attente de validation');				
				?>
				</div>
				<br/>
				<h1><?php echo $titre2; ?></h1>
				<br/>
				<p align="center">
				<?php
				if(isset($_GET['id']) && $_GET['id'] != '' && isset($_GET['t']) && $_GET['t'] != '')
				{
					$sql_membre_occuper = mysql_query("SELECT membre_occuper
												FROM site_membres_config
												WHERE membre_id = '".$_SESSION['membre_id']."'")
					or ErrorSQL(__FILE__,__LINE__);
					$req_membre_occuper = mysql_fetch_assoc($sql_membre_occuper);
					if($req_membre_occuper['membre_occuper'] == 2)
					{
						quit('Vous ne pouvez plus prendre en compte un tutoriel et une astuce.<br/>
						Vous avez déjà un tutoriel et une astuce sous vôtre responsabilité.<br/>
						<a href="'.ROOTPATH.'/astuce/?correc=correc">Cliquer ici pour voir le tutoriel et l\'astuce sous vôtre responsabilité.</a>');
					}
					
					$id = isset($_GET['id'])?intval($_GET['id']):'';
					if(!$id)
					{
						quit('Lien corrompu.');
					}
					else
					{
						$type = isset($_GET['t'])?htmlspecialchars($_GET['t']):'';
						switch($type)
						{
							case "a":
							
								if($req_membre_occuper['membre_occuper'] == 1)
								{
									$sql_occuper_a = mysql_query("SELECT correction_by_id
																FROM site_astuce
																WHERE correction_by_id = '".$_SESSION['membre_id']."'")
									or ErrorSQL(__FILE__,__LINE__);
									if(mysql_num_rows($sql_occuper_a) > 0)
									{
										quit('Vous ne pouvez prendre en charge plusieur astuce. Finissez d\'abord celle en cours ou abandonner là.
										<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select">Retour</a>');
									}
								}
								
								$sql_astuce = mysql_query("SELECT id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time
												FROM site_astuce
												WHERE id = '".$id."'")
								or ErrorSQL(__FILE__,__LINE__);
								$req_astuce = mysql_fetch_assoc($sql_astuce);
								
								if(isset($_GET['sur']) && $_GET['sur'] != '' && $_GET['sur'] == 1)
								{
									$sql_up_occuper = mysql_query(
														"UPDATE site_membres_config
														SET membre_occuper = membre_occuper +1
														WHERE membre_id = '".$_SESSION['membre_id']."'")
									or ErrorSQL(__FILE__,__LINE__);
									
									$sql_up_correction = mysql_query(
														"UPDATE site_astuce
														SET correction_by_id = '".$_SESSION['membre_id']."'
														WHERE id = '".$id."'")
									or ErrorSQL(__FILE__,__LINE__);
									
									$alert_mail = alert_mail($req_astuce['auteur'], $req_astuce['jeu'], $req_astuce['console'], $req_astuce['time'], $_SESSION['membre_id'], $_SESSION['membre_pseudo'], time(), 'astuce');
									
									if($sql_up_occuper && $sql_up_correction && $alert_mail)
									{
										echo '<div id="information">Vous avez bien pris en charge l\'astuce n°'.$req_astuce['id'].' de '.$req_astuce['auteur'].'.</div>';
									}
									else
									{
										echo '<div id="erreur">Vous n\'avez pas pu prendre en charge l\'astuce n°'.$req_astuce['id'].' de '.$req_astuce['auteur'].'.</div>';
									}
								}
								else
								{
									echo '<p align="center">
											Êtes vous sûr de vouloir prendre en charge l\'astuce n°<strong>'.$req_astuce['id'].'</strong> de <strong>'.$req_astuce['auteur'].'</strong> ?<br/>
										<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select&amp;id='.$id.'&amp;t='.$type.'&amp;sur=1">Oui</a>
										-
										<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select">Non</a>
										</p>';
								}
								
							break;
							
							case "t":
							
								if($req_membre_occuper['membre_occuper'] == 1)
								{
									$sql_occuper_t = mysql_query("SELECT correction_by_id
																FROM site_tutoriel
																WHERE correction_by_id = '".$_SESSION['membre_id']."'")
									or ErrorSQL(__FILE__,__LINE__);
									if(mysql_num_rows($sql_occuper_t) > 0)
									{
										quit('Vous ne pouvez prendre en charge plusieur tutoriel. Finissez d\'abord celle en cours ou abandonner là.
										<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select">Retour</a>');
									}
								}
								
								$sql_tutoriel = mysql_query("SELECT id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time
												FROM site_tutoriel
												WHERE id = '".$id."'")
								or ErrorSQL(__FILE__,__LINE__);
								$req_tutoriel = mysql_fetch_assoc($sql_tutoriel);
								
								if(isset($_GET['sur']) && $_GET['sur'] != '' && $_GET['sur'] == 1)
								{
									$sql_up_occuper = mysql_query(
														"UPDATE site_membres_config
														SET membre_occuper = membre_occuper +1
														WHERE membre_id = '".$_SESSION['membre_id']."'")
									or ErrorSQL(__FILE__,__LINE__);
									
									$sql_up_correction = mysql_query(
														"UPDATE site_tutoriel
														SET correction_by_id = '".$_SESSION['membre_id']."'
														WHERE id = '".$id."'")
									or ErrorSQL(__FILE__,__LINE__);
									
									$alert_mail = alert_mail($req_tutoriel['auteur'], $req_tutoriel['jeu'], $req_tutoriel['console'], $req_tutoriel['time'], $_SESSION['membre_id'], $_SESSION['membre_pseudo'], time(), 'tutoriel');
									
									if($sql_up_occuper && $sql_up_correction && $alert_mail)
									{
										echo '<div id="information">Vous avez bien pris en charge le tutoriel n°'.$req_tutoriel['id'].' de '.$req_tutoriel['auteur'].'.</div>';
									}
									else
									{
										echo '<div id="erreur">Vous n\'avez pas pu prendre en charge le tutoriel n°'.$req_tutoriel['id'].' de '.$req_tutoriel['auteur'].'.</div>';
									}
								}
								else
								{
									echo '<p align="center">
											Êtes vous sûr de vouloir prendre en charge le tutoriel n°<strong>'.$req_tutoriel['id'].'</strong> de <strong>'.$req_tutoriel['auteur'].'</strong> ?<br/>
										<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select&amp;id='.$id.'&amp;t='.$type.'&amp;sur=1">Oui</a>
										-
										<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select">Non</a>
										</p>';
								}							
							
							break;
							
							default :
							
								quit('Lien corrompu.');
							
							break;
						}
						echo '<hr/>';
					}
				}
				
				
				echo '<br/><br/>';
				$sql_membre_occuper = mysql_query("SELECT membre_occuper
												FROM site_membres_config
												WHERE membre_id = '".$_SESSION['membre_id']."'")
				or ErrorSQL(__FILE__,__LINE__);
				$req_membre_occuper = mysql_fetch_assoc($sql_membre_occuper);
				
				echo '<p align="center">';
				if(date("H") >= 17 OR date("H") <= 7)
				{
					echo 'Bonsoir';
				}
				else
				{
					echo 'Bonjour';
				}
				echo ' '.$_SESSION['membre_pseudo'].',';
				if($req_membre_occuper['membre_occuper'] == 2)
				{
					quit(' vous ne pouvez plus prendre en compte un tutoriel et une astuce.<br/>
					Vous avez déjà un tutoriel et une astuce sous vôtre responsabilité.<br/>
					<a href="'.ROOTPATH.'/astuce/?correc=correc">Cliquer ici pour voir le tutoriel et l\'astuce sous vôtre responsabilité.</a>');
				}
				
				echo ' voici la liste des astuce et tutoriel en attente de correction et validation.</p>';
				?>
				</p>
				<table class="liste_membre" width="100%">
					<thead>
						<tr>
							<th class="liste_membre"><strong>ID</strong></th>
							<th class="liste_membre"><strong>Jeu</strong></th>
							<th class="liste_membre"><strong>Console</strong></th>
							<th class="liste_membre" width="25%"><strong>Première lettre du jeu</strong></th>
							<th class="liste_membre"><strong>Auteur</strong></th>
							<th class="liste_membre" width="23%"><strong>La prendre en charge</strong></th>
						</tr>
					</thead>
					<tbody>
					<?php
					$sql_listing_a = mysql_query("SELECT id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time
												FROM site_astuce")
					or ErrorSQL(__FILE__,__LINE__);
					
					$sql_listing_t = mysql_query("SELECT id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time
												FROM site_tutoriel")
					or ErrorSQL(__FILE__,__LINE__);
					
					echo '<tr>
							<td class="liste_membreth" colspan="6"><strong>Astuce</strong></td>
						</tr>';
					if(mysql_num_rows($sql_listing_a) > 0)
					{
						while($req_listing_a = mysql_fetch_array($sql_listing_a))
						{
							$sql_membre_id_a = mysql_query("SELECT id
												FROM site_membres
												WHERE pseudo = '".$req_listing_a['auteur']."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_membre_id_a = mysql_fetch_array($sql_membre_id_a);
							
							$sql_membre_id_a_2 = mysql_query(
												"SELECT id, pseudo
												FROM site_membres
												WHERE id = '".$req_listing_a['correction_by_id']."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_membre_id_a_2 = mysql_fetch_array($sql_membre_id_a_2);
							echo '<tr>
									<td class="liste_membre">'.$req_listing_a['id'].'</td>
									<td class="liste_membre">'.$req_listing_a['jeu'].'</td>
									<td class="liste_membre">'.$req_listing_a['console'].'</td>
									<td class="liste_membre">'.$req_listing_a['jeu_first_letter'].'</td>
									<td class="liste_membre"><a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_membre_id_a['id'].'">'.$req_listing_a['auteur'].'</a></td>';
							if($req_listing_a['correction_by_id'] != '0')
							{
								echo '<td class="liste_membre">Pris en charge par  <a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_membre_id_a_2['id'].'">'.$req_membre_id_a_2['pseudo'].'</a></td>';
							}
							else
							{
								echo '<td class="liste_membre"><a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select&amp;id='.$req_listing_a['id'].'&amp;t=a">La prendre en charge</a></td>';
							}
							echo '</tr>';
						}
					}
					else
					{
						echo '<tr>
								<td class="liste_membre" colspan="6">Il n\'y a aucune astuce en attente de correction ou validation.</td>
							</tr>';
					}
					
					echo '<tr>
							<td class="liste_membreth" colspan="6"><strong>Tutoriel</strong></td>
						</tr>';
					if(mysql_num_rows($sql_listing_t) > 0)
					{
						while($req_listing_t = mysql_fetch_array($sql_listing_t))
						{
							$sql_membre_id_t = mysql_query("SELECT id
												FROM site_membres
												WHERE pseudo = '".$req_listing_t['auteur']."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_membre_id_t = mysql_fetch_array($sql_membre_id_t);
							
							$sql_membre_id_t_2 = mysql_query(
												"SELECT id, pseudo
												FROM site_membres
												WHERE id = '".$req_listing_t['correction_by_id']."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_membre_id_t_2 = mysql_fetch_array($sql_membre_id_t_2);
							echo '<tr>
									<td class="liste_membre">'.$req_listing_t['id'].'</td>
									<td class="liste_membre">'.$req_listing_t['jeu'].'</td>
									<td class="liste_membre">'.$req_listing_t['console'].'</td>
									<td class="liste_membre">'.$req_listing_t['jeu_first_letter'].'</td>
									<td class="liste_membre"><a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_membre_id_t['id'].'">'.$req_listing_t['auteur'].'</a></td>';
							if($req_listing_t['correction_by_id'] != '0')
							{
								echo '<td class="liste_membre">Pris en charge par  <a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_membre_id_t_2['id'].'">'.$req_membre_id_t_2['pseudo'].'</a></td>';
							}
							else
							{
								echo '<td class="liste_membre"><a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select&amp;id='.$req_listing_t['id'].'&amp;t=t">La prendre en charge</a></td>';
							}
							echo '</tr>';
						}
					}
					else
					{
						echo '<tr>
								<td class="liste_membre" colspan="6">Il n\'y a aucun tutoriel en attente de correction ou validation.</td>
							</tr>';
					}
					?>
					</tbody>
				</table>
			</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
	break;
	
	case "unselect" :
		
		$titre .= ' - abandonner une astuce / un tutoriel';
		$titre2 .= ' - abandonner une astuce / un tutoriel';
		include('../includes/haut.php');
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Interface des astuce').'
					'.fil_ariane(1, 'astuce/?correc=correc', 'Interface des corrections').'
					'.fil_ariane(2, 'astuce/?correc=correc&amp;a=unselect', 'Abandonner une astuce ou un tutoriel');				
				?>
				</div>
				<br/>
				<h1><?php echo $titre2; ?></h1>
				<br/>
				<?php
				if(isset($_GET['id']) && $_GET['id'] != '' && intval($_GET['id']) && isset($_GET['t']) && $_GET['t'] != '')
				{
					$id = isset($_GET['id'])?intval($_GET['id']):'';
					$type = isset($_GET['t'])?htmlspecialchars($_GET['t']):'';
					
					switch($type)
					{
						case "a" :
						
							$sql_astuce = mysql_query("SELECT id, auteur, console, jeu, jeu_first_letter, type,
													text, time, valid,
													correction_by_id, correction_time
													FROM site_astuce
													WHERE id = '".$id."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_astuce = mysql_fetch_assoc($sql_astuce);
							
							if(isset($_GET['sur']) && $_GET['sur'] != '' && $_GET['sur'] == 1)
							{
								$sql_down_occuper = mysql_query("
													UPDATE site_membres_config
													SET membre_occuper = membre_occuper -1
													WHERE membre_id = '".$_SESSION['membre_id']."'")
								or ErrorSQL(__FILE__,__LINE__);
								
								$sql_down_correction = mysql_query("
														UPDATE site_astuce
														SET correction_by_id = '0', correction_time = ''
														WHERE id = '".$req_astuce['id']."'")
								or ErrorSQL(__FILE__,__LINE__);
								
								if($sql_down_occuper && $sql_down_correction)
								{
									echo '<div id="information">L\'abandon de l\'astuce n°'.$req_astuce['id'].' de '.$req_astuce['auteur'].' a réussi.<br/>
									<a href="'.ROOTPATH.'/astuce/?correc=correc">Retour</a>
									-
									<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select">Prendre en charge une nouvelle astuce</a></div>';
								}
								else
								{
									echo '<div id="erreur">L\'abandon de l\'astuce n°'.$req_astuce['id'].' de '.$req_astuce['auteur'].' a échoué.</div>';
								}
							}
							else
							{
								echo '<p align="center">Ête vous sûr de vouloir abandonner l\'astuce n°'.$req_astuce['id'].' de <strong>'.$req_astuce['auteur'].'</strong> ?<br/>
									<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=unselect&amp;id='.$id.'&amp;t='.$type.'&amp;sur=1">Oui</a>
									-
									<a href="'.ROOTPATH.'/astuce/?correc=correc">Non</a></p>';
							}
						
						break;
						
						case "t":
						
							$sql_tutoriel = mysql_query("SELECT id, auteur, console, jeu, jeu_first_letter, type,
													text, time, valid,
													correction_by_id, correction_time
													FROM site_tutoriel
													WHERE id = '".$id."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_tutoriel = mysql_fetch_assoc($sql_tutoriel);
							
							if(isset($_GET['sur']) && $_GET['sur'] != '' && $_GET['sur'] == 1)
							{
								$sql_down_occuper = mysql_query("
													UPDATE site_membres_config
													SET membre_occuper = membre_occuper -1
													WHERE membre_id = '".$_SESSION['membre_id']."'")
								or ErrorSQL(__FILE__,__LINE__);
								
								$sql_down_correction = mysql_query("
														UPDATE site_tutoriel
														SET correction_by_id = '0', correction_time = ''
														WHERE id = '".$req_tutoriel['id']."'")
								or ErrorSQL(__FILE__,__LINE__);
								
								if($sql_down_occuper && $sql_down_correction)
								{
									echo '<div id="information">L\'abandon du tutoriel n°'.$req_tutoriel['id'].' de '.$req_tutoriel['auteur'].' a réussi.<br/>
									<a href="'.ROOTPATH.'/astuce/?correc=correc">Retour</a>
									-
									<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select">Prendre en charge un nouveau tutoriel</a></div>';
								}
								else
								{
									echo '<div id="erreur">L\'abandon du tutoriel n°'.$req_tutoriel['id'].' de '.$req_tutoriel['auteur'].' a échoué.</div>';
								}
							}
							else
							{
								echo '<p align="center">Ête vous sûr de vouloir abandonner le tutoriel n°'.$req_tutoriel['id'].' de <strong>'.$req_tutoriel['auteur'].'</strong> ?<br/>
									<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=unselect&amp;id='.$id.'&amp;t='.$type.'&amp;sur=1">Oui</a>
									-
									<a href="'.ROOTPATH.'/astuce/?correc=correc">Non</a></p>';
							}
						
						break;
					}
				}
				?>
			</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
		
	break;
	
	case "update":
	
		$titre .= ' - modifier une astuce / un tutoriel';
		$titre2 .= ' - modifier une astuce / un tutoriel';
		include('../includes/haut.php');
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Interface des astuce').'
					'.fil_ariane(1, 'astuce/?correc=correc', 'Interface des corrections').'
					'.fil_ariane(2, 'astuce/?correc=correc&amp;a=update&amp;id='.$_GET['id'].'&amp;t='.$_GET['t'].'', 'Modifier une astuce ou un tutoriel');				
				?>
				</div>
				<br/>
				<h1><?php echo $titre2; ?></h1>
				<br/>
				<?php
				if(isset($_GET['id']) && $_GET['id'] != '' && intval($_GET['id']) && isset($_GET['t']) && $_GET['t'] != '')
				{
					$id = isset($_GET['id'])?intval($_GET['id']):'';
					$type = isset($_GET['t'])?htmlspecialchars($_GET['t']):'';
					
					switch($type)
					{
						case "a" :
						
							$sql_verif_auth = mysql_query("
											SELECT site_astuce.correction_by_id, site_membres.pseudo
											FROM site_astuce
											LEFT JOIN site_membres ON site_astuce.correction_by_id = site_membres.id
											WHERE site_astuce.id = '".$id."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_verif_auth = mysql_fetch_assoc($sql_verif_auth);
							
							if($req_verif_auth['correction_by_id'] == $_SESSION['membre_id'])
							{
								if(isset($_POST['register']))
								{
									$text = add_SQL($_POST['textarea']);
									if(!empty($_POST['valider']))
									{
										$valider = ", valid = '1'";
									}
									else
									{
										$valider = ", valid = '0'";
									}
									
									$update = mysql_query("
												UPDATE site_astuce
												SET text = '".$text."', correction_time = ".time()." ".$valider."
												WHERE id = '".$id."'")
									or ErrorSQL(__FILE__,__LINE__);
									
									if($update)
									{
										echo '<div id="information">L\'astuce a bien été modifié.';
										if(!empty($_POST['valider']))
										{
											echo ' L\'astuce a bien été validé.</div>';
										}
										else
										{
											echo '</div>';
										}
									}
									else
									{
										echo '<div id="erreur">Il y a eu une erreur lors de la modification de l\'astuce.</div>';
									}
									echo '<br/><hr/><br/><br/>';
								}
								$sql_astuce = mysql_query("
												SELECT id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time
												FROM site_astuce
												WHERE id ='".$id."'")
								or ErrorSQl(__FILE__,__LINE__);
								$req_astuce = mysql_fetch_assoc($sql_astuce);
								
								echo '<p align="center">';
								if(date("H") >= 17 OR date("H") <= 7) {
									echo 'Bonsoir ';
								}
								else {
									echo 'Bonjour ';
								}
								echo $_SESSION['membre_pseudo'].', vous corriger actuellement l\'astuce n°<strong>'.$req_astuce['id'].'</strong> de <strong>'.$req_astuce['auteur'].'</strong>';
								echo '<br/><hr/><br/>';
								?>
									<form method="post" action="#">
										<table style="margin:auto;">
											<tr>
												<td align="center">
													<?php
														include('../includes/haut_bbcode.php');
													?>
													<label for="textarea">L'astuce :</label><br/>
													<textarea name="textarea" id="textarea" cols="70" rows="15" ><?php echo stripslashes($req_astuce['text']); ?></textarea>
													<?php
														$f = true; include('../includes/bas_bbcode.php');
													?>
												</td>
											</tr>
											<tr>
												<td align="center">
													<input type="checkbox" value="valider" name="valider" 
													<?php if($req_astuce['valid'] == 1){ echo 'checked="checked"'; }?>
													/><label for="valider">Cocher cette case pour valider l'astuce.</label>
												</td>
											</tr>
											<tr>
												<td align="center">
													<input type="submit" value="Enregistrer" name="register" />
												</td>
											</tr>
										</table>
									</form>
								<?php
							}
							else
							{
								quit('Vous ne pouvez corriger cette astuce, elle est prise en charge par <a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_verif_auth['correction_by_id'].'">'.$req_verif_auth['pseudo'].'</a>');
							}
						
						break;
						
						case "t" :
						
							$sql_verif_auth = mysql_query("
											SELECT site_tutoriel.correction_by_id, site_membres.pseudo
											FROM site_tutoriel
											LEFT JOIN site_membres ON site_tutoriel.correction_by_id = site_membres.id
											WHERE site_tutoriel.id = '".$id."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_verif_auth = mysql_fetch_assoc($sql_verif_auth);
							
							if($req_verif_auth['correction_by_id'] == $_SESSION['membre_id'])
							{
								if(isset($_POST['register']))
								{
									$text = add_SQL($_POST['textarea']);
									if(!empty($_POST['valider']))
									{
										$valider = ", valid = '1'";
									}
									else
									{
										$valider = ", valid = '0'";
									}
									
									$update = mysql_query("
												UPDATE site_tutoriel
												SET text = '".$text."', correction_time = ".time()." ".$valider."
												WHERE id = '".$id."'")
									or ErrorSQL(__FILE__,__LINE__);
									
									if($update)
									{
										echo '<div id="information">Le tutoriel a bien été modifié.';
										if(!empty($_POST['valider']))
										{
											echo ' Le tutoriel a bien été validé.</div>';
										}
										else
										{
											echo '</div>';
										}
									}
									else
									{
										echo '<div id="erreur">Il y a eu une erreur lors de la modification du tutoriel.</div>';
									}
									echo '<br/><hr/><br/><br/>';
								}
								$sql_tutoriel = mysql_query("
												SELECT id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time
												FROM site_tutoriel
												WHERE id ='".$id."'")
								or ErrorSQl(__FILE__,__LINE__);
								$req_tutoriel = mysql_fetch_assoc($sql_tutoriel);
								
								echo '<p align="center">';
								if(date("H") >= 17 OR date("H") <= 7) {
									echo 'Bonsoir ';
								}
								else {
									echo 'Bonjour ';
								}
								echo $_SESSION['membre_pseudo'].', vous corriger actuellement le tutoriel n°<strong>'.$req_tutoriel['id'].'</strong> de <strong>'.$req_tutoriel['auteur'].'</strong>';
								echo '<br/><hr/><br/>';
								?>
									<form method="post" action="#">
										<table style="margin:auto;">
											<tr>
												<td align="center">
													<?php
														include('../includes/haut_bbcode.php');
													?>
													<label for="textarea">Le tutoriel :</label><br/>
													<textarea name="textarea" id="textarea" cols="70" rows="15" ><?php echo stripslashes($req_tutoriel['text']); ?></textarea>
													<?php
														$f = true; include('../includes/bas_bbcode.php');
													?>
												</td>
											</tr>
											<tr>
												<td align="center">
													<input type="checkbox" value="valider" name="valider" 
													<?php if($req_tutoriel['valid'] == 1){ echo 'checked="checked"'; }?>
													/><label for="valider">Cocher cette case pour valider l'astuce.</label>
												</td>
											</tr>
											<tr>
												<td align="center">
													<input type="submit" value="Enregistrer" name="register" />
												</td>
											</tr>
										</table>
									</form>
								<?php
							}
							else
							{
								quit('Vous ne pouvez corriger ce tutoriel, il est pris en charge par <a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_verif_auth['correction_by_id'].'">'.$req_verif_auth['pseudo'].'</a>');
							}
						
						break;
					}
				}
				else
				{
					quit('Lien corrumpu.');
				}
				?>
			</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
		
	break;
	
	default :
	
		$titre .= ' - interface';
		$titre2 .= ' - Interface';
		include('../includes/haut.php');
		
		$sql_membre_occuper = mysql_query("SELECT membre_occuper
											FROM site_membres_config
											WHERE membre_id = '".$_SESSION['membre_id']."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req_membre_occuper = mysql_fetch_assoc($sql_membre_occuper);
		//$req_membre_occuper = mysql_fetch_array($sql_membre_occuper);
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Interface des astuce').'
					'.fil_ariane(2, 'astuce/?correc=correc', 'Interface des corrections');				
				?>
				</div>
				<br/>
				<h1><?php echo $titre2; ?></h1>
				<br/>
				<p align="center">
				<?php
				if(date("H") >= 17 OR date("H") <= 7)
				{
					echo 'Bonsoir';
				}
				else
				{
					echo 'Bonjour';
				}
				echo ' '.$_SESSION['membre_pseudo'];
				if($req_membre_occuper['membre_occuper'] == 0) // Si le membre n'est pas occuper
				{
					echo ' vous n\'avez aucune astuce ni tutoriel en cours de correction.';
				}
				elseif($req_membre_occuper['membre_occuper'] == 1) // Si le membre est occuper, soit il a une astuce, soit un tuto en cours
				{
					echo ' vous avez soit une astuce soit un tutoriel en cours de correction.';
				}
				else //Sinon il a les deux
				{
					echo ' vous avez une astuce et un tutoriel en cours de correction.';
				}
				?>
				</p>
				<table class="liste_membre" width="100%">
					<thead>
						<tr>
							<th class="liste_membre"><strong>ID</strong></th>
							<th class="liste_membre"><strong>Jeu</strong></th>
							<th class="liste_membre"><strong>Console</strong></th>
							<th class="liste_membre" width="25%"><strong>Première lettre du jeu</strong></th>
							<th class="liste_membre"><strong>Auteur</strong></th>
							<th class="liste_membre" width="15%"><strong>La corriger</strong></th>
							<th class="liste_membre"><strong>Abandonner</strong></th>
						</tr>
					</thead>
					<tbody>
				<?php
					$sql_listing_a = mysql_query("SELECT id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time
												FROM site_astuce											
												WHERE correction_by_id = '".$_SESSION['membre_id']."'")
					or ErrorSQL(__FILE__,__LINE__);
					
					$sql_listing_t = mysql_query("SELECT id, auteur, console, jeu, jeu_first_letter, type,
												text, time, valid,
												correction_by_id, correction_time
												FROM site_tutoriel
												WHERE correction_by_id = '".$_SESSION['membre_id']."'")
					or ErrorSQL(__FILE__,__LINE__);
					
					echo '<tr>
							<td class="liste_membreth" colspan="7">Astuce</td>
						</tr>';
					if(mysql_num_rows($sql_listing_a) > 0)
					{
						while($req_listing_a = mysql_fetch_array($sql_listing_a))
						{
							$sql_membre_id_a = mysql_query("SELECT id
												FROM site_membres
												WHERE pseudo = '".$req_listing_a['auteur']."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_membre_id_a = mysql_fetch_assoc($sql_membre_id_a);
							
						echo '<tr>
								<td class="liste_membre">'.$req_listing_a['id'].'</td>
								<td class="liste_membre">'.$req_listing_a['jeu'].'</td>
								<td class="liste_membre">'.$req_listing_a['console'].'</td>
								<td class="liste_membre">'.$req_listing_a['jeu_first_letter'].'</td>
								<td class="liste_membre"><a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_membre_id_a['id'].'">'.$req_listing_a['auteur'].'</a></td>
								<td class="liste_membre"><a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=update&amp;id='.$req_listing_a['id'].'&amp;t=a">La corriger</a></td>
								<td class="liste_membre"><a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=unselect&amp;id='.$req_listing_a['id'].'&amp;t=a">Abandonner</a></td>
							</tr>
						';
						}
					}
					else
					{
						echo '<tr>
							<td class="liste_membre" colspan="7">Vous corriger actuellement aucune astuce.<br/>
								<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select">Cliquer ici pour voir les astuces en attente de validation et correction.</a></td>
							</tr>';
					}
					
					echo '<tr>
							<td class="liste_membreth" colspan="7">Tutoriel</td>
						</tr>';
					if(mysql_num_rows($sql_listing_t) > 0)
					{
						while($req_listing_t = mysql_fetch_array($sql_listing_t))
						{
							$sql_membre_id_t = mysql_query("SELECT id
												FROM site_membres
												WHERE pseudo = '".$req_listing_t['auteur']."'")
							or ErrorSQL(__FILE__,__LINE__);
							$req_membre_id_t = mysql_fetch_assoc($sql_membre_id_t);
							
						echo '<tr>
								<td class="liste_membre">'.$req_listing_t['id'].'</td>
								<td class="liste_membre">'.$req_listing_t['jeu'].'</td>
								<td class="liste_membre">'.$req_listing_t['console'].'</td>
								<td class="liste_membre">'.$req_listing_t['jeu_first_letter'].'</td>
								<td class="liste_membre"><a href="'.ROOTPATH.'/?page=membre&amp;id='.$req_membre_id_t['id'].'">'.$req_listing_t['auteur'].'</a></td>
								<td class="liste_membre"><a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=update&amp;id='.$req_listing_t['id'].'&amp;t=t">La corriger</a></td>
								<td class="liste_membre"><a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=unselect&amp;id='.$req_listing_t['id'].'&amp;t=t">Abandonner</a></td>
							</tr>
						';
						}
					}
					else
					{
						echo '<tr>
							<td class="liste_membre" colspan="7">Vous corriger actuellement aucun tutoriel.<br/>
								<a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select">Cliquer ici pour voir les tutoriels en attente de validation et correction.</a></td>
							</tr>';
					}
				?>
					</tbody>
				</table>
			</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre code pin : 45848230 -->
		<?php
		
	break;
}
?>