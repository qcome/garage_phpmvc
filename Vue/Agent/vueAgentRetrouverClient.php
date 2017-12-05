<?php

function afficherRetrouverClient($data='', $err_msg=''){
	$contenu = '<div class="elem">
				<h3>Retrouver client</h3>
				<form method="post">
					<label for="nom_client">Nom client :</label> 
					<input type="text" name="nomClient" id="nom_client" required />
					<br>
					<label for="birthday_client">Date de naissance :</label> 
					<input type="date" name="birthdayClient" id="birthday_client" required />
					<input type="submit" name="retrouverClientSubmit" value="Valider" />
				</form>
				</div>';
	$contenu.= $data;
	$contenu.= $err_msg;
	afficherVueAgent($_SESSION['username'], $contenu);
}

function afficherRetrouverClientResultat($client_id){
	$contenu = '';
	$contenu.= '<div class="elem">Client trouvé! Voici son id: ';
	$contenu.= $client_id.'</div>';
	afficherRetrouverClient($contenu);
}