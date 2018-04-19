<?php
function ecrire_sapin($nb_ligne)
{
    for($l = 1; $l <= $nb_ligne; $l++)
    {
        for($i = 1; $i <= $l; $i++)
        {
            echo '*';
        }
        echo '<br/>';
    }
}

for ($n=2;$n<=50;$n+=2) ecrire_sapin($n);

?>