<?php
/*
page/livreor.php

Livre d'or du site
*/

// Titre de la page 
$titre = 'Livre d\'or';

// Définition du TITRE du CADRE du contenu de la page
$titre2 = 'Livre d\'or';

// Haut de la page, contient le doctype, charset, etc...

include('includes/haut.php');
if(isset($_GET['a']) && $_GET['a'] == "supprimer" && isset($_GET['mess']))
{
	if(isset($_SESSION['membre_id']))
	{
		$sql_rank = mysql_query("SELECT rang FROM site_membres WHERE id = '".$_SESSION['membre_id']."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req_rank = mysql_fetch_assoc($sql_rank);
		if($req_rank['rang'] != '100')
		{
			$info_commande = array('true', 'acces_not_denied');
			require_once('information.php');
			exit();
		}
		$id = intval($_GET['mess']);
		$delete = mysql_query("DELETE FROM site_livre_or 
							   WHERE id = '".$id."'") 
							   or ErrorSQL(__FILE__,__LINE__);
		if($delete)
		{
			echo '<div id="information">Le message n°'.$id.' a bien été supprimer.</div>';
		}
		else
		{
			echo '<div id="erreur">Le message n°'.$id.' n\'a pas été supprimer.</div>';
		}
	}	
	else
	{
		$info_commande = array('true', 'acces_not_denied');
		require_once('information.php');
		exit();
	}
}
if(isset($_POST['add_mess']))
{
	if(!isset($_SESSION['membre_id']))
	{
		if(isset($_POST['captcha'])) $_POST['captcha'] = strtoupper($_POST['captcha']);
		if(empty($_POST['pseudo']))
		{
			$erreur = 'Vous n\'avez pas entrez de pseudo.';
		}
		elseif(empty($_POST['texte']))
		{
			$erreur = 'Vous n\'avez pas entrez de texte.';
		}
		elseif(empty($_POST['captcha']))
		{
			$erreur = "Vous n'avez pas recopier le code.";
		}
		elseif($_POST['captcha'] != $_SESSION['aleat_nbr'])
		{
			$erreur = "Le code recopier, ne correspond pas à l'image, veuillez recommencer.";
		}
		else
		{
			$pseudo = mysql_real_escape_string($_POST['pseudo']);
			$message = mysql_real_escape_string($_POST['texte']);
			$add = mysql_query("INSERT INTO site_livre_or VALUES ('', '".$pseudo."', '".$message."', ".time().")") or ErrorSQL(__FILE__,__LINE__);
			if($add)
			{
				echo '<div id="information">Le message a bien été ajouté.</div>';
			}
			else
			{
				echo '<div id="erreur">Le message n\'a pas été ajouté.</div>';
			}
		}
	}
	else
	{
		if(isset($_POST['captcha'])) $_POST['captcha'] = strtoupper($_POST['captcha']);
		if(empty($_POST['texte']))
		{
			$erreur = 'Vous n\'avez pas entrez de texte.';
		}
		elseif(empty($_POST['captcha']))
		{
			$erreur = "Vous n'avez pas recopier le code.";
		}
		elseif($_POST['captcha'] != $_SESSION['aleat_nbr'])
		{
			$erreur = "Le code recopier, ne correspond pas à l'image, veuillez recommencer.";
		}
		else
		{
			$message = mysql_real_escape_string($_POST['texte']);
			$add = mysql_query("INSERT INTO site_livre_or VALUES ('', '".$_SESSION['membre_pseudo']."', '".$message."', ".time().")") or ErrorSQL(__FILE__,__LINE__);
			if($add)
			{
				echo '<div id="information">Le message a bien été ajouté.</div>';
			}
			else
			{
				echo '<div id="erreur">Le message n\'a pas été ajouté.</div>';
			}
		}
	}
}
?>
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
						<div id="fil_ariane">
						<?php
							echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '', 'Livre d\'Or');
						?>
						</div>
						<h1>Livre d'or</h1>
						<fieldset>
							<legend>Ajouter un message</legend>
							<form method="post" action="">
								<table style="margin:auto;">
									<?php
									if(!isset($_SESSION['membre_id']))
									{
									?>
									<tr>
										<td align="center"><label for="pseudo">Votre pseudo :</label></td>
									</tr>
									<tr>
										<td align="center"><input type="text" name="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo htmlspecialchars($_POST['pseudo'], ENT_QUOTES); }?>" /></td>
									</tr>
									<?php
									}
									?>
									<tr>
										<td align="center"><label for="textarea">Texte :</label></td>
									</tr>
									<tr>
										<td align="center">
											<?php include('includes/haut_bbcode.php'); ?>
											<textarea name="texte" id="textarea" cols="70" rows="10" ><?php if(!empty($_POST['texte'])) {echo $_POST['texte'];}?></textarea>
											<?php include('includes/bas_bbcode.php'); ?>
										</td>
									</tr>
									<tr>
										<td align="center"><label for="captcha">Recopier le code :</label></td>
									</tr>
									<tr>
										<td align="center">
											<input type="text" name="captcha" id="captcha" /><img src="page/captcha.php" alt="Captcha anti-bot" title="Captcha anti_bot"/>
											<span id="refreshCaptcha">
												<input type="submit" value=" " id="refresh" title="Rafraîchir" />
											</span>
										</td>
									</tr>
									<tr>
										<td align="center"><input type="submit" name="add_mess" id="add_mess" value="Envoyer" /></td>
									</tr>
								</table>
							</form>
						</fieldset>
					</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre --> 
			<div id="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
						<?php
						$nb_mess_page = 10;
						$sql = mysql_query("SELECT COUNT(*) AS nbr_mess FROM site_livre_or") or ErrorSQL(__FILE__,__LINE__);
						$req = mysql_fetch_array($sql);
						$nb_mess = $req['nbr_mess'];
						$nb_page = ceil($nb_mess / $nb_mess_page);
						echo '<span class="p">';
						if(isset($_GET['p']))
						{
							$page = $_GET['p'];
						}
						else
						{
							$page = 1;
						}
						if(isset($_GET['p']) && $_GET['p'] != 1)
						{
							$i = $_GET['p'] - 1;
							echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=livreor&amp;p='.$i.'">Précédente</a></span> ';
						}
						echo 'Page : |';
						for($i=1; $i <= $nb_page; $i++)
						{
							if($i == $page) //On ne met pas de lien sur la page actuelle
							{
								echo ' <span class="page_a">'.$i.'</span> |';
							}
							else
							{
								echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=livreor&amp;p='.$i.'">'.$i.'</a></span> |';
							}
						}
						if($nb_page != 1)
						{
							if(!isset($_GET['p']))
							{
								$i = +2;
								echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=livreor&amp;p='.$i.'">Suivante</a></span>';
							}
							elseif(isset($_GET['p']) && $_GET['p'] != $nb_page)
							{
								$i = $_GET['p'] + 1;
								echo ' <span class="p_lien"><a href="'.ROOTPATH.'/?page=livreor&amp;p='.$i.'">Suivante</a></span>';
							}
						}
						echo '</span>';
						$first_mess = ($page - 1) * $nb_mess_page;
						?>
						<fieldset>
							<legend>Les commentaires poster :</legend>
							<br/>
							<?php
							$sql2 = mysql_query("SELECT * FROM site_livre_or ORDER BY id DESC LIMIT ".$first_mess.", ".$nb_mess_page."") or ErrorSQL(__FILE__,__LINE__);
							if(mysql_num_rows($sql2) < 1)
							{
								echo 'Pas de message.';
							}
							else
							{
								while($req2 = mysql_fetch_array($sql2))
								{
									if(isset($_SESSION['membre_pseudo']))
									{
										$reponse = mysql_query("SELECT rang, pseudo FROM site_membres WHERE id=".$_SESSION['membre_id']."") or ErrorSQL(__FILE__,__LINE__);
										$donnees = mysql_fetch_array($reponse);
									}
									if(isset($donnees['rang']) && $donnees['rang'] == 100)
									{
										$supprimer = '(<a href="'.ROOTPATH.'/?page=livreor&amp;a=supprimer&amp;mess='.$req2['id'].'" onclick="confirm(\'Ête vous sûr de vouloir supprimer ce message ?\')" >Supprimer</a>)';
									}
									else
									{
										$supprimer = '';
									}
									echo '<fieldset>';
										echo '<legend>Poster par <strong>'.stripslashes($req2['auteur']).'</strong> : <span class="news_inf">'.mepd($req2['time']).'</span> '.$supprimer.'</legend>';
										echo parseZCode($req2['message']);
									echo '</fieldset>';
									echo '<br/>';
								}
							}
							?>
						</fieldset>
					</div>
				<div class="nb"></div> <!-- Fin news -->
			</div><!-- Fin centre -->