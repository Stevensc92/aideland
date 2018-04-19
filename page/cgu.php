<?php
/*
page/cgu.php

L'inscription au site
*/

/* Titre de la page */
$titre = 'Condition Générales d\'Utilisation';
/********************/

/* Définition du TITRE du CADRE du contenu de la page */
$titre2 = 'Condition Générales d\'Utilisation';
/******************************************************/

/* Haut de la page, contient le doctype, charset, etc... */
include('includes/haut.php'); 
/*********************************************************/
?>
<div id="content"><!-- Début centre -->	 
	<div class="nh"></div> <!-- News -->
		<div class="nf">
			<div id="fil_ariane">
			<?php
				echo fil_ariane(1, '', 'Accueil').' '.fil_ariane(2, '?page=cgu', 'Conditions Générales d\'Utilisation');
			?>
			</div>
			<br/>
			<h1><?php echo $titre2; ?></h1>
			<br/>
			<p>
				Les conditions générales d'utilisation sont à respecter dans leur intégraliter totale.
				Aucune infraction/fraude ne sera toléré. Toute infraction/fraude sera durement sanctionnée.
			</p>
			<br/>
			<h1 id="utilisation">1. Utilisation d'Help World</h1>
			<br/>
			<p>
				Help World est un site conçu pour aider des personnes en difficulté selon leur endroit.
				Toutes les astuces qui seront postées auront une signature propre de l'auteur qui certifiera l'empêchement de copie sans demande préalable.
				Une astuce qui se voit être copiée, recopiée, modifiée au niveau du contenu général, sans en avoir demandé l'autorisation à l'auteur, sera sanctionnée directement.
				Vous devez respecter le travail d'autrui. Les insultes envers l'auteur d'une diverse astuce sont à éviter, si celle-ci est mal faite, la page <a href="<?php echo ROOTPATH; ?>/?page=contact">contact</a> est là pour ça.
				Chaque astuce postée est examinée par des correcteurs. Certaines mises en forme d'astuce seront réorganisées par les correcteurs pour une meilleure visibilité.
				Les fautes d'orthographe et autres seront corrigées. Cependant, les correcteurs sont pas des machines.
				Veillez tout de même à faire le moins de fautes possible pour faciliter le travail des correcteurs.
				Les astuces postées qui sont en rapport avec le hacking, le piratage ou autre, seront supprimées dès leur lecture.
			</p>
			<br/>
			<h1 id="comportement">2. Comportement</h1>
			<br/>
			<p>
				Toute personne s'inscrivant à Help World certifie avoir pris connaissance des CGU.
				Tout comportement irrespectueux (insulte, provocation, demande de mot de passe, menace,  et autre (voir liste ci-dessous) ) sera sanctionné par des avertissements et/ou bannissements.
				Si un comportement vous semble étrange, douteux, particulier, menaçant quelqu'un et ou autre, c'est <a href="<?php echo ROOTPATH; ?>/?page=contact">ici</a> que ça se passe.
				La personne concernée se verra attribuer une sanction le plus tôt possible. Voici une liste des actions à ne pas faire  :
			</p>
				<ul>
					<li><span class="list"></span>&nbsp;Aucune insulte.</li>
					<li><span class="list"></span>&nbsp;Aucune provocation.</li>
					<li><span class="list"></span>&nbsp;Aucune menace.</li>
					<li><span class="list"></span>&nbsp;Aucune demande de mot de passe.</li>
					<li><span class="list"></span>&nbsp;Aucun racisme.</li>
					<li><span class="list"></span>&nbsp;Aucune tentative de Hacking, Scriptage et autre.</li>
					<li><span class="list"></span>&nbsp;Aucune écriture de style sms :</li>
					 <ul>
						<li><span id="erreur"><span class="list"></span>&nbsp;Slt jmapel Jean é g 10 pige ms osef de twa (Faux !)</span></li>
						<li><span id="information"><span class="list"></span>&nbsp;Salut, je m'appelle Jean et j'ai 10 ans mais on s'en fout de toi. (Correcte !)</span></li>
					 </ul>
				</ul>
				<p>
					Et pour varier un peu, une liste des choses à savoir/faire :
				</p>
				<ul>
					<li><span class="list"></span>&nbsp;Respect d'autrui (Membre/Équipe <acronym title="Help World">HW</acronym>).</li>
					<li><span class="list"></span>&nbsp;Parler français.</li>
					<li><span class="list"></span>&nbsp;Savoir communiquer avec d'autres personne.</li>
					<li><span class="list"></span>&nbsp;Savoir garder son calme.</li>
					<li><span class="list"></span>&nbsp;Savoir avertir un membre de l'équipe pour X chose.</li>
					<li><span class="list"></span>&nbsp;Savoir donner des titres explicites</li>
				</ul>
			<p>
				Si chaque condition n'est pas remplie, Une sanction se verra être exécutée.
			</p>
			<br/>
			<h1 id="upload">3. Upload</h1>
			<br/>
			<p>
				Lors de l'uploadement d'avatar, aucun contenu pornographique, raciste, juridique ou autre devra y figurer.
				Si un des contenus est présenté dans l'avatar, cet avatar sera supprimé ET la personne sera sanctionnée.
				Les avatars ne doivent pas excéder 75Ko, et doivent faire 150 pixel * 150 pixel (150 Pixel de hauteur * 150 Pixel de largeur) et doivent être de format PNG, JPG, GIF, JPEG.
			</p>
			<br/>
			<h1 id="forum">4. Le forum</h1>
			<br/>
			<p>
				Dans le forum, il est primordial d'avoir un comportement appréciable <a href="#comportement">(Cf chapitre 2)</a> .
				De savoir effectuer des recherches pour trouver avant tout si ce que vous chercher existe déjà. Des tutoriels sur "Comment effectuer une recherche" seront disponibles.
				Si vous ne trouvez pas ce que vous vouliez après maintes tentatives, vous pouvez créer un sujet parlant de votre problème ou autre.
				Je vous rappelle qu'un titre explicite donnera plus envie de lire et essayer de comprendre votre problème.<br/>
				Exemple de titre non explicite : 
			</p>
				<ul>
					<li><span class="list"></span>&nbsp;<span id="erreur">à l'aide j'ai un problème ! (Faux !) .</span></li>
					<li><span class="list"></span>&nbsp;<span id="erreur">ça fonctionne po ! (Faux !) .</span></<li>
				</ul>
			<p>
				Et maintenant, leur titre explicite :
			</p>
				<ul>
					<li><span class="list"></span>&nbsp;<span id="information">Aidez moi, notepad++ ne veut plus se lancer. (Correcte !) .</span></li>
					<li><span class="list"></span>&nbsp;<span id="information">Ma boucle while() ne fonctionne pas. (Correcte !) .</span></li>
				</ul>
			<p>
				Cependant, votre vocabulaire devra aussi être le plus français possible, donc le langage SMS est à oublier dès maintenant.
				En cas d'abus total de langage SMS, vous seriez averti une première fois, puis une seconde et enfin une troisième fois, si vous continuez, ce sera des bannissements temporaire.
				Les UP de vos sujets sont seulement réalisable 48H après. Les doubles post sont interdits, la fonction éditer est faite pour ça ! pour éviter les multis post.
				Vous devez aussi, respecter les choix des Modérateurs / Administrateur du forum de toute action (suppression de sujet + <acronym title="Message Privé">MP</acronym> envoyé pour expliquer la suppression du sujet, vérouillage du sujet + explication par MP) .
				Vous devez, et c'est obligatoire, lire chaque sujet marqué en post-it, annonce ou autre. Certains précisent des choses à faire/ne pas faire dans diverses sections.
			</p>
		</div>
	<div class="nb"></div> <!-- Fin news -->
</div><!-- Fin centre -->