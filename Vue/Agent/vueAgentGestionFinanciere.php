<?php 

function afficherGestionFinanciere ($data='', $err_msg=''){
	$contenu = '<div class="elem">
				<h3>Gestion financière</h3>
				<form method="post">
					<label for="id_client">ID client :</label> 
					<input type="text" name="idClient" id="id_client" required />
					<input type="submit" name="idClientSubmit" value="Valider" />
				</form>
				</div>';
	$contenu.= $data;
	$contenu.= $err_msg;
	afficherVueAgent($_SESSION['username'], $contenu);
}

function afficherGestionFinanciereResultats($tab_interventions, $client_id, $diff_max_autorise, $diff_restant_autorise, $msg_error='', $err_msg_modifierdiff=''){
	$contenu='';
	$no_result=True;
	
	
	#affichage infos client
	$contenu.='<h2>'.$tab_interventions[0]->client_firstname.' '.$tab_interventions[0]->client_lastname.'</h2>
				<h4>date de naissance: ('.$tab_interventions[0]->client_birthday.')</h4>
				<h4>différé max autorisé: '.$diff_max_autorise.'€
				<form method="post">
					<input type="text" name="diffInput" id="diff_input" required />
					<input type="submit" name="modifierDiffere" value="Modifier" />
				</form></h4>
				<h4>différé restant autorisé: '.$diff_restant_autorise.'€</h4>'.$err_msg_modifierdiff.'';
				#var_dump($tab_interventions);
	
	$cpt_row=0;
	# check si le client a déja eu une intervention
	if(isset($tab_interventions[0]->interv_id))
		foreach ($tab_interventions as $row){
			if($row->interv_etatfacture!='P'){
				if($no_result){
					$contenu.='<form method="post"><fieldset>
							<legend>Interventions :</legend>
							<table>
							<tr>
								<th></th>
								<th>etat interv</th>
								<th>n°interv</th>
								<th>nom interv</th>
								<th>date interv</th>
								<th>prix interv</th>
							</tr>';
				}
				$contenu.='<tr>
							<td><input type="checkbox" id="boxInterv_'.$cpt_row.'" name="interv[]" value="'.$cpt_row.'"></td>
							<td>'.$row->etat_facture_value.'</td>
							<td>'.$row->interv_id.'</td>
							<td>'.$row->typeinterv_nom.'</td>
							<td>'.$row->interv_date.'</td>
							<td>'.$row->interv_tarif.'</td></tr>';
				if($no_result)
					$no_result=False;
			}
			$cpt_row++;
		}
	if($no_result)
		$contenu.='<p>Les paiement sont à jour.</p>';
	else{
		$contenu.='</table>
				</fieldset>'.$msg_error.'
				<p>
					<input type="submit" name="payerInterv" value="Payer"  />
					<input type="submit" name="differerInterv" value="Mettre en différer"  />
					<input type="hidden" name="idClientHidden" value='.$client_id.'  />
					<input type="hidden" name="diffAutoriseHidden" value='.$diff_restant_autorise.'  />
				</p>
				</form>';
	}
	afficherGestionFinanciere($contenu);
}
