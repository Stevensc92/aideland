<?php
if(!isset($_SESSION['membre_id']))
{
	$informations = array(
					true,
					'Accès impossible',
					'Accès réservé. Vous ne pouvez entrer.',
					'',
					ROOTPATH,
					3
					);
	require_once('information.php');
	exit();
}
else
{
	$pseudo = array('Stevens');
	if(!in_array($_SESSION['membre_pseudo'], $pseudo))
	{
		$informations = array(
						true,
						'Accès impossible',
						'Accès réservé. Vous ne pouvez entrer.',
						'',
						ROOTPATH,
						3
						);
		require_once('information.php');
		exit();
	}
	else
	{
		function site($url, $s = NULL)
		{
			if($s != NULL)
			{
				$lien = '<a href="https://'.$url.'" target="_blank">'.$url.'</a>';
				return $lien;
			}
			else
			{
				$lien = '<a href="http://'.$url.'" target="_blank">'.$url.'</a>';
				return $lien;
			}
		}
		$titre = 'Info';
		$titre2 = $titre;
		include('includes/haut.php');
		if(isset($_POST['info']))
		{
			$password = htmlspecialchars($_POST['password']);
			$good_mdp = '/*/73aty98op/*/';
			if($password == $good_mdp)
			{
				echo '<div id="content">';
					echo '<div class="nh"></div>';
					echo '<div class="nf">';
						echo '<div id="fil_ariane">';
							echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?mod=info', $titre2);
						echo '</div>';
						echo '<br/><h1>'.$titre2.'</h1><br/>';
						echo '<h2 class="titre_news">Site internet</h2><br/>';
						echo '<ul>';
							echo '<li>'.site('aide-land.fr').'</li>';
							echo '<ul>';
								echo '<li>Pseudo : Stevens</li>';
								echo '<li>Mot de passe : 11089492</li>';
							echo '</ul>';
							echo '<li>'.site('2fight.com').'</li>';
							echo '<ul>';
								echo '<li>Pseudo : Na-Tsus</li>';
								echo '<li>Mot de passe : /*/73aty98op/*/</li>';
							echo '</ul>';
							echo '<li>'.site('youtube.com').'</li>';
							echo '<ul>';
								echo '<li>Pseudo : N4Tsus</li>';
								echo '<li>Mot de passe : 11089492</li>';
							echo '</ul>';
							echo '<li>'.site('site.flyforangel.eu').'</li>';
							echo '<li>'.site('proxon.net/index.php').'</li>';
							echo '<ul>';
								echo '<li>Pseudo : Shimaro</li>';
							echo '</ul>';
							echo '<li>'.site('siteduzero.com').'</li>';
							echo '<ul>';
								echo '<li>Pseudo : Na-tsu</li>';
							echo '</ul>';
							echo '<li>'.site('britania.ws/forum').'</li>';
							echo '<ul>';
								echo '<li>Pseudo : Shimaro</li>';
							echo '</ul>';
							echo '<li>'.site('underground-flyff.fr/').'</li>';
							echo '<ul>';
								echo '<li>Pseudo : Selenia</li>';
							echo '</ul>';
							echo '<li>'.site('admin.1and1.fr/xml/config/Login;jsessionid=035719CA72BDFC028BCC9C73222A1C99.TCpfix81a?__reuse=1295635295633', 'lol').'</li>';
							echo '<ul>';
								echo '<li>ID : 26672716</li>';
							echo '</ul>';
							echo '<li>'.site('forum.downparadise.ws/index.php').'</li>';
							echo '<ul>';
								echo '<li>Pseudo : Shimaro</li>';
							echo '</ul>';
						echo '</ul>';
						echo '<h2 class="titre_news">Logiciel</h2><br/>';
						echo '<ul>';
							echo '<li>'.site('megaupload.com/?d=D7N84G9C').' Fraps Cracker</li>';
							echo '<li>'.site('downloads.sourceforge.net/filezilla/FileZilla_3.3.5.1_win32-setup.exe').' Filezilla</li>';
							echo '<li>'.site('wampserver.com/dl32.php').' Wamp 2.1</li>';
							echo '<li>'.site('download.tuxfamily.org/notepadplus/5.8.6/npp.5.8.6.Installer.exe').' Notepad 5.8.6</li>';
							echo '<li>'.site('windows-live-messenger-2009.softonic.fr/').' Msn 2009</li>';
							echo '<li>'.site('www.msgpluslive.fr/download/').' Msn +</li>';
							echo '<li>'.site('01net.com/telecharger/windows/Multimedia/animation_2d_et_3d/fiches/15692.html').' Adobe After Effect</li>';
							echo '<li>'.site('techsmith.fr/download/camtasiatrial.asp').' Camtasia</li>';
							echo '<li>'.site('forum.downparadise.ws/viewtopic.php?f=169&t=304315&hilit=photoshop+cs5').' Photoshop CS5</li>';
							echo '<li>'.site('forum.downparadise.ws/search.php?keywords=sony+vegas&terms=all&author=&sc=1&sf=titleonly&sk=t&sd=d&sr=topics&st=0&ch=300&t=0&submit=Rechercher').' Sony Vegas</li>';
						echo '</ul>';
						echo '<h2 class="titre_news">Jeu</h2><br/>';
						echo '<ul>';
							echo '<li>Insanity Flyff</li>';
							echo '<li>S4 League</li>';
						echo '</ul>';
						echo '<br/>';
					echo '</div>';
					echo '<div class="nb"></div>';
				echo '</div>';
			}
			else
			{
				echo '<div id="content">';
					echo '<div class="nh"></div>';
					echo '<div class="nf">';
						echo '<div id="fil_ariane">';
							echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?mod=info', $titre2);
						echo '</div>';
						echo '<br/><h1>'.$titre2.'</h1><br/>';
						echo '<p>';
							echo 'Bonjour, pour pouvoir accèder au contenu de cette page, vous devez ';
							echo 'entrer le mot de passe que aviez reçu.';
						echo '</p>';
						echo '<form method="post" action="#">';
							echo '<input type="password" name="password" /><br/>';
							echo '<input type="submit" value="Voir le contenu" name="info" />';
						echo '</form>';
					echo '</div>';
					echo '<div class="nb"></div>';
				echo '</div>';
			}
		}
		else
		{
			echo '<div id="content">';
				echo '<div class="nh"></div>';
				echo '<div class="nf">';
					echo '<div id="fil_ariane">';
						echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?mod=info', $titre2);
					echo '</div>';
					echo '<br/><h1>'.$titre2.'</h1><br/>';
					echo '<p>';
						echo 'Bonjour, pour pouvoir accèder au contenu de cette page, vous devez ';
						echo 'entrer le mot de passe que aviez reçu.';
					echo '</p>';
					echo '<form method="post" action="#">';
						echo '<input type="password" name="password" /><br/>';
						echo '<input type="submit" value="Voir le contenu" name="info" />';
					echo '</form>';
				echo '</div>';
				echo '<div class="nb"></div>';
			echo '</div>';
		}
	}
}
?>