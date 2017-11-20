<?php 

function afficherVueAgent(){
	$titre = 'Agent'; 
	$contenu = getMainContenu();
	require_once 'gabarit.php';
}

function afficherGestionFinanciere($err_msg, $data){
	$titre = 'Agent'; 
	$contenu = getMainContenu();
	$contenu.='<div class="elem">
				<form method="post">
					<label for="idClient">ID client :</label> 
					<input type="text" name="idClient" id="idClient" required />
					<input type="submit" name="idClientSubmit" value="Valider" />
				</form>
				</div>';
	if ($err_msg != '')
		$contenu.='<div class="alert elem">'.$err_msg.'</div>';
	else
		$contenu.=$data;
	require_once 'gabarit.php';
}

function getMainContenu(){
	return '<div id="msgAccueil">Wesh Mr l\'agent, que désirez-vous faire?</div>
			<div class="elem">
				<form method="post">
					<input type="submit" name="gestionFinanciere" value="Gestion financière"  />
					<input type="submit" name="syntheseClient" value="Synthèse client"  />
					<input type="submit" name="gestionRdv" value="Gestion rdv"  />
				</form>
			</div>';
}

function afficherGestionFinanciereResultats($result, $client_id){
	$data='';
	$no_result=True;
	
	/* foreach ($result as $row){
		if($row->interv_etatfacture=='AP'){
			$data.='<p>Dernière intervention à regler:</p>';
			$data.='<p>'.$row->interv_id.$row->interv_tarif.$row->interv_etatfacture.'</p>';
			$data.='<p><form method="post">
					<input type="submit" name="payerDerniereInterv" value="Payer"  />
					<input type="submit" name="differerDerniereInterv" value="Mettre en différer"  />
					<input type="hidden" name="idClientHidden" value='.$client_id.'  />
				</form>
				</p>';
			$no_result=False;
		}
	} */

	#affiche infos client
	$data.='<h2>'.$result[0]->client_firstname.' '.$result[0]->client_lastname.'</h2>';
	
	foreach ($result as $row){
		if($row->interv_etatfacture!='P'){
			if($no_result){
				$data.='<form method="post"><fieldset>
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
			$data.='<tr>
						<td><input type="checkbox" id="boxInterv_'.$row->interv_id.'" name="interv[]" value="'.$row->interv_id.'"></td>
						<td>'.$row->interv_etatfacture.'</td>
						<td>'.$row->interv_id.'</td>
						<td>'.$row->typeinterv_nom.'</td>
						<td>'.$row->interv_date.'</td>
						<td>'.$row->interv_tarif.'</td>';
			$no_result=False;
		}
	}
	if($no_result)
		$data.='<p>Toute les interventions ont été payées.</p>';
	else{
		$data.='</table>
				</fieldset>
				<p>
					<input type="submit" name="payerDerniereInterv" value="Payer"  />
					<input type="submit" name="differerDerniereInterv" value="Mettre en différer"  />
					<input type="hidden" name="idClientHidden" value='.$client_id.'  />
				</p>
				</form>';
	}
	afficherGestionFinanciere('', $data);
}















