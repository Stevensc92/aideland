<?php
/*
page/inscription.php

L'inscription au site
*/

/* Titre de la page */
$titre = 'Inscription';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Inscription';
/******************************************************/

if(isset($_SESSION['membre_pseudo']))
{
	$informations = array( /*Si la personne est connecter, elle ne peut s'inscrire */
					true,
					'Inscription impossible',
					'L\'inscription est impossible, vous êtes déjà connecté sous le pseudo <strong>'.htmlspecialchars($_SESSION['membre_pseudo'], ENT_QUOTES).'</strong>.',
					' - <a href="'.ROOTPATH.'">Index</a>',
					ROOTPATH,
					5,
					'Inscription impossible'
					);
	require_once('information.php');
	exit();
}
$sql3 = mysql_query("SELECT COUNT(*)
					AS nbr3
					FROM site_membres
					WHERE ip = '".$_SERVER['REMOTE_ADDR']."'")
					or ErrorSQL(__FILE__,__LINE__);
$result3 = mysql_fetch_array($sql3);
if($result3['nbr3'] >= 2) /* Si la personne s'est déjà inscrite trois fois avec son adresse IP. */
{
	$informations = array(
					true,
					'Inscription impossible',
					'L\'inscription est impossible. Contacter le webmaster du site pour plus d\'information.',
					' - <a href="'.ROOTPATH.'/?page=contact">Contacter le Webmaster</a>',
					ROOTPATH,
					5,
					'Inscription impossible'
					);
	require_once('information.php');
	exit();
}
else
{

/* Traitement des données du formulaire */
if(isset($_POST['inscription'])) // On commence par vérifier si le formulaire à été soumis.
{
	/* Modifications des variables */
	// Trim retire les espaces en début et fin de chaîne, et stripslashes retire les blackslash => \' deviens '
	$pseudo = trim(add_SQL($_POST['pseudo']));
	$email = trim(add_SQL($_POST['email']));
	$mdp = trim(add_SQL($_POST['mdp']));
	$mdp_verif = trim(add_SQL($_POST['mdp_verif']));
	$mdp_hash = md5(add_SQL($_POST['mdp']));
	$captcha = strtoupper(add_SQL($_POST['captcha']));
	$day = trim(add_SQL($_POST['days']));
	$mounth = trim(add_SQL($_POST['mounth']));
	$annees = trim(add_SQL($_POST['annees']));
	$cgu = !empty($_POST['cgu'])?trim(add_SQL($_POST['cgu'])):'';
	$sexe = trim(add_SQL($_POST['sexe']));
	/*************************************/

	/* Vérification de tout les champs */
	$sql = mysql_query("SELECT COUNT(*)
						AS nbr
						FROM site_membres
						WHERE pseudo = '".mysql_real_escape_string($pseudo)."'")
						or ErrorSQL(__FILE__,__LINE__);
	$result = mysql_fetch_array($sql);

	$sql2 = mysql_query("SELECT COUNT(*)
						AS nbr2
						FROM site_membres
						WHERE mail = '".mysql_real_escape_string($email)."'")
						or ErrorSQL(__FILE__,__LINE__);
	$result2 = mysql_fetch_array($sql2);
	if(empty($pseudo)) // Pseudo non fourni
	{
		$erreur = "Vous n'avez pas choisi de pseudo.";
	}
	elseif(strlen($pseudo) <= 4 OR strlen($pseudo) >=12) // Pseudo trop petit ou trop grand
	{
		$erreur = "Le pseudo <strong>".htmlspecialchars($pseudo, ENT_QUOTES)."</strong> est soit trop petit soit trop grand.";
	}
	elseif($result['nbr'] >0) // Pseudo existant
	{
		$erreur = "Le pseudo <strong>".htmlspecialchars($pseudo, ENT_QUOTES)."</strong> est déjà utilisé.";
	}
	elseif(!preg_match('#^(?:[-]|[[:alnum:]])*$#', $pseudo))
	{
		$erreur = "Votre pseudo ne doit pas contenir des caractères spéciaux (ex : <,>,. et etc)";
	}
	elseif(empty($email)) // Email non fourni
	{
		$erreur = "Vous n'avez pas entrez votre adresse email.";
	}
	elseif(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $email)) // Email Invalide
	{
		$erreur = "L'adresse email <strong>".htmlspecialchars($email, ENT_QUOTES)."</strong> n'est pas valide.";
	}
	elseif($result2['nbr2'] >0)
	{
		$erreur = "L'adresse email <strong>".htmlspecialchars($email, ENT_QUOTES)."</strong> est déjà utilisé.";
	}
	elseif(empty($mdp)) // Mdp non Fourni
	{
		$erreur = "Vous n'avez pas choisi de mot de passe.";
	}
	elseif(strlen($mdp) <= 6 OR strlen($mdp) >= 15) // Mdp trop petit ou trop grand
	{
		$erreur = "Le mot de passe <strong>".htmlspecialchars($mdp, ENT_QUOTES)."</strong> est soit trop petit soit trop grand.";
	}
	elseif(empty($mdp_verif)) // Confirmation non fourni
	{
		$erreur = "Vous n'avez pas confirmer le mot de passe.";
	}
	elseif($mdp != $mdp_verif) // Mdp différent
	{
		$erreur = "Votre mot de passe et sa confirmation sont différents.";
	}
	elseif($day == 'none' OR $mounth == 'none' OR $annees == 'none') // Date de naissance non fournisse
	{
		$erreur = "Vous n'avez pas précisé le jour, le mois ou l'année de votre date de naissance.";
	}
	elseif($day == '29' AND $mounth == '2') // 29 Février en année non bissextile
	{
		$bissextile = array('1952', '1956', '1960', '1964', '1968', '1972', '1976', '1980', '1984', '1988', '1992', '1996', '2000', '2004', '2008');
		if(!in_array($annees, $bissextile))
		{
			$erreur = "La date de naissance est fausse, le 29 février n'existe que pour une année bissextile.";
		}
	}
	elseif($day >= '30' AND $mounth == '2') // 30 ou 31 février bissextile ou non
	{
		$bisextile = array('1952', '1956', '1960', '1964', '1968', '1972', '1976', '1980', '1984', '1988', '1992', '1996', '2000', '2004', '2008');
		if(!in_array($annees, $bisextile) OR in_array($annees, $bisextile))
		{
			$erreur = "La date de naissance est fausse, le ".$day." février n'existe pas.";
		}
	}
	elseif($day > '30' AND $mounth == '4') // 31, avril, juin, septembre, octobre n'existe pas
	{
		$mounth_t = array('1' => 'janvier', '2' => 'février', '3' => 'mars', '4' => 'avril', '5' => 'mai', '6' => 'juin', '7' => 'juillet', '8' => 'août', '9' => 'septembre', '10' => 'novembre', '11' => 'octobre', '12' => 'décembre');
		$erreur = "La date de naissance est fausse, le ".$day." ".$mounth_t[$mounth]." n'existe pas.";
	}
	elseif($day > '30' AND $mounth == '6')
	{
		$mounth_t = array('1' => 'janvier', '2' => 'février', '3' => 'mars', '4' => 'avril', '5' => 'mai', '6' => 'juin', '7' => 'juillet', '8' => 'août', '9' => 'septembre', '10' => 'novembre', '11' => 'octobre', '12' => 'décembre');
		$erreur = "La date de naissance est fausse, le ".$day." ".$mounth_t[$mounth]." n'existe pas.";
	}
	elseif($day > '30' AND $mounth == '9')
	{
		$mounth_t = array('1' => 'janvier', '2' => 'février', '3' => 'mars', '4' => 'avril', '5' => 'mai', '6' => 'juin', '7' => 'juillet', '8' => 'août', '9' => 'septembre', '10' => 'novembre', '11' => 'octobre', '12' => 'décembre');
		$erreur = "La date de naissance est fausse, le ".$day." ".$mounth_t[$mounth]." n'existe pas.";
	}
	elseif($day > '30' AND $mounth == '11')
	{
		$mounth_t = array('1' => 'janvier', '2' => 'février', '3' => 'mars', '4' => 'avril', '5' => 'mai', '6' => 'juin', '7' => 'juillet', '8' => 'août', '9' => 'septembre', '10' => 'novembre', '11' => 'octobre', '12' => 'décembre');
		$erreur = "La date de naissance est fausse, le ".$day." ".$mounth_t[$mounth]." n'existe pas.";
	}
	elseif($sexe == '') // sexe non spécifié
	{
		$erreur = "Vous n'avez préciser votre sexe.";
	}
	elseif(empty($cgu)) // cgu non accepté
	{
		$erreur = "Vous n'avez pas accepter les <a href=\"".ROOTPATH."/?page=cgu\" target=\"_blank\">conditions générales d'utilisations</a> de Help World.";
	}
	elseif(empty($captcha))
	{
		$erreur = "Vous n'avez pas recopier le code.";
	}
	elseif($captcha != $_SESSION['aleat_nbr'])
	{
		$erreur = "Le code recopier, ne correspond pas à l'image, veuillez recommencer.";
	}
	/***********************************/
	else
	{
		$mdp_hash = md5($mdp);
		$days = array('1' => '01', '2' => '02', '3' => '03', '4' => '04', '5' => '05', '6' => '06', '7' => '07', '8' => '08', '9' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31');
		$mounth_t = array('1' => '01', '2' => '02', '3' => '03', '4' => '04', '5' => '05', '6' => '06', '7' => '07', '8' => '08', '9' => '09', '10' => '10', '11' => '11', '12' => '12');
		$insertion = mysql_query("INSERT INTO site_membres(pseudo, mdp, mail, inscription, naissance, sexe, derniere_visite)
									VALUES('".$pseudo."', '".$mdp_hash."',
									'".$email."', ".time().",
									'".$days[$day]."/".$mounth_t[$mounth]."/".$annees."', '".$sexe."',
									".time().")")
		or ErrorSQL(__FILE__,__LINE__);
		$nouveau_membre = mysql_insert_id();
		if($insertion)
		{
			if(inscription_mail($email, $pseudo, $mdp)) $sent = "Un email contenant un lien d'activation vous a été envoyer.";
			else $sent = "Un email contenant un lien d'activation aurait dû vous être envoyé, mais son envoi a échoué, cependant, vous êtes bien inscrit.<br/>Contacter le Webmaster du site pour pouvoir obtenir votre lien d\'activation.";
			// On envoie un petit message privé de bienvenue
			mysql_query("INSERT INTO site_mp(mp_expediteur, mp_receveur, mp_titre, mp_text, mp_time)
						 VALUES('1', '".$nouveau_membre."', 'Bienvenue sur Help World',
						 'Bienvenue ".$pseudo.", l\'équipe d\'Help World est heureuse de vous accueillir.
						 Bonne navigation sur Help World et n\'oubliez pas d\'aller vous présenter
						 sur le forum [url=".ROOTPATH."/forum/?view=forum&f=1]ici[/url]\n\rCordialement, l\'équipe Help World.', ".time().")")
			or ErrorSQL(__FILE__,__LINE__);
			// On ajoute une entrée sur la configuration du membre
			mysql_query("INSERT INTO site_membres_config(membre_id)
						 VALUES('".$nouveau_membre."')")
			or ErrorSQL(__FILE__,__LINE__);

			$informations = array( /* Inscription réussi */
							false,
							'Inscription réussie',
							'Inscription réussie. '.$sent.'',
							' - <a href="'.ROOTPATH.'/?page=connexion">Se connecter</a>',
							ROOTPATH,
							3,
							);
			require_once('information.php');
			exit();
		}
		else
		{
			$informations = array( /* Inscription échoué */
							true,
							'Inscription échoué',
							'Inscription échoué, veuillez recommencer. Si l\'erreur persiste, contacter le Webmaster.',
							' - <a href="'.ROOTPATH.'/?page=inscription">Réessayer</a>',
							ROOTPATH.'?page=inscription',
							5,
							'Inscription échoué'
							);
			require_once('information.php');
			exit();
		}
	}
}
/* Haut de la page, contient le doctype, charset, etc... */
include('includes/haut.php');
/*********************************************************/
?>
<!-- DÉBUT CONTNEU DE LA PAGE -->
<div class="content"><!-- Début centre -->
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php
				echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?page=inscription', 'Inscription');
			?>
			</div>
			<h1>Inscription</h1>
			<?php
				if(isset($erreur))
				{
					echo '<span class="erreur">'.$erreur.'</span><br/>';
				}
			?>
			<form method="post" action="">
				<div style="margin:auto;">
				<table style="margin:auto;">
					<tr>
						<td><label for="pseudo">Pseudo : *</label></td>
						<td><input type="text" name="pseudo" id="pseudo"
						<?php
						if(!empty($pseudo)) // Si le pseudo a été spécifier, on le réaffiche en cas d'erreur
						{
							echo "value=\"".htmlspecialchars($pseudo,ENT_QUOTES)."\"";
						}
						?> tabindex="1" /> <em>(4 à 12 caractères,<br/> lettre (miniscules et majuscules), chiffre et tiret d'union autorisé)</em></td>
					</tr>
					<tr>
						<td><label for="email">Adresse email : *</label></td>
						<td><input type="text" name="email" id="email"
						<?php
						if(!empty($email)) // Si l'email a été spécifier, on le réaffiche en cas d'erreur
						{
							echo "value=\"".htmlspecialchars($email,ENT_QUOTES)."\"";
						}
						?> tabindex="2"/> <em>(Email valide !)</em></td>
					</tr>
					<tr>
						<td><label for="mdp">Mot de passe : *</label></td>
						<td><input type="password" name="mdp" id="mdp"
						<?php
						if(!empty($mdp)) // Si le mot de passe a été spécifier, on le réaffiche en cas d'erreur
						{
							echo "value=\"".htmlspecialchars($mdp,ENT_QUOTES)."\"";
						}
						?> tabindex="3" /> <em>(6 à 15 caractères)</em></td>
					</tr>
					<tr>
						<td><label for="mdp_verif">Confirmer le mot de passe : *</label></td>
						<td><input type="password" name="mdp_verif" id="mdp_verif" tabindex="4"/></td>
					</tr>
					<tr>
						<td><label>Date de Naissance : *</label></td>
						<td>
							<label for="days">Jour</label> :
							<select name="days" id="days" tabindex="5">
								<optgroup label="Jour">
									<option value="none" class="selected" selected="selected">Jour</option>
									<?php
									for($days=1; $days <= 31; $days++)
									{
										echo '<option value="'.$days.'">'.$days.'</option>';
									}
									?>
								</optgroup>
							</select>
							<label for="mounth">Mois</label> :
							<select name="mounth" id="mounth" tabindex="6">
								<optgroup label="Mois">
									<option value="none" class="selected" selected="selected">Mois</option>
									<?php
									$mounth = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
									for($m=1; $m <=12; $m++)
									{
										echo '<option value="'.$m.'">'.$mounth[$m-1].'</option>';
									}
									?>
								</optgroup>
							</select>
							<label for="annees">Année</label> :
							<select name="annees" id="annees" tabindex="7">
								<optgroup label="Année">
									<option value="none" class="selected" selected="selected">Année</option>
									<?php
									for($annees=1999; $annees >=1950; $annees--)
									{
										echo '<option value="'.$annees.'">'.$annees.'</option>';
									}
									?>
								</optgroup>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="sexe">Sexe : *</label></td>
						<td>
							<select name="sexe" id="sexe" tabindex="8">
								<optgroup label="Sexe">
									<option value=""></option>
									<?php
									$sexe = array('Masculin', 'Féminin');
									for($s=1; $s <=2; $s++)
									{
										echo '<option value="'.$sexe[$s-1].'">'.$sexe[$s-1].'</option>';
									}
									?>
								</optgroup>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="checkbox" name="cgu" id="cgu" tabindex="9" /><label for="cgu">En cochant cette case, je certifie avoir pris connaissance des <a href="<?php echo ROOTPATH; ?>/?page=cgu" target="blanck">Conditions Générales d'Utilisation</a> de Help World.</label></td>
					</tr>
					<tr>
						<td><label for="captcha">Recopier le code :</label></td>
						<td>
							<input type="text" name="captcha" id="captcha" /><img src="page/captcha.php" alt="Captcha anti-bot" title="Captcha anti_bot"/>
							<span id="refreshCaptcha">
								<input type="submit" value=" " id="refresh" title="Rafraîchir" />
							</span>
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="Valider mon inscription" name="inscription" id="inscription" tabindex="10" /></td>
						<td><input type="reset" value="Recommencer" name="effacer" id="effacer" tabindex="11" onclick="return confirm('Êtes vous sûr de vouloir recommencer votre inscription ?\n\rAucun retour ne sera possible.')" /></td>
					</tr>
				</table><br/><br/>
				<span style="font-size : 12px; font-style:italic;">Note : Les champs noter d'une * sont obligatoire.</span>
				</div>
			</form>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->
<?php
}
?>
