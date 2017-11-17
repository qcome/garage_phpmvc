<?php
session_start();
require('Modele/modele.php');

function CtlAccueil() {
	require 'Vue/vueAccueil.php';
	#sauvegarde de la page
	$_SESSION['current_view'] = 'Vue/vueAccueil.php';
}
function CtlLogin($user, $pwd) {
	$res=connexionEmployee($user, $pwd);
	$_SESSION['empl_id'] = $res->empl_id;
	$_SESSION['empl_cat'] = $res->cat_name;
	if ($_SESSION['empl_id'] == 1){
		require('Vue/vueAgent.php');
		$_SESSION['current_view'] = 'Vue/vueAgent.php';
	}else if ($_SESSION['empl_id'] == 2){
		require('Vue/vueMecanicien.php');
		$_SESSION['current_view'] = 'Vue/vueMecanicien.php';
	}else if ($_SESSION['empl_id'] == 3){
		require('Vue/vueDirecteur.php');
		$_SESSION['current_view'] = 'Vue/vueDirecteur.php';
	}
}

function CtlErreur($msg){
	$error = $msg;
	require($_SESSION['current_view']);
	#afficherErreur($msg);
}
