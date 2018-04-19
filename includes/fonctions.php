<?php
/*
Varial-Arts

Fonction
*/
function connexionbdd()
{
	//Définition des variables de connexion à la base de données
	$bd_nom_serveur=DB_HOST;
	$bd_login=DB_USER;
	$bd_mot_de_passe=DB_PASS;
	$bd_nom_bd=DB_NAME;

	//Connexion à la base de données
	mysql_connect($bd_nom_serveur, $bd_login, $bd_mot_de_passe);
	mysql_select_db($bd_nom_bd);
	mysql_query("set names 'utf8'");
}

function fil_ariane($nb, $a, $texte)
{
	if($nb == 1) // 1 = "out" (la personne est en dehors de la page (chemin pour y arriver ...))
	{
		if(isset($a) && isset($texte))
		{
			$a = '> <a href="'.ROOTPATH.'/'.$a.'">';
			$a .= $texte;
			$a .= '</a>';
			return $a;
		}
		else
		{
			echo 'Erreur lors de l\'éxécution de la fonction : fil_ariane. Argument ($a) non renseigné.';
		}
	}
	elseif($nb == 2) // 2 = in (la personne est dans la page présente)
	{
		if(isset($texte))
		{
			$a = '> <a href="'.ROOTPATH.'/'.$a.'" class="in">';
			$a .= $texte;
			$a .= '</a>';
			return $a;
		}
		else
		{
			echo 'Erreur lors de l\'éxécution de la fonction : fil_ariane. Argument ($texte) non renseigné.';
		}
	}
	else
	{
		echo 'Erreur lors de l\'éxécution de la fonction : fil_ariane. Argument ($nb) non renseigné.';
	}
}

