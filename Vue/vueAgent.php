<?php 

function afficherVueAgent(){
	$titre = 'Agent'; 
	$contenu = getMainContenu();
	require_once 'gabarit.php';
}

function afficherGestionFinanciere($data){
	$titre = 'Agent'; 
	$contenu = getMainContenu();
	$contenu.='<p>
				<form method="post">
					<label for="idClient">ID client :</label> 
					<input type="text" name="idClient" id="idClient" required />
					<input type="submit" name="idClientSubmit" value="Valider" />
				</form>
				</p>';
	if ($data != ''){
		$contenu.='<p class="alert">'.$data.'<p>';
	}
	require_once 'gabarit.php';
}

function getMainContenu(){
	return '<p>Wesh Mr l\'agent, que désirez-vous faire?</p>
				<p>
				<form method="post">
					<input type="submit" name="gestionFinanciere" value="Gestion financière"  />
					<input type="submit" name="syntheseClient" value="Synthèse client"  />
					<input type="submit" name="gestionRdv" value="Gestion rdv"  />
					</form>
				</p>
	
	';
}

function afficherGestionFinanciereResultats($result){
	$data='';
	$no_result=True;
	#var_dump ($result);
	
#	while ($row = $result->fetch()){
#		if($row->interv_etatfacture!='P'){
#			$data.='<p>'.$row->interv_id.$row->interv_tarif.$row->interv_etatfacture.'</p>';
#			
#		}
#	}
	foreach ($result as $row){
		if($row->interv_etatfacture!='P'){
			$data.='<p>'.$row->interv_id.$row->interv_tarif.$row->interv_etatfacture.'</p>';
			$no_result=False;
		}
	}
	if($no_result)
		$data.='<p>Toute les factures ont été payées</p>';
	afficherGestionFinanciere($data);
}
