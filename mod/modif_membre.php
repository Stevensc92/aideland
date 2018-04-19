<?php
/*
mod/modif_membre.php

Modification des membres
*/
if(isset($_SESSION['membre_id']))
{
    $id2 = $_SESSION['membre_id'];
    $sql2 = mysql_query("SELECT rang, pseudo 
						FROM site_membres 
						WHERE id = '".$id2."'") 
	or ErrorSQL(__FILE__,__LINE__);
    
    if($sql2)
    {
        $data2 = mysql_fetch_assoc($sql2);
        if($data2['rang'] >= 90)
        {
            /* Titre de la page */
            $titre = 'Modifier un membre';
            /********************/

            /* Définition du TITRE du CADRE du contenu de la page */
            $titre2 = 'Modifier un membre';
            /******************************************************/

            /* Haut de la page, contient le doctype, charset, etc... */
            include('includes/haut.php');
            /*********************************************************/
            if(isset($_POST['modif_membre']))
            {
                if(isset($_POST['membre']) && $_POST['membre'] == $_SESSION['membre_id'])
                {
					?>
					<div class="content"><!-- Début centre -->	 
						<div class="nh"></div> <!-- News -->
							<div class="nf">
							<?php
								$id = intval($_POST['membre']);
								$sql = mysql_query("SELECT pseudo
													FROM site_membres
													WHERE id = '".$id."'")
								or ErrorSQL(__FILE__,__LINE__);
								$req = mysql_fetch_assoc($sql);
								
								echo '<div id="fil_ariane">';
								echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?mod=modif_membre', 'Modération d\'un membre').' '.fil_ariane(2, '?mod=modif_membre', 'Erreur : Modération du membre '.$req['pseudo'].'');
								echo '</div><br/>';
								echo '<div id="erreur" align="center">Vous ne pouvez pas modifier vos propres accès.<br/><a href="'.ROOTPATH.'/?mod=modif_membre" align="center">Retour...</a></div>';
							?>
							</div>
						<div class="nb"></div> <!-- Fin news -->
					</div><!-- Fin centre -->
					<?php
				}
                else
                {
                    $id = $_POST['membre'];
                    $sql = mysql_query("SELECT * 
										FROM site_membres 
										WHERE id = '".$id."'") 
										or ErrorSQL(__FILE__,__LINE__);
                    
                    if($sql)
                    {
                        $data = mysql_fetch_assoc($sql);
                    ?>
					<div class="content"><!-- Début centre -->	 
						<div class="nh"></div> <!-- News -->
							<div class="nf">
								<div id="fil_ariane">
								<?php
									echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?mod=modif_membre', 'Modération d\'un membre').' '.fil_ariane(2, '?mod=modif_membre', 'Modification du membre '.$data['pseudo'].'');
								?>
								</div>
								<br/>
								<h1>Modification du membre <?php echo $data['pseudo']; ?></h1>
								<br/>
									<form method="post">
										<table style="margin:auto;">
											<tr>
												<td align="center">Vous modifier les accès du membre :<input type="text" name="membre" value="<?php echo $data['pseudo']; ?>" disabled="disabled"/><input type="hidden" name="membre" value="<?php echo $data['pseudo']; ?>" /></td>
											</tr>
											<tr>
												<td align="center">
													<select name="acces" id="acces" 
													onchange="
													if(this.options[this.selectedIndex].value == '0')
													{ 
														document.getElementById('raison').style.visibility='visible';
														document.getElementById('lraison').style.visibility='visible';
													} 
													else
													{ 
														document.getElementById('raison').style.visibility='hidden';
														document.getElementById('lraison').style.visibility='hidden';
													}
													">
													<?php
													$access = array('0' => 'Bannis', '1' => 'Membre', '10' => 'Correcteur', '15' => 'Correcteur & Traducteur', '20' => 'Traducteur', '80' => 'Modérateur', '90' => 'Administrateur', '100' => 'Webmaster');
													foreach($access as $key => $value)
													{
														if($data['groupe'] == $value)
														{
															echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
														}
														else
														{
															echo '<option value="'.$key.'">'.$value.'</option>';
														}
													}
													?>
													</select>
												</td>
											</tr>
											<div id="raisonBannis" style="visibility:hidden">
											<tr>
												<td align="center"><label for="raison" id="lraison" style="<?php if($data['groupe'] != 'Bannis') echo 'visibility:hidden'; else echo 'visibility:visible'; ?>">Raison du bannisement :</label></td>
											</tr>
											<tr>
												<td><textarea id="raison" cols="70" rows="10" name="raison" style="<?php if($data['groupe'] != 'Bannis') echo 'visibility:hidden'; else echo 'visibility:visible'; ?>"></textarea></td>
											</tr>
											</div>
											<tr>
												<td align="center"><input type="submit" value="Modifier ses accès" name="change_acces" /></td>
											</tr>
										</table>
									</form>
							</div>
						<div class="nb"></div> <!-- Fin news -->
					</div><!-- Fin centre -->
                    <?php
                    }
                }
            }
            elseif(isset($_POST['change_acces']))
            {
                $access = array('0' => 'Bannis', '1' => 'Membre', '10' => 'Correcteur', '15' => 'Correcteur & Traducteur', '20' => 'Traducteur', '80' => 'Modérateur', '90' => 'Administrateur', '100' => 'Webmaster');
                if(isset($_POST['raison']))
				{
					$raison = $_POST['raison'];
				}
				else
				{
					$raison = '';
				}
				$modif_membre = mysql_query("UPDATE site_membres 
											SET rang = '".$_POST['acces']."', groupe = '".$access[$_POST['acces']]."', bannis_raison = '".$raison."' 
											WHERE pseudo = '".$_POST['membre']."'") 
				or ErrorSQL(__FILE__,__LINE__);
				?>
				<div class="content"><!-- Début centre -->	 
					<div class="nh"></div> <!-- News -->
						<div class="nf">
							<div id="fil_ariane">
								<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?mod=modif_membre', 'Modération d\'un membre').' '.fil_ariane(2, '?mod=modif_membre', 'Modification du membre '.$_POST['membre'].''); ?>
							</div>
							<br/>
						<?php
						if($modif_membre)
						{
							echo '<div id="information">La modification du membre '.$_POST['membre'].' a bien été modifié.</div>';
						}
						else
						{
							echo '<div id="erreur">La modification du membre '.$_POST['membre'].' n\'a pas été modifié.</div>';
						}
						?>
						</div>
					<div class="nb"></div> <!-- Fin news -->
				</div><!-- Fin centre -->
				<?php
            }
            else
            {
            ?>
			<div class="content"><!-- Début centre -->	 
				<div class="nh"></div> <!-- News -->
					<div class="nf">
						<div id="fil_ariane">
						<?php
							echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?mod=modif_membre', 'Modération des membres');
						?>
						</div>
						<br/>
						<h1>Modifier un membre</h1>
						<br/>
						<form method="post">
							<table style="margin:auto;">
								<tr>
									<td><label for="membre">Choisir un membre :</label></td>
									<td><select name="membre" id="membre">
										<?php
										$profil = mysql_query("SELECT * 
																FROM site_membres")
																or ErrorSQL(__FILE__,__LINE__);
										while ($req = mysql_fetch_array($profil))
										{
											echo '<option value="'.$req['id'].'">'.$req['pseudo'].'</option>';
										}
										?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><input type="submit" value="Changer ce membre" name="modif_membre" /></td>
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
            $informations = array( /*Accès non autorisé */
                            true,
                            'Accès refusé',
                            'L\'accès vous est refusé.',
                            ' - <a href="'.ROOTPATH.'">Index</a>',
                            ROOTPATH,
                            5,
                            'Accès refusé'
                            );
            require_once('information.php');
            exit();
        }
    }
    else
    {
        $informations = array( /*Accès non autorisé */
                        true,
                        'Erreur',
                        'Une erreur s\'est produite.',
                        ' - <a href="'.ROOTPATH.'">Index</a>',
                        ROOTPATH,
                        5,
                        'Erreur'
                        );
        require_once('information.php');
        exit();
    }
}
else
{
    $informations = array( /*Accès non autorisé */
                    true,
                    'Accès refusé',
                    'Vous devez être connecter pour pouvoir accèder à cette page.',
                    ' - <a href="'.ROOTPATH.'/?page=connexion">Se connecter</a>',
                    ROOTPATH.'/?page=connexion',
                    5,
                    'Accès refusé'
                    );
    require_once('information.php');
    exit();
}