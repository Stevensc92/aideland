<h3>Quêlte Alternatif : Quête Annexe ! Venez voir !!</h3>
<div class="mh_2f qa">
	<?php
	echo creer_etape(
		'1',
		'',
		'',
		creer_action(
			'Aller en <a href="http://www.2fight.com/index.php?page=carte&case_x=8&case_y=6">H-6</a> (Maison) pour commencer la quête.<br/> 
			Valider l\'étape en passant le dialogue.',
			'Aucun pour cette étape',
			'',
			array('http://www.2fight.com/index.php?page=histoire&ev=314' => 'Quête Annexe ! Venez voir !!')
		),
		'<br/><br/>',
		''
	);
	echo '<br/>';
	
	echo creer_etape(
		'2',
		'',
		'',
		creer_action(
			'Vous devez utiliser le dragon radar pour vous rendre en <a href="http://www.2fight.com/index.php?page=carte&case_x=8&case_y=2">H-2</a>.<br/>
			Krillin doit combattre',
			'Aucun pour cette étape',
			'',
			array('http://www.2fight.com/index.php?page=histoire&ev=287' => 'Quête Annexe ! Suite !!')
		),
		'<br/><br/>',
		''
	);
	echo '<br/>';
	
	echo creer_etape(
		'3',
		'',
		'',
		creer_action(
			'Kulilin doit combattre Chibi Gokû Level 22 avec 530.000 de Ki classe Héros en combos Aléatoire.',
			'Aucun pour cette étape',
			array(array(3, '1')),
			array('http://www.2fight.com/index.php?page=histoire&oldev=330' => 'L\'entrainement de Muten Rôshi (2)')
		),
		'<br/><br/>',
		''
	);
	echo '<br/>';	
	?>
</div>