<?php
/*
page/mon_compte.php

Modification du compte des utilisateurs
*/
if(isset($_GET['mod']))
{
    if($_GET['mod'] == "modif")
    {
        if(!isset($_SESSION['membre_pseudo']))
        {
            $informations = array( /* Membre non connecté */
                            true,
                            'Accès impossible',
                            'Vous devez être connecter pour pouvoir accèder à cette page.<br/>',
                            ' - <a href="'.ROOTPATH.'/?page=connexion">Se connecter</a>',
                            ROOTPATH,
                            5,
                            'Accès impossible',
                            );
            require_once('information.php');
            exit();
        }
        /* Titre de la page */
        $titre = 'Modification de mon profil';
        /********************/

        /* Définition du TITRE du CADRE du contenu de la page */
        $titre2 = 'Modification de mon profil';
        /******************************************************/

        
        
        $sql = mysql_query("SELECT * 
							FROM site_membres 
							WHERE id = '".$_SESSION['membre_id']."'") 
							or ErrorSQL(__FILE__,__LINE__);
		$profil = mysql_fetch_assoc($sql);
        
        if(isset($_POST['change_mdp']))
        {
            $mdp = trim(stripslashes($_POST['new_mdp']));
            $mdp = htmlspecialchars($_POST['new_mdp']);
            if(empty($_POST['mdp']))
            {
                $erreur = 'Vous n\'avez pas préciser votre ancien mot de passe.';
            }
            elseif(md5($_POST['mdp']) != $profil['mdp'])
            {
                $erreur = 'Votre ancien mot de passe est incorrect.';
            }
            elseif(empty($_POST['new_mdp']))
            {
                $erreur = 'Vous n\'avez pas préciser un nouveau mot de passe.';
            }
            elseif(strlen($_POST['new_mdp']) <= 5 OR strlen($_POST['new_mdp']) >=25)
            {
                $erreur = 'Votre nouveau mot de passe est soit trop petit soit trop grand.';
            }
            elseif(empty($_POST['confirm_new_mdp']))
            {
                $erreur = 'Vous n\'avez pas confirmer le nouveau mot de passe.';
            }
            elseif($_POST['confirm_new_mdp'] != $_POST['new_mdp'])
            {
                $erreur = 'La confirmation du nouveau mot de passe est fausse.';
            }
            else
            {
                $update = mysql_query("UPDATE site_membres 
										SET valider = '0', mdp = '".md5($mdp)."' 
										WHERE id = '".$_SESSION['membre_id']."'") 
										or ErrorSQL(__FILE__,__LINE__);
                
                if($update)
                {
                    if(modif_mail($profil['membre_mail'],$_SESSION['membre_pseudo'],$_POST['mdp'],$_POST['new_mdp'])) $sent = "Un mail contenant un lien d'activation de votre compte vous à été envoyé.";
                    else $sent = "Un mail contenant un lien d'activation aurait dû vous être envoyé, mais son envoi a échoué, cependant, votre mot de passe à bien été changer.<br/>Contacter le Webmaster du site pour obtenir votre lien d'activation.";
                    
                    $informations = array( /* Modification du mot de passe réussi */
                                    false,
                                    '',
                                    'La modification de votre mot de passe à été modifier avec succès. '.$sent.'<br/>',
                                    ' - <a href="'.ROOTPATH.'">Index</a>',
                                    ROOTPATH,
                                    5
                                    );
                    require_once('information.php');
                    exit();
                }
                else
                {
                    $informations = array( /*Modification échoué */
                                    true,
                                    '',
                                    'La modification de votre mot de passe a échoué. Veuillez recommencer, ou contacter le Webmaster.<br/>',
                                    '',
                                    ROOTPATH,
                                    5
                                    );
                    require_once('information.php');
                    exit();
                }
            }
        }
        /* Haut de la page, contient le doctype, charset, etc... */
        include('includes/haut.php');
        /*********************************************************/
		if(isset($_POST['change_fofo']))
		{
			$msn = mysql_real_escape_string($_POST['msn']);
			$siteweb = mysql_real_escape_string($_POST['siteweb']);
			$change_msn = mysql_query("UPDATE site_membres 
										SET msn = '".$msn."'
										WHERE id = '".$_SESSION['membre_id']."'") 
										or ErrorSQL(__FILE__,__LINE__);
			
			$change_siteweb = mysql_query("UPDATE site_membres 
											SET siteweb = '".$siteweb."'
											WHERE id = '".$_SESSION['membre_id']."'") 
											or ErrorSQL(__FILE__,__LINE__);
			if($change_msn)
			{
				$msn_fofo = '<div id="information">L\'adresse msn sur le forum a bien été modifier.</div>';
			}
			else
			{
				$msn_fofo = '<div id="erreur">L\'adresse msn sur le forum n\'a pas été modifier.</div>';
			}
			if($change_siteweb)
			{
				$www_fofo = '<div id="information">Le site web sur le forum a bien été modifier.</div>';
			}
			else
			{
				$www_fofo = '<div id="erreur">Le site web sur le forum n\'a pas été modifier.</div>';
			}
		}
        if(isset($_POST['change_adress']))
        {
            if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $_POST['msn']))
            {
				$erreur = "L'adresse msn n'est pas valide.";
            }
            else
            {
				$_POST['msn'] = mysql_real_escape_string($_POST['msn']);
                $change_msn = "UPDATE site_membres SET msn = '".$_POST['msn']."' ";
                if(isset($_POST['cache_msn']))
                {
                    $change_msn .= ", cache_msn = '1' ";
                }
                else
                {
					$change_msn .= ", cache_msn = '0' ";
                }
				$change_msn .= "WHERE id = '".$_SESSION['membre_id']."'";
				if(mysql_query($change_msn) or ErrorSQL(__FILE__,__LINE__))
				{
					$msn = '<div id="information">L\'adresse msn a bien été changé.</div>';
				}
				else
				{
					$msn = '<div id="erreur">L\'adresse msn n\'a pas été changé.</div>';
				}
			}
			
			$_POST['skype'] = mysql_real_escape_string($_POST['skype']);
			$change_skype = "UPDATE site_membres SET skype = '".$_POST['skype']."' ";
			if(isset($_POST['cache_skype']))
			{
				$change_skype .= ", cache_skype = '1' ";
			}
			else
			{
				$change_skype .= ", cache_skype = '0' ";
			}
			$change_skype .= "WHERE id = '".$_SESSION['membre_id']."'";
			if(mysql_query($change_skype) or ErrorSQL(__FILE__,__LINE__))
			{
				$skype = '<div id="information">L\'adresse skype a bien été changé.</div>';
			}
			else
			{
				$skype = '<div id="erreur">L\'adresse skype n\'a pas été changé.</div>';
            }
            
			$_POST['yahoo'] = mysql_real_escape_string($_POST['yahoo']);
			$change_yahoo = "UPDATE site_membres SET yahoo = '".$_POST['yahoo']."' ";
			if(isset($_POST['cache_yahoo']))
			{
				$change_yahoo .= ", cache_yahoo = '1' ";
			}
			else
			{
				$change_yahoo .= ", cache_yahoo = '0' ";
			}
			$change_yahoo .= "WHERE id = '".$_SESSION['membre_id']."'";
			if(mysql_query($change_yahoo) or ErrorSQL(__FILE__,__LINE__))
			{
				$yahoo = '<div id="information">L\'adresse yahoo a bien été changé.</div>';
			}
			else
			{
				$yahoo = '<div id="erreur">L\'adresse yahoo n\'a pas été changé.</div>';
			}
            
			$_POST['aim'] = mysql_real_escape_string($_POST['aim']);
			$change_aim = "UPDATE site_membres SET aim = '".$_POST['aim']."' ";
			if(isset($_POST['cache_aim']))
			{
				$change_aim .= ", cache_aim = '1' ";
			}
			else
			{
				$change_aim .= ", cache_aim = '0' ";
			}
			$change_aim .= "WHERE id = '".$_SESSION['membre_id']."'";
			if(mysql_query($change_aim) or ErrorSQL(__FILE__,__LINE__))
			{
				$aim = '<div id="information">L\'adresse aim a bien été changé.</div>';
			}
			else
			{
				$aim = '<div id="erreur">L\'adresse aim n\'a pas été changé.</div>';
			}
        }
        if(isset($_POST['change_perso']))
        {
            $_POST['localisation'] = mysql_real_escape_string($_POST['localisation']);
            $change_localisation = "UPDATE site_membres SET localisation = '".$_POST['localisation']."' ";
            if(isset($_POST['cache_localisation']))
            {
                $change_localisation .= ", cache_localisation = '1' ";
            }
            else
            {
                $change_localisation .= ", cache_localisation = '0' ";
            }
            $change_localisation .= "WHERE id = '".$_SESSION['membre_id']."'";
            if(mysql_query($change_localisation) or ErrorSQL(__FILE__,__LINE__))
            {
                $localisation = '<div id="information">La localisation du site a bien été changé.</div>';
            }
            else
            {
                $localisation = '<div id="erreur">La localisation du site n\'a pas été changé.</div>';
            }
			
			$_POST['profession'] = mysql_real_escape_string($_POST['profession']);
            $change_profession = "UPDATE site_membres SET profession = '".$_POST['profession']."' ";
            if(isset($_POST['cache_profession']))
            {
				$change_profession .=", cache_profession = '1' ";
            }
            else
            {
                $change_profession .=", cache_profession = '0' ";
            }
            $change_profession .= "WHERE id = '".$_SESSION['membre_id']."'";
            if(mysql_query($change_profession) or ErrorSQL(__FILE__,__LINE__))
            {
                $profession = '<div id="information">La profession a bien été changé.</div>';
            }
            else
            {
                $profession = '<div id="erreur">La profession n\'a pas été changé.</div>';
            }
        }
        if(isset($_POST['change_sign']))
        {
            $_POST['signature'] = preg_replace('#<script (.+)>(.+)<\/script>#isU', '', $_POST['signature']);
			$_POST['signature'] = mysql_real_escape_string($_POST['signature']);
			$_POST['signature'] = nl2br($_POST['signature']);
			$change_sign = mysql_query("UPDATE site_membres 
										SET signature = '".$_POST['signature']."' 
										WHERE id = '".$_SESSION['membre_id']."'") 
			or ErrorSQL(__FILE__,__LINE__);
			if($change_sign)
			{
				$sign = '<div id="information">La signature du site a bien été changé.</div>';
			}
			else
			{
				$sign = '<div id="erreur">La signature du site n\'a pas été changé.</div>';
			}
        }
        if(isset($_POST['change_bio']))
        {
            $_POST['biographie'] = preg_replace('#<script (.+)>(.+)<\/script>#isU', '', $_POST['biographie']);
			$_POST['biographie'] = mysql_real_escape_string($_POST['biographie']);
			$_POST['biographie'] = nl2br($_POST['biographie']);
			$change_bio = mysql_query("UPDATE site_membres 
										SET biographie = '".$_POST['biographie']."'
										WHERE id = '".$_SESSION['membre_id']."'") 
										or ErrorSQL(__FILE__,__LINE__);
			if($change_bio)
			{
				$bio = '<div id="information">La biographie a bien été changé.</div>';
			}
			else
			{
				$bio = '<div id="erreur">La biographie n\'a pas été changé.</div>';
			}
        }
        if(isset($_POST['change_avatar']))
        {
            if(isset($_POST['suppr_avatar']))
            {
                if(unlink("page/membre_avatar/avatar-".$_SESSION['membre_id']."-".$_SESSION['membre_pseudo'].".png"))
                {
                    $delete = mysql_query("UPDATE site_membres 
											SET avatar = '' 
											WHERE id = '".$_SESSION['membre_id']."'") 
											or ErrorSQL(__FILE__,__LINE__);
											
					$delete2 = mysql_query("UPDATE forum_membres 
											SET avatar = '' 
											WHERE id = '".$_SESSION['membre_id']."'") 
											or ErrorSQL(__FILE__,__LINE__);
                    if($delete)
                    {
                        $suppr_avatar = '<div id="information">L\'avatar du site a bien été supprimé.</div>';
                    }
                    else
                    {
                        $suppr_avatar = '<div id="erreur">L\'avatar du site n\'a pas été supprimé.</div>';
                    }
                }
				else
                {
                    $supr_avatar = '<div id="erreur">L\'avatar n\'a pas été supprimé du répertoire.</div>';
                }
            }
            else
            {
                $maxheight = 150;
                $maxwidth = 150;
                $extension_valide = array('jpg', 'jpeg', 'gif', 'png');
                $extension_upload = strtolower(substr(strrchr($_FILES['avatar']['name'],'.'),1));
                $image_taille = getimagesize($_FILES['avatar']['tmp_name']);
                $nom_avatar = "page/membre_avatar/avatar-".$_SESSION['membre_id']."-".$_SESSION['membre_pseudo'].".png";
                if($_FILES['avatar']['error'] != 0)
                {
                    $erreur = 'Une erreur est survenue lors du téléchargement de l\'avatar.';
                }
                elseif($_FILES['avatar']['size'] > $_POST['MAX_FILE_SIZE'])
                {
                    $erreur  = 'L\'avatar excède le poid de 75 Ko.';
                }
                elseif(!in_array($extension_upload, $extension_valide))
                {
                    $erreur = 'L\'extension de l\'avatar est incorrecte.';
                }
                elseif($image_taille[0] > $maxwidth OR $image_taille[1] > $maxheight)
                {
                    $erreur = 'L\'avatar est trop grand.';
                }
                else
                {
                    if(move_uploaded_file($_FILES['avatar']['tmp_name'],$nom_avatar))
                    {
                        $modif_avatar = mysql_query("UPDATE site_membres 
													SET avatar = '".ROOTPATH."/page/membre_avatar/avatar-".$_SESSION['membre_id']."-".$_SESSION['membre_pseudo'].".png' 
													WHERE id = '".$_SESSION['membre_id']."'") 
						or ErrorSQL(__FILE__,__LINE__);
                        if($modif_avatar)
                        {
                            $avatar = '<div id="information">L\'avatar du site a bien été modifier.</div>';
                        }
                        else
                        {						
                            $avatar = '<div id="erreur">L\'avatar n\'a pas été modifier.</div>';
                        }
                    }
                    else
                    {
                        $upload = '<div id="erreur">Il y a eu une erreur lors de la création de l\'avatar.</div>';
                    }
                }
            }
        }
        ?>
		<div id="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
					<?php
						echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=mon_compte', 'Mon compte').' '.fil_ariane(2, '', 'Modification de mon compte');
					?>
					</div>
					<h1>Modification de mon profil</h1><br/>
					<?php
						if(isset($erreur) or isset($msn) or isset($skype) or isset($yahoo) or isset($aim) or isset($localisation) or isset($profession) or isset($sign) or isset($bio) or isset($suppr_avatar) or isset($supr_avatar) or isset($avatar) or isset($upload))
						{
							if(isset($erreur))
							{
								echo '<span class="erreur">'.$erreur.'</span>';
							}
							if(isset($msn_fofo))
							{
								echo $msn_fofo;
							}
							if(isset($www_fofo))
							{
								echo $www_fofo;
							}
							if(isset($msn))
							{
								echo $msn;
							}
							if(isset($skype))
							{
								echo $skype;
							}
							if(isset($yahoo))
							{
								echo $yahoo;
							}
							if(isset($aim))
							{
								echo $aim;
							}
							if(isset($localisation))
							{
								echo $localisation;
							}
							if(isset($profession))
							{
								echo $profession;
							}
							if(isset($sign))
							{
								echo $sign;
							}
							if(isset($bio))
							{
								echo $bio;
							}
							if(isset($suppr_avatar))
							{
								echo $suppr_avatar;
							}
							if(isset($supr_avatar))
							{
								echo $supr_avatar;
							}
							if(isset($avatar))
							{
								echo $avatar;
							}
							if(isset($upload))
							{
								echo $upload;
							}
						}
					?>
					<div class="profil_cellule_float">
						<div class="cellule">
							<span class="cellule_titre">Modifier mon mot de passe</span>
								<center><span style="font-style:italic; font-size:0.8em;">5 à 25 caractères pour le nouveau mot de passe</span></center>
							<form method="post">
								<table style="margin:auto;">
									<tr>
										<td><label for="mdp"><span class="donnees">Ancien mot de passe</span></label></td>
										<td><input type="password" name="mdp" id="mdp" tabindex="1" /></td>
									</tr>
									<tr>
										<td><label for="new_mdp"><span class="donnees">Nouveau mot de passe</span></label></td>
										<td><input type="password" name="new_mdp" id="new_mdp" tabindex="2" /></td>
									</tr>
									<tr>
										<td><label for="confirm_new_mdp"><span class="donnees">Confirmation du nouveau mot de passe</span></label></td>
										<td><input type="password" name="confirm_new_mdp" id="confirm_new_mdp" tabindex="3" /></td>
									</tr>
									<tr>
										<td colspan="2" align="center"><input type="submit" value="Changer mon mot de passe" name="change_mdp" id="change_mdp" /></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
					<div class="profil_cellule_float">
						<div class="cellule">
							<span class="cellule_titre">Modifier mon profil de forum</span>
							<form method="post">
								<table style="margin:auto;">
									<tr>
										<td><label for="msn">Adresse MSN :</label></td>
										<td><input type="text" name="msn" id="msn" /></td>
									</tr>
									<tr>
										<td><label for="siteweb">Site Web :</label></td>
										<td><input type="text" name="siteweb" id="siteweb" /></td>
									</tr>
									<tr>
										<td colspan="2" align="center"><input type="submit" id="change_fofo" name="change_fofo" value="Modifier mon profil de forum" /></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
					<div class="profil_cellule_float">
						<div class="cellule">
							<span class="cellule_titre">Modifier mes adresses de contact</span>
							<form method="post">
								<table style="margin:auto;">
									<tr>
										<td><label for="msn"><span class="donnees">MSN :</span></label></td>
										<td><input type="text" name="msn" id="msn" value="<?php if($profil['msn'] != '') echo $profil['msn']; ?>" /></td>
										<td><input type="checkbox" name="cache_msn" id="cache_msn" /></td>
										<td><label for="cache_msn"><span style="font-size:0.8em">Cacher cette information ?</span></label></td>
									</tr>
									<tr>
										<td><label for="skype"><span class="donnees">Skype :</span></label></td>
										<td><input type="text" name="skype" id="skype" value="<?php if($profil['skype'] != '') echo $profil['skype']; ?>" /></td>
										<td><input type="checkbox" name="cache_skype" id="cache_skype" /></td>
										<td><label for="cache_skype"><span style="font-size:0.8em">Cacher cette information ?</span></label></td>
									</tr>
									<tr>
										<td><label for="yahoo"><span class="donnees">Yahoo :</span></label></td>
										<td><input type="text" name="yahoo" id="yahoo" value="<?php if($profil['yahoo'] != '') echo $profil['yahoo']; ?>" /></td>
										<td><input type="checkbox" name="cache_yahoo" id="cache_yahoo" /></td>
										<td><label for="cache_yahoo"><span style="font-size:0.8em">Cacher cette information ?</span></label></td>
									</tr>
									<tr>
										<td><label for="aim"><span class="donnees">Aim :</span></label></td>
										<td><input type="text" name="aim" id="aim" value="<?php if($profil['aim'] != '') echo $profil['aim']; ?>" /></td>
										<td><input type="checkbox" name="cache_aim" id="cache_aim" /></td>
										<td><label for="cache_aim"><span style="font-size:0.8em">Cacher cette information ?</span></label></td>
									</tr>
									<tr>
										<td colspan="4" align="center"><input type="submit" value="Changer mes adresse de contact" name="change_adress" id="change_adress" /></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
					<div class="profil_cellule_float">
						<div class="cellule">
							<span class="cellule_titre">Modifier mes informations personnelles</span>
							<form method="post">
								<table style="margin:auto;">
									<tr>
										<td><label for="localisation"><span class="donnees">Localisation :</span></label></td>
										<td><input type="text" name="localisation" id="localisation" value="<?php if($profil['localisation'] != '') echo $profil['localisation']; ?>" /></td>
										<td><input type="checkbox" name="cache_localisation" id="cache_localisation" /></td>
										<td><label for="cache_localisation"><span style="font-size:0.8em">Cacher cette information ?</span></label></td>
									</tr>
									<tr>
										<td><label for="profession"><span class="donnees">Profession :</span></label></td>
										<td><input type="text" name="profession" id="profession" value="<?php if($profil['profession'] != '') echo $profil['profession']; ?>" /></td>
										<td><input type="checkbox" name="cache_profession" id="cache_profession" /></td>
										<td><label for="cache_profession"><span style="font-size:0.8em">Cacher cette information ?</span></td>
									</tr>
									<tr>
										<td colspan="4" align="center"><input type="submit" value="Changer mes informations personnelles" name="change_perso" id="change_perso" /></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
					<div class="profil_cellule_float">
						<div class="cellule">
							<span class="cellule_titre">Modifier mon avatar</span>
							<center><span style="font-size:1em; display:block; margin:auto; font-style:italic;">(Taille max : 75Ko, Format : 150 * 150, Format accepté : .PNG, .JPEG, .JPG, .GIF)</span></center>
							<form method="post" enctype="multipart/form-data">
								<table style="margin:auto;">
									<?php
									if($profil['avatar'] != '')
									{
									?>
									<tr>
										<td>Avatar actuelle :</td>
										<td colspan="2"><?php echo '<img src="'.$profil['avatar'].'" alt="Avatar" />';?></td>
									</tr>
									<tr>
										<td colspan="3" align="center"><input type="checkbox" name="suppr_avatar" id="suppr_avatar" /><label for="suppr_avatar">Supprimer l'avatar actuel</label></td>
									</tr>
									<?php
									}
									?>
									<tr>
										<td><label for="avatar"><span class="donnees">Avatar :</span></label></td>
										<td><input type="hidden" name="MAX_FILE_SIZE" value="76800" /></td>
										<td><input type="file" value="Rechercher..." name="avatar" /></td>
									</tr>
									<tr>
										<td colspan="3" align="center"><input type="submit" value="Changer mon avatar" name="change_avatar" /></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
					<div class="stop_float"></div>
					<div class="cellule2">
						<span class="cellule_titre">Modifier ma signature</span>
						<form method="post">
							<table style="margin:auto;">
								<tr>
									<td>
										<?php include('includes/haut_bbcode.php'); ?>
										<textarea name="signature" id="textarea" cols="70" rows="15" ><?php if($profil['signature'] != '') echo $profil['signature']; ?></textarea>
										<?php include('includes/bas_bbcode.php'); ?>
									</td>
								</tr>
								<tr>
									<td><input type="submit" value="Changer ma signature" name="change_sign" id="change_sign" /></td>
								</tr>
							</table>
						</form>
					</div>
					<div class="cellule3">
						<span class="cellule_titre">Modifier ma biographie</span>
						<form method="post">
							<table style="margin:auto;">
								<tr>
									<td>
										<?php include('includes/haut_bbcode.php'); ?>
										<textarea name="biographie" id="textarea2" cols="70" rows="15" ><?php if($profil['biographie'] != '') echo $profil['biographie']; ?></textarea>
										<?php include('includes/bas_bbcode.php'); ?>
									</td>
								</tr>
								<tr>
									<td><input type="submit" value="Changer ma biographie" name="change_bio" id="change_bio" /></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
    <?php
    }
    elseif($_GET['mod'] == "reset")
    {
        /* Titre de la page */
        $titre = 'Mot de passe oublié';
        /********************/

        /* Définition du TITRE du CADRE du contenu de la page */
        $titre2 = 'Mot de passe oublié';
        /******************************************************/

        if(isset($_POST['reset_mdp']))
        {
			$_POST['pseudo'] = add_SQL($_POST['pseudo']);
			$_POST['email'] = add_SQL($_POST['email']);
            $profil = mysql_query("SELECT pseudo
                                   FROM site_membres
                                   WHERE pseudo = '".$_POST['pseudo']."'")
								   or ErrorSQL(__FILE__,__LINE__);
            $nb = mysql_num_rows($profil);
            
            $profil_2 = mysql_query("SELECT mail
									FROM site_membres
									WHERE mail = '".$_POST['email']."'")
									or ErrorSQL(__FILE__,__LINE__);
            $nb2 = mysql_num_rows($profil_2);
            
            if(empty($_POST['pseudo']))
            {
                $erreur = 'Vous n\'avez pas précisé votre pseudo.';
            }
            elseif($nb == 0)
            {
                $erreur = 'Le pseudo entré n\'existe pas.';
            }
            elseif(empty($_POST['email']))
            {
                $erreur = 'Vous n\'avez pas précisé votre email.';
            }            
            elseif($nb2 == 0)
            {
                $erreur = 'L\'adresse email entrée n\'existe pas.';
            }
            else
            {
                $lettre = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
                $a = mt_rand(0,9);
                $b = mt_rand(0,9);
                $c = mt_rand(0,9);
                $d = mt_rand(0,9);
                $e = mt_rand(0,9);
                $f = mt_rand(0,9);
                $g = mt_rand(0,42);
                $h = mt_rand(0,42);
                $i = mt_rand(0,42);
                $j = mt_rand(0,42);
                $k = mt_rand(0,42);
                $l = mt_rand(0,42);                
                $mdp_aleat = $a.$lettre[$g].$lettre[$h].$b.$c.$lettre[$i].$d.$lettre[$j].$lettre[$k].$e.$f.$lettre[$l];
                $mdp = md5($mdp_aleat);
                $new_mdp = mysql_query("UPDATE site_membres 
										SET mdp = '".$mdp."', valider = '0', groupe = 'Non validé' 
										WHERE mail = '".$_POST['email']."'") 
										or ErrorSQL(__FILE__,__LINE__);
                
                if($new_mdp)
                { /* Reset réussi */
                    if(reset_mdp($_POST['email'], $_POST['pseudo'], $mdp_aleat))
                    {
                        $informations = array ( /* Envoié réussi */
                                        false,
                                        'Mot de passe oublié',
                                        'Un nouveau mot de passe vous à été envoyé.<br/>',
                                        '',
                                        ROOTPATH,
                                        3
                                        );
                        require_once('information.php');
                        exit();
                    }
                    else
                    {
                        $informations = array ( /* Envoié échoué */
                                        true,
                                        'Mot de passe oublié',
                                        'L\'envoi du nouveau mot de passe a échoué. Si cette erreur persiste, veuillez nous contacter via la page de contact.<br/>',
                                        ' - <a href="'.ROOTPATH.'"/?page=contact">Contacter le Webmaster</a>',
                                        ROOTPATH.'?page=mon_compte&amp;mod=reset',
                                        3
                                        );
                        require_once('information.php');
                        exit();
                    }
                }
                else /* Reset échoué */
                {
                    $informations = array( /* Reset échoué */
                                    true,
                                    'Mot de passe oublié',
                                    'La redéfinition d\'un nouveau mot de passe à échoué, veuillez réessayer. Si cette erreur persiste, veuillez nous contacter via la page de contact.<br/>',
                                    ' - <a href="'.ROOTPATH.'"/?page=contact">Contacter le Webmaster</a>',
                                    ROOTPATH.'?page=mon_compte&amp;mod=reset',
                                    3
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
	<div id="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=mon_compte', 'Mon compte').' '.fil_ariane(2, '?page=mon_compte&amp;mod=reset', 'Réinitialisation de mon mot de passe');
				?>
				</div>
				<br/>
				<h1>Redéfinir un mot de passe</h1>
				<br/>
				<?php
				if(isset($erreur))
				{
					echo '<span class="erreur">'.$erreur.'</span><br/>';
				}
				?>
				<p>Vous avez oublier votre mot de passe ? Alors inscrivez votre adresse entré lors de votre inscription ci-dessous pour recevoir un nouveau mot de passe.</p>
				<br/><br/>
				<form method="post">
					<table style="margin:auto;">
						<tr>
							<td><label for="pseudo">Pseudo :</label></td>
							<td><input type="text" name="pseudo" id="pseudo" value="<?php if(!empty($_POST['pseudo'])) echo htmlspecialchars($_POST['pseudo'],ENT_QUOTES); ?>" /></td>
						</tr>
						<tr>
							<td><label for="email">Adresse email :</label></td>
							<td><input type="text" name="email" id="email" value="<?php if(!empty($_POST['email'])) echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>" /></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" value="Envoyer un nouveau mot de passe" name="reset_mdp" id="reset_mdp" /></td>
						</tr>
					</table>
				</form>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
    <?php
    }
}
else
{
    /* Titre de la page */
    $titre = 'Mon profil';
    /********************/

    /* Définition du TITRE du CADRE du contenu de la page */
    $titre2 = 'Mon profil';
    /******************************************************/

    /* Haut de la page, contient le doctype, charset, etc... */
    include('includes/haut.php');
    /*********************************************************/
    
    if(isset($_SESSION['membre_id']))
	{
        $id = $_SESSION['membre_id'];
	}
    else
	{
		$id = -1;
	}
    
    $sql = mysql_query("SELECT * 
						FROM site_membres 
						LEFT JOIN site_connectes ON connectes_id = id
						LEFT JOIN site_membres_config ON membre_id = id
						WHERE id = ".intval($id)) 
						or ErrorSQL(__FILE__,__LINE__);
	$profil = mysql_fetch_assoc($sql);
    ?>
	<div id="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?page=mon_compte', 'Mon compte');
				?>
				</div>
				<br/>
				<h1>Mon profil</h1>
				<br/><br/>
				<div id="profil">
					<div class="cellule float_ig">
						<span class="cellule_titre">Information générale</span>
						<div class="cellule_avatar">
						<?php
						if($profil['avatar'] == '')
						{
							echo 'Pas d\'avatar.';
						}
						else
						{
							echo '<img src="'.$profil['avatar'].'" alt="Avatar" />';
						}
						?>
						</div>
						<ul>
							<li><span class="donnees">Pseudo :</span> <?php echo htmlspecialchars($profil['pseudo'],ENT_QUOTES); ?></li>
							<li><span class="donnees">Inscris le :</span> <?php echo mepd($profil['inscription']); ?></li>
							<li><span class="donnees">Groupe :</span> <?php echo htmlspecialchars($profil['groupe'],ENT_QUOTES); ?></li>
							<li><span class="donnees">Dernier passage :</span> <?php echo mepd($profil['derniere_visite']); ?></li>
							<li>
							<?php
							if($profil['connectes_id'] == $profil['membre_id'])
							{
							?>
								<span class="actif"><?php echo htmlspecialchars($profil['pseudo'], ENT_QUOTES); ?> est connecté</span>
							<?php
							}
							else
							{
							?>
								<span class="inactif"><?php echo htmlspecialchars($profil['pseudo'], ENT_QUOTES); ?> est déconnecté</span>
							<?php
							}
							?>
							</li>
						</ul>
					</div>			
					<div class="cellule2 float_profil">
						<span class="cellule_titre">Profil</span>
						<ul>
							<li><span class="donnees">Date de naissance :</span> <?php echo htmlspecialchars($profil['naissance'],ENT_QUOTES); ?></li>
							<li><span class="donnees">Âge :</span> <?php echo age($profil['naissance']); ?> ans</li>
							<li><span class="donnees">Sexe :</span> <?php echo '<span class="'.$profil['sexe'].'">'.htmlspecialchars($profil['sexe'],ENT_QUOTES).'</span>'; ?></li>
							<?php
							if($profil['cache_localisation'] == 0 AND trim($profil['localisation']) != '')
							{
								echo '<li><span class="donnees">Localisation :</span> '.htmlspecialchars($profil['localisation'],ENT_QUOTES).'</li>';
							}
							if($profil['cache_profession'] == 0 AND trim($profil['profession']) != '')
							{
								echo '<li><span class="donnees">Profession :</span> '.htmlspecialchars($profil['profession'],ENT_QUOTES).'</li>';
							}
							?>
						</ul>
					</div>
					<div class="cellule">
						<span class="cellule_titre">Le joindre</span>
						<ul>
						<?php
						if($profil['cache_msn'] == 0 AND trim($profil['msn']) != '')
						{
							echo '<li><span class="donnees">Adresse MSN :</span> '.htmlspecialchars($profil['msn'],ENT_QUOTES).'</li>';
						}
						if($profil['cache_skype'] == 0 AND trim($profil['skype']) != '')
						{
							echo '<li><span class="donnees">Skype :</span> '.htmlspecialchars($profil['skype'],ENT_QUOTES).'</li>';
						}
						if($profil['cache_yahoo'] == 0 AND trim($profil['yahoo']) != '')
						{
							echo '<li><span class="donnees">Adresse Yahoo :</span> '.htmlspecialchars($profil['yahoo'],ENT_QUOTES).'</li>';
						}
						if($profil['cache_aim'] == 0 AND trim($profil['aim']) != '')
						{
							echo '<li><span class="donnees">Adresse AIM :</span>' .htmlspecialchars($profil['aim'],ENT_QUOTES).'</li>';
						}
						?>
						</ul>
						<?php
						if(trim($profil['msn']) == '' AND trim($profil['skype']) == '' AND trim($profil['yahoo']) == '' AND trim($profil['aim']) == '')
						{
							echo '<span style="display:block; text-align:center; font-weight:bold;">'.$profil['pseudo'].' ne souhaite pas rendre ces informations publiques.</span><br/>';
						}
						if($profil['cache_msn'] == 1 AND $profil['cache_skype'] == 1 AND $profil['cache_yahoo'] == 1 AND $profil['cache_aim'] == 1)
						{
							echo '<span style="display:block; text-align:center; font-weight:bold;">'.$profil['pseudo'].' ne souhaite pas rendre ces informations publiques.</span><br/>';
						}
						?>
					</div>
					<div class="cellule">
						<span class="cellule_titre">Activité dans le site</span>
						<ul>
						<?php
						$sql5 = mysql_query("SELECT nb_post 
											 FROM site_membres 
											 WHERE id = '".$_SESSION['membre_id']."'") 
											 or ErrorSQL(__FILE__,__LINE__);
						$req5 = mysql_fetch_assoc($sql5);			
						echo '<li><strong>Message dans le forum :</strong> '.$req5['nb_post'].'</li>';
						echo '<li><a href="'.ROOTPATH.'/?page=mp&amp;action=nouveau&amp;id='.$_SESSION['membre_id'].'">Lui envoyer un message privé</a></li>';
						?>
						</ul>
					</div>
					<div class="cellule2">
						<span class="cellule_titre">Signature</span>
						<div class="cellule_texte">
						<?php
							if(trim($profil['signature']) != '')
							{
								echo parseZCode($profil['signature']);
							}
							else
							{
								echo '<br/>';
							}
						?>
						</div>
					</div>
					<div class="cellule3">
						<span class="cellule_titre">Biographie</span>
						<div class="cellule_texte">
						<?php
							if(trim($profil['biographie']) != '')
							{
								
								echo parseZCode($profil['biographie']);
							}
							else
							{
								echo '<br/>';
							}
						?>
						</div>
					</div>
				</div>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
}
?>