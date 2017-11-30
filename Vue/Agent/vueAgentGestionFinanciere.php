<?php 

function afficherGestionFinanciere ($data='', $err_msg=''){
	$contenu = '<div class="elem">
				<h3>Gestion financière</h3>
				<form method="post">
					<label for="idClient">ID client :</label> 
					<input type="text" name="idClient" id="idClient" required />
					<input type="submit" name="idClientSubmit" value="Valider" />
				</form>
				</div>';
	$contenu.= $data;
	$contenu.= $err_msg;
	afficherVueAgent($_SESSION['username'], $contenu);
}

function afficherGestionFinanciereResultats($tab_res, $client_id, $msg_error=''){
	$contenu='';
	$no_result=True;
	
	$max_diff=intval($tab_res[0]->client_maxdiff);
	$diff_actuel=0;
	
	foreach ($tab_res as $row){
		if($row->interv_etatfacture=='DF')
			$diff_actuel+=intval($row->interv_tarif);
	}

	$diff_restant_autorise=$max_diff-$diff_actuel;
	
	#affichage infos client
	$contenu.='<h2>'.$tab_res[0]->client_firstname.' '.$tab_res[0]->client_lastname.'</h2>
				<h4>date de naissance: ('.$tab_res[0]->client_birthday.')</h4>
				<h4>différé max autorisé: '.$max_diff.'€</h4>
				<h4>différé restant autorisé: '.$diff_restant_autorise.'€</h4>';
				#var_dump($tab_res);
	
	$cpt_row=0;
	foreach ($tab_res as $row){
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

