function actualiser_session()
{
	if(isset($_SESSION['membre_id']) && intval($_SESSION['membre_id']) != 0) //Vérification id
	{
		//utilisation de la fonction sqlquery, on sait qu'on aura qu'un résultat car l'id d'un membre est unique.
		$sql = mysql_query("SELECT *
							FROM site_membres
							WHERE id = ".intval($_SESSION['membre_id']))
							or ErrorSQL(__FILE__,__LINE__);
		$retour = mysql_fetch_assoc($sql);
		//Si la requête a un résultat (id est : si l'id existe dans la table membres)
		if(isset($retour['pseudo']) && $retour['pseudo'] != '')
		{
			if($_SESSION['membre_mdp'] != $retour['mdp'])
			{
				//Dehors vilain pas beau !
				$informations = Array(/*Mot de passe de session incorrect*/
										true,
										'Session invalide',
										'Le mot de passe de votre session est incorrect, vous devez vous reconnecter.',
										'',
										ROOTPATH.'?page=connexion',
										3,
										'Session invalide'
										);
				require_once('information.php');
				vider_cookie();
				session_destroy();
				exit();
			}
			elseif($_SESSION['membre_groupe'] != $retour['groupe'])
			{
				if($_SESSION['membre_groupe'] != $retour['groupe'] && $retour['groupe'] == 'Bannis')
				{
					$information = array( /* Membre Bannis */
										true,
										'Vous avez été bannis.',
										'Vous avez été bannis de '.TITRESITE.'. Raison de votre ban :<br/>'.$retour['membre_bannis_raison'].'',
										'',
										ROOTPATH.'?page=contact',
										3,
										'Vous avez été bannis.'
										);
					require_once('information.php');
					vider_cookie();
					session_destroy();
					exit();
				}
				else
				{
					$informations = array( /* Groupe incorrect */
										true,
										'Session invalide',
										'Vous avez été déconnecter suite à un changement de votre groupe.',
										'',
										ROOTPATH.'?page=connexion',
										3,
										'Session invalide'
										);
					require_once('information.php');
					vider_cookie();
					session_destroy();
					exit();
				}
			}
			else
			{
				//Validation de la session.
					$_SESSION['membre_id'] = $retour['id'];
					$_SESSION['membre_pseudo'] = $retour['pseudo'];
					$_SESSION['membre_mdp'] = $retour['mdp'];
					$_SESSION['membre_groupe'] = $retour['groupe'];
					mysql_query("UPDATE site_membres
								SET derniere_visite = ".time()."
								WHERE id = ".$_SESSION['membre_id'])
								or ErrorSQL(__FILE__,__LINE__);
			}
		}
	}
	else //On vérifie les cookies et sinon pas de session
	{
		if(isset($_COOKIE['membre_id']) && isset($_COOKIE['membre_mdp'])) //S'il en manque un, pas de session.
		{
			if(intval($_COOKIE['membre_id']) != 0)
			{
				//idem qu'avec les $_SESSION
				$req = mysql_query("SELECT id, pseudo, mdp
									FROM site_membres
									WHERE id = ".intval($_COOKIE['membre_id']))
									or ErrorSQL(__FILE__,__LINE__);
				$retour = mysql_fetch_assoc($req);
				if(isset($retour['pseudo']) && $retour['pseudo'] != '')
				{
					if($_COOKIE['membre_mdp'] != $retour['mdp'])
					{
						//Dehors vilain tout moche !
						$informations = Array(/*Mot de passe de cookie incorrect*/
											true,
											'Mot de passe cookie erroné',
											'Le mot de passe conservé sur votre cookie est incorrect, vous devez vous reconnecter.',
											'',
											ROOTPATH.'?page=connexion',
											3,
											'Mot de passe cookie erroné'
											);
						require_once('information.php');
						vider_cookie();
						session_destroy();
						exit();
					}
					else
					{
						//Bienvenue :D
						$_SESSION['membre_id'] = $retour['id'];
						$_SESSION['membre_pseudo'] = $retour['pseudo'];
						$_SESSION['membre_mdp'] = $retour['mdp'];
						mysql_query("UPDATE site_membres
									SET derniere_visite = ".time()."
									WHERE id = ".$_SESSION['membre_id'])
									or ErrorSQL(__FILE__,__LINE__);
					}
				}
			}
			else //cookie invalide, erreur plus suppression des cookies.
			{
				$informations = Array(/*L'id de cookie est incorrect*/
									true,
									'Cookie invalide',
									'Le cookie conservant votre id est corrompu, il va donc être détruit, vous devez vous reconnecter.',
									'',
									ROOTPATH.'?page=connexion',
									3,
									'Cookie invalide'
									);
				require_once('information.php');
				vider_cookie();
				session_destroy();
				exit();
			}
		}
		else
		{
			//Fonction de suppression de toutes les variables de cookie.
			if(isset($_SESSION['membre_id'])) unset($_SESSION['membre_id']);
			vider_cookie();
		}
	}
	if(isset($_SESSION['membre_id'])) $id = $_SESSION['membre_id'];
	else $id = -1;
	updateConnectes($id);
}

function updateConnectes($id)
{
	$ip = getIp();
	if($id != -1)
	{
		$id = $_SESSION['membre_id'];
		$additionnal = 1; //la variable à mettre dans connectes_membre
		$pseudo = $_SESSION['membre_pseudo'];
		$sexe = $_SESSION['membre_sexe'];
		$groupe = $_SESSION['membre_groupe'];
		$inscription = $_SESSION['membre_inscription'];
	}
	else
	{
		$additionnal = $ip;
		$pseudo = '';
		$sexe = '';
		$groupe = '';
		$inscription = '';
	}
	mysql_query("DELETE
				FROM site_connectes
				WHERE connectes_actualisation < ".(time()-300))
				or ErrorSQL(__FILE__,__LINE__); //MàJ générale des connectés
	mysql_query("INSERT INTO site_connectes
				VALUES(".$id.", '".$ip."', '".$additionnal."', '".$pseudo."', '".$sexe."', '".$groupe."', '".$inscription."', ".time().")
				ON DUPLICATE KEY UPDATE connectes_actualisation=".time().", connectes_ip='".$ip."'")
				or ErrorSQL(__FILE__,__LINE__); //tiens, tiens, ON DUPLICATE... :o
}

function getIp()
{
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
	else return $_SERVER['REMOTE_ADDR'];
}


function get($type)
{
	if($type == 'nb_membres')
	{
		$sql = mysql_query("SELECT COUNT(*)
							AS nbr
							FROM site_membres")
							or ErrorSQL(__FILE__,__LINE__);
		$count = mysql_fetch_array($sql);
		return $count['nbr'];
	}

	else if($type == 'connectes')
	{
		$sql = mysql_query("SELECT COUNT(*)
							AS nbr
							FROM site_connectes")
							or ErrorSQL(__FILE__,__LINE__);
		$count = mysql_fetch_array($sql);
		return $count['nbr'];
	}
	else
	{
		return 0;
	}
}

function mepd($date)
{
	if(intval($date) == 0) return $date;

	$tampon = time();
	$diff = $tampon - $date;

	$dateDay = date('d', $date);
	$tamponDay = date('d', $tampon);
	$diffDay = $tamponDay - $dateDay;

	if($diff < 60 && $diffDay == '°')
	{
		return 'Il y a '.$diff.'s';
	}

	else if($diff < 600 && $diffDay == 0)
	{
		return 'Il y a '.floor($diff/60).'m et '.floor($diff%60).'s';
	}

	else if($diff < 3600 && $diffDay == 0)
	{
		return 'Il y a '.floor($diff/60).'m';
	}

	else if($diff < 7200 && $diffDay == 0)
	{
		return 'Il y a '.floor($diff/3600).'h et '.floor(($diff%3600)/60).'m';
	}

	else if($diff < 24*3600 && $diffDay == 0)
	{
		return 'Aujourd\'hui à '.date('H\hi', $date);
	}

	else if($diff < 48*3600 && $diffDay == 1)
	{
		return 'Hier à '.date('H\hi', $date);
	}

	else
	{
		return 'Le '.date('d/m/Y', $date).' à '.date('h\hi', $date).'';
	}
}

function vider_cookie()
{
	foreach($_COOKIE as $cle => $element)
	{
		setcookie($cle, '', time()-3600);
	}
}

function vidersession()
{
	foreach($_SESSION as $cle => $element)
	{
		unset($_SESSION[$cle]);
	}
}

function reset_mdp($mail, $pseudo, $mdp_aleat)
{
    $to = $mail;
    $subject = 'Mot de passe oublié';
    $message = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
        <head>
            <title>Mot de passe oublié</title>
            <style type="text/css">
            .id_result
            {
                font-weight : bold;
            }
            .lien
            {
                text-decoration : underline;
            }
            </style>
        </head>
        <body>
            <span style="color:red; font-style:2em; display:block; text-align:center;"><h1>Mot de passe oublié sur '.TITRESITE.' !</h1></span>
            <div style="padding:10px; margin:auto; text-indent:20px; font-style:italic;">
            Bonjour, vous avez demandé à avoir un nouveau mot de passe suite à l\'oubli de ce dernier.<br/>
            Voici votre nouveau mot de passe :<br/>
            -------------------------------------------------------------------<br/>
            Mot de passe : <span class="id_result">'.htmlspecialchars($mdp_aleat, ENT_QUOTES).'</span><br/>
            -------------------------------------------------------------------<br/>
            Pour pouvoir vous connecter avec votre nouveau mot de passe cliquer <a href="'.ROOTPATH.'/valid.php?pseudo='.htmlspecialchars($pseudo,ENT_QUOTES).'&amp;mdp='.htmlspecialchars(md5($mdp_aleat),ENT_QUOTES).'">ici</a>.<br/>
            Si le lien ne fonctionne pas ou a du mal à s\'ouvrir, copier coller cette adresse :<br/>
            <span class="lien">'.ROOTPATH.'/valid.php?pseudo='.htmlspecialchars($pseudo,ENT_QUOTES).'&amp;mdp='.htmlspecialchars(md5($mdp_aleat),ENT_QUOTES).'</span><br/>
            Nous vous informons de changer immédiatement votre mot de passe pour éviter la perte de celui-ci.<br/>
            -------------------------------------------------------------------<br/>
            Ceci est un message automatique, merci de ne pas y répondre, aucune réponse ne sera retounée.<br/>
            </div>
            <center>
				<p>En vous remerciant,
				Le Wembaster de '.TITRESITE.'.<br/>
				<a href="http://www.aide-land.fr/">Aide Land</a> © 2010 | Tous droits réservées.</p>
			</center>
        </body>
    </html>';
    //headers principaux.
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//headers supplémentaires
	$headers .= 'From: "Mot de passe oublié" <no-reply@aide-land.fr>' . "\r\n";
	$headers .= 'Cc: "" <duplicata@aide-land.fr>' . "\r\n";
	$mail = mail($to, $subject, $message, $headers);
	if($mail) return true;
	return false;
}

function inscription_mail($mail, $pseudo)
{
	$to = $mail;
	$subject = 'Inscription sur '.TITRESITE;
	$message = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>Inscription sur '.TITRESITE.'</title>
            <style type="text/css">
            .id_result
            {
                font-weight : bold;
            }
            .lien
            {
                text-decoration : underline;
            }
            </style>
		</head>
		<body>
			<span style="color:red; font-style:2em; display:block; text-align:center;"><h1>Inscription réussie sur '.TITRESITE.' !</h1></span>
            <div style="padding:10px; margin:auto; text-indent:20px; font-style:italic;">
				Nous souhaitons vous remercier de vous être inscris sur notre site. Nous faisons un rappel de vos identifiants en cas d\'oubli :<br/>
				-------------------------------------------------------------------<br/>
				Pseudo : <span class="id_result">'.htmlspecialchars($pseudo, ENT_QUOTES).'</span><br/>
				-------------------------------------------------------------------<br/>
				Votre compte doit être validé pour que vous puissiez vous connecter. Pour valider votre compte ceci est simple, veuillez cliquer <a href="'.ROOTPATH.'/valid.php?pseudo='.htmlspecialchars($pseudo, ENT_QUOTES).'&amp;mdp='.htmlspecialchars(md5($passe),ENT_QUOTES).'">ici</a>.<br/>
				Si le lien ne fonctionne pas ou a du mal à s\'ouvrir, copier coller cette adresse :<br/>
				<span class="lien">'.ROOTPATH.'/valid.php?pseudo='.htmlspecialchars($pseudo, ENT_QUOTES).'&amp;mdp='.htmlspecialchars(md5($passe),ENT_QUOTES).'</span><br/>
				Si toute fois vous avez du mal à valider votre compte pour tout type d\'erreur, veuillez contacter le Webmaster pour plus d\'informations.<br/>
				Nous vous rappellons que ces identifiants sont personnels, et ne doivent être communiqué à personne.<br/>
				--------------------------------------------------------------------<br/>
				Ceci est un message automatique, merci de ne pas y répondre.<br/>
			</div>
			<center>
				<p>En vous remerciant,
				Le Wembaster de '.TITRESITE.'.<br/>
				<a href="http://www.aide-land.fr/">Aide Land</a> © 2010 | Tous droits réservées.</p>
			</center>
		</body>
	</html>';
	//headers principaux.
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//headers supplémentaires
	$headers .= 'From: "Inscription '.TITRESITE.'" <no-reply@aide-land.fr>' . "\r\n";
	$headers .= 'Cc: "" <duplicata@aide-land.fr>' . "\r\n";
	$mail = mail($to, $subject, $message, $headers); //marche
	if($mail) return true;
	return false;
}

function modif_mail($membre_mail, $membre_pseudo, $mdp_actuel, $new_mdp)
{
	$to = $membre_mail;
	$subject = 'Modification de votre mot de passe  '.$membre_pseudo.'';
	$message = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>Modification du mot de passe</title>
            <style type="text/css">
            .id_result
            {
                font-weight : bold;
            }
            .lien
            {
                text-decoration : underline;
            }
            </style>
		</head>
		<body>
			<span style="color:red; font-style:2em; display:block; text-align:center;"><h1>Modification de votre mot de passe réussi !</h1></span>
            <div style="padding:10px; margin:auto; text-indent:20px; font-style:italic;">
				Suite à votre changement de mot de passe sur '.TITRESITE.', votre mot de passe à bien été changé. Voici votre nouveau mot de passe :<br/>
				-------------------------------------------------------------------<br/>
				Ancien mot de passe : <span class="id_result">'.htmlspecialchars($mdp_actuel,ENT_QUOTES).'</span><br/>
                Nouveau mot de passe : <span class="id_result">'.htmlspecialchars($new_mdp,ENT_QUOTES).'</span><br/>
				-------------------------------------------------------------------<br/>
                En raison du changement du mot de passe, votre compte viens d\'être passé en compte non validé. Pour pouvoir valider à nouveau votre compte, cliquer <a href="'.ROOTPATH.'/valid.php?pseudo='.htmlspecialchars($membre_pseudo,ENT_QUOTES).'&amp;mdp='.htmlspecialchars(md5($new_mdp),ENT_QUOTES).'">ici</a>.<br/>
                Si vous ne pouvez pas cliquer sur ce lien, copier et coller cette url dans votre barre d\'adresse :<br/>
                <span class="lien">'.ROOTPATH.'/valid.php?pseudo='.htmlspecialchars($membre_pseudo,ENT_QUOTES).'&amp;mdp='.htmlspecialchars(md5($new_mdp),ENT_QUOTES).'</span><br/>
				Si toute fois vous avez du mal à valider votre compte pour tout type d\'erreur, veuillez contacter un Administrateur.<br/>
				Nous vous rappellons que ces identifiants sont personnel, et ne doivent être transmis à personne.<br/>
				--------------------------------------------------------------------<br/>
				Ceci est un message automatique, merci de ne pas y répondre.<br/>
			</div>
			<center>
				<p>En vous remerciant,
				Le Wembaster de '.TITRESITE.'.<br/>
				<a href="http://www.aide-land.fr/">Aide Land</a> © 2010 | Tous droits réservées.</p>
			</center>
		</body>
	</html>';
	//headers principaux.
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//headers supplémentaires
	$headers .= 'From: "Modifcation de votre mot de passe sur '.TITRESITE.'" <no-reply@aide-land.fr>' . "\r\n";
	$headers .= 'Cc: "" <duplicata@aide-land.fr>' . "\r\n";
	$mail = mail($to, $subject, $message, $headers); //marche
	if($mail) return true;
	return false;
}

function contact_mail($pseudo, $email, $sujet, $jeux, $console, $message, $copy)
{
	// On vérifie si le membre veut une copie du mail
	if($copy === true)
	{
		$copy = $headers .= 'Cc: "" <'.$email.'>' . "\r\n";
	}
	else
	{
		$copy = $headers .= 'Cc: "" <duplicata@aide-land.fr>' . "\r\n";
	}
	// On vérifie le type de sujet pour le mail
	if(isset($jeux) && trim($jeux) != '')
	{
		$jeux = 'Jeu : '.$jeux.'<br/>';
	}
	else
	{
		$jeux = '';
	}
	if(isset($console) && trim($console) != '')
	{
		$console = 'Console : '.$console.'<br/>';
	}
	else
	{
		$console = '';
	}
	// Maintenant on défini les variables pour le mail
	$to = 'contact@aide-land.fr';
	$subject = $sujet;
	$message = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>'.$sujet.'</title>
		</head>
		<body>
			Le membre '.$pseudo.' a récemment utiliser le formulaire de contact.<br/>
			<hr/><br>
			Sujet : '.$sujet.'<br/>
			'.$console.'
			'.$jeux.'
			Message : '.nl2br($message).'
			<hr/><br/>
		</body>
	</html>';
	//headers principaux.
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//headers supplémentaires
	$headers .= 'From: "'.$sujet.' par '.$pseudo.'" <'.$email.'>' . "\r\n";
	$copy;
	$mail = mail($to, $subject, $message, $headers); //marche
	if($mail) return true;
	return false;
}

function correction_mail($pseudo, $mail, $a_t, $console, $jeu, $titre, $sous_titre, $type, $text, $chemin, $time, $id)
{
	// On fait toute sorte de vérification pour que le mail correspond au ajout d'astuce ou tutoriel
	if($a_t == 'tutoriel')
	{
		$e = 'e';
		$ee = '';
		$t = '';
	}
	else
	{
		$e = '\'';
		$ee = 'e';
		$t = 'tte';
	}

	$titre = $titre!=''?$titre:'';
	$sous_titre = $sous_titre!=''?$sous_titre:'';
	$type = $type!=''?$type:'';

	// Le destinataire principal
	$to = 'webmaster@aide-land.fr';
	// Le sujet
	$subject = 'Ajout d'.$e.' '.$a_t.'';
	// Le message
	$message = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>'.$subject.'</title>
		</head>
		<body>
			Le membre '.$pseudo.' a envoyé un'.$ee.' '.$a_t.' le '.date('d/m/Y à H:i:s', $time).'.<br/>
			<hr/><br>
			Ce'.$t.' '.$a_t.' est pour le jeu '.$jeu.' sur '.$console.'.<br/>
			Voilà maintenant des informations concernant l'.$e.' '.$a_t.'.<br/><hr/><br/>
			<h1>Titre : '.$titre.'</h1><br/>
			<h2>Sous titre : '.$sous_titre.'</h2><br/>
			<h3>Type : '.$type.'</h3><br/>
			Voilà un début du texte, suivi du lien pour allez corriger ce'.$t.' '.$a_t.'.
			<hr/>
			'.substr(nl2br(stripslashes($text)), 0, 1000).'
			<hr/><br/>
			Cliquez <a href="'.ROOTPATH.'/astuce/?correc=correc&amp;a=select&amp;id='.$id.'&amp;t='.$type.'">ici</a> pour prendre en charge et corriger ce'.$t.' '.$a_t.'.
			<hr/><br/>
			Ceci est un message automatique, merci de ne pas y répondre.
			<p style="display : block; margin:auto;">Cordialement, le webmaster.</p>
		</body>
	</html>';
	// Les headers principaux.
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//headers supplémentaires
	$headers .= 'From: "'.$subject.' par '.$pseudo.'" <'.$mail.'>' . "\r\n";
	// On recherche tous les membres qui ont le droit de corriger / traduire
	$sql = mysql_query("SELECT mail
						FROM site_membres
						WHERE rang >= '90' OR rang = '10' OR rang = '15' OR rang = '20'")
						or ErrorSQL(__FILE__,__LINE__);
	// puis on remplis la variable to
	while($req = mysql_fetch_array($sql))
	{
		$to .= ', '.$req['mail'].'';
	}
	$mail = mail($to, $subject, $message, $headers);
	if($mail) return true;
	return false;
}

function alert_mail($pseudo, $jeu, $console, $time_add, $id_occ, $pseudo_occ, $time_occ, $a_t)
{
	$sql = mysql_query("SELECT mail
						FROM site_membres
						WHERE pseudo = '".$pseudo."'")
	or ErrorSQL(__FILE__,__LINE__);
	$req = mysql_fetch_assoc($sql);
	if($a_t == 'tutoriel')
	{
		$e = '';
	}
	else
	{
		$e = 'e';
	}
	if(date("H") >= 17 OR date("H") <= 7)
	{
		$hi = 'Bonsoir';
	}
	else
	{
		$hi = 'Bonjour';
	}
	// Le destinataire principal
	$to = $req['mail'];
	// Le sujet
	$subject = 'Votre '.$a_t.' a été pris'.$e.' en charge.';
	// Le message
	$message = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>'.$subject.'</title>
		</head>
		<body>
			'.$hi.' '.$pseudo.', votre '.$a_t.' concernant le jeu '.$jeu.' sur '.$console.' ajouté'.$e.' le '.date('d/m/Y à H:i:s', $time_add).'
			a été pris'.$e.' en charge par <a href="'.ROOTPATH.'/?page=membre&amp;id='.$id_occ.'">'.$pseudo_occ.'</a> le '.date('d/m/Y à H:i:s', $time_occ).'.
			<hr/><br/>
			Ceci est un message automatique, merci de ne pas y répondre.
			<p style="display : block; margin:auto;">Cordialement, le webmaster.</p>
		</body>
	</html>';
	// Les headers principaux.
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//headers supplémentaires
	$headers .= 'From: "'.$subject.' par Help World" <no-reply@aide-land.fr>' . "\r\n";
	$mail = mail($to, $subject, $message, $headers);
	if($mail) return true;
	return false;
}

function anniv_mail($pseudo, $age, $mail)
{
	if(date("H") >= 17 OR date("H") <= 7)
	{
		$hi = 'Bonsoir';
	}
	else
	{
		$hi = 'Bonjour';
	}

	// Le destinataire principal
	$to = $mail;
	// Le sujet
	$subject = 'Joyeux anniversaire '.$pseudo;
	// Le message
	$message = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>'.$subject.'</title>
		</head>
		<body>
			'.$hi.' '.$pseudo.',

			L\'équipe d\'Help World tient à vous souhaiter un joyeux anniversaire pour vos '.$age.' ans.<br/>
			Que cette nouvelle année qui commence pour vous soit encore meilleure que la précédente !
			<hr/><br/>
			Ceci est un message automatique, merci de ne pas y répondre.
			<p style="display : block; margin:auto;">Cordialement, le webmaster.</p>
		</body>
	</html>';
	// Les headers principaux.
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	//headers supplémentaires
	$headers .= 'From: "'.$subject.' par Help World" <no-reply@aide-land.fr>' . "\r\n";
	$mail = mail($to, $subject, $message, $headers);
	if($mail) return true;
	return false;
}

function age($birth)
{
	$DATE = intArray(explode('/', $birth));
	$try = mktime(0, 0, 0, $DATE[1], $DATE[0], date('Y'));
	if(time() >= $try) $age = date('Y') - $DATE[2];
	else $age = date('Y') - $DATE[2] - 1;

	return $age;
}

function intArray($Array)
{
	foreach($Array as $cle => $element)
	{
		$Array[$cle] = intval($element);
	}

	return $Array;
}

function verif_auth($auth_necessaire)
{
	//Dans un premier temps, on vérifie si le membre est connecté
	if(isset($_SESSION['membre_id']))
	{
		$sql = mysql_query("SELECT level
							FROM site_membres
							WHERE id = '".$_SESSION['membre_id']."'")
		or ErrorSQL(__FILE__,__LINE__);
		$req = mysql_fetch_assoc($sql);
		$auth = $req['level'];
	}
	else
	{
		$auth = 1;
	}
	if($auth_necessaire < $auth)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function parseZCode($content) {

	// Parsage des balises
	$zcode = array(
		'`\[i\](.+)\[/i\]`isU',
		'`\[b\](.+)\[/b\]`isU',
		'`\[s\](.+)\[/s\]`isU',
        '`\[u\](.+)\[/u\]`isU',
		'`\[url\](.+)\[/url\]`isU',
		'`\[url=(.+)\](.+)\[/url\]`isU',
		'`\[img\](.+)\[/img\]`isU',
		'`\[quote\](.+)\[/quote\]`isU',
		'`\[quote nom=(.+)\](.+)\[/quote\]`isU',
		'`\[quote lien=(.+)\](.+)\[/quote\]`isU',
		'`\[size valeur=(.+)\](.+)\[/size\]`isU',
		'`\[spoiler nom=(.+)\](.+)\[/spoiler\]`isU',
		'`\[liste](.+)\[/liste\]`isU',
		'`\[puce](.+)\[/puce\]`isU'

	);

	$html = array(
		'<em>$1</em>',
		'<strong>$1</strong>',
		'<del>$1</del>',
        '<ins>$1</ins>',
		'<a href="$1">$1</a>',
		'<a href="$1">$2</a>',
		'<img src="$1" alt="$1" />',
		'<br /><span class="citation">Citation</span><div class="citation2">$1</div>',
		'<br /><span class="citation">Citation : $1</span><div class="citation2">$2</div>',
		'<br /><span class="citation"><a href="$1">Citation</a></span><div class="citation2">$2</div>',
		'<span class="$1">$2</span>',
		'<div align="center">
			<div class="quotetitle">
				<input type="button" value="$1" onclick="if (this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display != \'\') { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'\'; this.innerText = \'\'; this.value = \'$1\'; } else { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'none\'; this.innerText = \'\'; this.value = \'$1\'; }" />
			</div>
			<div class="quotecontent">
				<div style="display:none;">
					$2
				</div>
			</div>
		</div>',
		'<ul>$1</ul>',
		'<li><span class="list"></span>&nbsp;$1</li>'
	);

	$content = htmlspecialchars($content);
	$content = stripslashes($content);
	$content = preg_replace($zcode, $html, $content);

	// parsage des smilies
	$smiliesName = array(':magicien:', ':colere:', ':diable:', ':ange:', ':ninja:', '&gt;_&lt;', ':pirate:', ':zorro:', ':honte:', ':soleil:', ':\'\\(', ':waw:', ':\\)', ':D', ';\\)', ':p', ':lol:', ':euh:', ':\\(', ':o', ':colere2:', 'o_O', '\\^\\^', ':\\-°');
	$smiliesUrl  = array('magicien.png', 'angry.gif', 'diable.png', 'ange.png', 'ninja.png', 'pinch.png', 'pirate.png', 'zorro.png', 'rouge.png', 'soleil.png', 'pleure.png', 'waw.png', 'smile.png', 'heureux.png', 'clin.png', 'langue.png', 'rire.gif', 'unsure.gif', 'triste.png', 'huh.png', 'mechant.png', 'blink.gif', 'hihi.png', 'siffle.png');
	$smiliesPath = "http://www.siteduzero.com/Templates/images/smilies/";

	for ($i = 0, $c = count($smiliesName); $i < $c; $i++) {
		$content = preg_replace('`' . $smiliesName[$i] . '`isU', '<img src="' . $smiliesPath . $smiliesUrl[$i] . '" alt="smiley" />', $content);
	}

	// Rtours à la ligne
	$content = preg_replace('`\n`isU', '<br/>', $content);

	return $content;

}

function newUrl($var)
{
	$carac = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý','ÿ');
	$new_carac = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
	$var = str_replace($carac, $new_carac, $var);
	$var = str_replace(' ', '-', $var);
	$var = str_replace('\'', '', $var);
	$var = strtolower($var);
	return $var;
}

function modif($carac, $new_carac, $var)
{
	$var = $var;
	$var = str_replace($carac, $new_carac, $var);
	return $var;
}

function creer_etape($nb_etape, $img, $titre, $text, $lien_clique, $text_clique)
{
	if($lien_clique == '' && $text_clique == '')
	{
		$click = '';
	}
	else
	{
		$click = '<span class="etape_click">
					<a href="'.$lien_clique.'" onclick="window.open(this.href); return false">'.$text_clique.'</a>
				</span>';
	}
	$texte = '<table style="margin:auto;" class="etape_2f">
					<tr>
						<td align="left" class="liste_membreth">Étape n°'.$nb_etape.'</td>
					</tr>
					<tr>
						<td align="center" width="600px">
							<span class="etape_img"><img src="'.$img.'" title="Étape n°'.$nb_etape.'" /></span>
							<h2 class="titre_news">'.$titre.'</h2>
							<p class="texte_etape">
								<br/>'.$text.'
							</p>
							'.$click.'
						</td>
					</tr>
				</table>';
	return $texte;
}

function creer_action($faire_action, $conseil, $gain, $dialogue)
{
	$search = array(
	'#Level ([0-9]){0,} #isU',
	'#(([0-9]{3})\.([0-9]{3}) de Ki)#isU',
	'#(Héros|Guerrier|Défenseur|Magicien)#isU',
	'#(Agressif|Défensif|Aléatoire|Magicien)#isU');

	$replace = array(
	'<span class="level">$0</span>',
	'<span class="ki">$0</span>',
	'<span class="classe">$0</span>',
	'<span class="combo">$0</span>');
	if($faire_action == '')
	{
		$faire_action = 'Vous devez valider l\'étape en lisant le dialogue';
	}
	else
	{
		$faire_action = preg_replace($search, $replace, $faire_action);
	}

	if($gain != '')
	{
		/*
		$gain_character = 1;
		$gain_zenis = 2;
		$gain_senzu = 3;
		$gain_plume = 4;
		$gain_objet = 5;
		$gain_caps = 6;
		$gain_case = 7;
		$gain_menu = 8;
		$gain_quest_alt = 9;
		*/
		$character = '';
		$zenis = '';
		$senzu = '';
		$plume = '';
		$objet = '';
		$caps = '';
		$case = '';
		$menu = '';
		$quest = '';
		foreach($gain as $element_key => $details)
		{
			for($i=-1; $i<=$element_key; $i++)
			{
				switch($details[0])
				{
					case "1":
						$character = '<img src="'.$details[2].'" title="'.$details[1].'" /> '.$details[1].'<br/>';
					break;

					case "2":
						$zenis = '<img src="http://www.2fight.com/images/icos/zenis.png" title="Zénis" /> '.$details[1].' Zénis<br/>';
					break;

					case "3":
						$senzu = '<img src="http://www.2fight.com/images/objets/902s.png" title="Senzu" /> '.$details[1].' Senzu<br/>';
					break;

					case "4":
						$plume = '<img src="http://www.2fight.com/images/objets/904s.png" title="Plume" /> '.$details[1].' Plume de Phœnix<br/>';
					break;

					case "5":
						$objet = '<img src="'.$details[2].'" title="Objet" /> '.$details[1].'<br/>';
					break;

					case "10":
						$objet2 = '<img src="'.$details[2].'" title="Objet" /> '.$details[1].'<br/>';
					break;

					case "6":
						$caps = '<img src="'.$details[2].'" title="'.$details[1].'" /> '.$details[1].'<br/>';
					break;

					case "7":
						$case = $details[1].'<br/>';
					break;

					case "8":
						$menu = 'Nouveau menu disponible : '.$details[1].'<br/>';
					break;

					case "9":
						$quest = '<span class="lien_q_alt"><a href="'.ROOTPATH.'/astuce/?astuces=2fight&amp;type=mh&amp;a=debut&amp;q_alt='.$details[2].'" onclick="window.open(this.href); return false">Nouvelle quête alternative disponible : '.$details[1].'</a></span><br/>';
					break;
				}
			}
		}
	}

	$dialog = '';
	foreach($dialogue as $url => $label)
	{
		$dialog .= '<a href="'.$url.'" title="'.$label.'" onclick="window.open(this.href); return false">'.$label.'</a><br/>';
	}
	$gain_toto = '';
	if(isset($character) || isset($zenis) || isset($senzu) || isset($plume) || isset($objet) || isset($caps) || isset($case) || isset($menu))
	{
		if(isset($character))
		{
			$gain_toto .= $character;
		}
		if(isset($zenis))
		{
			$gain_toto .= $zenis;
		}
		if(isset($senzu))
		{
			$gain_toto .= $senzu;
		}
		if(isset($plume))
		{
			$gain_toto .= $plume;
		}
		if(isset($objet))
		{
			$gain_toto .= $objet;
		}
		if(isset($objet2))
		{
			$gain_toto .= $objet2;
		}
		if(isset($caps))
		{
			$gain_toto .= $caps;
		}
		if(isset($case))
		{
			$gain_toto .= $case;
		}
		if(isset($menu))
		{
			$gain_toto .= $menu;
		}
		if(isset($quest))
		{
			$gain_toto .= $quest;
		}
	}
	else
	{
		$gain_toto = 'Aucun gain pour cette étape';
	}
	if($conseil == '')
	{
		$conseil = 'Aucun pour cette étape';
	}
	$action = '
	<span class="action">
		<ul>
			<li><span class="donnees">Action à réaliser : </span>'.$faire_action.'</li>
			<li><span class="donnees">Conseil : </span>'.$conseil.'</li>
			<li><span class="donnees">Gain : </span>'.$gain_toto.'</li>
			<li><span class="donnees">Revoir les dialogues : </span>'.$dialog.'</li>
		</ul>
		<span class="action_fin"></span>
	</span>';

	return $action;
}

function creer_sommaire($id, $texte)
{
	$texte = '<li><span class="list"></span>&nbsp;<a href="'.ROOTPATH.'/astuce/?astuces=2fight&amp;type=mh&amp;a=debut#'.$id.'">'.$texte.'</a></li>';

	return $texte;
}

function get_list_page($page, $nb_page, $nb = 2)
{
	$list_page = array();
	for ($i=1;$i <= $nb_page;$i++)
	{
		if (($i < $nb) OR ($i > $nb_page - $nb) OR (($i < $page + $nb) AND ($i > $page -$nb)))
		$list_page[] = $i;
		else
		{
			if ($i >= $nb AND $i <= $page - $nb)
					$i = $page - $nb;
			elseif ($i >= $page + $nb AND $i <= $nb_page - $nb)
					$i = $nb_page - $nb;
			$list_page[] = '...';
		}
	}
	return $list_page;
}

function creerFichier($fichierChemin, $fichierNom, $fichierExtension, $fichierContenu, $droit="")
{
	$fichierCheminComplet = $_SERVER["DOCUMENT_ROOT"].$fichierChemin."/".$fichierNom;
	if($fichierExtension!="")
	{
		$fichierCheminComplet = $fichierCheminComplet.".".$fichierExtension;
	}

	// création du fichier sur le serveur
	$leFichier = fopen($fichierCheminComplet, "wb");
	fwrite($leFichier,$fichierContenu);
	fclose($leFichier);

	// la permission
	if($droit=="")
	{
		$droit="0777";
	}

	// on vérifie que le fichier a bien été créé
	$t_infoCreation['fichierCreer'] = false;
	if(file_exists($fichierCheminComplet)==true)
	{
		$t_infoCreation['fichierCreer'] = true;
	}

	// on applique les permission au fichier créé
	$retour = chmod($fichierCheminComplet,intval($droit,8));
	$t_infoCreation['permissionAppliquer'] = $retour;

	return $t_infoCreation;
}

function ErrorSQL($f, $l)
{
	exit('Fichier : '.$f.'<br />Ligne : '.$l.'<br />Erreur sql : '.mysql_error());
}

function add_SQL($var)
{
	$var = trim(mysql_real_escape_string($var));

	return $var;
}

function secu_var($var)
{
	$var = htmlspecialchars($var);

	return $var;
}

function quit($texte)
{
	$texte = exit('<br/><div id="erreur"><strong>'.$texte.'</strong></div>
							</div>
						<div class="nb"></div> <!-- Fin news -->
					</div><!-- Fin centre -->
					<div class="clear"></div><!-- NE PAS SUPPRIMER -->
					</div><!-- Fin Global -->
					<div id="pied"><!-- Pied -->
						<div id="piedlien">
							<div id="piedgauche"><!-- Gauche -->
							</div><!-- Fin gauche -->

							<div id="pieddroite"><!-- Droite -->
							</div><!-- Fin droite -->

							<div id="piedcentre"><!-- Centre -->
								<span>Mentions :</span>
								<br />
								<a href="<?php echo ROOTPATH; ?>">Help World</a> © Tous Drois Réservées<br/>
								<!-- mention de copyright Ne pas retirer sans autorisation écrite Design <a href="http://www.kitgraphiquegratuit.org" onclick="window.open(this.href); return false;" title="Kits gratuits" >Kit Graphique</a> -->
								Design <a href="http://www.kitgraphiquegratuit.org" onclick="window.open(this.href); return false;" title="Kits gratuits" >Kit Graphique</a> |
								<!-- mention de copyright Ne pas retirer sans autorisation écrite Design <a href="http://www.kitgraphiquegratuit.org" onclick="window.open(this.href); return false;" title="Kits gratuits" >Kit Graphique</a> -->
								valide <a href="http://validator.w3.org/check?uri=referer" onclick="window.open(this.href); return false;">XHTML strict</a> &amp; <a href="http://jigsaw.w3.org/css-validator/check/referer" onclick="window.open(this.href); return false;">CSS3</a><br /><br />
							</div><!-- Fin Droite -->
						</div>
					</div><!-- Fin Pied -->
				</body>
			</html>');
	return $texte;
}
?>
