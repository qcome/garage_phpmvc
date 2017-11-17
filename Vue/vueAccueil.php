<?php 

function afficherVueAccueil($err_msg){
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
			<input type="submit" name="loginsubmit" value="Identification" />
		</p>';
	if($err_msg != ''){
		$contenu.='<div class="alert"> Erreur: &nbsp;'.$err_msg.'!</div>';
	}
	$contenu .='</fieldset>';
	
	require_once 'gabarit.php';
}



