<?php
/*
page/captcha.php

Captcha de l'inscription
*/
session_start();
// Là, on définit le header de la page pour la transformer en image
header ("Content-type: image/png");
// Là, on crée notre image
$_img = imagecreatefrompng('../design/fond_verif_img.png');

// On définit maintenant les couleurs
// Couleur de fond :
$arriere_plan = imagecolorallocate($_img, 0, 0, 0); // Au cas où on n'utiliserait pas d'image de fond, on utilise cette couleur-là.
// Autres couleurs :
$avant_plan = imagecolorallocate($_img, 255, 255, 255); // Couleur des chiffres

##### Ici on crée la variable qui contiendra le code aléatoire #####
$code = null;
$lettre = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E', '5' => 'F', '6' => 'G', '7' => 'H', '8' => 'I', '9' => 'J', '10' => 'K', '11' => 'L', '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', '16' => 'Q', '17' => 'R', '18' => 'S', '19' => 'T', '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', '24' => 'Y', '25' => 'Z');
$a = mt_rand(0,25);
$b = mt_rand(0,9);
$c = mt_rand(0,25);
$d = mt_rand(0,25);
$e = mt_rand(0,9);
$f = mt_rand(0,25);
$g = mt_rand(0,9);
$code .= $lettre[$a].$b.$lettre[$c].$lettre[$d].$e.$lettre[$f].$g;
##### On a fini de créer le code aléatoire, on le rentre maintenant dans une variable de session #####
$_SESSION['aleat_nbr'] = $code;

imagestring($_img, 5, 18, 8, $code, $avant_plan);

imagepng($_img);