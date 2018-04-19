<?php
if(isset($_POST['hash']))
{
	$password = htmlspecialchars($_POST['password']);
	$debut = "kikugalanet";
	$fin = $password;
	$hash = md5($debut.$fin);
	echo 'Voici votre mot de passe hasher en md5 kikugalanet : '.$hash.'<br/>';
	echo '<a href="">Recommencer</a><br/>';
}
else
{
?>
Votre mot de passe à hasher :<form method="post" action=""><input type="text" name="password" /><input type="submit" value="Hasher" name="hash" /></form>
<?php
}
?>