<?php

function afficherAjouterClient($notification=''){
	$contenu = '<div class="elem">
					<div class="formulaire">
						<form method="post">
						<fieldset>
						<legend><h3>Ajouter client</h3></legend>
							<label for="nom_client">Nom :</label> 
							<input type="text" name="nomClient" id="nom_client" required />
							<br>
							<label for="prenom_client">Prénom :</label> 
							<input type="text" name="prenomClient" id="prenom_client" required />
							<br>
							<label for="birthday_client">Date de naissance :</label> 
							<input type="date" name="birthdayClient" id="birthday_client" required />
							<br>
							<label for="adresse_client">Adresse :</label> 
							<input type="text" name="adresseClient" id="adresse_client" required />
							<br>
							<label for="phone_client">Num tel :</label> 
							<input pattern="[0-9]{10}" name="phoneClient" id="phone_client" required/>
							<br>
							<label for="mail_client">E-Mail :</label> 
							<input type="email" name="mailClient" id="mail_client" required />
							<br>
							<label for="diff_client">Différé :</label> 
							<input type="number" name="diffClient" id="diff_client" required />
							<br>
							<input type="submit" name="ajouterClientSubmit" value="Valider" />
						</fieldset>
						</form>
					</div>
				</div>';
	$contenu.= $notification;
	afficherVueAgent($_SESSION['username'], $contenu);
}