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
		$_SESSION['username']=$user;
		if ($res->empl_id == 1){
			afficherVueAgent($user);
		}else if ($res->empl_id == 2){
			require('Vue/vueMecanicien.php');
			$_SESSION['current_view'] = 'Vue/vueMecanicien.php';
		}else if ($res->empl_id == 3){
			require('Vue/vueDirecteur.php');
			$_SESSION['current_view'] = 'Vue/vueDirecteur.php';
		}
		return $res->empl_id;
	}
	catch(Exception $e){
		afficherVueAccueil(getDivErrorMsg($e->getMessage()));
	}
}

function CtlLogout(){
	session_destroy();
	afficherVueAccueil();
}

