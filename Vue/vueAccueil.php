<?php 

#si function appelé avec un argument, ajoute le message d'erreur
function afficherVueAccueil($err_msg = ''){
	$titre = 'Accueil';
	$contenu = '<form method="post">
	<fieldset>
		<legend>Identifiant</legend>
		<p>
			<label for="login">Login :</label> 
			<input type="text" name="user" id="login" required />
		</p>
		<p>
			<label for="password">Mot de passe :</label> 
			<input type="password" name="pwd" id="password" required /> 
			<br>
			<br>
			<input type="submit" name="loginsubmit" value="Identification" />
		</p>'.$err_msg.'</fieldset>';
	
	
	require_once 'gabarit.php';
}




