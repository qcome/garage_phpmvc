<?php

function afficherVueAgent ($username, $data=''){
	$titre = 'Agent'; 
	$contenu = '<form method="post">'.$username.'
					<input type="submit" name="logout" value="Logout"></input>
				</form>
				<div id="msgAccueil">Wesh Mr l\'agent, que désirez-vous faire?</div>
				<div class="elem">
					<form method="post">
						<input type="submit" name="gestionFinanciere" value="Gestion financière"  />
						<input type="submit" name="syntheseClient" value="Synthèse client"  />
						<input type="submit" name="gestionRdv" value="Gestion rdv"  />
						<br>
						<input type="submit" name="gotoAjouterClient" value="Ajouter client"  />
						<input type="submit" name="modifierClient" value="Modifier client"  />
						<input type="submit" name="gotoRetrouverClient" value="Retrouver client"  />
					</form>
				</div>';
	$contenu.= $data;
	require_once 'Vue/gabarit.php';
}