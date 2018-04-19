<?php
/*
page/contact.php

Page de contact
*/

/* Titre de la page */
$titre = 'Contact';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Contact';
/******************************************************/

/* Haut de la page, contient le doctype, charset, etc... */
include('includes/haut.php');
/*********************************************************/
?>
<div class="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<?php
			if(isset($_GET['form']))
			{
				if($_GET['form'] == 'support')
				{
				?>
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=contact', 'Contact').' '.fil_ariane(2, '', 'Envoie d\'un message');
				?>
				</div>
				<h1>Formulaire de Support</h1>
					<div style="margin:20px; margin-top:5px ">
						<div class="quotetitle">
							<input id="spoiler" type="button" value="Exemple" style="width:80px;font-size:10px;margin:0px;padding:0px;" 
							onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = 'Exemple'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Exemple'; }" />
						</div>
						<div class="quotecontent">
							<div style="display: none;">
								Sujet : Support<br/><br/>
								Message : Bonjour / Bonsoir. J'ai rencontré un problème {endroit de votre problème}.<br/>
								{ Ici vous exposer votre problème }<br/><br/>
								Cordialement, {pseudo}.<br/><br/>
								
								Cette exemple est fait pour les problèmes similaires au(x) problème(s) d'inscription par exemple.
							</div>
						</div>
					</div>
				<?php
					echo '<a href="'.ROOTPATH.'/?page=contact">Retour ...</a>';
					if(isset($_POST['support']))
					{
						if(!isset($_SESSION['membre_id']))
						{
							if(empty($_POST['pseudo']))
							{
								$erreur = "Vous n'avez pas entrez de pseudo.";
							}
							elseif(!preg_match('#^(?:[-]|[[:alnum:]])*$#', $_POST['pseudo']))
							{
								$erreur = "Votre pseudo ne doit pas contenir des caractères spéciaux (ex : <,>,. et etc)";
							}
							elseif(empty($_POST['email']))
							{
								$erreur = "Vous n'avez pas entrez d'adresse mail.";
							}
							elseif(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $_POST['email'])) // Email Invalide
							{
								$erreur = "L'adresse email <strong>".htmlspecialchars($_POST['email'], ENT_QUOTES)."</strong> n'est pas valide.";
							}
							elseif(empty($_POST['sujet']))
							{
								$erreur = "Vous n'avez pas entrez de sujet.";
							}
							elseif(empty($_POST['message']))
							{
								$erreur = "Vous n'avez pas entrez de message.";
							}
							else
							{
								$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
								$_POST['email'] = htmlspecialchars($_POST['email']);
								$_POST['sujet'] = htmlspecialchars($_POST['sujet']);
								$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
								if(isset($_POST['copy']))
								{
									$copy = true;
									$sent = 'Une copie vous a été envoyé.';
								}
								else
								{
									$copy = false;
								}
								if(contact_mail($_POST['pseudo'], $_POST['email'], $_POST['sujet'], '', '', $_POST['message'], $copy))
								{
									echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
								}
								else
								{
									echo '<div id="erreur">Le mail n\'a pas été envoyé.</div>';
								}
							}
						}
						elseif(empty($_POST['sujet']))
						{
							$erreur = "Vous n'avez pas entrez de sujet.";
						}
						elseif(empty($_POST['message']))
						{
							$erreur = "Vous n'avez pas entrez de message.";
						}
						else
						{
							$sql = mysql_query("SELECT membre_mail FROM site_membres WHERE membre_pseudo = '".$_SESSION['membre_pseudo']."'") or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
							$req = mysql_fetch_assoc($sql);
							$_POST['sujet'] = htmlspecialchars($_POST['sujet']);
							$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
							if(isset($_POST['copy']))
							{
								$copy = true;
								$sent = 'Une copie vous a été envoyé.';
							}
							else
							{
								$copy = false;
							}
							if(contact_mail($_SESSION['membre_pseudo'], $req['membre_mail'], $_POST['sujet'], '', '', $_POST['message'], $copy))
							{
								echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
							}
							else
							{
								echo '<div id="erreur">Le mail n\'a pas été envoyé.</div>';
							}
						}
						echo '<span class="erreur">'.$erreur.'</span>';
					}
				?>
					<form method="post" action="">
						<table style="margin:auto;">
						<?php
						if(!isset($_SESSION['membre_id']))
						{
						?>
							<tr>
								<td align="center"><label for="pseudo">Pseudo :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="pseudo" class="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="email">Email :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; }?>" /></td>
							</tr>
						<?php
						}
						?>
							<tr>
								<td align="center"><label for="sujet">Sujet :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="sujet" id="sujet" value="<?php if(!empty($_POST['sujet'])) { echo $_POST['sujet']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="message">Message :</label></td>
							</tr>
							<tr>
								<td align="center"><textarea name="message" id="message" cols="70" rows="10"><?php if(!empty($_POST['message'])) { echo $_POST['message']; }?></textarea></td>
							</tr>
							<tr>
								<td align="center"><input type="checkbox" name="copy" id="copy" /><label for="copy">Voulez-vous recevoir une copie du mail ?</label></td>
							</tr>
							<tr>
								<td align="center"><input type="submit" value="Envoyer" name="support" /></td>
							</tr>
						</table>
					</form>
				<?php
				}
				elseif($_GET['form'] == 'contact')
				{
				?>
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=contact', 'Contact').' '.fil_ariane(2, '', 'Envoie d\'un message');
				?>
				</div>
				<h1>Formulaire de Contact</h1>
				<div style="margin:20px; margin-top:5px">
					<div class="quotetitle">
						<input type="button" value="Exemple" style="width:80px; font-size:10px; margin:0px; padding:0px;"
						onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = 'Exemple'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Exemple'; }" />
					</div>
					<div class="quotecontent">
						<div style="display:none;">
						Sujet : Contact<br/><br/>
						Message : { Mettre votre message de contact }.<br/>
						</div>
					</div>
				</div>
				<?php
					if(isset($_POST['contact']))
					{
						if(!isset($_SESSION['membre_id']))
						{
							if(empty($_POST['pseudo']))
							{
								$erreur = "Vous n'avez pas entrez de pseudo.";
							}
							elseif(!preg_match('#^(?:[-]|[[:alnum:]])*$#', $_POST['pseudo']))
							{
								$erreur = "Votre pseudo ne doit pas contenir des caractères spéciaux (ex : <,>,. et etc)";
							}
							elseif(empty($_POST['email']))
							{
								$erreur = "Vous n'avez pas entrez d'adresse mail.";
							}
							elseif(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $_POST['email'])) // Email Invalide
							{
								$erreur = "L'adresse email <strong>".htmlspecialchars($_POST['email'], ENT_QUOTES)."</strong> n'est pas valide.";
							}
							elseif(empty($_POST['sujet']))
							{
								$erreur = "Vous n'avez pas entrez de sujet.";
							}
							elseif(empty($_POST['message']))
							{
								$erreur = "Vous n'avez pas entrez de message.";
							}
							else
							{
								$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
								$_POST['email'] = htmlspecialchars($_POST['email']);
								$_POST['sujet'] = htmlspecialchars($_POST['sujet']);
								$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
								if(isset($_POST['copy']))
								{
									$copy = true;
									$sent = 'Une copie vous a été envoyé.';
								}
								else
								{
									$copy = false;
								}
								if(contact_mail($_POST['membre_pseudo'], $_POST['email'], $_POST['sujet'], '', '', $_POST['message'], $copy))
								{
									echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
								}
								else
								{
									echo '<div id="erreur">Le mail n\'a pas été envoyé.</div>';
								}
							}
						}
						elseif(empty($_POST['sujet']))
						{
							$erreur = "Vous n'avez pas entrez de sujet.";
						}
						elseif(empty($_POST['message']))
						{
							$erreur = "Vous n'avez pas entrez de message.";
						}
						else
						{
							$sql = mysql_query("SELECT membre_mail FROM site_membres WHERE membre_pseudo = '".$_SESSION['membre_pseudo']."'") or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
							$req = mysql_fetch_assoc($sql);
							$_POST['sujet'] = htmlspecialchars($_POST['sujet']);
							$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
							if(isset($_POST['copy']))
							{
								$copy = true;
								$sent = 'Une copie vous a été envoyé.';
							}
							else
							{
								$copy = false;
							}
							if(contact_mail($_SESSION['membre_pseudo'], $req['membre_mail'], $_POST['sujet'], '', '', $_POST['message'], $copy))
							{
								echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
							}
							else
							{
								echo '<div id="erreur">Le mail n\'a pas été envoyé.</div>';
							}
						}
						echo '<span class="erreur">'.$erreur.'</span>';
					}
					echo '<a href="'.ROOTPATH.'/?page=contact">Retour ...</a>';
				?>
					<form method="post" action="">
						<table style="margin:auto;">
						<?php
						if(!isset($_SESSION['membre_id']))
						{
						?>
							<tr>
								<td align="center"><label for="pseudo">Pseudo :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="pseudo" class="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="email">Email :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; }?>" /></td>
							</tr>
						<?php
						}
						?>
							<tr>
								<td align="center"><label for="sujet">Sujet :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="sujet" id="sujet" value="<?php if(!empty($_POST['sujet'])) { echo $_POST['sujet']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="message">Message :</label></td>
							</tr>
							<tr>
								<td align="center"><textarea name="message" id="message" cols="70" rows="10"><?php if(!empty($_POST['message'])) { echo $_POST['message']; }?></textarea></td>
							</tr>
							<tr>
								<td align="center"><input type="checkbox" name="copy" id="copy" /><label for="copy">Voulez-vous recevoir une copie du mail ?</label></td>
							</tr>
							<tr>
								<td align="center"><input type="submit" value="Envoyer" name="contact" /></td>
							</tr>
						</table>
					</form>
				<?php
				}
				elseif($_GET['form'] == 'suggestion_idee')
				{
				?>
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=contact', 'Contact').' '.fil_ariane(2, '', 'Envoie d\'un message');
				?>
				</div>
				<h1>Formulaire de Suggestion / idée</h1>
					<div style="margin:20px; margin-top:5px">
						<div class="quotetitle">
							<input type="button" value="Exemple" style="width:80px; font-size:10px; margin:0px; padding:0px;"
							onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = 'Exemple'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Exemple'; }" />
						</div>
						<div class="quotecontent">
							<div style="display:none;">
							Sujet : Suggestion / idée<br/><br/>
							Message : Bonjour / Bonsoir. J'ai eu une petite idée { titre de l'idée }.<br/>
							{ Ici vous exposer votre suggestion / idée }<br/>
							Cordialement, {pseudo}.<br/>
							</div>
						</div>
					</div>
				<?php
					if(isset($_POST['sugg_idee']))
					{
						if(!isset($_SESSION['membre_id']))
						{
							if(empty($_POST['pseudo']))
							{
								$erreur = "Vous n'avez pas entrez de pseudo.";
							}
							elseif(!preg_match('#^(?:[-]|[[:alnum:]])*$#', $_POST['pseudo']))
							{
								$erreur = "Votre pseudo ne doit pas contenir des caractères spéciaux (ex : <,>,. et etc)";
							}
							elseif(empty($_POST['email']))
							{
								$erreur = "Vous n'avez pas entrez d'adresse mail.";
							}
							elseif(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $_POST['email'])) // Email Invalide
							{
								$erreur = "L'adresse email <strong>".htmlspecialchars($_POST['email'], ENT_QUOTES)."</strong> n'est pas valide.";
							}
							elseif(empty($_POST['sug_idee']))
							{
								$erreur = "Vous n'avez pas précisé votre Suggestion ou Idée.";
							}
							elseif(empty($_POST['message']))
							{
								$erreur = "Vous n'avez pas entrez de message.";
							}
							else
							{
								$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
								$_POST['email'] = htmlspecialchars($_POST['email']);
								$_POST['sug_idee'] = htmlspecialchars($_POST['sug_idee']);
								$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
								if(isset($_POST['copy']))
								{
									$copy = true;
									$sent = 'Une copie vous a été envoyé.';
								}
								else
								{
									$copy = false;
								}
								if(contact_mail($_POST['membre_pseudo'], $_POST['email'], $_POST['sug_idee'], '', '', $_POST['message'], $copy))
								{
									echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
								}
								else
								{
									echo '<div id="erreur">Le mail n\'a pas été envoyé.</div>';
								}
							}
						}
						elseif(empty($_POST['sug_idee']))
						{
							$erreur = "Vous n'avez pas précisé votre Suggestion ou Idée.";
						}
						elseif(empty($_POST['message']))
						{
							$erreur = "Vous n'avez pas entrez de message.";
						}
						else
						{
							$sql = mysql_query("SELECT membre_mail FROM site_membres WHERE membre_pseudo = '".$_SESSION['membre_pseudo']."'") or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
							$req = mysql_fetch_assoc($sql);
							$_POST['sug_idee'] = htmlspecialchars($_POST['sug_idee']);
							$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
							if(isset($_POST['copy']))
							{
								$copy = true;
								$sent = 'Une copie vous a été envoyé.';
							}
							else
							{
								$copy = false;
							}
							if(contact_mail($_SESSION['membre_pseudo'], $req['membre_mail'], $_POST['sug_idee'], '', '', $_POST['message'], $copy))
							{
								echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
							}
							else
							{
								echo '<div id="erreur">Le mail n\'a pas été envoyé.</div>';
							}
						}
						echo '<span class="erreur">'.$erreur.'</span>';
					}
					echo '<a href="'.ROOTPATH.'/?page=contact">Retour ...</a>';
				?>
					<form method="post" action="">
						<table style="margin:auto;">
						<?php
						if(!isset($_SESSION['membre_id']))
						{
						?>
							<tr>
								<td align="center"><label for="pseudo">Pseudo :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="pseudo" class="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="email">Email :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; }?>" /></td>
							</tr>
						<?php
						}
						?>
							<tr>
								<td align="center"><label for="sug_idee">Suggestion ou idée :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="sug_idee" id="sug_idee" value="<?php if(!empty($_POST['sug_idee'])) { echo $_POST['sug_idee']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="message">Message :</label></td>
							</tr>
							<tr>
								<td align="center"><textarea name="message" id="message" cols="70" rows="10"><?php if(!empty($_POST['message'])) { echo $_POST['message']; }?></textarea></td>
							</tr>
							<tr>
								<td align="center"><input type="checkbox" name="copy" id="copy" /><label for="copy">Voulez-vous recevoir une copie du mail ?</label></td>
							</tr>
							<tr>
								<td align="center"><input type="submit" value="Envoyer" name="sugg_idee" /></td>
							</tr>
						</table>
					</form>
				<?php
				}
				elseif($_GET['form'] == 'astuce')
				{
				?>
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=contact', 'Contact').' '.fil_ariane(2, '', 'Envoie d\'un message');
				?>
				</div>
				<h1>Formulaire d'ajout d'astuce.</h1>
					<div style="margin:20px; margin-top:5px">
						<div class="quotetitle">
							<input type="button" value="Exemple" style="width:80px; font-size:10px; margin:0px; padding:0px;"
							onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = 'Exemple'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Exemple'; }" />
						</div>
						<div class="quotecontent">
							<div style="display:none;">
							Sujet : Ajouts Astuce<br/><br/>
							Message : Bonjour / Bonsoir. Je viens pour faire un ajout d'{ Astuce }.<br/>
							<br/>
							Console : { Mettre le nom de la console si besoin }.<br/>
							Jeux : { Mettre le titre du jeux si besoin }.<br/>
							{ Astuce : } { Poster l'astuce <ins>en entière</ins> }.<br/>
							</div>
						</div>
					</div>
				<?php
					if(isset($_POST['astuce']))
					{
						if(!isset($_SESSION['membre_id']))
						{
							if(empty($_POST['pseudo']))
							{
								$erreur = "Vous n'avez pas entrez de pseudo.";
							}
							elseif(!preg_match('#^(?:[-]|[[:alnum:]])*$#', $_POST['pseudo']))
							{
								$erreur = "Votre pseudo ne doit pas contenir des caractères spéciaux (ex : <,>,. et etc)";
							}
							elseif(empty($_POST['email']))
							{
								$erreur = "Vous n'avez pas entrez d'adresse mail.";
							}
							elseif(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $_POST['email'])) // Email Invalide
							{
								$erreur = "L'adresse email <strong>".htmlspecialchars($_POST['email'], ENT_QUOTES)."</strong> n'est pas valide.";
							}
							elseif(empty($_POST['console']))
							{
								$erreur = "Vous n'avez pas entrez de console.";
							}
							elseif(empty($_POST['jeux']))
							{
								$erreur = "Vous n'avez pas entrez le jeu de l'astuce.";
							}
							elseif(empty($_POST['message']))
							{
								$erreur = "Vous n'avez pas entrez de message.";
							}
							else
							{
								$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
								$_POST['email'] = htmlspecialchars($_POST['email']);
								$_POST['console'] = htmlspecialchars($_POST['console']);
								$_POST['jeux'] = htmlspecialchars($_POST['jeux']);
								$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
								if(isset($_POST['copy']))
								{
									$copy = true;
									$sent = 'Une copie vous a été envoyé.';
								}
								else
								{
									$copy = false;
								}
								if(contact_mail($_POST['membre_pseudo'], $_POST['email'], 'Ajout d\'astuce', $_POST['jeux'], $_POST['console'], $_POST['message'], $copy))
								{
									echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
								}
								else
								{
									echo '<div id="erreur">Le mail n\'a pas été envoyé.</div>';
								}
							}
						}
						elseif(empty($_POST['console']))
						{
							$erreur = "Vous n'avez pas entrez de console.";
						}
						elseif(empty($_POST['jeux']))
						{
							$erreur = "Vous n'avez pas entrez le jeu de l'astuce.";
						}
						elseif(empty($_POST['message']))
						{
							$erreur = "Vous n'avez pas entrez de message.";
						}
						else
						{
							$sql = mysql_query("SELECT membre_mail FROM site_membres WHERE membre_pseudo = '".$_SESSION['membre_pseudo']."'") or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
							$req = mysql_fetch_assoc($sql);
							$_POST['console'] = htmlspecialchars($_POST['console']);
							$_POST['jeux'] = htmlspecialchars($_POST['jeux']);
							$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
							if(isset($_POST['copy']))
							{
								$copy = true;
								$sent = 'Une copie vous a été envoyé.';
							}
							else
							{
								$copy = false;
							}
							if(contact_mail($_SESSION['membre_pseudo'], $req['membre_mail'], 'Ajout d\'astuce', $_POST['jeux'], $_POST['console'], $_POST['message'], $copy))
							{
								echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
							}
							else
							{
								echo '<div id="erreur">Le mail n\'a pas été envoyé.</div>';
							}
						}
					}
					echo '<a href="'.ROOTPATH.'/?page=contact">Retour ...</a>';
				?>
					<form method="post" action="">
						<table style="margin:auto;">
						<?php
						if(!isset($_SESSION['membre_id']))
						{
						?>
							<tr>
								<td align="center"><label for="pseudo">Pseudo :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="pseudo" class="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="email">Email :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; }?>" /></td>
							</tr>
						<?php
						}
						?>
							<tr>
								<td align="center"><label for="titre_astuce">Titre de l'astuce (pas obligatoire) :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="titre_astuce" id="titre_astuce" value="<?php if(!empty($_POST['titre_astuce'])) { echo $_POST['titre_astuce']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="console">Console :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="console" id="console" value="<?php if(!empty($_POST['console'])) { echo $_POST['console']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="jeux">Jeu :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="jeux" id="jeux" value="<?php if(!empty($_POST['jeux'])) { echo $_POST['jeux']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="message">Message :</label></td>
							</tr>
							<tr>
								<td align="center"><textarea name="message" id="message" cols="70" rows="10"><?php if(!empty($_POST['message'])) { echo $_POST['message']; }?></textarea></td>
							</tr>
							<tr>
								<td align="center"><input type="checkbox" name="copy" id="copy" /><label for="copy">Voulez-vous recevoir une copie du mail ?</label></td>
							</tr>
							<tr>
								<td align="center"><input type="submit" value="Envoyer" name="astuce" /></td>
							</tr>
						</table>
					</form>
				<?php
				}
				elseif($_GET['form'] == 'tutoriel')
				{
				?>
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=contact', 'Contact').' '.fil_ariane(2, '', 'Envoie d\'un message');
				?>
				</div>
				<h1>Formulaire d'ajout de tutoriel.</h1>
					<div style="margin:20px; margin-top:5px">
						<div class="quotetitle">
							<input type="button" value="Exemple" style="width:80px; font-size:10px; margin:0px; padding:0px;"
							onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = 'Exemple'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Exemple'; }" />
						</div>
						<div class="quotecontent">
							<div style="display:none;">
							Sujet : Ajouts Tutoriel<br/><br/>
							Message : Bonjour / Bonsoir. Je viens pour faire un ajout de { Tutoriel }.<br/>
							<br/>
							Console : { Mettre le nom de la console si besoin }.<br/>
							Jeux : { Mettre le titre du jeux si besoin }.<br/>
							{ Tutoriel : } { Poster le tutoriel <ins>en entier</ins> }.<br/>
							</div>
						</div>
					</div>
				<?php
					if(isset($_POST['tutoriel']))
					{
						if(!isset($_SESSION['membre_id']))
						{
							if(empty($_POST['pseudo']))
							{
								$erreur = "Vous n'avez pas entrez de pseudo.";
							}
							elseif(!preg_match('#^(?:[-]|[[:alnum:]])*$#', $_POST['pseudo']))
							{
								$erreur = "Votre pseudo ne doit pas contenir des caractères spéciaux (ex : <,>,. et etc)";
							}
							elseif(empty($_POST['email']))
							{
								$erreur = "Vous n'avez pas entrez d'adresse mail.";
							}
							elseif(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $_POST['email'])) // Email Invalide
							{
								$erreur = "L'adresse email <strong>".htmlspecialchars($_POST['email'], ENT_QUOTES)."</strong> n'est pas valide.";
							}
							elseif(empty($_POST['console']))
							{
								$erreur = "Vous n'avez pas entrez de console.";
							}
							elseif(empty($_POST['jeux']))
							{
								$erreur = "Vous n'avez pas entrez le jeu du tutoriel.";
							}
							elseif(empty($_POST['message']))
							{
								$erreur = "Vous n'avez pas entrez de message.";
							}
							else
							{
								$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
								$_POST['email'] = htmlspecialchars($_POST['email']);
								$_POST['console'] = htmlspecialchars($_POST['console']);
								$_POST['jeux'] = htmlspecialchars($_POST['jeux']);
								$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
								if(isset($_POST['copy']))
								{
									$copy = true;
									$sent = 'Une copie vous a été envoyé.';
								}
								else
								{
									$copy = false;
								}
								if(contact_mail($_POST['pseudo'], $_POST['email'], 'Ajout de tutoriel', $_POST['jeux'], $_POST['console'], $_POST['message'], $copy))
								{
									echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
								}
							}
						}
						elseif(empty($_POST['console']))
						{
							$erreur = "Vous n'avez pas entrez de console.";
						}
						elseif(empty($_POST['jeux']))
						{
							$erreur = "Vous n'avez pas entrez le jeu du tutoriel";
						}
						elseif(empty($_POST['message']))
						{
							$erreur = "Vous n'avez pas entrez de message.";
						}
						else
						{
							$sql = mysql_query("SELECT membre_mail FROM site_membres WHERE membre_pseudo = '".$_SESSION['membre_pseudo']."'") or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
							$req = mysql_fetch_assoc($sql);
							$_POST['console'] = htmlspecialchars($_POST['console']);
							$_POST['jeux'] = htmlspecialchars($_POST['jeux']);
							$_POST['message'] = stripslashes(htmlspecialchars($_POST['message']));
							if(isset($_POST['copy']))
							{
								$copy = true;
								$sent = 'Une copie vous a été envoyé.';
							}
							else
							{
								$copy = false;
							}
							if(contact_mail($_SESSION['membre_pseudo'], $req['membre_mail'], 'Ajout de tutoriel', $_POST['jeux'], $_POST['console'], $_POST['message'], $copy))
							{
								echo '<div id="information">Le mail a bien été envoyé. '.$sent.'</div>';
							}
							else
							{
								echo '<div id="erreur">Le mail n\'a pas été envoyé.</div>';
							}
						}
					}
					echo '<a href="'.ROOTPATH.'/?page=contact">Retour ...</a>';
				?>
					<form method="post" action="">
						<table style="margin:auto;">
						<?php
						if(!isset($_SESSION['membre_id']))
						{
						?>
							<tr>
								<td align="center"><label for="pseudo">Pseudo :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="pseudo" class="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="email">Email :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; }?>" /></td>
							</tr>
						<?php
						}
						?>
							<tr>
								<td align="center"><label for="titre_tuto">Titre du tutoriel (pas obligatoire) :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="titre_tuto" id="titre_tuto" value="<?php if(!empty($_POST['titre_tuto'])) { echo $_POST['titre_tuto']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="console">Console :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="console" id="console" value="<?php if(!empty($_POST['console'])) { echo $_POST['console']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="jeux">Jeu :</label></td>
							</tr>
							<tr>
								<td align="center"><input type="text" name="jeux" id="jeux" value="<?php if(!empty($_POST['jeux'])) { echo $_POST['jeux']; }?>" /></td>
							</tr>
							<tr>
								<td align="center"><label for="message">Message :</label></td>
							</tr>
							<tr>
								<td align="center"><textarea name="message" id="message" cols="70" rows="10"><?php if(!empty($_POST['message'])) { echo $_POST['message']; }?></textarea></td>
							</tr>
							<tr>
								<td align="center"><input type="checkbox" name="copy" id="copy" /><label for="copy">Voulez-vous recevoir une copie du mail ?</label></td>
							</tr>
							<tr>
								<td align="center"><input type="submit" value="Envoyer" name="tutoriel" /></td>
							</tr>
						</table>
					</form>
				<?php
				}
				else
				{
					echo 'Aucun formulaire sélectionner<br/>';
					echo '<a href="'.ROOTPATH.'/?page=contact">Retour ...</a>';
				}
			}
			else
			{
			?>
			<div id="fil_ariane">
			<?php
				echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '', 'Contact');
			?>
			</div>
			<h1>Contact</h1>
			<?php

			$texte = "Un problème ? Vous voulez faire part d'une suggestion ? Ou autre ? Alors contactez le webmaster via le formulaire ci-dessous, en expliquant ce que vous voulez, avec un sujet explicite ;).";
				echo '<p>'.parseZCode($texte).'</p>';
			?>
			<form method="post" action="">
				<table style="margin:auto">
					<tr>
						<td align="center">
							<select name="formulaire" onchange="window.location.href='<?php echo ROOTPATH; ?>/?page=contact&amp;form=' + this.options[this.selectedIndex].value">
							<option value="none" class="selected" selected="selected">Formulaire</option>
							<option value="support">Support</option>
							<option value="contact">Contact</option>
							<option value="suggestion_idee">Suggestion / Idée</option>
							<option value="astuce">Astuce</option>
							<option value="tutoriel">Tutoriel</option>
							</select>
						</td>
					</tr>
				</table>
			</form>
			<?php
			}
			?>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->