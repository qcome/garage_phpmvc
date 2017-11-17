<?php
session_start();
require_once('Modele/modele.php');
require_once('Vue/vueAgent.php');
require_once('Vue/vueAccueil.php');

function CtlAccueil() {
	afficherVueAccueil('');
	#sauvegarde de la page
	#$_SESSION['current_view'] = 'Vue/vueAccueil.php';
}

function CtlLogin($user, $pwd) {
	try{
		$res=connexionEmployee($user, $pwd);
		$_SESSION['empl_id'] = $res->empl_id;
		$_SESSION['empl_cat'] = $res->cat_name;
		if ($_SESSION['empl_id'] == 1){
			afficherVueAgent();
		}else if ($_SESSION['empl_id'] == 2){
			require('Vue/vueMecanicien.php');
			$_SESSION['current_view'] = 'Vue/vueMecanicien.php';
		}else if ($_SESSION['empl_id'] == 3){
			require('Vue/vueDirecteur.php');
			$_SESSION['current_view'] = 'Vue/vueDirecteur.php';
		}
	}
	catch(Exception $e){
		afficherVueAccueil($e->getMessage());
	}
	
}

function CtlErreur($msg){
	$error = $msg;
	
	require($_SESSION['current_view']);
	#afficherErreur($msg);
}

function CtlGestionFinanciere(){
	afficherGestionFinanciere('');
	#require($_SESSION['current_view']);
}

function CtlGestionFinanciereInterventions($client_id){
	#si l'utilisateur a bien entré un entier pour l'id
	if(ctype_digit($client_id))
		try{
			$result=getClientInterventions($client_id);
			afficherGestionFinanciereResultats($result);
		}catch(Exception $e){
			afficherGestionFinanciere($e->getMessage());
		}
	else
		afficherGestionFinanciere("L'id client doit etre un entier");
}