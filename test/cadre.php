<form method="post" action="#">
    <label for="longueur">Longueur du cadre :</label> <input type="text" name="longueur" id="longueur" /><br/>
    <label for="largeur">Largeur du cadre :</label> <input type="text" name="largeur" id="largeur" /><br/>
    <label for="type">Type du cadre :</label>
    <select name="type" id="type">
        <?php
        for($i=1;$i<=4;$i++)
        {
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
        ?>
    </select>
    <input type="submit" name="submit" value="Soumettre" />
</form>
<?php
function creer_cadre($ligne, $colonne, $type)
{
    switch($type)
    {
        case "1":
            $type_1_1 = 'o';
            $type_1_2 = '-';
            $type_1_3 = '|';
        break;
    }
    for($i_ligne=1; $i_ligne <= $ligne; $i_ligne++)
    {
        for($i_colonne = 1; $i_colonne <= $colonne; $i_colonne++)
        {
            if($i_ligne != 1 && $i_ligne != $ligne)
            {
                if($i_colonne == 1 || $i_colonne == $colonne)
                {
                    echo $type_1_3;
                }
                else
                {
                    echo ' ';
                }
            }
            else
            {
                echo $type_1_1;
            }
        }
        echo '<br/>';
    }
}
if(isset($_POST['submit']))
{
?>
<pre>
<?php
creer_cadre($_POST['longueur'], $_POST['largeur'], $_POST['type']);
?>
</pre>
<?php
}
?>