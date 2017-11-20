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
	$req="select c.cat_name, e.empl_id from employe e INNER JOIN categorie_employe c ON 
			e.empl_catid = c.cat_id where e.empl_identifiant='".$user."' and e.empl_password='".$pwd."'";
	$res=$connexion->query($req); 
	$res->setFetchMode(PDO::FETCH_OBJ);
	$ligne=$res->fetch();
	
	$res->closeCursor();
	#si la requete n'a pas de ligne
	if ($ligne == false)
		throw new Exception("login ou mdp incorrect");
	else
		return $ligne;
}

function getClientInterventions($id_client){
	$connexion=getConnect();
	$req="select * from client c INNER JOIN intervention i ON 
			c.client_id = i.interv_client INNER JOIN type_intervention t 
			ON i.interv_typeid = t.typeinterv_id WHERE c.client_id=".$id_client;
	$res=$connexion->query($req); 
	$res->setFetchMode(PDO::FETCH_OBJ);
	
	if ($result = $res->fetchAll()) {
		$res->closeCursor();
        return $result;
    }
	$res->closeCursor();
	throw new Exception("Client inconnu au bataillon");
}

function updatePaiementInterventions($id_client, $tab_idinterventions){
	$connexion=getConnect();
	$req="UPDATE intervention SET interv_etatfacture='P' WHERE interv_id IN (";
	foreach ($tab_idinterventions as $id_intervention){
		$req.= $id_intervention;
		if (next($tab_idinterventions)==true) 
			$req.= ",";
		else
			$req.=")";
	}
	$res=$connexion->query($req); 
	$res->closeCursor();
	return $res;
	
}

function getConnect(){
	$connexion=new PDO('mysql:host=localhost;dbname=bd_garage',"root","");
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion;
}


