<?php
/*
page/membre.php

Liste des membres du site
*/

if(isset($_GET['id']))
{
	if($_GET['id'] == '')
	{
		if(isset($_SESSION['membre_id']))
		{
			$id = $_SESSION['membre_id'];
		}
        else
		{
			$id = -1;
		}
	}
	else
	{
		$id = $_GET['id'];
	}
	
	$sql = mysql_query("SELECT * FROM site_membres
						LEFT JOIN site_connectes
						ON connectes_id = id
						LEFT JOIN site_membres_config
						ON membre_id = id
						WHERE id= ".intval($id))
						or ErrorSQL(__FILE__,__LINE__);
	$profil = mysql_fetch_assoc($sql);
	if($profil['id'] == '' || $id == -1)
	{
        $informations = Array(/*L'id de cookie est incorrect*/
						true,
						'Membre inconnu',
						'Ce membre n\'existe pas.',
						'',
						'../index.php',
						3,
						);
        require_once('information.php');
        exit();
	}
	
	/* Titre de la page */ // Seulement si l'id d'un membre a été sélectionné //
	$titre = 'Membre '.htmlspecialchars($profil['pseudo'],ENT_QUOTES);
	/********************/
	
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Profil de '.htmlspecialchars($profil['pseudo'],ENT_QUOTES);
	/******************************************************/
	
	/* Haut de la page, contient le doctype, charset, etc... */
	include('includes/haut.php');
	/*********************************************************/
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
				<?php
					echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, '?page=membre', 'Membres inscrits').' '.fil_ariane(2, '', 'Profil d\'un membre');
				?>
				</div>
				<br/>
				<h1>Profil de <?php echo htmlspecialchars($profil['pseudo'],ENT_QUOTES); ?></h1>
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
								echo '<img src="'.$profil['avatar'].'" alt="Avatar du membre '.$profil['pseudo'].'" title="Avatar du membre '.$profil['pseudo'].'" />';
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
							if($profil['connectes_id'] == $profil['id'])
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
							?></li>
						</ul>
					</div>
					<div class="cellule2 float_profil">
						<span class="cellule_titre">Profil</span>
						<ul>
							<li><span class="donnees">Date de naissance :</span> <?php echo htmlspecialchars($profil['naissance'],ENT_QUOTES); ?></li>
							<li><span class="donnees">Âge :</span> <?php echo age($profil['naissance']); ?> ans</li>
							<li><span class="donnees">Sexe :</span> <?php 
							if($profil['sexe'] == 'Masculin')
							{
								$sexe = 'masculin';
							}
							else
							{
								$sexe = 'feminin';
							}
							echo '<span class="'.$sexe.'">'.htmlspecialchars($profil['sexe'],ENT_QUOTES).'</span>'; ?></li>
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
						$sql5 = mysql_query("SELECT nb_post, pseudo
											FROM site_membres
											WHERE id = '".$_GET['id']."'") 
											or ErrorSQL(__FILE__,__LINE__);
						$req5 = mysql_fetch_assoc($sql5);	
						if($req5['nb_post'] == 0)
						{
							$req5['nb_post'] = '0';
						}
						echo '<li><strong>Message dans le forum :</strong> '.$req5['nb_post'].'</li>';
						if(isset($_SESSION['membre_id']))
						{
						echo '<li><a href="'.ROOTPATH.'/?page=mp&amp;action=nouveau&amp;id='.$_GET['id'].'">Lui envoyer un message privé</a></li>';
							$sql6 = mysql_result(mysql_query("SELECT COUNT(*) AS nbr 
															  FROM site_amis 
															  WHERE ami_from = '".intval($_SESSION['membre_id'])."' AND ami_to = '".$_GET['id']."'
															  OR ami_to = '".intval($_SESSION['membre_id'])."' AND ami_from = '".$_GET['id']."'"),0);
							if($sql6 == 0)
							{
								echo '<li><a href="'.ROOTPATH.'/?page=friends&amp;action=new&amp;id='.$_GET['id'].'">Ajouter '.$req5['pseudo'].' en ami(e)</a></li>';
							}
							else
							{
								echo '<li>'.$req5['pseudo'].' figure déjà dans votre liste d\'amis.</li>';
							}
						}
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
else
{
/* Titre de la page */
$titre = 'Liste des membres inscrit';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = $titre;
/******************************************************/

/* Haut de la page, contient le doctype, charset, etc... */
include('includes/haut.php');
/*********************************************************/
?>
<div class="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php
				echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?page=membre', 'Liste des membres inscrits');
			?>
			</div>
			<br/>
			<h1><?php echo $titre2; ?></h1>
			<br/>
			<table class="liste_membre">
				<thead>
					<tr>
						<th class="liste_membre">N°</th>
						<th class="liste_membre">Pseudo</th>
						<th class="liste_membre">Sexe</th>
						<th class="liste_membre">Groupe</th>
						<th class="liste_membre">Date d'inscription</th>
						<th class="liste_membre">Dernière visite</th>
						<th class="liste_membre">Statut</th>
					</tr>
				</thead>
				<?php
				$id = ' AND connectes_id <> -1';
				$sql = mysql_query("SELECT id, pseudo, inscription, sexe, groupe, derniere_visite, 
									connectes_actualisation, connectes_id
									FROM site_membres
									LEFT JOIN site_connectes ON id = connectes_id
									ORDER BY id DESC")
				or ErrorSQL(__FILE__,__LINE__);
				$i = 0;
				?>
				<tbody>
				<?php
				while($req = mysql_fetch_array($sql))
				{
					if($req['id'] != '')
					{
						$lien = '<a href="'.ROOTPATH.'/?page=membre&amp;id='.$req['id'].'">';
						$lien2 = '</a>';
					}
					if($req['connectes_id'] == $req['id'])
					{
						$statut = '<span class="actif">En ligne</span>';
					}
					else
					{
						$statut = '<span class="inactif">Hors ligne</span>';
					}
					if($req['sexe'] == 'Masculin')
					{
						$sexe = 'masculin';
					}
					else
					{
						$sexe = 'feminin';
					}
					echo '
						  <tr class="ligne_'.($i%2).'" height="30">
						  <td class="liste_membre" width="150">'.$req['id'].'</td>
						  <td class="liste_membre" width="150">'.$lien.''.htmlspecialchars($req['pseudo'],ENT_QUOTES).''.$lien2.'</td>
						  <td class="liste_membre" width="150"><span class="'.$sexe.'">'.$req['sexe'].'</span></td>
						  <td class="liste_membre" width="150">'.$req['groupe'].'</td>
						  <td class="liste_membre" width="150">'.mepd($req['inscription']).'</td>
						  <td class="liste_membre" width="150">'.mepd($req['derniere_visite']).'</td>
						  <td class="liste_membre" width="150">'.$statut.'</td>
						  </tr>';
						  $i++;
				}
				?>
				</tbody>
			</table>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->
<?php
}
?>