<?php
/*
page/connexion.php

Permet de se connecter au site
*/

/* Titre de la page */
$titre = 'Connexion';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Connexion';
/******************************************************/

if(isset($_SESSION['membre_pseudo']))
{
	$informations = array( /*Si la personne est connecter, elle ne peut se reconnecter */
					true,
					'Connexion impossible',
					'La connexion est impossible, vous êtes déjà connecté sous le pseudo <strong><em>'.htmlspecialchars($_SESSION['membre_pseudo'], ENT_QUOTES).'</em></strong>.',
					' - <a href="'.ROOTPATH.'">Index</a>',
					ROOTPATH,
					3,
					'Connexion impossible'
					);
	require_once('information.php');
	exit();
}
if(!isset($_POST['connexion']))
{
	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php');
	/*********************************************************/
?>
<div id="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php
				echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '', 'Connexion');
			?>
			</div>
				<h1>Connexion</h1>
				<form method="post" name="connexion">
					<table style="margin : auto;">
						<tr>
							<td><input type="text" name="pseudo" id="pseudo" value="Pseudo" onfocus="if(this.value=='Pseudo')this.value='';" onblur="if(!this.value)this.value='Pseudo';" /></td>
						</tr>
						<tr>
							<td><input type="password" name="mdp" id="mdp" value="password" onfocus="if(this.value=='password')this.value='';" onblur="if(!this.value)this.value='password';" /></td>
						</tr>
							<td><input type="checkbox" name="cookie" id="cookie"/> <label for="cookie">Connexion automatique</label></td>
						</tr>
						<tr>
							<td><input type="submit" name="connexion" value="Me connecter" /></td>
						</tr>
						<tr>
							<td><a href="<?php echo ROOTPATH; ?>/?page=inscription">Pas encore inscrit ?</a> - <a href="<?php echo ROOTPATH; ?>/?page=mon_compte&amp;mod=reset">Mot de passe oublié</a></td>
						</tr>
					</table>
				</form>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre --> 
<div class="clear"></div><!-- NE PAS SUPPRIMER -->
<?php
}
else
{
	$sql = mysql_query("SELECT COUNT(*) 
						AS nbr, membre_id, membre_pseudo, membre_mdp, membre_rang, membre_valider, membre_groupe, membre_sexe, membre_inscription 
						FROM site_membres 
						WHERE membre_pseudo = '".mysql_real_escape_string($_POST['pseudo'])."' 
						GROUP BY membre_id")
						or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
	$result = mysql_fetch_array($sql);
	$sql2 = mysql_query("SELECT COUNT(*) 
						AS membre_rang 
						FROM forum_membres 
						WHERE membre_pseudo = '".mysql_real_escape_string($_POST['pseudo'])."' 
						GROUP BY membre_id") 
						or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
	$result2 = mysql_fetch_array($sql2);
	$sql3 = mysql_query("SELECT membre_bannis_raison
						 FROM site_membres
						 WHERE membre_pseudo = '".mysql_real_escape_string($_POST['pseudo'])."'")
						 or exit ('Fichier : '.__FILE__.'<br />Ligne : '.__LINE__.'<br />Erreur sql : '.mysql_error());
	$result3 = mysql_fetch_assoc($sql3);
	if($result['nbr'] == 1)
	{		
		if($result['membre_rang'] == 0)
		{
			$informations = array( /* Membre banni */
							true,
							'Connexion impossible',
							'La connexion est impossible, vous avez été bannis du site pour la raison suivante : <br/>
							<strong><em>'.htmlspecialchars(stripslashes($result3['membre_bannis_raison'])).'.</em></strong> <br/>Contactez le webmaster du site pour plus d\'information.',
							' - <a href="'.ROOTPATH.'/?page=contact">Contacter le webmaster</a>',
							ROOTPATH,
							3,
							'Connexion impossible'
							);
			require_once('information.php');
			exit();
		}
		if($result['membre_valider'] == 0)
		{
			$informations = array( /* Membre non validé */
							true,
							'Connexion impossible',
							'La connexion est impossible, vous n\'avez pas valider votre compte.',
							' - <a href="'.ROOTPATH.'">Index</a>',
							ROOTPATH,
							3,
							'Connexion impossible'
							);
			require_once('information.php');
			exit();
		}
		if(md5($_POST['mdp']) == $result['membre_mdp'])
		{
			$_SESSION['membre_id'] = $result['membre_id'];
			$_SESSION['membre_pseudo'] = $result['membre_pseudo'];
			$_SESSION['membre_mdp'] = $result['membre_mdp'];
			$_SESSION['membre_sexe'] = $result['membre_sexe'];
			$_SESSION['membre_groupe'] = $result['membre_groupe'];
			$_SESSION['membre_inscription'] = $result['membre_inscription'];
			$_SESSION['level'] = 2;
			unset($_SESSION['connexion_pseudo']);
						
			if(isset($_POST['cookie']) && $_POST['cookie'] == 'on')
			{
				setcookie('membre_id', $result['membre_id'], time()+365*24*3600);
				setcookie('membre_mdp', $result['membre_mdp'], time()+365*24*3600);
			}
			
			$informations = Array(/*Vous êtes bien connecté*/
							false,
							'Connexion réussie',
							'Vous êtes désormais connecté sous le pseudo <strong><em>'.htmlspecialchars($_SESSION['membre_pseudo'], ENT_QUOTES).'</em></strong>.',
							'',
							$_SERVER['PHP_SELF'],
							3,
							'Connexion réussie'
							);
			require_once('information.php');
			exit();
		}
					
		else
		{
			$_SESSION['connexion_pseudo'] = $_POST['pseudo'];
			$informations = Array(/*Erreur de mot de passe*/
							true,
							'Mauvais mot de passe',
							'Vous avez fourni un mot de passe incorrect.',
							' - <a href="'.ROOTPATH.'">Index</a>',
							ROOTPATH.'/?page=connexion',
							3,
							'Mauvais mot de passe'
							);
			require_once('information.php');
			exit();
		}
	}		
	else if($result['nbr'] > 1)
	{
		$informations = Array(/*Erreur de pseudo doublon (normalement impossible)*/
						true,
						'Doublon',
						'Deux membres ou plus ont le même pseudo, contactez le webmaster pour régler le problème.',
						' - <a href="'.ROOTPATH.'">Index</a>',
						ROOTPATH.'/?page=contact',
						3,
						'Doublon'
						);
		require_once('information.php');
		exit();
	}
				
	else
	{
		$informations = Array(/*Pseudo inconnu*/
						true,
						'Pseudo inconnu',
						'Le pseudo <strong><em>'.htmlspecialchars($_POST['pseudo'], ENT_QUOTES).'</em></strong> n\'existe pas. Vous avez probablement fait une erreur.',
						' - <a href="'.ROOTPATH.'">Index</a>',
						ROOTPATH.'/?page=connexion',
						3,
						'Pseudo inconnu'
						);
		require_once('information.php');
		exit();
	}
}
?>