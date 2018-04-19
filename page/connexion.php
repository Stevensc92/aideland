<?php
/**
 *
 * page/connexion.php
 *
 * Permet de se connecter au site
 *
 **/

/* Titre de la page */
$titre = 'Connexion';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Connexion';
/******************************************************/


if(isset($_SESSION['membre_pseudo']))
{
	$informations = array( /* Membre déjà connecter */
					true,
					'Connexion impossible',
					'La connexion est impossible car vous êtes déjà connecté sous le pseudo <strong>'.$_SESSION['membre_pseudo'].'</strong>',
					' - <a href="'.ROOTPATH.'">Index</a>',
					'',
					3,
					);
	require_once('information.php');
	exit();
}

if(isset($_POST['connexion']))
{
	$pseudo = trim(add_SQL($_POST['pseudo']));
	$password = trim(add_SQL($_POST['password']));
	$sql = "SELECT COUNT(*) AS nbr FROM site_membres WHERE pseudo = '".$pseudo."'";
	$req = mysql_query($sql) or ErrorSQL(__FILE__,__LINE__);
	$data = mysql_fetch_assoc($req);
	if($data['nbr'] == 1)
	{	
		$sql2 = "SELECT * FROM site_membres WHERE pseudo = '".$pseudo."'";
		$req2 = mysql_query($sql2) or ErrorSQL(__FILE__,__LINE__);
		$data2 = mysql_fetch_assoc($req2);
		
		if($data2['rang'] == 0)
		{
			$informations = array( /* Membre bannis */
							true,
							'Vous avez été bannis.',
							'Vous avez été bannis de '.TITRESITE.', en voilà la raison : <br/><br/><p><em><strong>'.htmlspecialchars($data2['bannis_raison']).'</strong></em></p>',
							'',
							ROOTPATH,
							3
							);
			require_once('information.php');
			exit();
		}
		elseif($data2['valider'] == 0)
		{
			$informations = array( /* Membre non valider */
							true,
							'Vous n\'avez pas validé votre compte.',
							'Vous n\'avez pas validé votre compte.<br/> Si vous n\'aviez pas reçu de mail contenant votre lien d\'activation, contactez le Webmaster du site.',
							'',
							ROOTPATH.'/?page=contact',
							5
							);
			require_once('information.php');
			exit();
		}
		elseif(md5($password) == $data2['mdp'])
		{
			$_SESSION['membre_id'] = $data2['id'];
			$_SESSION['membre_pseudo'] = $data2['pseudo'];
			$_SESSION['membre_mdp'] = $data2['mdp'];
			$_SESSION['membre_rang'] = $data2['rang'];
			$_SESSION['membre_groupe'] = $data2['groupe'];
			$_SESSION['membre_bannis_raison'] = $data2['bannis_raison'];
			$_SESSION['membre_inscription'] = $data2['inscription'];
			$_SESSION['membre_sexe'] = $data2['sexe'];
			$_SESSION['membre_level'] = 2;
			unset($_SESSION['connexion_pseudo']);
			
			if(isset($_POST['cookie']) && $_POST['cookie'] == 'on')
			{
				setcookie('membre_id', $data2['id'], time()+365*24*3600);
				setcookie('membre_mdp', $data2['mdp'], time()+365*24*3600);
			}
			
			$informations = array( /* Connexion réussie */
							false,
							'Connexion réussie',
							'Vous êtes désormais connecté sous le pseudo <strong><em>'.htmlspecialchars($_SESSION['membre_pseudo'], ENT_QUOTES).'</em></strong>.',
							'',
							ROOTPATH,
							3
							);
			require_once('information.php');
			exit();
		}
		else
		{
			$informations = array( /* Mot de passe incorrect */
							true,
							'Mot de passe incorect',
							'Vous avez fourni un mot de passe incorrecte.',
							' - <a href="'.ROOTPATH.'">Index</a>',
							ROOTPATH.'/?page=connexion',
							3
							);
			require_once('information.php');
			exit();
		}
	}
	elseif($data['nbr'] > 1)
	{
		$informations = array( /* Pseudo doublon */
						true,
						'Doublon',
						'Deux membres ou plus ont le même pseudo, contactez le webmaster pour régler le problème.',
						' - <a href="'.ROOTPATH.'">Index</a>',
						ROOTPATH.'/?page=contact',
						3,
						);
		require_once('information.php');
		exit();
	}
	else
	{
		$informations = array( /* Pseudo inexistant */
						true,
						'Pseudo inexistant',
						'Le pseudo <strong>'.htmlspecialchars($pseudo).'</strong> n\'existe pas. Veuillez réessayer.',
						' - <a href="'.ROOTPATH.'">Index</a>',
						ROOTPATH.'/?page=connexion',
						3
						);
		require_once('information.php');
		exit();
	}
}
else
{
	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php');
	/*********************************************************/
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '', 'Connexion');
				?>
				</div>
				<form method="post">
					<table style="margin:auto;">
						<tr>
							<td align="center"><input type="text" name="pseudo" value="Votre pseudo" onfocus="if(this.value=='Votre pseudo')this.value='';" onblur="if(this.value=='')this.value='Votre pseudo';" /></td>
						</tr>
						<tr>
							<td align="center"><input type="password" name="password" value="motdepasse" onfocus="if(this.value=='motdepasse')this.value='';" onblur="if(this.value=='')this.value='motdepasse';" /></td>
						</tr>
						<tr>
							<td align="center"><input type="checkbox" name="cookie" value="cookie" /> <label for="cookie">Connexion automatique</label></td>
						</tr>
						<tr>
							<td align="center"><input type="submit" value="Me connecter" name="connexion" /></td>
						</tr>
					</table>
				</form>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
}
?>