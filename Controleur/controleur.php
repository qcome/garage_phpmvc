<?php
session_start();
require_once('Modele/modele.php');
require_once('Vue/vueAccueil.php');

function CtlAccueil() {
	afficherVueAccueil();
}

function CtlLogin($user, $pwd) {
	try{
		$res=connexionEmployee($user, $pwd);
		if ($res->empl_id == 1){
			afficherVueAgent();
		}else if ($res->empl_id == 2){
			require('Vue/vueMecanicien.php');
			$_SESSION['current_view'] = 'Vue/vueMecanicien.php';
		}else if ($res->empl_id == 3){
			require('Vue/vueDirecteur.php');
			$_SESSION['current_view'] = 'Vue/vueDirecteur.php';
		}
	}
	catch(Exception $e){
		afficherVueAccueil(getDivErrorMsg($e->getMessage()));
	}
	return $res->empl_id;
}

