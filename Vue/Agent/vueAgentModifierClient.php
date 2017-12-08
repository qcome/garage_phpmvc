<?php
function afficherModifierClient ($data='', $err_msg=''){
	$contenu = '<div class="elem">
				<h3>Modifier client</h3>
				<form method="post">
					<label for="id_client">ID client :</label> 
					<input type="text" name="idClient" id="id_client" required />
					<input type="submit" name="modifierClientID" value="Valider" />
				</form>
				</div>';
	$contenu.= $data;
	$contenu.= $err_msg;
	afficherVueAgent($_SESSION['username'], $contenu);
}

function afficherModifierClientRes ($res, $err_msg=''){
    $client=$res[0];
	$contenu = '<div class="elem">
					<div class="formulaire">
						<form method="post">
						<fieldset>
						<legend><h3>Informations</h3></legend>
							<label for="nom_client">Nom :</label> 
							<input type="text" name="nomClient" id="nom_client" value="'.$client->client_lastname.'" required />
							<br>
							<label for="prenom_client">Prénom :</label> 
							<input type="text" name="prenomClient" id="prenom_client" value="'.$client->client_firstname.'" required />
							<br>
							<label for="birthday_client">Date de naissance :</label> 
							<input type="date" name="birthdayClient" id="birthday_client" value="'.$client->client_birthday.'" required />
							<br>
							<label for="adresse_client">Adresse :</label> 
							<input type="text" name="adresseClient" id="adresse_client" value="'.$client->client_address.'" required />
							<br>
							<label for="phone_client">Num tel :</label> 
							<input pattern="[0-9]{10}" name="phoneClient" id="phone_client" value="'.$client->client_phonenum.'" required/>
							<br>
							<label for="mail_client">E-Mail :</label> 
							<input type="email" name="mailClient" id="mail_client" value="'.$client->client_mail.'" required />
							<br>
							<label for="diff_client">Différé :</label> 
							<input type="number" name="diffClient" id="diff_client" value="'.$client->client_maxdiff.'" required />
							<br>
							<input type="submit" name="modifierClientSubmit" value="Modifier" />
						</fieldset>
						</form>
					</div>
				</div>';
	$contenu.= $err_msg;
	afficherModifierClient($contenu);
}