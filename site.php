<?php
	require_once ('Controleur/controleurLogin.php');
	require_once ('Controleur/controleurAgent.php');
	try{
		#var_dump ($_SESSION);
		#page accueil
		if (isset($_POST['loginsubmit'])){
			$user=$_POST['user'];
			$pwd=$_POST['pwd'];
			$type_empl=CtlLogin($user, $pwd);
		} 
	#####page agent#####
		#Gestion Financiere
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
		elseif(isset($_POST['modifierDiffere'])){
			$diff_input = $_POST['diffInput'];
			CtlGestionFinanciereModifierDiffere($diff_input);
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
		#Synthese Client
		elseif(isset($_POST['syntheseClient'])){
			CtlSyntheseClient();
		}
		elseif(isset($_POST['syntheseClientIdSubmit'])){
			$client_id=$_POST['idClient'];
			CtlSyntheseClientInterventions($client_id);
		}
		#Retrouver client
		elseif(isset($_POST['gotoRetrouverClient'])){
			CtlRetrouverClient();
		}
		elseif(isset($_POST['retrouverClientSubmit'])){
			$client_birthday=$_POST['birthdayClient'];
			$client_name=$_POST['nomClient'];
			CtlRetrouverClientResultat($client_name, $client_birthday);
		}
		
		elseif(isset($_POST['logout'])){
			CtlLogout();
		}
		else{
			#par défault affichage page accueil
			if (session_status() != PHP_SESSION_NONE)
				session_destroy();
			CtlAccueil();
		}
	}
	catch(Exception $e) {
		CtlErreur($e->getMessage());
	}
	