<?php 

function afficherSyntheseClient ($data='', $err_msg=''){
	$contenu = '<div class="elem">
				<h3>Synthèse client</h3>
				<form method="post">
					<label for="id_client">ID client :</label> 
					<input type="text" name="idClient" id="id_client" required />
					<input type="submit" name="syntheseClientIdSubmit" value="Valider" />
				</form>
				</div>';
	$contenu.= $data;
	$contenu.= $err_msg;
	afficherVueAgent($_SESSION['username'], $contenu);
}

function afficherSyntheseClientResultats($tab_res, $client_id, $msg_error=''){
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
	# check si le client a déja eu une intervention
	if(isset($tab_interventions[0]->interv_id))
		foreach ($tab_res as $row){
			if($no_result){
				$contenu.='<form method="post"><fieldset>
						<legend>Interventions :</legend>
						<table>
						<tr>
							<th>etat interv</th>
							<th>n°interv</th>
							<th>nom interv</th>
							<th>date interv</th>
							<th>mecanicien</th>
							<th>prix interv</th>
						</tr>';
			}
			$contenu.='<tr>
						<td>'.$row->etat_facture_value.'</td>
						<td>'.$row->interv_id.'</td>
						<td>'.$row->typeinterv_nom.'</td>
						<td>'.$row->interv_date.'</td>
						<td>'.$row->empl_identifiant.'</td>
						<td>'.$row->interv_tarif.'</td></tr>';
			
			$no_result=False;
			
			$cpt_row++;
		}
	if($no_result)
		$contenu.='<p>Le client n\'est associé à aucune intervention.</p>';
	afficherSyntheseClient($contenu);
}