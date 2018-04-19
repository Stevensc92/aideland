<?php
/*
page/friends.php

Gestion des amis des membre
*/

if(!isset($_SESSION['membre_id']))
{
	$info_commande = array('true', 'acces_not_connect');
	require_once('information.php');
	exit();
}
else
{
	/* Titre de la page */
	$titre = 'Gestion des amis';
	/********************/
		
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Gestion des amis';
	/******************************************************/
	
	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php');
	/*********************************************************/
?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '', 'Gestion des amis'); ?>
				</div>
				<?php
				if(isset($_POST['friend']))
				{
					$pseudo_d = mysql_real_escape_string($_POST['pseudo']);
					$requete = mysql_query("SELECT id, COUNT(*) AS nbr 
											FROM site_membres 
											WHERE pseudo = '".$pseudo_d."'
											GROUP BY pseudo") 
											or ErrorSQL(__FILE__,__LINE__);
					$data = mysql_fetch_assoc($requete);
					$pseudo_exist = $data['nbr'];
					$i = 0;
					if(!$pseudo_exist)
					{
						echo '<div id="erreur">Ce membre ne semble pas exister.</div>';
						$i++;
					}
					$deja_ami = mysql_result(mysql_query("SELECT COUNT(*) AS nbr 
														FROM site_amis 
														WHERE ami_from = '".intval($_SESSION['membre_id'])."' AND ami_to = '".$data['id']."'
														OR ami_to = '".intval($_SESSION['membre_id'])."' AND ami_from = '".$data['id']."'"),0);
					if($deja_ami != 0)
					{
						echo '<div id="erreur">Ce membre fait soit déjà partie de vos amis, soit vous lui avez envoyé une demande, soit vous en avez reçu une de lui.</div>';
						$i++;
					}
					if($data['id'] == $_SESSION['membre_id'])
					{
						echo '<div id="erreur">Vous ne pouvez pas vous ajouter vous même.</div>';
						$i++;
					}		
					if($i == 0)
					{
						mysql_query("INSERT INTO site_amis (ami_from, ami_to, ami_confirm, ami_date)
									VALUES('".$_SESSION['membre_id']."', '".$data['id']."', '0', '".time()."')")
						or ErrorSQL(__FILE__,__LINE__);;						
						echo '<div id="information"><a href="'.ROOTPATH.'/?page=membre&amp;id='.$data['id'].'">'.stripslashes(htmlspecialchars($pseudo_d)).'</a> a bien reçu votre demande d\'ajout en tant qu\'ami.</div>';
					}
				}
				if(isset($_GET['action']))
				{
					if($_GET['action'] == 'add')
					{
						if(!isset($_GET['m']))
						{
							quit('<div id="erreur">Impossible de continuer, veuillez réessayer.</div>');
						}
						$membre = (int) $_GET['m'];
						$sql = mysql_query("UPDATE site_amis
											SET ami_confirm = '1', ami_date_confirm = ".time()."
											WHERE ami_from = '".$membre."' AND ami_to = '".intval($_SESSION['membre_id'])."'")
											or ErrorSQL(__FILE__,__LINE__);
						if($sql)
						{
							echo '<div id="information">Le membre a bien été ajouté à votre liste d\'amis.</div>';
						}
						else
						{
							echo '<div id="erreur">Il y a eu une erreur lors de l\'ajout du membre dans votre liste d\'amis. Veuillez réessayer.</div>';
						}
					}
					elseif($_GET['action'] == 'delete')
					{
						if(!isset($_GET['m']))
						{
							quit('<div id="erreur">Impossible de continuer, veuillez réessayer.</div>');
						}
						$membre = (int) $_GET['m'];
						mysql_query('DELETE FROM site_amis 
									 WHERE ami_from = '.$membre.' AND ami_to = '.intval($_SESSION['membre_id']))
									 or ErrorSQL(__FILE__,__LINE__);
						mysql_query('DELETE FROM site_amis 
									 WHERE ami_to = '.$membre.' AND ami_from = '.intval($_SESSION['membre_id']))
									 or ErrorSQL(__FILE__,__LINE__);
						echo '<div id="information">Le membre a bien été supprimé.</div>';
					}
					elseif($_GET['action'] == 'annuler')
					{
						if(!isset($_GET['m']))
						{
							quit('<div id="erreur">Impossible de continuer, veuillez réessayer.</div>');
						}
						$membre = (int) $_GET['m'];
						mysql_query("DELETE FROM site_amis
									 WHERE ami_to = '".$membre."' AND ami_from = '".intval($_SESSION['membre_id'])."'")
									 or exit ('Fichier : '.__FILE__.'<br/>Ligne : '.__LINE__.'</br>Erreur sql : '.mysql_error());
						$sql = mysql_query("SELECT pseudo
											FROM site_membres
											WHERE id = '".$membre."'")
											or exit ('Fichier : '.__FILE__.'<br/>Ligne : '.__LINE__.'</br>Erreur sql : '.mysql_error());
						$req = mysql_fetch_assoc($sql);
						echo '<div id="information">La demande qui a été envoyé au membre <a href="'.ROOTPATH.'/?page=membre&amp;id='.$membre.'">'.$req['pseudo'].'</a> a bien été annulé.</div>';
					}
					elseif($_GET['action'] == 'new')
					{
						if(!isset($_GET['id']))
						{
							quit('<div id="erreur">Impossible de continuer, veuillez réessayer.</div>');
						}
						$pseudo_d = mysql_real_escape_string($_GET['id']);
						$requete = mysql_query("SELECT id, COUNT(*) AS nbr 
												FROM site_membres
												WHERE id = '".$pseudo_d."'
												GROUP BY id") 
						or ErrorSQL(__FILE__,__LINE__);
						$data = mysql_fetch_assoc($requete);
						$pseudo_exist = $data['nbr'];
						
						$sql_pseudo = mysql_query("SELECT pseudo
												   FROM site_membres
												   WHERE id = '".$pseudo_d."'")
						or ErrorSQL(__FILE__,__LINE__);
						$req_pseudo = mysql_fetch_assoc($sql_pseudo);
						
						$i = 0;
						if(!$pseudo_exist)
						{
							echo '<div id="erreur">Ce membre ne semble pas exister.</div>';
							$i++;
						}
						$deja_ami = mysql_result(mysql_query("SELECT COUNT(*) AS nbr 
															FROM site_amis 
															WHERE ami_from = '".intval($_SESSION['membre_id'])."' AND ami_to = '".$data['id']."'
															OR ami_to = '".intval($_SESSION['membre_id'])."' AND ami_from = '".$data['id']."'"),0);
						if($deja_ami != 0)
						{
							echo '<div id="erreur">Ce membre fait soit déjà partie de vos amis, soit vous lui avez envoyé une demande, soit vous en avez reçu une de lui.</div>';
							$i++;
						}
						if($data['id'] == $_SESSION['membre_id'])
						{
							echo '<div id="erreur">Vous ne pouvez pas vous ajouter vous même.</div>';
							$i++;
						}		
						if($i == 0)
						{
							mysql_query("INSERT INTO site_amis (ami_from, ami_to, ami_confirm, ami_date)
										VALUES('".$_SESSION['membre_id']."', '".$data['id']."', '0', '".time()."')")
										or ErrorSQL(__FILE__,__LINE__);
							mysql_query("INSERT INTO site_mp (mp_expediteur, mp_receveur, mp_titre, mp_text, mp_time)
										VALUES ('1', '".$data['id']."', 'Demande d\'ajout d\'ami', 'Bonjour ".$req_pseudo['pseudo'].", le membre ".$_SESSION['membre_pseudo']." souhaite vous ajouter à sa liste d\'ami.

										Rendez-vous [url=http://www.aide-land.fr/?page=friends]ici[/url] pour accepter ou refuser la demande.
										
										Cordialement,', ".time().")");
							echo '<div id="information"><a href="'.ROOTPATH.'/?page=membre&amp;id='.$data['id'].'">'.stripslashes(htmlspecialchars($req_pseudo['pseudo'])).'</a> a bien reçu votre demande d\'ajout en tant qu\'ami.</div>';
						}
					}
					else
					{
						echo '<div id="erreur">Arguement d\'action non renseigné.</div>';
					}
				}
				?>
				<h1>Ajouter un ami</h1>
				<form method="post">
					<table style="margin:auto;">
						<tr>
							<td><label for="pseudo">Entrez le pseudo :</label></td>
							<td><input type="text" name="pseudo" id="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo htmlspecialchars($_POST['pseudo']); } ?>" /></td>
							<td><input type="submit" value="Envoyer" name="friend" /></td>
						</tr>
					</table>
				</form>
				<h1>Vos amis</h1>
				<table class="liste_membre">
					<tr>
						<th class="liste_membre" width="25%">Pseudo</th>
						<th class="liste_membre" width="25%">Depuis</th>
						<th class="liste_membre" width="25%">Action</th>
						<th class="liste_membre" width="25%">Statut</th>
					</tr>
					<?php
					$sql = mysql_query("SELECT (ami_from + ami_to - ".intval($_SESSION['membre_id']).") AS ami_id, ami_date, ami_date_confirm, pseudo, id, connectes_id
										FROM site_amis
										LEFT JOIN site_membres ON id = (ami_from + ami_to - ".intval($_SESSION['membre_id']).")
										LEFT JOIN site_connectes ON id = connectes_id
										WHERE (ami_from = '".intval($_SESSION['membre_id'])."' OR ami_to = '".intval($_SESSION['membre_id'])."') AND ami_confirm = '1' ORDER BY pseudo")
										or ErrorSQL(__FILE__,__LINE__);
					if(mysql_num_rows($sql) == 0)
					{
					?>
					<tr>
						<td class="liste_membre" colspan="4">Vous n'avez aucun ami pour le moment</td>
					</tr>
					<?php
					}
					else
					{
						while($data = mysql_fetch_array($sql))
						{
						?>
							<tr>
								<td class="liste_membre">
									<a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data['ami_id']; ?>"><?php echo stripslashes(htmlspecialchars($data['pseudo'])); ?></a>
								</td>
								<td class="liste_membre"><?php echo mepd($data['ami_date_confirm']); ?></td>
								<td class="liste_membre">
									<a href="<?php echo ROOTPATH; ?>/?page=mp&amp;id=<?php echo $data['ami_id']; ?>">Envoyer un MP</a><br/>
									<a href="<?php echo ROOTPATH; ?>/?page=friends&amp;action=delete&m=<?php echo $data['ami_id']; ?>">Supprimer</a>
								</td>
								<td class="liste_membre">
								<?php
								if($data['connectes_id'] == $data['membre_id'])
								{
									echo '<span class="actif">En ligne</span>';
								}
								else
								{
									echo '<span class="inactif">Hors ligne</span>';
								}
								?>
								</td>
							</tr>
						<?php
						}
					}
					?>
				</table>
				<h1>Demande reçue / envoyée</h1>
				<?php
				$requete = mysql_query("SELECT ami_from, ami_date, pseudo 
										FROM site_amis
										LEFT JOIN site_membres ON id = ami_from
										WHERE ami_to = '".intval($_SESSION['membre_id'])."' AND ami_confirm = '0'
										ORDER BY ami_date DESC")
										or ErrorSQL(__FILE__,__LINE__);
				?>
				<table class="liste_membre">
					<tr>
						<th colspan="4" class="liste_membre" width="80%">Demande reçu</th>
					</tr>
					<tr>
						<th class="liste_membre">Pseudo</th>
						<th class="liste_membre">Reçu</th>
						<th class="liste_membre" colspan="2">Action</th>
					</tr>
					<?php
					if(mysql_num_rows($requete) == 0)
					{
					?>
					<tr>
						<td colspan="4" class="liste_membre">Aucune demande reçu</td>
					</tr>
					<?php
					}
					else
					{
						while($data = mysql_fetch_assoc($requete))
						{
						?>
							<tr>
								<td class="liste_membre">
									<a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data['ami_from']; ?>"><?php echo stripslashes(htmlspecialchars($data['pseudo'])); ?></a>
								</td>
								<td class="liste_membre"><?php echo mepd($data['ami_date']); ?></td>
								<td class="liste_membre" colspan="2">
									<a href="<?php echo ROOTPATH; ?>/?page=friends&amp;action=add&amp;m=<?php echo $data['ami_from']; ?>">Accepter</a> - <a href="<?php echo ROOTPATH; ?>/?page=friends&amp;action=delete&amp;m=<?php echo $data['ami_from']; ?>">Refuser</a>
								</td>
							</tr>
						<?php
						}
					}
					$requete2 = mysql_query("SELECT ami_date, ami_to, ami_from, pseudo, ami_confirm
											 FROM site_amis
											 LEFT JOIN site_membres ON id = ami_to
											 WHERE ami_from = '".intval($_SESSION['membre_id'])."'
											 ORDER BY ami_date DESC")
											 or ErrorSQL(__FILE__,__LINE__);
					?>
					<tr>
						<th colspan="4" class="liste_membre" width="80%">Demande envoyée</th>
					</tr>
					<tr>
						<th class="liste_membre">Pseudo</th>
						<th class="liste_membre">Envoyez</th>
						<th class="liste_membre">Action</th>
						<th class="liste_membre">Statut</th>
					</tr>
					<?php
					if(mysql_num_rows($requete2) == 0)
					{
					?>
					<tr>
						<td colspan="4" class="liste_membre">Aucune demande envoyée</td>
					</tr>
					<?php
					}
					else
					{
						while($data2 = mysql_fetch_array($requete2))
						{
						?>
							<tr>
								<td class="liste_membre">
									<a href="<?php echo ROOTPATH; ?>/?page=membre&amp;id=<?php echo $data2['ami_to']; ?>"><?php echo stripslashes(htmlspecialchars($data2['pseudo'])); ?></a>
								</td>
								<td class="liste_membre"><?php echo mepd($data2['ami_date']); ?></td>
								<td class="liste_membre">
									<a href="<?php echo ROOTPATH; ?>/?page=friends&amp;action=annuler&amp;m=<?php echo $data2['ami_to']; ?>">Annuler</a>
								</td>
								<td class="liste_membre">
								<?php
								if($data2['ami_confirm'] == 0)
								{
									echo '<span class="inactif">En attente</span>';
								}
								else
								{
									echo '<span class="actif">Acceptée</span>';
								}
								?>
								</td>
							</tr>
						<?php
						}
					}
					?>
				</table>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
<?php
}
?>