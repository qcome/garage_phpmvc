<?php
require_once('Vue/Agent/vueAgent.php');
require_once('Vue/Agent/vueAgentGestionFinanciere.php');
require_once('Vue/Agent/vueAgentSyntheseClient.php');
require_once('Vue/Agent/vueAgentRetrouverClient.php');

/*************************************
******Partie GESTION FINANCIERE*******
*************************************/

function CtlGestionFinanciere(){
	afficherGestionFinanciere();
}

function CtlGestionFinanciereModifierDiffere($diff_input){
	if(ctype_digit($diff_input))
		//check si la valeur entrée est supérieure ou égale a la somme des interventions déjà en différé
		if($_SESSION['diffMaxAutorise']-$_SESSION['diffRestantAutorise'] <= $diff_input)
			try{
				updateDiffereMaxClient($_SESSION['idClient'], $diff_input);
				$_SESSION['diffMaxAutorise']=$diff_input;
				$cpt_interv_diff=0;
				foreach ($_SESSION['interventionsClient'] as $intervention){
					if($intervention->interv_etatfacture == 'DF')
						$cpt_interv_diff+=$intervention->interv_tarif;
				}
				$_SESSION['diffRestantAutorise']=$diff_input-$cpt_interv_diff;
				afficherGestionFinanciereResultats($_SESSION['interventionsClient'], $_SESSION['idClient'], $_SESSION['diffMaxAutorise'], $_SESSION['diffRestantAutorise']);
			}catch(Exception $e){
				afficherGestionFinanciere($err_msg=getDivErrorMsg($e->getMessage()));
			}
		else{
			$a = $_SESSION['diffMaxAutorise']-$_SESSION['diffRestantAutorise'];
			afficherGestionFinanciereResultats($_SESSION['interventionsClient'], $_SESSION['idClient'], $_SESSION['diffMaxAutorise'], $_SESSION['diffRestantAutorise'], '',
				$err_msg_modifierdiff=getDivErrorMsg('Modification impossible, l\'autorisation doit etre >= à '.$a.'€'));
		}
	else
		afficherGestionFinanciereResultats($_SESSION['interventionsClient'], $_SESSION['idClient'], $_SESSION['diffMaxAutorise'], $_SESSION['diffRestantAutorise'], '',
				$err_msg_modifierdiff=getDivErrorMsg('Vous devez entrer un entier.'));
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
			$_SESSION['diffMaxAutorise']=$result[0]->client_maxdiff;
			# fin
			afficherGestionFinanciereResultats($result, $client_id, $_SESSION['diffMaxAutorise'],$_SESSION['diffRestantAutorise'] , getDivErrorMsg($error_msg));
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
		# test si la mise en différé est autorisée
		$intervention_checked_total=0;
		foreach($tab_interventions_checked as $intervention){
			$intervention_checked_total+=$_SESSION['interventionsClient'][$intervention]->interv_tarif;
		}
		if($intervention_checked_total>$_SESSION['diffRestantAutorise'])
			throw new Exception("Mise en différé impossible, le plafond autorisé est dépassé....");
		# si tout est ok
		$result=updateDiffererInterventions($_SESSION['idClient'], $_SESSION['interventionsClient'], $tab_interventions_checked);
		CtlGestionFinanciereInterventions($_SESSION['idClient']);
	}catch(Exception $e){
		CtlGestionFinanciereInterventions($_SESSION['idClient'], getDivErrorMsg($e->getMessage()));
	}
}

/*************************************
********Partie SYNTHESE CLIENT********
*************************************/

function CtlSyntheseClient(){
	afficherSyntheseClient();
}

function CtlSyntheseClientInterventions($client_id, $error_msg=''){
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
			afficherSyntheseClientResultats($result, $client_id, getDivErrorMsg($error_msg));
		}catch(Exception $e){
			afficherSyntheseClient($err_msg=getDivErrorMsg($e->getMessage()));
		}
	else
		afficherSyntheseClient($err_msg=getDivErrorMsg("L'id client doit etre un entier"));
}

/*************************************
*******Partie RETROUVER CLIENT********
*************************************/

function CtlRetrouverClient(){
	afficherRetrouverClient();
}

function CtlRetrouverClientResultat($client_name, $client_birthday){
	try{
		$res=getClientId($client_name, $client_birthday);
		# si client trouvé
		if($res)
			afficherRetrouverClientResultat($res);
		else
			afficherRetrouverClient($err_msg=getDivErrorMsg("Client non trouvé."));
		
	}catch(Exception $e){
		afficherRetrouverClient($err_msg=getDivErrorMsg($e->getMessage()));
	}
	
}


function getDivErrorMsg($msg_error){
	return '<div class="alert elem">'.$msg_error.'</div>';
}