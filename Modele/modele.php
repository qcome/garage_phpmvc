<?php

function getClient($id){
	$connexion=getConnect();
	$req="select * from client where client_id = 1";
	$res=$connexion->query($req); 
	$res->setFetchMode(PDO::FETCH_OBJ);
	while($result = $res->fetch()){
		echo $result->client_firstname;
	}
	$res->closeCursor();
}

function connexionEmployee($user, $pwd){
	$connexion=getConnect();
	$req="select c.cat_name, e.empl_id from employe e INNER JOIN categorie c ON 
			e.empl_catid = c.cat_id where e.empl_identifiant='".$user."' and e.empl_password='".$pwd."'";
	$res=$connexion->query($req); 
	$res->setFetchMode(PDO::FETCH_OBJ);
	$ligne=$res->fetch();
	
	$res->closeCursor();
	#si la requete n'a pas de ligne
	if ($ligne == false){
		throw new Exception("pseudo ou mdp incorrect");
	}
	else{
		return $ligne;
	}
	
}

function getConnect(){
	$connexion=new PDO('mysql:host=localhost;dbname=bd_garage',"root","");
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion;
}
