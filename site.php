<?php
	require_once ('Controleur/controleur.php');
	require_once ('Controleur/controleur_agent.php');
	try{
		#page accueil
		if (isset($_POST['loginsubmit'])){
			$user=$_POST['user'];
			$pwd=$_POST['pwd'];
			$type_empl=CtlLogin($user, $pwd);
		} 
		#page agent
		elseif (isset($_POST['idClientSubmit'])){
			$client_id=$_POST['idClient'];
			CtlGestionFinanciereInterventions($client_id);
		}
		elseif(isset($_POST['payerInterv'])){
			if(isset($_POST['interv'])){
				$tab_selection_interv=$_POST['interv'];
				CtlGestionFinanciereInterventionsPaiment($tab_selection_interv);
			}else
				CtlGestionFinanciereInterventions($_SESSION['idClient'], 'Il n\'y a aucune checkbox de sélectionné.');
		}
		elseif(isset($_POST['differerInterv'])){
			if(isset($_POST['interv'])){
				$tab_selection_interv=$_POST['interv'];
				CtlGestionFinanciereInterventionsDifferer($tab_selection_interv);
			}else{
				CtlGestionFinanciereInterventions($_SESSION['idClient'], 'Il n\'y a aucune checkbox de sélectionné.');
			}
		}
		elseif(isset($_POST['gestionFinanciere'])){
			CtlGestionFinanciere();
		}
		else{
			#par défault affichage page accueil
			CtlAccueil();
		}
	}
	catch(Exception $e) {
		CtlErreur($e->getMessage());
	}
	
