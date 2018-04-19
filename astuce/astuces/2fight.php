<?php
/*
astuce/astuces/2fight.php

Astuce du jeux 2Fight
*/
if(isset($_GET['type']))
{
	$type = array('mh' => 'Mode Histoire');
	if($_GET['type'] == 'mh')
	{
		/* Titre de la page */
		$titre = 'Astuce : 2Fight - '.$type[$_GET['type']];
		/********************/
		
		/* Définition du TITRE du CADRE du contenu de la page */
		$titre2 = 'Astuce : 2Fight - '.$type[$_GET['type']];
		/******************************************************/

		/* Haut de la page, contient le doctype, charset, etc... */
		include('../includes/haut.php');
		/*********************************************************/
		?>
		<div class="content"><!-- Début centre -->	 
			<div class="nh"></div> <!-- News -->
				<div class="nf">
					<div id="fil_ariane">
						<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Liste des astuces').' '.fil_ariane(1, 'astuce/', 'Choix d\'un jeu').' '.fil_ariane(1, 'astuce/?astuces=2fight', 'Liste des astuce du jeux '.$_GET['astuces'].'').' '.fil_ariane(1, 'astuce/?astuces=2fight&amp;type='.$_GET['type'].'', 'Astuce du '.$type[$_GET['type']].'').' '.fil_ariane(2, '', 'Lecture de l\'astuce du '.$type[$_GET['type']].''); ?>
					</div>
					<div id="astuce_2fight">
						<br/>
						<h1>Astuce du mode histoire</h1>
						<br/>
						
						<?php
						if(!isset($_GET['a']))
						{
						?>
						<div class="intro">
							<div id="sommaire">
								<h3>Sommaire :</h3>
								<ul>
									<?php echo creer_sommaire('saga_tutoriel', 'Saga Tutoriel'); ?>
									<?php echo creer_sommaire('saga_quetedb', 'Saga Quête des DBs'); ?>
									<?php echo creer_sommaire('saga_21etournoi', 'Saga 21ème Tournoi'); ?>
									<?php echo creer_sommaire('saga_rubanrouge', 'Saga Ruban Rouge'); ?>
									<?php echo creer_sommaire('saga_babavoyante', 'Saga Baba la voyante'); ?>
									<?php echo creer_sommaire('saga_22etournoi', 'Saga 22ème Tournoi'); ?>
									<?php echo creer_sommaire('saga_piccolo_le_demon', 'Saga Piccolo le Démon'); ?>
									<?php echo creer_sommaire('saga_23etournoi', 'Saga 23ème Tournoi'); ?>
									<?php echo creer_sommaire('saga_saiyans', 'Saga Saiyans'); ?>
									<?php echo creer_sommaire('saga_namek', 'Saga Namek'); ?>
								</ul>
							</div>
							<p>Entre dans le mode aventure, c'est un tutoriel, tu vas découvrir tous les secrets du jeu !</p>
							<a href="<?php echo ROOTPATH; ?>/astuce/?astuces=2fight&amp;type=mh&amp;a=debut"><img src="http://www.2fight.com/images/histoire/image/beginDB.jpg" title="Début du Mode Histoire" /></a>
							<p>Cliquez sur l'image pour commencer l'aventure ;).</p>
						</div>
						<?php
						}
						elseif(isset($_GET['q_alt']))
						{
							if(intval($_GET['q_alt']))
							{
								include('q_alt_'.$_GET['q_alt'].'.php');
							}
							else
							{
								echo '<span class="erreur">Erreur dans le lien.</span>';
							}
						}
						else
						{
						?>
						<div class="mh_2f">
							<div id="sommaire">
								<h3>Sommaire :</h3>
								<ul>
									<?php echo creer_sommaire('saga_tutoriel', 'Saga Tutoriel'); ?>
									<?php echo creer_sommaire('saga_quetedb', 'Saga Quête des DBs'); ?>
									<?php echo creer_sommaire('saga_21etournoi', 'Saga 21ème Tournoi'); ?>
									<?php echo creer_sommaire('saga_rubanrouge', 'Saga Ruban Rouge'); ?>
									<?php echo creer_sommaire('saga_babavoyante', 'Saga Baba la voyante'); ?>
									<?php echo creer_sommaire('saga_22etournoi', 'Saga 22ème Tournoi'); ?>
									<?php echo creer_sommaire('saga_piccolo_le_demon', 'Saga Piccolo le Démon'); ?>
									<?php echo creer_sommaire('saga_23etournoi', 'Saga 23ème Tournoi'); ?>
									<?php echo creer_sommaire('saga_saiyans', 'Saga Saiyans'); ?>
									<?php echo creer_sommaire('saga_namek', 'Saga Namek'); ?>
								</ul>
							</div>						
							<div class="intro">
								<img src="http://img27.imageshack.us/img27/7035/babab.png" title="Intro" />
							</div>
							<br/>
							<h2 id="saga_tutoriel">Saga Tutoriel</h2>
							<br/>
							<?php echo creer_etape(
										'1',
										'http://www.2fight.com/images/obsc/d004cca4b97f.jpg',
										'Bienvenue dans 2Fight !',
										'C\'est ici que tu vas découvrir le jeu, on va tout te montrer point par point, et en s\'amusant j\'espère !
											Commençons par un combat !',
										'http://2fight.com/index.php?page=histoire&amp;ev=224&amp;findialogue=1',
										'Clique ici !!');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Combattre Wolfy <span class="level">Level 1</span> avec <span class="ki">13.000 de Ki</span> classe Héros en combo Agressif </li>
									<li>Conseil : Combattez seulement Wolfy, ne faite aucune autre action tel que fouiller jusqu'à nouvel ordre.</li>
									<li>Gain : <img src="http://www.2fight.com/images/objets/902s.png" title="Senzu" /> 1 Senzu<br/>
										Le bouton "Perso" est apparut.<br/>
										Vous avez la possibilité d'accèder à la page Perso sur votre personnage en cours.</li>
									<li>Revoir le dialogue : Aucun pour cette étape</li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'2',
										'http://www.2fight.com/images/obsc/d087d6d3fcb8.jpg',
										'Commençons le Jeu !',
										'Mon petit, il va falloir commencer par comprendre comment marche ton personnage.',
										'http://www.2fight.com/index.php?page=histoire&oldev=147',
										'Clique ici');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Attribuer les 450 points bonus.</li>
									<li>Conseil : Choissisez bien où vous voulez répartir vos points, aucun retour en arrière ne sera possible.</li>
									<li>Gain : <img src="http://www.2fight.com/images/objets/902s.png" title="Senzu" /> 1 Senzu</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=147" onclick="window.open(this.href); return false">Découvrir son personnage</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'3',
										'http://www.2fight.com/images/obsc/ac580da1337c.jpg',
										'Booste tes caracs !',
										'Tu vas t\'entrainer maintenant... Exceptionnellement ce sera gratuit et immédiat !',
										'http://www.2fight.com/index.php?page=histoire&oldev=148',
										'Clique ici...');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Faire un entraînement <a href="http://www.2fight.com/index.php?page=entrainement&entrainement=maison" onclick="window.open(this.href); return false" title="Entraînement maison">ici</a></li>
									<li>Conseil : Cette entraînement est donc gratuit, choissisez alors +150 en résistance ;).</li>
									<li>Gain : <img src="http://www.2fight.com/images/caps/jaune.png" title="Capsule jaune" />Éveil de Rou Dai Kaiôshin <br/>
										<img src="http://www.2fight.com/images/caps/jaune.png" title="Capsule jaune" />Armure lourde <br/>
										Deux nouveaux lien se débloque dans le menu "Perso" : <br/>
										- Capsules, qui vous permet d'équiper, enlever, regarder vos capsules et<br/>
										- Objets, qui vous permet de regarder vos objets que vous avez, et d'en utiliser.</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=148" onclick="window.open(this.href); return false">Fait un entraînement !</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'4',
										'http://www.2fight.com/images/obsc/995a70c04d08.jpg',
										'Le pouvoir des capsules',
										'Tu as maintenant accès à "Capsules" et "Objets" dans le menu "Persos".
										Les objets sont de type divers, et leurs utilisations sont très aléatoires. Certains... ne servent à rien !
										Pour les capsules...',
										'http://www.2fight.com/index.php?page=histoire&oldev=149',
										'clique ici');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Équiper une ou deux capsules <a href="http://www.2fight.com/index.php?page=capsules" onclick="window.open(this.href); return false" title="Page capsule">ici</a></li>
									<li>Conseil : Aucun pour cette étape.</li>
									<li>Gain : <img src="http://www.2fight.com/images/objets/902s.png" title="Senzu" /> 1 Senzu<br/>
										Dans le menu à gauche, vous avez la possibilité d'accèder à votre messagerie.<br/>
										Le menu "Monde" apparaît enfin. Aucune case ne se débloque sur la carte.</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=149" onclick="window.open(this.href); return false">Baba explique les capsules</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<h2 id="saga_quetedb">Saga Quête des DBs</h2>
							<br/>
							<?php echo creer_etape(
										'5',
										'http://www.2fight.com/images/obsc/65ab1eb2f442.jpg',
										'Ton premier combat !!',
										'Continue ta quête... et va parler à Mamie Voyante dans le menu "Monde".<br/>
										Aide : Ta barre de vie baisse quand tu te prends des coups, mais remonte 
										toute seule de quelques milliers de points par heure.',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Combattre & gagner contre <img src="http://www.2fight.com/images/obsc/80e1cebc90c9.gif" title="Bulma" />Bulma <span class="level">Level 1</span> avec <span class="ki">15.000 de Ki</span>
									classe Héros en combo Défensif <a href="http://www.2fight.com/index.php?page=histoire&oldev=150&findialogue=1" onclick="window.open(this.href); return false" title="Combat contre Bulma">ici</a></li>
									<li>Conseil : Choissisez le combos Agressif.</li>
									<li>Gain : <img src="http://www.2fight.com/images/obsc/80e1cebc90c9.gif" title="Bulma" />Bulma<br/>
										Une nouvelle case se débloque, la case F-8 (L'île au tournois).</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=150" onclick="window.open(this.href); return false">Le premier combat</a><br/>
										<a href="http://www.2fight.com/index.php?page=histoire&oldev=151" onclick="window.open(this.href); return false">Tu as vaincu ce terrible monstre !</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'6',
										'http://www.2fight.com/images/obsc/e04e2bc5d654.jpg',
										'Duo de Héros !',
										'Tu as maintenant deux personnages. Chacun a des caractéristiques personnalisables,
										et tu peux jouer l\'un pendant que l\'autre est occupé (entraînement, travail...).
										Mais... mais.... y\'a plus Baba dans le menu "Monde" !? Jette un œil à la carte... et change de case !',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Lire le dialogue en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8" onclick="window.open(this.href); return false">F-8</a> </li>
									<li>Conseil : Aucun pour cette étape.</li>
									<li>Gain : <img src="http://www.2fight.com/images/boule2.gif" title="Dragon ball à 2 étoiles" /> Dragon Ball à 2 étoiles<br/>
										<img src="http://www.2fight.com/images/boule5.gif" title="Dragon ball à 5 étoiles" /> Dragon Ball à 5 étoiles<br/>
										Une nouvelle case se débloque, la case I-7 (Kame house).</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=152" onclick="window.open(this.href); return false">La suite du mode histoire, c'est par ici !</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'7',
										'http://www.2fight.com/images/obsc/3d058ab93db9.jpg',
										'',
										'Trouve la prochaine Dragon Ball... cherche le nouveau lieu disponible dans la carte !
										Aide (qui n\'a rien à voir): En combat, à chaque "round", ton personnage ne peut faire
										que deux actions différentes : soit il attaque, soit il défend. Dans le premier cas, il
										enlèvera des points à l\'adversaire, dans le second, il augmentera ses capacité de défenses.',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Lire le dialogue en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8" onclick="window.open(this.href); return false">F-8</a> </li>
									<li>Conseil : Aucun pour cette étape.</li>
									<li>Gain : <img src="http://www.2fight.com/images/caps/rouge.png" title="Capsule rouge" /> Janken</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=153" onclick="window.open(this.href); return false">À la recherche des DBs</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'8',
										'http://www.2fight.com/images/obsc/77c2b7e02a74.jpg',
										'Le cadeau de Tortue Gé-- de Kamesennin',
										'Maître Kame Sennin va t\'apprendre à utiliser les techniques
										spéciales, avec les capsules rouges.',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Rendez-vous en <a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=7" onclick="window.open(this.href); return false">I-7</a><br/>
									Équiper la capsule  <img src="http://www.2fight.com/images/caps/rouge.png" title="Capsule rouge" /> Janken<br/>
									Combattre & utiliser la capsule Janken (Combo : Magicien) contre Muten Rôshi <span class="level">Level 3</span> avec <span class="ki">174.000 de Ki</span></li>
									<li>Conseil : Ce n'est pas un véritable conseil, mais nous n'avez pas besoin de gagner ce combat.</li>
									<li>Gain : <img src="http://www.2fight.com/images/objets/902s.png" title="Senzu" /> 1 Senzu</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=154" onclick="window.open(this.href); return false">Le cadeau de Kamesennin</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'9',
										'http://www.2fight.com/images/obsc/344dd7964dc1.jpg',
										'Un cadeau pour Kamesennin',
										'Le vieux maître en demande beaucoup !
										Aide (qui n\'a rien à voir): En combat, tu donnes un coup
										dont la puissance est visible dans la barre "Attaque". 
										Mais l\'adversaire ne se prends pas tout : il absorbe une
										partie (barre "Absorption"). La vie qu\'il perds réellement
										s\'envole au-dessus de lui...',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Fouiller sur le même emplacement pour trouver un magazine cochon : <img src="http://www.2fight.com/images/obsc/ab1b97929cb6.jpg" title="Magazine cochon" /></li>
									<li>Conseil : Fouiller au même endroit où vous êtes.</li>
									<li>Gain : <img src="http://www.2fight.com/images/boule3.gif" title="Dragon ball à 3 étoiles" /> Dragon Ball à 3 étoiles<br/>
										Une nouvelle case se débloque, la case D-5 (Capital).</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=155" onclick="window.open(this.href); return false">Kamesennin veut un cadeau</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'10',
										'http://www.2fight.com/images/obsc/c07144eecb05.jpg',
										'Tu es maître des capsules',
										'De nombreux autres lieux s\'ouvrent à toi.
										Bulma te propose de passer par chez elle, dans la capitale !
										Aide (qui n\'a rien à voir): En combat, tu fais une "Esquive"
										parfois et évite tout le coup. Cela n\'a rien à voir avec l\'"Absorption" !
										Quand tu es en défense, que tu as beaucoup de Résistance, cela augmente tes possibilité d\'Esquives.',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Lire le dialogue en <a href="http://www.2fight.com/index.php?page=carte&case_x=4&case_y=5" onclick="window.open(this.href); return false">D-5</a> puis valider l'étape.</li>
									<li>Conseil : Aucun pour cette étape.</li>
									<li>Gain : <img src="http://www.2fight.com/images/objets/902s.png" title="Senzu" /> 1 Senzu<br/>
										Une nouvelle case se débloque, la case C-9 (Coin perdu).</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=156" onclick="window.open(this.href); return false">Suite du mode histoire, ici !</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'11',
										'http://www.2fight.com/images/obsc/6be172cf0c53.jpg',
										'Le terrible démon Oolong',
										'La quête pour les Dragon Ball continue. Le radar t\'indique <a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=9" onclick="window.open(this.href); return false">C-9</a> ...
										Une fois le Dragon Ball récupéré, tu pourras combattre les autres joueurs !',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Combattre & gagner contre Oolong <span class="level">Level 1</span> avec <span class="ki">35.000 de Ki</span>
									classe Héros en combo Aléatoire en <a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=9">C-9</a> </li>
									<li>Conseil : Attaquer en combo agressif.</li>
									<li>Gain : <img src="http://www.2fight.com/images/boule6.gif" title="Dragon ball à 6 étoiles" /> Dragon Ball à 6 étoiles<br/>
												<img src="http://www.2fight.com/images/icos/zenis.png" title="zénis" /> 1.000 Zénis</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=158" onclick="window.open(this.href); return false">Le village terrorisé</a><br/>
															<a href="http://www.2fight.com/index.php?page=histoire&oldev=160" onclick="window.open(this.href); return false">Après le combat</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'12',
										'http://www.2fight.com/images/obsc/4b0f05558f97.jpg',
										'Le test de respect',
										'Oolong se conduira-t-il en bon garçon ?',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Répondre aux questions posé sur la charte.<br/> Une seule bonne réponse est suffisante.<br/>
										Nous ne vous donnerons pas les réponses pour que<br/> vous puissiez rechercher par vous mêmes.</li>
									<li>Conseil : Aucun pour cette étape.</li>
									<li>Gain : <img src="http://www.2fight.com/images/objets/902s.png" title="Senzu" />1 Senzu<br/>
										Une grande majeure partie de la carte se débloque. <br/>
										Notamment la case I-5 (Satan city). La case E-3 (Deset champignongs).<br/>
										La case B-5 (Tour karine).<br/>
										Le menu "Fight" apparaît enfin, vous pouvez accèder
										au combat contre d'autre joueurs et aller sur
										la page du mode histoire directement par ce menu.<br/>
										Le menu "Amis" a aussi fait son apparition.<br/>
										Vous pouvez accèder au forum, à la charte, au module du parrainage, et sur 2Fighteur avec l'add-On.</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=159" onclick="window.open(this.href); return false">Bien se comporter</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'13',
										'http://www.2fight.com/images/obsc/368ea5df652e.jpg',
										'La grande ouverture du monde !',
										'Attention, si tu sors d\'une ville, d\'autres pourront t\'attaquer !
										Écoute mes conseils en C-9 si tu veux pas finir taillé en frites !',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Faire 10 combats en dehors d'une ville, puis revenez valider.</li>
									<li>Conseil : Rendez-vous sur la fiche de votre personnage, et choissisez la combo par défaut.</li>
									<li>Gain : <img src="http://www.2fight.com/images/objets/902s.png" title="Senzu" />1 Senzu</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=162" onclick="window.open(this.href); return false">Comment se battre hors des villes</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'14',
										'http://www.2fight.com/images/obsc/67c8771a5569.jpg',
										'Le voleur du désert',
										'Votre détecteur pointe sur "Mont Fry Pan" pour la prochaine Dragon Ball.
										Entre votre étape précédente et ce point, c\'est un chemin pile en diagonale...
										Votre prochaine étape se situe sur ce chemin... entre C-9 et F-6 ! (si vous avez compris, ce n\'est PAS la peine de cliquer sur les liens)',
										'',
										'');							
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Combattre & gagner contre Yamcha <span class="level">Level 2</span> avec <span class="ki">63.500 de Ki</span>
									classe Héros en combo Aléatoire en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=7" onclick="window.open(this.href); return false">E-7</a></li>
									<li>Conseil : Attaquer en compo Agressif.</li>
									<li>Gain : <img src="http://www.2fight.com/images/obsc/82ee1a696e3f.gif" title="Yamcha" />Yamcha</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=163" onclick="window.open(this.href); return false">Le voleur du désert !!</a><br/>
										<a href="http://www.2fight.com/index.php?page=histoire&oldev=164" onclick="window.open(this.href); return false">Après le combat</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'15',
										'http://www.2fight.com/images/obsc/041cbd7c2929.jpg',
										'Le Mont Pan Fry',
										'Retrouvez Gyumao en F-6, là où la boule brille...<br/>
										Le roi Gyumao sera-t-il tendre avec vous ?...<br/>
										Ou vous enverra-t-il faire une quête ? C\'est quoi ce RPG ?',
										'',
										'');							
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Yamcha doit combattre Chichi <span class="level">Level 3</span> avec <span class="ki">78.000 de Ki</span>
									classe Héros en combo Magicien en <a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=7">I-7</a></li>
									<li>Conseil : Faite tous vos entraînements force / résistance à chaque level up.</li>
									<li>Gain : <img src="http://www.2fight.com/images/obsc/737feed0ed83.gif" title="Chichi" />Chichi<br/>
										<img src="http://www.2fight.com/images/boule7.gif" title="Dragon ball à 7 étoiles" />Dragon Ball à 7 étoiles</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=165" onclick="window.open(this.href); return false">Le mont Fry Pan</a><br/>
										<a href="http://www.2fight.com/index.php?page=histoire&oldev=166" onclick="window.open(this.href); return false">La petite chichi</a><br/>
										<a href="http://www.2fight.com/index.php?page=histoire&oldev=167" onclick="window.open(this.href); return false">Après le combat</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'16',
										'http://www.2fight.com/images/obsc/139991fc6f23.jpg',
										'Le retour du maître',
										'Passez retrouver mon obsédé de frère !',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Un personnage doit se rendre en <a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=7" onclick="window.open(this.href); return false">I-7</a>
										et lire le dialogue pour valider l'étape.</li>
									<li>Conseil : Aucun pour cette étape.</li>
									<li>Gain : <img src="http://www.2fight.com/images/caps/rouge.png" title="Capsule rouge" /> Mitraillette pour Bulma</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=168" onclick="window.open(this.href); return false">Maître Mutenroshi</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'17',
										'http://www.2fight.com/images/obsc/5c71cdb90df3.jpg',
										'Le gang de Toto le Lapin',
										'Dernière Dragon Ball détectée en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=3">E-3</a> !',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réalisé : Valider l'étape en passant le dialogue.</li>
									<li>Conseil : Aucun pour cette étape.</li>
									<li>Gain : Vous débloquez le module des clans.</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=169" onclick="window.open(this.href); return false">Village de Toto le Lapin</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'18',
										'http://www.2fight.com/images/obsc/e5df2c15a207.jpg',
										'On a volé les Dragon Ball !',
										'Sur le chemin, vous vous êtes fait attaquer et voler toutes vos dragon ball ! Heureusement Goku gardait la sienne sur lui...<br/>
										Les voleurs avaient la dernière boule, vous détectez les 6 autres en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=3">E-3</a>...',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réaliser : Chibi Gokû doit combattre Pilaf <span class="level">Level 3</span> avec <span class="ki">85.000 de Ki</span>
									classe Héros en combo Défensif</li>
									<li>Conseil : N'oublier pas de faire tous vos entraîments !</li>
									<li>Gain : <img src="http://www.2fight.com/images/icos/zenis.png" title="Zénis" />2.000 Zénis<br/>
										<img src="http://www.2fight.com/images/objets/902s.png" title="Senzu" />1 Senzu</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=170" onclick="window.open(this.href); return false">Au voleur !</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'19',
										'http://www.2fight.com/images/obsc/fea9405367db.jpg',
										'En prison !',
										'Pilaf n\'a pas accepté sa défaite... quel mauvais joueur...<br/>
										Gaah ! Il invoque le dragon !!',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réaliser : Valider l'étape en passant le dialogue.</li>
									<li>Conseil : Aucun pour cette étape.</li>
									<li>Gain : <img src="http://www.2fight.com/images/icos/zenis.png" title="Zénis" />1.000 Zénis<br/>
										Vous perdez toutes les dragon balls acquise debuit le début.</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=171" onclick="window.open(this.href); return false">L'invocation de Shenron</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php echo creer_etape(
										'20',
										'http://www.2fight.com/images/obsc/216dc71a42d7.jpg',
										'La nuit de pleine lune avant l\'attaque du soleil',
										'Les Dragon Balls ont été invoquées !<br/>
										Pilaf vous enferme dans une autre prison, bien plus solide.<br/>
										Comment en sortir ?...',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réaliser : Yamcha doit combattre Oozaru <span class="level">Level 4</span> avec <span class="ki">121.000 de Ki</span>
									classe Héros en combo Magicien</li>
									<li>Conseil : N'oublier pas de faire tous vos entraînements !</li>
									<li>Gain : <img src="http://www.2fight.com/images/icos/zenis.png" title="Zénis" />1.000 Zénis</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=172" onclick="window.open(this.href); return false">Enfermé en prison !</a><br/>
										<a href="http://www.2fight.com/index.php?page=histoire&oldev=184" onclick="window.open(this.href); return false">Après le combat</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<h2 id="saga_21etournoi">Saga 21ème Tournoi</h2>
							<br/>
							<?php echo creer_etape(
										'21',
										'http://www.2fight.com/images/obsc/fd931e5fdc4f.jpg',
										'Devenir l\'élève de Muten Roshi',
										'La quête des Dragon Ball est terminée...<br/>
										Vous décidez d\'améliorer vos capacités auprès de ce maître...
										(un vieux crouton ouais)',
										'',
										'');
							?>
							<span class="action">
								<ul>
									<li>Action à réaliser : Chibi Gokû doit avoir réaliser au moins UN entraînement chez Muten Roshi ! (Entraînement de force)</li>
									<li>Conseil : Si vous n'aviez pas fait un entraînement chez Muten Roshi, il faut le faire.</li>
									<li>Gain : Aucun gain.</li>
									<li>Revoir le dialogue : <a href="http://www.2fight.com/index.php?page=histoire&oldev=173" onclick="window.open(this.href); return false">Entraînement des Tortues (1)</a></li>
								</ul>
								<span class="action_fin"></span>
							</span>
							<br/>
							<?php 
							echo creer_etape(
								'22',
								'http://www.2fight.com/images/obsc/8cfeab31996e.jpg',
								'Un nouvel arrivant',
								'Vous n\'êtes pas le seul à vouloir être l\'élève du moustachu on dirait...',
								'',
								'');
							echo creer_action(
								'Chibi Goku doit combattre Kulilin Level 4 avec 100.000 de Ki classe Héros en Défensif en <a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=7" onclick="window.open(this.href); return false">I-7</a> (Kame House)',
								'Aucun pour cette étape',
								array(array(1, 'Kulilin', 'http://www.2fight.com/images/obsc/c60d14f55b93.gif'), array(2, '1.000', 'http://www.2fight.com/images/icos/zenis.png')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=174' => 'Un nouveau venu...')
							);							
							echo '<br/>';
							
							echo creer_etape(
								'23',
								'http://www.2fight.com/images/obsc/a3e86e88f778.jpg',
								'La fille pour Mutenroshi',
								'Vous êtes maintenant deux élèves, mais devez toujours trouver une fille pour Mutenroshi !
								Je vais vous aider.... Regardez autour de la capitale !',
								'',
								''
							);
							echo creer_action(
								'Valider l\'étape en passant le dialogue aux alentours de la capitale',
								'Chercher seulement qu\'au dessus de la Capitable ;).',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=186' => 'Une beauté fatale...',
									'http://www.2fight.com/index.php?page=histoire&oldev=185' => 'Une fille en détresse !')
							);							
							echo '<br/>';
							
							echo creer_etape(
								'24',
								'http://www.2fight.com/images/obsc/75eddb4cca69.jpg',
								'Le tortue training !',
								'Gokû et Kulilin doivent avoir fait un entraînement chacun chez le maître.',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit avoir réaliser au moins UN entraînement chez Muten Roshi ! (Entraînement de force)',
								'Aucun pour cette étape',
								array(array(7, 'Une partie de la carte s\'est libéré. Vous avez la possibilité de changer de classe.'), array(9, 'L\'entraînement de Muten Rôshi', '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=175' => 'Entraînement des Tortues (2)')
							);
							echo '<br/>';
							
							echo creer_etape(
								'25',
								'http://www.2fight.com/images/obsc/2bcad3d0a893.jpg',
								'Le tournoi des arts martiaux !',
								'Changez d\'île pour un évènement extraordinaire !',
								'',
								''
							);
							echo creer_action(
								'Vous devez changer la classe d\'un de vos personnages 
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=1" onclick="window.open(this.href); return false">F-1</a> puis valider l\'étape en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8" onclick="window.open(this.href); return false">F-8</a> (Île du tournoi).',
								'Changer la classe sur un personnage de bas level.<br/> Rappel : Changer de classe coûte 500 zénis multiplié par le niveau de votre personnage.',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=176' => 'Le Grand Tournoi !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'26',
								'http://www.2fight.com/images/obsc/c92ee2d607fe.jpg',
								'Les combats commencent',
								'Sur l\'île des tournois, vous avez du boulot !',
								'',
								''
							);
							echo creer_action(
								'Yamcha doit combattre Jacky Choun Level 4 avec 130.000 de Ki classe Héros en combo Magicien en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> (Île du tournoi)',
								'Aucun pour cette étape',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=177' => 'Premier grand match !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'27',
								'http://www.2fight.com/images/obsc/aeb82ee3c31f.jpg',
								'Demi finales',
								'Ne soyez pas impressionnés...',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre Jacky Choun Level 4 avec 152.000 de Ki classe Héros en combo Aléatoire en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> (Île du tournoi)',
								'Aucun pour cette étape',
								array(array(2, '1.000'), array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=178' => 'Demi Finale contre Jacky Choun')
							);
							echo '<br/>';
							
							echo creer_etape(
								'28',
								'http://www.2fight.com/images/obsc/54987c5f4726.jpg',
								'Fin des demi-finales',
								'Allez, la finale n\'est pas loin !',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Nam Level 4 avec 125.000 de Ki classe Héros en combo Agressif en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> (Île du tournoi)',
								'Aucun pour cette étape',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=179' => 'Demi Finale contre Nam')
							);
							echo '<br/>';
							
							echo creer_etape(
								'29',
								'http://www.2fight.com/images/obsc/016bfdbf35f8.jpg',
								'Finale Jacky Choun contre Son Gokû',
								'Deviendras-tu champion du monde ?',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Muten Rôshi level 5 avec 174.000 de Ki classe Héros en combo Magicien en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> (Île du tournoi)',
								'Aucun pour cette étape',
								array(array(1, 'Muten Rôshi !', 'http://www.2fight.com/images/obsc/fe49f81995d5.gif'), array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=180' => 'Enfin la finale !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'30',
								'http://www.2fight.com/images/obsc/9d965be8f9bb.jpg',
								'Finale Jacky Choun contre un singe géant !!',
								'Son Gokû a une manière quelque peu radicale d\'essayer de gagner le combat !!!',
								'',
								''
							);
							echo creer_action(
								'Muten Rôshi doit combattre Oozaru level 4 avec 110.000 de Ki classe Héros en combo Agressif en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> (Île du tournoi)',
								'Aucun pour cette étape',
								array(array(4, '1'), array(2, '2.000'), array(7, 'Vous avez maintenant accès à toute la carte sur terre.'), array(8, 'Tournois & Marché aux objets')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=182' => 'Gokû triche ??', 
									'http://www.2fight.com/index.php?page=histoire&oldev=183' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'31',
								'http://www.2fight.com/images/obsc/a47205c924db.jpg',
								'Après un bon repas...',
								'En <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> nos héros se rassemblent avant de se quitter, et discutent de ce beau tournoi.',
								'',
								''
							);
							echo creer_action(
								'Vous devez acheter un Détecteur de Dragon Ball au marché en <a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=5">I-5</a> (Satan City)',
								'Pour savoir comment utiliser le détecteur de Dragon Ball cliquez ici',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=187' => 'Après ce tournoi...',
									'http://www.2fight.com/index.php?page=histoire&oldev=188' => 'Tu as un détecteur ??')
							);
							?>
							<br/>
							<h2 id="saga_rubanrouge">Saga Ruban Rouge</h2>
							<br/>
							<?php
							echo creer_etape(
								'32',
								'http://www.2fight.com/images/obsc/1eb5b70be72a.jpg',
								'Recherche ton premier Dragon Ball',
								'Va dans Le menu "Persos" puis "Objets".
								Si tu n\'as pas jeté ou perdu ton détecteur, tu auras l\'option "Utiliser le Dragon Radar" à droite.
								Et bien... clique dessus... et suis son indication !',
								'',
								''
							);
							echo creer_action(
								'Utiliser le dragon radar pour vous rendre en ... 
									<a href="http://www.2fight.com/index.php?page=carte&case_x=7&case_y=4">G-4</a> et passer l\'étape en passant le dialogue',
								'Utiliser le dragon radar comme sur le tuto ci-dessus',
								array(array(5, 'Dragon Ball à 5 étoiles ', 'http://www.2fight.com/images/boule5.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=189' => 'Première boule détectée')
							);
							echo '<br/>';
							
							echo creer_etape(
								'33',
								'http://www.2fight.com/images/obsc/7cf8eddf9a3b.jpg',
								'La tour du muscle',
								'Le prochain point de ton détecteur t\'envoie au devant d\'épreuves difficiles...',
								'',
								''
							);
							echo creer_action(
								'Utiliser le dragon radar pour vous rendre en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=2">B-2</a><br/>
								Chibi Gokû doit combattre le Sergent Metallic Level 6 avec 147.000 de Ki classe Héros en combo Agressif',
								'Aucun pour cette étape',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=190' => 'La où pointe le Dragon Radar')
							);
							echo '<br/>';
							
							echo creer_etape(
								'34',
								'http://www.2fight.com/images/obsc/eb42afb1b3d7.jpg',
								'La tour du muscle - Étage 2',
								'Increvable !!
								Il vous avait dit qu\'il reviendrait...',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre le Sergent Metallic Level 7 avec 152.000 de Ki classe Héros en combo Agressif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=2">B-2</a>',
								'',
								array(array(2, '5.000')),
								array('http://www.2fight.com/index.php?page=histoire&ev=191' => 'I\'ll be back')
							);
							echo '<br/>';
							
							echo creer_etape(
								'35',
								'http://www.2fight.com/images/obsc/eb45deb8f8f5.jpg',
								'Complètement rien à voir',
								'Un filler !!!!
								Va donc voir ce qu\'il se passe chez Guymao... des choses terribles !!!',
								'',
								''
							);
							echo creer_action(
								'Rendez-vous chez Gyumao en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a><br/>
								Chichi doit combattre Pilaf Level 4 avec 170.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&ev=196' => 'Le mariage de Chichi')
							);
							echo '<br/>';
							
							echo creer_etape(
								'36',
								'http://www.2fight.com/images/obsc/e0658d60a82e.jpg',
								'La tour du muscle - Étage 3',
								'Retour en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=2">B-2</a>.
								Que vous préparent-ils cette fois ?',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Murasaki Level 7 avec 210.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(3, '1'), array(1, 'Murasaki', 'http://www.2fight.com/images/obsc/2fcfc285c440.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=192' => 'Etage suivant de la tour')
							);
							echo '<br/>';
							
							echo creer_etape(
								'37',
								'http://www.2fight.com/images/obsc/9b10ce1a476d.jpg',
								'La tour du muscle - Cyborg N°8',
								'Quoi, encore un robot ?
								Celui qui l\'a construit s\'améliore avec chaque modèle !
								Bah, qu\'est ce que tu risques, c\'est pas comme s\'ils pourraient détruire un jour l\'humanité entière, ah ah ah !',
								'',
								''
							);
							echo creer_action(
								'Murasaki doit combattre C-8 Level 5 avec 135.000 de ki classe Héros combo Agressif',
								'',
								array(array(2, '2.000'), array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&ev=193' => 'La vengeance du ninja')
							);
							echo '<br/>';
							
							echo creer_etape(
								'38',
								'http://www.2fight.com/images/obsc/e3f4812a0850.jpg',
								'La tour du muscle - Étage 4',
								'Quel horrible monstre !
								Mais vous n\'êtes plus seul...',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Boom level 8 avec 170.000 de Ki classe Héros en combo Défensif en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=2">B-2</a>',
								'',
								array(array(5, 'Dragon Ball à 2 étoiles ', 'http://www.2fight.com/images/boule2.gif')),
								array('http://www.2fight.com/index.php?page=histoire&ev=194' => 'Dernier étage de la tour')
							);
							echo '<br/>';
							
							echo creer_etape(
								'39',
								'http://www.2fight.com/images/obsc/0bebc303902e.jpg',
								'Deux boules rassemblées',
								'Une bonne chose de faite. Mais... le détecteur... il déconne ?
								(Si tu es perdu, nous sommes en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=2">B-2</a> !)',
								'',
								''
							);
							echo creer_action(
								'Passer cette étape en validant le dialogue.',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&ev=195' => 'Victoire...')
							);
							echo '<br/>';
							
							echo creer_etape(
								'40',
								'http://www.2fight.com/images/obsc/f46cd4eb0b15.jpg',
								'Dans la grande ville de la Capitale',
								'Retrouvez Bulma pour continuer votre aventure.',
								'',
								''
							);
							echo creer_action(
								'Rendez-vous à la capitale <a href="http://www.2fight.com/index.php?page=carte&case_x=4&case_y=5">D-5</a> puis parler à Bulma.<br/>
								Pour valider cette étape, vous devez acheter un nouveau dragon radar.',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&ev=200' => 'Parler à bulma')
							);
							echo '<br/>';
							
							echo creer_etape(
								'41',
								'http://www.2fight.com/images/obsc/555551e2c0f4.jpg',
								'Prochain Dragon Ball immergé !',
								'Inutile d\'aller jusque dans l\'eau. Arrête-toi en <a href="http://www.2fight.com/index.php?page=carte&case_x=8&case_y=6">H-6</a> pour faire le point avant.<br/>
								Je ne sais pas qui est ce type à gauche mais il m\'inspire pas confiance...',
								'',
								''
							);
							echo creer_action(
								'Rendez-vous en <a href="http://www.2fight.com/index.php?page=carte&case_x=8&case_y=6">H-6</a> et valider cette étape en passant le dialogue.',
								'',
								array(array(5, 'Magazine cochon', 'http://www.2fight.com/images/icos/object.png')),
								array('http://www.2fight.com/index.php?page=histoire&ev=197' => 'Comment aller sous l\'eau')
							);
							echo '<br/>';
							
							echo creer_etape(
								'42',
								'http://www.2fight.com/images/obsc/05b0548d601e.jpg',
								'Emprunter un sous-marin',
								'Encore une fois, le vieux barbu sauvera la situation...
								Allez chez Kamesenin en <a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=7">I-7</a>',
								'',
								''
							);
							echo creer_action(
								'Bulma doit combattre Muten Rôshi Level 5 avec 195.000 de Ki classe Héros combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=7">I-7</a>',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&ev=198' => 'Demander un sous-marin',
									'http://www.2fight.com/index.php?page=histoire&oldev=205' => 'DB sous l\'eau')
							);
							echo '<br/>';
							
							echo creer_etape(
								'43',
								'http://www.2fight.com/images/obsc/56e7f1780e0f.jpg',
								'Ok, fouille au fond de la mer',
								'Tu as maintenant un sous-marin, tu peux aller fouiller là où pointe ton détecteur.
								Attention aux dangers de la mer...',
								'',
								''
							);
							echo creer_action(
								'Muten Rôshi doit combattre le Commandant Blue Level 6 avec 200.000 de Ki classe Héros en combo Magicien en <a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=7">I-7</a>',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&ev=201' => 'Entrez dans la grotte...',
									'http://www.2fight.com/index.php?page=histoire&ev=202' => 'Kamé House attaquée !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'44',
								'http://www.2fight.com/images/obsc/9dd7a7179aa1.jpg',
								'Dans la grotte mystérieuse',
								'Trouverez-vous le trésor des pirates là où cligne le détecteur ?
								Ou un Dragon Ball ? Ou les deux ?
								Ou un ennemi ? Ou les trois ?',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre le Commandant Blue Level 6 avec 225.000 de Ki classe Héros en combo Aléatoire 
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=10&case_y=6">J-6</a>',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&ev=203' => 'Dans la grotte des Pirates')
							);
							echo '<br/>';
							
							echo creer_etape(
								'45',
								'http://www.2fight.com/images/obsc/3ddf5f13f634.jpg',
								'Terrassez le Commandant Blue !',
								'Allez petit il faut sortir vivant de cette grotte sous-marine...',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre le Commandant Blue Level 9 avec 235.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=10&case_y=6">J-6</a>',
								'',
								array(array(5, 'Dragon Ball à 3 étoiles ', 'http://www.2fight.com/images/boule3.gif')),
								array('http://www.2fight.com/index.php?page=histoire&ev=204' => 'Le commandant Blue !!',
									'http://www.2fight.com/index.php?page=histoire&oldev=208' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'46',
								'http://www.2fight.com/images/obsc/13157a7d9ffe.jpg',
								'Retrouvez Blue !',
								'Suis les Dragon Ball pour retrouver Blue !',
								'',
								''
							);
							echo creer_action(
								'Valider cette étape en passant le dialogue en <a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=9">C-9</a>',
								'',
								array(array(1, 'Aralé', 'http://www.2fight.com/images/obsc/2dfe071f5581.gif')),
								array('http://www.2fight.com/index.php?page=histoire&ev=207' => 'Au village Pingouin')
							);
							echo '<br/>';
							
							echo creer_etape(
								'47',
								'http://www.2fight.com/images/obsc/129f1b7a4460.jpg',
								'Combat au Village Pingouin !!',
								'C\'est en <a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=9">C-9</a> que tu en finiras avec Blue.',
								'',
								''
							);
							echo creer_action(
								'Aralé doit combattre le Commandant Blue level 4 avec 200.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=9">C-9</a>',
								'',
								array(array(1, 'Commandant Blue', 'http://www.2fight.com/images/obsc/30ecd43193a3.gif'),array(2, '2.000'), array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&ev=206' => 'Confrontation finale !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'48',
								'http://www.2fight.com/images/obsc/415af34a4517.jpg',
								'Bulma rentre chez elle',
								'Bien décidée à oublier l\'armée du Red Ribbon, Bulma rentre chez elle, mais que découvre-t-elle ??',
								'',
								''
							);
							echo creer_action(
								'Bulma doit combattre Oolon Level 7 avec 166.000 de Ki classe Héros en combo Défensif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=4&case_y=5">D-5</a>',
								'',
								array(array(2, '1.000'), array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&ev=209' => 'Colocation difficile')
							);
							echo '<br/>';
							
							echo creer_etape(
								'49',
								'http://www.2fight.com/images/obsc/04a7412d72b5.jpg',
								'Le tueur professionnel',
								'L\'armée du Red Ribbon a décidée d\'en finir !
								Elle envoie le terrible Taopaipai à la Tour Karine, en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a>.
								Mais est-ce bien lui ?',
								'',
								''
							);
							echo creer_action(
								'Murasaki doit combattre Bora Level 9 avec 203.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a>',
								'',
								array(array(1, 'Bora', 'http://www.2fight.com/images/obsc/daeec0de4ab8.gif'), array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&ev=210' => 'La boule de la Terre Sacrée',
									'http://www.2fight.com/index.php?page=histoire&oldev=219' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'50',
								'http://www.2fight.com/images/obsc/54ae80f398f2.jpg',
								'Entraînement',
								'Quelle belle famille ! Ce serait terrible qu\'il leur arrive quelque chose... de terrible.',
								'',
								''
							);
							echo creer_action(
								'Bora doit combattre Upa level 4 avec 135.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a>',
								'',
								array(array(5, 'Dragon Ball à 4 étoiles ', 'http://www.2fight.com/images/boule4.gif'), array(2, '2.000'), array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&ev=211' => 'Upa, Bora, et la Tour Karine')
							);
							echo '<br/>';
							
							echo creer_etape(
								'51',
								'http://www.2fight.com/images/obsc/2551904201c0.jpg',
								'Le vrai Taopaipai',
								'L\'armée du Red Ribbon ne plaisante pas !
								Tu es le commandant Blue et tu es enfin revenu au quartier général, qui est en en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=3" onclick="window.open(this.href); return false">E-3</a>...',
								'',
								''
							);
							echo creer_action(
								'Commandant Blue doit combattre Taopaipai Level 5 avec 200.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=3" onclick="window.open(this.href); return false">E-3</a>',
								'',
								array(array(2, '2.000'), array(4, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=212' => 'Le QG du Red Ribbon')
							);
							echo '<br/>';
							
							echo creer_etape(
								'52',
								'http://www.2fight.com/images/obsc/2d7dde854196.jpg',
								'Le tueur s\'avance',
								'Taopaipai est arrivé à la tour Karine, en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a> ! Il faut défendre la terre sacrée !',
								'',
								''
							);
							echo creer_action(
								'Bora doit combattre Taopaipai Level 6 avec 221.000 de Ki classe Héros en combo Magicien en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a>.',
								'',
								array(array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=213' => 'Taopaipai attaque !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'53',
								'http://www.2fight.com/images/obsc/667aba79e43a.jpg',
								'C\'est terrible',
								'Gokû, tu dois venger le gentil indien !',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Taopaipai Level 10 avec 170.000 de Ki classe Héros en combo Agressif en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a>.',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=214' => 'Le tueur sanguinaire !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'54',
								'http://www.2fight.com/images/obsc/af7f91f4b30b.jpg',
								'L\'eau sacrée',
								'La légende parle d\'un entraînement super efficace à la tour Karine...',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit avoir fait au moins 1 entraînement d\'énergie à la tour karine.',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=215' => 'La Tour Karine')
							);
							echo '<br/>';
							
							echo creer_etape(
								'55',
								'http://www.2fight.com/images/obsc/f345fcbc16fe.jpg',
								'La revanche',
								'Cette fois il va sentir sa douleur !',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Taopaipai Level 11 avec 295.000 de Ki classe Héros en combo Aléatoire en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a>.',
								'',
								array(array(2, '5.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=216' => 'La revanche !!!',
									'http://www.2fight.com/index.php?page=histoire&oldev=222' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'56',
								'http://www.2fight.com/images/obsc/93aa917a7720.jpg',
								'A l\'attaque du quartier général du Red Ribbon',
								'C\'est la fin de cette armée ! Tu sais où aller...?',
								'',
								''
							);
							echo creer_action(
								'Valider l\'étape en lisant le dialogue.',
								'',
								array(array(5, 'Dragon Ball à 6 étoiles', 'http://www.2fight.com/images/boule6.gif'), array(10, 'Dragon Ball à 7 étoiles', 'http://www.2fight.com/images/boule7.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=217' => 'Attaque du QG du Red Ribbon !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'57',
								'http://www.2fight.com/images/obsc/bc43e2cc9533.jpg',
								'Taopaipai se trompe de chemin...',
								'Le tueur sanguinaire, vaincu, cherche à retrouver le QG du Red Ribbon...
								Il trouve bien un château, mais ce n\'est pas du tout le bon !
								Alors... un grand château, tout neuf et fraichement reconstruit, ça vous dit quelque chose ?',
								'',
								''
							);
							echo creer_action(
								'Chichi doit combattre Taopaipai Level 6 avec 230.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>',
								'',
								array(array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=218' => 'Taopaipai se trompe de forteresse !')
							);
							echo '<br/>';
							?>
							<br/>
							<h2 id="saga_babavoyante">Saga Baba la voyante</h2>
							<br/>
							<?php
							echo creer_etape(
								'58',
								'http://www.2fight.com/images/obsc/dc5a5a146ea7.jpg',
								'La dernière boule du dragon',
								'Comment trouver la boule si le détecteur ne dit rien ?
								En donnant des gnons bien sur ! Ça marche toujours comme ça... Rendez-vous 
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>.',
								'',
								''
							);
							echo creer_action(
								'Valider l\'étape en lisant le dialogue.',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=220' => 'La dernière boule du dragon')
							);
							echo '<br/>';
							
							echo creer_etape(
								'59',
								'http://www.2fight.com/images/obsc/22cd52ed9a4c.jpg',
								'Baba la voyante (moi)',
								'Combattez en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>
								chez moi pour avoir droit à une consultation !',
								'',
								''
							);
							echo creer_action(
								'Yamcha doit combattre Invisible Man Level 9 avec 183.010 de Ki classe Héros en combo Agressif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>.',
								'',
								array(array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=221' => 'Dracula Man et l\'homme invisible !!')
							);
							echo '<br/>';
							
							echo creer_etape(
								'60',
								'http://www.2fight.com/images/obsc/a3425f86fb96.jpg',
								'Les toilettes du démon !!',
								'L\'homme invisible ne pourra pas être vaincu s\'il reste invisible !!',
								'',
								''
							);
							echo creer_action(
								'Yamcha doit combattre C-8 Level 10 avec 210.010 de Ki classe Héros en combo Défensif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>.',
								'',
								array(array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=225' => 'Les toilettes du Démon !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'61',
								'http://www.2fight.com/images/obsc/be1c32822186.jpg',
								'Le retour de la momie !',
								'Yamcha ne suit plus, Gokû entre dans la pyramide!...
								-Bibliothèque.. -Termite. -Rectangulaire. -Hum... pantoufle. -Exact ! On pouvait aussi dire "alligator".',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre C-8 Level 12 avec 230.010 de Ki classe Héros en combo Défensif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>.',
								'',
								array(array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=226' => 'Une momie avertie en veut deux.')
							);
							echo '<br/>';
							
							echo creer_etape(
								'62',
								'http://www.2fight.com/images/obsc/d9b509e88618.jpg',
								'Diableman !',
								'Toujours chez moi (en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>), la galerie de monstres fantastiques continue !',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Akkuman Level 12 avec 270.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>.',
								'',
								array(array(1, 'Akkuman', 'http://www.2fight.com/images/obsc/9866550fff82.gif'), array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=227' => 'Combat aux toilettes !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'63',
								'http://www.2fight.com/images/obsc/2c249653d66a.jpg',
								'Le dernier combattant',
								'Je suis sûr que vous ne pourrez rien contre mon dernier !
								Grrr... je vais pas faire une vision gratuite comme ça !',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Papy Gohan Level 13 avec 275.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>.',
								'',
								array(array(1, 'Papy Gohan', 'http://www.2fight.com/images/obsc/e073aaaea58e.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=228' => 'Le dernier combattant !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'64',
								'http://www.2fight.com/images/obsc/51a4852940e1.jpg',
								'Le vieux grand-père !',
								'Vous avez retrouvé votre grand-père ! C\'est pas émouvant ça ? Et tout ça, c\'est grâce à moi, et ouais.',
								'',
								''
							);
							echo creer_action(
								'Papy Gohan doit combattre Muten Rôshi Level 7 avec 225.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a>.',
								'',
								array(array(2, '5.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=229' => 'Entre vieux maîtres')
							);
							echo '<br/>';
							
							echo creer_etape(
								'65',
								'http://www.2fight.com/images/obsc/d2d34259ba08.jpg',
								'Le trio des imbéciles, le retour',
								'Et voilà, nous savons maintenant où est la dernière boule !',
								'',
								''
							);
							echo creer_action(
								'Krillin doit combattre Pilaf Level 8 avec 260.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=3">F-3</a>',
								'',
								array(array(2, '2.000'), array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=230' => 'La dernière Dragon Ball !',
									'http://www.2fight.com/index.php?page=histoire&ev=231' => 'La dernière DB est ici !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'66',
								'http://www.2fight.com/images/obsc/a04fb192cf6c.jpg',
								'Fusion du trio!',
								'Bon sang les jetman ont fusionnés leur robot en super-robot !',
								'',
								''
							);
							echo creer_action(
								'Chibi Goku doit combattre Pilaf Level 13 avec 305.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=3">F-3</a>',
								'',
								array(array(2, '1.000'), array(7, 'Dragon Ball à 1 étoiles', 'http://www.2fight.com/images/boule1.gif')),
								array('http://www.2fight.com/index.php?page=histoire&ev=old232' => 'Combat robot final !',
									'http://www.2fight.com/index.php?page=histoire&oldev=233' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'67',
								'http://www.2fight.com/images/obsc/6fbf5a396b38.jpg',
								'L\'heure du miracle !',
								'Tu as les sept Dragon Ball ! Il est l\'heure de faire revenir à la vie le père d\'Upa, qui est enterré au pied de la Tour Karine.',
								'',
								''
							);
							echo creer_action(
								'Vous devez valider l\'étape en lisant le dialogue 
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a> à la tour Karine.',
								'',
								array(array(7, 'Dragon Ball en pierre', 'http://www.2fight.com/images/boule0.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=234' => 'Invocation du dragon !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'68',
								'http://www.2fight.com/images/obsc/30fc8f0ab4ce.jpg',
								'Le miraculé',
								'Bien, le bonhomme semble en forme...',
								'',
								''
							);
							echo creer_action(
								'Bora doit combattre Chibi Gokû level 8 avec 300.000 de Ki classe Héros en combo Magicien 
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a> à la tour Karine.',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=237' => 'Bora veut voir s\'il est bien vivant')
							);
							echo '<br/>';
							
							echo creer_etape(
								'69',
								'http://www.2fight.com/images/obsc/a86db93961fb.jpg',
								'La fin d\'une époque',
								'Un dernier passage chez moi pour conclure cette grande histoire !',
								'',
								''
							);
							echo creer_action(
								'Vous devez valider l\'étape en lisant le dialogue 
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a> au Mont Fry Pan.',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=236' => 'Fin de la quête !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'70',
								'http://www.2fight.com/images/obsc/947528addf26.jpg',
								'La rédemption de Blue',
								'Le commandant Blue ira-t-il au paradis ou en enfer ? Va dans le monde des morts pour en discuter avec le Roi Enma !',
								'',
								''
							);
							echo creer_action(
								'Commandant Blue doit combattre Paikuhan level 7 avec 200.000 de Ki classe Héros en combo Agressif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=4">C-4</a> au monde des morts chez Enma.',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=238' => 'Enma parle au commandant Blue !!')
							);
							echo '<br/>';
							
							echo creer_etape(
								'71',
								'http://www.2fight.com/images/obsc/cc740df35872.jpg',
								'La partie vivante de l\'armée Red Ribbon',
								'A la Tour du Muscle, l\'on se rassemble...',
								'',
								''
							);
							echo creer_action(
								'Murasaki doit combattre Sergant Mettalic Level 10 avec 230.010 de Ki classe Héros en combo Agressif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=2">B-2</a> à la tour au grand nord.',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=239' => 'Les robots de la tour')
							);
							echo '<br/>';
							
							echo creer_etape(
								'72',
								'http://www.2fight.com/images/obsc/df2a4a2214b2.jpg',
								'Reconstruction',
								'Pendant que certains s\'assemblent, d\'autres rassemblent. Toujours à la tour du muscle.',
								'',
								''
							);
							echo creer_action(
								'Vous devez avoir en votre possession 25 jeux et un jeu tobal. Rendez-vous en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=2">B-2</a> pour continuer.',
								'Évitez d\'acheter le jeu Tobal au marché, il coûte <ins>cher</ins>',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=240' => 'Les bons robots de la Tour')
							);
							echo '<br/>';
							
							echo creer_etape(
								'73',
								'http://www.2fight.com/images/obsc/476a2fd1c9c4.jpg',
								'Au village des jouets mécaniques',
								'Tiens, ça ne s\'appelait pas le village Pingouin à la base ? Bref, il se passe des choses en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=9">C-9</a>',
								'',
								''
							);
							echo creer_action(
								'Aralé doit combattre Boom Level 7 avec 195.010 de Ki classe Héros en combo Défensif en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=9">C-9</a>',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=241' => 'Au village Pingouin')
							);
							echo '<br/>';
							
							echo creer_etape(
								'74',
								'http://www.2fight.com/images/obsc/bf8e2aaea1a1.jpg',
								'Chichi fait des chichis',
								'Au mont Fry Pan, Gyumao se désespère (de famille) !',
								'',
								''
							);
							echo creer_action(
								'Chichi doit avoit faire au moins un entraînement chez Muten Roshî. (Entraînement de force)',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=242' => 'Chichi apprends à se battre.')
							);
							echo '<br/>';
							
							echo creer_etape(
								'75',
								'http://www.2fight.com/images/obsc/f42bf3b82468.jpg',
								'Chichi fait des chichis (fin)',
								'Sa fille fera-elle la fierté de papa ?',
								'',
								''
							);
							echo creer_action(
								'Chichi doit combattre Wolfy Level 7 avec 200.010 de Ki classe Héros en combo Agressif',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=243' => 'Chichi sait se battre !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'76',
								'http://www.2fight.com/images/obsc/0ce6f68a60b0.jpg',
								'Rififi à la capitale',
								'Quels parents insupportables ! A moins que ce soit la fille qui le soit ?<br/>
								<br/>
								En tout cas, Bulma doit faire le ménage...',
								'',
								''
							);
							echo creer_action(
								'Bulma doit combattre Murasaki Level 8 avec 270.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '1.000'), array(7, 'Dragon ball à 4 étoiles', 'http://www.2fight.com/images/boule2.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=244' => 'Un voleur à la capsule Corps !')
							);
							echo '<br/>';
							?>
							<h2 id="saga_22etournoi">Saga 22ème Tournoi</h2>
							<?php
							echo creer_etape(
								'77',
								'http://www.2fight.com/images/obsc/4ff14396e31a.jpg',
								'Trois ans ont passés',
								'C\'est fou, le temps de ces fillers, tant de temps a passé !<br/>
								On se retrouve en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> pour un nouveau tournoi des arts martiaux !!<br/>
								Dis-moi Yamcha, es-tu prêt pour le tournoi ?',
								'',
								''
							);
							echo creer_action(
								'Yamcha doit avoir fait au moins 1 entraînement chez Muten Roshi. (Entraînement de force).',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=245' => 'Le nouveau tournoi !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'78',
								'http://www.2fight.com/images/obsc/cbbece668341.jpg',
								'Le grand tournoi des arts martiaux !',
								'Et bien ça commence, en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> !<br/>
								Allez les éliminatoires !',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=246' => 'Les éliminatoires !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'79',
								'http://www.2fight.com/images/obsc/87cf22bc2200.jpg',
								'Quart de finale : Yamcha contre Tenshinan !',
								'Les deux grandes gueules vont se mettre sur la gueule.',
								'',
								''
							);
							echo creer_action(
								'Yamcha doit combattre Tenshihan Level 12 avec 290.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=247' => 'Quart de finale 1')
							);
							echo '<br/>';
							
							echo creer_etape(
								'80',
								'http://www.2fight.com/images/obsc/d5fd54b019e5.jpg',
								'Quart de finale : Jacky Choun contre l\'Homme-garou !',
								'Il semble détester Jacky, mais pourquoi ?',
								'',
								''
							);
							echo creer_action(
								'Muten Rôshi doit combattre Wolfy Level 8 avec 230.010 de Ki classe Héros en combo Agressif',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=248' => 'Quart de finale 2')
							);
							echo '<br/>';
							
							echo creer_etape(
								'81',
								'http://www.2fight.com/images/obsc/19c84cecc8a8.jpg',
								'Quart de finale : Kulilin contre Chaozu !',
								'Ce combat sera au raz des pâquerettes !',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre Chaozu Level 11 avec 270.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=249' => 'Quart de finale 3')
							);
							echo '<br/>';
							
							echo creer_etape(
								'82',
								'http://www.2fight.com/images/obsc/ba4796f2d44c.jpg',
								'Quart de finale : Son Gokû contre Pamputt !',
								'Pourquoi tu te bas toujours en dernier Gokû ?',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Nam level 14 avec 230.000 de Ki classe Héros en combo Agressif',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=250' => 'Quart de finale 4')
							);
							echo '<br/>';
							
							echo creer_etape(
								'83',
								'http://www.2fight.com/images/obsc/e2152b54ff74.jpg',
								'Demi-finale : Tenshinan contre Jacky Choun !',
								'Oh, l\'ancien boss final contre le nouveau boss final !',
								'',
								''
							);
							echo creer_action(
								'Muten Rôshi doit combattre Tenshihan Level 10 avec 245.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=251' => 'Demi Finale 1')
							);
							echo '<br/>';
							
							echo creer_etape(
								'84',
								'http://www.2fight.com/images/obsc/859df7c1af53.jpg',
								'Demi-finale : Kulilin contre Son Gokû !',
								'Nos deux amis vont enfin s\'affronter !!',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre Chibi Gokû Level 12 avec 309.000 de Ki classe Héros en combo Aléatoire',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=252' => 'Demi Finale 2')
							);
							echo '<br/>';
							
							echo creer_etape(
								'85',
								'http://www.2fight.com/images/obsc/71f40b214ff4.jpg',
								'La finale : Tenshinan contre Son Gokû !',
								'Enfin le grand final : la finale.',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Tenshinhan Level 15 avec 315.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(1, 'Tenshinhan', 'http://www.2fight.com/images/obsc/6829b8eace87.gif'), array(2, '5.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=253' => 'La finale')
							);
							echo '<br/>';
							
							echo creer_etape(
								'86',
								'http://www.2fight.com/images/obsc/3006571d30d1.jpg',
								'Fin de finale : Tenshinan contre Son Gokû !',
								'Cette fois-ci, Tenshinan se bat du bon côté !',
								'',
								''
							);
							echo creer_action(
								'Tenshihan doit combattre Chibi Gokû Level 6 avec 255.000 de Ki classe Héros en combo magicien',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=254' => 'La finale, deuxième partie')
							);
							echo '<br/>';
							
							echo creer_etape(
								'87',
								'http://www.2fight.com/images/obsc/732766b79e7f.jpg',
								'Fin du tournoi',
								'Tout devrait aller bien maintenant... n\'est-ce pas ?
								Tu restes en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> pour fêter la fin du tournoi...',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre Tambourine Level 13 avec 230.000 de Ki classe Héros en combo Défensif',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=255' => 'Pas de happy ending')
							);
							echo '<br/>';
							?>
							<br/>
							<h2 id="saga_piccolo_le_demon">Saga Piccolo le Démon</h2>
							<br/>
							<?php
							echo creer_etape(
								'88',
								'http://www.2fight.com/images/obsc/ae194dff9bbb.jpg',
								'Le terrible démon Piccolo',
								'Toujours en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a>... tu entends un cri !
								Oh mon dieu ils ont tués Kulilin !
								Espèces d\'enfoirés !!',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Tambourine Level 16 avec 270.010 de Ki classe Héros en combo Aléatoire 
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=4&case_y=7">D-7</a>',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=256' => 'Le tueur et voleur de DB !',
									'http://www.2fight.com/index.php?page=histoire&oldev=305' => 'Le meurtre de Kulilin !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'89',
								'http://www.2fight.com/images/obsc/1ded2abce5cb.jpg',
								'L\'allié de Son',
								'Heureusement que quelqu\'un veille sur toi...
								Là où Gokû s\'est battu contre le monstre, en <a href="http://www.2fight.com/index.php?page=carte&case_x=4&case_y=7">D-7</a>...',
								'',
								''
							);
							echo creer_action(
								'Vous devez avoir en votre possession l\'objet de collection le poisson pour pouvoir valider cette étape.',
								'',
								array(array(7, 'Dragon ball à 1 étoile', 'http://www.2fight.com/images/boule1.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=257' => 'Gokû, pas très en forme')
							);
							echo '<br/>';
							
							echo creer_etape(
								'90',
								'http://www.2fight.com/images/obsc/4a2e12ad25fc.jpg',
								'Nouvelle quête des Dragon Ball !',
								'Retrouvez à l\'île du tournoi (<a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a>) les autres membres de l\'équipe.',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								array(array(1, 'Chaozu', 'http://www.2fight.com/images/obsc/950fd55386d3.gif'),
								array(7, 'Dragon Ball à 6 étoiles', 'http://www.2fight.com/images/boule6.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=258' => 'Comment enfermer Piccolo ?')
							);
							echo '<br/>';
							
							echo creer_etape(
								'91',
								'http://www.2fight.com/images/obsc/d5b58e1b8bf5.jpg',
								'La vieille rancoeur',
								'Suis le détecteur de Dragon Balls pour trouver l\'emplacement de ta prochaine quête...
								Vas-y avec Tenshinhan.',
								'',
								''
							);
							echo creer_action(
								'Tenshinhan doit combattre Spopovich Level 8 avec 210.010 de Ki classe Héros en combo Aléatoire',
								'',
								array(array(2, '1.000'), array(7, 'Dragon ball à 5 étoiles', 'http://www.2fight.com/images/boule5.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=259' => 'Tenshinan cherche une Boule')
							);
							echo '<br/>';
							
							echo creer_etape(
								'92',
								'http://www.2fight.com/images/obsc/c742080fcad9.jpg',
								'La forêt maudite.',
								'Chaoz se dit qu\'il n\'aurai pas du partir seul !
								Suit également ton détecteur.',
								'',
								''
							);
							echo creer_action(
								'Chaozu doit combattre Wolfy Level 4 avec 120.010 de Ki classe Héros en combo Aléatoire',
								'',
								array(array(3, '1'), array(7, 'Dragon Ball à 2 étoiles', 'http://www.2fight.com/images/boule2.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=260' => 'Chaoz cherche une Boule')
							);
							echo '<br/>';
							
							echo creer_etape(
								'93',
								'http://www.2fight.com/images/obsc/157f6a069a68.jpg',
								'Tambourine attaque !',
								'Yamcha ayant une jambe cassée, il se repose à la Kame House...<br/>
								Mais cela ne sera pas si facile !',
								'',
								''
							);
							echo creer_action(
								'Yamcha doit combattre Tambourine Level 14 avec 230.010 de Ki classe Héros en combo Agressif',
								'',
								array(array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=261' => 'Yamcha se repose')
							);
							echo '<br/>';
							
							echo creer_etape(
								'94',
								'http://www.2fight.com/images/obsc/0f5dc58b3800.jpg',
								'Pendant ce temps, l\'équipe de recherche...',
								'Votre quête continue. Détecteur, tout ça...',
								'',
								''
							);
							echo creer_action(
								'Bora doit combattre Chaozu Level 10 avec 330.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(3, '1'), array(7, 'Dragon Ball à 3 étoiles', 'http://www.2fight.com/images/boule3.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=262' => 'Chaoz cherche une Boule')
							);
							echo '<br/>';
							
							echo creer_etape(
								'95',
								'http://www.2fight.com/images/obsc/76c65598a04c.jpg',
								'Tambourine change de cible.',
								'Tenshinan, tu es notre seul espoir ! Sauve Yamcha de ce monstre !',
								'',
								''
							);
							echo creer_action(
								'Tenshinhan doit combattre Tambourine Level 10 avec 210.010 de Ki classe Héros en combo Agressif',
								'',
								array(array(4, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=263' => 'Sauvez Yamcha !',
									'http://www.2fight.com/index.php?page=histoire&oldev=306' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'96',
								'http://www.2fight.com/images/obsc/4037fa0eeb58.jpg',
								'Piccolo lui-même apparait !',
								'Nos héros vont en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a> pour affronter Piccolo.',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=289' => 'L\'affrontement contre le Démon !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'97',
								'http://www.2fight.com/images/obsc/c483e0356201.jpg',
								'Le dernier combat du vieux maître !',
								'J\'espère que votre plan est parfait ! Si vous devez combattre Piccolo, vous êtes cuit !',
								'',
								''
							);
							echo creer_action(
								'Muten Rôshi doit combattre Piccolo Daimao Level 12 avec 390.000 de Ki classe Héros en combo Aléatoire',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=266' => 'Combattre le Démon !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'98',
								'http://www.2fight.com/images/obsc/76a00022c32f.jpg',
								'Piccolo invoque le Dragon !',
								'Oh non ! Fréro ! Il a tué mon frère ! Quel salaud !<br/>
								Je ne reverrai jamais mes 400 000 zenis qu\'il me doit...',
								'',
								''
							);
							echo creer_action(
								'Tenshinhan doit combattre Piccolo Daimao Level 10 avec 360.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=264' => 'Piccolo contre-attaque !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'99',
								'http://www.2fight.com/images/obsc/bde67cc358ce.jpg',
								'Qui fera le voeu aux Dragon Ball ?',
								'Ah bah si, j\'ai qu\'à lui donner une journée sur Terre. Héhé pas conne la soeurette !
								Bon je vais le chercher. J\'imagine que son âme est déjà en enfer, ah ah !',
								'',
								''
							);
							echo creer_action(
								'Chaozu doit combattre Piccolo Daimao Level 6 avec 270.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=265' => 'Piccolo va faire un voeu !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'100',
								'http://www.2fight.com/images/obsc/40d15576340c.jpg',
								'Vous êtes mal barré les gars',
								'Piccolo obtient la jeunesse, et toi Gokû ??',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit avoir réalisé au moins 10 entraînement d\'énergie chez Maitre Karine.',
								'Prenez les entraînement pour 1 heure.',
								array(array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=267' => 'Le voeu de Piccolo')
							);
							echo '<br/>';
							
							echo creer_etape(
								'101',
								'http://www.2fight.com/images/obsc/a02f30e5baf5.jpg',
								'Le nouveau Roi Démon',
								'Piccolo prends possession du château du Roi !!<br/>
								Va en <a href="http://www.2fight.com/index.php?page=carte&case_x=4&case_y=5">D-5</a> l\'arrêter !',
								'',
								''
							);
							echo creer_action(
								'Tenshinhan doit combattre Drum Level 11 avec 275.010 de Ki classe Héros en combo Aléatoire',
								'',
								array(array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=268' => 'Le nouveau Roi')
							);
							echo '<br/>';
							
							echo creer_etape(
								'102',
								'http://www.2fight.com/images/obsc/322f7efceeca.jpg',
								'Le retour du Héros !',
								'Le combat contre le démon est en <a href="http://www.2fight.com/index.php?page=carte&case_x=4&case_y=5">D-5</a> ! Sauve Tenshinan !',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Drum Level 16 avec 250.010 de Ki classe Héros en combo Agressif',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=269' => 'Le monstre Drum')
							);
							echo '<br/>';
							
							echo creer_etape(
								'103',
								'http://www.2fight.com/images/obsc/bb24b420e097.jpg',
								'Le grand combat final !',
								'On combat Piccolo lui-même maintenant !',
								'',
								''
							);
							echo creer_action(
								'Tenshinhan doit combattre Piccolo Daimao Level 12 avec 370.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=270' => 'Combat final !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'104',
								'http://www.2fight.com/images/obsc/60ef441f34cc.jpg',
								'Nous disions donc, le grand combat final !',
								'Après ce petit contretemps, on reprends en <a href="http://www.2fight.com/index.php?page=carte&case_x=4&case_y=5">D-5</a>...',
								'',
								''
							);
							echo creer_action(
								'Chibi Goku doit combattre Piccolo Daimao Level 17 avec 355.000 de Ki classe Héros en combo Aléatoire',
								'',
								array(array(2, '5.000'), array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=271' => 'Combat final ! (vrai)',
									'http://www.2fight.com/index.php?page=histoire&oldev=307' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'105',
								'http://www.2fight.com/images/obsc/283a27d2acbb.jpg',
								'Le créateur des Dragon Ball',
								'Suite à la Tour Karine, en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a>.
								Gokû vient se ressourcer auprès de son maître après sa victoire.',
								'',
								''
							);
							echo creer_action(
								'Chibi Goku doit combattre Mr Popo Level 18 avec 290.010 de Ki class Héros en combo Aléatoire',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=272' => 'Dieu lui-même !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'106',
								'http://www.2fight.com/images/obsc/ba1725b0c411.jpg',
								'Au sanctuaire de Dieu',
								'Toujours en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a>, tu vas rencontrer Dieu ! La classe non ?',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Kami Sama Level 18 avec 410.000 de Ki classe Héros en combo Agressif',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&ev=old273' => '')
							);
							echo '<br/>';
							?>
							<br/>
							<h2 id="saga_23etournoi">Saga 23ème Tournois</h2>
							<br/>
							<?php
							echo creer_etape(
								'107',
								'http://www.2fight.com/images/obsc/3e3a6ddfc5f2.jpg',
								'De nouveau trois ans d\'entraînement',
								'Il est temps de rappeler la base basique de Dragon Ball : les entraînements ! Allez, le prochain tournoi arrive !',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit avoir fait un entraînement dans la Salle de l\'esprit et du temps à la tour Karine !',
								'Ne le faite pas avant, à cette étape, il ne coûte que 30.000 zénis ;) au lieu de 80.000 zénis.',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=274' => 'La suite des événements')
							);
							echo '<br/>';
							
							echo creer_etape(
								'108',
								'http://www.2fight.com/images/obsc/d7431bf4f405.jpg',
								'Nouveau tournoi des arts martiaux !',
								'Vous avez trois ans de de training devant vous.<br/>
								Gokû sait ce qu\'il va faire, mais qu\'en est-il des autres ? Ils en discutent à Kame House, en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=7">I-7</a>.',
								'',
								''
							);							
							echo creer_action(
								'Yamcha et Kulilin doivent avoir fait au moins un entraînement chez maître Karine. (Entraînement de magie).',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=275' => 'Que faire pendant 3 ans ?')
							);
							echo '<br/>';
							
							echo creer_etape(
								'109',
								'http://www.2fight.com/images/obsc/fdfe0d4f3743.jpg',
								'Une différence de taille',
								'Trois ans ont passés. Que fait-on ? On se retrouve en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a> !<br/>
								(vous devriez le savoir)',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=310' => 'Retrouvailles')
							);
							echo '<br/>';
							
							echo creer_etape(
								'110',
								'http://www.2fight.com/images/obsc/e384a3f325ca.jpg',
								'Éliminatoires : L\'ancien champion',
								'Akkuman se dit qu\'il devrait reprendre son vieux titre mondial. Mais est-il encore à la hauteur ?',
								'',
								''
							);
							echo creer_action(
								'Akkuman doit combattre Piccolo Level 8 avec 230.000 de Ki classe Héros en combo Magicien.',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=311' => 'Éliminatoires')
							);
							echo '<br/>';
							
							echo creer_etape(
								'111',
								'http://www.2fight.com/images/obsc/6032f8bfbad2.jpg',
								'Éliminatoires : une fille de la campagne',
								'La petite Chichi est venue au tournoi? Mais pourquoi donc ?...',
								'',
								''
							);
							echo creer_action(
								'Chichi doit combattre Muten Rôshi Level 8 avec 280.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=312' => 'Suite éliminatoires')
							);
							echo '<br/>';
							
							echo creer_etape(
								'112',
								'http://www.2fight.com/images/obsc/dcf09f1c0c8f.jpg',
								'Éliminatoires : le retour du Roi',
								'Chibi Gokû... ceci sera ton dernier combat de tout le mode histoire !',
								'',
								''
							);
							echo creer_action(
								'Chibi Gokû doit combattre Nam Level 19 avec 295.010 de Ki classe Héros en combo Agressif',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=313' => 'Suite éliminatoires, etc')
							);
							echo '<br/>';
							
							echo creer_etape(
								'113',
								'http://www.2fight.com/images/obsc/a6bb564f2542.jpg',
								'Éliminatoires : Une mauvaise surprise !',
								'Dernier match des éliminatoires, j\'espère que c\'est pas à nouveau contre un ex-champion du monde... je me demande d\'où ils sortent tous.<br/>
								Ah non, Diableman c\'est pas mon problème, hein !',
								'',
								''
							);
							echo creer_action(
								'Chaozu doit combattre Taopaipai Level 9 avec 255.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=276' => 'Les éliminatoires du tournoi')
							);
							echo '<br/>';
							
							echo creer_etape(
								'114',
								'http://www.2fight.com/images/obsc/a0996314da22.jpg',
								'Quart de finale : Tenshinan contre Taopaipai !',
								'Bon ben vous savez hein. Pour ceux qui sont perdus, c\'est toujours en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a>',
								'',
								''
							);
							echo creer_action(
								'Tenshinhan doit combattre Taopaipai Level 12 avec 400.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=277' => 'Quart de finale 1')
							);
							echo '<br/>';
							
							echo creer_etape(
								'115',
								'http://www.2fight.com/images/obsc/dd567013c58c.jpg',
								'Quart de finale : Chichi contre Son Gokû !',
								'',
								'',
								''
							);
							echo creer_action(
								'Chichi doit combattre Son Gokû Level 10 avec 210.010 de Ki classe Héros en combo Défensif',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=278' => 'Quart de finale 2')
							);
							echo '<br/>';
							
							echo creer_etape(
								'116',
								'http://www.2fight.com/images/obsc/1db47a905df0.jpg',
								'Quart de finale : Kulilin contre Ma Junior !',
								'',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre Piccolo Level 14 avec 340.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=279' => 'Quart de finale 3')
							);
							echo '<br/>';
							
							echo creer_etape(
								'117',
								'http://www.2fight.com/images/obsc/d6ef072b27c8.jpg',
								'Quart de finale : Yamcha contre Shen !',
								'',
								'',
								''
							);
							echo creer_action(
								'Yamcha doit combattre Kami Sama Level 15 avec 285.010 de Ki classe Héros en combo Agressif',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=280' => 'Quart de finale 4')
							);
							echo '<br/>';
							
							echo creer_etape(
								'118',
								'http://www.2fight.com/images/obsc/5bd12d682de5.jpg',
								'Demi-finale : Tenshinan contre Son Goku !',
								'',
								'',
								''
							);
							echo creer_action(
								'Tenshinhan doit combattre Son Gokû Level 14 avec 400.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(2, '2.000'), array(1, 'Kami Sama', 'http://www.2fight.com/images/obsc/8c62e29db965.gif')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=281' => 'Demi Finale 1')
							);
							echo '<br/>';
							
							echo creer_etape(
								'119',
								'http://www.2fight.com/images/obsc/8fcfd7245a36.jpg',
								'Demi-finale : Ma Junior contre Shen !',
								'',
								'',
								''
							);
							echo creer_action(
								'Kami Sama doit combattre Piccolo Level 5 avec 175.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(1, 'Son Gokû', 'http://www.2fight.com/images/obsc/335145c72c11.gif'), array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=282' => 'Demi Finale 2')
							);
							echo '<br/>';
							
							echo creer_etape(
								'120',
								'http://www.2fight.com/images/obsc/8a371b5149f5.jpg',
								'La finale : Son Gokû contre Ma Junior !',
								'',
								'',
								''
							);
							echo creer_action(
								'Son Gokû doit combattre Piccolo Level 4 avec 180.000 de Ki classe Héros en combo Aléatoire',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=283' => 'La Finale !') 
							);
							echo '<br/>';
							
							echo creer_etape(
								'121',
								'http://www.2fight.com/images/obsc/a9be4615f0af.jpg',
								'Kami Sama à la rescousse !',
								'Pour ceux qui sont perdus, c\'est toujours en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=8">F-8</a>.',
								'',
								''
							);
							echo creer_action(
								'Kami Sama doit combattre Piccolo Level 5 avec 185.000 de Ki classe Héros en combo Magicien',
								'',
								array(array(1, 'Piccolo', 'http://www.2fight.com/images/obsc/96f9b01202e6.gif'), array(4, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=290' => 'La finale, deuxième partie')
							);
							echo '<br/>';
							
							echo creer_etape(
								'122',
								'http://www.2fight.com/images/obsc/a09803d07a8f.jpg',
								'Fin du duel',
								'Bon, il va finir ce tournoi, oui ?',
								'',
								''
							);
							echo creer_action(
								'Piccolo doit combattre Son Gokû Level 5 avec 189.000 de Ki classe Héros en combo Aléatoire',
								'',
								array(array(2, '5.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=291' => 'La finale, dernière partie')
							);
							echo '<br/>';
							
							echo creer_etape(
								'123',
								'http://www.2fight.com/images/obsc/fbdd11b60773.jpg',
								'Fin d\'une ère...',
								'Ah ah ! Je le savais qu\'il sauverai le monde ! C\'est la deuxième fois là !',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=284' => 'Fin du tournoi')
							);
							echo '<br/>';
							
							echo creer_etape(
								'124',
								'http://www.2fight.com/images/obsc/ac08ca1e3e13.jpg',
								'La bénédiction du parent',
								'Voici ta nouvelle mission Gokû : va dans le monde des morts retrouver ton grand-père. Il te donnera sa bénédiction pour le mariage.<br/>
								Voici sa dernière adresse :<br/>
								Nuage avec vue sur le gouffre de l\'enfer,<br/>
								32, rue des nuages,<br/>
								93 203   Paradis',
								'',
								''
							);
							echo creer_action(
								'Son Gokû doit combattre Papy Gohan Level 6 avec 190.000 de Ki classe Héros en combo Aléatoire en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a> au monde des morts.',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=292' => '32, rue des nuages')
							);
							echo '<br/>';
							
							echo creer_etape(
								'125',
								'http://www.2fight.com/images/obsc/6fa2d2b642b6.jpg',
								'Bénédiction, suite',
								'Tu n\'en as pas fini avec Papy Son Gohan.',
								'',
								''
							);
							echo creer_action(
								'Chichi doit combattre Papy Gohan Level 11 avec 215.010 de Ki classe Héros en combo Agressif en 
								<a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=6">F-6</a> au monde des morts.',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=285' => '32, rue des nuages(bis)')
							);
							echo '<br/>';
							
							echo creer_etape(
								'126',
								'http://www.2fight.com/images/obsc/1f07c3543c67.jpg',
								'Mariage !',
								'Bravo, tu peux t\'unir dignement ! Vient donc sur le lieux du mariage pour fêter ça ! C\'est chez ton beau-père !
								Bah et moi je suis pas invitée ? Pourtant je suis pas loin...',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								array(array(7, 'Dragon Ball à 4 étoiles', '')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=293' => 'Mariage !!!')
							);
							echo '<br/>';
							
							echo creer_etape(
								'127',
								'http://www.2fight.com/images/obsc/6f304747427f.jpg',
								'La famille Son s\'agrandit !',
								'Nous entrons dans une nouvelle époque. Contre toute attente, Son Gokû a semble-t-il réussi à gérer une vie de famille sans divorce pendant cinq ans.
								Va dans ta maison, en <a href="http://www.2fight.com/index.php?page=carte&case_x=8&case_y=6">H-6</a>.',
								'',
								''
							);
							echo creer_action(
								'Vous devez avoir en votre possession les jeux : Legacy Of Goku 1, 2 et 3.',
								'',
								array(array(1, 'Son Gohan', 'http://www.2fight.com/images/obsc/78f2f06120fc.gif'), array(9, 'Venez voir', '2')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=286' => 'Entrez dans l\'ère de DBZ !')
							);
							echo '<br/>';
							?>
							<br/>
							<h2 id="saga_saiyans">Saga Saiyans</h2>
							<br/>
							<?php
							echo creer_etape(
								'128',
								'http://www.2fight.com/images/obsc/c7296969721b.jpg',
								'Entrée officielle dans Dragon Ball Z',
								'C\'est parti pour l\'aventure ! On vous attends à la Kame House pour une partie de Monopoly !
								Sinon, une quête secondaire vient de s\'ouvrir ! A toi de la trouver...',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=296' => 'La petite famille')
							);
							echo '<br/>';
							
							echo creer_etape(
								'129',
								'http://www.2fight.com/images/obsc/f7bb80c4b77a.jpg',
								'Un mystérieux guerrier',
								'Une capsule étrange est tombée sur la Terre. Un être énigmatique en est sorti, il est parti en direction de Kame House, allez voir !
								En <a href="http://www.2fight.com/index.php?page=carte&case_x=9&case_y=7">I-7</a> !',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=1' => 'Un mystérieux guerrier')
							);
							echo '<br/>';
							
							echo creer_etape(
								'130',
								'http://www.2fight.com/images/obsc/11df69adb776.jpg',
								'Raditz',
								'Raditz s\'est enfui avec Son Gohan, il l\'a emmené dans sa capsule !',
								'',
								''
							);
							echo creer_action(
								'Piccolo doit combattre Raditz level 7 avec 215.000 de Ki classe Héros en combo Magicien en <a href="http://www.2fight.com/index.php?page=carte&case_x=8&case_y=3">H-3</a>',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=2' => 'Capsule inconnue')
							);
							echo '<br/>';
							
							echo creer_etape(
								'131',
								'http://www.2fight.com/images/obsc/7b0eba427575.jpg',
								'Raditz',
								'C\'est maintenant à Son Gokû, qui est resté sur les lieux, d\'affronter le terrible Raditz.',
								'',
								''
							);
							echo creer_action(
								'Son Gokû doit combattre Raditz level 7 avec 275.000 de Ki classe Héros en combo Magicien en <a href="http://www.2fight.com/index.php?page=carte&case_x=8&case_y=3">H-3</a>',
								'Après cette étape, Son Gokû sera envoyer au monde des morts, il est seulement mort, vous pouvez le ressusciter à tout moment.',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=3' => 'Capsule inconnue',
									'http://www.2fight.com/index.php?page=histoire&oldev=4' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'132',
								'http://www.2fight.com/images/obsc/8c964c601e2d.jpg',
								'Un an d\'entrainements',
								'Bougez-vous le cul, les Saiyans arrivent dans un an !<br/>
								Tout le monde chez Kami, en <a href="http://www.2fight.com/index.php?page=carte&case_x=2&case_y=5">B-5</a> !',
								'',
								''
							);
							echo creer_action(
								'Kulilin, Yamcha, Tenshinhan, Chaozu doivent faire un entraînement de la salle de l\'esprit et du temps.',
								'Ne les faites pas avant, mais à partir de cette étape, l\'entraînement coûte 30.000 zénis au lieu de 80.000 profitez-en !',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=297' => 'Préparation pour les Saiyans')
							);
							echo '<br/>';
							
							echo creer_etape(
								'133',
								'http://www.2fight.com/images/obsc/4eaa26afb536.jpg',
								'Les Saiyans sont arrivés !',
								'Ils ont déjà détruit une ville pour fêter l\'atterrissage !<br/>
								J\'ai détecté où la rencontre aura lieu... en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a> !',
								'',
								''
							);
							echo creer_action(
								'Tenshinhan doit combattre Saïbaman level 15 avec 275.000 de Ki classe Héros en combo Agressif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=298' => 'L\'arrivée des Saiyans !')
							);
							echo '<br/>';
							
							echo creer_etape(
								'134',
								'http://www.2fight.com/images/obsc/073053295958.jpg',
								'Les Saiyans sortent leurs pokemons',
								'Faut combattre les gars.',
								'',
								''
							);
							echo creer_action(
								'Chaozu doit combattre Saïbaman level 10 avec 290.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=299' => 'Les Saïbamen')
							);
							echo '<br/>';
							
							echo creer_etape(
								'135',
								'http://www.2fight.com/images/obsc/26c0ebd3db5d.jpg',
								'Chacun le sien !',
								'Je choisis... Yamcha !',
								'',
								''
							);
							echo creer_action(
								'Yamcha doit combattre Saïbaman level 17 avec 285.010 de Ki classe Héros en combo Agressif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=300' => 'Les Saïbamen')
							);
							echo '<br/>';
							
							echo creer_etape(
								'136',
								'http://www.2fight.com/images/obsc/029ef83f898a.jpg',
								'Mass Death',
								'Kulilin va en finir !!',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre Saïbaman level 15 avec 255.010 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=301' => 'Les Saïbamen')
							);
							echo '<br/>';
							
							echo creer_etape(
								'137',
								'http://www.2fight.com/images/obsc/12efdfb120ac.jpg',
								'Le véritable combat',
								'Ce sont les Saiyans qui se battent maintenant !<br/>
								Rappel: en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								''
							);
							echo creer_action(
								'Chaozu doit combattre Nappa level 11 avec 295.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(4, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=302' => 'Les Saïbamen')
							);
							echo '<br/>';
							
							echo creer_etape(
								'138',
								'http://www.2fight.com/images/obsc/2319162dfbf8.jpg',
								'Désespoir',
								'Ça ne va pas...',
								'',
								''
							);
							echo creer_action(
								'Tenshinhan doit combattre Nappa level 15 avec 435.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=6' => 'Les Saiyans 1')
							);
							echo '<br/>';
							
							echo creer_etape(
								'139',
								'http://www.2fight.com/images/obsc/11f6f6243ca4.jpg',
								'Les nouvelles techniques de Kulilin',
								'Déjà 3 morts ! Kulilin subira-t-il le même sort ?<br/>
								<br/>
								Je te rappelle que les Saiyans sont sur la grande île à gauche de l\'île du tournoi.',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre Nappa level 15 avec 375.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=7' => 'Les Saiyans 2')
							);
							echo '<br/>';
							
							echo creer_etape(
								'140',
								'http://www.2fight.com/images/obsc/8e289c31de38.jpg',
								'Piccolo est un extra-terrestre !',
								'Toujours au même endroit, Piccolo qui vient d\'apprendre ses origines se lance dans le combat.',
								'',
								''
							);
							echo creer_action(
								'Piccolo doit combattre Nappa level 8 avec 230.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=8' => 'Les Saiyans 3')
							);
							echo '<br/>';
							
							echo creer_etape(
								'141',
								'http://www.2fight.com/images/obsc/7d3f37ae29f3.jpg',
								'Coup final',
								'Toujours au même endroit, Son Gohan est appellé à la barre...',
								'',
								''
							);
							echo creer_action(
								'Son Gohan doit combattre Nappa level 5 avec 175.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=9' => 'Les Saiyans 4')
							);
							echo '<br/>';
							
							echo creer_etape(
								'142',
								'http://www.2fight.com/images/obsc/ed5105f75837.jpg',
								'Son Gokû, à l\'aide !',
								'Son Gokû, qu\'attends-tu pour venir ? Il y a des gens qui meurent ici !! Quoi ? Ben fini-le, ton entraînement chez Kaioh !',
								'',
								''
							);
							echo creer_action(
								'Son Gokû doit avoir fait l\'entraînement de Kaioh.',
								'Si vous l\'avez fait avant, ça fonctionne aussi. Ce train est très important, il vous donne +2.000 dans toutes les caractéristique !',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=10' => 'Les Saiyans 5')
							);
							echo '<br/>';
							
							echo creer_etape(
								'143',
								'http://www.2fight.com/images/obsc/168bfa44a128.jpg',
								'Son Gokû, à l\'aide ! (2)',
								'Fonce sur ton nuage, Gokû ! Tu sens les énergies des Saiyans à gauche de l\'île des tournois, 
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a> !',
								'',
								''
							);
							echo creer_action(
								'Son Gokû doit combattre Nappa level 8 avec 285.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '1.000'), array(3, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=11' => 'Les Saiyans 6')
							);
							echo '<br/>';
							
							echo creer_etape(
								'144',
								'http://www.2fight.com/images/obsc/36c5e949a988.jpg',
								'Son Gokû, à la rescousse',
								'Nappa est tué par Vegeta !<br/>
								Gokû doit maintenant faire face au prince... Toujours en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>.',
								'',
								''
							);
							echo creer_action(
								'Son Gokû doit combattre Végéta level 8 avec 310.000 de Ki classe Héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=12' => 'Saiyans : Vegeta')
							);
							echo '<br/>';
							
							echo creer_etape(
								'145',
								'http://www.2fight.com/images/obsc/1cc91bbadaf5.jpg',
								'Le prince des Saiyans',
								'Vegeta s\'est transformé ! Encore du courage, Son Gokû !',
								'',
								''
							);
							echo creer_action(
								'Son Gokû doit combattre Oozaru level 9 avec 330.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=13' => 'Saiyans : Vegeta')
							);
							echo '<br/>';
							
							echo creer_etape(
								'146',
								'http://www.2fight.com/images/obsc/49636e9cb84c.jpg',
								'Kulilin et Gohan à la rescousse',
								'Kulilin arrivera-t-il à couper la queue du monstre ?
								Moi je vais rester tranquillement chez moi à regarder le combat sur ma boule de cristal 16 / 9ième.',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre Oozaru level 16 avec 280.010 de Ki classe Héros en combo Agressif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=14' => 'Saiyans : Vegeta')
							);
							echo '<br/>';
							
							echo creer_etape(
								'147',
								'http://www.2fight.com/images/obsc/d338db4d1e00.jpg',
								'Le genkidama',
								'Vegeta vous en veut beaucoup de lui avoir coupé sa précieuse queue !<br/>
								Vite Son Gohan, retiens le pendant que Kulilin prends le Genkidama de Son Gokû !',
								'',
								''
							);
							echo creer_action(
								'Son Gohan doit combattre Végéta level 6 avec 205.00 de Ki classe héros en combo Magicien
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=15' => 'Saiyans : Vegeta')
							);
							echo '<br/>';
							
							echo creer_etape(
								'148',
								'http://www.2fight.com/images/obsc/7f89bd7bcd64.jpg',
								'Gohan tourne mal',
								'Son Gohan tu... quelle horreur ! Chichi s\'est évanouie sur ma boule !
								Kulilin, retiens-le, il ne se maîtrise plus !
								Je vous rappelle tout cela se passe sur la grande île à gauche de l\'île du tournoi. 
								Oui, en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>.',
								'',
								''
							);
							echo creer_action(
								'Kulilin doit combattre Oozaru level 17 avec 305.010 de Ki classe Héros en combo Agressif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=5&case_y=8">E-8</a>',
								'',
								array(array(2, '1.000'), array(3, '1'), array(4, '1')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=16' => 'Saiyans : Vegeta',
									'http://www.2fight.com/index.php?page=histoire&oldev=17' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'149',
								'http://www.2fight.com/images/obsc/a38e9b8eb81f.jpg',
								'Se remettre de ses émotions',
								'Nos amis sont en <a href="http://www.2fight.com/index.php?page=carte&case_x=4&case_y=5">D-5</a>, à l\'hôpital.',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=324' => 'Se remettre de ses émotions')
							);
							echo '<br/>';
							
							echo creer_etape(
								'150',
								'http://www.2fight.com/images/obsc/b45008db6291.jpg',
								'La langue Namek',
								'Qui va accompagner nos héros ? Qui est bon en langues ?<br/>
								A vous de décider !',
								'',
								''
							);
							echo creer_action(
								'Chichi doit combattre Mr Popo level 12 avec 240.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=1">F-1</a>',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=326' => 'La langue Namek')
							);
							echo '<br/>';
							
							echo creer_etape(
								'151',
								'http://www.2fight.com/images/obsc/68f1a459a15a.jpg',
								'La langue Namek (2)',
								'Qui va accompagner nos héros ? Qui est bon en langues ?<br/>
								A vous de décider.',
								'',
								''
							);
							echo creer_action(
								'Buma doit combattre Mr Popo level 10 avec 240.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=6&case_y=1">F-1</a>',
								'',
								array(array(2, '1.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=327' => 'La langue Namek (2)')
							);
							echo '<br/>';
							
							echo creer_etape(
								'152',
								'http://www.2fight.com/images/obsc/dc89fbd8d88e.jpg',
								'L\'encyclopédie',
								'Bulma a besoin d\'une Encyclopédie Galactique et d\'autres objets pour pouvoir t\'emmener sur la planète Namek, trouve ce qu\'il faut !
								Va à la capitale lui demander des détails ou lui donner ces objets.',
								'',
								''
							);
							echo creer_action(
								'',
								'Obtennez le dictionnaire de Namek en l\'achetant à la librairie.<br/>
								Obtennez l\'encyclopédie en échangeant 5 jeux vidéos chez Gyumao.<br/>
								Obtennez 5 morceaux de métal en fouillant ou en les achetant au marché.',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=18' => 'Création du Vaisseau')
							);
							echo '<br/>';
							?>
							<br/>
							<h2 id="saga_namek">Saga Namek</h2>
							<br/>
							<?php
							echo creer_etape(
								'153',
								'http://www.2fight.com/images/obsc/d1bf42becd24.jpg',
								'Balade sur Namek',
								'Bravo ! Tu peux maintenant changer de planète ! Regarde sur la carte !!<br/>
								Et bien... il faut trouver un village maintenant !<br/>
								Tu ressens des forces pas très loin au sud.',
								'',
								''
							);
							echo creer_action(
								'Son Gohan doit combattre Dodoria level 7 avec 215.000 de Ki classe Héros en combo Aléatoire
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=8">C-8</a> sur Namek.',
								'',
								array(array(2, '2.000')),
								array('http://www.2fight.com/index.php?page=histoire&oldev=19' => 'C\'est pas des Nameks ça !',
									'http://www.2fight.com/index.php?page=histoire&oldev=20' => 'Après le combat')
							);
							echo '<br/>';
							
							echo creer_etape(
								'154',
								'http://www.2fight.com/images/obsc/c879d83c78db.jpg',
								'Le petit Dendé',
								'Ce petit Namek a bien des choses à vous dire...',
								'',
								''
							);
							echo creer_action(
								'',
								'',
								array(array(1, 'Végéta', 'http://www.2fight.com/images/obsc/9eceaaffec69.gif')),
								array('' => '')
							);
							echo '<br/>';
							
							echo creer_etape(
								'155',
								'http://www.2fight.com/images/obsc/3fb93452f877.jpg',
								'La quête de Vegeta',
								'Pendant ce temps, à Vera Cruz, Vegeta entend bien s\'emparer des Dragon Balls,
								et pour cela il faut d\'abord éliminer un à un les hommes de Freeza... 
								mais n\'en vois-je pas un qui se balade tout seul près d\'un village Namek ?',
								'',
								''
							);
							echo creer_action(
								'Vegeta doit combattre Dodoria level 5 avec 168.000 de Ki classe Héros en combo Agressif
								en <a href="http://www.2fight.com/index.php?page=carte&case_x=3&case_y=8">C-8</a> sur Namek.',
								'',
								'',
								array('http://www.2fight.com/index.php?page=histoire&oldev=22' => 'Dodoria')
							);
							echo '<br/>';
							?>
						</div>
						<br/>
						<h1>La suite plus tard ...</h1>
						<br/>
						<?php
						}
						?>
					</div>
					<br/>
				</div>
			<div class="nb"></div> <!-- Fin news -->
		</div><!-- Fin centre -->
		<?php
	}
	else
	{
		echo 'Haha';
	}
}
else
{
	/* Titre de la page */
	$titre = 'Astuce : 2Fight';
	/********************/
	
	/* Définition du TITRE du CADRE du contenu de la page */
	$titre2 = 'Astuce : 2Fight';
	/******************************************************/

	/* Haut de la page, contient le doctype, charset, etc... */
	include('../includes/haut.php');
	/*********************************************************/
	?>
	<div class="content"><!-- Début centre -->	 
		<div class="nh"></div> <!-- News -->
			<div class="nf">
				<div id="fil_ariane">
					<?php echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(1, 'astuce/', 'Liste des astuces').' '.fil_ariane(1, 'astuce/', 'Choix d\'un jeu').' '.fil_ariane(2, '', 'Liste des astuce du jeux '.$_GET['astuces'].''); ?>
				</div>
				<h1>Liste des astuces du jeux 2Fight</h1>
				<ul>
					<li><a href="<?php echo ROOTPATH; ?>/astuce/?astuces=2fight&amp;type=mh">Mode Histoire</a></li>
				</ul>
				<br/>
			</div>
		<div class="nb"></div> <!-- Fin news -->
	</div><!-- Fin centre -->
	<?php
}
?>
