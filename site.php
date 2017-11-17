<?php
	require_once ('Controleur/controleur.php');
	try{
		if(isset($_POST['loginsubmit'])){
			$user=$_POST['user'];
			$pwd=$_POST['pwd'];
			CtlLogin($user, $pwd);
		}else{
			CtlAccueil();
		}
	}
	catch(Exception $e) {
		CtlErreur($e->getMessage());
		#echo $e->getMessage();
		#$msg = $e->getMessage();
		#CtlErreur($msg);
	}
	
