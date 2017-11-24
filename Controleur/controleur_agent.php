<?php
require_once('Vue/vueAgent.php');

function CtlGestionFinanciere(){
	afficherGestionFinanciere();
}

function CtlGestionFinanciereInterventions($client_id, $error_msg=''){
	# si l'utilisateur a bien entré un entier pour l'id
	if(ctype_digit($client_id))
		try{
			$result=getClientInterventions($client_id);
			# stockage des infos dans la variable _SESSION
			$_SESSION['idClient']=$client_id;
			$_SESSION['interventionsClient']=$result;
			$cpt_interv_diff=0;
			foreach ($result as $intervention){
				if($intervention->interv_etatfacture == 'DF')
					$cpt_interv_diff+=$intervention->interv_tarif;
			}
			$_SESSION['diffRestantAutorise']=($result[0]->client_maxdiff)-$cpt_interv_diff;
			# fin
			afficherGestionFinanciereResultats($result, $client_id, getDivErrorMsg($error_msg));
		}catch(Exception $e){
			afficherGestionFinanciere($err_msg=getDivErrorMsg($e->getMessage()));
		}
	else
		afficherGestionFinanciere($err_msg=getDivErrorMsg("L'id client doit etre un entier"));
}

function CtlGestionFinanciereInterventionsPaiment($tab_interventions_checked){
	try{
		$result=updatePaiementInterventions($_SESSION['idClient'], $_SESSION['interventionsClient'], $tab_interventions_checked);
		CtlGestionFinanciereInterventions($_SESSION['idClient']);
	}catch(Exception $e){
		afficherGestionFinanciere($err_msg=getDivErrorMsg($e->getMessage()));
	}
}

function CtlGestionFinanciereInterventionsDifferer($tab_interventions_checked){
	#var_dump ($_SESSION);
	try{
		# test s'il y a des checkbox DF de cochées
		$DF_checked = False;
		foreach($tab_interventions_checked as $intervention){
			if($_SESSION['interventionsClient'][$intervention]->interv_etatfacture == 'DF' )
				$DF_checked = True;
		}
		if ($DF_checked)
			throw new Exception("Impossible de différer un paiment déjà différé. Vérifiez votre sélection...");
		#t est si la mise en différé est autorisée
		$intervention_checked_total=0;
		foreach($tab_interventions_checked as $intervention){
			$intervention_checked_total+=$_SESSION['interventionsClient'][$intervention]->interv_tarif;
		}
		if($intervention_checked_total>$_SESSION['diffRestantAutorise'])
			throw new Exception("Mise en différé impossible, le plafond autorisé est dépassé....");
		# si tout est ok
		$result=updateDiffererInterventions($_SESSION['idClient'], $_SESSION['interventionsClient'], $tab_interventions_checked);
		CtlGestionFinanciereInterventions($client_id);
	}catch(Exception $e){
		CtlGestionFinanciereInterventions($_SESSION['idClient'], getDivErrorMsg($e->getMessage()));
	}
}

function getDivErrorMsg($msg_error){
	return '<div class="alert elem">'.$msg_error.'</div>';
}