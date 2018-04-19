<?php
function multiple($nb)
{
    echo "Table de multiplication de $nb :<br/>";
    $nb_multiple = 0;
    while($nb_multiple <= 20)
    {
        $result = $nb_multiple*$nb;
        echo "$nb_multiple * $nb = $result <br/>";
        $nb_multiple++;
    }
}
?>

<form method="post" action ="#">
    <label for="number" id="number" name="number">Entrer un chiffre :<input type="text" name="number" /><br/>
    <input type="submit" name="submit" /><br/>
</form>

<?php
if(isset($_POST['submit']))
{
    $_POST['number'] == isset($_POST['number'])?htmlspecialchars($_POST['number']):'';
    if(isset($_POST['number']) && $_POST['number'] != '' && preg_match("#^[0-9]{1,5}$#", $_POST['number']))
    {
        
        print_r(multiple($_POST['number']));
    }
    else
    {
        echo 'Tout nest pas bon';
    }
}
else
{
    echo 'Formulaire failed';
}
?>